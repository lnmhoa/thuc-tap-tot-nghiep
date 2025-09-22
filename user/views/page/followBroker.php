<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <div class="page-title">
                <h1><i class="fas fa-user-friends"></i> Môi giới theo dõi</h1>
                <p>Quản lý danh sách các môi giới bạn đang theo dõi</p>
            </div>
            <div class="breadcrumb">
                <a href="index.php"><i class="fas fa-home"></i> Trang chủ</a>
                <span>/</span>
                <a href="?act=profile">Hồ sơ</a>
                <span>/</span>
                <span>Môi giới theo dõi</span>
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
                    <a href="?act=followBroker" class="menu-item active">
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
                    <h2>Môi giới theo dõi</h2>
                    <p>Danh sách các môi giới bạn đang theo dõi và nhận thông báo cập nhật</p>
                </div>

                <!-- Follow Stats -->
                <div class="follow-stats">
                    <div class="stat-card">
                        <div class="stat-icon following">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="stat-info">
                            <h3>8</h3>
                            <p>Đang theo dõi</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon online">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3>5</h3>
                            <p>Đang online</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon properties">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="stat-info">
                            <h3>156</h3>
                            <p>BĐS từ họ</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon notifications">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="stat-info">
                            <h3>12</h3>
                            <p>Thông báo mới</p>
                        </div>
                    </div>
                </div>

                <!-- Filter and Search -->
                <div class="content-filters">
                    <div class="filter-tabs">
                        <button class="filter-tab active" data-filter="all">
                            <i class="fas fa-users"></i>
                            Tất cả
                        </button>
                        <button class="filter-tab" data-filter="online">
                            <i class="fas fa-circle text-success"></i>
                            Online
                        </button>
                        <button class="filter-tab" data-filter="active">
                            <i class="fas fa-bolt"></i>
                            Hoạt động
                        </button>
                        <button class="filter-tab" data-filter="new-posts">
                            <i class="fas fa-plus-circle"></i>
                            Có tin mới
                        </button>
                    </div>
                    <div class="filter-actions">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Tìm kiếm môi giới...">
                        </div>
                        <div class="sort-options">
                            <select class="form-select">
                                <option value="newest">Theo dõi mới nhất</option>
                                <option value="name">Theo tên A-Z</option>
                                <option value="active">Hoạt động gần đây</option>
                                <option value="properties">Nhiều BĐS nhất</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Followed Brokers Grid -->
                <div class="followed-brokers-grid">
                    <!-- Broker Card 1 -->
                    <div class="followed-broker-card" data-status="online" data-activity="active">
                        <div class="broker-header">
                            <div class="broker-avatar">
                                <img src="../admin/uploads/broker/688614ebb3040.png" alt="Nguyễn Văn Minh" onerror="this.src='../logo.jpg'">
                                <div class="broker-status online">
                                    <i class="fas fa-circle"></i>
                                </div>
                            </div>
                            <div class="broker-info">
                                <h3 class="broker-name">Nguyễn Văn Minh</h3>
                                <p class="broker-title">Chuyên viên tư vấn BĐS</p>
                                <div class="follow-date">
                                    <i class="fas fa-calendar"></i>
                                    Theo dõi từ 15/08/2024
                                </div>
                            </div>
                            <div class="broker-actions">
                                <button class="action-btn" onclick="toggleNotification(this)" title="Bật/tắt thông báo">
                                    <i class="fas fa-bell"></i>
                                </button>
                                <button class="action-btn" onclick="messageBroker()" title="Nhắn tin">
                                    <i class="fas fa-comment"></i>
                                </button>
                                <button class="action-btn unfollow" onclick="unfollowBroker(this)" title="Bỏ theo dõi">
                                    <i class="fas fa-user-minus"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="broker-stats">
                            <div class="stat-item">
                                <i class="fas fa-home"></i>
                                <span>45 BĐS</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-star"></i>
                                <span>4.8/5</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-handshake"></i>
                                <span>120 GD</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-eye"></i>
                                <span>1.2K views</span>
                            </div>
                        </div>

                        <div class="recent-activity">
                            <h4>Hoạt động gần đây</h4>
                            <div class="activity-list">
                                <div class="activity-item">
                                    <i class="fas fa-plus text-success"></i>
                                    <span>Đăng 2 BĐS mới</span>
                                    <small>2 giờ trước</small>
                                </div>
                                <div class="activity-item">
                                    <i class="fas fa-edit text-primary"></i>
                                    <span>Cập nhật giá căn hộ Vinhomes</span>
                                    <small>1 ngày trước</small>
                                </div>
                            </div>
                        </div>

                        <div class="broker-contact">
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-phone"></i>
                                Liên hệ
                            </button>
                            <a href="?act=brokerProperty&id=1" class="btn btn-outline btn-sm">
                                <i class="fas fa-home"></i>
                                Xem BĐS
                            </a>
                        </div>
                    </div>

                    <!-- Broker Card 2 -->
                    <div class="followed-broker-card" data-status="online" data-activity="new-posts">
                        <div class="broker-header">
                            <div class="broker-avatar">
                                <img src="../admin/uploads/broker/688615b882eef.png" alt="Trần Thị Hương" onerror="this.src='../logo.jpg'">
                                <div class="broker-status online">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="new-badge">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                            <div class="broker-info">
                                <h3 class="broker-name">Trần Thị Hương</h3>
                                <p class="broker-title">Chuyên gia đầu tư BĐS</p>
                                <div class="follow-date">
                                    <i class="fas fa-calendar"></i>
                                    Theo dõi từ 10/08/2024
                                </div>
                            </div>
                            <div class="broker-actions">
                                <button class="action-btn active" onclick="toggleNotification(this)" title="Bật/tắt thông báo">
                                    <i class="fas fa-bell"></i>
                                </button>
                                <button class="action-btn" onclick="messageBroker()" title="Nhắn tin">
                                    <i class="fas fa-comment"></i>
                                </button>
                                <button class="action-btn unfollow" onclick="unfollowBroker(this)" title="Bỏ theo dõi">
                                    <i class="fas fa-user-minus"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="broker-stats">
                            <div class="stat-item">
                                <i class="fas fa-home"></i>
                                <span>78 BĐS</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-star"></i>
                                <span>4.9/5</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-handshake"></i>
                                <span>250 GD</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-eye"></i>
                                <span>2.1K views</span>
                            </div>
                        </div>

                        <div class="recent-activity">
                            <h4>Hoạt động gần đây</h4>
                            <div class="activity-list">
                                <div class="activity-item">
                                    <i class="fas fa-plus text-success"></i>
                                    <span>Đăng 5 BĐS mới</span>
                                    <small>30 phút trước</small>
                                </div>
                                <div class="activity-item">
                                    <i class="fas fa-star text-warning"></i>
                                    <span>Nhận đánh giá 5 sao</span>
                                    <small>3 giờ trước</small>
                                </div>
                            </div>
                        </div>

                        <div class="broker-contact">
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-phone"></i>
                                Liên hệ
                            </button>
                            <a href="?act=brokerProperty&id=2" class="btn btn-outline btn-sm">
                                <i class="fas fa-home"></i>
                                Xem BĐS
                            </a>
                        </div>
                    </div>

                    <!-- Broker Card 3 -->
                    <div class="followed-broker-card" data-status="away" data-activity="normal">
                        <div class="broker-header">
                            <div class="broker-avatar">
                                <img src="../admin/uploads/broker/68861612add95.png" alt="Lê Văn Cường" onerror="this.src='../logo.jpg'">
                                <div class="broker-status away">
                                    <i class="fas fa-circle"></i>
                                </div>
                            </div>
                            <div class="broker-info">
                                <h3 class="broker-name">Lê Văn Cường</h3>
                                <p class="broker-title">Chuyên viên cho thuê</p>
                                <div class="follow-date">
                                    <i class="fas fa-calendar"></i>
                                    Theo dõi từ 05/08/2024
                                </div>
                            </div>
                            <div class="broker-actions">
                                <button class="action-btn" onclick="toggleNotification(this)" title="Bật/tắt thông báo">
                                    <i class="fas fa-bell-slash"></i>
                                </button>
                                <button class="action-btn" onclick="messageBroker()" title="Nhắn tin">
                                    <i class="fas fa-comment"></i>
                                </button>
                                <button class="action-btn unfollow" onclick="unfollowBroker(this)" title="Bỏ theo dõi">
                                    <i class="fas fa-user-minus"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="broker-stats">
                            <div class="stat-item">
                                <i class="fas fa-home"></i>
                                <span>33 BĐS</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-star"></i>
                                <span>4.7/5</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-handshake"></i>
                                <span>95 GD</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-eye"></i>
                                <span>856 views</span>
                            </div>
                        </div>

                        <div class="recent-activity">
                            <h4>Hoạt động gần đây</h4>
                            <div class="activity-list">
                                <div class="activity-item">
                                    <i class="fas fa-handshake text-success"></i>
                                    <span>Hoàn thành 1 giao dịch</span>
                                    <small>2 ngày trước</small>
                                </div>
                                <div class="activity-item">
                                    <i class="fas fa-edit text-primary"></i>
                                    <span>Cập nhật thông tin liên hệ</span>
                                    <small>1 tuần trước</small>
                                </div>
                            </div>
                        </div>

                        <div class="broker-contact">
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-phone"></i>
                                Liên hệ
                            </button>
                            <a href="?act=brokerProperty&id=3" class="btn btn-outline btn-sm">
                                <i class="fas fa-home"></i>
                                Xem BĐS
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div class="empty-state" style="display: none;">
                    <div class="empty-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h3>Chưa theo dõi môi giới nào</h3>
                    <p>Theo dõi các môi giới để nhận thông báo về BĐS mới và cập nhật từ họ</p>
                    <a href="?act=listBroker" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Tìm môi giới
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
    const brokerCards = document.querySelectorAll('.followed-broker-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            brokerCards.forEach(card => {
                const status = card.getAttribute('data-status');
                const activity = card.getAttribute('data-activity');
                
                let shouldShow = false;
                
                if (filter === 'all') {
                    shouldShow = true;
                } else if (filter === 'online' && status === 'online') {
                    shouldShow = true;
                } else if (filter === 'active' && activity === 'active') {
                    shouldShow = true;
                } else if (filter === 'new-posts' && activity === 'new-posts') {
                    shouldShow = true;
                }
                
                card.style.display = shouldShow ? 'block' : 'none';
            });
        });
    });
    
    // Search functionality
    const searchInput = document.querySelector('.search-box input');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        brokerCards.forEach(card => {
            const name = card.querySelector('.broker-name').textContent.toLowerCase();
            const title = card.querySelector('.broker-title').textContent.toLowerCase();
            
            if (name.includes(searchTerm) || title.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

// Toggle notification
function toggleNotification(button) {
    if (button.classList.contains('active')) {
        button.classList.remove('active');
        button.innerHTML = '<i class="fas fa-bell-slash"></i>';
        button.title = 'Bật thông báo';
    } else {
        button.classList.add('active');
        button.innerHTML = '<i class="fas fa-bell"></i>';
        button.title = 'Tắt thông báo';
    }
}

// Message broker
function messageBroker() {
    alert('Tính năng nhắn tin sẽ được phát triển trong phiên bản tiếp theo!');
}

// Unfollow broker
function unfollowBroker(button) {
    if (confirm('Bạn có chắc muốn bỏ theo dõi môi giới này?')) {
        const card = button.closest('.followed-broker-card');
        card.style.transition = 'all 0.3s ease';
        card.style.opacity = '0';
        card.style.transform = 'scale(0.9)';
        
        setTimeout(() => {
            card.remove();
        }, 300);
    }
}
</script>
                                    <option value="oldest">Theo dõi lâu nhất</option>
                                    <option value="rating">Đánh giá cao nhất</option>
                                    <option value="properties">Nhiều BĐS nhất</option>
                                </select>
                            </div>
                        </div>

                        <div class="followed-agents-grid">
                            <div class="followed-agent-card">
                                <div class="agent-header">
                                    <div class="agent-avatar">
                                        <img src="/placeholder.svg?height=60&width=60" alt="Môi giới">
                                        <div class="online-status"></div>
                                    </div>
                                    <div class="agent-info">
                                        <h3><a href="agent-detail.html">Nguyễn Văn An</a></h3>
                                        <p class="agent-title">Chuyên viên tư vấn BĐS cao cấp</p>
                                        <div class="agent-rating">
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span>4.9/5</span>
                                        </div>
                                        <div class="follow-date">Theo dõi từ: 15/11/2024</div>
                                    </div>
                                    <div class="agent-actions">
                                        <button class="unfollow-btn" title="Bỏ theo dõi">
                                            <i class="fas fa-user-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="agent-stats">
                                    <div class="stat-item">
                                        <span class="stat-number">150+</span>
                                        <span class="stat-label">BĐS</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">89</span>
                                        <span class="stat-label">Giao dịch</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">5</span>
                                        <span class="stat-label">Năm KN</span>
                                    </div>
                                </div>

                                <div class="agent-specialties">
                                    <span class="specialty-tag">Căn hộ cao cấp</span>
                                    <span class="specialty-tag">Penthouse</span>
                                </div>

                                <div class="agent-footer">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-phone"></i>
                                        Gọi ngay
                                    </button>
                                    <button class="btn btn-outline btn-sm">
                                        <i class="fas fa-envelope"></i>
                                        Nhắn tin
                                    </button>
                                    <button class="btn btn-outline btn-sm">
                                        <i class="fas fa-eye"></i>
                                        Xem chi tiết
                                    </button>
                                </div>
                            </div>

                            <div class="followed-agent-card">
                                <div class="agent-header">
                                    <div class="agent-avatar">
                                        <img src="/placeholder.svg?height=60&width=60" alt="Môi giới">
                                        <div class="online-status offline"></div>
                                    </div>
                                    <div class="agent-info">
                                        <h3><a href="agent-detail.html">Trần Thị Bình</a></h3>
                                        <p class="agent-title">Chuyên gia đầu tư BĐS</p>
                                        <div class="agent-rating">
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span>4.8/5</span>
                                        </div>
                                        <div class="follow-date">Theo dõi từ: 10/11/2024</div>
                                    </div>
                                    <div class="agent-actions">
                                        <button class="unfollow-btn" title="Bỏ theo dõi">
                                            <i class="fas fa-user-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="agent-stats">
                                    <div class="stat-item">
                                        <span class="stat-number">200+</span>
                                        <span class="stat-label">BĐS</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">156</span>
                                        <span class="stat-label">Giao dịch</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">8</span>
                                        <span class="stat-label">Năm KN</span>
                                    </div>
                                </div>

                                <div class="agent-specialties">
                                    <span class="specialty-tag">Nhà phố</span>
                                    <span class="specialty-tag">Biệt thự</span>
                                    <span class="specialty-tag">Đầu tư</span>
                                </div>

                                <div class="agent-footer">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-phone"></i>
                                        Gọi ngay
                                    </button>
                                    <button class="btn btn-outline btn-sm">
                                        <i class="fas fa-envelope"></i>
                                        Nhắn tin
                                    </button>
                                    <button class="btn btn-outline btn-sm">
                                        <i class="fas fa-eye"></i>
                                        Xem chi tiết
                                    </button>
                                </div>
                            </div>

                            <div class="followed-agent-card">
                                <div class="agent-header">
                                    <div class="agent-avatar">
                                        <img src="/placeholder.svg?height=60&width=60" alt="Môi giới">
                                        <div class="online-status"></div>
                                    </div>
                                    <div class="agent-info">
                                        <h3><a href="agent-detail.html">Lê Văn Cường</a></h3>
                                        <p class="agent-title">Chuyên viên cho thuê</p>
                                        <div class="agent-rating">
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <span>4.7/5</span>
                                        </div>
                                        <div class="follow-date">Theo dõi từ: 05/11/2024</div>
                                    </div>
                                    <div class="agent-actions">
                                        <button class="unfollow-btn" title="Bỏ theo dõi">
                                            <i class="fas fa-user-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="agent-stats">
                                    <div class="stat-item">
                                        <span class="stat-number">120+</span>
                                        <span class="stat-label">BĐS</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">67</span>
                                        <span class="stat-label">Giao dịch</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">3</span>
                                        <span class="stat-label">Năm KN</span>
                                    </div>
                                </div>

                                <div class="agent-specialties">
                                    <span class="specialty-tag">Phòng trọ</span>
                                    <span class="specialty-tag">Căn hộ mini</span>
                                </div>

                                <div class="agent-footer">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-phone"></i>
                                        Gọi ngay
                                    </button>
                                    <button class="btn btn-outline btn-sm">
                                        <i class="fas fa-envelope"></i>
                                        Nhắn tin
                                    </button>
                                    <button class="btn btn-outline btn-sm">
                                        <i class="fas fa-eye"></i>
                                        Xem chi tiết
                                    </button>
                                </div>
                            </div>

                            <div class="followed-agent-card">
                                <div class="agent-header">
                                    <div class="agent-avatar">
                                        <img src="/placeholder.svg?height=60&width=60" alt="Môi giới">
                                        <div class="online-status"></div>
                                    </div>
                                    <div class="agent-info">
                                        <h3><a href="agent-detail.html">Phạm Thị Dung</a></h3>
                                        <p class="agent-title">Giám đốc kinh doanh</p>
                                        <div class="agent-rating">
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span>5.0/5</span>
                                        </div>
                                        <div class="follow-date">Theo dõi từ: 01/11/2024</div>
                                    </div>
                                    <div class="agent-actions">
                                        <button class="unfollow-btn" title="Bỏ theo dõi">
                                            <i class="fas fa-user-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="agent-stats">
                                    <div class="stat-item">
                                        <span class="stat-number">300+</span>
                                        <span class="stat-label">BĐS</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">234</span>
                                        <span class="stat-label">Giao dịch</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">10+</span>
                                        <span class="stat-label">Năm KN</span>
                                    </div>
                                </div>

                                <div class="agent-specialties">
                                    <span class="specialty-tag">Luxury</span>
                                    <span class="specialty-tag">Thương mại</span>
                                    <span class="specialty-tag">Tư vấn</span>
                                </div>

                                <div class="agent-footer">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-phone"></i>
                                        Gọi ngay
                                    </button>
                                    <button class="btn btn-outline btn-sm">
                                        <i class="fas fa-envelope"></i>
                                        Nhắn tin
                                    </button>
                                    <button class="btn btn-outline btn-sm">
                                        <i class="fas fa-eye"></i>
                                        Xem chi tiết
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div class="empty-state" style="display: none;">
                            <div class="empty-icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <h3>Chưa theo dõi môi giới nào</h3>
                            <p>Hãy tìm và theo dõi những môi giới uy tín để nhận thông tin BĐS mới nhất</p>
                            <a href="agents.html" class="btn btn-primary">Tìm môi giới</a>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination">
                            <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                            <button class="page-btn active">1</button>
                            <button class="page-btn">2</button>
                            <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>