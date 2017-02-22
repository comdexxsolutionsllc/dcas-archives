<?php error_reporting(E_ALL); session_start();
if(!@$_SESSION['loggedin']) header("Location: logout.php");
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MyDediServer</title>
<!--<link href="style.css" rel="stylesheet" type="text/css" />-->
<?php echo $coreEngine->fileObject->loadCSS('default.css', 'client', $coreEngine->sRU); ?>

<!-- tr { background-color: #DDDDDD} -->
<style type="text/css">
<!--
  tr { }
  .initial { background-color: #DDDDDD; color:#000000 }
  .normal { background-color: #CCCCCC }
  .highlight { background-color: #8888FF }
//-->
</style>


</head>

<body>
<table width="958" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr  >
    <td width="13" height="90" background="<?php echo $coreEngine->sRU; ?>admin/images/header_left_slice.gif" class="bg_fixed" ><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="13" height="1"  /></td>
    <td background="<?php echo $coreEngine->sRU; ?>admin/images/header_bg_slice.gif"><table width="100%" height="90" border="0" cellpadding="0" cellspacing="0">
      <tr >
        <td width="50%"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="20" /><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/logo.gif" width="265" height="50" /></td>
        <td width="50%"><table width="300" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr  >
            <td width="70" align="center"><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_home.gif" width="36" height="30" border="0" /></a></td>
            <td width="70" align="center"><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_mydediserver.gif" width="82" height="30" border="0" /></a></td>
            <td width="70" align="center"><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_support.gif" width="53" height="30" border="0" /></a></td>
            <td width="70" align="center"><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_mini.gif" width="28" height="30" border="0" /></a></td>
            <td width="70" align="center">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="13" height="90" background="<?php echo $coreEngine->sRU; ?>admin/images/header_right_slice.gif" class="bg_fixed"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="13" height="1" /></td>
  </tr>
</table><table width="958" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr >
    <td height="34" background="<?php echo $coreEngine->sRU; ?>admin/images/nav_bar_bg.gif"><table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr >
        <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_administrative.gif" width="118" height="34" border="0" /></a></td>
        <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_support0.gif" width="91" height="34" border="0" /></a></td>
        <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_security.gif" width="87" height="34" border="0" /></a></td>
        <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_hardware.gif" width="101" height="34" border="0" /></a></td>
        <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_software.gif" width="91" height="34" border="0" /></a></td>
        <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_publicnetwork.gif" width="129" height="34" border="0" /></a></td>
        <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_privatework.gif" width="124" height="34" border="0" /></a></td>
        <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_sales.gif" width="100" height="34" border="0" /></a></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0"><tr >
  <td height="42" background="<?php echo $coreEngine->sRU; ?>admin/images/customer_splash_heading_bg.jpg" class="bg_fixed"><span class="text_login_h2"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="34" height="1" />Welcome To MydediServer (PDF) </span></td>
</tr><tr >
  <td height="42" background="<?php echo $coreEngine->sRU; ?>admin/images/customer_splash_heading_bg2.gif" class="bg_fixed"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr >
      <td width="50%"><span class="text_login_h3_RED"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="34" height="15" />New Account Security Requirements </span></td>
      <td width="50%" rowspan="2" align="right" class="text_login_h">CUSTOMER PORTAL HOME<img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="10" height="2" /> </td>
    </tr>
    <tr >
      <td><span class="text_login_h2"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="34" height="13" /></span><span class="text_rights"><strong>Click to Open/Close</strong></span> </td>
      </tr>
  </table></td>
</tr><tr >
  <td height="40" class="text_login_h_green"><span class="text_login_h2"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="34" height="1" /></span>Welcome to MyDediServer Customer Login Portal</td>
</tr>
  <tr >
    <td height="490" align="center" valign="top" class="bg_fixed_repeat_y"><table width="955" border="0" cellspacing="0" cellpadding="0">
      <tr >
        <td height="35" align="left" background="<?php echo $coreEngine->sRU; ?>admin/images/customer-login_heading_bg6.gif" class="bg_fixed"><span class="text_login_h"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="20" height="1" />Current Active Ticket</span> </td>
      </tr>
      <tr >
        <td height="22" align="center" background="<?php echo $coreEngine->sRU; ?>admin/images/customer-ticket-view-head.gif"><table width="90%" border="0" cellspacing="0" cellpadding="0">
          <tr >
            <td width="5%" align="left" class="text_login_h">Id</td>
            <td width="25%" align="left" class="text_login_h">Title</td>
            <td width="9%" align="left" class="text_login_h">Owner</td>
            <td width="8%" align="left" class="text_login_h">Status</td>
            <td width="9%" align="left" class="text_login_h">Type</td>
            <td width="18%" align="left" class="text_login_h">Created</td>
            <td width="17%" align="left" class="text_login_h">Modified</td>
            <td width="9%" align="left" class="text_login_h">Edit</td>
          </tr>
        </table></td>
      </tr>
      <tr >
        <td class="bg_fixed_bottom"><table width="100%" height="130" border="0" cellpadding="0" cellspacing="0">
          <tr >
            <td height="0" align="center" valign="middle" background="<?php echo $coreEngine->sRU; ?>admin/images/customer-ticket-view-line.gif"><table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                <td width="10%" align="left" class="text_login_h">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;001</td>
                <td width="22%" align="left" class="text_login_h2">Remove 40 GB NAS </td>
                <td width="8%" align="left" class="text_login_h2">John Smith </td>
                <td width="7%" align="left" class="text_login_h2">Closed</td>
                <td width="9%" align="left" class="text_login_h">&nbsp;</td>
                <td width="15%" align="left" class="text_login_h2">2008-Feb-26 09:48</td>
                <td width="16%" align="left" class="text_login_h2"><span class="text_login_h2">2008-Mar-03 04:48</span></td>
                <td width="13%" align="left" class="text_login_h2"><p class="text_login_h_green">Edit</p>
                  </td>
              </tr>
              <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                <td align="left" bgcolor="#E9F4F8" class="text_login_h">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;002</td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h"><span class="text_login_h2">Remove Cisco ASA 10 Mbps </span></td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h"><span class="text_login_h2">John Smith</span></td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h"><span class="text_login_h2">Closed</span></td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h">&nbsp;</td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h2">2008-Feb-26 09:48</td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h2">2008-Mar-03 04:48</td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h2"><span class="text_login_h_green">Edit</span></td>
              </tr>
              <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                <td align="left" class="text_login_h">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;003</td>
                <td align="left" class="text_login_h2">Payment is late pricing issue </td>
                <td align="left" class="text_login_h"><span class="text_login_h2">John Smith</span></td>
                <td align="left" class="text_login_h"><span class="text_login_h2">Closed</span></td>
                <td align="left" class="text_login_h">&nbsp;</td>
                <td align="left" class="text_login_h2">2008-Feb-26 09:48</td>
                <td align="left" class="text_login_h2">2008-Mar-03 04:48</td>
                <td align="left" class="text_login_h2"><span class="text_login_h_green">Edit</span></td>
              </tr>
              <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                <td align="left" bgcolor="#E9F4F8" class="text_login_h">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;004</td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h"><span class="text_login_h2">Remove 40 GB NAS </span></td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h"><span class="text_login_h2">John Smith</span></td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h"><span class="text_login_h2">Closed</span></td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h">&nbsp;</td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h2">2008-Feb-26 09:48</td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h2">2008-Mar-03 04:48</td>
                <td align="left" bgcolor="#E9F4F8" class="text_login_h2"><span class="text_login_h_green">Edit</span></td>
              </tr>
            </table></td>
          </tr><tr ><td background="<?php echo $coreEngine->sRU; ?>admin/images/customer-ticket-line_corner.gif" class="bg_fixed_bottom" ><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" height="5"/></td>
          </tr>
        </table></td>
      </tr>
    </table>
      <br />
      <br />
      <table width="955" border="0" cellspacing="0" cellpadding="0">
        <tr >
          <td height="35" align="left" background="<?php echo $coreEngine->sRU; ?>admin/images/customer-login_heading_bg6.gif" class="bg_fixed"><span class="text_login_h"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="20" height="1" />Last Five Closed  Tickets</span></td>
        </tr>
        <tr >
          <td height="22" align="center" background="<?php echo $coreEngine->sRU; ?>admin/images/customer-ticket-view-head.gif"><table width="90%" border="0" cellspacing="0" cellpadding="0">
              <tr >
                <td width="5%" align="left" class="text_login_h">Id</td>
                <td width="25%" align="left" class="text_login_h">Title</td>
                <td width="9%" align="left" class="text_login_h">Owner</td>
                <td width="8%" align="left" class="text_login_h">Status</td>
                <td width="9%" align="left" class="text_login_h">Type</td>
                <td width="18%" align="left" class="text_login_h">Created</td>
                <td width="17%" align="left" class="text_login_h">Modified</td>
                <td width="9%" align="left" class="text_login_h">Edit</td>
              </tr>
          </table></td>
        </tr>
        <tr >
          <td class="bg_fixed_bottom"><table width="100%" height="130" border="0" cellpadding="0" cellspacing="0">
              <tr >
                <td height="0" align="center" valign="middle" background="<?php echo $coreEngine->sRU; ?>admin/images/customer-ticket-view-line.gif"><table width="100%" border="0" cellspacing="0" cellpadding="5">
                    <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                      <td width="10%" align="left" class="text_login_h">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;099</td>
                      <td width="22%" align="left" class="text_login_h2">Server Price Adjustments  </td>
                      <td width="8%" align="left" class="text_login_h2">John Smith </td>
                      <td width="7%" align="left" class="text_login_h2">Closed</td>
                      <td width="9%" align="left" class="text_login_h">&nbsp;</td>
                      <td width="15%" align="left" class="text_login_h2">2008-Feb-26 09:48</td>
                      <td width="16%" align="left" class="text_login_h2">2008-Mar-03 04:48</td>
                      <td width="13%" align="left" class="text_login_h2"><p class="text_login_h_green">View</p></td>
                    </tr>
                    <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;098</td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h"><span class="text_login_h2" >Accounting Request  </span></td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h"><span class="text_login_h2">John Smith</span></td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h"><span class="text_login_h2">Closed</span></td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h">&nbsp;</td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h2">2008-Feb-26 09:48</td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h2">2008-Mar-03 04:48</td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h2"><span class="text_login_h_green">View</span></td>
                    </tr>
                    <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                      <td align="left" class="text_login_h">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;097</td>
                      <td align="left" class="text_login_h2">Server Price Adjustments</td>
                      <td align="left" class="text_login_h"><span class="text_login_h2">John Smith</span></td>
                      <td align="left" class="text_login_h"><span class="text_login_h2">Closed</span></td>
                      <td align="left" class="text_login_h">&nbsp;</td>
                      <td align="left" class="text_login_h2">2008-Feb-26 09:48</td>
                      <td align="left" class="text_login_h2">2008-Mar-03 04:48</td>
                      <td align="left" class="text_login_h2"><span class="text_login_h_green">View</span></td>
                    </tr>
                    <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;096</td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h"><span class="text_login_h2">Payment Past Due march  02, 3 </span></td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h"><span class="text_login_h2">John Smith</span></td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h"><span class="text_login_h2">Closed</span></td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h">&nbsp;</td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h2">2008-Feb-26 09:48</td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h2">2008-Mar-03 04:48</td>
                      <td align="left" bgcolor="#E9F4F8" class="text_login_h2"><span class="text_login_h_green">View</span></td>
                    </tr>
                </table></td>
              </tr>
            <tr >
              <td background="<?php echo $coreEngine->sRU; ?>admin/images/customer-ticket-line_corner.gif" class="bg_fixed_bottom" ><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" height="5"/></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
  </tr>
  <tr  >
    <td height="53" valign="middle" background="<?php echo $coreEngine->sRU; ?>admin/images/login_slic_bt2.gif" class="bg_fixed"><table width="400" border="0" align="left" cellpadding="0" cellspacing="0">

      <tr >
        <td height="30" class="text_rights"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="20" height="10" /><strong>products  |  services  |  network datacenter  |  aboutsoflayer  | sitemap</strong></td>
      </tr><tr >
        <td align="left" class="text_rights"><span class="text_login_h2"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="20" height="10" /></span>Copyrights &copy; 2008 MyDediServer All rights reserved.</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>