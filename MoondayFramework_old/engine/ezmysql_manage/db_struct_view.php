<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?
	include("ezMySQL.cls.lib.php");

	$ezMySQL = new ezMySQL();
	
	$ezMySQL->dbConnect($_POST['username'], $_POST['password'], $_POST['dbname'], $_POST['hostname']);
	
	$ezMySQL->dbStructure();

?>
</body>
</html>
