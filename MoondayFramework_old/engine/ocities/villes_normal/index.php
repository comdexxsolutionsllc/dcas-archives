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


/**
*includes pour php4
*
*/
/*
require_once 'php4/ocity.cls.php';
require_once 'php4/oajax.cls.php';
*/

$ville = new ocity ('../villes/data.dat');
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
<input type="button" value="Chercher" onclick="search (''+document.getElementById('mySearch').value+'', 0);" style="cursor:pointer;"/>

<div id="divContent">
</div>

</body>
</html>
<?php
$sBuffer .= ob_get_clean ();
if ($bCheck === false) {
	echo $sBuffer;
}
?>