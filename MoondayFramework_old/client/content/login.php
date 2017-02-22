<?php session_start(); $_SESSION['usertype'] = 'client'; error_reporting(-1); echo 'Session__USERTYPE:'.$_SESSION['usertype'];
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
<meta name="Author" content="Comdexx Software LLC">
<meta name="Language" content="English">
<meta name="Designer" content="Zend Framework">
<meta name="Distribution" content="Global">
<meta name = "keywords" content = ""/>
<meta name = "robots" content = "all"/>
<meta name="generator" content=
"HTML Tidy for Linux/x86 (vers 1 September 2005), see www.w3.org" />
<!-- End   META Inclusion -->

<!-- Start LINK Inclusion -->

<?php echo $coreEngine->fileObject->loadCSS('default.css', 'client', $coreEngine->sRU); ?>
<?php echo $coreEngine->fileObject->loadCSS('inlineComments.css', 'client', $coreEngine->sRU); ?>
<?php echo $coreEngine->fileObject->loadCSS('ajaxLoader.css', 'client', $coreEngine->sRU); ?>
<?php echo $coreEngine->fileObject->loadCss('automaticBreadcrumbs.css', 'client', $coreEngine->sRU); ?>
<?php echo $coreEngine->fileObject->loadCss('SpryValidationTextField.css', 'client', $coreEngine->sRU); ?>
<link rel="Alternate" href="./?translation=es" hreflang="es" title="Spanish Translation" />
<link rel="Alternate" href="./?translation=fr" hreflang="fr" title="French Translation" />
<link rel="Alternate" href="./?translation=gm" hreflang="gm" title="German Translation" />
<link rel="Alternate" href="./?translation=it" hreflang="it" title="Italian Translation" />
<link rel="Bookmark" href="" />
<link rel="Contents" href="Administrative Panel: managedNOC" />
<link rel="Copyright" href="2007, Comdexx Software LLC" />
<link rel="Help" href="./?action=help" />
<link rel="Index" href="index.php" />
<link rel="Next" href="./?action=next" />
<link rel="Prev" href="./?action=prev" />
<link rel="Start" href="./?page=login" />

<link rel="pingback" href="http://localhost/managedNOC/xmlrpc.php">
<!-- End   LINK Inclusion -->


<title><?php echo configObject::$title; ?></title>

</head>


<body>

<?php //echo $coreEngine->userObject->clearAccessLevels((int) 1) . "<br \>"; ?>

<!-- Creating SAFE Links -->
<!--
<a href="
<?php echo rawurlencode('second page.php'); ?>
?
<?php echo urlencode('hi=5&id=1 2'); ?>
">
<?php echo htmlspecialchars('<Click> Here!'); ?>
</a>
-->
<!-- Creating SAFE Links -->

<script type="text/javascript">
<!--
  autoExpire();
  breadcrumbs();
//-->
</script>

<table width="958" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="13" height="97" background="<?php echo $coreEngine->sRU; ?>client/images/header_left_slice.gif" class="bg_fixed" ><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="13" height="1"  /></td>
    <td background="<?php echo $coreEngine->sRU; ?>client/images/header_bg_slice.gif"><table width="100%" height="97" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50%"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="20" /><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/logo.gif" width="265" height="50" /></td>
        <td width="50%"><table width="300" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="70" align="center"><a href="#"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/btn_home.gif" width="36" height="30" border="0" /></a></td>
            <td width="70" align="center"><a href="http://mydediserver.com/#redirect__panel"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/btn_mydediserver.gif" width="82" height="30" border="0" /></a></td>
            <td width="70" align="center"><a href="#"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/btn_support.gif" width="53" height="30" border="0" /></a></td>
            <td width="70" align="center"><a href="#"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/btn_mini.gif" width="28" height="30" border="0" /></a></td>
            <td width="70" align="center"></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="13" height="97" background="<?php echo $coreEngine->sRU; ?>client/images/header_right_slice.gif" class="bg_fixed"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="13" height="1" /></td>
  </tr>
</table><table width="958" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="2" height="10" /></td>
  </tr>
</table>
<table width="960" height="542" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="239" align="left" valign="top"><table width="239" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="32" align="left" valign="top" background="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bg.gif" class="bg_fixed"><span class="text_login_h_white"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="16" height="20" />Customer Login</span> </td>
      </tr>
      <tr>
        <td height="160" align="left" valign="middle" background="<?php echo $coreEngine->sRU; ?>client/images/customer-login_headingline_bg.gif" class="bg_fixed_repeat_y"><table width="209" border="0" align="center" cellpadding="0" cellspacing="0">
        <!--<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="loginFrm" name="loginFrm" />-->
        <form action="<?php print $coreEngine->sRU; ?>" method="post">
          <tr>
            <td width="107" height="31" class="text_login_h_grey_small"><span id="sprytextfield1">User Name : </td>
            <td width="102"><input type="text" class="text_rights" size="20" name="username" id="username" />
            <span class="textfieldRequiredMsg">A value is required.</span></span>
            </td>
          </tr>
          <tr>
            <td height="28" valign="top" class="text_login_h_grey_small">Password : </td>
            <td valign="top"><input type="password" class="text_rights" size="20" name="password" id="password" /></td>
          </tr>
          <tr>
            <td height="21" colspan="2" class="text_login_h_grey_small">Security Question (If Configured) </td>
            </tr>
          <tr>
            <td height="37" colspan="2" valign="top"><select name="select" class="text_rights">
              <option>What is your favorite food?       </option>
              <option>What is your pet's name?          </option>
              <option>What is your mother's maiden name?</option>
            </select>
            </td>
            </tr>
          <tr>
            <td class="text_login_h_grey_small">Lost Password : </td>
            <td align="right"><input type="image" id="submit" name="submit" onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/btn_cst-login.gif" width="56" height="25" border="0" /><!--<img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/btn_cst-login.gif" width="56" height="25" border="0" />--></td>
          </tr>
        </form>
        </table></td>
      </tr>
      <tr>
        <td height="31" align="left" valign="top" background="<?php echo $coreEngine->sRU; ?>client/images/customer-login_btm_bg.gif" class="bg_fixed"></td>
      </tr>
    </table>
      <br />
      <table width="239" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="33" align="left" valign="top" background="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bg2.gif" class="bg_fixed"><span class="text_login_h_grey"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="16" height="20" />Portal Features </span> </td>
        </tr>
        <tr>
          <td height="160" align="left" valign="middle" background="<?php echo $coreEngine->sRU; ?>client/images/customer-login_headingline_bg.gif" class="bg_fixed_repeat_y"><table width="90%" height="317" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td height="31" class="text_login_h_grey_small">Administrative Features</td>
              </tr>
              <tr>
                <td height="82" valign="top" class="text_login_h2"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />Purchase Servers<br />
                <img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />Purchase Services<br />
                <img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />User Administration<br />
                <img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />Contact Information<br />
                <img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />Accounting / Billing Information</td>
              </tr>
              <tr>
                <td height="28" class="text_login_h_grey_small">Public Network Features</td>
              </tr>
              <tr>
                <td height="77" valign="top" class="text_login_h2"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />DNS Management<br />
                  <img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />Security Information<br />
                  <img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />Public Port Control<br />
                <img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />Public Bandwidth Graphs</td>
              </tr>
              <tr>
                <td height="25" class="text_login_h_grey_small">Support Features</td>
              </tr>
              <tr>
                <td class="text_login_h2"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />Tutorials<br />
                  <img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />Ticketing System<br />
                  <img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />Hardware Reboot<br />
                  <img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />VPN Access Information<br />
                <img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bullet.gif" width="18" height="8" />Administration Tickets</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="31" align="left" valign="top" background="<?php echo $coreEngine->sRU; ?>client/images/customer-login_btm_bg.gif" class="bg_fixed"></td>
        </tr>
      </table></td>
    <td width="8" align="left"></td>
    <td width="713" align="left" valign="top"><table width="710" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="37" align="left" valign="top" background="<?php echo $coreEngine->sRU; ?>client/images/customer-login_heading_bg3.gif" class="bg_fixed"><span class="text_login_h"><span class="text_login_h_white"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="16" height="20" /></span>MyDediServer customer portal</span></td>
      </tr>
      <tr>
        <td height="241" background="<?php echo $coreEngine->sRU; ?>client/images/customer-login_headingline_bg2.gif" class="text_login_h2_grey"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="77" align="left"><span class="text_login_h"><strong>Welcome to MyDediServer </strong></span><br />
              Customer Management Portal</td>
          </tr>
        </table>
          <table width="95%" height="211" border="0" align="center" cellpadding="0" cellspacing="0" class="text_login_h2_grey">
  <tr>
    <td height="211" align="left" valign="top"><p><strong>Public Network Approach:</strong> Users can connect directly to the server via SSH, Terminal Services, web-based Plesk admin screen, or other server control type applications. This will allow you to directly administer your server over the Internet.<br />
        </p>
          <p><strong>Private Network Approach:</strong> Users first connect to our secure SSL VPN<br />
            gateway to gain access to the private out-of-band management network. Once connected, administer your server with SSH, Terminal Services or other server control type applications. This will allow you to securely manage your server over the Internet through a private VPN tunnel.<br />
          </p>
          <p><strong>Customer Management Portal:</strong> Most users will find the customer portal the most comprehensive method to manage your server and services with MyDediServer. MyDediServer customer portal allows secure access via SSL web-based administration over the Internet using common web browsers, such as Internet Explorer.<br />
          </p></td>
  </tr>
</table>
</td>
      </tr>
      <tr>
        <td height="40" background="<?php echo $coreEngine->sRU; ?>client/images/customer-login_btm_bg2.gif"></td>
      </tr>
    </table>
      <br />
      <table width="710" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="340" height="115" align="left" valign="middle" background="<?php echo $coreEngine->sRU; ?>client/images/customer-login_panel-bg.gif" class="bg_fixed"><table width="272" height="95" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="77" align="center" valign="top"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/btn_cst-login-assitant.gif" width="30" height="50" /></td>
              <td width="195" valign="top"><span class="text_login_h">Sales Assistance</span><br />
                <span class="text_login_h_blue"><strong><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="1" height="15" />Contact a Sales <br />
                Representative</strong></span><br />
                <span class="text_login_h_blue"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="1" height="15" />Toll Free: 0-000-000-000<br />
                Local:      0-000-000-000<br />
                sales@mydediserver.com</span></td>
            </tr>
          </table></td>
          <td width="5" align="left" valign="top" class="bg_fixed"></td>
          <td width="365" align="left" valign="middle" background="<?php echo $coreEngine->sRU; ?>client/images/customer-login_panel2-bg.gif" class="bg_fixed"><table width="272" height="95" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="77" align="center" valign="top"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/btn_cst-login-assitant2.gif" width="35" height="61" /></td>
              <td width="195" valign="top"><span class="text_login_h">Support Assistance</span><br />
                  <span class="text_login_h_blue"><strong><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="1" height="15" />Contact a Support <br />
                  Representative</strong></span><br />
                <span class="text_login_h_blue"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="1" height="15" />Toll Free: 0-000-000-000<br />
                  Local:      0-000-000-000<br />
                  sales@mydediserver.com</span></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="710" height="102" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left" valign="middle" class="bg_fixed"><br />
          <img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/bottom_img.gif" width="710" height="102" /></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="2" height="10" /></td>
  </tr>
  <tr >
    <td height="53" valign="middle" background="<?php echo $coreEngine->sRU; ?>client/images/login_slic_bt2.gif" class="bg_fixed"><table width="400" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td height="30" class="text_rights"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="20" height="10" /><strong>products  |  services  |  network+datacenter  |  about | sitemap</strong></td>
      </tr>
      <tr>
        <td align="left" class="text_rights"><span class="text_login_h2"><img onError="imageError(this)" onAbort="imageError(this)" alt="" src="<?php echo $coreEngine->sRU; ?>client/images/spacer.gif" width="20" height="10" /></span>Copyright &copy; 2008-<span id="copyright"></span> MyDediServer All rights reserved.</td>
      </tr>
    </table></td>
  </tr>
</table>
<!--
<br>
Be sure and read <a href="#" onClick="return show_hide_box(this,200,270,'2px dotted')">this one</a>.
<br>

<br>
The <a name="1" class="show">W3C</a> <span class="hide">World Wide Web Consortium</span> develops
<a name="2" class="show">interoperable technologies</a> <span class="hide">specifications, guidelines, software, and tools</span> to lead the Web to its full potential. To achieve the goal of one Web, specifications for the Web's formats and protocols must be compatible with one another and allow (any) hardware and software used to access the Web to work together.  Since 1994, the W3C has produced more than ninety
<a name="2" class="show">Web standards</a> <span class="hide">W3C Recommendations</span>.
<br>-->
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
//-->
</script>

<script type="text/javascript" src="/managedNOC/client/js/inlineComments.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/acceptTerms.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/addressBook.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/ajaxLoader.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/ajaxNavigation2.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/alertBoxProtection.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/allLowerCase.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/altRows.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/animatedTooltip.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/antiSPAM.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/autoBreadcrumbs.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/autoExpire.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/autoTab.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/base2.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/breakFrames.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/browserInformation.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/browserVersionRedirect.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/buildTOC.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/checkMIMES.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/cookieEnabled.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/copyNote.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/dFilter.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/DHTMLTooltipGenerator.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/directory.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/disableEnter.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/DOMAssistantCompressed.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/domFunction.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/FTPServerLogin.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/getElementById.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/getElementsByAttribute.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/getelementsbyclassname.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/getFirefox.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/getPosition2.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/getStyle.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/getXML.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/historyKeeper.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/htaccessLogin.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/HTML-Interface.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/HTML2XHTML.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/imageLoad.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/imagePreloader.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/keyLauncher.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/newBrowsersOnly.js"></script>
<script type="text/javascript" src="/managedNOC/client/js/softxmllib.js"></script>
<script src="/managedNOC/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language="Javascript1.2">
message = "Function Disabled!";

function NoRightClick(b) {
   if(((navigator.appName=="Microsoft Internet Explorer")&&(event.button > 1))
   ||((navigator.appName=="Netscape")&&(b.which > 1))){
   alert(message);
   return false;
   }
}
document.onmousedown = NoRightClick;

</script>


</body>
</html>

<?php require_once('terminate-coreEngine.php'); // Terminate coreEngine Class ?>