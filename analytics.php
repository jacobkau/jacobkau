<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: public/login.html");
    exit();
}
// Determine the current page
$current_page = basename($_SERVER['PHP_SELF']);


$post_engagement = isset($_SESSION['post_engagement']) ? $_SESSION['post_engagement'] : [];
$campaign_traffic = isset($_SESSION['campaign_traffic']) ? $_SESSION['campaign_traffic'] : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="dashboard-container">
        <div class="main-content">
            <?php include ("includes/header.php");
        include("includes/sidebar.php")?>
            <main>
                <section>
                    <h1 style="font-size:35px">Analytics</h1>
                    <h2>Post Engagement</h2>
                    <canvas id="postEngagementChart"></canvas>

                    <h2>Campaign Traffic</h2>
                    <canvas id="campaignTrafficChart"></canvas>
                </section>
            </main>
        </div>
    </div>
    <script>
    const postEngagement = <?php echo json_encode($post_engagement); ?>;
    const campaignTraffic = <?php echo json_encode($campaign_traffic); ?>;

    const postLabels = postEngagement.map(item => item.message);
    const postLikes = postEngagement.map(item => item.total_likes);
    const postComments = postEngagement.map(item => item.total_comments);
    const postShares = postEngagement.map(item => item.total_shares);

    const postEngagementChart = new Chart(document.getElementById('postEngagementChart'), {
        type: 'bar',
        data: {
            labels: postLabels,
            datasets: [{
                    label: 'Likes',
                    data: postLikes,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Comments',
                    data: postComments,
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Shares',
                    data: postShares,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }
            ]
        }
    });

    const campaignLabels = campaignTraffic.map(item => item.campaign_name);
    const campaignVisitors = campaignTraffic.map(item => item.total_visitors);

    const campaignTrafficChart = new Chart(document.getElementById('campaignTrafficChart'), {
        type: 'line',
        data: {
            labels: campaignLabels,
            datasets: [{
                label: 'Visitors',
                data: campaignVisitors,
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        }
    });
    </script>
</body>

</html>