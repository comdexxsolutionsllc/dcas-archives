<?php
/* include the main class */
include("../autoresponse.class.php");
/* create a object of the class */
$respond=new autoresponse('joshuastevenabbott@gmail.com','ImaCowsertjoshua','joshuastevenabbott-noreply@gmail.com','imap.gmail.com', 'imap', '993');
/* connect to the mail server specified in the constructor */
$respond->connect();
/* set a autoresponse content */
$respond->responseContentSource="This is a response to your mail!";
/* send out a html format custom autoresponse and delete all the mails in the mail server */
$respond->send('custom','html',true);
//* close the mailbox */
$respond->close_mailbox();
?>