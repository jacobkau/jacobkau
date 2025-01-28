<?php
function addNotification($user_id, $message) {
    include 'db/connect.php';

    $sql = "INSERT INTO notifications (user_id, message) VALUES ('$user_id', '$message')";
    $conn->query($sql);
    $conn->close();
}
?>
