<?php

/****************************************************************************************************
 *
 *    _____   _____       ___  ___   _____   _____  __    __ __    __  _____   _____   _____   _____
 *   /  ___| /  _  \     /   |/   | |  _  \ | ____| \ \  / / \ \  / / /  ___/ /  _  \ |  ___| |_   _|
 *   | |     | | | |    / /|   /| | | | | | | |__    \ \/ /   \ \/ /  | |___  | | | | | |__     | |
 *   | |     | | | |   / / |__/ | | | | | | |  __|    }  {     }  {   \___  \ | | | | |  __|    | |
 *   | |___  | |_| |  / /       | | | |_| | | |___   / /\ \   / /\ \   ___| | | |_| | | |       | |
 *   \_____| \_____/ /_/        |_| |_____/ |_____| /_/  \_\ /_/  \_\ /_____/ \_____/ |_|       |_|
 *
 * Copyright (c) Comdexx Software, LLC                                                  Version : 1.0
 ****************************************************************************************************/

//*** Stops all unauthorized access to this file.
if(!defined("IN_ENGINE")) {
    die(include_once('../error_docs/contextInEngine.html'));
}

//*** Starts dbObject class.
class dbObject
{
    var $configObject;
    var $dbConn;
    var $dbList;


    public function __get($var) {
        print "Attempted to retrieve $var and failed...\n";
    }

    public function __call($function, $args) {
        $args = implode(', ', $args);
        print "Call to $function() with args '$args' failed!\n";
    }

    /**
     * Connects to a MySQL server.
     *
     * @param $dbHost string - MySQL server.
     * @param $dbName string - Database name.
     * @param $dbUser string - Database username.
     * @param $dbPass string - Database password.
     * $@return bool
     */
    function connect($dbHost, $dbUser, $dbPass, $dbName)
    {
        $this->dbConn = mysql_connect($dbHost, $dbUser, $dbPass);
        $this->selectDB($dbName);
    }

    /**
     * Sends a SQL query to the MySQL server.
     *
     * @param $query string    - SQL query.
     * @param $returnArray int - Switches return array on and off.
     * $@return bool, string
     */

    function query($query, $returnArray=0)
    {
        $SQLq = mysql_query($query);
        if(!$SQLq) {
            $this->errorObject->displayError("MySQL Error", mysql_error());
            return(0);
        }
        else {
            return ($returnArray == 0) ? $SQLq : mysql_fetch_array($SQLq);
        }
    }

	function query_count($query, $returnVar){
		$result = mysql_query($query);
		while($SQLq = mysql_fetch_array($result)){ return $SQLq['COUNT('.$returnVar.')']; }
	}

    /**
     * Disconnects from MySQL server.
     *
     * $@return bool
     */
    function disconnect()
    {
        if(mysql_close($this->dbConn))
            return(1);
        else
            return(0);
    }

    function get_info($infotype)
    {
        switch($infotype) {
            case 'client': // Get MySQL client info
                return $returnArray = mysql_get_client_info();
            break;
            case 'host':  // Get MySQL host info
                return $returnArray = mysql_get_host_info();
            break;
            case 'proto':  // Get MySQL protocol info
                return $returnArray = mysql_get_proto_info();
            break;
            case 'server':  // Get MySQL server info
                return $returnArray = mysql_get_server_info();
            break;
            default:
                $this->errorObject->displayError("MySQL Get Info", "Invalid Info Type");
                return(0);
            break;
        }
    }

    function affected_rows($link=NULL)
    {
        return mysql_affected_rows($link);
    }

    function data_seek()
    {
        return(0);
    }

    function db_name($dbList)
    {
        return mysql_db_name();
    }

    function db_query()
    {
        return(0);
    }

    function error_number()
    {
        return mysql_errno();
    }

    function escape_string()
    {
        return(0);
    }

    function fetch_lengths()
    {
        return(0);
    }

    function field_flags()
    {
        return(0);
    }

    function field_length()
    {
        return(0);
    }

    function field_name()
    {
        return(0);
    }

    function field_seek()
    {
        return(0);
    }

    function field_table()
    {
        return(0);
    }

    function field_type()
    {
        return(0);
    }

    function free_result()
    {
        return(0);
    }

    function insert_id()
    {
        return(0);
    }

    function list_db()
    {
        return $this->dbList = mysql_list_dbs();
    }

    function list_fields()
    {
        return(0);
    }

    function list_tables()
    {
        return(0);
    }

    function num_fields()
    {
        return(0);
    }

    function num_rows()
    {
        return(0);
    }

    function system_status()
    {
        return(0);
    }

    function thread_id()
    {
        return(0);
    }

    function unbuffered_query($query, $returnArray=0)
    {
        $SQLq = mysql_unbuffered_query($query);
        if(!$SQLq) {
            $this->errorObject->displayError("MySQL Error", mysql_error());
            return(0);
        }
        else {
            return ($returnArray == 0) ? $SQLq : mysql_fetch_array($SQLq);
        }
    }

    private function selectDB($dbName)
    {
        return mysql_select_db($dbName);
    }

    function Load($intID) {}

    function LoadAll($objOptionalClauses = null) {}

    function CountAll() {}

    function Save($blnForceInsert = false, $blnForceUpdate = false) {}

    function Delete($intID) {}

    function DeleteAll() {}

    function Truncate() {}

    function __destruct() { }

}

?>