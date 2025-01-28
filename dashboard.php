<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}
$tweets = isset($_SESSION['tweets']) ? $_SESSION['tweets'] : [];
$notifications = isset($_SESSION['notifications']) ? $_SESSION['notifications'] : [];
$instagram_posts = [
    'https://www.instagram.com/p/XXXXX/',
    'https://www.instagram.com/p/YYYYY/'
];
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Fetch Facebook data after login
        function fetchFacebookData() {
            fetch('facebook_api.php')
                .then(response => response.json())
                .then(data => {
                    if (data.login_url) {
                        document.getElementById('loginButton').innerHTML = `<a href="${data.login_url}">Log in with Facebook!</a>`;
                    } else if (data.error) {
                        document.getElementById('postsContainer').innerHTML = `<p>Error: ${data.error}</p>`;
                    } else {
                        displayPosts(data); // Call function to display posts
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    document.getElementById('postsContainer').innerHTML = `<p>Error fetching data.</p>`;
                });
        }

        // Display the posts in the dashboard
        function displayPosts(data) {
            const postsContainer = document.getElementById('postsContainer');
            postsContainer.innerHTML = `<h2>${data.name}'s Posts</h2><p>Email: ${data.email}</p>`;
            
            // Loop through posts and display each one
            data.posts.forEach(post => {
                const postElement = document.createElement('div');
                postElement.className = 'post';
                postElement.innerHTML = `
                    <p>${post.message || 'No content'}</p>
                    <small>Posted on: ${new Date(post.created_time).toLocaleString()}</small>
                `;
                postsContainer.appendChild(postElement);
            });
        }

        window.onload = function() {
            fetchFacebookData();
        };
    </script>
</head>

<body>
    <div class="dashboard-container">
        <div class="main-content">
            <?php include("includes/header.php");
            include("includes/sidebar.php") ?>
            <main>
                <section>
                    <h2>Dashboard Overview</h2>
                    <p>Here you can manage your posts and view analytics.</p>
                    <div class="search-input">
                        <input type="text" id="searchInput" onkeyup="searchContent()" placeholder="Search posts...">
                    </div>
                    <div class="filters">
                        <label for="dateFilter">Date:</label>
                        <input type="date" id="dateFilter" onchange="filterContent()">
                        <label for="typeFilter">Type:</label>
                        <select id="typeFilter" onchange="filterContent()">
                            <option value="">All</option>
                            <option value="twitter">Twitter</option>
                            <option value="instagram">Instagram</option>
                        </select>
                    </div>

                    <h2>Notifications</h2>
                    <div class="notifications">
                        <?php if (!empty($notifications)): ?>
                            <ul>
                                <?php foreach ($notifications as $notification): ?>
                                    <li class="notification">
                                        <?php echo htmlspecialchars($notification['message']); ?>
                                        <em>- <?php echo $notification['created_at']; ?></em>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No notifications found.</p>
                        <?php endif; ?>
                    </div>

                    <h2>Recent Tweets</h2>
                    <div class="posts-row">
                        <?php if (!empty($tweets)): ?>
                            <?php foreach ($tweets as $tweet): ?>
                                <div class="post tweet">
                                    <p><?php echo htmlspecialchars($tweet->text); ?></p>
                                    <em>- <?php echo $tweet->created_at; ?></em>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No tweets found.</p>
                        <?php endif; ?>
                    </div>

                    <!-- FACEBOOK POSTS -->
                    <h2>Facebook</h2>
                    <div class="posts-row instagram-posts">
                        <div id="loginButton"></div>
                        <div id="postsContainer"></div>
                    </div>
                    <!-- FACEBOOK POSTS -->

                    <h2>Instagram Posts</h2>
                    <div class="posts-row instagram-posts">
                        <?php foreach ($instagram_posts as $url): ?>
                            <div class="post">
                                <blockquote class="instagram-media" data-instgrm-permalink="<?php echo $url; ?>"
                                    data-instgrm-version="13">
                                    <a href="<?php echo $url; ?>" target="_blank"></a>
                                </blockquote>
                            </div>
                        <?php endforeach; ?>
                        <script async src="//www.instagram.com/embed.js"></script>
                    </div>
                </section>
            </main>
        </div>
    </div>
</body>

</html>
