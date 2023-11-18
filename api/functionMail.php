<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';
require_once "../config.php";

function sendEmail( $to_address, $reply_to_address, $bcc_address, $subject, $body, $alt_body) {
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $error = false;  // assume error until proven otherwise
    try {
        //Server settings
        $mail->SMTPDebug = false;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                   //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail = setInfoAccount($mail);   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->addAddress($to_address);                             //Add a recipient
        $mail->addReplyTo($reply_to_address, 'CSI SAKEC'); 
        if($bcc_address != 'NO'){
            $mail->addBCC($bcc_address);
        }
        // $mail->addBCC('trekindia2017@gmail.com');
    
        //Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody =  $alt_body;
        // $mail->AddEmbeddedImage('C:/xampp/htdocs/Trek-India/assets/img/logo/trek-india-logo.png', 'brand-logo', '', 'base64', 'image/png');
        // $mail->AddEmbeddedImage( ROOT.'/assets/img/social_media/facebook.png', 'facebook', '', 'base64', 'image/png');
        // $mail->AddEmbeddedImage( ROOT.'/assets/img/social_media/instagram.png', 'instagram', '', 'base64', 'image/png');
        // $mail->AddEmbeddedImage( ROOT.'/assets/img/social_media/telegram.png', 'telegram', '', 'base64', 'image/png');
        // $mail->AddEmbeddedImage( ROOT.'/assets/img/social_media/youtube.png', 'youtube', '', 'base64', 'image/png');
        // $mail->AddEmbeddedImage( ROOT.'/assets/img/social_media/twitter.png', 'twitter', '', 'base64', 'image/png');

        if(!$error){
            $mail->send();
            return 'Message has been sent';
        }else{
            return 'Could not send email, Please select correct account.';
        }
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
}
