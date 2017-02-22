<?php
	include("ezMySQL.cls.lib.php");
	
	//$ezMySQL = new ezMySQL("mysql");
	$ezMySQL = new ezMySQL();
	
	if(isset($_POST['Submit']) or isset($_POST['txtdb']))
	{
		$ezMySQL->dbConnect("root", "", $_POST['txtdb']);
		$strmsg = $ezMySQL->CreateSP($_POST['txtSP']);
		$_POST['txtSP'] = $ezMySQL->FormatText($_POST['txtSP']);
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::ezMySQL::.ARiF</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body>

<table width="100%" border="0" cellspacing="0" bgcolor="#C5E2C5">
  <tr>
    <td width="1%" height="8">&nbsp;</td>
    <td width="98%"></td>
    <td width="1%"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="10">
        
        <tr>
          <td width="100%" colspan="2" align="center" valign="top" bgcolor="#EEEEDD"><table width="100%" border="0" cellspacing="5" class="ContText12">
            <tr>
              <td colspan="3" align="left"><div class="HeadText18"><strong>Stored Procedure Management</strong> (Create New) </div></td>
            </tr>
            <tr>
              <td align="left" valign="top"><a href="index.php" class="SPLink"><font size="4"><b>&lt;&lt; Back</b></font></a></td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="right" valign="top"><a href="help.html" target="_blank" class="SPLink"><font size="4"><b>Help</b></font></a></td>
            </tr>
            <tr>
              <td colspan="3" align="center" valign="top"><strong class="TitleText12">Message: [ </strong>
                <?php echo $strmsg; ?> <strong class="TitleText12">]</strong></td>
              </tr>
            <tr>
              <td align="left" valign="top">&nbsp;</td>
              <td colspan="2" align="left" valign="top"><div class="HeadText18"><strong><a href="view_sp_list_home.php" class="SPLink">Update Existing Stored Procedure</a></strong></div></td>
            </tr>
            
            <tr>
              <td width="11%" align="left" valign="top">&nbsp;</td>
              <td width="89%" colspan="2" align="left" valign="top"><div class="HeadText18"><strong class="TitleText12">Create Stored Procedure :</strong></div></td>
            </tr>
            <tr>
              <td colspan="3" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
                <table width="100%" border="0" cellspacing="5" class="ContText12">
                  
                  <tr>
                    <td align="right" valign="middle">Database(<span class="style1">*</span>):</td>
                    <td align="left" valign="top"><input name="txtdb" type="text" class="ContText14" id="txtdb" value="<?php echo  $_POST['txtdb']; ?>" size="50" /></td>
                  </tr>
                  
                  <tr>
                    <td width="18%" align="right" valign="top">Code:</td>
                    <td width="82%" align="left" valign="top"><textarea name="txtSP" cols="80" rows="15" class="ContText14" id="txtSP"><?php echo  $_POST['txtSP']; ?></textarea>
                      <br />
                        <br />
                        <input name="Submit" type="submit" class="button" value="Submit" />
                      &nbsp;&nbsp;
                        <input name="btnReset" type="reset" class="button" id="btnReset" value="Reset" /></td>
                  </tr>
                </table>
                            </form>              </td>
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