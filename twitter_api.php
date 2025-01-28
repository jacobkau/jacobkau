<?php
require "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

function getTwitterConnection() {
    $consumerKey = 'xmvwGHJNSnhxexMTJngMhoDVW';
    $consumerSecret = 'Iq9whx6pAUdzg3PrDMhWUwff4WQAgsgUXlWIB31g2mwoCwQ6cv';
    $accessToken = '1834270177543819264-sp3tyJ03yNwj0ipNpjgqEJqRKvBaTF';
    $accessTokenSecret = 'dMozpn9sDcua0bWgVxPHzabsxmZ8O60AsmMEa4ivwhBzu';

    return new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
}

function postToTwitter($message) {
    $connection = getTwitterConnection();
    $status = $connection->post("statuses/update", ["status" => $message]);

    if ($connection->getLastHttpCode() == 200) {
        return true;
    } else {
        return false;
    }
}
?>
