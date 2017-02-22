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
//if(!defined("IN_ENGINE")) {
    //die(include_once('../error_docs/contextInEngine.html'));
//}

//*** Starts TimeClockObject class.
class TimeClockObject
{
        var $stringObject,
        $dbObject;

    public function __construct() {
        
    }
        
    public function __get($var) {
        print "Attempted to retrieve $var and failed...\n";
    }
    
    public function __call($function, $args) {
        $args = implode(', ', $args);
        print "Call to $function() with args '$args' failed!\n";
    }
	
    public function ClockIn() {
        
    }

    public function ClockOut() {
        
    }
    
    public function TakeBreak() {
        
    }
    
    public function TakeLunch() {
        
    }
    
    public function GetHoursWorked() {
        
    }
    
    public function GetWage() {
        
    }
    
    public function GetOverTime() {
        
    }
    
    public function GetTotal() {
        
    }
    
    public function PrintTimeCard() {
        
    }
    
    public function _FormatDate($date_format) {
        return date($date_format);
    }
    
    public function _FormatTime($time_format) {
        return strtotime($time_format);
    }
    
    
    function __destruct() { }
	
}


?>