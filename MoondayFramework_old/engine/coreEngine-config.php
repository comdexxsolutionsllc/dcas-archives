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


//*** Starts configObject class.
class configObject
{
        var $stringObject,
        $errorObject;

        static public $title = '::managedNOC::Login::'; 	// Website Title
        static public $database = 'paragonpanel'; 			// Database Name
        static public $database_host = 'localhost'; 		// Database Host
        static public $database_user = 'framework'; 		// Database User
        static public $database_pass = 'TUWsNeb3yS6nc7hZ'; 	// Database Password
        static public $database_pref = 'mn001a_'; 			// Database Prefix (Leave blank)
        static public $database_type = 'mysql'; 			// mysql, postgres, mssql, sybase, oracle


        public function __get($var) {
            print "Attempted to retrieve $var and failed...\n";
        }

        public function __call($function, $args) {
            $args = implode(', ', $args);
            print "Call to $function() with args '$args' failed!\n";
        }

        function __destruct() { }

}

?>