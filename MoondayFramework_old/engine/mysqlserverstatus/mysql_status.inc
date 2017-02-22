<?php
/**
* @package MySQLServerStatus
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc MySQL Server Status class
* @uses
* @example
* @files
*/
	class MySQLServerStatus
	{
		var $new_value = '', $format = '';		

		function MySQLServerStatus()
		{
			// constructor
			// nothing to do here really
		}
		
		function GetServerStatus()
		{
			$query="show status";
			$result=mysql_query($query) or die(mysql_error());
			while($row=mysql_fetch_row($result))
			{
				// now put these values into an array
				$server_status[$row[0]]=$row[1];
			}
			return $server_status;
		}

		function TimeSpanFormat($seconds)
		{
			$days = floor($seconds / 86400);
			if ($days > 0)
			{
				$seconds -= $days * 86400;
			}
			$hours = floor($seconds / 3600);
			if ($days > 0 || $hours > 0)
			{
				$seconds -= $hours * 3600;
			}
			$minutes = floor($seconds / 60);
			if ($days > 0 || $hours > 0 || $minutes > 0)
			{
				$seconds -= $minutes * 60;
			}
			$formated_date['Days']=$days;
			$formated_date['Hours']=$hours;
			$formated_date['Minutes']=$minutes;
			$formated_date['Seconds']=$seconds;
	
			return $formated_date;
		}

		function FormatBytes($byte_value, $num_decimals)
		{
			
			// take the passed value and format it to
			// Terabyte, Gigabyte, Megabyte, or Kilobyte
			$tera=1000000000000;
			$giga=1000000000;
			$mega=1000000;
			$kilo=1000;
			if($byte_value>$tera)
			{
				$new_value=$byte_value/$tera;
				$format="TB";
			}
			else if($byte_value>$giga)
			{
				$new_value=$byte_value/$giga;
				$format="GB";
			}
			else if($byte_value>$mega)
			{
				$new_value=$byte_value/$mega;
				$format="MB";
			}
			else if(@$byte_value>$kilo)
			{
				$new_value=$byte_value/$kilo;
				$format="KB";
			}
			$formated_byte['value']=number_format($new_value, $num_decimals);
			$formated_byte['format']=$format;
			// return the new value and format
			return $formated_byte;
		}
		
	}
?>

