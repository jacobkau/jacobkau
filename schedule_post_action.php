<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

include 'db/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $message = $_POST['message'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $platform = $_POST['platform'];
    $schedule_datetime = $date . ' ' . $time;

    $sql = "INSERT INTO scheduled_posts (user_id, message, schedule_datetime, platform) VALUES ('$user_id', '$message', '$schedule_datetime', '$platform')";
    if ($conn->query($sql) === TRUE) {
        echo "Post scheduled successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
