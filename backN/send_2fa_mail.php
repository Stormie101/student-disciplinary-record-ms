<?php
require '../db_connects.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; 

$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host = 'smtp.example.com'; 
  $mail->SMTPAuth = true;
  $mail->Username = 'stormie8work@gmail.com'; 
  $mail->Password = 'rvvq fclq dnlv oijh';   
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  $mail->setFrom('stormie8work@gmail.com', 'UPTM Attendance System');
  $mail->addAddress($_SESSION['username']); 
  $mail->Subject = 'Your 2FA Verification Code';
  $mail->Body    = "Your verification code is: " . $_SESSION['2fa_code'];

  $mail->send();
} catch (Exception $e) {
  echo "<script>alert('2FA email failed: {$mail->ErrorInfo}');</script>";
}
?>
