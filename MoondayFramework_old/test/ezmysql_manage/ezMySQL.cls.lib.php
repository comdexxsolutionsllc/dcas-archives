<?php
/***************************************************************************
 *                   ------- ezMySQL.cls.lib.php --------
 *--------------------------------------------------------------------------
 *
 *		Author				: S. M. ARIFUL ISLAM
 *		Email				: arif_look@yahoo.com
 *		Contact				: +88-0152344105
 *		Country				: Bangladesh
 *		Begin				: Thursday, Feb 15, 2007
 *		Website				: www.bsourcing.com
 *		Check updates at	: www.bsourcing.com/developers/classes/
 *
 ***************************************************************************/

class ezMySQL //Easy MySQL Administration Class Library.
{
	var $apache;		//Store apache server information
	var $php;			//Store php inforation
	var $mysql_v_full;	//MySQL version information(full)
	var $mysql_v;		//MySQL version information without floating point
	var $strLink;		//Database connection string
	var $dbname;		//Store current database name

	//Constructor.
	function ezMySQL($dummyuser="", $dummypass="")
	{
		$dummyuser	=	(!$dummyuser)	?	"root"	: $dummyuser;
		$dummypass	=	(!$dummypass)	?	"a8DPKCC5KJPrVtn"		: $dummypass;
		$link=mysql_connect("localhost", $dummyuser, $dummypass); //Dummy connection to MySQL.
		$this->apache=apache_get_version();
		$this->php=phpversion();
		$this->mysql_v_full=mysql_get_server_info();//Get MySQL Version Information(full).
		$this->mysql_v=(int)mysql_get_server_info();//Get MySQL Version without floating point.
		$this->strLink = $link;
	}//End method.
	
	//Establish a connection with MySQL database.
	function dbConnect($user="", $pass="", $dbname="", $host="")
	{
		//Prepare connection requirements.
		$UserName	= (!$user)		? "root"		: $user;
		$Password	= (!$pass)		? "a8DPKCC5KJPrVtn"			: $pass;
		$DbName		= (!$dbname)	? die("You should specify a database name.")	: $dbname;
		$HostName	= (!$host)		? "localhost"	: $host;
		
		//Connect to the MySQL Server.
		$this->strLink = @mysql_pconnect($HostName, $UserName, $Password) or die("Could Not Connect Database.");
		//Selection of given database.
		@mysql_select_db($DbName, $this->strLink) or die(mysql_error());
		$this->dbname = $dbname;
	}//End method.
	
	//Get table structures of a database.
	function dbStructure()
	{
		$tables = mysql_list_tables($this->dbname);
		$num_tables = mysql_num_rows($tables);
		
		//Select the current Database and Print.
		$row=mysql_fetch_row(mysql_query("SELECT DATABASE()"));
		echo "<br />";
		echo "<span class='HeadText18'><b>Database Name:</b></span><span class='ContText14'> [ ".$row[0]." ]</span>";
		echo "<br /><br />";
	
		$i = 0;
		while($num_tables > $i)
		{
			//Get Table name from array;
			$TableName = mysql_tablename($tables, $i);
			$fields = mysql_db_query($this->dbname, "SHOW FIELDS FROM ".$TableName) or die(mysql_error());
			$output .= "<table class='ContText14' border=1 width=650 bordercolor='#C5E2C5'>";
			$output .= "<tr bgcolor='#C5E2C5'><td colspan=6>&nbsp;<b>Table Name:</b> ".$TableName."</td></tr>";
			$output .= "<tr><td height=5 colspan=6></td></tr>";
			$output .= "<tr bgcolor='#EEEEDD'>"
							."<td>&nbsp;<b>Field Name</b></td>"
							."<td>&nbsp;<b>Type</b></td>"
							."<td>&nbsp;<b>Null</b></td>"
							."<td>&nbsp;<b>Key</b></td>"
							."<td>&nbsp;<b>Default</b></td>"
							."<td>&nbsp;<b>Extra</b></td>"
						."</tr>";
			
			//Get column content.
			while($row=mysql_fetch_array($fields))
			{
				$output .="<tr bgcolor='#EEEEDD'>"
							."<td>&nbsp;".$row["Field"]."</td>"
							."<td>&nbsp;".$row["Type"]."</td>"
							."<td>&nbsp;".$row["Null"]."</td>"
							."<td>&nbsp;".$row["Key"]."</td>"
							."<td>&nbsp;".$row["Default"]."</td>"
							."<td>&nbsp;".$row["Extra"]."</td>"
						."</tr>";
			}
			
			$output .="</table><br /><br />";
	
			$i++;
		}
	
		echo $output;
	}//End method.
	
	//Get Stored Procedure list.
	//Here--
	//	$UpdateFile = File name with extension (i.e, page.php) from which page you will call the method - UpdateSP().
	//	$ThisPage	= File name with extension (i.e, page.php) from which page you called this method.
	function ProcedureList($UpdateFile="", $ThisPage="")
	{
		$sql="SHOW PROCEDURE STATUS";
		$result=mysql_query($sql, $this->strLink);
		
		$html_out= "<table width=90% border=1 bordercolor=#FFFFFF style='border-collapse:collapse'><tr>"
						."<td width=10% class='TitleText12' align='center'>SL.</td>"
						."<td width=30% class='TitleText12' align='left'>&nbsp;&nbsp;Database</td>"
						."<td width=40% class='TitleText12' align='left'>&nbsp;&nbsp;Procedure (Update)</td>";
		if($ThisPage!="")
			$html_out	.="<td width=20% class='TitleText12' align='center'>Delete</td>";
			
			$html_out	.="</tr>";
			
		if(mysql_num_rows($result)>0)
		{
			$sl=0;
			while($row = mysql_fetch_row($result))
			{
				$sl++;
				$html_out .="<tr>";
				$html_out .="<td height=20 class='TitleText12' align='center'>".$sl.".</td>";
				$html_out .="<td align='left'>&nbsp;&nbsp;".$row[0]."</td>";
				$html_out .="<td align='left'>&nbsp;&nbsp;<a class=\"SPLink\" href=\"$UpdateFile?dbName=".$row[0]."&&SPName=".$row[1]."\" target=\"_blank\">".$row[1]."</a></td>";
				if($ThisPage!="")
					$html_out .="<td align='center'><a href='$ThisPage?del=1&&dbName=".$row[0]."&&SPName=".$row[1]."' class='SPLink'><b>Delete</b></a></td>";
				
				$html_out .="</tr>";
			}
		}else
		{
			$row=mysql_fetch_row($result);
				$html_out .="<tr><td class='TitleText12'>Procedure list is empty.</td></tr>";
		}
		$html_out .= "</table>";
		
		return $html_out;
	}//End method.
	
	//Here, first drop the existing procedure. Then Create a new procedure.
	//Here--
	//		$SPName = Stored Procedure Name
	//		$SPBody = Full stored procedure code.
	function UpdateSP($SPName, $SPBody)
	{
		mysql_query("DROP PROCEDURE IF EXISTS ".$SPName);
		$result=mysql_query($SPBody);
		if($result)
		{
			return "Stored procedure updated successfully.";
		}else
		{
			return mysql_error();
		}
	}//End method.
	
	//Create a new stored procedure.
	//Here, $SPBody = Full stored procedure code.
	function CreateSP($SPBody="")
	{
		if($this->mysql_v>=5) //Check mysql version
		{
			if($SPBody!="")
			{	
				$SPBody = $this->FormatText($SPBody);
				$result = mysql_query($SPBody);
				if($result)
				{
					$strmsg = "Procedure created successfully.";
					return $strmsg;
				}else
				{
					return mysql_error();
				}
			}else
			{
				mysql_close($this->strLink);
				$strmsg = "Your procedure code is empty.";
				return $strmsg;
			}
		}else
		{
				$strmsg = "Could not create PROCEDURE. Please check your MySQL version and other features.";
				return $strmsg;
		}
	}//End method.
	
	//Drop stored procedure
	//Here, $SPName = Stored Procedure Name
	function DropProcedure($SPName)
	{
		$result = mysql_query("DROP PROCEDURE ".$SPName);
		if($result)
		{
			mysql_close($this->strLink);
			return "The procedure [ ".$SPName." ] droped successfully";
		}
		else
			return mysql_error();
	}//End method.
	
	//Show the code of a Stored Procedure
	//Here, $SPName = Stored Procedure Name
	function ShowCreateSP($SPName)
	{
		$result=mysql_query("SHOW CREATE PROCEDURE ".$SPName);
		if($result)
		{
			$row = mysql_fetch_row($result);
			mysql_close($this->strLink);
			return $this->FormatText($row[2]);
		}else
		{
			return mysql_error();
		}
	}//End method.
	
	//Eliminate single coat('), dubble coat(") and back-slash(\) from String.
	function FormatText($txt)
	{
		$formated = str_replace("\\", "", $txt); //Exclude (\)
		return $formated;
	}
}
?>