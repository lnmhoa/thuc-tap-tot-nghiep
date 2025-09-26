<div class="user-profile-wrapper">
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
                    <div class="saved-stats">
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

                    <!-- Sort Options Only -->
                    <div class="content-filters">
                        <div class="filter-actions">
                        <div class="filter-actions">
                            <div class="sort-options">
                                <label>Sắp xếp theo:</label>
                                <select class="form-select">
                                    <option value="newest">Mới nhất</option>
                                    <option value="oldest">Cũ nhất</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Consultation Requests Grid -->
                    <div class="saved-properties-grid">
                    </div>

                    <!-- Consultation Requests List -->
                    <div class="consultation-requests-list">
                        <!-- Active Request -->
                        <div class="saved-property-card" data-type="consultation">
                            <div class="property-image">
                                <img src="../admin/uploads/broker/688614ebb3040.png" alt="Tư vấn viên" onerror="this.src='../logo.jpg'">
                                <div class="property-badge consultation">Tư vấn</div>
                                <div class="property-badge active">Đang tư vấn</div>
                                <div class="property-actions">
                                    <button class="action-btn" onclick="callConsultant()" title="Gọi điện">
                                        <i class="fas fa-phone"></i>
                                    </button>
                                    <button class="action-btn" onclick="messageConsultant()" title="Nhắn tin">
                                        <i class="fas fa-comment"></i>
                                    </button>
                                    <button class="action-btn" onclick="viewDetails()" title="Chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="property-details">
                                <div class="property-title">
                                    <h3>Tư vấn mua căn hộ 2PN tại Quận 7</h3>
                                    <div class="property-status active">
                                        <i class="fas fa-phone"></i>
                                        <span>Đang tư vấn</span>
                                    </div>
                                </div>
                                <p class="property-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Quận 7, TP.HCM
                                </p>
                                <div class="property-features">
                                    <span><i class="fas fa-home"></i> Căn hộ chung cư</span>
                                    <span><i class="fas fa-money-bill-wave"></i> 3-4 tỷ</span>
                                    <span><i class="fas fa-bed"></i> 2 phòng ngủ</span>
                                </div>
                                <div class="property-price">
                                    <span class="consultation-id">#CR001</span>
                                    <span class="consultation-date">
                                        <i class="fas fa-calendar"></i>
                                        15/09/2024
                                    </span>
                                </div>
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
                        <div class="saved-property-card" data-type="consultation">
                            <div class="property-image">
                                <img src="../logo.jpg" alt="Yêu cầu tư vấn" onerror="this.src='../logo.jpg'">
                                <div class="property-badge consultation">Tư vấn</div>
                                <div class="property-badge pending">Chờ phản hồi</div>
                                <div class="property-actions">
                                    <button class="action-btn" onclick="editRequest()" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn" onclick="cancelRequest()" title="Hủy yêu cầu">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button class="action-btn" onclick="viewDetails()" title="Chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="property-details">
                                <div class="property-title">
                                    <h3>Tư vấn thuê nhà phố tại Quận Bình Thạnh</h3>
                                    <div class="property-status pending">
                                        <i class="fas fa-clock"></i>
                                        <span>Chờ phản hồi</span>
                                    </div>
                                </div>
                                <p class="property-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Quận Bình Thạnh, TP.HCM
                                </p>
                                <div class="property-features">
                                    <span><i class="fas fa-home"></i> Nhà phố</span>
                                    <span><i class="fas fa-money-bill-wave"></i> 15-25tr/tháng</span>
                                    <span><i class="fas fa-bed"></i> 3-4 phòng ngủ</span>
                                </div>
                                <div class="property-price">
                                    <span class="consultation-id">#CR002</span>
                                    <span class="consultation-date">
                                        <i class="fas fa-calendar"></i>
                                        12/09/2024
                                    </span>
                                </div>
                            </div>
                        </div>
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
                        <div class="saved-property-card" data-type="consultation">
                            <div class="property-image">
                                <img src="../admin/uploads/broker/688615b882eef.png" alt="Tư vấn viên" onerror="this.src='../logo.jpg'">
                                <div class="property-badge consultation">Tư vấn</div>
                                <div class="property-badge completed">Hoàn thành</div>
                                <div class="property-actions">
                                    <button class="action-btn" onclick="rateConsultant()" title="Đánh giá">
                                        <i class="fas fa-star"></i>
                                    </button>
                                    <button class="action-btn" onclick="messageConsultant()" title="Nhắn tin">
                                        <i class="fas fa-comment"></i>
                                    </button>
                                    <button class="action-btn" onclick="viewDetails()" title="Chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="property-details">
                                <div class="property-title">
                                    <h3>Tư vấn mua đất nền tại Củ Chi</h3>
                                    <div class="property-status completed">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Hoàn thành</span>
                                    </div>
                                </div>
                                <p class="property-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Huyện Củ Chi, TP.HCM
                                </p>
                                <div class="property-features">
                                    <span><i class="fas fa-map"></i> Đất nền</span>
                                    <span><i class="fas fa-money-bill-wave"></i> 1-2 tỷ</span>
                                    <span><i class="fas fa-check"></i> 5 lô đã tư vấn</span>
                                </div>
                                <div class="property-price">
                                    <span class="consultation-id">#CR003</span>
                                    <span class="consultation-date">
                                        <i class="fas fa-calendar"></i>
                                        05/09/2024
                                    </span>
                                </div>
                            </div>
                        </div>
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

            </div>
        </div>
    </div>
</main>
</div>

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
    const sortSelect = document.querySelector('.form-select');
    
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            sortRequests(this.value);
        });
    }
});

function sortRequests(sortType) {
    const requestCards = document.querySelectorAll('.saved-property-card');
    const container = document.querySelector('.saved-properties-grid');
    const requestArray = Array.from(requestCards);
    
    requestArray.sort((a, b) => {
        if (sortType === 'newest') {
            return -1; // Mới nhất lên trên
        } else if (sortType === 'oldest') {
            return 1; // Cũ nhất lên trên
        }
        return 0;
    });
    
    container.innerHTML = '';
    requestArray.forEach(card => container.appendChild(card));
}

// Consultation actions
function callConsultant() {
    alert('Tính năng gọi điện sẽ được phát triển trong phiên bản tiếp theo!');
}

function messageConsultant() {
    alert('Tính năng nhắn tin sẽ được phát triển trong phiên bản tiếp theo!');
}

function editRequest() {
    alert('Tính năng chỉnh sửa yêu cầu sẽ được phát triển trong phiên bản tiếp theo!');
}

function cancelRequest() {
    if (confirm('Bạn có chắc muốn hủy yêu cầu tư vấn này?')) {
        alert('Yêu cầu đã được hủy!');
    }
}

function rateConsultant() {
    alert('Tính năng đánh giá tư vấn viên sẽ được phát triển trong phiên bản tiếp theo!');
}

function viewDetails() {
    alert('Tính năng xem chi tiết sẽ được phát triển trong phiên bản tiếp theo!');
}
</script>