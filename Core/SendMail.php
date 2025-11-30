<?php

/*
Author: Huy Nguyen
Date: 2025-09-01
Purpose: provide send mail functionality
 */

namespace Core;

use Helpers\EmailTemplate;
use Helpers\Log;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class SendMail {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
    }

    public function sendOTP($email, $customer, $otpCode, $purpose = 'Xác minh tài khoản') {
        try {
            $this->config();
            $this->mail->addAddress($email, $customer);
            $this->mail->addReplyTo('huynguyenharu3108@gmail.com', 'Hệ thống quản lý cho thuê nhà');

            $this->mail->Subject = "Mã xác minh OTP - {$purpose}";
            $this->mail->Body = EmailTemplate::renderOTP($customer, $otpCode, $purpose);
            $this->mail->send();
            Log::queue("OTP Email sent successfully to: " . $email);
            return true;
        } catch (Exception $e) {
            Log::queue("Failed to send OTP email to {$email}: {$this->mail->ErrorInfo}");
            return false;
        }
    }

    public function config() {
        $this->mail->isSMTP(); //Send using SMTP
        $this->mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $this->mail->SMTPAuth = true; //Enable SMTP authentication
        $this->mail->Username = 'huynguyenharu3108@gmail.com'; //SMTP username
        $this->mail->Password = 'mfuk uxvq ykdy stst'; //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $this->mail->Port = 465;
        $this->mail->CharSet = 'UTF-8'; // ✅ xử lý tiếng Việt
        $this->mail->Encoding = 'base64'; // hoặc 'quoted-printable'                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $this->mail->setFrom('huynguyenharu3108@gmail.com', 'Hệ thống quản lý cho thuê nhà');
        // $mail->addAddress('ellen@example.com');               //Name is optional
        $this->mail->addReplyTo('huynguyenharu3108@gmail.com', 'Hệ thống quản lý cho thuê nhà');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $this->mail->isHTML(true); //Set email format to HTML
    }

    /**
     * Gửi email chào mừng cho người dùng mới
     */
    public function sendWelcome($email, $customer, $loginUrl) {
        try {
            $this->config();
            $this->mail->addAddress($email, $customer);
            $this->mail->addReplyTo('huynguyenharu3108@gmail.com', 'Hệ thống quản lý cho thuê nhà');

            $this->mail->Subject = "Chào mừng bạn đến với hệ thống quản lý cho thuê nhà";
            $this->mail->Body = EmailTemplate::renderWelcome($customer, $loginUrl);
            $this->mail->send();
            Log::queue("Welcome email sent successfully to: " . $email);
            return true;
        } catch (Exception $e) {
            Log::queue("Failed to send welcome email to {$email}: {$this->mail->ErrorInfo}");
            return false;
        }
    }

    /**
     * Gửi email thông báo đặt lịch xem nhà
     */
    public function sendAppointment($email, $customer, $houseName, $houseAddress, $housePrice, $appointmentDate, $appointmentTime, $appointmentUrl, $notes = null) {
        try {
            $this->config();
            $this->mail->addAddress($email, $customer);
            $this->mail->addReplyTo('huynguyenharu3108@gmail.com', 'Hệ thống quản lý cho thuê nhà');

            $this->mail->Subject = "Thông báo đặt lịch xem nhà - {$houseName}";
            $this->mail->Body = EmailTemplate::renderAppointment($customer, $houseName, $houseAddress, $housePrice, $appointmentDate, $appointmentTime, $appointmentUrl, $notes);
            $this->mail->send();
            Log::queue("Appointment email sent successfully to: " . $email);
            return true;
        } catch (Exception $e) {
            Log::queue("Failed to send appointment email to {$email}: {$this->mail->ErrorInfo}");
            return false;
        }
    }

    /**
     * Gửi email đặt lại mật khẩu
     */
    public function sendPasswordReset($email, $customer, $resetUrl) {
        try {
            $this->config();
            $this->mail->addAddress($email, $customer);
            $this->mail->addReplyTo('huynguyenharu3108@gmail.com', 'Hệ thống quản lý cho thuê nhà');

            $this->mail->Subject = "Đặt lại mật khẩu - Hệ thống quản lý cho thuê nhà";
            $this->mail->Body = EmailTemplate::renderPasswordReset($customer, $resetUrl);
            $this->mail->send();
            Log::queue("Password reset email sent successfully to: " . $email);
            return true;
        } catch (Exception $e) {
            Log::queue("Failed to send password reset email to {$email}: {$this->mail->ErrorInfo}");
            return false;
        }
    }

    /**
     * Gửi email active account
     */
    public function sendActiveAccount($email, $customer, $resetUrl) {
        try {
            $this->config();
            $this->mail->addAddress($email, $customer);
            $this->mail->addReplyTo('huynguyenharu3108@gmail.com', 'Hệ thống quản lý cho thuê nhà');

            $this->mail->Subject = "Kích hoạt tài khoản - Hệ thống quản lý cho thuê nhà";
            $this->mail->Body = EmailTemplate::renderActiveAccount($customer, $resetUrl);
            $this->mail->send();
            Log::queue("Active account email sent successfully to: " . $email);
            return true;
        } catch (Exception $e) {
            Log::queue("Failed to send active account email to {$email}: {$this->mail->ErrorInfo}");
            return false;
        }
    }

    /**
     * Gửi email thông báo chung
     */
    public function sendNotification($email, $customer, $data) {
        try {
            $this->config();
            $this->mail->addAddress($email, $customer);
            $this->mail->addReplyTo('huynguyenharu3108@gmail.com', 'Hệ thống quản lý cho thuê nhà');

            $this->mail->Subject = $data['emailTitle'] ?? 'Thông báo từ hệ thống';
            $this->mail->Body = EmailTemplate::renderNotification($data);
            $this->mail->send();
            Log::queue("Notification email sent successfully to: " . $email);
            return true;
        } catch (Exception $e) {
            Log::queue("Failed to send notification email to {$email}: {$this->mail->ErrorInfo}");
            return false;
        }
    }

    /**
     * Gửi email tùy chỉnh
     */
    public function sendCustom($email, $customer, $subject, $template, $data = []) {
        try {
            $this->config();
            $this->mail->addAddress($email, $customer);
            $this->mail->addReplyTo('huynguyenharu3108@gmail.com', 'Hệ thống quản lý cho thuê nhà');

            $this->mail->Subject = $subject;
            $this->mail->Body = EmailTemplate::renderCustom($template, $data);
            $this->mail->send();
            Log::queue("Custom email sent successfully to: " . $email);
            return true;
        } catch (Exception $e) {
            Log::queue("Failed to send custom email to {$email}: {$this->mail->ErrorInfo}");
            return false;
        }
    }

    // Gửi email thông báo báo cáo vi phạm đã được xử lý
    public function sendResolvedReport($email, $customer, $actionMessage, $resolvedAt, $message = '', $rentalPostDate = '') {
        try {
            $this->config();
            $this->mail->addAddress($email, $customer);
            $this->mail->addReplyTo('huynguyenharu3108@gmail.com', 'Hệ thống quản lý cho thuê nhà');
            $this->mail->Subject = "Thông báo xử lý báo cáo vi phạm – Hosty";
            $this->mail->Body = EmailTemplate::renderResolvedReport($customer, $actionMessage, $resolvedAt, $message, $rentalPostDate);
            $this->mail->send();
            Log::queue("Resolved report email sent successfully to: " . $email);
            return true;
        } catch (Exception $e) {
            Log::queue("Failed to send resolved report email to {$email}: {$this->mail->ErrorInfo}");
            return false;
        }
    }
}