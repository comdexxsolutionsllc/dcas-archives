include("../autoresponse.class.php");
$respond=new autoresponse('vedanta@exampledomain.com','elephant','vedanta@exampledomain.com','mail.exampledomain.com');
$respond->connect();
$respond->send('url','html');
$respond->close_mailbox();