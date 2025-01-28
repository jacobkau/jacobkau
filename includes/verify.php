<?php
// includes/verify.php
include '../db/connect.php';

if (isset($_GET['code'])) {
    $verification_code = $_GET['code'];

    $sql = "SELECT * FROM users WHERE verification_code='$verification_code' AND verified=FALSE";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $sql_update = "UPDATE users SET verified=TRUE WHERE verification_code='$verification_code'";
        if ($conn->query($sql_update) === TRUE) {
            echo "Your email has been verified successfully!";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Invalid or expired verification code.";
    }

    $conn->close();
} else {
    echo "No verification code provided.";
}
?>
