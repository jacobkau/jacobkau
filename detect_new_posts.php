<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location:public/login.html");
    exit();
}

include 'db/connect.php';

$user_id = $_SESSION['user_id'];

// Fetch new posts created within the last X minutes
$sql = "SELECT * FROM posts WHERE created_at > NOW() - INTERVAL 10 MINUTE AND user_id='$user_id'";
$new_posts = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

// Fetch posts that reached a specific number of likes
$sql = "SELECT * FROM posts p JOIN post_engagement e ON p.post_id = e.post_id WHERE e.likes >= 100 AND p.user_id='$user_id'";
$popular_posts = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

$conn->close();

$_SESSION['new_posts'] = array_merge($new_posts, $popular_posts);
header("Location: create_campaigns.php");
exit();
?>
