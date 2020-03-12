<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/autoload.php';

function send_php_mail($email, $subject, $msg, $headers)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = "projecthardik8@gmail.com";                     // SMTP username
        $mail->Password   = "143830jsu";                             // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('projecthardik8@gmail.com', 'Intern-Manager IIT Patna');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $msg;
        // $mail->AltBody = $msg;

        if ($mail->send()) {
            // echo 'Message has been sent';
            return true;
        } else {
            // echo 'Message not sent';
            return false;
        }
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
