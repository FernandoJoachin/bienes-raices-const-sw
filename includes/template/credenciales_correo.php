<?php
use PHPMailer\PHPMailer\PHPMailer;


$mail = new PHPMailer();
$mail->isSMTP();                                            
$mail->Host       = "sandbox.smtp.mailtrap.io";             
$mail->SMTPAuth   = true;                                   
$mail->Username   = "f8e92f68474ba2";                       
$mail->Password   = "4316e4060555ba";                       
$mail->SMTPSecure = "tls";            
$mail->Port       = 2525;             

$mail->setFrom("from@example.com");
$mail->addAddress("from@example.com", "a18000621@alumnos.uady.mx");

$mail->isHTML(true);
$mail->CharSet = "UFT-8";      