/* include the main class */
include("../autoresponse.class.php");
/* create a object of the class */ 
$respond=new autoresponse('vedanta@exampledomain.com','bulky','vedanta@exampledomain.com','mail.exampledomain.com'); 
/* connect to the mail server specified in the constructor */ 
$respond->connect();
/* set a autoresponse content to a file in the system*/
$respond->responseContentSource="/path/to/a/readable/file/in/your/system";
/* send out a html format file autoresponse and do not delete the mails in the mail server */ 
$respond->send('custom','html'); 
/* close the mailbox */ 
$respond->close_mailbox();