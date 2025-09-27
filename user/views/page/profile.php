<div class="user-profile-wrapper">

<main class="profile-main">
    <div class="container">
        <div class="profile-layout">
            <aside class="profile-sidebar">
                <div class="profile-user-card">
                    <div class="user-avatar">
                        <?php if (!empty($_SESSION['user']['avatar'])): ?>
                            <img src="./uploads/avatar/<?= $_SESSION['user']['avatar'] ?>" alt="Avatar" id="avatarPreview">
                        <?php else: ?>
                            <img src="../logo.jpg" alt="Default Avatar" id="avatarPreview">
                        <?php endif; ?>
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
                    <a href="?act=profile" class="menu-item active">
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
                    <a href="?act=saveProperty" class="menu-item">
                        <i class="fas fa-heart"></i>
                        <span>BĐS đã lưu</span>
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
                <div class="profile-form-container">
                    <form method="POST" enctype="multipart/form-data" class="profile-form">
                        <div class="form-section">
                            <h3>Ảnh đại diện</h3>
                            <div class="avatar-upload">
                                <div class="avatar-preview">
                                    <?php if (!empty($_SESSION['user']['avatar'])): ?>
                                        <img src="./uploads/avatar/<?= $_SESSION['user']['avatar'] ?>" alt="Avatar" id="avatarDisplay">
                                    <?php else: ?>
                                        <img src="../logo.jpg" alt="Default Avatar" id="avatarDisplay">
                                    <?php endif; ?>
                                    <div class="upload-overlay">
                                        <i class="fas fa-camera"></i>
                                        <span>Thay đổi</span>
                                    </div>
                                </div>
                                <input type="file" id="avatar" name="avatar" accept="image/jpg, image/png" hidden>
                                <div class="upload-info">
                                    <p>Tải lên ảnh đại diện mới</p>
                                    <small>Định dạng: JPG, PNG. Kích thước tối đa: 5MB</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-section">
                            <h3>Thông tin cá nhân</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="fullName">Họ và tên <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-user"></i>
                                        <input type="text" id="fullName" name="fullName" 
                                               value="<?= htmlspecialchars($_SESSION['user']['fullName'] ?? '') ?>" 
                                               required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <i class="fas fa-envelope"></i>
                                        <input type="email" id="email" name="email" 
                                               value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phoneNumber">Số điện thoại <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-phone"></i>
                                        <input type="tel" id="phoneNumber" required name="phoneNumber" 
                                               value="<?= htmlspecialchars($_SESSION['user']['phoneNumber'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="form-group full-width">
                                    <label for="address">Địa chỉ</label>
                                    <div class="input-group">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <input type="text" id="address" name="address" 
                                               value="<?= htmlspecialchars($_SESSION['user']['address'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="fullName">Họ và tên <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-user"></i>
                                        <input type="text" id="fullName" name="fullName" 
                                               value="<?= htmlspecialchars($_SESSION['user']['fullName'] ?? '') ?>" 
                                               required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <i class="fas fa-envelope"></i>
                                        <input type="email" id="email" name="email" 
                                               value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phoneNumber">Số điện thoại <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-phone"></i>
                                        <input type="tel" id="phoneNumber" required name="phoneNumber" 
                                               value="<?= htmlspecialchars($_SESSION['user']['phoneNumber'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="form-group full-width">
                                    <label for="address">Địa chỉ</label>
                                    <div class="input-group">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <input type="text" id="address" name="address" 
                                               value="<?= htmlspecialchars($_SESSION['user']['address'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="fullName">Họ và tên <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-user"></i>
                                        <input type="text" id="fullName" name="fullName" 
                                               value="<?= htmlspecialchars($_SESSION['user']['fullName'] ?? '') ?>" 
                                               required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <i class="fas fa-envelope"></i>
                                        <input type="email" id="email" name="email" 
                                               value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phoneNumber">Số điện thoại <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-phone"></i>
                                        <input type="tel" id="phoneNumber" required name="phoneNumber" 
                                               value="<?= htmlspecialchars($_SESSION['user']['phoneNumber'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="form-group full-width">
                                    <label for="address">Địa chỉ</label>
                                    <div class="input-group">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <input type="text" id="address" name="address" 
                                               value="<?= htmlspecialchars($_SESSION['user']['address'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" name="update_profile" class="btn btn-primary">
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
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    const avatarDisplay = document.getElementById('avatarDisplay');
    const avatarPreview = document.getElementById('avatarPreview');
    const uploadOverlay = document.querySelector('.upload-overlay');
    const form = document.querySelector('.profile-form');
    const fullnameInput = document.getElementById('fullName');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phoneNumber');

    const phoneRegex = /^(0|\+84)(3|5|7|8|9)\d{8}$/;
    function showValidationError(inputElement, message) {
        inputElement.setCustomValidity(message);
        inputElement.reportValidity(); 
    }
    function clearValidationError(inputElement) {
        inputElement.setCustomValidity('');
    }
    if (uploadOverlay) {
        uploadOverlay.addEventListener('click', function() {
            avatarInput.click();
        });
    }

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

    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const phoneValue = phoneInput.value.trim();
            const cleanPhone = phoneValue.replace(/[^0-9+]/g, '');
            if (cleanPhone !== "" && !phoneRegex.test(cleanPhone)) {
                showValidationError(phoneInput, 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam 10 số.');
                isValid = false;
            } else {
                clearValidationError(phoneInput);
            }
            const value = fullnameInput.value.trim();
            const nameRegex = /^[a-zA-Z\s\u00C0-\u1EF9]+$/u;            
            if (value === '') {
                showValidationError(fullnameInput, 'Họ và tên không được để trống.');
                 isValid = false;
            }
            if (value.length < 2) {
                showValidationError(fullnameInput, 'Họ và tên phải có ít nhất 2 ký tự.');
                 isValid = false;
            }
            if (value.length > 100) {
                showValidationError(fullnameInput, 'Họ và tên không được vượt quá 100 ký tự.');
                 isValid = false;
            }
            if (!nameRegex.test(value)) {
                showValidationError(fullnameInput, 'Họ và tên chỉ được chứa chữ cái và khoảng trắng.');
                 isValid = false;
            }
            if (!isValid) {
                e.preventDefault(); 
            }
        });
    }
});
</script>
