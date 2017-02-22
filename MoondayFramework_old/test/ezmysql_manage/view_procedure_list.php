<?php
	include("ezMySQL.cls.lib.php");
	$StrMsg = $_REQUEST['StrMsg'];
	
	$ezMySQL = new ezMySQL();
	
	//echo $_REQUEST['SPName'];
	if($_REQUEST['del']==1)
	{
	}
	
	if(isset($_POST['btnYes']))
	{
		$ezMySQL->dbConnect("root","",$_REQUEST['dbName']);
		$StrMsg = $ezMySQL->DropProcedure($_REQUEST['SPName']);
		header("Location: view_procedure_list.php?StrMsg=$StrMsg");
	}
	
	if(isset($_POST['btnNo']))
	{
		header("Location: view_procedure_list.php?No=1");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #EEEEDD;
}
-->
</style></head>

<body>
<div align="center">
<?php
if($_REQUEST['del']==1)
{
?>
<table width="100%" border="0" cellspacing="5" class="ContText12">
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><form id="form1" name="form1" method="post" action="">
      Are you sure, you want 
to delete the procedure [ <span class="TitleText12"><?php echo  $_REQUEST['SPName']; ?></span> ] <br />
<br />
<input name="btnYes" type="submit" class="button" id="btnYes" value="  Yes  " />&nbsp;&nbsp;
        <input name="btnNo" type="submit" class="button" id="btnNo" value="  No  " />
    </form>    </td>
  </tr>
 </table>
<?php
}else
{
	if($_POST['btnSeeSP']!="" || isset($_REQUEST['No']))
	{	
		//$_POST['spdbname']
		if($ezMySQL->mysql_v>=5)
		{
	?>
	<table width="95%" border="0" cellspacing="5" class="ContText12">
	  <tr>
		<td align="center"><div class="HeadText18"><strong>Procedure List </strong></div></td>
	  </tr>
	  <tr>
		<td align="center" valign="top"><?php echo $ezMySQL->ProcedureList("update_sp.php","view_procedure_list.php"); ?></td>
	  </tr>
	</table>
	<?php
		}else
		{
			echo "<br /><br /><br /><div class=\"TitleText12\">Your MySQL version does not support this feature.</div>";
		}
	}else
	{
	?>
	<br /><br /><br />
	<div align="center" class="ContText12"><?php echo  "<span class='TitleText12'>Message: </span>".$StrMsg; ?></div>
<?php
	}
}
?>
</div>
</body>
</html>
