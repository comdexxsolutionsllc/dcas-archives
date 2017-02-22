<?php error_reporting(-1);

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

//*** Retrives the page var from the URL query string.
//$page = $_GET['page'];
if (!isset($page)) { $page = $_GET['page']; } else { return (0); }

//*** include functions
//function iinclude($file)
//{
//    if (@!include($file))
//    {
//        iinclude("error_docs/not_found.html");
//    } else {
//        return(0);
//    }
//}

//*** Includes the correct content file based upon the page var.
switch($page)
{
    //*** Client management.
    case "add_client":
        iinclude("content/add_client.php");
        break;
    case "list_clients":
        iinclude("content/list_clients.php");
        break;
    case "manage_mailings":
        iinclude("content/manage_mailings.php");
        break;
    case "create_newsletter":
        iinclude("content/create_newsletter.php");
        break;
    case "create_maintenance_notice":
        iinclude("content/create_maintenance_notice.php");
        break;
    case "pending_signups":
        iinclude("content/pending_signups.php");
        break;
    case "signup_config":
        iinclude("content/signup_config.php");
        break;
    case "blocked_ips":
        iinclude("content/blocked_ips.php");
        break;

    //*** Billing management.
    case "add_package":
        iinclude("content/add_package.php");
        break;
    case "view_edit_packages":
        iinclude("content/view_edit_packages.php");
        break;
    case "manage_coupons":
        iinclude("content/manage_coupons.php");
        break;
    case "view_invoices":
        iinclude("content/view_invoices.php");
        break;
    case "process_due_invoices":
        iinclude("content/process_due_invoices.php");
        break;
    case "process_failed_invoices":
        iinclude("content/process_failed_invoices.php");
        break;

    //*** support management.
    case "new_tickets":
        iinclude("content/new_tickets.php");
        break;
    case "director_database":
        iinclude("content/director_database.php");
        break;
    case "claimed_tickets":
        iinclude("content/claimed_tickets.php");
        break;
    case "closed_tickets":
        iinclude("content/closed_tickets.php");
        break;
     case "manage_departments":
        iinclude("content/manage_departments.php");
        break;
   case "manage_categories":
        iinclude("content/manage_categories.php");
        break;
    case "manage_news":
        iinclude("content/manage_news.php");
        break;
    case "manage_knowledgebase":
        iinclude("content/manage_knowledgebase.php");
        break;

    //*** Server management.
    case "add_server":
        iinclude("content/add_server.php");
        break;
    case "servers_overview":
        iinclude("content/servers_overview.php");
        break;
    case "network_overview":
        iinclude("content/network_overview.php");
        break;
    case "manage_monitoring":
        iinclude("content/manage_monitoring.php");
        break;
    case "manage_backups":
        iinclude("content/manage_backups.php");
        break;
    case "system_health":
        iinclude("content/system_health.php");
        break;
    case "add_ips":
        iinclude("content/add_ips.php");
        break;
    case "manage_ips":
        iinclude("content/manage_ips.php");
        break;

    //*** Reports management.
    case "revenue_report":
        iinclude("content/revenue_report.php");
        break;
    case "support_report":
        iinclude("content/support_report.php");
        break;
    case "signups_report":
        iinclude("content/signups_report.php");
        break;
    case "cancellations_report":
        iinclude("content/cancellations_reportt.php");
        break;
    case "transactions_report":
        iinclude("content/transactions_report.php");
        break;
    case "clients_report":
        iinclude("content/clients_report.php");
        break;
    case "accounts_report":
        iinclude("content/accounts_report.php");
        break;
    case "packages_report":
        iinclude("content/packages_report.php");
        break;

    //*** Advanced management.
    case "manage_projects":
        iinclude("content/manage_projects.php");
        break;
    case "marketing_tracker":
        iinclude("content/marketing_tracker.php");
        break;
    case "view_staff":
        iinclude("content/view_staff.php");
        break;
    case "manage_staff":
        iinclude("content/manage_staff.php");
        break;
    case "personal_settings":
        iinclude("content/personal_settings.php");
        break;
    case "nocassist_settings":
        iinclude("content/nocassist_settings.php");
        break;

	//*** TEST
    case "customer_ticket_view":
    	iinclude("client/content/customer_ticket_view.php");
	break;


    //*** Login
    case "login":
        iinclude("content/login.php");
    break;

    //*** Logout
    case "logout":
        //iinclude("content/logout.php");
        foreach ($_SESSION as $var)
        {
            session_unset($var);
        }
        session_destroy();
        header("WISEGENE: Logged Out");
        header("location:index.php"); exit();
        break;

    //*** Main page.
    case "home":
    	iinclude("client/content/home.php");
    	break;

    default:
    	iinclude('error_docs/not_found.html');
    	break;
    	exit;
}



?>