<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <div class="page-title">
                <h1><i class="fas fa-history"></i> Lịch sử thuê</h1>
                <p>Theo dõi và quản lý các bất động sản bạn đã thuê</p>
            </div>
            <div class="breadcrumb">
                <a href="index.php"><i class="fas fa-home"></i> Trang chủ</a>
                <span>/</span>
                <a href="?act=profile">Hồ sơ</a>
                <span>/</span>
                <span>Lịch sử thuê</span>
            </div>
        </div>
    </div>
</section>

<!-- Main Profile Content -->
<main class="profile-main">
    <div class="container">
        <div class="profile-layout">
            <!-- Profile Sidebar -->
            <aside class="profile-sidebar">
                <div class="profile-user-card">
                    <div class="user-avatar">
                        <?php if (isset($_SESSION['user_avatar']) && !empty($_SESSION['user_avatar'])): ?>
                            <img src="./uploads/avatar/<?= $_SESSION['user_avatar'] ?>" alt="Avatar">
                        <?php else: ?>
                            <img src="../logo.jpg" alt="Default Avatar">
                        <?php endif; ?>
                        <div class="avatar-status online"></div>
                    </div>
                    <div class="user-info">
                        <h3><?= htmlspecialchars($_SESSION['user_name'] ?? 'Người dùng') ?></h3>
                        <p><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></p>
                        <div class="user-badge">
                            <i class="fas fa-shield-alt"></i>
                            Thành viên
                        </div>
                    </div>
                </div>
                
                <nav class="profile-menu">
                    <a href="?act=profile" class="menu-item">
                        <i class="fas fa-user"></i>
                        <span>Thông tin cá nhân</span>
                    </a>
                    <a href="?act=changePassword" class="menu-item">
                        <i class="fas fa-lock"></i>
                        <span>Đổi mật khẩu</span>
                    </a>
                    <a href="?act=brokerProperty" class="menu-item">
                        <i class="fas fa-home"></i>
                        <span>BĐS của tôi</span>
                    </a>
                    <a href="?act=saveProperty" class="menu-item">
                        <i class="fas fa-heart"></i>
                        <span>BĐS đã lưu</span>
                    </a>
                    <a href="?act=userRentals" class="menu-item active">
                        <i class="fas fa-history"></i>
                        <span>Lịch sử thuê</span>
                    </a>
                    <a href="?act=followBroker" class="menu-item">
                        <i class="fas fa-user-friends"></i>
                        <span>Môi giới theo dõi</span>
                    </a>
                    <a href="?act=consultationRequest" class="menu-item">
                        <i class="fas fa-comments"></i>
                        <span>Yêu cầu tư vấn</span>
                    </a>
                </nav>
            </aside>

            <!-- Profile Content -->
            <div class="profile-content">
                <div class="content-header">
                    <h2>Lịch sử thuê</h2>
                    <p>Quản lý các hợp đồng thuê bất động sản của bạn</p>
                </div>

                <!-- Rental Stats -->
                <div class="rental-stats">
                    <div class="stat-card">
                        <div class="stat-icon active">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3>3</h3>
                            <p>Đang thuê</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon completed">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3>12</h3>
                            <p>Đã hoàn thành</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon pending">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h3>2</h3>
                            <p>Chờ xử lý</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon total">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="stat-info">
                            <h3>850M</h3>
                            <p>Tổng thanh toán</p>
                        </div>
                    </div>
                </div>

                <!-- Filter and Search -->
                <div class="content-filters">
                    <div class="filter-tabs">
                        <button class="filter-tab active" data-filter="all">
                            <i class="fas fa-list"></i>
                            Tất cả
                        </button>
                        <button class="filter-tab" data-filter="active">
                            <i class="fas fa-play-circle"></i>
                            Đang thuê
                        </button>
                        <button class="filter-tab" data-filter="completed">
                            <i class="fas fa-check-circle"></i>
                            Đã hoàn thành
                        </button>
                        <button class="filter-tab" data-filter="pending">
                            <i class="fas fa-clock"></i>
                            Chờ xử lý
                        </button>
                    </div>
                    <div class="filter-search">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Tìm kiếm theo tên BĐS...">
                        </div>
                    </div>
                </div>

                <!-- Rental List -->
                <div class="rental-list">
                    <!-- Active Rental -->
                    <div class="rental-card" data-status="active">
                        <div class="rental-image">
                            <img src="../1.jpg" alt="Căn hộ Vinhomes">
                            <div class="rental-status active">
                                <i class="fas fa-play-circle"></i>
                                Đang thuê
                            </div>
                        </div>
                        <div class="rental-content">
                            <h3 class="rental-title">Căn hộ cao cấp Vinhomes Central Park</h3>
                            <p class="rental-location">
                                <i class="fas fa-map-marker-alt"></i>
                                Quận Bình Thạnh, TP.HCM
                            </p>
                            <div class="rental-details">
                                <div class="detail-row">
                                    <span class="label">Giá thuê:</span>
                                    <span class="value">25 triệu/tháng</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Ngày bắt đầu:</span>
                                    <span class="value">01/01/2024</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Ngày kết thúc:</span>
                                    <span class="value">31/12/2024</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Thời gian còn lại:</span>
                                    <span class="value highlight">8 tháng 15 ngày</span>
                                </div>
                            </div>
                            <div class="rental-actions">
                                <button class="btn btn-outline btn-sm">
                                    <i class="fas fa-file-contract"></i>
                                    Xem hợp đồng
                                </button>
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-credit-card"></i>
                                    Thanh toán
                                </button>
                                <button class="btn btn-outline btn-sm">
                                    <i class="fas fa-phone"></i>
                                    Liên hệ
                                </button>
                            </div>
                        </div>
                        <div class="rental-meta">
                            <div class="payment-status paid">
                                <i class="fas fa-check-circle"></i>
                                Đã thanh toán tháng này
                            </div>
                            <div class="next-payment">
                                Thanh toán tiếp theo: <strong>01/10/2024</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Rental -->
                    <div class="rental-card" data-status="completed">
                        <div class="rental-image">
                            <img src="../2.png" alt="Nhà phố Sài Gòn South">
                            <div class="rental-status completed">
                                <i class="fas fa-check-circle"></i>
                                Đã hoàn thành
                            </div>
                        </div>
                        <div class="rental-content">
                            <h3 class="rental-title">Nhà phố liền kề Sài Gòn South</h3>
                            <p class="rental-location">
                                <i class="fas fa-map-marker-alt"></i>
                                Quận 7, TP.HCM
                            </p>
                            <div class="rental-details">
                                <div class="detail-row">
                                    <span class="label">Giá thuê:</span>
                                    <span class="value">35 triệu/tháng</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Ngày bắt đầu:</span>
                                    <span class="value">01/06/2023</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Ngày kết thúc:</span>
                                    <span class="value">31/05/2024</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Thời gian thuê:</span>
                                    <span class="value">12 tháng</span>
                                </div>
                            </div>
                            <div class="rental-actions">
                                <button class="btn btn-outline btn-sm">
                                    <i class="fas fa-file-contract"></i>
                                    Xem hợp đồng
                                </button>
                                <button class="btn btn-outline btn-sm">
                                    <i class="fas fa-download"></i>
                                    Tải hóa đơn
                                </button>
                                <button class="btn btn-outline btn-sm">
                                    <i class="fas fa-star"></i>
                                    Đánh giá
                                </button>
                            </div>
                        </div>
                        <div class="rental-meta">
                            <div class="payment-status completed">
                                <i class="fas fa-check-circle"></i>
                                Hoàn thành thanh toán
                            </div>
                            <div class="rating">
                                <span>Đánh giá:</span>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Rental -->
                    <div class="rental-card" data-status="pending">
                        <div class="rental-image">
                            <img src="../3.jpg" alt="Chung cư Masteri">
                            <div class="rental-status pending">
                                <i class="fas fa-clock"></i>
                                Chờ xử lý
                            </div>
                        </div>
                        <div class="rental-content">
                            <h3 class="rental-title">Chung cư Masteri Thảo Điền</h3>
                            <p class="rental-location">
                                <i class="fas fa-map-marker-alt"></i>
                                Quận 2, TP.HCM
                            </p>
                            <div class="rental-details">
                                <div class="detail-row">
                                    <span class="label">Giá thuê:</span>
                                    <span class="value">18 triệu/tháng</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Ngày yêu cầu:</span>
                                    <span class="value">15/09/2024</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Thời gian thuê:</span>
                                    <span class="value">6 tháng</span>
                                </div>
                                <div class="detail-row">
                                    <span class="label">Trạng thái:</span>
                                    <span class="value pending">Chờ chủ nhà xác nhận</span>
                                </div>
                            </div>
                            <div class="rental-actions">
                                <button class="btn btn-outline btn-sm">
                                    <i class="fas fa-eye"></i>
                                    Xem chi tiết
                                </button>
                                <button class="btn btn-outline btn-sm">
                                    <i class="fas fa-edit"></i>
                                    Chỉnh sửa
                                </button>
                                <button class="btn btn-outline btn-sm text-danger">
                                    <i class="fas fa-times"></i>
                                    Hủy yêu cầu
                                </button>
                            </div>
                        </div>
                        <div class="rental-meta">
                            <div class="payment-status pending">
                                <i class="fas fa-clock"></i>
                                Chờ xác nhận từ chủ nhà
                            </div>
                            <div class="estimated-time">
                                Thời gian xử lý dự kiến: <strong>2-3 ngày</strong>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Empty State -->
                <div class="empty-state" style="display: none;">
                    <div class="empty-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3>Chưa có lịch sử thuê</h3>
                    <p>Bạn chưa có bất động sản nào trong lịch sử thuê</p>
                    <a href="?act=listProperty" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Tìm bất động sản
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const rentalCards = document.querySelectorAll('.rental-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            filterTabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            // Show/hide rental cards based on filter
            rentalCards.forEach(card => {
                if (filter === 'all' || card.getAttribute('data-status') === filter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Search functionality
    const searchInput = document.querySelector('.search-box input');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        rentalCards.forEach(card => {
            const title = card.querySelector('.rental-title').textContent.toLowerCase();
            if (title.includes(searchTerm)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>
                            <div class="filter-tabs">
                                <button class="tab-btn active" data-status="all">Tất cả (3)</button>
                                <button class="tab-btn" data-status="active">Đang thuê (2)</button>
                                <button class="tab-btn" data-status="ending">Sắp hết hạn (1)</button>
                                <button class="tab-btn" data-status="expired">Đã hết hạn (0)</button>
                            </div>
                        </div>
                    </div>

                    <!-- Rental Properties List -->
                    <div class="rentals-list">
                        <!-- Active Rental -->
                        <div class="rental-item" data-status="active">
                            <div class="rental-card">
                                <div class="property-image">
                                    <img src="/placeholder.svg?height=150&width=200" alt="Property">
                                    <div class="rental-status active">Đang thuê</div>
                                </div>
                                <div class="property-info">
                                    <h3><a href="property-detail.html">Căn hộ cao cấp Vinhomes Central Park</a></h3>
                                    <p class="location"><i class="fas fa-map-marker-alt"></i> Quận 1, TP.HCM</p>
                                    <p class="price">25 triệu/tháng</p>
                                    <div class="property-features">
                                        <span><i class="fas fa-bed"></i> 2 phòng ngủ</span>
                                        <span><i class="fas fa-bath"></i> 2 phòng tắm</span>
                                        <span><i class="fas fa-expand-arrows-alt"></i> 80m²</span>
                                    </div>
                                </div>
                                <div class="rental-details">
                                    <div class="rental-info">
                                        <div class="info-item">
                                            <span class="label">Ngày bắt đầu:</span>
                                            <span class="value">15/01/2024</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label">Ngày kết thúc:</span>
                                            <span class="value">15/01/2025</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label">Thời gian còn lại:</span>
                                            <span class="value remaining">8 tháng 12 ngày</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label">Tiền cọc:</span>
                                            <span class="value">50 triệu</span>
                                        </div>
                                    </div>
                                    <div class="agent-contact">
                                        <div class="agent-info">
                                            <img src="/placeholder.svg?height=40&width=40" alt="Agent">
                                            <div>
                                                <h4>Nguyễn Văn A</h4>
                                                <p>Môi giới</p>
                                            </div>
                                        </div>
                                        <div class="contact-actions">
                                            <button class="btn btn-sm btn-outline">
                                                <i class="fas fa-phone"></i>
                                                Gọi
                                            </button>
                                            <button class="btn btn-sm btn-outline">
                                                <i class="fas fa-comment"></i>
                                                Nhắn tin
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="rental-actions">
                                    <button class="action-btn" title="Xem hợp đồng">
                                        <i class="fas fa-file-contract"></i>
                                        Hợp đồng
                                    </button>
                                    <button class="action-btn" title="Lịch sử thanh toán">
                                        <i class="fas fa-history"></i>
                                        Thanh toán
                                    </button>
                                    <button class="action-btn" title="Gia hạn">
                                        <i class="fas fa-redo"></i>
                                        Gia hạn
                                    </button>
                                    <button class="action-btn" title="Báo cáo sự cố">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Báo cáo
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Another Active Rental -->
                        <div class="rental-item" data-status="active">
                            <div class="rental-card">
                                <div class="property-image">
                                    <img src="/placeholder.svg?height=150&width=200" alt="Property">
                                    <div class="rental-status active">Đang thuê</div>
                                </div>
                                <div class="property-info">
                                    <h3><a href="property-detail.html">Phòng trọ cao cấp full nội thất</a></h3>
                                    <p class="location"><i class="fas fa-map-marker-alt"></i> Quận Bình Thạnh, TP.HCM</p>
                                    <p class="price">6 triệu/tháng</p>
                                    <div class="property-features">
                                        <span><i class="fas fa-bed"></i> 1 phòng ngủ</span>
                                        <span><i class="fas fa-bath"></i> 1 phòng tắm</span>
                                        <span><i class="fas fa-expand-arrows-alt"></i> 25m²</span>
                                    </div>
                                </div>
                                <div class="rental-details">
                                    <div class="rental-info">
                                        <div class="info-item">
                                            <span class="label">Ngày bắt đầu:</span>
                                            <span class="value">01/02/2024</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label">Ngày kết thúc:</span>
                                            <span class="value">01/02/2025</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label">Thời gian còn lại:</span>
                                            <span class="value remaining">8 tháng 28 ngày</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label">Tiền cọc:</span>
                                            <span class="value">12 triệu</span>
                                        </div>
                                    </div>
                                    <div class="agent-contact">
                                        <div class="agent-info">
                                            <img src="/placeholder.svg?height=40&width=40" alt="Agent">
                                            <div>
                                                <h4>Trần Thị B</h4>
                                                <p>Môi giới</p>
                                            </div>
                                        </div>
                                        <div class="contact-actions">
                                            <button class="btn btn-sm btn-outline">
                                                <i class="fas fa-phone"></i>
                                                Gọi
                                            </button>
                                            <button class="btn btn-sm btn-outline">
                                                <i class="fas fa-comment"></i>
                                                Nhắn tin
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="rental-actions">
                                    <button class="action-btn" title="Xem hợp đồng">
                                        <i class="fas fa-file-contract"></i>
                                        Hợp đồng
                                    </button>
                                    <button class="action-btn" title="Lịch sử thanh toán">
                                        <i class="fas fa-history"></i>
                                        Thanh toán
                                    </button>
                                    <button class="action-btn" title="Gia hạn">
                                        <i class="fas fa-redo"></i>
                                        Gia hạn
                                    </button>
                                    <button class="action-btn" title="Báo cáo sự cố">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Báo cáo
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Ending Soon Rental -->
                        <div class="rental-item" data-status="ending">
                            <div class="rental-card">
                                <div class="property-image">
                                    <img src="/placeholder.svg?height=150&width=200" alt="Property">
                                    <div class="rental-status ending">Sắp hết hạn</div>
                                </div>
                                <div class="property-info">
                                    <h3><a href="property-detail.html">Văn phòng hạng A tòa nhà Bitexco</a></h3>
                                    <p class="location"><i class="fas fa-map-marker-alt"></i> Quận 1, TP.HCM</p>
                                    <p class="price">50 triệu/tháng</p>
                                    <div class="property-features">
                                        <span><i class="fas fa-users"></i> 50 chỗ ngồi</span>
                                        <span><i class="fas fa-car"></i> Bãi đỗ xe</span>
                                        <span><i class="fas fa-expand-arrows-alt"></i> 200m²</span>
                                    </div>
                                </div>
                                <div class="rental-details">
                                    <div class="rental-info">
                                        <div class="info-item">
                                            <span class="label">Ngày bắt đầu:</span>
                                            <span class="value">15/05/2023</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label">Ngày kết thúc:</span>
                                            <span class="value">15/05/2024</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label">Thời gian còn lại:</span>
                                            <span class="value ending">15 ngày</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="label">Tiền cọc:</span>
                                            <span class="value">100 triệu</span>
                                        </div>
                                    </div>
                                    <div class="agent-contact">
                                        <div class="agent-info">
                                            <img src="/placeholder.svg?height=40&width=40" alt="Agent">
                                            <div>
                                                <h4>Lê Văn C</h4>
                                                <p>Môi giới</p>
                                            </div>
                                        </div>
                                        <div class="contact-actions">
                                            <button class="btn btn-sm btn-outline">
                                                <i class="fas fa-phone"></i>
                                                Gọi
                                            </button>
                                            <button class="btn btn-sm btn-outline">
                                                <i class="fas fa-comment"></i>
                                                Nhắn tin
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="rental-actions">
                                    <button class="action-btn" title="Xem hợp đồng">
                                        <i class="fas fa-file-contract"></i>
                                        Hợp đồng
                                    </button>
                                    <button class="action-btn" title="Lịch sử thanh toán">
                                        <i class="fas fa-history"></i>
                                        Thanh toán
                                    </button>
                                    <button class="action-btn urgent" title="Gia hạn ngay">
                                        <i class="fas fa-redo"></i>
                                        Gia hạn ngay
                                    </button>
                                    <button class="action-btn" title="Báo cáo sự cố">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Báo cáo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div class="empty-state" style="display: none;">
                        <div class="empty-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <h3>Chưa có bất động sản nào đang thuê</h3>
                        <p>Bạn chưa thuê bất động sản nào. Hãy tìm kiếm và thuê ngay!</p>
                        <a href="properties.html" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Tìm BĐS để thuê
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>