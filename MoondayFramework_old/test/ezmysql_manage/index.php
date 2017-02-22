<?php
	include("ezMySQL.cls.lib.php");
	
	//$ezMySQL = new ezMySQL("mysql");
	$ezMySQL = new ezMySQL();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::ezMySQL::.ARiF</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" bgcolor="#C5E2C5">
  <tr>
    <td width="1%" height="8"></td>
    <td width="98%"></td>
    <td width="1%"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="10">
        <tr>
          <td width="50%" align="center" valign="top" bgcolor="#EEEEDD">
		  <form id="frmDbStructure" name="frmDbStructure" method="post" target="_blank" action="db_struct_view.php">
            <table width="100%" border="0" cellspacing="5" class="ContText12">
              <tr>
                <td colspan="2" align="center" valign="top"><div class="HeadText18"><strong>View Database Structure </strong></div></td>
              </tr>
              <tr>
                <td align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="middle">Host Name: </td>
                <td align="left" valign="middle"><input name="hostname" type="text" id="hostname" value="localhost" size="30" /></td>
              </tr>
              <tr>
                <td align="right" valign="middle">DB Name:                  </td>
                <td align="left" valign="middle"><input name="dbname" type="text" id="dbname" size="30" /></td>
              </tr>
              <tr>
                <td align="right" valign="top">User Name: </td>
                <td align="left" valign="top"><input name="username" type="text" id="username" size="30" /></td>
              </tr>
              <tr>
                <td align="right" valign="top">Password:</td>
                <td align="left" valign="top"><input name="password" type="password" id="password" size="30" /></td>
              </tr>
              <tr>
                <td align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="Submit" type="submit" class="button" id="Submit" onclick="addRow()" value="  Submit  " /></td>
              </tr>
            </table>
            </form>          </td>
          <td width="50%" align="center" valign="top" bgcolor="#EEEEDD"><table width="100%" border="0" cellspacing="5" class="ContText12">
            <tr>
              <td colspan="3" align="center"><div class="HeadText18"><strong>Local System Information</strong></div></td>
            </tr>
            <tr>
              <td align="right" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
            <tr>
              <td width="17%" align="right" valign="top" class="TitleText12">Apache</td>
              <td width="3%" align="left" valign="top" class="TitleText12">:</td>
              <td width="80%" align="left" valign="top"><?php echo $ezMySQL->apache; ?></td>
            </tr>
            <tr>
              <td align="right" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
            <tr>
              <td align="right" valign="top" class="TitleText12">PHP</td>
              <td align="left" valign="top" class="TitleText12">:</td>
              <td align="left" valign="top"><?php echo $ezMySQL->php; ?></td>
            </tr>
            <tr>
              <td align="right" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
            <tr>
              <td align="right" valign="top" class="TitleText12">MySQL</td>
              <td align="left" valign="top" class="TitleText12">:</td>
              <td align="left" valign="top"><?php echo  $ezMySQL->mysql_v_full; ?></td>
            </tr>
            
            
          </table>            </td>
        </tr>
        <tr>
          <td colspan="2" align="center" valign="top" bgcolor="#EEEEDD"><table width="100%" border="0" cellspacing="5" class="ContText12">
            <tr>
              <td height="60" colspan="3" align="center">&nbsp;</td>
            </tr>
            
            <tr>
              <td width="20%" align="center">&nbsp;</td>
              <td width="60%" align="center"><div class="HeadText18"><strong>Switch to - Stored Procedure Management</strong></div></td>
              <td width="20%" align="center">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" align="center" valign="top">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" align="center" valign="top"><input name="btnSwitch" type="button" class="button" id="btnSwitch" onclick="window.location='sp_manage.php'" value="  Switch  " /></td>
              </tr>
            <tr>
              <td height="60" colspan="3" align="center" valign="top">&nbsp;</td>
            </tr>
            

          </table></td>
        </tr>
        
        
      </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="8"></td>
    <td></td>
    <td></td>
  </tr>
</table>
</body>
</html>
<?php mysql_close; ?>