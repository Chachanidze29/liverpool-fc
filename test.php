<?php
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function confirmMail($email)
{
    $mail = new PHPMailer();
    //Set mailer to use smtp
    $mail->isSMTP();
    //Define smtp host
    $mail->Host = "smtp.gmail.com";
    //Enable smtp authentication
    $mail->SMTPAuth = true;
    //Set smtp encryption type (ssl/tls)
    $mail->SMTPSecure = "tls";
    //Port to connect smtp
    $mail->Port = "587";
    //Set gmail username
    $mail->Username = "chachanidzee29m@gmail.com";
    //Set gmail password
    $mail->Password = "ynwa1234";
    //Email subject
    $mail->Subject = "Test email using PHPMailer";
    //Set sender email
    $mail->setFrom('chachanidzee29m@gmail.com');
    //Enable HTML
    $mail->isHTML(true);
    //Attachment
    //Email body
    $mail->Body = <<<END
        <h1 style="text-align:center;">Email Confirmation</h1>
        <a href="http://localhost/www/login.php">CONFIRM</a>
    END;
    //Add recipient
    $mail->addAddress($email);
    //Finally send email
    if ($mail->send()) {
        return true;
    } else {
        return false;
    }
    //Closing smtp connection
    $mail->smtpClose();
}
