<?php


$host = 'localhost';
$username = 'framework';
$password = 'TUWsNeb3yS6nc7hZ';
$database = 'paragonpanel';

$link = mysql_connect($host, $username, $password);
if(!$link) { die(mysql_errno().mysql_error()); }
?>
