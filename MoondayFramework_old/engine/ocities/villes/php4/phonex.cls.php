<?php
/**
* CLASS phonex
* phonex, phonetics search algo
* based on the algorithm described here : http://sqlpro.developpez.com/cours/soundex/ by Fr�d�ric BROUARD
*
* author Johan Barbier <barbier_johan@hotmail.com>
*/
class phonex {

	/**
	* The public string we will work on
	*/
	var $sString = '';

	/**
	* private replacement array
	*/
	var $aReplaceGrp1 = array (
		'gan' => 'kan',
		'gam' => 'kam',
		'gain' => 'kain',
		'gaim' => 'kaim'
		);
	/**
	* private replacement array
	*/
	var $aReplaceGrp2 = array (
		'/(ain)([aeiou])/' => 'yn$2',
		'/(ein)([aeiou])/'=> 'yn$2',
		'/(aim)([aeiou])/' => 'yn$2',
		'/(eim)([aeiou])/'=> 'yn$2',
		);
	/**
	* private replacement array
	*/
	var $aReplaceGrp3 = array (
		'eau' => 'o',
		'oua' => '2',
		'ein' => '4',
		'ain' => '4',
		'eim' => '4',
		'aim' => '4'
		);
	/**
	* private replacement array
	*/
	var $aReplaceGrp4 = array (
		'�' => 'y',
		'�' => 'y',
		'�' => 'y',
		'ai' => 'y',
		'ei' => 'y',
		'er' => 'yr',
		'ess' => 'yss',
		'et' => 'yt'
		);
	/**
	* private replacement array
	*/
	var $aReplaceGrp5 = array (
		'/(an)($|[^aeiou1234])/' => '1$2',
		'/(am)($|[^aeiou1234])/' => '1$2',
		'/(en)($|[^aeiou1234])/' => '1$2',
		'/(em)($|[^aeiou1234])/' => '1$2',
		'/(in)($|[^aeiou1234])/' => '4$2'
		);
	/**
	* private replacement array
	*/
	var $aReplaceGrp6 = array (
		'on' => '1'
		);
	/**
	* private replacement array
	*/
	var $aReplaceGrp7 = array (
		'/([aeiou1234])(s)([aeiou1234])/' => '$1z$3'
		);
	/**
	* private replacement array
	*/
	var $aReplaceGrp8 = array (
		'oe' => 'e',
		'eu' => 'e',
		'au' => 'o',
		'oi' => '2',
		'oy' => '2',
		'ou' => '3'
		);
	/**
	* private replacement array
	*/
	var $aReplaceGrp9 = array (
		'ch' => '5',
		'sch' => '5',
		'sh' => '5',
		'ss' => 's',
		'sc' => 's'
		);
	/**
	* private replacement array
	*/
	var $aReplaceGrp10 = array (
		'/(c)([ei])/' => 's$2'
		);
	/**
	* private replacement array
	*/
	var $aReplaceGrp11 = array (
		'c' => 'k',
		'q' => 'k',
		'qu' => 'k',
		'gu' => 'k',
		'ga' => 'ka',
		'go' => 'ko',
		'gy' => 'ky'
		);
	/**
	* private replacement array
	*/
	var $aReplaceGrp12 = array (
		'a' => 'o',
		'd' => 't',
		'p' => 't',
		'j' => 'g',
		'b' => 'f',
		'v' => 'f',
		'm' => 'n'
		);
	/**
	* private replacement array
	*/
	var $aReplaceGrp13 = array (
			'1',
		 	'2',
		 	'3',
		 	'4',
		 	'5',
		 	'e',
		 	'f',
		 	'g',
		 	'h',
		 	'i',
		 	'k',
		 	'l',
		 	'n',
		 	'o',
		 	'r',
		 	's',
		 	't',
		 	'u',
		 	'w',
		 	'x',
		 	'y',
		 	'z'
		);
	/**
	* private replacement array
	*/
	var $aEnd = array (
		't',
		'x'
		);

	/**
	* public function build ()
	* main method, building the phonex code of a given string
	* @Param string sString : the string!
	*/
	function build ($sString) {
		if (is_string ($sString) && !empty ($sString)) {
			$this -> sString = $sString;
		} else {
			trigger_error ('Parameter string must not be empty', E_USER_ERROR);
		}
		$this -> sString = strtolower ($this -> sString);
		$this -> sString = str_replace (' ', '', $this -> sString);
		$this -> sString = str_replace ('y', 'i', $this -> sString);
		$this -> sString = preg_replace ('/(?<![csp])h/', '', $this -> sString);
		$this -> sString = str_replace ('ph', 'f', $this -> sString);
		$this -> aReplace ($this -> aReplaceGrp1);
		$this -> aReplace ($this -> aReplaceGrp2, true);
		$this -> aReplace ($this -> aReplaceGrp3);
		$this -> aReplace ($this -> aReplaceGrp4);
		$this -> aReplace ($this -> aReplaceGrp5, true);
		$this -> aReplace ($this -> aReplaceGrp6);
		$this -> aReplace ($this -> aReplaceGrp7, true);
		$this -> aReplace ($this -> aReplaceGrp8);
		$this -> aReplace ($this -> aReplaceGrp9);
		$this -> aReplace ($this -> aReplaceGrp10, true);
		$this -> aReplace ($this -> aReplaceGrp11);
		$this -> aReplace ($this -> aReplaceGrp12);
		$this -> sString = preg_replace( '/(.)\1/', '$1', $this -> sString );
		$this -> trimLast ();
		$this -> getNum ();
	}

	/**
	* private function aReplace ()
	* method used to replace letters, given an array
	* @Param array aTab : the replacement array to be used
	* @Param bool bPreg : is the array an array of regular expressions patterns : true => yes`| false => no
	*/
	function aReplace ($aTab, $bPreg = false) {
		if (false === $bPreg) {
			$this -> sString = str_replace (array_keys ($aTab), array_values ($aTab), $this -> sString);
		} else {
			$this -> sString = preg_replace (array_keys ($aTab), array_values ($aTab), $this -> sString);
		}
	}

	/**
	* private function trimLast ()
	* method to trim the bad endings
	*/
	function trimLast () {
		$length = strlen ($this -> sString) - 1;
		if (in_array ($this -> sString{$length}, $this -> aEnd)) {
			$this -> sString = substr ($this -> sString, 0, $length);
		}
	}

	/**
	* private static function mapNum ()
	* callback method to create the phonex numeric code, base 22
	* @Param int val : current value
	* @Param int clef : current key
	* @Returns int num : the calculated base 22 value
	*/
	 function mapNum ($val, $clef) {
		$num = array_search ($val, $this -> aReplaceGrp13);
		$num *= pow (22, - ($clef + 1));
		return $num;
	}

	/**
	* private function getNum ()
	* method to get a numeric array from the main string
	* we call the callback function mapNum and we sum all the values of the obtained array to get the final phonex code
	*/
	function getNum () {
		$aString = $chars = preg_split('//', $this -> sString, -1, PREG_SPLIT_NO_EMPTY);
		$aNum = array_map (array ($this, 'mapNum'), array_values ($aString), array_keys ($aString));
		$this -> sString = (string) array_sum ($aNum);
	}
}
?>
