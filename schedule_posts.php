<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Posts</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="dashboard-container">
        <div class="main-content">
            <?php include ("includes/header.php");
        include("includes/sidebar.php")?>
           <main>
            <section>
            <h1>Schedule Posts</h1>
            <form action="schedule_post_action.php" method="POST">
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>

                <label for="platform">Platform:</label>
                <select id="platform" name="platform" required>
                    <option value="twitter">Twitter</option>
                    <option value="facebook">Facebook</option>
                    <option value="instagram">Instagram</option>
                    <option value="linkedin">LinkedIn</option>
                    <!-- Add more platforms as needed -->
                </select><br><br>

                <button type="submit">Schedule Post</button>
            </form>
            </section>
           </main>
        </div>
</body>

</html>