<?php
// the message
$msg = "This is a test email\nTHis is the 2nd line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("harshvardhanpoojary@gmail.com","Test Email",$msg);
echo 'reached here';
?>