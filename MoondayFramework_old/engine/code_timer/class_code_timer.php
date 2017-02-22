<?php

/**
* @package code_time
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Class to time different parts of code.
* @uses
* @example
* @files
*/

class code_timer // this is class definition
{
	
	var $timer_start; // this var stores the start time
	var $timer_end;  // this var stores the end time
	var $timer_total; // this var stores the total time (end time - start time)
	
	function code_timer() 
	// class constructor. the timer is started 
	{
		$this->timer_start = microtime();
		return $this->timer_start;
	}
	
	function start()
	// start function is used to reset the timer
	{
		$this->timer_start = microtime();
		return $this->timer_start;		
	}
	
	function end()
	// end function is used to stop the timer
	{
		$this->timer_end = microtime();
		return $this->timer_end;
	}
	
	function total()
	// total function does the "math". it calculates total timer time (end - start)
	{
		$this->timer_total = $this->timer_end - $this->timer_start;
		return  $this->timer_total;
	}
	
	function display_total($txt = 'Total time: ', $br = 1)
	// this function displays the result.
	// if $br a <br> tag is printed. then $txt is printed and then the total timer time
	{
		if ($br)
		{
			print '<br>';
		}
		
		if ($decimals < 0)
		{
			$decimals = 2;
		}

		$total = number_format($this->timer_total, $decimals);
			
		print $txt.$total;
		
		return $total;
	}
	
	function end_and_display($txt = 'Total time: ', $br = 1, $decimals = 8)
	//this function stops the timer and displays the total timer time
	// for displaying is used the same idee from the display_total
	{
		$this->timer_end = microtime();
		$this->timer_total = $this->timer_end - $this->timer_start;
		
		if ($br)
		{
			print '<br>';
		}
		
		if ($decimals < 0)
		{
			$decimals = 2;
		}

		$total = number_format($this->timer_total, $decimals);
			
		print $txt.$total;
		
		return $total;
	}	
	
}
?>