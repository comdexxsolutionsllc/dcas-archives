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

//*** Retrieves the page var from the URL query string.
if (!isset($page)) { $page = @$_GET['page']; } else { return (0); }

//if (!isset($_GET['page'])) { $page = 'home'; } else { return(1);}

//iinclude("admin/content/message.php");
if(@$_SESSION['loggedin'] == true)
{
	//*** Includes "Header" files
	include('admin/content/header-mainpanel.php'); // header
	echo "\n";
	include('admin/content/topbanner-mainpanel.php'); // Top Panel
	echo "\n";
	include('admin/content/userinfo-mainpanel.php'); // User Info Panel
	echo "\n";
	include('admin/content/ticketstatus-mainpanel.php'); // Ticket Status Panel
	echo "\n";
	include('admin/content/transactionstatus-mainpanel.php'); // Transaction Status Panel
	echo "\n";
	include('admin/content/commonlinks-mainpanel.php'); // Common Links Panel
	echo "\n";
	include('admin/content/breadcrumbs-mainpanel.php'); // Breadcrumbs Panel
	echo "\n";
	include('admin/content/links-mainpanel.php'); // Links Panel+
	echo "\n";
}

//*** Includes the correct content file based upon the page var.
switch($page)
{
    //*** Base Tabs.
    case "accounting_view":
        iinclude("admin/content/_accounting.php");
        break;
    case "hardware_view":
        iinclude("admin/content/_hardware.php");
        break;
    case "network_view":
        iinclude("admin/content/_network.php");
        break;
    case "sales_view":
        iinclude("admin/content/_sales.php");
        break;
    case "security_view":
        iinclude("admin/content/_security.php");
        break;
    case "services_view":
        iinclude("admin/content/_services.php");
        break;
    case "reports_view":
        iinclude("admin/content/_reports.php");
        break;
    case "management_view":
        iinclude("admin/content/_management.php");
        break;



	//*** Tickets
    case "ticket_search":
    	iinclude("admin/content/_ticket_search.php");
    	break;


    //*** Logout
    case "logout":
        #iinclude("admin/content/logout.php");
        $coreEngine->userObject->logout();
        break;

    //*** Main page.
    case "home":
        iinclude("admin/content/home.php");
	    break;

	//*** Admin:Lost Password page.
    case "admin-lostpassword":
    	iinclude("admin/content/admin-lostpassword.php");
    	break;

    //*** TEST page.
    case "test":
        iinclude("admin/content/test.php");
	    break;

    default:
        //iinclude('error_docs/not_found.html');
        break;
        exit;
}

//*** Includes "Footer" files
if(@$_SESSION['loggedin'] == true)
{
	echo "\n";
	include('admin/content/footer-mainpanel.php'); // footer
}

?>