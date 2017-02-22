<?php
if(!@$_SESSION['loggedin']) header("Location: logout.php");
//session_start(); // msg:coreEngine already included
/* Include for login to work */  // msg:coreEngine already included
//require_once('engine/coreEngine.php');  // msg:coreEngine already included
//$coreEngine = new coreEngine;  // msg:coreEngine already included
//$coreEngine->init();  // msg:coreEngine already included

if(!empty($_GET['reason']) && $_GET['reason'] == "loggedout")
{
    session_unset();
    session_destroy();
    header("location:index.php?reason=not_authorized_admin");
    exit;
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>

<!-- Start META Inclusion -->
<meta http-equiv="Content-type" content="text/html; charset=ISO-8859-1">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="robots" content="all">
<meta name="generator" content="HTML Tidy for Linux/x86 (vers 1 September 2005), see www.w3.org">
<!-- End   META Inclusion -->

<!-- Start LINK Inclusion -->
<?php echo $coreEngine->fileObject->loadCSS('default.css', 'admin', $coreEngine->sRU); ?>

<link rel="Alternate" href="https://localhost/managedNOC/user.admin/page/home/?translation=es" hreflang="es" title="Spanish Translation">
<link rel="Alternate" href="https://localhost/managedNOC/user.admin/page/home/?translation=fr" hreflang="fr" title="French Translation">
<link rel="Alternate" href="https://localhost/managedNOC/user.admin/page/home/?translation=gm" hreflang="gm" title="German Translation">
<link rel="Alternate" href="https://localhost/managedNOC/user.admin/page/home/?translation=it" hreflang="it" title="Italian Translation">

<link rel="Bookmark" href="">
<link rel="Contents" href="https://localhost/managedNOC/user.admin/page/home/Administrative%20Panel:%20managedNOC">
<link rel="Copyright" href="https://localhost/managedNOC/user.admin/page/home/2007,%20Comdexx%20Software%20LLC">
<link rel="Help" href="https://localhost/managedNOC/user.admin/page/home/?action=help">
<link rel="Index" href="https://localhost/managedNOC/user.admin/page/home/index.php">
<link rel="Next" href="https://localhost/managedNOC/user.admin/page/home/?action=next">
<link rel="Prev" href="https://localhost/managedNOC/user.admin/page/home/?action=prev">
<link rel="Start" href="https://localhost/managedNOC/user.admin/page/home/?page=login">
<!-- End   LINK Inclusion -->

<!-- Start (Any) JavaScript Inclusion -->
<!--<script src="managedNOC/logout.htm" type="text/javascript"></script> // http 404 -->
<script type="text/javascript" src="/managedNOC/admin/js/logout-timeout.js"></script>
<script type="text/javascript" src="/managedNOC/admin/js/countdown-timer.js"></script>
<!-- End (Any) JavaScript Inclusion -->

<title>::managedNOC:: (<?php print $_SESSION['username']; ?>)</title>

</head><body onLoad="set_interval()" onmousemove="reset_interval()" onscroll="reset_interval()">
<!--<body onload="countDown()" onmousemove="resetCounter()" onclick="resetCounter()">--> <!-- onchange/onscroll rmvd -->
<!-- End Page::View(header-mainpanel) -->
