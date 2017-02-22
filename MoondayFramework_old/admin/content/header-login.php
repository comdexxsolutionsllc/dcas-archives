<?php $_SESSION['usertype'] = 'admin'; error_reporting(-1);
/* Include for login to work */
require_once('engine/coreEngine.php');
$coreEngine = new coreEngine;
$coreEngine->init();

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
<?php echo $coreEngine->fileObject->loadCSS('automaticBreadcrumbs.css', 'admin', $coreEngine->sRU); ?>

<script type="text/javascript" src="/managedNOC/admin/js/autoBreadcrumbs.js"></script>
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

<link rel="pingback" href="http://localhost/managedNOC/xmlrpc.php">
<!-- End   LINK Inclusion -->

<title><?php echo configObject::$title; ?></title>

</head>

<body OnLoad="document.loginFrm.username.focus();">
<script type="text/javascript">
//<!--
  breadcrumbs();
//-->
</script>