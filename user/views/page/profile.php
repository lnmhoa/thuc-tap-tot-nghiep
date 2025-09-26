<div class="user-profile-wrapper">

<main class="profile-main">
    <div class="container">
        <div class="profile-layout">
            <aside class="profile-sidebar">
                <div class="profile-user-card">
                    <div class="user-avatar">
                        <?php if (!empty($userInfo['avatar'])): ?>
                            <img src="./uploads/avatar/<?= $userInfo['avatar'] ?>" alt="Avatar" id="avatarPreview">
                        <?php else: ?>
                            <img src="../logo.jpg" alt="Default Avatar" id="avatarPreview">
                        <?php endif; ?>
                    </div>
                    <div class="user-info">
                        <h3><?= htmlspecialchars($userInfo['fullName'] ?? 'Người dùng') ?></h3>
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

            <div class="profile-content">
                <div class="content-header">
                    <h2>Thông tin cá nhân</h2>
                    <p>Cập nhật và quản lý thông tin cá nhân của bạn</p>
                </div>

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
</div>

<script>
// Avatar upload functionality
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    const avatarDisplay = document.getElementById('avatarDisplay');
    const avatarPreview = document.getElementById('avatarPreview');
    const uploadOverlay = document.querySelector('.upload-overlay');

    // Click to upload
    if (uploadOverlay) {
        uploadOverlay.addEventListener('click', function() {
            avatarInput.click();
        });
    }

    // Preview uploaded image
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (avatarDisplay) avatarDisplay.src = e.target.result;
                    if (avatarPreview) avatarPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
