<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

include 'db/connect.php';

$user_id = $_SESSION['user_id'];

// Fetch post engagement data
$sql = "SELECT p.post_id, p.message, SUM(e.likes) AS total_likes, SUM(e.comments) AS total_comments, SUM(e.shares) AS total_shares
        FROM posts p
        LEFT JOIN post_engagement e ON p.post_id = e.post_id
        WHERE p.user_id='$user_id'
        GROUP BY p.post_id, p.message";
$post_engagement = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

// Fetch campaign traffic data
$sql = "SELECT c.campaign_id, c.campaign_name, t.source, SUM(t.visitors) AS total_visitors
        FROM campaigns c
        LEFT JOIN campaign_traffic t ON c.campaign_id = t.campaign_id
        WHERE c.user_id='$user_id'
        GROUP BY c.campaign_id, c.campaign_name, t.source";
$campaign_traffic = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

$conn->close();

$_SESSION['post_engagement'] = $post_engagement;
$_SESSION['campaign_traffic'] = $campaign_traffic;

header("Location: analytics.php");
exit();
?>
