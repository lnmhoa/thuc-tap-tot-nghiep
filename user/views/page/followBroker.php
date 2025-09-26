<div class="user-profile-wrapper">
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

    <main class="profile-main">
        <div class="container">
            <div class="profile-layout">
                
                <aside class="profile-sidebar">
                    <div class="profile-user-card">
                        <div class="user-avatar">
                            <?php if (isset($_SESSION['user_avatar']) && !empty($_SESSION['user_avatar'])): ?>
                                <img src="./uploads/avatar/<?= htmlspecialchars($_SESSION['user_avatar']) ?>" alt="Avatar">
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

                <div class="profile-content">
                    <div class="content-header">
                        <h2>Môi giới theo dõi</h2>
                        <p>Danh sách các môi giới bạn đang theo dõi và nhận thông báo cập nhật</p>
                    </div>

                    <div class="content-filters">
                        <div class="filter-actions">
                            <div class="sort-options">
                                <label>Sắp xếp theo:</label>
                                <select class="form-select" id="sort-broker-select">
                                    <option value="followDate_newest">Mới theo dõi nhất</option>
                                    <option value="followDate_oldest">Cũ theo dõi nhất</option>
                                    <option value="property_count">Số BĐS nhiều nhất</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="saved-properties-grid" id="broker-grid">
                        <?php if (!empty($followedBrokers)): ?>
                            <?php foreach ($followedBrokers as $broker): ?>
                                <div class="saved-property-card" data-type="broker" 
                                     data-follow-date="<?= strtotime(str_replace('/', '-', $broker['follow_date'])) ?>"
                                     data-properties="<?= $broker['properties'] ?>"
                                     data-id="<?= $broker['id'] ?>">
                                    <div class="property-image">
                                        <img src="<?= htmlspecialchars($broker['avatar']) ?>" alt="<?= htmlspecialchars($broker['name']) ?>" onerror="this.src='../logo.jpg'">
                                        <div class="property-badge broker">Môi giới</div>
                                        <?php if (in_array('new', $broker['badges'])): ?>
                                            <div class="property-badge new">Đăng tin mới</div>
                                        <?php endif; ?>
                                        <div class="property-actions">
                                            <button class="action-btn saved" onclick="toggleFollow(this, <?= $broker['id'] ?>)" title="Bỏ theo dõi">
                                                <i class="fas fa-user-minus"></i>
                                            </button>
                                            <button class="action-btn" onclick="messageBroker(<?= $broker['id'] ?>)" title="Nhắn tin">
                                                <i class="fas fa-comment"></i>
                                            </button>
                                            <button class="action-btn <?= $broker['notifications'] ? 'active' : '' ?>" onclick="toggleNotification(this, <?= $broker['id'] ?>)" title="<?= $broker['notifications'] ? 'Tắt thông báo' : 'Bật thông báo' ?>">
                                                <i class="fas <?= $broker['notifications'] ? 'fa-bell' : 'fa-bell-slash' ?>"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="property-details">
                                        <div class="property-title">
                                            <h3><?= htmlspecialchars($broker['name']) ?></h3>
                                            <div class="property-status <?= $broker['status'] ?>">
                                                <i class="fas fa-circle"></i>
                                                <span><?= $broker['status'] == 'online' ? 'Online' : 'Away' ?></span>
                                            </div>
                                        </div>
                                        <p class="property-location">
                                            <i class="fas fa-briefcase"></i>
                                            <?= htmlspecialchars($broker['title']) ?>
                                        </p>
                                        <div class="property-features">
                                            <span><i class="fas fa-home"></i> <?= $broker['properties'] ?> BĐS</span>
                                            <span><i class="fas fa-star"></i> <?= $broker['rating'] ?></span>
                                            <span><i class="fas fa-handshake"></i> <?= $broker['transactions'] ?> GD</span>
                                        </div>
                                        <div class="property-price">
                                            <span class="follow-date">
                                                <i class="fas fa-calendar"></i>
                                                Theo dõi từ <?= $broker['follow_date'] ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <?php if ($broker['id'] == 2): ?>
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
                                    <?php endif; ?>
                                    
                                    <div class="broker-contact">
                                        <button class="btn btn-primary btn-sm" onclick="contactBroker(<?= $broker['id'] ?>)">
                                            <i class="fas fa-phone"></i>
                                            Liên hệ
                                        </button>
                                        <a href="?act=brokerProperty&id=<?= $broker['id'] ?>" class="btn btn-outline btn-sm">
                                            <i class="fas fa-home"></i>
                                            Xem BĐS
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-state" id="empty-state">
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
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
// Lấy thẻ lưới môi giới
const brokerGrid = document.getElementById('broker-grid');
const emptyState = document.getElementById('empty-state');
const sortSelect = document.getElementById('sort-broker-select');

// --- Chức năng Sắp xếp (Sort functionality) ---

document.addEventListener('DOMContentLoaded', function() {
    // Chỉ chạy sắp xếp khi có môi giới
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            sortBrokers(this.value);
        });
        
        // Sắp xếp mặc định khi tải trang
        sortBrokers(sortSelect.value);
    }
});

function sortBrokers(sortType) {
    // Lấy tất cả các thẻ môi giới
    const brokerCards = document.querySelectorAll('.saved-property-card');
    const brokerArray = Array.from(brokerCards);
    
    // Hàm sắp xếp
    brokerArray.sort((a, b) => {
        let valueA, valueB;

        switch (sortType) {
            case 'followDate_newest':
                // Sử dụng data-follow-date (timestamp)
                valueA = parseInt(a.getAttribute('data-follow-date'));
                valueB = parseInt(b.getAttribute('data-follow-date'));
                return valueB - valueA; // Mới nhất lên trên (lớn hơn là mới hơn)
            case 'followDate_oldest':
                valueA = parseInt(a.getAttribute('data-follow-date'));
                valueB = parseInt(b.getAttribute('data-follow-date'));
                return valueA - valueB; // Cũ nhất lên trên (bé hơn là cũ hơn)
            case 'property_count':
                // Sử dụng data-properties
                valueA = parseInt(a.getAttribute('data-properties'));
                valueB = parseInt(b.getAttribute('data-properties'));
                return valueB - valueA; // Số lượng BĐS nhiều nhất lên trên
            default:
                return 0;
        }
    });
    
    // Xóa nội dung cũ và chèn các thẻ đã sắp xếp lại
    brokerGrid.innerHTML = '';
    brokerArray.forEach(card => brokerGrid.appendChild(card));
}

// --- Chức năng Bỏ theo dõi (Toggle follow) ---

function toggleFollow(button, brokerId) {
    if (confirm('Bạn có chắc muốn bỏ theo dõi môi giới ID ' + brokerId + ' này?')) {
        const card = button.closest('.saved-property-card');
        
        // **THỰC HIỆN AJAX TẠI ĐÂY để gửi brokerId về server và cập nhật database**
        console.log('Đã gửi yêu cầu bỏ theo dõi môi giới ID:', brokerId);
        
        // Hiệu ứng xóa thẻ (Chỉ là hiệu ứng frontend)
        card.style.transition = 'all 0.3s ease';
        card.style.opacity = '0';
        card.style.transform = 'scale(0.9)';
        
        setTimeout(() => {
            card.remove();
            checkEmptyState(); // Kiểm tra trạng thái rỗng sau khi xóa
        }, 300);
    }
}

// --- Chức năng Bật/Tắt thông báo (Toggle notification) ---

function toggleNotification(button, brokerId) {
    const isActivating = !button.classList.contains('active');
    
    // **THỰC HIỆN AJAX TẠI ĐÂY để gửi trạng thái mới (isActivating) về server**
    console.log(`Đã gửi yêu cầu ${isActivating ? 'BẬT' : 'TẮT'} thông báo cho môi giới ID:`, brokerId);
    
    // Cập nhật giao diện (Frontend)
    if (isActivating) {
        button.classList.add('active');
        button.innerHTML = '<i class="fas fa-bell"></i>';
        button.title = 'Tắt thông báo';
        alert(`Đã bật thông báo cập nhật từ môi giới ${brokerId}.`);
    } else {
        button.classList.remove('active');
        button.innerHTML = '<i class="fas fa-bell-slash"></i>';
        button.title = 'Bật thông báo';
        alert(`Đã tắt thông báo cập nhật từ môi giới ${brokerId}.`);
    }
}

// --- Chức năng Nhắn tin và Liên hệ (Message/Contact broker) ---

function messageBroker(brokerId) {
    alert(`Mở cửa sổ chat với môi giới ID ${brokerId}. Tính năng nhắn tin sẽ được phát triển trong phiên bản tiếp theo!`);
}

function contactBroker(brokerId) {
    alert(`Mở pop-up/modal liên hệ với môi giới ID ${brokerId} (số điện thoại, email,...)`);
}

// --- Kiểm tra trạng thái rỗng (Check Empty State) ---

function checkEmptyState() {
    const remainingBrokers = document.querySelectorAll('.saved-property-card').length;
    
    if (remainingBrokers === 0) {
        // Nếu không còn môi giới nào, hiển thị trạng thái rỗng
        if (emptyState) {
             emptyState.style.display = 'block';
        }
        // Ẩn luôn các bộ lọc nếu không có dữ liệu
        const filters = document.querySelector('.content-filters');
        if (filters) {
            filters.style.display = 'none';
        }
    } else {
        // Đảm bảo trạng thái rỗng bị ẩn
        if (emptyState) {
            emptyState.style.display = 'none';
        }
        const filters = document.querySelector('.content-filters');
        if (filters) {
            filters.style.display = 'flex';
        }
    }
}

// Chạy kiểm tra ban đầu khi tải trang
document.addEventListener('DOMContentLoaded', checkEmptyState);

</script>