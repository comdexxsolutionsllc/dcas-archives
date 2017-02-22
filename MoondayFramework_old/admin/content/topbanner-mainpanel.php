<?php if(!@$_SESSION['loggedin']) header("Location: logout.php"); ?>
<!-- Start Page::View(topbanner-mainpanel) --> <!-- <?php echo $coreEngine->sRU; ?>/admin/images/ -->
<table p_border="1" align="center" border="0" cellpadding="0" cellspacing="0" width="95%">
  <tbody><tr>
    <td class="bg_fixed" background="<?php echo $coreEngine->sRU; ?>/admin/images//header_left_slice.gif" width="13" height="97"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images//spacer.gif" width="13" height="8"></td>

    <td background="<?php echo $coreEngine->sRU; ?>/admin/images//header_bg_slice.gif"><table p_border="1" border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody><tr>
        <td width="33%"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images//logo.gif" width="265" height="50"></td>

        <td width="67%"><table p_border="1" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody><tr>
            <td width="50%" height="58"><table p_border="1" align="left" border="0" cellpadding="0" cellspacing="0" width="300">
              <tbody><tr>
                <td align="center" width="70"><a href="https://localhost/managedNOC/user.admin/page/home/"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images//btn_home.gif" border="0" width="36" height="30"></a></td>
                <td align="center" width="70"><a href="http://mydediserver.com/#redirect__panel"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images//btn_mydediserver.gif" border="0" width="82" height="30"></a></td>

                <td align="center" width="70"><a href="https://localhost/managedNOC/user.admin/page/support/"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images//btn_support.gif" border="0" width="53" height="30"></a></td>
                <td align="center" width="70"><a href="https://localhost/managedNOC/user.admin/page/mini/"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images//btn_mini.gif" border="0" width="28" height="30"></a></td>

                <td align="center" width="70"></td>
              </tr>
            </tbody></table></td>
            <td width="50%"><table p_border="1" align="center" border="0" cellpadding="0" cellspacing="0" width="84%">
              <tbody><tr>
                <td class="text_login_h" height="27">Search :
                  <input name="textfield3" class="text_login_h_blue" type="text">

                  <a href="#"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images//btn_search.gif" border="0" width="52" height="18"></a></td>
              </tr>

              <tr>
                <td class="text_login_h_green" height="26">For Advanced Search! </td>
              </tr>
              <tr>
                <td height="29">
                <select name="quick_search_type" class="text_login_h2_grey" tabindex="2">
                    <option selected="selected" value="0">Ticket - Ticket Id      </option>
                    <option value="1">Ticket - Account Id     </option>

                    <option value="4">Ticket - Company Name   </option>
                    <option value="2">Ticket - Title          </option>
                    <option value="3">Ticket - Content        </option>
                    <option value="10">Customer - Account Id  </option>
                    <option value="11">Customer - Company Name</option>
                    <option value="12">Customer - Username    </option>

                    <option value="13">Customer - Email       </option>
                    <option value="20">Hardware - ID          </option>
                    <option value="21">Hardware - Hostname    </option>
                    <option value="22">Hardware - Domain      </option>
                    <option value="23">Hardware - Account ID  </option>
                    <option value="24">Hardware - IP Address  </option>

            	</select>

                </td>
              </tr>
            </tbody></table></td>
          </tr>
        </tbody></table></td>
      </tr>
    </tbody></table></td>
    <td class="bg_fixed" background="<?php echo $coreEngine->sRU; ?>/admin/images//header_right_slice.gif" width="13" height="97"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images//spacer.gif" width="13" height="1"></td>

  </tr>
</tbody></table>
<!-- End Page::View(topbanner-mainpanel) -->
