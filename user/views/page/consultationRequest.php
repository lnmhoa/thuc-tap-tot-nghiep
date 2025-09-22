<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <div class="page-title">
                <h1><i class="fas fa-comments"></i> Yêu cầu tư vấn</h1>
                <p>Quản lý và gửi yêu cầu tư vấn bất động sản</p>
            </div>
            <div class="breadcrumb">
                <a href="index.php"><i class="fas fa-home"></i> Trang chủ</a>
                <span>/</span>
                <a href="?act=profile">Hồ sơ</a>
                <span>/</span>
                <span>Yêu cầu tư vấn</span>
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
                    <a href="?act=userRentals" class="menu-item">
                        <i class="fas fa-history"></i>
                        <span>Lịch sử thuê</span>
                    </a>
                    <a href="?act=followBroker" class="menu-item">
                        <i class="fas fa-user-friends"></i>
                        <span>Môi giới theo dõi</span>
                    </a>
                    <a href="?act=consultationRequest" class="menu-item active">
                        <i class="fas fa-comments"></i>
                        <span>Yêu cầu tư vấn</span>
                    </a>
                </nav>
            </aside>

            <!-- Profile Content -->
            <div class="profile-content">
                <!-- Tab Navigation -->
                <div class="consultation-tabs">
                    <button class="tab-btn active" data-tab="requests">
                        <i class="fas fa-list"></i>
                        Yêu cầu của tôi
                    </button>
                    <button class="tab-btn" data-tab="new-request">
                        <i class="fas fa-plus"></i>
                        Tạo yêu cầu mới
                    </button>
                </div>

                <!-- Tab Content: My Requests -->
                <div class="tab-content active" id="requests">
                    <div class="content-header">
                        <h2>Yêu cầu tư vấn của tôi</h2>
                        <p>Theo dõi trạng thái và quản lý các yêu cầu tư vấn</p>
                    </div>

                    <!-- Consultation Stats -->
                    <div class="consultation-stats">
                        <div class="stat-card">
                            <div class="stat-icon total">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="stat-info">
                                <h3>12</h3>
                                <p>Tổng yêu cầu</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon pending">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-info">
                                <h3>3</h3>
                                <p>Chờ phản hồi</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon active">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="stat-info">
                                <h3>2</h3>
                                <p>Đang tư vấn</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon completed">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-info">
                                <h3>7</h3>
                                <p>Hoàn thành</p>
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
                            <button class="filter-tab" data-filter="pending">
                                <i class="fas fa-clock"></i>
                                Chờ phản hồi
                            </button>
                            <button class="filter-tab" data-filter="active">
                                <i class="fas fa-phone"></i>
                                Đang tư vấn
                            </button>
                            <button class="filter-tab" data-filter="completed">
                                <i class="fas fa-check-circle"></i>
                                Hoàn thành
                            </button>
                        </div>
                        <div class="filter-actions">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" placeholder="Tìm kiếm yêu cầu...">
                            </div>
                        </div>
                    </div>

                    <!-- Consultation Requests List -->
                    <div class="consultation-requests-list">
                        <!-- Active Request -->
                        <div class="request-card" data-status="active">
                            <div class="request-header">
                                <div class="request-info">
                                    <h3>Tư vấn mua căn hộ 2PN tại Quận 7</h3>
                                    <div class="request-meta">
                                        <span class="request-id">#CR001</span>
                                        <span class="request-date">
                                            <i class="fas fa-calendar"></i>
                                            15/09/2024
                                        </span>
                                        <span class="request-type">
                                            <i class="fas fa-tag"></i>
                                            Mua bán
                                        </span>
                                    </div>
                                </div>
                                <div class="request-status">
                                    <span class="status active">
                                        <i class="fas fa-phone"></i>
                                        Đang tư vấn
                                    </span>
                                </div>
                            </div>
                            
                            <div class="request-details">
                                <div class="detail-item">
                                    <strong>Loại BĐS:</strong> Căn hộ chung cư
                                </div>
                                <div class="detail-item">
                                    <strong>Khu vực:</strong> Quận 7, TP.HCM
                                </div>
                                <div class="detail-item">
                                    <strong>Ngân sách:</strong> 3-4 tỷ
                                </div>
                                <div class="detail-item">
                                    <strong>Yêu cầu:</strong> 2 phòng ngủ, gần trường học, có bãi đậu xe
                                </div>
                            </div>

                            <div class="consultant-info">
                                <div class="consultant-avatar">
                                    <img src="../admin/uploads/broker/688614ebb3040.png" alt="Tư vấn viên" onerror="this.src='../logo.jpg'">
                                </div>
                                <div class="consultant-details">
                                    <h4>Nguyễn Văn Minh</h4>
                                    <p>Chuyên viên tư vấn BĐS</p>
                                    <div class="consultant-contact">
                                        <span><i class="fas fa-phone"></i> 0901234567</span>
                                        <span><i class="fas fa-envelope"></i> minh@ehome.com</span>
                                    </div>
                                </div>
                                <div class="consultant-actions">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-phone"></i>
                                        Gọi điện
                                    </button>
                                    <button class="btn btn-outline btn-sm">
                                        <i class="fas fa-comment"></i>
                                        Nhắn tin
                                    </button>
                                </div>
                            </div>

                            <div class="request-actions">
                                <button class="btn btn-outline btn-sm">
                                    <i class="fas fa-eye"></i>
                                    Chi tiết
                                </button>
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i>
                                    Hoàn thành
                                </button>
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-times"></i>
                                    Hủy
                                </button>
                            </div>
                        </div>

                        <!-- Pending Request -->
                        <div class="request-card" data-status="pending">
                            <div class="request-header">
                                <div class="request-info">
                                    <h3>Tư vấn thuê nhà phố tại Quận Bình Thạnh</h3>
                                    <div class="request-meta">
                                        <span class="request-id">#CR002</span>
                                        <span class="request-date">
                                            <i class="fas fa-calendar"></i>
                                            12/09/2024
                                        </span>
                                        <span class="request-type">
                                            <i class="fas fa-key"></i>
                                            Cho thuê
                                        </span>
                                    </div>
                                </div>
                                <div class="request-status">
                                    <span class="status pending">
                                        <i class="fas fa-clock"></i>
                                        Chờ phản hồi
                                    </span>
                                </div>
                            </div>
                            
                            <div class="request-details">
                                <div class="detail-item">
                                    <strong>Loại BĐS:</strong> Nhà phố
                                </div>
                                <div class="detail-item">
                                    <strong>Khu vực:</strong> Quận Bình Thạnh, TP.HCM
                                </div>
                                <div class="detail-item">
                                    <strong>Ngân sách:</strong> 15-25 triệu/tháng
                                </div>
                                <div class="detail-item">
                                    <strong>Yêu cầu:</strong> 3-4 phòng ngủ, có sân vườn, gần chợ
                                </div>
                            </div>

                            <div class="pending-notice">
                                <i class="fas fa-info-circle"></i>
                                <span>Yêu cầu đang được xử lý. Chúng tôi sẽ liên hệ với bạn trong vòng 24 giờ.</span>
                            </div>

                            <div class="request-actions">
                                <button class="btn btn-outline btn-sm">
                                    <i class="fas fa-eye"></i>
                                    Chi tiết
                                </button>
                                <button class="btn btn-outline btn-sm">
                                    <i class="fas fa-edit"></i>
                                    Chỉnh sửa
                                </button>
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-times"></i>
                                    Hủy
                                </button>
                            </div>
                        </div>

                        <!-- Completed Request -->
                        <div class="request-card" data-status="completed">
                            <div class="request-header">
                                <div class="request-info">
                                    <h3>Tư vấn mua đất nền tại Củ Chi</h3>
                                    <div class="request-meta">
                                        <span class="request-id">#CR003</span>
                                        <span class="request-date">
                                            <i class="fas fa-calendar"></i>
                                            05/09/2024
                                        </span>
                                        <span class="request-type">
                                            <i class="fas fa-map"></i>
                                            Đất nền
                                        </span>
                                    </div>
                                </div>
                                <div class="request-status">
                                    <span class="status completed">
                                        <i class="fas fa-check-circle"></i>
                                        Hoàn thành
                                    </span>
                                </div>
                            </div>
                            
                            <div class="request-details">
                                <div class="detail-item">
                                    <strong>Loại BĐS:</strong> Đất nền
                                </div>
                                <div class="detail-item">
                                    <strong>Khu vực:</strong> Huyện Củ Chi, TP.HCM
                                </div>
                                <div class="detail-item">
                                    <strong>Ngân sách:</strong> 1-2 tỷ
                                </div>
                                <div class="detail-item">
                                    <strong>Kết quả:</strong> Đã được tư vấn và giới thiệu 5 lô đất phù hợp
                                </div>
                            </div>

                            <div class="completion-info">
                                <div class="completion-date">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span>Hoàn thành ngày 10/09/2024</span>
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

                            <div class="request-actions">
                                <button class="btn btn-outline btn-sm">
                                    <i class="fas fa-eye"></i>
                                    Chi tiết
                                </button>
                                <button class="btn btn-outline btn-sm">
                                    <i class="fas fa-download"></i>
                                    Tải báo cáo
                                </button>
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i>
                                    Tạo yêu cầu mới
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Content: New Request -->
                <div class="tab-content" id="new-request">
                    <div class="content-header">
                        <h2>Tạo yêu cầu tư vấn mới</h2>
                        <p>Điền thông tin chi tiết để nhận được tư vấn phù hợp nhất</p>
                    </div>

                    <div class="consultation-form-container">
                        <form class="profile-form consultation-form">
                            <!-- Contact Information -->
                            <div class="form-section">
                                <h3>Thông tin liên lạc</h3>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="fullName">Họ và tên <span class="required">*</span></label>
                                        <div class="input-group">
                                            <i class="fas fa-user"></i>
                                            <input type="text" id="fullName" name="fullName" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại <span class="required">*</span></label>
                                        <div class="input-group">
                                            <i class="fas fa-phone"></i>
                                            <input type="tel" id="phone" name="phone" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <div class="input-group">
                                            <i class="fas fa-envelope"></i>
                                            <input type="email" id="email" name="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="preferredTime">Thời gian liên hệ</label>
                                        <div class="input-group">
                                            <i class="fas fa-clock"></i>
                                            <select id="preferredTime" name="preferredTime">
                                                <option value="">Bất kỳ lúc nào</option>
                                                <option value="morning">Buổi sáng (8h-12h)</option>
                                                <option value="afternoon">Buổi chiều (13h-17h)</option>
                                                <option value="evening">Buổi tối (18h-21h)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Property Requirements -->
                            <div class="form-section">
                                <h3>Nhu cầu bất động sản</h3>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="propertyType">Loại bất động sản <span class="required">*</span></label>
                                        <div class="input-group">
                                            <i class="fas fa-home"></i>
                                            <select id="propertyType" name="propertyType" required>
                                                <option value="">Chọn loại BĐS</option>
                                                <option value="apartment">Căn hộ chung cư</option>
                                                <option value="house">Nhà phố</option>
                                                <option value="villa">Biệt thự</option>
                                                <option value="land">Đất nền</option>
                                                <option value="office">Văn phòng</option>
                                                <option value="shop">Shophouse</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="transactionType">Loại giao dịch <span class="required">*</span></label>
                                        <div class="input-group">
                                            <i class="fas fa-handshake"></i>
                                            <select id="transactionType" name="transactionType" required>
                                                <option value="">Chọn loại giao dịch</option>
                                                <option value="buy">Mua</option>
                                                <option value="rent">Thuê</option>
                                                <option value="sell">Bán</option>
                                                <option value="lease">Cho thuê</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="location">Khu vực quan tâm <span class="required">*</span></label>
                                        <div class="input-group">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <input type="text" id="location" name="location" required placeholder="VD: Quận 1, TP.HCM">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="budget">Ngân sách</label>
                                        <div class="input-group">
                                            <i class="fas fa-dollar-sign"></i>
                                            <input type="text" id="budget" name="budget" placeholder="VD: 2-3 tỷ hoặc 15-20 triệu/tháng">
                                        </div>
                                    </div>
                                    <div class="form-group full-width">
                                        <label for="requirements">Yêu cầu chi tiết</label>
                                        <div class="input-group">
                                            <i class="fas fa-list"></i>
                                            <textarea id="requirements" name="requirements" rows="4" placeholder="Mô tả chi tiết về yêu cầu của bạn (số phòng, tiện ích, vị trí cụ thể...)"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i>
                                    Gửi yêu cầu
                                </button>
                                <button type="reset" class="btn btn-outline">
                                    <i class="fas fa-undo"></i>
                                    Làm mới
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all tabs and contents
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });
    
    // Filter functionality
    const filterTabs = document.querySelectorAll('.filter-tab');
    const requestCards = document.querySelectorAll('.request-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            requestCards.forEach(card => {
                if (filter === 'all' || card.getAttribute('data-status') === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>

                            <div class="form-group">
                                <label>Loại giao dịch *</label>
                                <div class="radio-group">
                                    <label class="radio-item">
                                        <input type="radio" name="transaction_type" value="rent" required>
                                        <span>Thuê</span>
                                    </label>
                                    <label class="radio-item">
                                        <input type="radio" name="transaction_type" value="buy" required>
                                        <span>Mua</span>
                                    </label>
                                    <label class="radio-item">
                                        <input type="radio" name="transaction_type" value="sell" required>
                                        <span>Bán</span>
                                    </label>
                                    <label class="radio-item">
                                        <input type="radio" name="transaction_type" value="invest" required>
                                        <span>Đầu tư</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Property Type -->
                            <div class="form-group">
                                <label>Loại bất động sản *</label>
                                <div class="checkbox-group">
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="property_type" value="apartment">
                                        <span>Căn hộ</span>
                                    </label>
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="property_type" value="house">
                                        <span>Nhà phố</span>
                                    </label>
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="property_type" value="office">
                                        <span>Văn phòng</span>
                                    </label>
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="property_type" value="room">
                                        <span>Phòng trọ</span>
                                    </label>
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="property_type" value="land">
                                        <span>Đất nền</span>
                                    </label>
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="property_type" value="villa">
                                        <span>Biệt thự</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="form-group">
                                <label>Khu vực mong muốn *</label>
                                <div class="location-grid">
                                    <select name="city" required>
                                        <option value="">Chọn tỉnh/thành phố</option>
                                        <option value="hcm">TP. Hồ Chí Minh</option>
                                        <option value="hn">Hà Nội</option>
                                        <option value="dn">Đà Nẵng</option>
                                        <option value="hp">Hải Phòng</option>
                                        <option value="ct">Cần Thơ</option>
                                    </select>
                                    <select name="district">
                                        <option value="">Chọn quận/huyện</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Budget -->
                            <div class="form-group">
                                <label>Khoảng giá mong muốn *</label>
                                <div class="budget-range">
                                    <div class="range-inputs">
                                        <input type="number" name="budget_from" placeholder="Từ" required>
                                        <span>-</span>
                                        <input type="number" name="budget_to" placeholder="Đến">
                                    </div>
                                    <select name="budget_unit">
                                        <option value="million">Triệu VNĐ</option>
                                        <option value="billion">Tỷ VNĐ</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Area -->
                            <div class="form-group">
                                <label>Diện tích mong muốn (m²)</label>
                                <div class="area-range">
                                    <input type="number" name="area_from" placeholder="Từ">
                                    <span>-</span>
                                    <input type="number" name="area_to" placeholder="Đến">
                                </div>
                            </div>

                            <!-- Rooms -->
                            <div class="form-group">
                                <label>Số phòng</label>
                                <div class="rooms-selection">
                                    <div class="room-type">
                                        <label>Phòng ngủ</label>
                                        <select name="bedrooms">
                                            <option value="">Không yêu cầu</option>
                                            <option value="1">1 phòng</option>
                                            <option value="2">2 phòng</option>
                                            <option value="3">3 phòng</option>
                                            <option value="4">4 phòng</option>
                                            <option value="5+">5+ phòng</option>
                                        </select>
                                    </div>
                                    <div class="room-type">
                                        <label>Phòng tắm</label>
                                        <select name="bathrooms">
                                            <option value="">Không yêu cầu</option>
                                            <option value="1">1 phòng</option>
                                            <option value="2">2 phòng</option>
                                            <option value="3">3 phòng</option>
                                            <option value="4+">4+ phòng</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Agent Preference -->
                        <div class="form-section">
                            <h3><i class="fas fa-user-tie"></i> Yêu cầu về môi giới</h3>
                            <div class="form-group">
                                <label>Giới tính môi giới mong muốn</label>
                                <div class="radio-group">
                                    <label class="radio-item">
                                        <input type="radio" name="agent_gender" value="any">
                                        <span>Không yêu cầu</span>
                                    </label>
                                    <label class="radio-item">
                                        <input type="radio" name="agent_gender" value="male">
                                        <span>Nam</span>
                                    </label>
                                    <label class="radio-item">
                                        <input type="radio" name="agent_gender" value="female">
                                        <span>Nữ</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Kinh nghiệm môi giới</label>
                                <select name="agent_experience">
                                    <option value="">Không yêu cầu</option>
                                    <option value="1-2">1-2 năm</option>
                                    <option value="3-5">3-5 năm</option>
                                    <option value="5+">Trên 5 năm</option>
                                </select>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="form-section">
                            <h3><i class="fas fa-comment"></i> Thông tin bổ sung</h3>
                            <div class="form-group">
                                <label for="urgency">Mức độ cấp thiết</label>
                                <select id="urgency" name="urgency">
                                    <option value="normal">Bình thường</option>
                                    <option value="urgent">Cấp thiết (trong 1 tuần)</option>
                                    <option value="very_urgent">Rất cấp thiết (trong 3 ngày)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="notes">Ghi chú thêm</label>
                                <textarea id="notes" name="notes" rows="4" placeholder="Mô tả chi tiết về yêu cầu của bạn, ví dụ: gần trường học, có chỗ đỗ xe, view đẹp..."></textarea>
                            </div>
                        </div>

                        <!-- Terms -->

                        <div class="terms-agreement">
                            <label class="checkbox-item">
                                <input type="checkbox" name="terms" required>
                                <span>Tôi đồng ý cho E-HOME và các môi giới liên hệ để tư vấn</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="privacy" required>
                                <span>Tôi đã đọc và đồng ý với <a href="#" target="_blank">Chính sách bảo mật</a></span>
                            </label>
                        </div>


                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                                Gửi yêu cầu tư vấn
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<style>
    .consultation-page {
        margin-top: 3rem;
    }

    .consultation-page .container {
        max-width: 980px;
        margin: 0 auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
    }

    .page-layout {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .tab-btn {
        background: #e9ecef;
        color: #4e73df;
        border: none;
        padding: 12px 28px;
        border-radius: 8px 8px 0 0;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .tab-btn.active {
        background: #4e73df;
        color: #fff;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .consultation-form-container {
        background: #f8f9fc;
        border-radius: 10px;
        padding: 28px 24px;
        box-shadow: 0 1px 8px rgba(0, 0, 0, 0.04);
    }

    .form-header h2 {
        font-size: 1.5rem;
        margin-bottom: 6px;
    }

    .form-header p {
        color: #666;
        margin-bottom: 18px;
    }

    .consultation-form .form-section {
        margin-bottom: 28px;
    }

    .consultation-form h3 {
        font-size: 1.15rem;
        color: #4e73df;
        margin-bottom: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 6px;
        display: block;
        color: #222;
    }

    input[type="text"],
    input[type="tel"],
    input[type="email"],
    input[type="number"],
    select,
    textarea {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #d1d3e2;
        border-radius: 6px;
        font-size: 1rem;
        background: #fff;
        transition: border-color 0.2s;
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: #4e73df;
        outline: none;
    }

    .radio-group,
    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
    }

    .radio-item,
    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 1rem;
        cursor: pointer;
    }

    input[type="radio"],
    input[type="checkbox"] {
        accent-color: #4e73df;
        width: 18px;
        height: 18px;
    }

    .location-grid {
        display: flex;
        gap: 18px;
    }

    .budget-range,
    .area-range {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .range-inputs {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rooms-selection {
        display: flex;
        gap: 24px;
    }

    .room-type label {
        font-weight: 500;
        margin-bottom: 4px;
        display: block;
    }

    .terms-agreement {
        display: flex;
        gap: 24px;
        align-items: center;
        margin-top: 8px;
    }

    .terms-agreement a {
        color: #4e73df;
        text-decoration: underline;
    }

    .form-actions {
        display: flex;
        gap: 18px;
        justify-content: flex-end;
        margin-top: 18px;
    }

    .btn {
        padding: 10px 22px;
        border-radius: 6px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .btn-primary {
        background: #4e73df;
        color: #fff;
    }


    .btn-primary:hover{
        opacity: 0.85;
    }

    .requests-header {
        margin-bottom: 18px;
    }

    .filter-tabs {
        display: flex;
        gap: 12px;
        margin-top: 8px;
    }

    .filter-btn {
        background: #e9ecef;
        color: #4e73df;
        border: none;
        padding: 7px 18px;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
    }

    .filter-btn.active {
        background: #4e73df;
        color: #fff;
    }

    .requests-list {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .request-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 8px rgba(0, 0, 0, 0.04);
        padding: 18px 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .request-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }

    .request-info h3 {
        font-size: 1.1rem;
        color: #222;
        margin-bottom: 4px;
    }

    .request-meta {
        font-size: 0.95rem;
        color: #666;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .request-status {
        padding: 2px 8px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .request-status.pending {
        background: #fff3cd;
        color: #856404;
    }

    .request-status.processing {
        background: #d1ecf1;
        color: #0c5460;
    }

    .request-status.completed {
        background: #d4edda;
        color: #155724;
    }

    .request-actions {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        background: #e9ecef;
        border: none;
        color: #4e73df;
        padding: 7px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
    }

    .action-btn:hover {
        background: #4e73df;
        color: #fff;
    }

    .request-details,
    .completion-info,
    .assigned-agent {
        margin-top: 8px;
        font-size: 0.98rem;
    }

    .detail-item {
        display: flex;
        gap: 6px;
        margin-bottom: 3px;
    }

    .detail-item .label {
        color: #666;
        min-width: 110px;
        font-weight: 500;
    }

    .detail-item .value {
        color: #222;
    }

    .value.success {
        color: #1cc88a;
        font-weight: 600;
    }

    .completion-info {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-top: 10px;
    }

    .completed-property {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .completed-property img {
        border-radius: 6px;
        background: #e9ecef;
    }

    .property-details h4 {
        margin: 0 0 4px 0;
        font-size: 1rem;
        color: #222;
    }

    .property-details p {
        margin: 0;
        color: #666;
        font-size: 0.97rem;
    }

    .completion-date {
        color: #666;
        font-size: 0.97rem;
    }

    .assigned-agent {
        display: flex;
        align-items: center;
        gap: 18px;
        background: #f8f9fc;
        border-radius: 7px;
        padding: 10px 14px;
        margin-top: 10px;
    }

    .agent-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .agent-info img {
        border-radius: 50%;
        background: #e9ecef;
    }

    .agent-details h4 {
        margin: 0 0 2px 0;
        font-size: 1rem;
        color: #222;
    }

    .agent-details p {
        margin: 0;
        color: #666;
        font-size: 0.96rem;
    }

    .contact-info {
        color: #4e73df;
        font-size: 0.97rem;
    }

    .contact-actions {
        display: flex;
        gap: 8px;
    }

    .empty-state {
        text-align: center;
        padding: 36px 0;
        color: #666;
    }

    .empty-icon {
        font-size: 2.5rem;
        color: #4e73df;
        margin-bottom: 12px;
    }

    .empty-state h3 {
        font-size: 1.2rem;
        margin-bottom: 8px;
    }

    .empty-state p {
        margin-bottom: 14px;
    }

    .empty-state .btn {
        margin-top: 8px;
    }
</style>