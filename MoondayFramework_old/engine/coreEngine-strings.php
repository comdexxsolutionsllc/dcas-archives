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

//*** Starts stringObject class.
class stringObject
{


    public function __get($var) {
        print "Attempted to retrieve $var and failed...\n";
    }

    public function __call($function, $args) {
        $args = implode(', ', $args);
        print "Call to $function() with args '$args' failed!\n";
    }

	public function outputSpacers()
	{
		return "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
	}

    /**
     * Parse a given string.
     *
     * @param $type string   - What type of string parsing.
     * @param $string string - The string to parse.
     * @return $string string
     */
    function parseString($type, $string)
    {
        switch($type)
        {
            case "name":
                $string = "";
                break;
        }
    }

    /**
     * Checks if a string is empty.
     *
     * @param $string string - String to check.
     * @return bool
     */
    function is_empty($string)
    {
        if(is_int($string) && $string == 0) {
            return(1);
        } elseif(empty($string)) {
            return(1);
        } elseif(str_replace(" ", "", $string) == "") {
            return(1);
        } else {
            return(0);
        }
    }

     /**
     * Checks if a string is alphanumeric.
     *
     * @param $string string - String to check.
     * @return bool
     */
    function is_alphanum($string)
    {
        if(!ctype_alnum($string)) {
            return(1);
        } elseif(empty($string)) {
            return(1);
        } elseif(str_replace(" ", "", $string) == "") {
            return(1);
        } else {
            return(0);
        }
    }

     /**
     * Checks if a string is alphabetic.
     *
     * @param $string string - String to check.
     * @return bool
     */
    function is_alpha($string)
    {
        if(!ctype_alpha($string)) {
            return(1);
        } elseif(empty($string)) {
            return(1);
        } elseif(str_replace(" ", "", $string) == "") {
            return(1);
        } else {
            return(0);
        }
    }

     /**
     * Checks if a string is uppercase.
     *
     * @param $string string - String to check.
     * @return bool
     */
    function is_upper($string)
    {
        if(!ctype_upper($string)) {
            return(1);
        } elseif(empty($string)) {
            return(1);
        } elseif(str_replace(" ", "", $string) == "") {
            return(1);
        } else {
            return(0);
        }
    }

     /**
     * Checks if a string is lowercase.
     *
     * @param $string string - String to check.
     * @return bool
     */
    function is_lower($string)
    {
        if(!ctype_lowercase($string)) {
            return(1);
        } elseif(empty($string)) {
            return(1);
        } elseif(str_replace(" ", "", $string) == "") {
            return(1);
        } else {
            return(0);
        }
    }

    function __destruct() { }

}
?>