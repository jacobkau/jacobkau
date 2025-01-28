<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

include 'db/connect.php';
include 'redis.php';  // Include the Redis cache class

$redisCache = new RedisCache();
$cache_key = "user_posts_" . $_SESSION['user_id'];
$posts = $redisCache->get($cache_key);

if (!$posts) {
    $sql = "SELECT p.*, 
                   (SELECT COUNT(*) FROM likes WHERE post_id=p.id) as likes_count,
                   (SELECT COUNT(*) FROM comments WHERE post_id=p.id) as comments_count
            FROM posts p
            WHERE p.user_id='" . $_SESSION['user_id'] . "'";
    $result = $conn->query($sql);
    $posts = $result->fetch_all(MYSQLI_ASSOC);
    $redisCache->set($cache_key, $posts);
}

// Process and display the posts
foreach ($posts as $post) {
    echo "Post: " . htmlspecialchars($post['message']);
    echo "Likes: " . $post['likes_count'];
    echo "Comments: " . $post['comments_count'];
}
?>
