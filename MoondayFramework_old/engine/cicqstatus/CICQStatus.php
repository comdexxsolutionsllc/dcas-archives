<?php 

/**
* @package CICQStatus
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc ICQ Screen-name Status
* @uses
* @example
* @files
*/

define ("ICQ_ONLINE", 1);
define ("ICQ_OFFLINE", 2);
define ("ICQ_WEBAWARE", 3);

class CICQStatus
{
	var $timeout = 20;
	
	function execute ($icq = "", &$errno, &$errstr)
	{
		$errno = ""; 
		$errstr = "";
		$raw_headers = "";

		$icq = trim ($icq);
		$host = "status.icq.com";
		$path = "/online.gif?icq=" . $icq;
		
		if (!function_exists ("fsockopen"))
		{
			$errno = "-1"; 
			$errstr = "Function fsockopen not founded!";
			return false;
		}
		else
		{
			$fp = fsockopen ($host, 80, $errno, $errstr, $this->timeout); 
			if (!$fp) 
			{ return false; } 
			else 
			{ 
				fputs ($fp,"GET " . $path . " HTTP/1.1\r\n"); 
				fputs ($fp,"HOST: " . $host . "\r\n"); 
				fputs ($fp,"User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)\r\n"); 
				fputs ($fp,"Connection: close\r\n\r\n"); 
			
				while (!feof ($fp)) 
				{ $raw_headers .= fgets ($fp, 128);  }
			} 
			fclose ($fp);
	
			$headers = array ();
			$tmp_headers = explode ("\n", $raw_headers);
			foreach ($tmp_headers as $header)
			{ 
				$tokens = explode (":", $header, 2);
				if (isset ($tokens[0]) && (trim($tokens[0]) != ""))
				{ 
					if (!isset ($tokens[1])) { $tokens[1] = ""; }
					$headers[] = array ($tokens[0] => trim($tokens[1])); 
				}
			}
			
			$location = "";
			foreach ($headers as $header)
			{ 
				if (isset ($header["Location"]))
				{ 
					$location = $header["Location"]; 
					break;
				}
			}
			
			$filename = basename ($location);
			switch ($filename) { 
				case "online0.gif": 
					return ICQ_OFFLINE;		
					break; 
				case "online1.gif": 
					return ICQ_ONLINE;
					break; 
				default: 
					return ICQ_WEBAWARE;
					break; 
			} 	
		}
	}
}
?>