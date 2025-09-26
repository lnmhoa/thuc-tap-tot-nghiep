<div class="admin-dashboard-wrapper">
    <div class="admin-dashboard-container">
        <div class="admin-dashboard-stats">
            <div class="admin-dashboard-card admin-dashboard-card-blue">
                <div class="admin-dashboard-card-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="admin-dashboard-card-content">
                    <h3><?php echo number_format($totalProperties); ?></h3>
                    <p>Bất động sản</p>
                </div>
            </div>

            <div class="admin-dashboard-card admin-dashboard-card-green">
                <div class="admin-dashboard-card-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="admin-dashboard-card-content">
                    <h3><?php echo number_format($totalBrokers); ?></h3>
                    <p>Môi giới</p>
                </div>
            </div>

            <div class="admin-dashboard-card admin-dashboard-card-orange">
                <div class="admin-dashboard-card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="admin-dashboard-card-content">
                    <h3><?php echo number_format($totalUsers); ?></h3>
                    <p>Người dùng</p>
                </div>
            </div>

            <div class="admin-dashboard-card admin-dashboard-card-purple">
                <div class="admin-dashboard-card-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="admin-dashboard-card-content">
                    <h3><?php echo number_format($totalNews); ?></h3>
                    <p>Tin tức</p>
                </div>
            </div>

            <div class="admin-dashboard-card admin-dashboard-card-red">
                <div class="admin-dashboard-card-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="admin-dashboard-card-content">
                    <h3><?php echo number_format($totalContacts); ?></h3>
                    <p>Liên hệ</p>
                </div>
            </div>
        </div>

        <div class="admin-dashboard-charts">
            <div class="admin-dashboard-chart-container">
                <div class="admin-dashboard-chart-header">
                    <h3>Thống kê theo tháng</h3>
                    <p>Biểu đồ đường thể hiện xu hướng 12 tháng gần nhất</p>
                </div>
                <canvas id="adminLineChart" width="400" height="150"></canvas>
            </div>
            <div class="admin-dashboard-chart-container">
                <div class="admin-dashboard-chart-header">
                    <h3>So sánh tổng quan</h3>
                    <p>Biểu đồ cột thể hiện tổng số liệu hiện tại</p>
                </div>
                <canvas id="adminBarChart" width="400" height="150"></canvas>
            </div>
            <div class="admin-dashboard-chart-container admin-dashboard-pie-container">
                <div class="admin-dashboard-chart-header">
                    <h3>Phân bố dữ liệu</h3>
                    <p>Biểu đồ tròn thể hiện tỷ lệ phần trăm</p>
                </div>
                <canvas id="adminPieChart" width="300" height="300"></canvas>
            </div>
        </div>
    </div>

    <script>
        const chartDataFromPHP = <?php echo json_encode($chartData); ?>;
        const totalStats = {
            properties: <?php echo $totalProperties; ?>,
            brokers: <?php echo $totalBrokers; ?>,
            users: <?php echo $totalUsers; ?>,
            news: <?php echo $totalNews; ?>,
            contacts: <?php echo $totalContacts; ?>
        };
    </script>
</div>