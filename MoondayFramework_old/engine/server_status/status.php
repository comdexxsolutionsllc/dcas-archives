<?php

/**
* @package status
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc web-ouput server status
* @uses
* @example
* @files
*/

class status
	{
		var $all = array();
		var $log = FALSE;
		var $dbhost = 'localhost';
		var $dbuser = 'root';
		var $dbpass = '';
		var $dbname = 'server_status';
		var $uptime;
		var $downtime;
		
		# AddService adds a service to a multi-dimensional array
		function AddService($ip, $port, $service, $type)
		{
			$small_array = array('ip' => $ip, 'port' => $port, 'service' => $service, 'type' => $type, 'status' => '');
			array_push($this->all, $small_array);
			return $this->all;
		}

		# GetCount returns the number of services added
		function GetCount()
		{
			return count($this->all);
		}

		# CheckStatus checks the status
		function CheckStatus($timeout = 5)
		{
			$x = $this->GetCount();
			for($i = 0; $i <= $x - 1; $i++)
			{
				$ip = $this->all[$i]['ip'];
				$port = $this->all[$i]['port'];
				$service = $this->all[$i]['service'];
				if($this->all[$i]['type'] == 'tcp')
				{
					$fp = @fsockopen($ip, $port, $errno, $errstr, $timeout);
				}
				else
				{
					$fp = @fsockopen('udp://'.$ip, $errno, $errstr, $timeout);
				}

				if($fp)
				{
					fclose($fp);
					$this->all[$i]['status'] = TRUE;
					if($this->log)
					{
						$this->AddLog($this->all[$i]['ip'], $this->all[$i]['port'], $this->all[$i]['service'], $this->all[$i]['type'], 'TRUE');
						// $this->StatusUp(mysql_insert_id());
					}
				}
				else
				{
					$this->all[$i]['status'] = FALSE;
					if($this->log)
					{
						$this->AddLog($this->all[$i]['ip'], $this->all[$i]['port'], $this->all[$i]['service'], $this->all[$i]['type'], 'FALSE');
						// $this->StatusDown(mysql_insert_id());
					}
				}
			}
		}

		# GetStatus a unecessary function to return the status
		function GetStatus()
		{
			return $this->all;
		}

		# GetSingleStatus will get the status of single address
		function GetSingleStatus($ip, $port, $type, $timeout = 5)
		{
			if($type == 'tcp')
			{
				$fp = @fsockopen($ip, $port, $errno, $errstr, $timeout);
			}
			else
			{
				$fp = @fsockopen('udp://'.$ip, $port, $errno, $errstr, $timeout);
			}
			if($fp)
			{
				fclose($fp);
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}

		# DBConnect connects to the mysql database
		function DBConnect()
		{
			mysql_connect($this->dbhost, $this->dbuser, $this->dbpass) or trigger_error(mysql_error(), E_USER_ERROR);
			mysql_select_db($this->dbname) or trigger_error(mysql_error(), E_USER_ERROR);
		}

		# AddLog connects to the db and inserts a row of data
		function AddLog($ip, $port, $service, $type, $status)
		{
			$this->DBConnect();
			// Going to put query into a variable so it's editable.
			$query = "INSERT INTO server_status (
				status_ip, status_port, status_service, status_type, status_status)
				VALUES ('$ip', '$port', '$service', '$type', '$status')";
			mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
		}

		# StatusUp (MySQL)
		function StatusUp($id)
		{
			$this->DBConnect();
			$query = "INSERT INTO server_status_up (status_id) VALUES ($id)";
			mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
		}

		# StatusDown (MySQL)
		function StatusDown($id)
		{
			$this->DBConnect();
			$query = "INSERT INTO server_status_down (status_id) VALUES ($id)";
			mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
		}
	}
?>