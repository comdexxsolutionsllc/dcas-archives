<?php
class ocity {
	/**
	* private array aNomVilles, aCpVilles, aSoundexVilles, aPhonexVilles : data arrays
	*/
	private $aNomVilles = array ();
	private $aCpVilles = array ();
	private $aSoundexVilles = array ();
	private $aPhonexVilles = array ();
	/**
	* public static string sResult : string used to store the result of the query
	*/
	private $sResult = '';

	/**
	* public static string sSearch : string used to store the query
	*/
	private static $sSearch = '';
	private static $_post = '';

	private $oSoundex;
	private $oPhonex;
	/**
	* public function __construct
	* constructor
	* @Param string dataFile : data filename.
	*/
	public function __construct ($dataFile = 'data.dat', $soundex, $phonex) {
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
	private static function getFirst ($val) {
		return (substr ($val, 0, strlen (self::$sSearch)) === self::$sSearch);
	}

	private static function mapLev ($val) {
		return levenshtein (self::$_post, $val);
	}

	/**
	* public function getSearch
	* returns the string result, called by the xmlhttp method
	* @Returns string sResult
	*/
	public function getSearch () {
		if (isset ($_POST['data']) && '' !== trim ($_POST['data'])) {
			self::$sSearch = strtolower ($_POST['data']);
			if ($_POST['type'] === '0') {
				if (self::$sSearch === '*') {
					$aTmp = array_combine ($this -> aCpVilles, $this -> aNomVilles);
					if (isset ($_POST['sort']) && in_array ($_POST['sort'], array ('0', '2'))) {
						ksort ($aTmp);
					} else {
						asort ($aTmp);
					}
				$aTmp = array_combine ($this -> aCpVilles, $this -> aNomVilles);
				}
				elseif (is_numeric (self::$sSearch)) {
					$aTmp = array_filter ($this -> aCpVilles, array ('self', 'getFirst'));
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
					$aTmp = array_filter ($this -> aNomVilles, array ('self', 'getFirst'));
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
				if (!is_numeric (self::$sSearch)) {
					$this -> oSoundex -> build (self::$sSearch);
					self::$sSearch = $this -> oSoundex -> sString;
					self::$_post = strtolower ($_POST['data']);
					$aDump = array_filter ($this -> aSoundexVilles, array ('self', 'getFirst'));
					$aVilles = array_intersect_key ($this -> aNomVilles, $aDump);
					if (isset ($_POST['sort']) && $_POST['sort'] === '2') {
						$aTmp = array_combine (array_intersect_key ($this -> aCpVilles, $aDump), $aVilles);
						asort ($aTmp);
					} elseif (isset ($_POST['sort']) && $_POST['sort'] === '1')  {
						$aTmp = array_combine (array_intersect_key ($this -> aCpVilles, $aDump), $aVilles);
						ksort ($aTmp);
					} else {
						$aLev = array_map (array ('self', 'mapLev'), $aVilles);
						if (!empty ($aLev) && !empty ($aVilles)) {
							array_multisort ($aLev, $aVilles);
							$aTmp = array_combine (array_intersect_key ($this -> aCpVilles, $aDump), $aVilles);
						} else {
							$aTmp = array ();
						}
					}
				} else {
					$aTmp = array ();
				}
			} else {
				if (!is_numeric (self::$sSearch)) {
					$this -> oPhonex -> build (self::$sSearch);
					self::$sSearch = $this -> oPhonex -> sString;
					self::$_post = strtolower ($_POST['data']);
					$aDump = array_filter ($this -> aPhonexVilles, array ('self', 'getFirst'));
					$aVilles = array_intersect_key ($this -> aNomVilles, $aDump);
					if (isset ($_POST['sort']) && $_POST['sort'] === '2') {
						$aTmp = array_combine (array_intersect_key ($this -> aCpVilles, $aDump), $aVilles);
						asort ($aTmp);
					} elseif (isset ($_POST['sort']) && $_POST['sort'] === '1')  {
						$aTmp = array_combine (array_intersect_key ($this -> aCpVilles, $aDump), $aVilles);
						ksort ($aTmp);
					} else {
						$aLev = array_map (array ('self', 'mapLev'), $aVilles);
						if (!empty ($aLev) && !empty ($aVilles)) {
							array_multisort ($aLev, $aVilles);
							$aTmp = array_combine (array_intersect_key ($this -> aCpVilles, $aDump), $aVilles);
						} else {
							$aTmp = array ();
						}
					}
				} else {
					$aTmp = array ();
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