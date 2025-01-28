<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Facebook App credentials
$client_id = '966765091577042';  // Your Facebook App ID
$client_secret = '1d3133ea5c0a913e4ca66a78f785f7c1';  // Your Facebook App Secret
$redirect_uri = 'https://9c8b-105-161-229-187.ngrok-free.app/facebook_api.php';  // Your redirect URI

// Function to make a GET request using cURL
function curl_get($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo json_encode(['error' => 'Request Error: ' . curl_error($ch)]);
        exit;
    }
    curl_close($ch);
    return $response;
}

// Check if there's an authorization code in the URL
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Exchange code for an access token
    $url = 'https://graph.facebook.com/v12.0/oauth/access_token?' .
        'client_id=' . $client_id .
        '&redirect_uri=' . urlencode($redirect_uri) .
        '&client_secret=' . $client_secret .
        '&code=' . $code;

    // Make a GET request to get the access token
    $response = curl_get($url);
    $response_data = json_decode($response, true);

    // Extract the access token
    if (isset($response_data['access_token'])) {
        $access_token = "EAANvRIndXNIBO37CeCVZCbZBZAqm4RIDcC7YOZBMQdij3BHQD9hLwHrXy7vWvhpVA1i3YF4h0WA6cHYsBmXmr9qcZA3YxJYMMWShBfSZBfOUpZCZBfQnZAcFp3dlRrPf5MrQxV9khMZAwoiTAA49bEX6LaOCW94HYMnhEZBtWZAbBlsZAjF6r7ZChPaF2qrbxWY5paVTLnZAr5G4OtZB"; // Replace with your actual access token

        
        // Fetch user data (name, email)
        $user_info_url = "https://graph.facebook.com/me?fields=name,email&ac=$access_token";
        $user_info = json_decode(curl_get($user_info_url), true);

        // Fetch user posts
        $posts_url = "https://graph.facebook.com/me/posts?access_token=$access_token";
        $posts = json_decode(curl_get($posts_url), true);

        // Check for errors in the posts response
        if (isset($posts['error'])) {
            echo json_encode(['error' => 'Error fetching posts: ' . $posts['error']['message']]);
            exit;
        }

        // Prepare the response to return to frontend
        echo json_encode([
            'name' => $user_info['name'],
            'email' => $user_info['email'],
            'posts' => isset($posts['data']) ? $posts['data'] : []
        ]);
    } else {
        echo json_encode(['error' => 'Error fetching access token: ' . $response_data['error']['message']]);
    }
} else {
    // If no code parameter is found, we need to return the login URL
    $login_url = 'https://www.facebook.com/v12.0/dialog/oauth?' .
        'client_id=' . $client_id .
        '&redirect_uri=' . urlencode($redirect_uri) .
        '&scope=email,user_posts';

    echo json_encode(['login_url' => $login_url]);
}
?>
