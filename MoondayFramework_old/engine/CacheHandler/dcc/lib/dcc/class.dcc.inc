<?php
/////////////////////////////////////////////////////////////
//  DCC::QuickSite Pro.
//  Copiright (C) 2003, 2004, Gregory A. Rozanoff
//
//  This library is free software; you can redistribute it and/or
//  modify it under the terms of the GNU Lesser General Public
//  License as published by the Free Software Foundation; either
//  version 2.1 of the License, or (at your option) any later version.
//  This library is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
//  Lesser General Public License for more details.
//  You should have received a copy of the GNU Lesser General Public
//  License along with this library; if not, write to the Free Software
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
/////////////////////////////////////////////////////////////

class dcc extends db {

 var $TEMPLATES, $VALUES, $ARGS, $SELF;

 function module($args = '') {			// Constructor
	$this->start = $this->getmicrotime();
	$this->tm = time();
	$this->ARGS = &$args;

	$this->TemplateDir	= PATH."/templates";
	$this->CacheDir		= PATH."/cache";
	$this->LogDir		= PATH."/logs";
	$this->DataDir		= PATH."/data";

	$this->signature = md5($_SERVER['REQUEST_URI']);
	$this->path = $this->CacheDir."/".$this->signature.".cgi";
 }

 function _header() {				// Create HTTP header
	if ($this->fileMtime = $this->_init()) {
		header("HTTP/1.0 200 Ok");
		header("Status: 200 Ok");
		if (CACHE) {
			$this->last_modified = "Last-Modified: ".gmdate("D, M d Y H:i:s", $this->fileMtime)." GMT";
			$expire = "Expire: ".gmdate("D, M d Y H:i:s", $this->fileMtime + $this->expireTime)." GMT";
			header("Cache-Control: max-age=".$this->expireTime.", s-maxage=".$this->expireTime.", proxy-revalidate, must-revalidate");
		} else {
			$this->last_modified = "Last-Modified: ".gmdate("D, M d Y H:i:s", $this->tm)." GMT";
			$expire = "Expire: Sun, Mar 07 2004 00:10:00 GMT";
			header("Cache-Control: no-store, no-cache");
		}
		header($this->last_modified);
		header($expire);
	} else $this->error_404(implode("/", $this->ARGS));
 }

 function main() {
	$this->_header();
	$this->_flush();
	if (CACHE) $this->cached = $this->fetch();
	if (! $this->cached) {
		if (MYSQL) $this->connect();	// connect to MySQL
		$this->load_template($this->TEMPL ? $this->TEMPL : $this->SITE);
		$this->_execute();		// execute module
		if (MYSQL) $this->close();	// Close MySQL connection

		$this->assign($this->SITE);	// finalize
		if (CLEAR) $this->VALUES[$this->SITE] = preg_replace("/(>[\s\t\r\n]{2,})</i", "><", $this->VALUES[$this->SITE]);
		$this->VALUES[$this->SITE] = trim($this->VALUES[$this->SITE]);
	}
	if (LOGGING) $this->_log();		// logging
	if (CACHE && $this->CACHE) $this->add();
 }

 function done() {				// Destructor
	$this->stop = $this->getmicrotime();
	$uptime = round(($this->stop - $this->start) * 1000000) / 1000;
	$pc = $this->cached ? "Page retreived from cache: Success!" : "Page rendered: Ok!".
		"\n\tUsed ".count($this->TEMPLATES)." templates";
	$info = "\n<!--\n\tPage rendered in: ".$uptime." mC".
		"\n\t".$this->last_modified."\n\t".$pc."\n\t";
	if (GZIP) {
		if ($this->gzip_enabled()) {
			header('Content-Encoding: gzip');
			$this->VALUES[$this->SITE] = $this->VALUES[$this->SITE].$info."GZIP enabled.\n-->";
			$this->_gzip();
		} else {
			$this->VALUES[$this->SITE] = $this->VALUES[$this->SITE].$info."GZIP not supported.\n-->";
			echo $this->VALUES[$this->SITE];
		}
	} else {
		$this->VALUES[$this->SITE] = $this->VALUES[$this->SITE].$info."GZIP disabled\n-->";
		echo $this->VALUES[$this->SITE];
	}
	flush();
 }

 // Cache functions

 function add() {
	if (!file_exists($this->path) && empty($_POST)) {
		$fp = fopen($this->path, "w");
		if (FLOCKING) flock($fp, 2);
		fwrite($fp, $this->VALUES[$this->SITE]);
		if (FLOCKING) flock($fp, 3);
		fclose($fp);
	}
 }

 function fetch() {
	if (file_exists($this->path)) {
		if ($_SERVER['HTTP_CACHE_CONTROL'] != 'no-cache' && $_SERVER['HTTP_PRAGMA'] != 'no-cache' && empty($_POST)) {
			$this->VALUES[$this->SITE] = $this->summon($this->path);
			return TRUE;
		}
	}
	return FALSE;
 }

 function _flush() {		// Remove expired cache
	if (file_exists($this->path)) {
		$fmt = filemtime($this->path);
		if ($this->tm - $fmt > $this->expireTime || $fmt < $this->fileMtime) unlink($this->path);
	}
 }

 // Template functions

 function get_templates(&$html) {
	$rez = preg_match_all("/<tpl:([a-z0-9_-]+)>(.*)<\/tpl:\\1>/si", $html, $matches);
	for($i = 0; $i < $rez; $i++) {
		$this->TEMPLATES[$matches[1][$i]] = preg_replace(" /<tpl:([a-z0-9_-]+)>(.*)<\/tpl:\\1>/si", "<tpl:\\1 />", $matches[2][$i]);
		$this->get_templates($matches[2][$i]);
	}
 }

 function _wrap($tid) {
	$tmp = $this->TEMPLATES[$tid];
	$res = preg_match_all("/<tpl:([a-z0-9_-]+)([\s]+)\/>/si", $tmp, $matches);
	for ($i = 0; $i < $res; $i++)
		if (isset($this->VALUES[$matches[1][$i]])) $tmp = preg_replace("/<tpl:".$matches[1][$i]."([\s]+)\/>/s", $this->VALUES[$matches[1][$i]], $tmp);
			else $tmp = preg_replace("/<tpl:".$matches[1][$i]."([\s]+)\/>/s", $this->_wrap($matches[1][$i]), $tmp);
	return $tmp;
 }

 function assign($tid, $val = '') {
	if ("." == substr($tid, 0, 1)) {
		$tid = substr($tid, 1);
		$append = TRUE;
	}
	if (isset($this->TEMPLATES[$val]) && $val) $tmp = $this->_wrap($val);
		else $tmp = $val ? $val : $this->_wrap($tid);

	$this->VALUES[$tid] = $append ? $this->VALUES[$tid].$tmp : $tmp;
 }

 function wrap(&$arr) {			// Serialized wrapping
	 foreach ($arr as $key => $val) $this->assign ($key, $val);
 }

 function load_template($name) {
	$tmp = $this->summon($this->TemplateDir."/".$name.".tpl");
	for ($i = 0; $i < $this->depth; $i++) $this->prepare($tmp);
	$this->get_templates($tmp);
 }

 function purge($tid = "") {
	 if ($tid) unset($this->VALUES[$tid]);
		 else $this->VALUES = array();
 }

 function &get_options($from) {
	 $p = array();
	 $rez = preg_match_all("/([a-z0-9_-]+)(\s*\=\s*\"([^\"\>]*)\")?\s*/i", $from, $m);
	 for ($j = 0; $j < $rez; $j++) $p[$m[1][$j]] = $m[3][$j];
	 return $p;
 }

 function prepare(&$html) {
	 $res = preg_match_all("/<tpl:([a-z0-9_-]+)([^\>]*)\/>/si", $html, $matches);
	 for ($i = 0; $i < $res; $i++) {
		 $p = $this->get_options($matches[2][$i]);
		 switch ($matches[1][$i]) {
			 case 'include':	// include external template
				 if (!isset($p['used_by']) || $p['used_by'] == ME) {
					 $tpl = isset($p['self']) ? ME.".tpl" : $p['file'];
					 $temp = $this->summon($this->TemplateDir."/".$tpl);
				 } else $temp = "";
				 $html = preg_replace("#".preg_quote($matches[0][$i])."#i", $temp, $html);
				 break;
			 case 'timestamp':	// preset: time and date
				 $html = preg_replace("#".preg_quote($matches[0][$i])."#i", $this->formdate($this->tm), $html);
				 break;
			 case 'last_modified':	// preset: last modified stamp (GMT)
				 $html = preg_replace("#".preg_quote($matches[0][$i])."#i", $this->last_modified, $html);
				 break;
		 }
	 }
 }

 // Service functions

 function getmicrotime() {
	list($usec, $sec) = explode(" ",microtime());
	return ((float)$usec + (float)$sec);
 }

 function &summon($name) {
	 if (file_exists($name)) {
		$len = filesize($name);
		$fp = fopen($name, "r");
		if (FLOCKING) flock($fp, 1);
		$temp = fread($fp, $len);
		if (FLOCKING) flock($fp, 3);
		fclose($fp);
		return $temp;
	 } else return FALSE;
 }

 function get_ip() {				// Get user IP adress
	$ip1 = $_SERVER['REMOTE_ADDR'];
	$ip2 = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$result = ($ip2 != '' && ip2long($ip2) != -1) ? $ip2 : $ip1;
	return substr ($result, 0, 15);
 }

 function gzip_enabled() {
	$phpver = phpversion();
	$useragent = (isset($_SERVER["HTTP_USER_AGENT"]) ) ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_USER_AGENT;
	if ( $phpver >= '4.0.4pl1' && ( strstr($useragent,'compatible') || strstr($useragent,'Gecko')))
		if ( extension_loaded('zlib')) return TRUE;
	elseif ( $phpver > '4.0' )
		if ( strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip'))
			if ( extension_loaded('zlib')) return TRUE;
	return FALSE;
 }

 function _gzip() {
	$gzip_size = strlen($this->VALUES[$this->SITE]);
	$gzip_crc = crc32($this->VALUES[$this->SITE]);

	$this->VALUES[$this->SITE] = gzcompress($this->VALUES[$this->SITE], 9);
	$this->VALUES[$this->SITE] = substr($this->VALUES[$this->SITE], 0, strlen($this->VALUES[$this->SITE]) - 4);

	echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	echo $this->VALUES[$this->SITE];
	echo pack('V', $gzip_crc);
	echo pack('V', $gzip_size);
 }

 function _log() {
	$name = $this->LogDir."/".date("d-m-Y", $this->tm).".log";
	$time = gmdate("D, M d Y H:i:s", $this->tm)." GMT";
	$user_agent = $_SERVER["HTTP_USER_AGENT"] ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_USER_AGENT;
	$referrer = $_SERVER["HTTP_REFERER"] ? $_SERVER["HTTP_REFERER"] : $HTTP_REFERER;
	$referrer = $referrer ? $referrer : "-";
	$c = $this->cached ? "hit" : "out";

	$log = "[".$this->get_ip()."] [".$time."] [".$this->BaseURL.$_SERVER['REQUEST_URI']."] [".$referrer."] [".(string) $c."] [".$user_agent."]\n";

	$fp = fopen($name, "a");
	if (FLOCKING) flock($fp, 2);
	fwrite($fp, $log);
	if (FLOCKING) flock($fp, 3);
	fclose($fp);
 }

}

?>