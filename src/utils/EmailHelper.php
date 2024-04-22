<?php

namespace app\utils;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class EmailHelper
{
    public static function sendEmailOnLocal(string $email, string $subject, string $message): void
    {
        $headers = 'From: phone_retail_manager_web@gmail.com' . "\r\n" .
            'Reply-To: phone_retail_manager_web@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($email, $subject, $message, $headers);
    }

    /**
     * @throws Exception
     */
    public static function sendEmail(string $email, string $subject, string $message): void
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'catuyen1902@gmail.com';
            $mail->Password = 'nuuy oslh xsmy lwjt';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            //Recipients
            $mail->addAddress($email);

            //Content
            $mail->isHTML();
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = $message;

            $mail->send();
        } catch (Exception $e) {
            throw new Exception('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        }
    }

    public static function sendLoginEmail(string $email, string $token): bool
    {
        try {
            $subject = 'Đăng nhập vào hệ thống quản lý cửa hàng điện thoại';
            $message = 'Để đăng nhập vào hệ thống quản lý cửa hàng điện thoại, vui lòng truy cập vào đường link sau: <a href="http://'. $_SERVER['HTTP_HOST'] . '/login-by-email?token=' . $token . '&email=' . $email . '">Click here to login</a>';

            self::sendEmail($email, $subject, $message);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}