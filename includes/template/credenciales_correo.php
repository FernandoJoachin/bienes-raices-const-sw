<?php
use PHPMailer\PHPMailer\PHPMailer;


$mail = new PHPMailer();
$mail->isSMTP();                                            
$mail->Host       = "sandbox.smtp.mailtrap.io";             
$mail->SMTPAuth   = true;                                   
$mail->Username   = "34632f45fe1840";                       
$mail->Password   = "dca63e7a70b3df";                       
$mail->SMTPSecure = "tls";            
$mail->Port       = 2525;             

$mail->setFrom($emailRemitente);
$mail->addAddress($emailDestinatario);

$mail->isHTML(true);
$mail->CharSet = "UFT-8";      