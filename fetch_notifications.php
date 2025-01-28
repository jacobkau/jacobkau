<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

include 'db/connect.php';
include 'redis.php';  // Include the Redis cache class

$redisCache = new RedisCache();
$cache_key = "user_notifications_" . $_SESSION['user_id'];
$notifications = $redisCache->get($cache_key);

if (!$notifications) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM notifications WHERE user_id='$user_id' ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $notifications = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
    }

    $redisCache->set($cache_key, $notifications);
}

$conn->close();
$_SESSION['notifications'] = $notifications;
header("Location: dashboard.php");
exit();
?>
