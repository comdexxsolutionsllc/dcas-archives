<?php

/**
* @package portscan
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Portscanner
* @uses
* @example
* @files
*/

class portscan {
	var $port,
	$host,
	$action,
	$result,
	$pname,
	$plist,
	$sresult,
	$hlist;
	function status() {
		$sc=socket_create (AF_INET, SOCK_STREAM, getprotobyname("TCP"));
		if (@socket_connect($sc,$this->host,$this->port)) {
			$this->result="open\n";
		}
		else {
			$this->result="closed\n";
		}
	}
	function name() {
		$fp=fopen('ports.txt','r');
		$temp=fread($fp,filesize('ports.txt'));
		fclose($fp);
		$temp=explode("\n",$temp);
		for($a=0;$a<sizeof($temp);$a++) {
			$temp2=explode("||",$temp[$a]);
			if ($this->port==$temp2[0]) {
					$this->pname=$temp2[1];
					$found==1;
			}
		}
		if ($found==NULL) {
			$this->pname=="NA";
		}
	}
	function scan($sfile) {
		if(is_file($sfile)) {
			$fp=fopen($sfile,'r');
			$file=$sfile;
		}
		else {
			$fp=fopen('ports.txt','r');
			$file='ports.txt';
		}
		$temp=fread($fp,filesize($file));
		fclose($fp);
		$temp=explode("\n",$temp);
		for($a=0;$a<sizeof($temp);$a++) {
			$temp2=explode("||",$temp[$a]);
			if($temp2[0]!=NULL) {
				$this->port=$temp2[0];
				$this->status();
				$this->name();
				$this->sresult[$a]=$this->port."||".$this->result."||".$this->pname;
			}
		}
	}

}
$scan=new portscan;
$scan->port=80;
$scan->host="singlehop.com";
$scan->status();
$scan->name();
print "PORT: ".$scan->port.": ".$scan->result." SERVICE: ".$scan->pname."\n";
$scan->scan(NULL);
print sizeof($scan->sresult)."\n";
for($a=0;$a<sizeof($scan->sresult);$a++) {
	print $scan->sresult[$a]."\n";
}
?>