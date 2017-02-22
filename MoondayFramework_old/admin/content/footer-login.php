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
  <tr >
    <td height="81" valign="bottom" background="<?php echo $coreEngine->sRU; ?>admin/images/login_slic_bt.gif" class="bg_fixed"><table width="400" border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" class="text_rights">Copyrights &copy; 2008 MyDediServer All rights reserved.</td>
      </tr>
      <tr>
        <td><img alt="" src="<?php echo $coreEngine->sRU; ?>admin/images/spacer.gif" width="2" height="10" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

<?php require_once('./terminate-coreEngine.php'); // Terminate coreEngine Class ?>