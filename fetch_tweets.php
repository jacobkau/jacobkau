<?php
require 'vendor/autoload.php'; // Include Composer autoload if using Composer
use Abraham\TwitterOAuth\TwitterOAuth;

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

// Twitter API credentials
$apiKey = 'xmvwGHJNSnhxexMTJngMhoDVW';
$apiSecretKey = 'Iq9whx6pAUdzg3PrDMhWUwff4WQAgsgUXlWIB31g2mwoCwQ6cv';
$accessToken = '1834270177543819264-sp3tyJ03yNwj0ipNpjgqEJqRKvBaTF';
$accessTokenSecret = 'dMozpn9sDcua0bWgVxPHzabsxmZ8O60AsmMEa4ivwhBzu';

// Create TwitterOAuth instance
$connection = new TwitterOAuth($apiKey, $apiSecretKey, $accessToken, $accessTokenSecret);

// Fetch user timeline
$user = 'Jacob_witty4';
$tweets = $connection->get("statuses/user_timeline", ["count" => 10, "screen_name" => $user]);

// Store tweets in session or database (example: store in session)
$_SESSION['tweets'] = $tweets;

header("Location: dashboard.php");
exit();
?>
