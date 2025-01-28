<?php
include 'db/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    
    // Check if the email exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50));
        
        // Store the reset token in the database
        $sql = "UPDATE users SET reset_token='$token' WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
            $resetLink = "http://localhost/advanced/reset_password.php?token=$token";
            $subject = "Password Reset Request";
            $message = "Click the link to reset your password: $resetLink";
            $headers = "From: kaujacob4@gmail.com";

            // Send the email
            mail($email, $subject, $message, $headers);
            
            echo "Password reset link has been sent to your email.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "No user found with that email address.";
    }

    $conn->close();
}
?>
