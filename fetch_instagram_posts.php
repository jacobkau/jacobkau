<?php
require 'vendor/autoload.php'; // Include Composer autoload if using Composer

use InstagramScraper\Instagram;

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

// Instagram API credentials
$accessToken = 'YOUR_ACCESS_TOKEN';

// Create Instagram instance
$instagram = new Instagram();
$instagram->setAccessToken($accessToken);

// Fetch user media
$media = $instagram->getFeed();

$_SESSION['instagram_posts'] = $media;
header("Location: dashboard.php");
exit();
?>
