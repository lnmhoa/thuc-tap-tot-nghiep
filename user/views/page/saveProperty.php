<div class="save-property">
    <section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <div class="page-title">
                <h1><i class="fas fa-heart"></i> BĐS đã lưu</h1>
                <p>Quản lý danh sách bất động sản yêu thích của bạn</p>
            </div>
            <div class="breadcrumb">
                <a href="index.php"><i class="fas fa-home"></i> Trang chủ</a>
                <span>/</span>
                <a href="?act=profile">Hồ sơ</a>
                <span>/</span>
                <span>BĐS đã lưu</span>
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
                    <a href="?act=saveProperty" class="menu-item active">
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
                    <a href="?act=consultationRequest" class="menu-item">
                        <i class="fas fa-comments"></i>
                        <span>Yêu cầu tư vấn</span>
                    </a>
                </nav>
            </aside>

            <!-- Profile Content -->
            <div class="profile-content">
                <div class="content-header">
                    <h2>Bất động sản đã lưu</h2>
                    <p>Danh sách các bất động sản bạn đã đánh dấu yêu thích</p>
                </div>

                <!-- Saved Properties Stats -->
                <div class="saved-stats">
                    <div class="stat-card">
                        <div class="stat-icon saved">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="stat-info">
                            <h3>24</h3>
                            <p>Đã lưu</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon rent">
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="stat-info">
                            <h3>16</h3>
                            <p>Cho thuê</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon sale">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="stat-info">
                            <h3>8</h3>
                            <p>Bán</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon recent">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h3>5</h3>
                            <p>Tuần này</p>
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
                        <button class="filter-tab" data-filter="rent">
                            <i class="fas fa-key"></i>
                            Cho thuê
                        </button>
                        <button class="filter-tab" data-filter="sale">
                            <i class="fas fa-tag"></i>
                            Bán
                        </button>
                        <button class="filter-tab" data-filter="recent">
                            <i class="fas fa-clock"></i>
                            Gần đây
                        </button>
                    </div>
                    <div class="filter-actions">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Tìm kiếm BĐS đã lưu...">
                        </div>
                        <div class="sort-options">
                            <select class="form-select">
                                <option value="newest">Mới nhất</option>
                                <option value="oldest">Cũ nhất</option>
                                <option value="price-asc">Giá tăng dần</option>
                                <option value="price-desc">Giá giảm dần</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Saved Properties Grid -->
                <div class="saved-properties-grid">
                    <!-- Property Card 1 -->
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

                <!-- Empty State -->
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
// Filter functionality
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
                            <div class="stat-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number"><?= number_format($stats['total']) ?></span>
                                <span class="stat-label">Tổng BĐS đã lưu</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-month"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number"><?= number_format($stats['thisMonth']) ?></span>
                                <span class="stat-label">Lưu tháng này</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-number"><?= number_format($stats['avgPrice']) ?></span>
                                <span class="stat-label">Giá trung bình</span>
                            </div>
                        </div>
                    </div>

                    <!-- Properties Grid -->
                    <?php if (!empty($savedProperties)): ?>
                    <div class="saved-properties-grid">
                        <?php foreach ($savedProperties as $property): ?>
                        <div class="saved-property-card" data-property-id="<?= $property['id'] ?>">
                            <div class="property-image">
                                <img src="<?= !empty($property['mainImage']) ? $property['mainImage'] : 'placeholder.jpg' ?>" 
                                     alt="<?= htmlspecialchars($property['title']) ?>">
                                <div class="property-badges">
                                    <span class="transaction-type <?= $property['transactionType'] === 'rent' ? 'rent' : 'sale' ?>">
                                        <?= $property['transactionType'] === 'rent' ? 'Cho thuê' : 'Bán' ?>
                                    </span>
                                </div>
                                <div class="property-actions">
                                    <button class="action-btn remove-btn" onclick="removeSavedProperty(<?= $property['id'] ?>)" 
                                            title="Xóa khỏi danh sách yêu thích">
                                        <i class="fas fa-heart-broken"></i>
                                    </button>
                                    <a href="?act=property&id=<?= $property['id'] ?>" class="action-btn view-btn" 
                                       title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="property-content">
                                <div class="property-price">
                                    <?= number_format($property['price']) ?> VNĐ
                                </div>
                                
                                <h3 class="property-title">
                                    <a href="?act=property&id=<?= $property['id'] ?>">
                                        <?= htmlspecialchars($property['title']) ?>
                                    </a>
                                </h3>
                                
                                <div class="property-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?= htmlspecialchars($property['address']) ?>
                                </div>
                                
                                <div class="property-features">
                                    <span class="feature">
                                        <i class="fas fa-expand-arrows-alt"></i>
                                        <?= number_format($property['area']) ?>m²
                                    </span>
                                    <?php if ($property['bedrooms']): ?>
                                    <span class="feature">
                                        <i class="fas fa-bed"></i>
                                        <?= $property['bedrooms'] ?> PN
                                    </span>
                                    <?php endif; ?>
                                    <?php if ($property['bathrooms']): ?>
                                    <span class="feature">
                                        <i class="fas fa-bath"></i>
                                        <?= $property['bathrooms'] ?> WC
                                    </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="property-meta">
                                    <div class="saved-date">
                                        <i class="fas fa-heart"></i>
                                        Đã lưu: <?= date('d/m/Y', strtotime($property['savedAt'])) ?>
                                    </div>
                                    <div class="property-type">
                                        <?= htmlspecialchars($property['propertyType']) ?>
                                    </div>
                                </div>
                                
                                <?php if ($property['brokerName']): ?>
                                <div class="broker-info">
                                    <img src="<?= !empty($property['brokerAvatar']) ? $property['brokerAvatar'] : 'default-avatar.png' ?>" 
                                         alt="<?= htmlspecialchars($property['brokerName']) ?>" class="broker-avatar">
                                    <span class="broker-name"><?= htmlspecialchars($property['brokerName']) ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                    <div class="pagination-wrapper">
                        <nav class="pagination">
                            <?php if ($page > 1): ?>
                            <a href="?act=saveProperty&page=<?= $page - 1 ?>" class="page-btn prev">
                                <i class="fas fa-chevron-left"></i> Trước
                            </a>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <a href="?act=saveProperty&page=<?= $i ?>" 
                               class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                            <a href="?act=saveProperty&page=<?= $page + 1 ?>" class="page-btn next">
                                Sau <i class="fas fa-chevron-right"></i>
                            </a>
                            <?php endif; ?>
                        </nav>
                    </div>
                    <?php endif; ?>

                    <?php else: ?>
                    <!-- Empty State -->
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-heart-broken"></i>
                        </div>
                        <h3>Chưa có bất động sản nào được lưu</h3>
                        <p>Hãy khám phá và lưu những bất động sản yêu thích của bạn!</p>
                        <a href="?act=listProperty" class="btn btn-primary">
                            <i class="fas fa-search"></i> Khám phá ngay
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Remove Property Modal -->
<div id="removeModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Xác nhận xóa</h4>
            <span class="modal-close">&times;</span>
        </div>
        <div class="modal-body">
            <p>Bạn có chắc chắn muốn xóa bất động sản này khỏi danh sách yêu thích không?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeRemoveModal()">Hủy</button>
            <form id="removeForm" method="POST" style="display: inline;">
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="propertyId" id="removePropertyId">
                <button type="submit" class="btn btn-danger">Xóa</button>
            </form>
        </div>
    </div>
</div>

<script>
// Remove property functions
function removeSavedProperty(propertyId) {
    document.getElementById('removePropertyId').value = propertyId;
    document.getElementById('removeModal').style.display = 'block';
}

function closeRemoveModal() {
    document.getElementById('removeModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('removeModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

// Close modal with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeRemoveModal();
    }
});
</script>
                                    <option value="oldest">Cũ nhất</option>
                                    <option value="price-low">Giá thấp đến cao</option>
                                    <option value="price-high">Giá cao đến thấp</option>
                                </select>
                                <button class="btn btn-outline" onclick="clearAllSaved()">
                                    <i class="fas fa-trash"></i>
                                    Xóa tất cả
                                </button>
                            </div>
                        </div>

                        <div class="saved-properties-grid">
                            <div class="saved-property-card">
                                <div class="property-image">
                                    <img src="/placeholder.svg?height=200&width=300" alt="Căn hộ">
                                    <div class="property-badge">Cho thuê</div>
                                    <button class="remove-saved-btn" title="Bỏ lưu">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <div class="saved-date">Lưu: 15/12/2024</div>
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
                                    <div class="property-actions">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-phone"></i>
                                            Liên hệ
                                        </button>
                                        <button class="btn btn-outline">
                                            <i class="fas fa-eye"></i>
                                            Xem chi tiết
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="saved-property-card">
                                <div class="property-image">
                                    <img src="/placeholder.svg?height=200&width=300" alt="Nhà phố">
                                    <div class="property-badge sale">Bán</div>
                                    <button class="remove-saved-btn" title="Bỏ lưu">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <div class="saved-date">Lưu: 14/12/2024</div>
                                </div>
                                <div class="property-info">
                                    <h3><a href="property-detail.html">Nhà phố mặt tiền đường lớn</a></h3>
                                    <p class="location"><i class="fas fa-map-marker-alt"></i> Quận 7, TP.HCM</p>
                                    <p class="price">8.5 tỷ</p>
                                    <div class="property-features">
                                        <span><i class="fas fa-bed"></i> 4 phòng ngủ</span>
                                        <span><i class="fas fa-bath"></i> 3 phòng tắm</span>
                                        <span><i class="fas fa-expand-arrows-alt"></i> 120m²</span>
                                    </div>
                                    <div class="property-actions">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-phone"></i>
                                            Liên hệ
                                        </button>
                                        <button class="btn btn-outline">
                                            <i class="fas fa-eye"></i>
                                            Xem chi tiết
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="saved-property-card">
                                <div class="property-image">
                                    <img src="/placeholder.svg?height=200&width=300" alt="Văn phòng">
                                    <div class="property-badge">Cho thuê</div>
                                    <button class="remove-saved-btn" title="Bỏ lưu">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <div class="saved-date">Lưu: 13/12/2024</div>
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
                                    <div class="property-actions">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-phone"></i>
                                            Liên hệ
                                        </button>
                                        <button class="btn btn-outline">
                                            <i class="fas fa-eye"></i>
                                            Xem chi tiết
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="saved-property-card">
                                <div class="property-image">
                                    <img src="/placeholder.svg?height=200&width=300" alt="Penthouse">
                                    <div class="property-badge">Cho thuê</div>
                                    <button class="remove-saved-btn" title="Bỏ lưu">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <div class="saved-date">Lưu: 12/12/2024</div>
                                </div>
                                <div class="property-info">
                                    <h3><a href="property-detail.html">Penthouse view sông Sài Gòn</a></h3>
                                    <p class="location"><i class="fas fa-map-marker-alt"></i> Quận 2, TP.HCM</p>
                                    <p class="price">80 triệu/tháng</p>
                                    <div class="property-features">
                                        <span><i class="fas fa-bed"></i> 3 phòng ngủ</span>
                                        <span><i class="fas fa-bath"></i> 3 phòng tắm</span>
                                        <span><i class="fas fa-expand-arrows-alt"></i> 150m²</span>
                                    </div>
                                    <div class="property-actions">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-phone"></i>
                                            Liên hệ
                                        </button>
                                        <button class="btn btn-outline">
                                            <i class="fas fa-eye"></i>
                                            Xem chi tiết
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="saved-property-card">
                                <div class="property-image">
                                    <img src="/placeholder.svg?height=200&width=300" alt="Đất nền">
                                    <div class="property-badge sale">Bán</div>
                                    <button class="remove-saved-btn" title="Bỏ lưu">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <div class="saved-date">Lưu: 11/12/2024</div>
                                </div>
                                <div class="property-info">
                                    <h3><a href="property-detail.html">Đất nền khu d��n cư cao cấp</a></h3>
                                    <p class="location"><i class="fas fa-map-marker-alt"></i> Quận 9, TP.HCM</p>
                                    <p class="price">3.2 tỷ</p>
                                    <div class="property-features">
                                        <span><i class="fas fa-expand-arrows-alt"></i> 100m²</span>
                                        <span><i class="fas fa-road"></i> Mặt tiền 5m</span>
                                        <span><i class="fas fa-certificate"></i> Sổ hồng</span>
                                    </div>
                                    <div class="property-actions">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-phone"></i>
                                            Liên hệ
                                        </button>
                                        <button class="btn btn-outline">
                                            <i class="fas fa-eye"></i>
                                            Xem chi tiết
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="saved-property-card">
                                <div class="property-image">
                                    <img src="/placeholder.svg?height=200&width=300" alt="Phòng trọ">
                                    <div class="property-badge">Cho thuê</div>
                                    <button class="remove-saved-btn" title="Bỏ lưu">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <div class="saved-date">Lưu: 10/12/2024</div>
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
                                    <div class="property-actions">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-phone"></i>
                                            Liên hệ
                                        </button>
                                        <button class="btn btn-outline">
                                            <i class="fas fa-eye"></i>
                                            Xem chi tiết
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div class="empty-state" style="display: none;">
                            <div class="empty-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h3>Chưa có bất động sản nào được lưu</h3>
                            <p>Hãy khám phá và lưu những bất động sản yêu thích của bạn</p>
                            <a href="properties.html" class="btn btn-primary">Khám phá ngay</a>
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
</div>
