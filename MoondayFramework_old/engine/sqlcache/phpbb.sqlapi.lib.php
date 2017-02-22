<?phpPHP
/**
* SQL API Extending Library
*/

if(!defined("DALAPIPATH")) trigger_error("You must specify correct PHPBB Db API path");

if( !@include_once( DALAPIPATH.SQLLAYER.'.php' ) ) trigger_error("Can not load ".DALAPIPATH.SQLLAYER.".php module", E_USER_ERROR);

/**
* SQLAPI Class. Needs Abstract DB Layers Library PHPBB DB Layers Package
* Extend DB API
* @package kernel
* @author $Author: Sheiko $ 
*/

define("CACHETABLESINFOCALL", true);
define("APPLYCACHE", true);

class sqlAPI extends sql_db {

	/**
	* Unified ID of DB Conection
	* @var string (may be interger)
	*/	
	var $dbConnectionID;

	/**
	* Class constructor
	* @param string $sqlserver server host
	* @param string $sqluser user name
	* @param string $sqlpassword user password
	* @param string $database base name
	* @param string $persistency persistent connection trigger 
	* @return object
	*/	
	function sqlAPI($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true) {
		$obj = $this->sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency);
		$this->dbConnectionID = $this->db_connect_id;
		return $obj;
	}
	/**
	 * Results array cleaning (slashes striping and entry duplicates deleting)
	 *
	 * @param array $results results array
	 * @return array
	 */	
	function cleanResults($results) {
			if($results) {
				foreach($results as $index=>$result){
					foreach($result as $key=>$val){
					if(is_int($key)) unset($results[$index][$key]);
					elseif( get_magic_quotes_gpc() ) $results[$index][$key]=stripslashes($result[$key]);
					}
				}
			}
		return $results;
	}
	/**
	 * Get fetches' listing from DB
	 *
	 * @param string $Query SQL query
	 * @param string $Trigger (may be APPLYCACHE or false). If $Trigger equals APPLYCACHE cache engine will be use
	 * @return array or error string
	 */		
	function getFetchListing($Query, $Trigger=false) { 
		$Query = trim($Query);
		if(!preg_match("/^SELECT\s/is", $Query)) trigger_error("This method may be used only in common with SELECT query", E_USER_ERROR);
		$results = CACHENOTFOUND;
		if($Trigger == APPLYCACHE) $results=$this->getCache($Query);
		if( $results == CACHENOTFOUND) {
			$r=$this->sql_query($Query);
			$Error = $this->sql_error($r);
				if($Error["code"]) return convert_cyr_string($Error["message"],'k','w');
			$results=$this->sql_fetchrowset($r);
			$this->sql_freeresult($r);
			$results = $this->cleanResults($results);
			if($Trigger == APPLYCACHE) $this->putCache($Query, $results);
		}
		return $results;
	} 		
	/**
	 * DB modifying 
	 *
	 * @param string $Query SQL query
	 * @param string $Trigger (may be CACHETABLESINFOCALL or false). $Trigger allows CACHETABLESINFOCALL value only for calls from sqlCache methods
	 * @return pointer
	 */	
	function modify($Query, $Trigger=false) {
		$Query = trim($Query);
		if(!preg_match("/^(INSERT|UPDATE|DELETE|CREATE)\s/is", $Query)) trigger_error("This method may be used only in common with INSERT/UPDATE/DELETE queries", E_USER_ERROR);
		if($Trigger!=CACHETABLESINFOCALL) $this->cleanCache($Query);
		return $this->sql_query($Query);
	}
	/**
	 * SQL query validation 
	 *
	 * @param string $Query SQL query
	 * @return integer (false or not false)
	 */		
	function checkQuery($Query) {
		$this->sql_query($Query);
		$Error = $this->sql_error();
		return $Error["code"];
	}
	
}

