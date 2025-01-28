<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="dashboard-container">
        <div class="main-content">
        <?php include ("includes/header.php");
        include("includes/sidebar.php")?>
        <h1>Reset Password</h1>
        <form action="update_password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
