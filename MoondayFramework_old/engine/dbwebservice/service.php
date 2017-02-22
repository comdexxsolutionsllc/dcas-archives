<?php
// Test for DBService
	$SCRIPT_URL="http://".$_SERVER["SERVER_NAME"].($_SERVER["SERVER_PORT"]!="80"?":".$_SERVER["SERVER_PORT"]:"").$_SERVER["SCRIPT_NAME"];
	
	define ("SERVICE_NAME","DB");
	define ("SERVICE_LOCATION",$SCRIPT_URL);
	define ("SCRIPT_URL",$SCRIPT_URL);
	define ("TARGETNAMESPACE",$SCRIPT_URL);
	define ("SOURCENAMESPACE",$SCRIPT_URL);
	
	
	require_once ("db.inc.php");
	require_once ("domain.php");
	require_once ("DBWebService.php");
	require_once ("handle_request.php");
	
	header("Content-type: text/xml");
   	ob_start();
	echo "<"."?"."xml version=\"1.0\""."?".">";

	if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST') { 
		service($HTTP_RAW_POST_DATA); 
	} else { 
		if (isset($_SERVER['QUERY_STRING']) && strcasecmp($_SERVER['QUERY_STRING'],'wsdl') == 0) { 
			echo getWSDL(); 
		} else { 
?><disco:discovery xmlns:disco="http://schemas.xmlsoap.org/disco/" xmlns:scl="http://schemas.xmlsoap.org/disco/scl/">
<scl:contractRef ref="<?php echo $SCRIPT_URL ?>?wsdl" />
</disco:discovery><?php
		}
	}
	
	$output = ob_get_contents();
   	ob_end_clean();

	$fp = fopen("debug.txt","wb");
	fwrite($fp,"URL:".$SCRIPT_URL."\n");
	fwrite($fp,"QUERY_STRING:".@$_SERVER['QUERY_STRING']."\n");
	fwrite($fp,"request:\n--------\n".@$HTTP_RAW_POST_DATA);
	fwrite($fp,"response:\n--------\n".$output);
	fclose($fp);
	
	die ($output);
	
?>
