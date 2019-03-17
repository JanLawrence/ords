<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 1/29/2019
 * Time: 4:11 PM
 */


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Emailsender
{

    static $url = "";

    public function send_email_autosending($to, $message, $subject){

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
            //$mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = "smtp.gmail.com";                   // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'jltolentino0106@gmail.com';                 // SMTP username
            $mail->Password = 'KiraKira06';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = '587';                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('jltolentino0106@gmail.com', 'SPTA');
            $mail->addAddress($to);      // Add a recipient


            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $message;

            $mail->send();
            //echo 'Message has been sent';


        } catch (Exception $e) {
            //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }


}