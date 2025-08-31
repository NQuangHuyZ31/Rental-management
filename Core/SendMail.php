<?php

namespace Core;

use Helpers\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';
class SendMail
{
  private $mail;

  public function __construct() {
    $this->mail = new PHPMailer(true);
  }

  public function sendOTP($email, $customer, $otp, $content)
  {
    try {
      $this->config();
      $this->mail->addAddress($email, $customer);     //Add a recipient
      // $mail->addAddress('ellen@example.com');               //Name is optional
      $this->mail->addReplyTo('huynguyenharu3108@gmail.com', 'Wild Horizon BookShop');
      // $mail->addCC('cc@example.com');
      // $mail->addBCC('bcc@example.com');

      //Attachments
      // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

      //Content                                  //Set email format to HTML
      $this->mail->Subject = $content;
      $this->mail->Body = '<p style="font-size: 20px; font-weight: 600;">Mã xác minh của bạn: <span style="font-size: 30px; font-weight: 600;">' . $otp . '</span></p>
      <p>Làm ơn không tiết lộ trong bất kì hình thức nào để đảm bảo an toàn cho bạn.</p>
      <p>Đây là mã xác minh để ' . $content . '. Vui lòng đảm bảo xác minh trong vòng <strong>5 phút</strong>.</p>';
      $this->mail->send();
      Log::queue("Email sent successfully to: " . $email);
      return true;
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
    }
  }

  public function config() { 
    $this->mail->isSMTP();                                            //Send using SMTP
      $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $this->mail->Username   = 'huynguyenharu3108@gmail.com';                     //SMTP username
      $this->mail->Password   = 'mfuk uxvq ykdy stst';                               //SMTP password
      $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $this->mail->Port       = 465;
      $this->mail->CharSet = 'UTF-8';          // ✅ xử lý tiếng Việt
      $this->mail->Encoding = 'base64';        // hoặc 'quoted-printable'                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $this->mail->setFrom('huynguyenharu3108@gmail.com', 'Wild Horizon BookShop');
      // $mail->addAddress('ellen@example.com');               //Name is optional
      $this->mail->addReplyTo('huynguyenharu3108@gmail.com', 'Wild Horizon BookShop');
      // $mail->addCC('cc@example.com');
      // $mail->addBCC('bcc@example.com');

      //Attachments
      // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

      //Content
      $this->mail->isHTML(true);                                  //Set email format to HTML
  }
}
