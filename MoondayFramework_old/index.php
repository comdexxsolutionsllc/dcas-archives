<?php

/****************************************************************************************************
 *
 *    _____   _____       ___  ___   _____   _____  __    __ __    __  _____   _____   _____   _____
 *   /  ___| /  _  \     /   |/   | |  _  \ | ____| \ \  / / \ \  / / /  ___/ /  _  \ |  ___| |_   _|
 *   | |     | | | |    / /|   /| | | | | | | |__    \ \/ /   \ \/ /  | |___  | | | | | |__     | |
 *   | |     | | | |   / / |__/ | | | | | | |  __|    }  {     }  {   \___  \ | | | | |  __|    | |
 *   | |___  | |_| |  / /       | | | |_| | | |___   / /\ \   / /\ \   ___| | | |_| | | |       | |
 *   \_____| \_____/ /_/        |_| |_____/ |_____| /_/  \_\ /_/  \_\ /_____/ \_____/ |_|       |_|
 *
 * Copyright (c) Comdexx Software, LLC                                                  Version : 1.0
 ****************************************************************************************************/
//*** Enables output buffering.
ob_start();

//*** Sets which PHP errors are reported.
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(-1);


$fs = stat($_SERVER["SCRIPT_FILENAME"]);


//header("Etag: ".sprintf('"%x-%x-%s"', $fs['ino'], $fs['size'],base_convert(str_pad($fs['mtime'],16,"0"),10,16)));
header("Accept-Ranges: bytes");
header("Accept-Encoding: gzip, deflate");
header('Pragma: public');
header("Expires: Wed, 01 Aug 1962 05:00:00 GMT");                  // Date in the past
header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');     // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0');    // HTTP/1.1
header("Pragma: no-cache, hack");
header("ExpiresActive: On");
header("Expires: 0");
header('Content-Transfer-Encoding: none');
header('X-Pingback: http://localhost/managedNOC/xmlrpc.php');

header('ComdexxSoft-Version: 1.0');								// Custom Header (Will Be Ignored By Browser)
																// : BUT -Will Respond- on Custom HTTP Built Framework
																// : to check for CURRENT VERSION of COMDEXX FRAMEWORK

//
//User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1.10) Gecko/20100504 Firefox/3.5.10 ( .NET CLR 3.5.30729)
//Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
//Accept-Language: en-us,en;q=0.5
//Accept-Encoding: gzip,deflate
//Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7
//Keep-Alive: 300
//Connection: keep-alive
//Cookie: session-id=06e1055751faec5bdec79ddcc7905554; PHPSESSID=tl71djm12jigtcvkbskhvhd5e3
//
//HTTP/1.1 200 OK
//Date: Fri, 09 Jul 2010 21:53:46 GMT
//Server: Apache/2.2.14 (Win32) DAV/2 mod_ssl/2.2.14 OpenSSL/0.9.8l mod_autoindex_color PHP/5.3.1 mod_apreq2-20090110/2.7.1 mod_perl/2.0.4 Perl/v5.10.1
//X-Powered-By: PHP/5.3.1
//Etag: "6de8a503dfe05ec8fce78bae826492dc"
//Accept-Ranges: bytes
//Pragma: no-cache
//Expires: Thu, 19 Nov 1981 08:52:00 GMT
//Last-Modified: Fri, 09 Jul 2010 21:53:46 GMT
//Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
//ExpiresActive: On
//Content-Transfer-Encoding: none
//Keep-Alive: timeout=5, max=100
//Connection: Keep-Alive
//Transfer-Encoding: chunked
//Content-Type: text/html
//


//*** Initialize session data.
session_start();

// true=1 false=0
//*** Requires ComdexxSoft core files.
require_once("engine/coreEngine.php");

if ( empty($_GET['user']) )
{
    require_once("client/inc/config.inc.php");
} elseif ( !( empty($_GET['user']) ) && ($_GET['user'] == 'admin') ) {
    require_once("admin/inc/config.inc.php");
} else {
    echo "";//die('Line 85: index.php');
}

if ($_SERVER['REQUEST_URI'] == "/managedNOC/") {
	header('location:/managedNOC/login/client/');
} else {
	// void
}

//*** include functions
function iinclude($file)
{
    if (@!include($file))
    {
    	//echo "Line [".__LINE__."] of iinclude()";
        iinclude("error_docs/not_found.html");
    } else {
        return(0);
    }
}

//*** Initialize coreEngine and it's components.
$coreEngine = new coreEngine;
$coreEngine->init();

// DEBUG: print "All declared classes are: "; foreach ( get_declared_classes() as $class ) { print $class."<br \>"; } print "\n";

## DEBUG
$coreEngine->firePHPObject->fb('Log message', FirePHP::LOG);
$coreEngine->firePHPObject->fb('Info message' ,FirePHP::INFO);
$coreEngine->firePHPObject->fb('Warn message' ,FirePHP::WARN);
$coreEngine->firePHPObject->fb('Error message',FirePHP::ERROR);
$coreEngine->firePHPObject->log('Hello');
$options = array('maxObjectDepth' => 10,
                 'maxArrayDepth' => 20,
                 'useNativeJsonEncode' => true,
                 'includeLineNumbers' => true);
$coreEngine->firePHPObject->fb('Trace Label', FirePHP::TRACE);

$coreEngine->firePHPObject->getOptions();
$coreEngine->firePHPObject->setOptions($options);

//*** Connects to MySQL server.
$coreEngine->dbObject->connect(configObject::$database_host, configObject::$database_user, configObject::$database_pass, configObject::$database);

//*** Checks if someone has submited there login information.
if(isset($_POST['username']) && isset($_POST['password'])) {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
	if(@$_GET['user'] == 'admin') {
		$_SESSION['usertype'] = $_GET['user'];
	} else {
		$_SESSION['usertype'] = 'client';
	}
    //*** Refreshes the current users page.
    header("Location:".$coreEngine->sRU."user.".$_SESSION['usertype']."/page/home/");
}

//*** Checks the user & pass stored in the users session against the database.
if(!$coreEngine->userObject->verifyUser(@$_SESSION['username'], @$_SESSION['password'])) {
    session_destroy();
    if ( empty($_GET['user']) )
    {
        iinclude("client/content/login.php");
    } elseif ( !( empty($_GET['user']) ) && ($_GET['user'] == 'admin') ) {
        //iinclude("admin/content/login.php");
        iinclude("admin/content/header-login.php");
        iinclude("admin/content/content-login.php");
        iinclude("admin/content/footer-login.php");
    } else {
        echo ""; //die('Line 154: index.php');
    }
    echo ""; //die('Line 156:  index.php');
} else {
	$_SESSION['loggedin'] = true;
}

if ( empty($_GET['user']) )
{
    $usertype = 'client';
} elseif ( !( empty($_GET['user']) ) && ($_GET['user'] == 'admin') ) {
    $usertype = 'admin';
} else {
    echo ""; //die('Line 165: index.php');
}

//print_r(get_headers('http://localhost/current_projects/paragonpanel/index.php?page=logout'));
?>
<?php // <!-- Session: --> ?>
<?php // print_r($_SESSION); ?>
<?php // <!-- <br \> --> ?>
<?php // <!-- Request: --> ?>
<?php // print_r($_REQUEST); ?>
<?php // <!-- <br \> --> ?>
<?php // <!-- Post: --> ?>
<?php // print_r($_POST); ?>
<?php // <!-- <br \> --> ?>
<?php // <!-- Get: --> ?>
<?php // print_r($_GET); ?>
<?php
// userObject Debug Block
/* Sample Output */
//<!-- Start userObject Debug Line -->
//	<Div name='Debug'>
//		UserID:      1</br>
//		UserLevelID: 1</br>
//	</Div>
//<!-- TERM: userObject Debug Line -->

/*
	echo "<!-- Start userObject Debug Line -->"."\n";
		echo "\t"."<Div name='Debug'>"."\n";
        echo "\t\t"."UserID:      ". $coreEngine->userObject->userid        ."</br>"."\n";
        echo "\t\t"."UserLevelID: ". $coreEngine->userObject->user_level_id ."</br>"."\n";
        echo "\t"."</Div>"."\n";
	echo "<!-- TERM: userObject Debug Line -->"."\n"; */
?>
            <?php
            if($_GET['user'] == "client")
            {
            	require("client/inc/content.inc.php");
            }elseif($_GET['user'] == "admin"){
            	require("admin/inc/content.inc.php");
            }else {
            	die('Line 202: index.php'); //require($_SESSION['usertype']."/inc/content.inc.php");
            }
            ?>
<?php
    //*** Disconnects from the MySQL server.
    $coreEngine->dbObject->disconnect();

    //*** Terminate coreEngine class
    //$coreEngine->terminate();
?>
