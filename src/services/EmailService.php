<?php

namespace app\services;

use app\models\LoginEmail;
use app\repositories\LoginEmailRepository;
use app\utils\LoginTokenGenerator;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class EmailService
{
    public function __construct
    (
        private readonly LoginEmailRepository $loginEmailRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    private function sendEmailGmail(string $email, string $subject, string $message): void
    {
        $mail = new PHPMailer();

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
            $mail->setFrom('phone-retail-manager@noreply.com', 'Phone Retail Manager Mailer');
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

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws Exception
     */
    private function generateLoginToken(string $email): string
    {
        $token = LoginTokenGenerator::generateToken($email);
        $loginEmail = new LoginEmail($email, $token);

        $this->loginEmailRepository->save($loginEmail);

        return $token;
    }

    /**
     * @throws ORMException
     */
    public function sendLoginEmailOnAccountCreation(string $email): bool
    {
        try {
            $token = self::generateLoginToken($email);

            $subject = 'Tạo tài khoản hệ thống quản lý cửa hàng điện thoại thành công';
            $message =
                'Chào bạn, '
                . '<br><br>'
                . 'Tài khoản của bạn đã được tạo thành công.'
                . '<br><br>'
                . 'Để đăng nhập vào hệ thống quản lý cửa hàng điện thoại, vui lòng truy cập vào đường link sau: <a href="http://' . $_SERVER['HTTP_HOST'] . '/login-by-email?token=' . $token . '&email=' . $email . '">Nhấn vào đây để đăng nhập!</a>'
                . '<br><br>'
                . 'Trân trọng,';


            self::sendEmailGmail($email, $subject, $message);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @throws ORMException
     */
    public function sendLoginEmail(string $email): bool
    {
        try {
            $token = self::generateLoginToken($email);

            $subject = 'Đăng nhập vào hệ thống quản lý cửa hàng điện thoại';
            $message =
                'Chào bạn, '
                . '<br><br>'
                . 'Để đăng nhập vào hệ thống quản lý cửa hàng điện thoại, vui lòng truy cập vào đường link sau: <a href="http://' . $_SERVER['HTTP_HOST'] . '/login-by-email?token=' . $token . '&email=' . $email . '">Nhấn vào đây để đăng nhập!</a>'
                . '<br><br>'
                . 'Trân trọng,';

            self::sendEmailGmail($email, $subject, $message);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}