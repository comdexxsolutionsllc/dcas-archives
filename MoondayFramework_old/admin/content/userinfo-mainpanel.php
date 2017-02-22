<?php if(!@$_SESSION['loggedin']) header("Location: logout.php"); ?>
<!-- Start Page::View(userinfo-mainpanel) -->
<table p_border="1" align="center" border="0" cellpadding="0" cellspacing="0" width="95%">
  <tbody><tr>
    <td><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/spacer.gif" width="2" height="10">
      <table p_border="1" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr>
          <td><table p_border="1" border="0" cellpadding="0" cellspacing="0" width="100%">

            <tbody><tr>
              <td width="210" height="27"><table p_border="1" border="0" cellpadding="0" cellspacing="0" width="210">
  <tbody><tr>
    <td class="bg_fixed" align="left" background="<?php echo $coreEngine->sRU; ?>/admin/images/customer-login_heading_bg4.gif" valign="top" height="32"><span class="text_login_h"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/spacer.gif" width="16" height="20">User Information </span> </td>
  </tr>
  <tr>
    <td class="bg_fixed_repeat_y" align="left" background="<?php echo $coreEngine->sRU; ?>/admin/images/customer-login_headingline_bg3.gif" valign="middle"><table p_border="1" align="center" border="0" cellpadding="0" cellspacing="0" width="195">
        <tbody><tr>

          <td class="text_login_h_grey_smallsa" width="195" height="160"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/bullet-green.gif" width="19" height="9"><strong>Active User:</strong> <span class="style1"><strong><?php echo $coreEngine->userObject->displayFullName('admin'); ?></strong></span> <br>
              <img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/bullet-green.gif" width="19" height="9"><strong>Assigned Tickets:</strong> <span class="style1"><?php echo $coreEngine->ticketObject->showAssignedTicketsCOUNT(); ?></span><br>
              <img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/bullet-green.gif" width="19" height="9"><strong>Yellow Tickets:</strong> <span class="style1"><?php echo $coreEngine->ticketObject->showYellowTicketsCOUNT(); ?></span><br>
              <img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/bullet-green.gif" width="19" height="9"><strong>Date:</strong><span class="style1"><?php $coreEngine->timeObject->showDate(); ?></span><span id="CountDownPanel"></span><br>

              <img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/bullet-green.gif" width="19" height="9"><strong>TZ:</strong> <span class="style1"><?php $coreEngine->timeObject->showTimeZone(); ?></span> <br>
              <img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/bullet-green.gif" width="19" height="9"><strong>ChangeLog:</strong> <span class="style1">ChangeLog (<a href="https://localhost/<?php echo $coreEngine->sRU; ?>/admin/images/user.admin/page/changelog/">0</a>)</span> <br>
              <br>
              <img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/bullet-green.gif" width="19" height="9"><strong class="style1"><a href="https://localhost/<?php echo $coreEngine->sRU; ?>/admin/images/user.admin/page/forum/action/login/">Forum Login</a></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/bullet-green.gif" width="19" height="9"> <strong class="style1"><a href="https://localhost/<?php echo $coreEngine->sRU; ?>/admin/images/user.admin/page/logout/">Logout</a></strong> </td>

        </tr>
    </tbody></table></td>
  </tr>
  <tr>
    <td class="bg_fixed" align="left" background="<?php echo $coreEngine->sRU; ?>/admin/images/customer-login_btm_bg3.gif" valign="top" height="31"></td>
  </tr>
</tbody></table>
<!-- End Page::View(userinfo-mainpanel) -->
