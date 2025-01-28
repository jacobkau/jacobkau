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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function searchContent() {
            var input, filter, tweets, posts, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            tweets = document.getElementsByClassName("tweet");
            posts = document.getElementsByClassName("post");

            for (i = 0; i < tweets.length; i++) {
                txtValue = tweets[i].textContent || tweets[i].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    tweets[i].style.display = "";
                } else {
                    tweets[i].style.display = "none";
                }
            }

            for (i = 0; i < posts.length; i++) {
                txtValue = posts[i].textContent || posts[i].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    posts[i].style.display = "";
                } else {
                    posts[i].style.display = "none";
                }
            }
        }

        function filterContent() {
            var dateFilter = document.getElementById("dateFilter").value;
            var typeFilter = document.getElementById("typeFilter").value;
            var tweets = document.getElementsByClassName("tweet");
            var posts = document.getElementsByClassName("post");

            for (var i = 0; i < tweets.length; i++) {
                var tweetDate = new Date(tweets[i].getElementsByTagName("em")[0].innerText);
                var tweetType = "twitter";
                if ((dateFilter === "" || tweetDate >= new Date(dateFilter)) && (typeFilter === "" || typeFilter === tweetType)) {
                    tweets[i].style.display = "";
                } else {
                    tweets[i].style.display = "none";
                }
            }

            for (var i = 0; i < posts.length; i++) {
                if (!posts[i].classList.contains("tweet")) {
                    var postDate = new Date(posts[i].getElementsByTagName("em")[0].innerText);
                    var postType = "instagram";
                    if ((dateFilter === "" || postDate >= new Date(dateFilter)) && (typeFilter === "" || typeFilter === postType)) {
                        posts[i].style.display = "";
                    } else {
                        posts[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div class="dashboard-container">
        <div class="main-content">
        <?php include ("includes/header.php");
        include("includes/sidebar.php")?>
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

                    <h2>Instagram Posts</h2>
                    <div class="posts-row instagram-posts">
                        <?php foreach ($instagram_posts as $url): ?>
                            <div class="post">
                                <blockquote class="instagram-media" data-instgrm-permalink="<?php echo $url; ?>" data-instgrm-version="13">
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
