<?php
// Test Paypal IPN
$f = fopen("what_server_receives.txt", "a");

while( list($key, $val) = each ($_POST))
{
	fwrite ($f, "$key = $val\n");
}
fwrite ($f, str_repeat("-", 80)."\n");

fclose($f);

// if the POST doesn't contain cmd variable, return INVALID
if($_POST["cmd"]!="_notify-validate")
{
	print "INVALID";
}

// otherwise, return random answer
print rand(0,1)?"VERIFIED":"INVALID";

?>