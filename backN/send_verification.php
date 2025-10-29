<?php
session_start();
require '../db_connects.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';

  $stmt = $conn->prepare("SELECT userID, username FROM Users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $verificationCode = rand(100000, 999999);

    $_SESSION['reset_userID'] = $user['userID'];
    $_SESSION['verification_code'] = $verificationCode;

    // Send email
    $mail = new PHPMailer(true);
    try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'stormie8work@gmail.com';       // Your Gmail
      $mail->Password = 'pbxd dves mtlt qzfu';      // Your App Password
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom('stormie8work@gmail.com', 'UPTM Disciplinary System');
      $mail->addAddress($email);

      $mail->isHTML(true);
      $mail->Subject = 'Verification Code – Reset Password';
      $mail->Body = "
        Hi,<br><br>
        You requested to reset your password.<br>
        Your verification code is: <strong>$verificationCode</strong><br><br>
        Please enter this code on the verification page to continue.<br><br>
        Regards,<br>
        UPTM Disciplinary System
      ";

      $mail->send();
      echo "<script>
        alert('Verification code sent to $email');
        window.location.href = 'verify_code.php';
      </script>";
    } catch (Exception $e) {
      echo "<script>
        alert('Email could not be sent. Error: {$mail->ErrorInfo}');
        window.location.href = 'forgot_password.php';
      </script>";
    }
  } else {
    echo "<script>
      alert('Email not found. Please enter a registered email.');
      window.location.href = 'forgot_password.php';
    </script>";
  }

  $stmt->close();
  $conn->close();
}
?>
