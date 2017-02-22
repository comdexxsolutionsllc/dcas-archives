<?php session_start();
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
    <td width="13" height="97" background="images/header_left_slice.gif" class="bg_fixed" ><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="13" height="1"  /></td>
    <td background="images/header_bg_slice.gif"><table width="100%" height="97" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="33%"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/logo.gif" width="265" height="50" /></td>
        <td width="67%"><table width="100%" height="97" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="50%" height="58"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
              <tr>
                <td width="70" align="center"><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_home.gif" width="36" height="30" border="0" /></a></td>
                <td width="70" align="center"><a href="http://mydediserver.com/#redirect__panel"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_mydediserver.gif" width="82" height="30" border="0" /></a></td>
                <td width="70" align="center"><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_support.gif" width="53" height="30" border="0" /></a></td>
                <td width="70" align="center"><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_mini.gif" width="28" height="30" border="0" /></a></td>
                <td width="70" align="center"></td>
              </tr>
            </table></td>
            <td width="50%"><table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td height="27" class="text_login_h">Search :
                  <input name="textfield3" type="text" class="text_login_h_blue" />
                  <a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_search.gif" width="52" height="18" border="0" align="absmiddle" /></a></td>
              </tr>
              <tr>
                <td height="26" class="text_login_h_green">For Advanced Search! </td>
              </tr>
              <tr>
                <td height="29"><select name="select2" class="text_login_h2_grey">
                  <option selected="selected">Ticket - Ticket Id</option>
                </select>
                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="13" height="97" background="images/header_right_slice.gif" class="bg_fixed"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="13" height="1" /></td>
  </tr>
</table><table width="958" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="2" height="10" /></td>
  </tr>
</table>
<table width="0" height="542" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="210" align="left" valign="top"><table width="210" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="32" align="left" valign="top" background="images/customer-login_heading_bg4.gif" class="bg_fixed"><span class="text_login_h"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="16" height="20" />User Information </span> </td>
      </tr>
      <tr>
        <td align="left" valign="middle" background="images/customer-login_headingline_bg3.gif" class="bg_fixed_repeat_y"><table width="195" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="195" height="160" class="text_login_h_grey_smallsa"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green.gif" width="19" height="9" /><strong>Active User:</strong> <span class="style1"><strong>John Smith</strong></span> <br />
                <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green.gif" width="19" height="9" /><strong>Assigned Tickets:</strong> <span class="style1">0</span><br />
                <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green.gif" width="19" height="9" /><strong>Yellow Tickets:</strong> <span class="style1">0</span><br />
                <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green.gif" width="19" height="9" /><strong>Date:</strong><br />
                <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green.gif" width="19" height="9" /><strong>TZ:</strong> <span class="style1">America/Chicago</span> <br />
                <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green.gif" width="19" height="9" /><strong>Change Log:</strong> <span class="style1">Change Log (0)</span> <br />
                <br />
                <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green.gif" width="19" height="9" /><strong class="style1" >Forum Login</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green.gif" width="19" height="9" /> <strong class="style1">Logout</strong> </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="31" align="left" valign="top" background="images/customer-login_btm_bg3.gif" class="bg_fixed"></td>
      </tr>
    </table>
      <table width="210" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="32" align="left" valign="top" background="images/customer-login_heading_bg4.gif" class="bg_fixed"><span class="text_login_h"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="16" height="20" />Ticket Status  </span> </td>
        </tr>
        <tr>
          <td align="left" valign="middle" background="images/customer-login_headingline_bg3.gif" class="bg_fixed_repeat_y"><table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="195" height="160" align="left" valign="top" class="text_login_h_grey_smallsa"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="text_login_h2_2">

                  <tr>
                    <td width="93" align="left"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />ChargesBacks: </td>
                    <td width="39" align="left">9<br /></td>
                    <td width="45" align="left">2<br /></td>
                    <td width="23" align="left"><strong> 1</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />Development:</td>
                    <td align="left">15<br /></td>
                    <td align="left">17<br /></td>
                    <td align="left"><strong> 21</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />Maintenance:</td>
                    <td align="left">19<br /></td>
                    <td align="left">0<br /></td>
                    <td align="left"><strong> 18</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />Monitoring:</td>
                    <td align="left">26<br /></td>
                    <td align="left">0<br /></td>
                    <td align="left"><strong>23</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />Network:</td>
                    <td align="left">20<br /></td>
                    <td align="left">9<br /></td>
                    <td align="left"><strong>1</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />SLA:</td>
                    <td align="left">0<br /></td>
                    <td align="left">5<br /></td>
                    <td align="left"><strong>5</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />Sales:</td>
                    <td align="left">124<br /></td>
                    <td align="left">59<br /></td>
                    <td align="left"><strong>12</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />Support:</td>
                    <td align="left">134<br /></td>
                    <td align="left">119<br /></td>
                    <td align="left"><strong>4</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />SysAdmin:</td>
                    <td align="left">47<br /></td>
                    <td align="left">111<br /></td>
                    <td align="left"><strong>3</strong></td>
                  </tr>
                  <tr>
                    <td align="left"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />Systems</td>
                    <td align="left">1</td>
                    <td align="left">4</td>
                    <td align="left"><strong>1</strong></td>
                  </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="31" align="left" valign="top" background="images/customer-login_btm_bg3.gif" class="bg_fixed"></td>
        </tr>
      </table>
      <table width="210" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="32" align="left" valign="top" background="images/customer-login_heading_bg4.gif" class="bg_fixed"><span class="text_login_h"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="16" height="20" />Transaction status</span> </td>
        </tr>
        <tr>
          <td align="left" valign="middle" background="images/customer-login_headingline_bg3.gif" class="bg_fixed_repeat_y"><table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="195" height="130" align="left" valign="top" class="text_login_h_grey_smallsa"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="text_login_h2_2">

                    <tr>
                      <td width="0" align="left" valign="middle"><p>                      <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />Pending Assignment:<br />
                        </p>
                      </td>
                      <td width="39" align="left">0</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />Pending Charges:<br /></td>
                      <td align="left">0</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />Overdue: **<br /></td>
                      <td align="left">1</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />Running:<br /></td>
                      <td align="left">5</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green2.gif" width="11" height="14" />Total:</td>
                      <td align="left">5</td>
                    </tr>

                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="31" align="left" valign="top" background="images/customer-login_btm_bg3.gif" class="bg_fixed"></td>
        </tr>
      </table>
      <table width="210" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="32" align="left" valign="top" background="images/customer-login_heading_bg4.gif" class="bg_fixed"><span class="text_login_h"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="16" height="20" />Common Links </span> </td>
        </tr>
        <tr>
          <td align="left" valign="middle" background="images/customer-login_headingline_bg3.gif" class="bg_fixed_repeat_y"><table width="195" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="195" height="160" valign="top" class="text_login_h2_grey"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green3.gif" width="10" height="20" align="absmiddle" />Ticket Search<br />
                  <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green3.gif" width="10" height="20" align="absmiddle" />Hardware Search<br />
                  <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green3.gif" width="10" height="20" align="absmiddle" />Customer Search<br />
                  <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green3.gif" width="10" height="20" align="absmiddle" />Support Wiki<br />
                  <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green3.gif" width="10" height="20" align="absmiddle" />Emergency Contact<br />
                  <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green3.gif" width="10" height="20" align="absmiddle" />Employee List<br />
                  <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green3.gif" width="10" height="20" align="absmiddle" />Tutorial<br />
                  <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green3.gif" width="10" height="20" align="absmiddle" />Links<br />
                  <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/bullet-green3.gif" width="10" height="20" align="absmiddle" />Forums</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="31" align="left" valign="top" background="images/customer-login_btm_bg3.gif" class="bg_fixed"></td>
        </tr>
      </table>
    <br /></td>
    <td width="8" align="left"></td>
    <td width="763" align="left" valign="top">
      <table width="763" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="26" background="images/employee_1.gif" class="text_login_h"> <img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="20" height="2" />Link: None </td>
        </tr>
        <tr>
          <td height="25" background="images/employee_2.gif" class="text_login_h"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="20" height="2" />Current: Employee portal </td>
        </tr>
        <tr>
          <td height="27"><table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_sections.gif" width="78" height="27" /></td>
              <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_accounting.gif" width="101" height="27" border="0" /></a></td>
              <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_hardware1.gif" width="89" height="27" border="0" /></a></td>
              <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_network.gif" width="78" height="27" border="0" /></a></td>
              <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_sales1.gif" width="70" height="27" border="0" /></a></td>
              <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_security1.gif" width="80" height="27" border="0" /></a></td>
              <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_services.gif" width="80" height="27" border="0" /></a></td>
              <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_reports.gif" width="80" height="27" border="0" /></a></td>
              <td><a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_managments.gif" width="107" height="27" border="0" /></a></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="910" align="left" valign="top" background="images/line_21.gif" class="bg_fixed_repeat_y"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td height="35" class="text_login_h_green">Welcome to the Employee Management Portal </td>
            </tr>
            <tr>
              <td height="45" class="text_login_h2_grey">Search:
                <select name="select" class="text_login_h2">
                  <option>Department</option>
                </select>
                For:
                <input name="textfield" type="text" class="text_login_h2" value="Billing" />
                With status:
                <select name="select3" class="text_login_h2">
                  <option>All</option>
                </select>
                &nbsp;<img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_search.gif" width="52" height="18" align="absmiddle" /> <span class="text_login_h3_RED">Advanced Search! </span></td>
            </tr>
            <tr>
              <td><table width="747" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="36" background="images/customer-login_heading_bg6.gif" class="text_login_h"><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="10" height="2" />Ticket Search (1)</td>
                </tr>
                <tr>
                  <td height="100" bgcolor="#E0F1FA"><table width="90%" border="0" align="left" cellpadding="0" cellspacing="5">
                    <tr>
                      <td width="4%" class="text_login_h3_RED">&nbsp;</td>
                      <td width="17%" class="text_login_h2">&nbsp;</td>
                      <td width="17%" class="text_login_h2">Amount: 10000 $ </td>
                      <td width="36%" class="text_login_h2">Created: 2008-Feb-26 09:48 (GMT-0600)</td>
                      <td width="13%" class="text_login_h2">Status : Open </td>
                      <td width="13%" class="text_login_h3_RED">[Preview]</td>

                    </tr>
                    <tr>
                      <td class="text_login_h3_RED">&nbsp;</td><td class="text_login_h2">Server   : Not Found                                                            </td>
                      <td class="text_login_h2">Owner:    John Smith</td>
                      <td class="text_login_h2">Modified: 2008-Feb-26 09:48 (GMT-0600)</td>
                      <td class="text_login_h2">Staff   : None</td>
                      <td class="text_login_h3_RED">[Auto Reply]</td>

                    </tr>
                    <tr>
                      <td>&nbsp;</td><td class="text_login_h2">Location : Not Found                                      </td>
                      <td class="text_login_h2">Group:     Billing</td>
                      <td class="text_login_h2">Elapsed:  3m </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>

                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
		<tr>
          <td height="43" valign="bottom" background="images/line_2btDFDF.gif" class="bg_fixed"><table width="400" border="0" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" class="text_rights">Copyrights &copy; 2008 MyDediServer All rights reserved.</td>
            </tr>
            <tr>
              <td><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="2" height="10" /></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
