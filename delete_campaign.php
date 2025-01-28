<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

include 'db/connect.php';

if (isset($_GET['id'])) {
    $campaign_id = $_GET['id'];
    $sql = "DELETE FROM campaigns WHERE campaign_id='$campaign_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: campaigns.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}
?>
