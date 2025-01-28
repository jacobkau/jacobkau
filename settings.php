<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

include 'db/connect.php';

$user_id = $_SESSION['user_id'];

// Fetch user profile information
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$conn->close();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="dashboard-container">
        <div class="main-content">
        <?php include ("includes/header.php");
        include("includes/sidebar.php")?>
            <main>
                <section>
                    <h1> Settings</h1>
                    <form action="update_profile.php" method="POST">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required><br>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>

                        <button type="submit">Update Profile</button>
                    </form>

                    <h2>Change Password</h2>
                    <form action="update_password.php" method="POST">
                        <label for="current_password">Current Password:</label>
                        <input type="password" id="current_password" name="current_password" required><br>

                        <label for="new_password">New Password:</label>
                        <input type="password" id="new_password" name="new_password" required><br>

                        <button type="submit">Change Password</button>
                    </form>
                </section>
            </main>
        </div>
    </div>
</body>

</html>