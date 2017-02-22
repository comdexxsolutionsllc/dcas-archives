<?php
/**
* @package HASH
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Hash Class
* @uses
* @example
* @files
*/

require_once("parametres_base.inc.php");
require_once("biblio_mysql.inc.php");

$database_name="site";
$database_table="autorisations";

// SQL string to create the table
$sql_create="CREATE TABLE IF NOT EXISTS `$database_table` ("
								."`hash` varchar( 32 ) NOT NULL default '',"
								."`hash_item` varchar( 32 ) NOT NULL default '',"
								."`moment` bigint( 20 ) NOT NULL default '0',"
								."`nb_max_access` bigint( 20 ) NOT NULL default '-1',"
								."`max_timestamp` bigint( 20 ) NOT NULL default '-1',"
								."`timestamp_delete` bigint( 20 ) NOT NULL default '2592000',"
								."PRIMARY KEY ( `hash` )"
								.") TYPE = MYISAM ";

class hash {
	var $hash_data_server; // hash of the string data_server
	var $hash_data_site; // hash of the string data_website
	var $hash_ident_user; // hash of the session id
	var $max_duration; // max number of second of existence of a row
	function hash($data_server,$data_site,$max_duration=2592000) {
		global $database_name,$database_table;
		mysql_delete($database_name,$database_table,"`timestamp_delete`<".mktime()); // delete of ancient rows
		$this->hash_ident_user= md5(session_id());
		$this->hash_data_server=md5($data_server);
		$this->hash_data_site=md5($data_site);
		$this->max_duration=$max_duration;
	}
	
	function make_hash($items,$nb_max_access=1,$duration=-1) {
		global $database_name,$database_table;
		if (!is_array($items))
			$items=array($items); // transform items to an array if not
		for ($i=0;$i<count($items);$i++) {
			$moment=mktime();
			$hash_moment=md5($moment);
			$hash_item=md5($items[$i]);
			// hash is depending of:
			$hash[$i]=md5(	$this->hash_data_server // a private data from the server
										.	$this->hash_data_site		// a private data from the site
										.	$this->hash_ident_user	// a hash of uid
										.	$hash_item							// a hash of the item
										.	$hash_moment);					// a hash of the timestamp
			// 	store authorisation for:
			//	* this session
			//	* this hash
			//	* this moment
			//	* a number of access (or unlimited if equal to -1)
			//	* a certain duration	(or unlimited if equal to -1)
			if (mysql_select_value($database_name,"SELECT '".$hash[$i]."' FROM $database_table WHERE (hash='".$hash[$i]."')",-1)==-1)
				mysql_insert($database_name,$database_table,
											array('hash','hash_item','moment','nb_max_access','max_timestamp','timestamp_delete'),
											array($hash[$i],$hash_item,$moment,$nb_max_access,($duration==-1)?-1:($moment+$duration),$moment+$this->max_duration));
		}
		return $hash;
	}
	function check_hash($hash,$item) {
		global $database_name,$database_table;
		$data=mysql_rawquery($database_name,"SELECT * FROM $database_table WHERE (hash='$hash') LIMIT 0,1");
		if (count($data)==0) // no authorisation => false
			return false;
		else {
			$moment=mktime();
			$hash_item=md5($item);
			$nb_max_access=$data[0]['nb_max_access'];
			$max_timestamp=$data[0]['max_timestamp'];
			$hash_moment=md5($data[0]['moment']);
			$hash_temp=md5(		$this->hash_data_server
											.	$this->hash_data_site
											.	$this->hash_ident_user
											.	$hash_item
											.	$hash_moment);
			if (	($hash==$hash_temp)
					&&(		($max_timestamp==-1)
							||($moment<=$max_timestamp))
					) { // access = ok // don't have to verify nb_max_access because if line present, nb_max_access>=0
				if ($nb_max_access!=-1)
					if ($nb_max_access>1) // have to decrease nb_max_access in row
						mysql_update($database_name,$database_table,array('nb_max_access'),array($nb_max_access-1),"hash='$hash'");
					else // delete row because no other access will be accepted
						mysql_delete($database_name,$database_table,"hash='$hash'");
				return true; // and return ok
			}
			else
				if (	($hash==$hash_temp) // hash ok, but...
						&&($moment>$max_timestamp)) // it's too late
						mysql_delete($database_name,$database_table,"hash='$hash'"); // => delete row 
				return false; // hash is invalid or too late => return nok
		}
	}
}

?>