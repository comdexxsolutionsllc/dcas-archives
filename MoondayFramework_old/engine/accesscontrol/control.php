<?php
// Test Script

include("accessControl.class.php");

$auditor = new accessControl();
$auditor->resumeFiles();
$auditor->resumeGeneric(1);


?>