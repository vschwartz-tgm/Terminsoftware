<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

$mail = new PHPMailer(true);                              
try {
    $mail->SMTPDebug = 4;                                
    $mail->isSMTP();                                     
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                               
    $mail->Username = 'terminreservierung.teamm@gmail.com';                 
    $mail->Password = 'Admin12$';                          
    $mail->SMTPSecure = 'ssl';                           
    $mail->Port = 465;                                    

    $mail->setFrom('terminreservierung.teamm@gmail.com', 'Mailer');
    $mail->addAddress('chris10.kern@gmail.com');            
    $mail->addReplyTo('chris10.kern@gmail.com', 'Information');

    $mail->isHTML(true);                                 
    $mail->Subject = 'Angemeldet';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}

?>
