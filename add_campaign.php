<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

include 'db/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $campaign_name = $_POST['campaign_name'];
    $post_id = $_POST['post_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "INSERT INTO campaigns (user_id, post_id, campaign_name, start_date, end_date) VALUES ('$user_id', '$post_id', '$campaign_name', '$start_date', '$end_date')";
    if ($conn->query($sql) === TRUE) {
        header("Location: campaigns.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
