<?php
require_once("../WSDLCreator.php");


$test = new WSDLCreator("MoondayFramework-Service", "http://localhost/managedNOC/service/wsdl");

$test->addFile("../../../engine/coreEngine.php");
//$test->addFile("../../../engine/coreEngine-accounting.php");
$test->addFile("../../../engine/coreEngine-config.php");
$test->addFile("../../../engine/coreEngine-database.php");
$test->addFile("../../../engine/coreEngine-errors.php");
$test->addFile("../../../engine/coreEngine-exception.php");
$test->addFile("../../../engine/coreEngine-filesystem.php");
$test->addFile("../../../engine/coreEngine-hardware-audits.php");
$test->addFile("../../../engine/coreEngine-hardware-find.php");
$test->addFile("../../../engine/coreEngine-hardware-inventory.php");
$test->addFile("../../../engine/coreEngine-hardware-leasemanagement.php");
$test->addFile("../../../engine/coreEngine-hardware-main.php");
$test->addFile("../../../engine/coreEngine-hardware-network.php");
$test->addFile("../../../engine/coreEngine-hardware-operations.php");
$test->addFile("../../../engine/coreEngine-hardware-reports.php");
$test->addFile("../../../engine/coreEngine-hardware-scanin.php");
$test->addFile("../../../engine/coreEngine-hardware-special.php");
$test->addFile("../../../engine/coreEngine-hardware-transactions.php");
$test->addFile("../../../engine/coreEngine-hardware.php");
$test->addFile("../../../engine/coreEngine-management-databaseadministration.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");
//$test->addFile("../../../engine/coreEngine-.php");


$test->setClassesGeneralURL("http://localhost/managedNOC/engine");

////$test->addURLToClass("example1", "http://protung.ro/examplewsdl");
$test->addURLToTypens("XMLCreator", "http://localhost/managedNOC/test/php2wsdl");

$test->ignoreMethod(array("example1_1"=>"getEx"));

$test->createWSDL();

$test->printWSDL(true); // print with headers
?>


<?php

//require_once("../WSDLCreator.php");
////header("Content-Type: application/xml");
//
//
//$test = new WSDLCreator("WSDLExample1", "http://www.yousite.com/wsdl");
////$test->includeMethodsDocumentation(false);
//
//$test->addFile("example_class.php");
//$test->addFile("example_class2.php");
//
//$test->setClassesGeneralURL("http://protung.ro");
//
//$test->addURLToClass("example1", "http://protung.ro/examplewsdl");
//$test->addURLToTypens("XMLCreator", "http://localhost/php2swdl");
//
//$test->ignoreMethod(array("example1_1"=>"getEx"));
//
//$test->createWSDL();
//
//$test->printWSDL(true); // print with headers
////print $test->getWSDL();
////$test->downloadWSDL();
////$test->saveWSDL(dirname(__FILE__)."/test.wsdl", false);



?>