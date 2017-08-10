<?php

//Composer's autoload file loads all necessary files

include_once ('includemailer/vendor/autoload.php');
include_once ('includemailer/config.php');

$mail = new PHPMailer;

$mail->isSMTP();  // Set mailer to use SMTP
$mail->Host = $mail_host;  // Specify mailgun SMTP servers
$mail->SMTPAuth = true; // Enable SMTP authentication
$mail->Username = $mail_uname; // SMTP username from https://mailgun.com/cp/domains
$mail->Password = $mail_pwd; // SMTP password from https://mailgun.com/cp/domains
$mail->SMTPSecure = 'tls';   // Enable encryption, 'ssl'
$mail->isHTML(true);   // Set email to be sent as HTML, if you are planning on sending plain text email just set it to false

?>
