<?php
use PHPMailer\PHPMailer\PHPMailer;


$mail = new PHPMailer();
$mail->isSMTP();                                            
$mail->Host       = $_ENV['EMAIL_HOST'] ?? '';             
$mail->SMTPAuth   = true;                                   
$mail->Username   = $_ENV['EMAIL_USER'] ?? '';                       
$mail->Password   = $_ENV['EMAIL_PASS'] ?? '';                       
$mail->SMTPSecure = "tls";            
$mail->Port       = $_ENV['EMAIL_PORT'] ?? '';             

$mail->setFrom($emailRemitente);
$mail->addAddress($emailDestinatario);

$mail->isHTML(true);
$mail->CharSet = "UFT-8";      