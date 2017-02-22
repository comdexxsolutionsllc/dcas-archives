<?php
// Test Script

include("accessControl.class.php");

$auditor = new accessControl();
$auditor->executeFiles();
$auditor->executeGeneric('HTTP_USER_AGENT', 1);

echo date("Y-m-d");
echo "<br>This is a simple page to access ";

?>