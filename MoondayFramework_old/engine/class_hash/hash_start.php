<?php
// Test for hash
require_once("class_hash.inc.php");

echo "Creating hash...<br>\n";

// private data not to be known. Can be login / password for example
$data_server="a private data from the server";
$data_site="a private string of the site";

$h=new hash($data_server,$data_site);
$item="134"; // the id of an item, for example

// access characteristic
// example of an only once access to a ressource
$max_access=1; // -1 for infinity
$duration=-1; // -1 for infinity

//display characteristic
if ($max_access==-1)
  echo "Illimited number of access<br>\n";
else
  echo "$max_access access<br>\n";
if ($duration==-1)
  echo "Illimited time<br>\n";
else
  echo "$duration seconds of access<br>\n";

echo "<br>\n";
$hash=$h->make_hash($item,$max_access,$duration);
echo "Here is the hash created: ",$hash[0],"<br>\n";

echo "<a href=hash_check.php?item=$item&hash=",$hash[0],">page to be checked</a>\n";
?>