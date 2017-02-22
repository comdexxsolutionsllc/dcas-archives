<html>
<head>
<style>
body,td{
	font-family:"verdana";
	font-size:11px;
}
</style>
</head>
<body>
<table style='border:1px solid #99CC00' align='center' width='70%'><tr><td>
<?php
	
	require("rssweather.inc.php");
	
	$weather=new WEATHER();	

	$url=urldecode($_GET['url']); 
	if(!empty($url))
		$weather->setURL($url);
	$weather->getWeather();
	if(!$weather)
		echo $weather->error();
	$weather->printList();
?>
</td></tr></table>
</body>
</html>