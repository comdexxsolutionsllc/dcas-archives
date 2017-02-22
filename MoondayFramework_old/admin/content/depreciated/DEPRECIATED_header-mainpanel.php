<?php //session_start(); // msg:coreEngine already included
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<!-- Start META Inclusion -->
<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
<meta name = "description" content = ""/>
<meta name = "keywords" content = ""/>
<meta name = "robots" content = "all"/>
<meta name="generator" content=
"HTML Tidy for Linux/x86 (vers 1 September 2005), see www.w3.org" />
<!-- End   META Inclusion -->

<!-- Start LINK Inclusion -->

<?php echo $coreEngine->fileObject->loadCSS('default.css', 'admin', $coreEngine->sRU); ?>
<link rel="Alternate" href="?translation=es" hreflang="es" title="Spanish Translation" />
<link rel="Alternate" href="?translation=fr" hreflang="fr" title="French Translation" />
<link rel="Alternate" href="?translation=gm" hreflang="gm" title="German Translation" />
<link rel="Alternate" href="?translation=it" hreflang="it" title="Italian Translation" />
<link rel="Bookmark" href="" />
<link rel="Contents" href="Administrative Panel: managedNOC" />
<link rel="Copyright" href="2007, Comdexx Software LLC" />
<link rel="Help" href="?action=help" />
<link rel="Index" href="index.php" />
<link rel="Next" href="?action=next" />
<link rel="Prev" href="?action=prev" />
<link rel="Start" href="?page=login" />
<!-- End   LINK Inclusion -->

<title>::managedNOC::Login::</title>

</head>

<body>
<!-- End Page::View(header-mainpanel) -->