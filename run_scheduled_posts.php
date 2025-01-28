<?php
include 'db/connect.php';
include 'twitter_api.php'; // Include your Twitter API functions
include 'facebook_api.php'; // Include your Facebook API functions
include 'instagram_api.php'; // Include your Instagram API functions
include 'linkedin_api.php'; // Include your LinkedIn API functions

$sql = "SELECT * FROM scheduled_posts WHERE schedule_datetime <= NOW() AND status = 'pending'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $scheduled_post_id = $row['id'];
    $user_id = $row['user_id'];
    $message = $row['message'];
    $platform = $row['platform'];

    if ($platform == 'twitter') {
        $response = postToTwitter($message); // Function to post to Twitter
        if ($response) {
            $sql_update = "UPDATE scheduled_posts SET status = 'posted' WHERE id = '$scheduled_post_id'";
            $conn->query($sql_update);
        } else {
            // Handle post failure
        }
    } elseif ($platform == 'facebook') {
        $response = postToFacebook($message); // Function to post to Facebook
        if ($response) {
            $sql_update = "UPDATE scheduled_posts SET status = 'posted' WHERE id = '$scheduled_post_id'";
            $conn->query($sql_update);
        } else {
            // Handle post failure
        }
    } elseif ($platform == 'instagram') {
        $response = postToInstagram($message); // Function to post to Instagram
        if ($response) {
            $sql_update = "UPDATE scheduled_posts SET status = 'posted' WHERE id = '$scheduled_post_id'";
            $conn->query($sql_update);
        } else {
            // Handle post failure
        }
    } elseif ($platform == 'linkedin') {
        $response = postToLinkedIn($message); // Function to post to LinkedIn
        if ($response) {
            $sql_update = "UPDATE scheduled_posts SET status = 'posted' WHERE id = '$scheduled_post_id'";
            $conn->query($sql_update);
        } else {
            // Handle post failure
        }
    }

    // Add handling for more platforms as needed
}

$conn->close();
?>
