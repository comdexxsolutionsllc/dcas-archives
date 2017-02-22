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

/**
 * Cisco Networking Hardware
 * Main Class
 *
 * @version $Id$
 * @copyright 2010
 */



//*** Stops all unauthorized access to this file.
if(!defined("IN_ENGINE")) {
	die(include_once('../error_docs/contextInEngine.html'));
}


//*** Starts ciscoNetworkingObject class.
class ciscoNetworkingObject
{
	var $stringObject,
		$errorObject;

	public function __construct() {

	}

	private function connect($hostname, $port='22', $errno, $errstr, $timeout='120') {
		$fp = fsockopen($hostname, $port, $errno, $errstr, $timeout );
	}

	public function sendCommand() {

	}

	public function captureOutput() {

	}

	public function disconnect() {

	}

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