<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

include 'db/connect.php';

$new_posts = isset($_SESSION['new_posts']) ? $_SESSION['new_posts'] : [];

foreach ($new_posts as $post) {
    $user_id = $post['user_id'];
    $post_id = $post['post_id'];
    $campaign_name = "Auto Campaign for Post #" . $post_id;
    $start_date = date('Y-m-d');
    $end_date = date('Y-m-d', strtotime('+7 days')); // 1 week campaign

    $sql = "INSERT INTO campaigns (user_id, post_id, campaign_name, start_date, end_date) VALUES ('$user_id', '$post_id', '$campaign_name', '$start_date', '$end_date')";
    if ($conn->query($sql) === TRUE) {
        // Optional: Send notification to user about the new campaign
        // sendNotification($user_id, "New marketing campaign created for your post!");
    }
}

$conn->close();

header("Location: campaigns.php");
exit();
?>
