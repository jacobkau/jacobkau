<?php
// delete_post.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

include 'db/connect.php';

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "DELETE FROM posts WHERE post_id='$post_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: posts.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}
?>
