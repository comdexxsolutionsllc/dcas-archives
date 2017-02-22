<?
	include("ezMySQL.cls.lib.php");
	
	//$ezMySQL = new ezMySQL("mysql");
	$ezMySQL = new ezMySQL();
	
	if($_POST['Submit'])
	{
		$ezMySQL->dbConnect("root", "", $_POST['hdndbName']);
		$strmsg = $ezMySQL->UpdateSP($_POST['hdnSPName'], $_POST['txtSP']);
		$_REQUEST['dbName']=$_POST['hdndbName'];
		$_REQUEST['SPName']=$_POST['hdnSPName'];
	}
	
	if($_REQUEST['dbName']!="" || $_REQUEST['SPName']!="")
	{
		$ezMySQL->dbConnect("root", "", $_REQUEST['dbName']);
		$SPBody = $ezMySQL->ShowCreateSP($_REQUEST['SPName']);
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::ezMySQL::.ARiF</title>
<script src="ezmysql.js"></script>
<script type="text/javascript">
function validText()
{
	if(event.keyCode==34 || event.keyCode==39 || event.which==34 || event.which==39)
	{
		insertTags("`","","","txtSP");
		return false;
	}
}
</script>
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
    <td width="1%" height="8"></td>
    <td width="98%"></td>
    <td width="1%"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="10">
        
        <tr>
          <td width="100%" colspan="2" align="center" valign="top" bgcolor="#EEEEDD"><table width="100%" border="0" cellspacing="5" class="ContText12">
            <tr>
              <td width="100%" colspan="2" align="left"><div class="HeadText18"><strong>Update Stored Procedure</strong></div></td>
            </tr>
            
            
            <tr>
              <td colspan="2" align="center" valign="top"><form id="form1" name="form1" method="post" action="update_sp.php">
                <table width="100%" border="0" cellspacing="5" class="ContText12">
                  
                  <tr>
                    <td colspan="2" align="center" valign="top"><strong class="TitleText12">Message:</strong><strong class="TitleText12">[</strong>&nbsp;
                      <?= $strmsg; ?>                      <strong class="TitleText12"> ]</strong> </td>
                    </tr>
                  <tr>
                    <td align="right" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td width="19%" align="right" valign="top">Procedure:</td>
                    <td width="81%" align="left" valign="top"><textarea name="txtSP" cols="80" rows="20" class="ContText12" id="txtSP"><?= $SPBody; ?></textarea>
                    <br />
                        <br />
                        <input name="Submit" type="submit" class="button" value="Update" />
&nbsp;&nbsp;
<input name="btnReset" type="reset" class="button" id="btnReset" value="Reset" />
&nbsp;&nbsp;
<input name="btnResetOrigin" onclick="document.getElementById('txtSP').value=document.getElementById('hdnSPOrigin').value" type="button" class="button" id="btnResetOrigin" value="Reset With Original" />
&nbsp;&nbsp;
<input name="btnClose" onclick="window.close();" type="button" class="button" id="btnClose" value="  Close  " />
<input name="hdnSPName" type="hidden" id="hdnSPName" value="<?= $_REQUEST['SPName']; ?>" />
<input name="hdndbName" type="hidden" id="hdndbName" value="<?= $_REQUEST['dbName']; ?>" />
<textarea style="display:none" name="hdnSPOrigin" id="hdnSPOrigin" rows="5" cols="50"><? if(!$_POST['hdnSPOrigin']) echo $SPBody; else echo $ezMySQL->FormatText($_POST['hdnSPOrigin']); ?></textarea></td>
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
<? mysql_close; ?>