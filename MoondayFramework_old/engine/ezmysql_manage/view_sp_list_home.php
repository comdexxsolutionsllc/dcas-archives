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
          <td colspan="2" align="center" valign="top" bgcolor="#EEEEDD"><table width="100%" border="0" cellspacing="5" class="ContText12">
            <tr>
              <td colspan="2" align="left"><div class="HeadText18"><strong>Stored Procedure Management</strong> (View and Update) </div></td>
            </tr>
            <tr>
              <td width="89%" align="left" valign="top"><a href="sp_manage.php" class="SPLink"><font size="4"><b>&lt;&lt; Back</b></font></a><font size="4" color="#FF0000">&nbsp;&nbsp;::&nbsp;</font><a href="index.php" class="SPLink">&nbsp;<font size="4"><b>Home</b></font></a></td>
              <td width="11%" align="right" valign="top"><a href="help.html" target="_blank" class="SPLink"><font size="4"><b>Help</b></font></a></td>
            </tr>
            

          </table></td>
        </tr>
        <tr>
          <td width="50%" align="center" valign="top" bgcolor="#EEEEDD">
		  <form id="frmProcedure" name="frmProcedure" method="post" action="view_procedure_list.php" target="spview">
            <table width="100%" border="0" cellspacing="5" class="ContText12">
              
              
              <tr>
                <td height="100" align="center" valign="middle">&nbsp;</td>
                </tr>
              
              <tr>
                <td align="center" valign="top"><div class="TitleText12"><strong>View Stored Procedures : </strong></div></td>
              </tr>
              <tr>
                <td align="center" valign="top"><input name="btnSeeSP" type="submit" class="button" id="btnSeeSP" value="  See &gt;&gt;  " />
                  <input name="hdndbname" type="hidden" id="hdndbname" />
                  <input name="hdnspname" type="hidden" id="hdnspname" /></td>
                </tr>
            </table>
            </form>          </td>
          <td width="50%" align="center" valign="top" bgcolor="#EEEEDD">
          <iframe name="spview" width="100%" style="border:0;" height="420" src="view_procedure_list.php">&nbsp;</iframe></td>
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