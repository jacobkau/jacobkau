<?php
// includes/register.php
include '../db/connect.php';
require '../includes/PHPMailer/src/PHPMailer.php';
require '../includes/PHPMailer/src/SMTP.php';
require '../includes/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $verification_code = md5(uniqid(rand(), true)); // Generate a unique verification code

    $sql = "INSERT INTO users (name, email, password, verification_code) VALUES ('$name', '$email', '$password', '$verification_code')";
    if ($conn->query($sql) === TRUE) {
        // Send verification email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io'; // Mailtrap SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = '8fef25885ea16d'; // Mailtrap SMTP username
            $mail->Password = 'cb0f6048b72ade'; // Mailtrap SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('jacobkau4@gmail.com', 'Mailer');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body = "Click the link below to verify your email address:<br><br><a href='http://localhost/advanced/includes/verify.php?code=$verification_code'>Verify Email</a>";

            $mail->send();
            echo 'Registration successful! Please check your email to verify your account.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
