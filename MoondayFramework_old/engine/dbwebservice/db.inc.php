<?php

	define ("MYSQL_HOST","localhost");
	define ("MYSQL_USER","");
	define ("MYSQL_PWD","");
	define ("MYSQL_DB","cyanenl");

	function db_connect() {
		global $dblink;

		if ($dblink = mysql_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PWD))
			mysql_select_db(MYSQL_DB);
		if ($e = mysql_error()) die ("connection error:".$e);
		return $dblink;
	}
	function db_disconnect($dblink) {
		global $dblink;
		mysql_close($dblink);
		$dblink=false;
	}
	function executeSql($sql) {
		global $insertedId, $dblink, $db_error;
		$db_persistent=true;
		if (!$dblink) {
			$dblink = db_connect();
			$db_persistent=false;
		}
		if (!$dblink) return -1;
		mysql_query ($sql);
		if ($db_error = mysql_error()) $result=-1;
		else {
			$insertedId=mysql_insert_id();
			$result=mysql_affected_rows();
		}
		if (!$db_persistent) {
			db_disconnect($dblink);
		}
		return $result;
	}
	function executeTransSql($trans) {
		global $dblink,$db_error;
		$db_error=false;
		$db_persistent=true;
		if (!$dblink) {
			$dblink = db_connect();
			$db_persistent=false;
		}
		if (!$dblink) return -1;
		$result=0;
		foreach($trans as $i=>$sql) {
			$result+=mysql_query ($sql);
			if ($db_error = mysql_error()) {
				$result=-1;
				break;
			}
		}
		if (!$db_persistent) {
			db_disconnect($dblink);
		}
		return $result;
	}
	function executeTableSql($sql) {
		global $dblink,$db_error;
		$db_persistent=true;
		if (!$dblink) {
			$dblink = db_connect();
			$db_persistent=false;
		}
		if (!$dblink) return -1;
		$result=mysql_query ($sql);
		if ($db_error = mysql_error()) $result=false;
		if (!$db_persistent) {
			db_disconnect($dblink);
		}
		return $result;
	}
	function getTableArray($sql,$indexfield=false) {
		$dataset=executeTableSql($sql);
		$result=array();
		if ($dataset) while ($line=mysql_fetch_assoc($dataset)) {
			if ($indexfield) 
				$result[$line[$indexfield]] = $line;
			else
				$result[] = $line;
		}
		return $result;
	}
	function getOneValue($sql,$field=false) {
		$d = executeTableSql($sql);
		if ($d) $line=mysql_fetch_assoc($d);
		if ($field && @$line[$field]) return $line[$field];
		return @current($line);
	}
	function getOneRow($sql) {
		$d = executeTableSql($sql);
		if ($d) return mysql_fetch_assoc($d);
		else return false;
	}
?>