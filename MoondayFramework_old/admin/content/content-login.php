<?php error_reporting(E_ALL);
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
    <form name="loginFrm" action="<?php print $coreEngine->sRU; ?>?user=<?php print $_GET['user']; ?>" method="post">
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
            <td><input name="password" type="password" size="13" /></td>
          </tr>
          <tr>
            <td height="26">&nbsp;</td>
            <td><a href="#"><input name="submit_btn" type="image" alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/btn_login.gif" width="58" height="19" border="0" onclick="form.submit()" /></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="31" colspan="2" align="center" valign="middle" class="text_red"><a href='javascript:window.open ("admin-lostpassword/","adminPaswdRetrieval","status=0,location=0,menubar=0,resizable=0,height=200px,width=500px");'>Forget Your Password? </a></td>
        </tr>
    </table></form></td>
  </tr>