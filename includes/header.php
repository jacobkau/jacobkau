<?php
$tweets = isset($_SESSION['tweets']) ? $_SESSION['tweets'] : [];
$notifications = isset($_SESSION['notifications']) ? $_SESSION['notifications'] : [];
$instagram_posts = [
    'https://www.instagram.com/p/XXXXX/',
    'https://www.instagram.com/p/YYYYY/'
];
?>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 <link rel="shortcut icon" href="https://localhost/advanced/img/logo.png" type="image/x-icon">
<header>
    <h3><i class="fa fa-user" style="font-size:25px;color:white"></i>&nbsp;&nbsp;Welcome, <?php echo $_SESSION['user_name']; ?></h3>
    <nav>
        <ul style="display: flex; justify-content: space-between;">
            <li><a href="fetch_notifications.php"><i class="fas fa-bell"></i>&nbsp;Notifications (<?php echo count($notifications); ?>)</a></li>
            <li><a href="logout.php"><i class="fas fa-power-off"></i>&nbsp;Logout</a></li>
        </ul>
    </nav>
</header>