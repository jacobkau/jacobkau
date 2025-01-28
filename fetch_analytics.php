<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

include 'db/connect.php';

$user_id = $_SESSION['user_id'];

// Fetch total posts
$sql = "SELECT COUNT(*) AS total_posts FROM posts WHERE user_id='$user_id'";
$result = $conn->query($sql);
$total_posts = $result->fetch_assoc()['total_posts'];

// Fetch total campaigns
$sql = "SELECT COUNT(*) AS total_campaigns FROM campaigns WHERE user_id='$user_id'";
$result = $conn->query($sql);
$total_campaigns = $result->fetch_assoc()['total_campaigns'];

// Fetch engagement metrics
$sql = "SELECT SUM(likes) AS total_likes, SUM(comments) AS total_comments, SUM(shares) AS total_shares FROM post_engagement WHERE post_id IN (SELECT post_id FROM posts WHERE user_id='$user_id')";
$result = $conn->query($sql);
$engagement = $result->fetch_assoc();

// Fetch traffic sources
$sql = "SELECT source, SUM(visitors) AS total_visitors FROM campaign_traffic WHERE campaign_id IN (SELECT campaign_id FROM campaigns WHERE user_id='$user_id') GROUP BY source";
$result = $conn->query($sql);
$traffic_sources = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();

$_SESSION['analytics'] = [
    'total_posts' => $total_posts,
    'total_campaigns' => $total_campaigns,
    'engagement' => $engagement,
    'traffic_sources' => $traffic_sources,
];

header("Location: analytics.php");
exit();
?>
