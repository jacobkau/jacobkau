<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}

include 'db/connect.php';

// Fetch user campaigns from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM campaigns WHERE user_id='$user_id'";
$result = $conn->query($sql);
$campaigns = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $campaigns[] = $row;
    }
}
$current_page = basename($_SERVER['PHP_SELF']);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Campaigns</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">       
        <div class="main-content">
        <?php include ("includes/header.php");
        include("includes/sidebar.php")?>
            <main>
                <section>
                    <h2>Your Campaigns</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Campaign Name</th>
                                <th>Post ID</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($campaigns as $campaign): ?>
                            <tr>
                                <td><?php echo $campaign['campaign_id']; ?></td>
                                <td><?php echo htmlspecialchars($campaign['campaign_name']); ?></td>
                                <td><?php echo $campaign['post_id']; ?></td>
                                <td><?php echo $campaign['start_date']; ?></td>
                                <td><?php echo $campaign['end_date']; ?></td>
                                <td>
                                    <a href="delete_campaign.php?id=<?php echo $campaign['campaign_id']; ?>">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <h2>Create New Campaign</h2>
                    <form action="add_campaign.php" method="POST">
                        <label for="campaign_name">Campaign Name:</label>
                        <input type="text" id="campaign_name" name="campaign_name" required>
                        
                        <label for="post_id">Post ID:</label>
                        <input type="text" id="post_id" name="post_id" required>
                        
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" required>
                        
                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" name="end_date" required><br>
                        
                        <button type="submit">Create Campaign</button>
                    </form>
                </section>
            </main>
        </div>
    </div>
</body>
</html>
