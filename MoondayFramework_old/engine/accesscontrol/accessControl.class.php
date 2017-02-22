<?php

/**
* @package accessControl
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc	        It is a simple class to implement an access
*               control, with log of had access files, user
*               agent and other string that the server can
*               get with the array $_SERVER
*               It also implements methods to analyse logs 
*               generated
* @uses 
* @example 
* @files
*/

class accessControl {

	var $file = 'logs.txt';		// @var file string			File when is loged the informations
	var $arr;					// @var arr  array			Information's array that contains data
	var $ignoreReload = TRUE;	// @var ignoreReload bool	ignore or not the reload of user agent

	//!--------------------------------------------------
	// @function	accessControl::accessControl
	// @desc		Class constructor
	//				this function verify if the param to
	//				ignore the user reload was informed 
	//				and if a log file exists.
	// @param		ignore bool		Ignore the agent reload
	// @access		public
	// @return		void
	//!--------------------------------------------------
	function accessControl($ignore = FALSE) {
		$this->ignoreReload = $ignore;
		if ( $this->ignoreReload == TRUE )
			session_start('ACCESS');
		if (! file_exists($this->file) ){
			$x = fopen($this->file, "w+");
			fclose($x);
		}
		$this->arr = file($this->file);
	}

	//!--------------------------------------------------
	// @function	accessControl::_processLog
	// @desc		Save the array's content to file 
	// @param		desc resource	Handler to save the file
	// @access		private
	// @return		void
	//!--------------------------------------------------
	function _processLog($desc) {
		for ( $i = 0; $i < sizeof($this->arr); $i++) {
			$newline = explode("\t",$this->arr[$i]);
			$tmp = trim($this->arr[$i]) . "\n";
			if($tmp)
				fputs($desc, $tmp);
		}
	}

	//!--------------------------------------------------
	// @function	accessControl::executeFiles
	// @desc		It registers in the log that the file
	//				was accessed whit the file name. If
	//				the file already accessed it increment
	//				a the number that indicates the number
	//				of accesses
	// @access		private
	// @return		void
	//!--------------------------------------------------
	function executeFiles() {
		$str = $_SERVER['REQUEST_URI'];
		$desc = fopen($this->file, "w+");
		foreach ($this->arr as $p=>$l) {
			if(strstr($l, $str)) {
				$newline = explode("\t",$l);
				if ($newline[2] == 0) {
					$i = trim($newline[1]);
					if ($this->ignoreReload == FALSE)
						$i++;
					$j = trim($newline[3]);
					$this->arr[$p] = $newline[0] . "\t" . $i . "\t0\t" . ++$j . "\n";
					$found = TRUE;
					break;
				}
			}
		}
		if (!$found)
			$this->arr[] = $str . "\t0\t0\t0\n";
		$this->_processLog($desc);
		fclose($desc);
	}

	//!--------------------------------------------------
	// @function	accessControl::executeGeneric
	// @desc		In the same way that executeFiles, it
	//				register a string that can be retorned
	//				by the $_SERVER variable when the user
	//				to access the file.
	// @param		var string		it informs which is the
	//				variable name to register to file
	// @param		ind integer		it informs the id which
	//				will be used to consult this variable
	// @access		private
	// @return		void
	//!--------------------------------------------------
	function executeGeneric($var, $ind) {
		$desc = fopen($this->file, "w+");
		$str = $_SERVER[$var];
		if (is_null($str)) {
			$this->_processLog($desc);
			return FALSE;
		}
		foreach ($this->arr as $p=>$l) {
			if(strstr($l, $str)) {
				$newline = explode("\t",$l);
				if ($newline[2] == $ind) {
					$i = trim($newline[1]);
					$this->arr[$p] = $newline[0] . "\t" . ++$i . "\t$ind\n";
					$found = TRUE;
					break;
				}
			}
		}
		if (!$found)
			$this->arr[] = $str . "\t0\t$ind\n";
		$this->_processLog($desc);
		fclose($desc);
	}

	//!--------------------------------------------------
	// @function	accessControl::resumeFiles
	// @desc		Make the information resume of files
	//				had been access
	//				If ignoreReload is set the "Amount" field
	//				will not be increase, but the "Total" field
	//				ever store all access
	// @access		private
	// @return		void
	//!--------------------------------------------------
	function resumeFiles() {
		foreach ($this->arr as $l) {
			$newline = explode("\t", $l);
			if ($newline[2] == 0) {
				$a[] = $l . "<br>" ;
			}
		}
		
		for ($i = 0 ; $i < sizeof($a) ; $i++) {
			$newline = explode("\t", $a[$i]);
			for ($j = 0 ; $j < sizeof($a); $j++) {
				$newlineatual = explode("\t", $a[$j]);
				if ($newline[1] > $newlineatual[1] ) {
					$aux = $a[$i];
					$a[$i] = $a[$j];
					$a[$j] = $aux;
				}
			}
		}
		echo "<table width='100%' border='0'>\n";
		echo "\t<tr>\n\t\t<td>File name</td>\n\t\t<td>Amount</td>\n\t\t<td>Total</td>\n\t</tr>\n";
		foreach ($a as $l) {
			$newline = explode("\t", $l);
			if ($newline[2] == 0) {
				echo "\t<tr>\n\t\t<td>";
				echo "<a href=\"http://" . $_SERVER['SERVER_NAME'] . $newline[0] . "\">";
				echo $newline[0] . "</a>";
				echo "</td>\n\t\t<td>";
				echo $newline[1];
				echo "</td>\n\t\t<td>";
				echo $newline[3];
				echo "</td>\n\t</tr>\n";
			}
		}
		echo "</table>\n";
	}

	//!--------------------------------------------------
	// @function	accessControl::resumeGeneric
	// @desc		Make the information resume of strings
	//				referent to id informed
	// @param		ind	integer		id to find the informations
	// @access		private
	// @return		void
	//!--------------------------------------------------
	function resumeGeneric($ind) {
		foreach ($this->arr as $l) {
			$newline = explode("\t", $l);
			if ($newline[2] == $ind) {
				$a[] = $l . "<br>" ;
			}
		}
		for ($i = 0 ; $i < sizeof($a) ; $i++) {
			$newline = explode("\t", $a[$i]);
			for ($j = 0 ; $j < sizeof($a); $j++) {
				$newlineatual = explode("\t", $a[$j]);
				if ($newline[1] > $newlineatual[1] ) {
					$aux = $a[$i];
					$a[$i] = $a[$j];
					$a[$j] = $aux;
				}
			}
		}
		echo "<table width='100%' border='0'>\n";
		echo "\t<tr>\n\t\t<td>Names</td>\n\t\t<td>Amount</td>\n\t</tr>\n";
		foreach ($a as $l) {
			$newline = explode("\t", $l);
			if ($newline[2] == $ind) {
				echo "\t<tr>\n\t\t<td>";
				echo $newline[0];
				echo "</td>\n\t\t<td>";
				echo $newline[1];
				echo "</td>\n\t</tr>\n";
			}
		}
		echo "</table>";
	}

}

?>