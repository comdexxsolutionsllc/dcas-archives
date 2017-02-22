<?php if(!@$_SESSION['loggedin']) header("Location: logout.php"); ?>
<!-- Start Page::View(transactionstatus-mainpanel) -->
<table border="0" p_border="1" cellpadding="0" cellspacing="0" width="210">
  <tr>
    <td class="bg_fixed" align="left" background="<?php echo $coreEngine->sRU; ?>/admin/images/customer-login_heading_bg4.gif" height="32" valign="top"><span class="text_login_h"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/spacer.gif" height="20" width="16"></img>Transaction status</span> </td>
  </tr>
  <tr>
    <td class="bg_fixed_repeat_y" align="left" background="<?php echo $coreEngine->sRU; ?>/admin/images/customer-login_headingline_bg3.gif" valign="middle"><table align="center" border="0" p_border="1" cellpadding="0" cellspacing="0" width="200">
        <tr>
          <td class="text_login_h_grey_smallsa" align="left" height="130" valign="top" width="195"><table class="text_login_h2_2" border="0" p_border="1" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td align="left" valign="middle" width="0"><p> <img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/bullet-green2.gif" height="14" width="11"></img>Pending Assignment:<br />
                </p></td>
                <td align="left" width="39"><a href="">0</a></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/bullet-green2.gif" height="14" width="11"></img>Pending Charges:<br /></td>
                <td align="left"><a href="">0</a></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/bullet-green2.gif" height="14" width="11"></img>Overdue: **<br /></td>
                <td align="left"><a href="">1</a></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/bullet-green2.gif" height="14" width="11"></img>Running:<br /></td>
                <td align="left"><a href="">5</a></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/bullet-green2.gif" height="14" width="11"></img>Total:</td>
                <td align="left"><a href="">5</a></td>
              </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td class="bg_fixed" align="left" background="<?php echo $coreEngine->sRU; ?>/admin/images/customer-login_btm_bg3.gif" height="31" valign="top"></td>
  </tr>
</table>
<!-- End Page::View(transactionstatus-mainpanel) -->