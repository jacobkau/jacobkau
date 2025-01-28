<?php
include 'db/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Verify the token and update the password
    $sql = "SELECT * FROM users WHERE reset_token='$token'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];
        
        $sql = "UPDATE users SET password='$newPassword', reset_token=NULL WHERE id='$user_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Your password has been reset successfully.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Invalid or expired token.";
    }

    $conn->close();
}
?>
