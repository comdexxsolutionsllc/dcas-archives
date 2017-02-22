<?php 
/**
* @package CYahooStatus
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Yahoo screen-name Status
* @uses
* @example
* @files
*/

define ("YAHOO_ONLINE", 1);
define ("YAHOO_OFFLINE", 2);
define ("YAHOO_UNKNOWN", 3);

class CYahooStatus
{
	function execute ($yahoo = "", &$errno, &$errstr)
	{
		$errno = 0;
		$errstr = "";
		$lines = @file ("http://opi.yahoo.com/online?u=" . $yahoo . "&m=t"); 
		if ($lines !== false) {
			$response = implode ("", $lines);
			if (strpos ($response, "NOT ONLINE") !== false) {
				return YAHOO_OFFLINE;
			} elseif (strpos ($response, "ONLINE") !== false) {
				return YAHOO_ONLINE;
			} else {
				return YAHOO_UNKNOWN;
			}
		} else {
			$errno = 1;
			$errstr = "Unable to connect to http://opi.yahoo.com";
			return false;
		}
	}
}
?>