<!-- OLD LOGIN PAGE -->
<?php session_start();
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
<table width="958" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="13" height="97" background="<?php echo $coreEngine->sRU; ?>admin/images/header_left_slice.gif" class="bg_fixed" ><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="13" height="1"  /></td>
    <td background="<?php echo $coreEngine->sRU; ?>admin/images/header_bg_slice.gif"><table width="100%" height="97" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50%"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="20" /><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/logo.gif" width="265" height="50" /></td>
        <td width="50%"><table width="300" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="70" align="center"><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_home.gif" width="36" height="30" border="0" /></a></td>
            <td width="70" align="center"><a href="http://mydediserver.com/#redirect__panel"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_mydediserver.gif" width="82" height="30" border="0" /></a></td>
            <td width="70" align="center"><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_support.gif" width="53" height="30" border="0" /></a></td>
            <td width="70" align="center"><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_mini.gif" width="28" height="30" border="0" /></a></td>
            <td width="70" align="center">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="13" height="97" background="<?php echo $coreEngine->sRU; ?>admin/images/header_right_slice.gif" class="bg_fixed"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="13" height="1" /></td>
  </tr>
</table><table width="958" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="2" height="10" /></td>
  </tr>
</table>
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td height="35" background="<?php echo $coreEngine->sRU; ?>admin/images/login_slic_tp.gif" class="bg_fixed"><span class="text_login_h"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="150" height="1" />Employee Login</span></td>
</tr>
  <tr>
    <td height="230" background="<?php echo $coreEngine->sRU; ?>admin/images/login_line_slc.gif" class="bg_fixed_repeat_y">
    <form action="<?php print $coreEngine->sRU; ?>?user=<?php print $_GET['user']; ?>" method="post">
    <table height="151" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="96" align="left" valign="middle"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/icon_login.gif" width="61" height="67" /></td>
        <td width="247" align="left" valign="bottom"><table width="247" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="116" height="29" class="text_rights">Enter User Name : </td>
            <td width="131"><input name="username" type="text" size="13" /></td>
          </tr>
          <tr>
            <td height="27" class="text_rights">Enter Password : </td>
            <td><input name="password" type="text" size="13" /></td>
          </tr>
          <tr>
            <td height="26">&nbsp;</td>
            <td><a href="#"><input name="submit_btn" type="image" alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_login.gif" width="58" height="19" border="0" onclick="form.submit()" /></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="31" colspan="2" align="center" valign="middle" class="text_red">Forget Your Password? </td>
        </tr>
    </table></form></td>
  </tr>
  <tr >
    <td height="81" valign="bottom" background="<?php echo $coreEngine->sRU; ?>admin/images/login_slic_bt.gif" class="bg_fixed"><table width="400" border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" class="text_rights">Copyrights &copy; 2008 MyDediServer All rights reserved.</td>
      </tr>
      <tr>
        <td><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="2" height="10" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
