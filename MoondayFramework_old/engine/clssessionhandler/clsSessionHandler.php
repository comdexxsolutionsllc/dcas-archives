<?php

/**
* @package SessionHandler
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Session Handler
* @uses
* @example
* @files
*/

class SessionHandler {

	var $SessionName = "SID";
	var $DomainName	= "";
	var $NoSessionPage;
	
	function SessionHandler($myDomain,$path,$failURL,$sName=""){

	    $this->DomainName=$myDomain;
	    if (!empty($sName)) $this->SessionName=$sName;
	    session_name($this->SessionName);
	    session_set_cookie_params(84600,$path,$myDomain,0);
	    $this->NoSessionPage=$failURL;
		
	}

	function NoSessions() {
	    $failURL=$this->NoSessionPage;
	    header("Location: $failURL");
	    die();
	}
	
	function Start() {
	    session_start();
	}

	function SetVariable($varname,$initval) {
	    $sname=$this->SessionName;
	    $_SESSION[$sname."_".$varname]=$initval;
	}
	
	function GetVariable($varname) {
	    $sname=$this->SessionName;
	    return $_SESSION[$sname."_".$varname];
	}
	
	function UnsetVariable($varname) {
	    $sname=$this->SessionName;
	    unset($_SESSION[$sname."_".$varname]);
	}

	function SavePath($newPath="") {
	    if (empty($newPath)) {
	    	return session_save_path();
	    } else {
		if (!file_exists($newPath)) {
		    mkdir($newPath);
		    chmod($newPath,777);
		} else {
		    if (!is_dir($newPath))
			return false;
		}
	    	session_save_path($newPath);
	    	return $newPath;
	    }
	}

	function Destroy() {
	    session_unset();
	    $_SESSION=array();
	    session_destroy();
	}
		
}

?>