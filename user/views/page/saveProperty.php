<div class="user-profile-wrapper">
<main class="profile-main">
    <div class="container">
        <div class="profile-layout">
            <aside class="profile-sidebar">
                <div class="profile-user-card">
                    <div class="user-avatar">
                        <?php if (isset($_SESSION['user']['avatar']) && !empty($_SESSION['user']['avatar'])): ?>
                            <img src="./uploads/avatar/<?= $_SESSION['user']['avatar'] ?>" alt="Avatar">
                        <?php else: ?>
                            <img src="../logo.jpg" alt="Default Avatar">
                        <?php endif; ?>
                        <div class="avatar-status online"></div>
                    </div>
                    <div class="user-info">
                        <h3><?= htmlspecialchars($_SESSION['user']['fullName'] ?? 'Người dùng') ?></h3>
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
                    <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['role'] === '2' && $_SESSION['user']['status'] === 'active'): ?>
                    <a href="?act=brokerProperty" class="menu-item">
                        <i class="fas fa-home"></i>
                        <span>BĐS của tôi</span>
                    </a>
                    <?php endif; ?>
                    <a href="?act=saveProperty" class="menu-item active">
                        <i class="fas fa-heart"></i>
                        <span>BĐS đã lưu</span>
                    </a>
                    <!-- <a href="?act=userRentals" class="menu-item">
                        <i class="fas fa-history"></i>
                        <span>Lịch sử thuê</span>
                    </a> -->
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

            <div class="profile-content" style="padding: 2rem">
                        <div class="form-section" style="margin-bottom: 0.5rem;">
                <h3 class="section-title" style="padding: 0; margin-bottom:0.5rem;">Bất động sản đã lưu</h3>
                <div class="content-filters">
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
                </div>
                
                
                <div class="saved-properties-grid">
                    <div class="saved-property-card" data-type="rent">
                        <div class="property-image">
                            <img src="../1.jpg" alt="Căn hộ Vinhomes">
                            <div class="property-badge rent">Cho thuê</div>
                            <div class="property-actions">
                                <button class="action-btn saved" onclick="toggleSave(this)" title="Bỏ lưu">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button class="action-btn" onclick="shareProperty()" title="Chia sẻ">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                                <button class="action-btn" onclick="compareProperty()" title="So sánh">
                                    <i class="fas fa-balance-scale"></i>
                                </button>
                            </div>
                            <div class="save-date">
                                <i class="fas fa-calendar"></i>
                                Lưu ngày 15/09/2024
                            </div>
                        </div>
                        <div class="property-content">
                            <h3 class="property-title">Căn hộ cao cấp Vinhomes Central Park</h3>
                            <p class="property-location">
                                <i class="fas fa-map-marker-alt"></i>
                                Quận Bình Thạnh, TP.HCM
                            </p>
                            <div class="property-price">25 triệu/tháng</div>
                            <div class="property-features">
                                <span><i class="fas fa-bed"></i> 2 PN</span>
                                <span><i class="fas fa-bath"></i> 2 WC</span>
                                <span><i class="fas fa-expand-arrows-alt"></i> 80m²</span>
                            </div>
                            <div class="property-status">
                                <span class="status available">
                                    <i class="fas fa-check-circle"></i>
                                    Còn trống
                                </span>
                            </div>
                            <div class="property-actions-bottom">
                                <a href="?act=property&id=1" class="btn btn-outline btn-sm">
                                    <i class="fas fa-eye"></i>
                                    Xem chi tiết
                                </a>
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-phone"></i>
                                    Liên hệ
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Property Card 2 -->
                    <div class="saved-property-card" data-type="sale">
                        <div class="property-image">
                            <img src="../2.png" alt="Nhà phố Sài Gòn South">
                            <div class="property-badge sale">Bán</div>
                            <div class="property-actions">
                                <button class="action-btn saved" onclick="toggleSave(this)" title="Bỏ lưu">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button class="action-btn" onclick="shareProperty()" title="Chia sẻ">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                                <button class="action-btn" onclick="compareProperty()" title="So sánh">
                                    <i class="fas fa-balance-scale"></i>
                                </button>
                            </div>
                            <div class="save-date">
                                <i class="fas fa-calendar"></i>
                                Lưu ngày 12/09/2024
                            </div>
                        </div>
                        <div class="property-content">
                            <h3 class="property-title">Nhà phố liền kề Sài Gòn South</h3>
                            <p class="property-location">
                                <i class="fas fa-map-marker-alt"></i>
                                Quận 7, TP.HCM
                            </p>
                            <div class="property-price">8.5 tỷ</div>
                            <div class="property-features">
                                <span><i class="fas fa-bed"></i> 4 PN</span>
                                <span><i class="fas fa-bath"></i> 3 WC</span>
                                <span><i class="fas fa-expand-arrows-alt"></i> 120m²</span>
                            </div>
                            <div class="property-status">
                                <span class="status available">
                                    <i class="fas fa-check-circle"></i>
                                    Sẵn sàng
                                </span>
                            </div>
                            <div class="property-actions-bottom">
                                <a href="?act=property&id=2" class="btn btn-outline btn-sm">
                                    <i class="fas fa-eye"></i>
                                    Xem chi tiết
                                </a>
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-phone"></i>
                                    Liên hệ
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Property Card 3 -->
                    <div class="saved-property-card" data-type="rent">
                        <div class="property-image">
                            <img src="../3.jpg" alt="Chung cư Masteri">
                            <div class="property-badge rent">Cho thuê</div>
                            <div class="property-actions">
                                <button class="action-btn saved" onclick="toggleSave(this)" title="Bỏ lưu">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button class="action-btn" onclick="shareProperty()" title="Chia sẻ">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                                <button class="action-btn" onclick="compareProperty()" title="So sánh">
                                    <i class="fas fa-balance-scale"></i>
                                </button>
                            </div>
                            <div class="save-date">
                                <i class="fas fa-calendar"></i>
                                Lưu ngày 10/09/2024
                            </div>
                        </div>
                        <div class="property-content">
                            <h3 class="property-title">Chung cư Masteri Thảo Điền</h3>
                            <p class="property-location">
                                <i class="fas fa-map-marker-alt"></i>
                                Quận 2, TP.HCM
                            </p>
                            <div class="property-price">18 triệu/tháng</div>
                            <div class="property-features">
                                <span><i class="fas fa-bed"></i> 1 PN</span>
                                <span><i class="fas fa-bath"></i> 1 WC</span>
                                <span><i class="fas fa-expand-arrows-alt"></i> 55m²</span>
                            </div>
                            <div class="property-status">
                                <span class="status rented">
                                    <i class="fas fa-times-circle"></i>
                                    Đã thuê
                                </span>
                            </div>
                            <div class="property-actions-bottom">
                                <a href="?act=property&id=3" class="btn btn-outline btn-sm">
                                    <i class="fas fa-eye"></i>
                                    Xem chi tiết
                                </a>
                                <button class="btn btn-outline btn-sm" disabled>
                                    <i class="fas fa-ban"></i>
                                    Đã thuê
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="empty-state" style="display: none;">
                    <div class="empty-icon">
                        <i class="fas fa-heart-broken"></i>
                    </div>
                    <h3>Chưa có BĐS đã lưu</h3>
                    <p>Bạn chưa lưu bất động sản nào. Hãy khám phá và lưu những BĐS yêu thích!</p>
                    <a href="?act=listProperty" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Khám phá BĐS
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const propertyCards = document.querySelectorAll('.saved-property-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            filterTabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            // Show/hide property cards based on filter
            propertyCards.forEach(card => {
                if (filter === 'all' || card.getAttribute('data-type') === filter) {
                    card.style.display = 'block';
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
        
        propertyCards.forEach(card => {
            const title = card.querySelector('.property-title').textContent.toLowerCase();
            const location = card.querySelector('.property-location').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || location.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

// Toggle save functionality
function toggleSave(button) {
    if (button.classList.contains('saved')) {
        // Show confirmation dialog
        if (confirm('Bạn có chắc muốn bỏ lưu bất động sản này?')) {
            const card = button.closest('.saved-property-card');
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.9)';
            
            setTimeout(() => {
                card.remove();
            }, 300);
        }
    }
}

// Share property
function shareProperty() {
    if (navigator.share) {
        navigator.share({
            title: 'Bất động sản trên E-HOME',
            text: 'Xem bất động sản này trên E-HOME',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href);
        alert('Đã copy link vào clipboard!');
    }
}

// Compare property
function compareProperty() {
    alert('Tính năng so sánh sẽ được phát triển trong phiên bản tiếp theo!');
}
</script>