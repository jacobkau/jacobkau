<?php
function sendNotification($user_id, $message) {
    include 'db/connect.php';

    // Fetch user email
    $sql = "SELECT email FROM users WHERE id='$user_id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    $email = $user['email'];

    // Send email notification
    $subject = "New Marketing Campaign Created";
    $headers = "From: kaujacob4@gmail.com";
    mail($email, $subject, $message, $headers);

    $conn->close();
}
?>
