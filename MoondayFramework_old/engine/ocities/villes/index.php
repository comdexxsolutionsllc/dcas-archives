<?php
ob_start ();
?>
<?phpxml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
	<link rel="stylesheet" type="text/css" href="css/maindoc.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
/**
*includes pour php5
*
*/

require_once 'php5/ocity.cls.php';
require_once 'php5/oajax.cls.php';
require_once 'php5/soundex2.cls.php';
require_once 'php5/phonex.cls.php';


/**
*includes pour php4
*
*/
/*
require_once 'php4/ocity.cls.php';
require_once 'php4/oajax.cls.php';
require_once 'php4/soundex2.cls.php';
require_once 'php4/phonex.cls.php';
*/

$soundex = new soundex2;
$phonex = new phonex;
$ville = new ocity ('data.dat', $soundex, $phonex);
$ajax = new oajax;

echo $ajax -> setHeader ();
echo $ajax -> buildAjax ();
echo $ajax -> search ();
echo $ajax -> setFooter ();

$sBuffer = ob_get_clean ();
$bCheck = $ville -> getSearch ();
ob_start ();
?>
</head>
	<body>
<input type="text" name="mySearch" id="mySearch" />
<input type="button" value="Search" title="Letters or numbers" onclick="search (''+document.getElementById('mySearch').value+'', 0, 0);" style="cursor:pointer;"/>
<input type="button" value="Soundex" title="Only letters !" onclick="search (''+document.getElementById('mySearch').value+'', 0, 1);" style="cursor:pointer;"/>
<input type="button" value="Phonex" title="Only letters !" onclick="search (''+document.getElementById('mySearch').value+'', 0, 2);" style="cursor:pointer;"/>

<div id="divContent">
</div>

</body>
</html>
<?php
$sBuffer .= ob_get_clean ();
if ($bCheck === false) {
	echo $sBuffer;
}
/**
* data2.dat file creation, with soundex and phonex codes (already done)
*
$sVilles = file_get_contents ('data.dat');
$aLines =explode ("\r", $sVilles);
echo '<pre>', print_r ($aLines), '</pre>';
foreach ($aLines as $clef => $line) {
	$nom = strtolower (trim (substr ($line, 0, strlen ($line) - 6)));
	if (!empty ($nom)) {
		$aCpVilles[$clef] = trim (substr ($line, -6));
		$aNomVilles[$clef] = $nom;
		$soundex -> build ($nom);
		$phonex -> build ($nom);
		$aSoundexVilles[$clef] = $soundex -> sString;
		$aPhonexVilles[$clef] = $phonex -> sString;
	}
}
$fp = fopen ('data2.dat', 'w');
foreach ($aCpVilles as $clef => $val) {
	fwrite ($fp, $val.';'.$aNomVilles[$clef].';'.$aSoundexVilles[$clef].';'.$aPhonexVilles[$clef]."\r\n");
}
fclose ($fp);
*/

?>