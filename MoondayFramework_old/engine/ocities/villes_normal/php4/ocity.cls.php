<?php
class ocity {
	/**
	* private array aVilles : data array
	*/
	var $aVilles = array ();

	/**
	* public static string sResult : string used to store the result of the query
	*/
	var $sResult = '';

	/**
	* public static string sSearch : string used to store the query
	*/
	var $sSearch = '';

	/**
	* public function __construct
	* constructor
	* @Param string dataFile : data filename.
	*/
	function ocity ($dataFile = 'data.dat') {
		$sVilles = file_get_contents ($dataFile);
		$aLines =explode ("\r", $sVilles);
		$aLines = file ($dataFile);
		foreach ($aLines as $line) {
			$aWord = explode (';', $line);
			$this -> aVilles[$aWord[0]] = $aWord[1];
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

	/**
	* public function getSearch
	* returns the string result, called by the xmlhttp method
	* @Returns string sResult
	*/
	function getSearch () {
		if (isset ($_POST['data']) && '' !== trim ($_POST['data'])) {
			$this -> sSearch = strtolower ($_POST['data']);
			if ($this -> sSearch === '*') {
				$aTmp = $this -> aVilles;
				if (isset ($_POST['sort']) && in_array ($_POST['sort'], array ('0', '2'))) {
					asort ($aTmp);
				} else {
					ksort ($aTmp);
				}
			}
			elseif (is_numeric ($this -> sSearch)) {
				$aTmp = array_filter (array_flip ($this -> aVilles), array ($this, 'getFirst'));
				$aTmp = array_flip ($aTmp);
				if (isset ($_POST['sort']) && in_array ($_POST['sort'], array ('0', '1'))) {
					ksort ($aTmp);
				} else {
					asort ($aTmp);
				}
			} else {
				$aTmp = array_filter ($this -> aVilles, array ($this, 'getFirst'));
				if (isset ($_POST['sort']) && in_array ($_POST['sort'], array ('0', '2'))) {
					asort ($aTmp);
				} else {
					ksort ($aTmp);
				}
			}
			$iCpt = 0;
			$this -> sResult .= '<div style="border: 1px solid #000000;width: 250px;background-color: #ffffff;"><span title="Trier par code postal" onclick="search (\''.$this -> sSearch.'\',1);" style="cursor: pointer; margin: 5px;font-weight: bold;text-align: left;width: 100px;">Code </span><span title="Trier par ville" onclick="search (\''.$this -> sSearch.'\',2);" style="width: 150px;cursor: pointer; margin: 5px;font-weight: bold; text-align: right;">Ville</span></div>';
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