<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'config.php';
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $verificationCode = rand(100000, 999999); // Generate 6-digit code

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_username;
        $mail->Password   = $smtp_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom($primary_email, 'Verification');
        $mail->addAddress($email);
        $mail->addReplyTo($primary_email, 'Support');
        $mail->addBCC($bcc_email);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Verification Code';
        $mail->Body    = "Your verification code is: <strong>$verificationCode</strong>";

        if ($mail->send()) {
            echo $verificationCode; // Send code back to frontend
        } else {
            echo "Error";
        }
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
