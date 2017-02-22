<?php
// Test for  hash
require_once("class_hash.inc.php");
require_once("biblio_www.inc.php");

$hash=www_get_param("hash","");
$item=www_get_param("item","");

// private data not to be known. Can be login / password for example. The same
$data_server="a private data from the server";
$data_site="a private string of the site";

echo "Here is the hash created: $hash<br>\n";
echo "Item to be verified: $item<br>\n";
echo "<br>\n";

$h=new hash($data_server,$data_site,5);

$res=$h->check_hash($hash,$item);
if ($res)
  echo "<font color=#0000FF>Check ok!</a><br>\n";
else
  echo "<font color=#FF0000>Check not ok!<br></a>\n";
echo "<br>\n";
echo "<a href=hash_check.php?hash=$hash&item=$item>Refresh</a><br>\n";
echo "<a href=hash_start.php>back</a><br>\n";
?>