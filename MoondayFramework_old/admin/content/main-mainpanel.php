<?php if(!@$_SESSION['loggedin']) header("Location: logout.php"); ?>
<!-- Not being used -->
<!-- Start Page::View(main-mainpanel) -->

            <tr>
              <td>
              &nbsp;

               </td></tr><tr>
              <td class="text_login_h2_grey" height="45">Search:
                <select name="select" class="text_login_h2">
                  <option>Department</option>

                </select>
                For:
                <input name="textfield" class="text_login_h2" value="Billing" type="text">
                With status:
                <select name="select3" class="text_login_h2">
                  <option>All</option>
                </select>
                &nbsp;<img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/btn_search.gif" align="absmiddle" height="18" width="52"></img> <span class="text_login_h3_RED">Advanced Search! </span></td>
            </tr>

            <tr>
              <td><table border="0" cellpadding="0" cellspacing="0" width="747">
                <tr>
                  <td class="text_login_h" background="images/customer-login_heading_bg6.gif" height="36"><img alt="" src="<?php echo $coreEngine->sRU; ?>/admin/images/spacer.gif" height="2" width="10"></img>Ticket Search (1)</td>
                </tr>
                <tr>
                  <td bgcolor="lightgrey" height="100"><table width_was="90%" align="left" border="0" cellpadding="0" cellspacing="5" width="100%">

                    <tr>
                      <td class="text_login_h3_RED" width="4%">&nbsp;</td>
                      <td class="text_login_h2" width="17%">######</td>
                      <td class="text_login_h2" width="17%">Amount: 10000 $ </td>
                      <td class="text_login_h2" width="36%">Created: 2008-Feb-26 09:48 (GMT-0600)</td>
                      <td class="text_login_h2" width="13%">Status : Open </td>
                      <td class="text_login_h3_RED" width="13%">[Preview]</td>


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

                    </table></td></tr></table>

              </td>
            </tr>
          </table>
<!-- End Page::View(main-mainpanel) -->