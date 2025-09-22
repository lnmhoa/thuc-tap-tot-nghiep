<div class=""></div>
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <div class="page-title">
                <h1><i class="fas fa-user-circle"></i> Hồ sơ cá nhân</h1>
                <p>Quản lý thông tin cá nhân và cài đặt tài khoản</p>
            </div>
            <div class="breadcrumb">
                <a href="index.php"><i class="fas fa-home"></i> Trang chủ</a>
                <span>/</span>
                <span>Hồ sơ cá nhân</span>
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
                        <?php if (!empty($userInfo['avatar'])): ?>
                            <img src="./uploads/avatar/<?= $userInfo['avatar'] ?>" alt="Avatar" id="avatarPreview">
                        <?php else: ?>
                            <img src="../logo.jpg" alt="Default Avatar" id="avatarPreview">
                        <?php endif; ?>
                        <div class="avatar-status online"></div>
                    </div>
                    <div class="user-info">
                        <h3><?= htmlspecialchars($userInfo['fullName'] ?? 'Người dùng') ?></h3>
                        <p><?= htmlspecialchars($userInfo['email'] ?? '') ?></p>
                        <div class="user-badge">
                            <i class="fas fa-shield-alt"></i>
                            Thành viên
                        </div>
                    </div>
                </div>
                
                <nav class="profile-menu">
                    <a href="?act=profile" class="menu-item active">
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
                    <a href="?act=consultationRequest" class="menu-item">
                        <i class="fas fa-comments"></i>
                        <span>Yêu cầu tư vấn</span>
                    </a>
                </nav>
            </aside>

            <!-- Profile Content -->
            <div class="profile-content">
                <div class="content-header">
                    <h2>Thông tin cá nhân</h2>
                    <p>Cập nhật và quản lý thông tin cá nhân của bạn</p>
                </div>

                <!-- Profile Form -->
                <div class="profile-form-container">
                    <?php if (!empty($successMessage)): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <?= htmlspecialchars($successMessage) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data" class="profile-form">
                        <!-- Avatar Upload -->
                        <div class="form-section">
                            <h3>Ảnh đại diện</h3>
                            <div class="avatar-upload">
                                <div class="avatar-preview">
                                    <?php if (!empty($userInfo['avatar'])): ?>
                                        <img src="./uploads/avatar/<?= $userInfo['avatar'] ?>" alt="Avatar" id="avatarDisplay">
                                    <?php else: ?>
                                        <img src="../logo.jpg" alt="Default Avatar" id="avatarDisplay">
                                    <?php endif; ?>
                                    <div class="upload-overlay">
                                        <i class="fas fa-camera"></i>
                                        <span>Thay đổi</span>
                                    </div>
                                </div>
                                <input type="file" id="avatar" name="avatar" accept="image/*" hidden>
                                <div class="upload-info">
                                    <p>Tải lên ảnh đại diện mới</p>
                                    <small>Định dạng: JPG, PNG. Kích thước tối đa: 5MB</small>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="form-section">
                            <h3>Thông tin cá nhân</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="fullName">Họ và tên <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-user"></i>
                                        <input type="text" id="fullName" name="fullName" 
                                               value="<?= htmlspecialchars($userInfo['fullName'] ?? '') ?>" 
                                               required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <i class="fas fa-envelope"></i>
                                        <input type="email" id="email" name="email" 
                                               value="<?= htmlspecialchars($userInfo['email'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phoneNumber">Số điện thoại</label>
                                    <div class="input-group">
                                        <i class="fas fa-phone"></i>
                                        <input type="tel" id="phoneNumber" name="phoneNumber" 
                                               value="<?= htmlspecialchars($userInfo['phoneNumber'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="form-group full-width">
                                    <label for="address">Địa chỉ</label>
                                    <div class="input-group">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <input type="text" id="address" name="address" 
                                               value="<?= htmlspecialchars($userInfo['address'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Lưu thay đổi
                            </button>
                            <button type="reset" class="btn btn-outline">
                                <i class="fas fa-undo"></i>
                                Khôi phục
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Avatar upload functionality
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    const avatarDisplay = document.getElementById('avatarDisplay');
    const avatarPreview = document.getElementById('avatarPreview');
    const uploadOverlay = document.querySelector('.upload-overlay');

    // Click to upload
    uploadOverlay.addEventListener('click', function() {
        avatarInput.click();
    });

    // Preview uploaded image
    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarDisplay.src = e.target.result;
                avatarPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

            <!-- Main Content Area -->
            <div class="content-area">
                <div class="content-header">
                    <div class="results-info">
                        <span>Tìm thấy <strong><?= isset($total) ? number_format($total) : 0 ?></strong> bất động sản</span>
                    </div>
                    <div class="sort-options">
                        <label>Sắp xếp:</label>
                        <select class="form-select" onchange="updateSort(this.value)">
                            <option value="newest" <?= isset($_GET['sortBy']) && $_GET['sortBy'] == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                            <option value="price-low" <?= isset($_GET['sortBy']) && $_GET['sortBy'] == 'price-low' ? 'selected' : '' ?>>Giá thấp đến cao</option>
                            <option value="price-high" <?= isset($_GET['sortBy']) && $_GET['sortBy'] == 'price-high' ? 'selected' : '' ?>>Giá cao đến thấp</option>
                            <option value="area-small" <?= isset($_GET['sortBy']) && $_GET['sortBy'] == 'area-small' ? 'selected' : '' ?>>Diện tích nhỏ đến lớn</option>
                            <option value="area-large" <?= isset($_GET['sortBy']) && $_GET['sortBy'] == 'area-large' ? 'selected' : '' ?>>Diện tích lớn đến nhỏ</option>
                        </select>
                    </div>
                </div>

                <div class="properties-grid">
                    <?php if (!empty($properties)): ?>
                        <?php foreach ($properties as $item): ?>
                            <div class="property-card">
                                <div class="property-image">
                                    <img src="<?= !empty($item['mainImage']) ? $item['mainImage'] : 'placeholder.svg' ?>" 
                                         alt="<?= htmlspecialchars($item['title']) ?>" 
                                         style="height:200px;width:100%;object-fit:cover;">
                                    <div class="property-badge<?= $item['transactionType']==='sale' ? ' sale' : '' ?>">
                                        <?= $item['transactionType']==='sale' ? 'Bán' : 'Cho thuê' ?>
                                    </div>
                                    <button class="save-btn"><i class="far fa-heart"></i></button>
                                </div>
                                <div class="property-info">
                                    <h3><a href="index.php?act=property&id=<?= $item['id'] ?>">
                                        <?= htmlspecialchars($item['title']) ?>
                                    </a></h3>
                                    <p class="location"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($item['locationName'] ?? $item['address']) ?></p>
                                    <p class="price">
                                        <?= number_format($item['price'], 0, ',', '.') ?><?= $item['transactionType']==='sale' ? ' VNĐ' : ' VNĐ/tháng' ?>
                                    </p>
                                    <div class="property-features">
                                        <span><?= $item['area'] ?? 0 ?> m²</span>
                                        <?php if ($item['bedrooms'] > 0): ?>
                                            | <span><?= $item['bedrooms'] ?> PN</span>
                                        <?php endif; ?>
                                        <?php if ($item['bathrooms'] > 0): ?>
                                            | <span><?= $item['bathrooms'] ?> WC</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="property-agent">
                                        <?php if (!empty($item['brokerAvatar'])): ?>
                                            <img src="<?= $item['brokerAvatar'] ?>" alt="<?= htmlspecialchars($item['brokerName']) ?>" 
                                                 style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                                        <?php endif; ?>
                                        <span><?= htmlspecialchars($item['brokerName'] ?? 'Đại lý') ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-results">
                            <p>Không tìm thấy bất động sản phù hợp với tiêu chí tìm kiếm.</p>
                            <a href="index.php?act=property" class="btn btn-primary">Xem tất cả</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if (!empty($properties)): ?>
                    <?php
                    $totalPages = isset($total) ? ceil($total / $limit) : 1;
                    $currentPage = isset($page) ? $page : 1;
                    ?>
                    <div class="pagination">
                        <?php if ($currentPage > 1): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage-1])) ?>" class="page-btn">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $currentPage-2); $i <= min($totalPages, $currentPage+2); $i++): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" 
                               class="page-btn<?= $i == $currentPage ? ' active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($currentPage < $totalPages): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage+1])) ?>" class="page-btn">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
function updateSort(sortBy) {
    const url = new URL(window.location);
    url.searchParams.set('sortBy', sortBy);
    window.location.href = url.href;
}
</script>
