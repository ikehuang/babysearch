<?php
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->SMTPDebug = 3;
$mail->isSMTP();
$mail->Host = 'email-smtp.us-west-2.amazonaws.com';
$mail->SMTPAuth = true;
$mail->Username = 'AKIAJLZBBPUF4NTIG6GQ';
$mail->Password = 'ArVzhV6Pgm000i8dwHAlTzCKVPSrLIEiktIKS0gk2Ue9';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->From = 'no-reply@traceez.com';
$mail->FromName = 'Mailer';

$mail->addAddress('terry@ink.net.tw');

$mail->isHTML(true);
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
