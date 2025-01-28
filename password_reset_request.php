<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="dashboard-container">
        <div class="main-content">
        <?php include ("includes/header.php");
        include("includes/sidebar.php")?>
        <h1>Password Reset Request</h1>
        <form action="send_reset_link.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Send Reset Link</button>
        </form>
    </div>
</body>
</html>
