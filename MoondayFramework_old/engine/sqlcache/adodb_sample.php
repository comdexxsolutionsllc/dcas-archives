<?phpPHP
/**
* SQL Caching Sample (AdoDB Version)
*
* Install:
* Restore test.sql dump into your DB. Create /cache/ folder and set up 777 permission to it. 
* Copy into /adodb/ folder AdoDB files. 
*
*/
// Tracing function
function d($varDump=false) {?><pre style="font-size: 11px;  color: Maroon; font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;"><?phpprint_r($varDump)?></pre><?} 

define("SQLLAYER", "mysql");
define("DALAPIPATH", dirname(__FILE__)."/adodb/");
define("CACHEPATH", dirname(__FILE__)."/cache/");

$dbaccess = array(
				"server" => "localhost",
				"user" => "root",
				"pwd" => "",
				"db" => "test",
				);

require_once( dirname(__FILE__) .'/adodb.sqlapi.lib.php' );
require_once( dirname(__FILE__) .'/sqlcache.lib.php' );

// Initiate DB connection
$db = new sqlAPI($dbaccess["server"], $dbaccess["user"], $dbaccess["pwd"], $dbaccess["db"], false);
aggregate($db, "sqlCache");
if(!$db->dbConnectionID) trigger_error("Can not connect to DB", E_USER_ERROR);

// Apply group SQL query
$Query = "SELECT * FROM whois WHERE country_name LIKE 'B%' OR country_name LIKE 'U%' LIMIT 0,30";
$output = $db->getFetchListing($Query, APPLYCACHE); 
// Show query's results
d($output);
// Show trace information
d($db->TraceInfo);
?>