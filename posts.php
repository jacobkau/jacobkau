<?php
// posts.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

include 'db/connect.php';

// Fetch user posts from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM posts WHERE user_id='$user_id'";
$result = $conn->query($sql);
$posts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

$conn->close();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="dashboard-container">
        <div class="main-content">
        <?php include ("includes/header.php");
        include("includes/sidebar.php")?>
            <main>
                <section>
                    <h2>Your Posts</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Content</th>
                                <th>Timestamp</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post): ?>
                            <tr>
                                <td><?php echo $post['post_id']; ?></td>
                                <td><?php echo htmlspecialchars($post['content']); ?></td>
                                <td><?php echo $post['timestamp']; ?></td>
                                <td>
                                    <a href="delete_post.php?id=<?php echo $post['post_id']; ?>">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <h2>Add New Post</h2>
                    <form action="add_post.php" method="POST">
                        <label for="content">Content:</label>
                        <textarea id="content" name="content" required></textarea><br>
                        <button type="submit">Add Post</button>
                    </form>
                </section>
            </main>
        </div>
    </div>
</body>

</html>