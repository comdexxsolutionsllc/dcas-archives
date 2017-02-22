<?php

/**
* @package im
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc	        Get AIM Screen-name Online Status
* @uses
* @example
* @files
*/


class im {
	function getaim($screenname) {
		$ch		= curl_init();
		$url	= "http://big.oscar.aol.com/$screenname?on_url=true&off_url=false";
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$result	= curl_exec($ch);
		curl_close($ch);

		if(eregi("true",$result)) {
			return true;
		} else {
			return false;
		}
	}
}

?>
