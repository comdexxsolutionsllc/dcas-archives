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


//*** Starts TimeObject class.
class timeObject
{
        public function __get($var) {
            print "Attempted to retrieve $var and failed...\n";
        }

        public function __call($function, $args) {
            $args = implode(', ', $args);
            print "Call to $function() with args '$args' failed!\n";
        }
        
        public function showDate() {
        	$lt = localtime();
        	
        	if ($lt[1] < 10) {
        		$lt[1] = (int) '0'.$lt[1];
        	} else {
        		$lt[1] = (int) $lt[1];
        	}
        	
        	echo(' '.($lt[4]+1).'/'.$lt[3].'/'.($lt[5]+1900).' '.$lt[2].':'.$lt[1]);
        }
        
        public function showTimeZone() {
        	echo date_default_timezone_get();
        }

        function __destruct() { }

}
?>