<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';


function sendMail($to, $subject, $body){

$mail = new PHPMailer(true);

try {
    
    $mail->SMTPDebug = 0;                     
    $mail->isSMTP();                                          
    $mail->Host       = 'smtp.gmail.com';                  
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'wendymadissone@gmail.com';              
    $mail->Password   = 'vvztvxwbqugxktwz';                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;                                  

    $mail->setFrom('wendymadissone@gmail.com', 'Wendy');
    $mail->addAddress($to);     
     

    $mail->isHTML(true);                                 
    $mail->Subject = $subject;
    $mail->Body    = $body;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo "<script>alert('Message has been sent');</script>";
}
 catch (Exception $e) {
    echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');<?script>";
  }
}