<?php
/**
* @package sqlCache
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc SQL Cache class
* @uses
* @example
* @files
*/


define("CACHENOTFOUND", -1);
define("START", 1);
define("FINISH", 2);

class sqlCache extends sqlAPI {
	
	var $TraceInfo;
	var $StartTime;
	
	function sqlCache() {
		return $this;
	}

	function getCache($Query) {
		$results = array();
		if(!$Query OR !is_string($Query)) trigger_error("Invalid input query type", E_USER_ERROR);
		if(!defined("CACHEPATH")) trigger_error("CACHEPATH is undefined", E_USER_ERROR);
		$this->trace(START);
		$Query = trim($Query);
		$FileName = CACHEPATH.md5($Query);
		if(file_exists($FileName)) {
			$results = $this->readFile($FileName);
			$this->trace(FINISH, $Query);	
			return $results;
		} else return CACHENOTFOUND;
	}
	
	function putCache($Query, $data) {
		$Tables = array();
		if(!$Query OR !is_string($Query)) trigger_error("Invalid input query type", E_USER_ERROR);
		if($data AND !is_array($data) ) trigger_error("Invalid input data array type", E_USER_ERROR);
		if(!defined("CACHEPATH")) trigger_error("CACHEPATH is undefined", E_USER_ERROR);
		if(!$data) return false;
		
		$Query = trim($Query);
		if( !$Tables = $this->parseReadingQuery($Query) ) return false;
		$this->addCacheTablesInfo($Query, $Tables);
		
		$FileName = CACHEPATH.md5($Query);
		$this->writeFile($FileName, $data);
	
		return true;				
	}
	
	function parseReadingQuery($Query) {
		$TablesStr = "";
		$Tables = array();
		$Table = "";
		$Key = 0;
		// Syntax: SELECT * FROM table1 as A, table2 as B WHERE/LIMIT/ORDER/GROUP
		if(!preg_match("/^SELECT\s/is", $Query)) return false;
		if(preg_match("/(WHERE|LIMIT|ORDER|GROUP)/is", $Query)) {
			$TablesStr = preg_replace("/^.*\sFROM\s(.*?)(WHERE|LIMIT|ORDER|GROUP).*$/is", "\\1", $Query); 
		} else $TablesStr = preg_replace("/^.*\sFROM\s(.*?)$/is", "\\1", $Query); 
		
		$Tables = split(",", trim($TablesStr) );
		if($Tables) {
			foreach($Tables as $Key=>$Table) {
				$Tables[$Key] = preg_replace("/^(\w+)\s+?\w*?$/is", "\\1", trim($Table));
				$Tables[$Key] = str_replace("`","", $Tables[$Key]);
			}
		}
		return $Tables;
	}
	
	function parseModifyingQuery($Query) {
		
		$TablesStr = "";
		$Tables = array();
		$Table = "";
		$Key = 0;
		
		// Syntax: UPDATE table SET expression WHERE condition
		if(preg_match("/^UPDATE\s/is", $Query)) {
			if(preg_match("/(WHERE|SET)/is", $Query)) {
				$TablesStr = preg_replace("/^UPDATE\s(.*?)(WHERE|SET).*$/is", "\\1", $Query); 
			} else $TablesStr = preg_replace("/^UPDATE\s(.*?)$/is", "\\1", $Query); 
			$Tables = split(",", trim($TablesStr) );
			if($Tables) {
				foreach($Tables as $Key=>$Table) {
					$Tables[$Key] = preg_replace("/^(\w+)\s+?\w*?$/is", "\\1", trim($Table));
					$Tables[$Key] = str_replace("`","", $Tables[$Key]);
				}
			}
			return $Tables;
		}
		// Syntax: DELETE FROM table WHERE condition
		if(preg_match("/^DELETE\s/is", $Query)) {
			if(preg_match("/(WHERE|LIMIT)/is", $Query)) {
				$TablesStr = preg_replace("/^.*?\sFROM\s(.*?)(WHERE|LIMIT).*$/is", "\\1", $Query); 
			} else $TablesStr = preg_replace("/^.*?\sFROM\s(.*?)$/is", "\\1", $Query); 
			$Tables = split(",", trim($TablesStr) );
			if($Tables) {
				foreach($Tables as $Key=>$Table) {
					$Tables[$Key] = preg_replace("/^(\w+)\s+?\w*?$/is", "\\1", trim($Table));
					$Tables[$Key] = str_replace("`","", $Tables[$Key]);
				}
			}
			return $Tables;
		}		
	// Syntax: INSERT INTO table () VALUES()
		if(preg_match("/^INSERT\s/is", $Query)) {		
			$TablesStr = trim(preg_replace("/^.+INTO\s(.*?)\(.*$/is", "\\1", $Query)); 
			$TablesStr=str_replace("`","",$TablesStr);
			return array($TablesStr);
		}
		
	}	
	
	function addCacheTablesInfo($Query, $Tables) {
		$QueryKey ='';
		$QueryTable ='';
		if( $this->checkQuery("SELECT id, querykey, querytable FROM sqlcache LIMIT 0,1") ) {
			$CreationQuery = 'CREATE TABLE `sqlcache` (`id` INT NOT NULL AUTO_INCREMENT, `querykey` VARCHAR( 255 ) NOT NULL , `querytable` VARCHAR( 128 ) NOT NULL , PRIMARY KEY ( `id` ) )';
			$this->modify($CreationQuery, CACHETABLESINFOCALL);
			if( $this->checkQuery("SELECT id, querykey, querytable FROM sqlcache LIMIT 0,1") )  trigger_error("Can not create cache table 'sqlcache'", E_USER_ERROR);
		}
		
		$QueryKey = md5($Query);
		foreach($Tables as $QueryTable) {
			$this->modify("DELETE FROM `sqlcache` WHERE querykey='".$QueryKey."' AND querytable='".$QueryTable."'", CACHETABLESINFOCALL);
			$this->modify("INSERT INTO `sqlcache` ( `id` , `querykey` , `querytable` ) VALUES ('', '".$QueryKey."', '".$QueryTable."')", CACHETABLESINFOCALL);
		}
	}
	
	
	function writeFile($FileName, $data) {
		@unlink($FileName);
		if( $handle = @fopen ($FileName, "w")) {
				if (flock($handle, LOCK_EX)) {
				@fwrite ($handle, serialize($data)); 
				flock($handle, LOCK_UN); }
				@fclose ($handle); 
		} else trigger_error("Can not write into cache file ".basename($FileName), E_USER_ERROR);
	}
	
	function readFile($FileName) {
		$results = array();
		if( $handle = @fopen ($FileName, "r")) {
		$contents = @fread ($handle, filesize ($FileName)); 
		@fclose ($handle); } else trigger_error("Can not open cache file ".basename($FileName), E_USER_ERROR);
		if($contents) $results = unserialize($contents);
		return $results;
	}
	
	function cleanCache($Query=false) {
		// Clean all cache files and DB rows
		if(!$Query) {
		   if ($dh = opendir(CACHEPATH)) { 
		       while (($FileName = readdir($dh)) !== false) { 
		       		if($FileName!="." OR $FileName!="..") @unlink(CACHEPATH.$FileName);
		       } 
		       closedir($dh); 
		   }
		   	$this->modify("DELETE FROM sqlcache", CACHETABLESINFOCALL); 			
			return true;
		}
		// Clean the cache of certain query key
		
		$Table = "";
		$Key = 0;
		$Listing = array();
		$Row = array();
		$Tables = $this->parseModifyingQuery($Query);
		if(!$Tables) return false;
		foreach($Tables as $Key=>$Table) {$Tables[$Key]="'$Table'";}
		$Listing = $this->getFetchListing("SELECT querykey FROM sqlcache WHERE querytable in (".join(",", $Tables).")");
		if($Listing) {
			foreach($Listing as $Row) {
				@unlink(CACHEPATH.$Row["querykey"]);
			}
		}
		$this->modify("DELETE FROM sqlcache WHERE querytable in (".join(",", $Tables).")", CACHETABLESINFOCALL);
	}

	function trace($Trigger, $Query=false) {
		if($Trigger==START) {
			return $this->StartTime = $this->getmicrotime();		
		}
		if($Trigger==FINISH) {
			$this->TraceInfo[] = "Time: ".sprintf('%.4f', $this->getmicrotime() - $this->StartTime)." sec \t Query: ".$Query;
			return true;		
		}
	}
		
	function getmicrotime() { 
  		list($usec, $sec) = explode(" ",microtime()); 
   		return ((float)$usec + (float)$sec); 
	}

}