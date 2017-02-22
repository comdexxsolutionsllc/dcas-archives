#!/usr/bin/php
<?php

# in linux this script needs +x (exec permission)

/* this script will call the autoresponder from the console */

/* customize to your requirements */
$USERNAME='joeward';
$PASSWORD='password';
$RESPONSE_EMAIL='joeward@example.com';
$MAIL_SERVER='mail.example.com';
$SERVER_TYPE='pop'	# alternate is imap
$PORT='110';		# 143 for imap
$RESPONSE_TYPE='custom'	# alternate is file and url

/* a simple custom autoresponse message! */
$message="Your auto-response message goes here!\r\n";

/* include the class file */
include("../autoresponse.class.php");
/* create a object of the class */
$r=new autoresponse($USERNAME,$PASSWORD,$RESPONSE_EMAIL,$MAIL_SERVER,$SERVER_TYPE,$PORT);
/* connect to the server */
$r->connect();
/* set the response message */
$r->responseContentSource="$message";
/* send the response mails - text mail not purged from the server */
$r->send('custom','text');
/* close the mailbox */
$r->close_mailbox();

?>