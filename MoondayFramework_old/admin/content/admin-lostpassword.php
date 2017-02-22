<?php session_start(); ob_start();
if(!@$_SESSION['loggedin']) header("Location: logout.php");

/* Include for login to work */
require_once('../../engine/coreEngine.php');
$coreEngine = new coreEngine;
$coreEngine->init();

//*** Connects to MySQL server.
$coreEngine->dbObject->connect(configObject::$database_host, configObject::$database_user, configObject::$database_pass, configObject::$database);
?>

<html>



<head><title>Lost Username/Password</title></head>


<body>
<p class="bodytext16px"><span class="bodytext16pxbold"><center><b>Forgotten Password</b></center></span></p>
<p class="bodytext12px"><center><b>To obtain a new password, please enter your e-mail address and a link will be emailed to you.</b></center></p>

<table width="90%" align="center" bgcolor="#a5aeb5" border="0" cellpadding="12" cellspacing="1">
	<tbody><tr>
		<td bgcolor="#efebef">
			<table>
				<tbody><tr>
				<form name="AdminLostPasswordfrm" method="post" action=<?php echo $_SERVER['PHP_SELF']; ?>>

					<td bgcolor="#efebef"><p class="textBoldBrown12px"><b>E-mail address&nbsp;</b></p></td>
					<td bgcolor="#efebef"><input size="35" value="" name="userId" type="text"></td>
					<td bgcolor="#efebef">&nbsp;<input alt="Send" type="submit" name="Send"></td>
				</form>
				</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>
</body>

</html>




<?php

if(!empty($_POST['userId']) && isset($_POST['Send']))
{
	// Do Retrieval Stuff
	if($coreEngine->userObject->lookupUser($_POST['userId']))
	{
		$coreEngine->retrievePasswordObject->sendResetEmail(); // Send E-mail
	}
}

?>