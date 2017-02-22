<?php if(!@$_SESSION['loggedin']) header("Location: logout.php"); ?>
<!-- Start Page::View(welcome-mainpanel) -->
                <tr>
                  <td colspan="3" valign="top"><table width="100%"  border="0" p_border="1" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="4" style=" background-image:url(<?php echo $coreEngine->sRU; ?>/admin/images/bg_mid_strip.jpg); background-repeat:repeat-y; background-position:left;">&nbsp;</td>
                      <td width="775" valign="top" class="welcome_text">Welcome to the Employee Managment Portal</td>
                      <td width="4" style=" background-image:url(<?php echo $coreEngine->sRU; ?>/admin/images/bg_mid_strip.jpg); background-repeat:repeat-y; background-position:right;">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>

<!-- End Page::View(welcome-mainpanel) -->