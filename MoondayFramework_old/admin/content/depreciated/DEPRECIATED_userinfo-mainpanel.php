<!-- Start Page::View(userinfo-mainpanel) -->
<table width_was="0" align="center" border="0" cellpadding="0" cellspacing="0" height="542" width="1258">
  <tr>
    <td align="left" valign="top" width="210"><table border="0" cellpadding="0" cellspacing="0" width="210">
      <tr>
        <td class="bg_fixed" align="left" background="/managedNOC/admin/images/customer-login_heading_bg4.gif" height="32" valign="top"><span class="text_login_h"><img alt="" src="/managedNOC/admin/images/spacer.gif" height="20" width="16"></img>User Information </span> </td>
      </tr>
      <tr>
        <td class="bg_fixed_repeat_y" align="left" background="/managedNOC/admin/images/customer-login_headingline_bg3.gif" valign="middle"><table align="center" border="0" cellpadding="0" cellspacing="0" width="195">
          <tr>
            <td class="text_login_h_grey_smallsa" height="160" width="195"><img alt="" src="/managedNOC/admin/images/bullet-green.gif" height="9" width="19"></img><strong>Active User:</strong> <span class="style1"><strong>John Smith</strong></span> <br />

                <img alt="" src="/managedNOC/admin/images/bullet-green.gif" height="9" width="19"></img><strong>Assigned Tickets:</strong> <span class="style1">0</span><br />
                <img alt="" src="/managedNOC/admin/images/bullet-green.gif" height="9" width="19"></img><strong>Yellow Tickets:</strong> <span class="style1">0</span><br />
                <img alt="" src="/managedNOC/admin/images/bullet-green.gif" height="9" width="19"></img><strong>Date:</strong> <span class="style1"><?php $lt = localtime(); echo ($lt[4]+1),'/',$lt[3],'/',($lt[5]+1900)," $lt[2]:$lt[1]"; ?></span><br />
                <img alt="" src="/managedNOC/admin/images/bullet-green.gif" height="9" width="19"></img><strong>TZ:</strong> <span class="style1"><?php echo date_default_timezone_get(); ?></span> <br />

                <img alt="" src="/managedNOC/admin/images/bullet-green.gif" height="9" width="19"></img><strong>ChangeLog:</strong> <span class="style1">ChangeLog (0)</span> <br />
                <br />
                <img alt="" src="/managedNOC/admin/images/bullet-green.gif" height="9" width="19"></img><strong class="style1"><a href="/managedNOC/user.admin/page/forum/action/login/">Forum Login</a></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img alt="" src="/managedNOC/admin/images/bullet-green.gif" height="9" width="19"></img> <strong class="style1"><a href="/managedNOC/user.admin/page/logout/">Logout</a></strong> </td>
          </tr>
        </table></td>

      </tr>
      <tr>
        <td class="bg_fixed" align="left" background="/managedNOC/admin/images/customer-login_btm_bg3.gif" height="31" valign="top"></td>
      </tr>
    </table>
<!-- End Page::View(userinfo-mainpanel) -->