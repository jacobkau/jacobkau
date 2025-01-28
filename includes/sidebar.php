<aside class="sidebar">
    <h2><i class="fas fa-bars"></i>&nbsp;Menu</h2>
    <nav>
        <ul>
            <li><a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>"><i
                        class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="posts.php" class="<?php echo $current_page == 'posts.php' ? 'active' : ''; ?>"><i
                        class="fas fa-pencil-alt"></i> Manage Posts</a></li>
            <li><a href="schedule_posts.php"
                    class="<?php echo $current_page == 'schedule_posts.php' ? 'active' : ''; ?>"><i
                        class="fas fa-calendar-alt"></i> Schedule Posts</a></li>
            <li><a href="analytics.php" class="<?php echo $current_page == 'analytics.php' ? 'active' : ''; ?>"><i
                        class="fas fa-chart-line"></i> Analytics</a></li>
            <li><a href="campaigns.php" class="<?php echo $current_page == 'campaigns.php' ? 'active' : ''; ?>"><i
                        class="fas fa-bullhorn"></i> Manage Campaigns</a></li>
            <li><a href="settings.php" class="<?php echo $current_page == 'settings.php' ? 'active' : ''; ?>"><i
                        class="fas fa-cog"></i> User Settings</a></li>
        </ul>
    </nav>
</aside>