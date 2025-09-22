<div class="main-content">
    <header class="top-header">
        <h2>Trang quản trị</h2>
        <div class="user-info">
            <span>Xin chào, Admin!</span>
            <button>Đăng xuất</button>
        </div>
    </header>
    <div class="content-area">
        <div class="dashboard-grid">
            <div class="kpi-card">
                <div class="kpi-icon"><i class="fas fa-home"></i></div>
                <div class="kpi-content">
                    <h3>Tổng Listing</h3>
                    <p>5,210</p>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon"><i class="fas fa-handshake"></i></div>
                <div class="kpi-content">
                    <h3>Giao dịch thành công</h3>
                    <p>125</p>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon"><i class="fas fa-chart-line"></i></div>
                <div class="kpi-content">
                    <h3>Giá trị TB/giao dịch</h3>
                    <p>1.8 tỷ VNĐ</p>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon"><i class="fas fa-eye"></i></div>
                <div class="kpi-content">
                    <h3>Lượt xem Listing</h3>
                    <p>876,123</p>
                </div>
            </div>

            <div class="chart-card large-card">
                <h3>Giá trị giao dịch hàng tháng</h3>
                <canvas id="monthlyRevenueChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>Listing mới theo loại hình</h3>
                <canvas id="newListingTypeChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>Tỷ lệ trạng thái Listing</h3>
                <canvas id="listingStatusChart"></canvas>
            </div>

            <div class="recent-activities large-card">
                <h3>Hoạt động gần đây</h3>
                <ul>
                    <li>
                        <span class="activity-type new-order">Listing mới:</span> Căn hộ Riverview - TP. HCM
                        <span class="activity-time">5 phút trước</span>
                    </li>
                    <li>
                        <span class="activity-type product-update">Cập nhật:</span> Đất nền khu đô thị mới - Giá: 3.2 tỷ VNĐ
                        <span class="activity-time">1 giờ trước</span>
                    </li>
                    <li>
                        <span class="activity-type user-registered">Người dùng mới:</span> Nguyễn Thị Lan - lannt@example.com
                        <span class="activity-time">3 giờ trước</span>
                    </li>
                    <li>
                        <span class="activity-type order-status">Listing đã bán:</span> Nhà phố quận 7 - #ABC1234
                        <span class="activity-time">Hôm qua</span>
                    </li>
                    <li>
                        <span class="activity-type admin-action">Admin:</span> Duyệt 5 listing mới
                        <span class="activity-time">2 ngày trước</span>
                    </li>
                </ul>
                <button class="view-all-activities">Xem tất cả hoạt động</button>
            </div>

            <div class="alert-card">
                <h3>Thông báo quan trọng</h3>
                <div class="alert-message warning">
                    <i class="fas fa-exclamation-triangle"></i> Có 7 listing đang chờ duyệt!
                </div>
                <div class="alert-message info">
                    <i class="fas fa-info-circle"></i> Giá trị giao dịch tháng này tăng 15% so với tháng trước.
                </div>
                <div class="alert-message success">
                    <i class="fas fa-check-circle"></i> Trang chủ đã được cập nhật thành công.
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="./views/js/dashboard/chart.js"></script>