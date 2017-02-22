<?php
function array_intersect_key($arr1, $arr2) {
   $res = array();
   foreach($arr1 as $key=>$value) {
       $push = true;
       for ($i = 1; $i < func_num_args(); $i++) {
           $actArray = func_get_arg($i);
           if (gettype($actArray) != 'array') return false;
           if (!array_key_exists($key, $actArray)) $push = false;
       }
       if ($push) $res[$key] = $arr1[$key];
   }
   return $res;
} 

function array_combine($a, $b) {
   $c = array();
   if (is_array($a) && is_array($b))
       while (list(, $va) = each($a))
           if (list(, $vb) = each($b))
               $c[$va] = $vb;
           else
               break 1;
   return $c;
}

class ocity {
	/**
	* private array aNomVilles, aCpVilles, aSoundexVilles, aPhonexVilles : data arrays
	*/
	var $aNomVilles = array ();
	var $aCpVilles = array ();
	var $aSoundexVilles = array ();
	var $aPhonexVilles = array ();
	/**
	* public static string sResult : string used to store the result of the query
	*/
	var $sResult = '';

	/**
	* public static string sSearch : string used to store the query
	*/
	var $sSearch = '';
	var $_post = '';

	var $oSoundex;
	var $oPhonex;
	/**
	* public function __construct
	* constructor
	* @Param string dataFile : data filename.
	*/
	function ocity ($dataFile = 'data.dat', $soundex, $phonex) {
		$this -> oSoundex = $soundex;
		$this -> oPhonex = $phonex;
		$aLines = file ($dataFile);
		foreach ($aLines as $line) {
			$aWord = explode (';', $line);
			$this -> aCpVilles[] = $aWord[0];
			$this -> aNomVilles[] = $aWord[1];
			$this -> aSoundexVilles[] = $aWord[2];
			$this -> aPhonexVilles[] = $aWord[3];
		}
	}

	/**
	* callback public static function getFirst
	* returns an array with the results of the query
	* @Returns array
	*/
	function getFirst ($val) {
		return (substr ($val, 0, strlen ($this -> sSearch)) === $this -> sSearch);
	}

	function mapLev ($val) {
		return levenshtein ($this -> _post, $val);
	}

	/**
	* public function getSearch
	* returns the string result, called by the xmlhttp method
	* @Returns string sResult
	*/
	function getSearch () {
		if (isset ($_POST['data']) && '' !== trim ($_POST['data'])) {
			$this -> sSearch = strtolower ($_POST['data']);
			if ($_POST['type'] === '0') {
				if ($this -> sSearch === '*') {
					$aTmp = array_combine ($this -> aCpVilles, $this -> aNomVilles);
					if (isset ($_POST['sort']) && in_array ($_POST['sort'], array ('0', '2'))) {
						ksort ($aTmp);
					} else {
						asort ($aTmp);
					}
				$aTmp = array_combine ($this -> aCpVilles, $this -> aNomVilles);
				}
				elseif (is_numeric ($this -> sSearch)) {
					$aTmp = array_filter ($this -> aCpVilles, array ($this, 'getFirst'));
					if (!empty ($aTmp)) {
						$aTmp = array_combine ($aTmp, array_intersect_key ($this -> aNomVilles, $aTmp));
						if (isset ($_POST['sort']) && in_array ($_POST['sort'], array ('0', '1'))) {
							ksort ($aTmp);
						} else {
							asort ($aTmp);
						}
					} else {
						$aTmp = array ();
					}
				} else {
					$aTmp = array_filter ($this -> aNomVilles, array ($this, 'getFirst'));
					if (!empty ($aTmp)) {
						$aTmp = array_combine (array_intersect_key ($this -> aCpVilles, $aTmp), $aTmp);
						if (isset ($_POST['sort']) && in_array ($_POST['sort'], array ('0', '2'))) {
							asort ($aTmp);
						} else {
							ksort ($aTmp);
						}
					} else {
						$aTmp = array ();
					}
				}
			} elseif ($_POST['type'] === '1') {
				if (!is_numeric ($this -> sSearch)) {
					$this -> oSoundex -> build ($this -> sSearch);
					$this -> sSearch = $this -> oSoundex -> sString;
					$this -> _post = strtolower ($_POST['data']);
					$aDump = array_filter ($this -> aSoundexVilles, array ($this, 'getFirst'));
					$aVilles = array_intersect_key ($this -> aNomVilles, $aDump);
					if (isset ($_POST['sort']) && $_POST['sort'] === '2') {
						$aTmp = array_combine (array_intersect_key ($this -> aCpVilles, $aDump), $aVilles);
						asort ($aTmp);
					} elseif (isset ($_POST['sort']) && $_POST['sort'] === '1')  {
						$aTmp = array_combine (array_intersect_key ($this -> aCpVilles, $aDump), $aVilles);
						ksort ($aTmp);
					} else {
						$aLev = array_map (array ($this, 'mapLev'), $aVilles);
						if (!empty ($aLev) && !empty ($aVilles)) {
							array_multisort ($aLev, $aVilles);
							$aTmp = array_combine (array_intersect_key ($this -> aCpVilles, $aDump), $aVilles);
						} else {
							$aTmp = array ();
						}
					}
				}
			} else {
				if (!is_numeric ($this -> sSearch)) {
					$this -> oPhonex -> build ($this -> sSearch);
					$this -> sSearch = $this -> oPhonex -> sString;
					$this -> _post = strtolower ($_POST['data']);
					$aDump = array_filter ($this -> aPhonexVilles, array ($this, 'getFirst'));
					$aVilles = array_intersect_key ($this -> aNomVilles, $aDump);
					if (isset ($_POST['sort']) && $_POST['sort'] === '2') {
						$aTmp = array_combine (array_intersect_key ($this -> aCpVilles, $aDump), $aVilles);
						asort ($aTmp);
					} elseif (isset ($_POST['sort']) && $_POST['sort'] === '1')  {
						$aTmp = array_combine (array_intersect_key ($this -> aCpVilles, $aDump), $aVilles);
						ksort ($aTmp);
					} else {
						$aLev = array_map (array ($this, 'mapLev'), $aVilles);
						if (!empty ($aLev) && !empty ($aVilles)) {
							array_multisort ($aLev, $aVilles);
							$aTmp = array_combine (array_intersect_key ($this -> aCpVilles, $aDump), $aVilles);
						} else {
							$aTmp = array ();
						}
					}
				}
			}
			$iCpt = 0;
			$this -> sResult .= '<div style="border: 1px solid #000000;width: 250px;background-color: #ffffff;"><span title="Trier par code postal" onclick="search (\''.$_POST['data'].'\',1, '.$_POST['type'].');" style="cursor: pointer; margin: 5px;font-weight: bold;text-align: left;width: 100px;">Code </span><span title="Trier par ville" onclick="search (\''.$_POST['data'].'\',2, '.$_POST['type'].');" style="width: 150px;cursor: pointer; margin: 5px;font-weight: bold; text-align: right;">Ville</span></div>';
			foreach ($aTmp as $cp => $ville) {
				$sColor = ($iCpt%2 === 0)?'background-color: #cccccc;':'background-color: #ffffff;';
				$this -> sResult .= '<div style="border: 1px solid #000000;width: 250px;'.$sColor.'"><span onclick="document.getElementById(\'mySearch\').value = this.innerHTML;" style="cursor: pointer; margin: 5px;'.$sColor.'">'.$cp.'</span><span onclick="document.getElementById(\'mySearch\').value = this.innerHTML;" style="cursor: pointer; margin: 5px;'.$sColor.'">'.$ville.'</span></div>';
				$iCpt ++;
			}
			echo $this -> sResult;
		} else {
			return false;
		}
	}
}
?>
