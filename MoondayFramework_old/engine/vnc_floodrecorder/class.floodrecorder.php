<?php

/**
* @package floodrecorder
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Class to record access to a script / submit request by client
* @uses
* @example
* @files
*/

class floodrecorder {
	
	/*
	 $dir Flood data directory
	 $ip IP Address
	 $interval Time interval
	 $maxaccess Max access per time
	 $blocktime How long the client has to wait when they're blocked
	 $handler Object Callback Handler
	*/
	var $dir = '';
	var $ip = '';
	var $interval = 10;
	var $maxaccess = 10;
	var $blocktime = 300;
	var $handler = array(
		'flood' => false ,
		'mkdir' => false ,
		'chmod' => false ,
		'writefile' => false ,
		'unlink' => false ,
		'readfile' => false ,
		'rmdir' => false ,
	);
	
	function floodrecorder($dir , $max = 10 , $interval = 10 , $ip = '') {
		if ($ip == '') $ip = $_SERVER['REMOTE_ADDR'];
		$this->dir = $dir;
		$this->ip = $ip;
		$this->interval = $interval;
		$this->maxaccess = $max;
	}
	
	function initalize() {
		if ($this->isBlock()) {
			$this->_flood();
			return false;
		}
		return $this->record();
	}
	
	function isBlock($index = null,$access=-1,$interval=-1,$time=-1) {
		if ($access == -1) $access = $this->maxaccess;
		if ($interval == -1) $interval = $this->interval;
		if ($time == -1) $time = $this->blocktime;
		
		$path = $this->_path($index);
		if (file_exists($path . "/block")) {
			//this ip has been blocked , let take a small check
      $time = $this->_readfile("$path/block");
      if (time() > $time) $this->_unlink("$path/block");
      else return true;
		}
		$block = false;
		if ($dh = opendir($path)) {
				$count = 0;
        while (($file = readdir($dh)) !== false) {
            if ($file == '.' || $file == '..') continue;
            if (is_numeric($file)) {
            	if ($file < (time() - $interval)) {
            		//old file , just delete it
            		$this->_unlink("$path/$file");
            		continue;
            	}
            	//access counter
            	$count++;
            }
        }
        closedir($dh);
        if ($count >= $access) {
        	$this->block($index , $time);
        	$block = true;
        }
    }
    return $block;
	}
	
	function record($index = null) {
		$path = $this->_path($index);
		return $this->_writefile($path . "/" . time());
	}
	
	function unblock($index = null) {
		$path = $this->_path($index) . "/block";
		if (!file_exists($path)) return false;
		return $this->_unlink($path);
	}
	
	function block($index = null ,$time = 0) {
		$time = intval($time);
		if ($time <= 0) $time = $this->blocktime;
		return $this->_writefile($this->_path($index) . "/block" , time() + $time);
	}
	
	function clean($ip = null) {
		if ($ip === true) {
			//global clean
			$dh = opendir($this->dir);
			$ip = array();
			while (($file = readdir($dh)) !== false) {
				if ($file == '..' || $file == '.') continue;
				$this->clean($file);
			}
			closedir($dh);
			return true;
			
		} else {
			if ($ip == null) $ip = $this->ip;
			$path = $this->dir . "/" . $ip;
			$empty = true;
			if (is_dir($path)) {
				if ($dh = opendir($path)) {
					while (($file = readdir($dh)) !== false) {
						if ($file == '..' || $file == '.') continue;
						if (is_dir("$path/$file")) {
							//clean index folder
							$index = $file;
							$dh2 = opendir("$path/$index");
							$sub_empty = true;
							while (($file = readdir($dh2)) !== false) {
								if ($file == '..' || $file == '.') continue;
								if (is_numeric($file)) {
									//clean sub access record
									if ($file > (time() - $this->interval)) $sub_empty = false;
									else $this->_unlink("$path/$index/$file");
								} else if ($file == 'block') {
									//clean sub block record
									$time = $this->_readfile("$path/$index/$file");
									if ($time > time()) $sub_empty = false;
									else $this->_unlink("$path/$index/$file");
								}
								if ($sub_empty) $this->_rmdir("$path/$index");
								else $empty = false;
							}
							closedir($dh2);
						} else if (is_numeric($file)) {
							//clean access record
							if ($file > (time() - $this->interval)) $empty = false;
							else $this->_unlink("$path/$file");
						} else if ($file == 'block') {
							//clean block record
							$time = $this->_readfile("$path/$file");
							if ($time > time()) $empty = false;
							else $this->_unlink("$path/$file");
						}
					}
					closedir($dh);
					if ($empty) return $this->_rmdir($path);
					return true;
    		}
			}
		}
	}
	
	function _path($index = null) {
		$path = $this->dir . "/$this->ip";
		if (!file_exists($path)) {
			//create ip folder
			if (!$this->_mkdir($path)) return false;
		}
		if ($index) {
			$path .= "/$index";
			if (!file_exists($path)) {
				//create index folder
				if (!$this->_mkdir($path)) return false;
			}
		}
		return $path;
	}
	function _flood() {
		if ($this->handler['flood']) return call_user_func($this->handler['flood']);
		die('Flood Detected !');
	}
	function _unlink($path) {
		if ($this->handler['unlink']) return call_user_func($this->handler['unlink'] , $path);
		return unlink($path);
	}
	function _readfile($path) {
		if ($this->handler['readfile']) return call_user_func($this->handler['readfile'] , $path);
		return implode('' , file($path));
	}
	function _writefile($path , $data = null) {
		if ($this->handler['writefile']) return call_user_func($this->handler['writefile'] , $path , $data);
		$f = fopen($path , "wb");
		if (!$f) return false;
		if (!($data === null)) fwrite($f , $data);
		fclose($f);
		return $this->_chmod($path);
	}
	function _chmod($path , $right = 0777) {
		if ($this->handler['chmod']) return call_user_func($this->handler['chmod'] , $path , $right);
		return chmod($path , $right);
	}
	function _mkdir($path) {
		if ($this->handler['mkdir']) return call_user_func($this->handler['mkdir'] , $path);
		if (mkdir($path)) {
			return $this->_chmod($path);
		}
		return false;
	}
	function _rmdir($path) {
		if ($this->handler['rmdir']) return call_user_func($this->handler['rmdir'] , $path);
		return rmdir($path);
	}
}



?>