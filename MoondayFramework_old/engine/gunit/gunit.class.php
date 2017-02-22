<?php
/**
* @package GUnit
* @author Joshua Abbott, WiseGene Project (NKommunikation)
* @copyright (C) 2006 NKommunikation. All Rights Reserved.
* @desc Contains the Tester class from the GiMb framework.
* @uses
* @example
* @files
*/

/**
* GUnit class
*
* Tests all other classes from the GiMb framework to assure that they all work from build to build.<br />
* Example:
* <code>
* require_once 'alerter.class.php';
* require_once 'tester.class.php';
*
* class alerterTest extends GUnit {
* 	function testAlert(){
*		$o = new alerter;
*		$result = $o->setLogfile( 'e:\temp\log.txt' );
*		return ( $result == true ) ? true : false;
*	}
    
* 	function testStaticAlert() {
*		$result = alerter::Alert( ' error message ', false, 'log.txt' );
*		return ( $result == true ) ? true : false;
*	}
* }
*
* $o = new alerterTest;
* $o->runTests();
*</code>
*/
class GUnit {
 	/**
	* Script time execution function
	*/
	function microt(){
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	/**
	* Run all tests and draw a table with the results
	*
	* Runs all test* functions, defined in the [Unit]test class, gets their input and flushesh it if <br />
	* unexpected variable is returned. Generates a HTML page and draws a table with the results of the <br />
	* tests and error messages on failed tests.
	*
	* @return void	
	*/
	function runTests(){
	 	$c = get_class($this);
		$o = new $c;
		$s = 0;
	 	ob_start();
	 	$results = array();
    	$functions = get_class_methods( $o );
 		foreach ( $functions as $function )
 			if( strpos( $function, 'test' ) !== false ){
		 		$time_start = $this->microt();
 				$result = call_user_func( array( $o, $function) );
				$time_end = $this->microt();
				$r['time'] = substr( (string) ($time_end - $time_start), 0, 6 );
 				$r['function'] = $function;
 				$r['status'] = ( $result === true ) ? true : false;
 				$r['note'] = ( $result === true ) ? '' : ob_get_contents();
 				if( $result === true )
 					$s++;
 				$results[] = $r;
 				ob_clean();
	        }
	    ob_get_clean();
		$html = '
<html>
<head>
	<title>GiMb Unit Tester</title>
</head>
<body>
<font face="Times New Roman, Verdana">
<table width="450px" style="position: absolute; top: 50px; left: 50%; margin-left: -225px;" bgcolor="#A71821" border=0>
	<tr>
		<td align="center" colspan=4>
		<b><font color="#ffffff">
			Unit Testing - '.$c.'
		</font></b>
		</td>
	<tr>
		<td>
			<table rules="groups" align="center" width="100%" bgcolor="#FFFFFF">
				<tr>
					<td align="center">
						<b>
							No.
						</b>
					</td>
					<td align="center">
						<b>
							Function
						</b>
					</td>
					<td align="center">
						<b>
							Status
						</b>
					</td>
					<td align="center">
						<b>
							Time
						</b>
					</td>
					<td align="center">
						<b>
							Note
						</b>
					</td>
				</tr>
					';
	if ( !empty ( $results ) ) {
	 	$bgtd = '#EBEBEB';
	 	$i = 1;
	 	$cr = count( $results );
		foreach ( $results as $key ){
		$bgtd = ( $bgtd=='#FFFFFF' ) ? '#EBEBEB' : '#FFFFFF';
			$html .= '<tr bgcolor='.$bgtd.'>';
			$html .= '	<td align="center"> '.$i.' </td>';
			$html .= '	<td align="center"> '.$key['function'].' </td>';
			$html .= '	<td align="center" ><b>';
			$html .= ( $key['status'] == true ) ? '<font color = "#368F39">success</font>' : '<font color = "#A71821">failure</font>';
			$html .= '	</b><td align="center"> '.$key['time'].' </td>';
			$html .= '	</b><td align="center"> '.$key['note'].' </td>';
			$html .= '</tr>';
			$i++;
		}
	}
	else
		$html .= '	<tr>
						<td colspan=4 align="center">No tests performed</td>
					</tr>'; 

	$html .= '
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table align="center" width="100%" bgcolor="#FFFFFF">
				<tr>
					<td colspan=4 align="center">
						<b>
							'.$cr.' tests passed. '.$s.' of them were successful and '.($cr-$s).' failed.
						</b>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table align="center" width="100%" bgcolor="#FFFFFF">
				<tr>
					<td colspan=4 align="center" style="font-size: 12px">
							GiMb Unit Tester 2006 - author: Georgi Momchilov (gmomchilov at gmail dot com)
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</font>
</body>
</html>';
	echo $html;
    }
}
?>