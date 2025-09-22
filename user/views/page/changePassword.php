<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <div class="page-title">
                <h1><i class="fas fa-lock"></i> Đổi mật khẩu</h1>
                <p>Bảo mật tài khoản bằng cách thay đổi mật khẩu định kỳ</p>
            </div>
            <div class="breadcrumb">
                <a href="index.php"><i class="fas fa-home"></i> Trang chủ</a>
                <span>/</span>
                <a href="?act=profile">Hồ sơ</a>
                <span>/</span>
                <span>Đổi mật khẩu</span>
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
                    <a href="?act=changePassword" class="menu-item active">
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
                    <h2>Đổi mật khẩu</h2>
                    <p>Cập nhật mật khẩu để bảo vệ tài khoản của bạn</p>
                </div>

                <!-- Security Info -->
                <div class="security-notice">
                    <div class="security-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="security-content">
                        <h3>Bảo mật tài khoản</h3>
                        <ul>
                            <li>Sử dụng mật khẩu có ít nhất 8 ký tự</li>
                            <li>Kết hợp chữ hoa, chữ thường, số và ký tự đặc biệt</li>
                            <li>Không sử dụng thông tin cá nhân trong mật khẩu</li>
                            <li>Thay đổi mật khẩu định kỳ</li>
                        </ul>
                    </div>
                </div>

                <!-- Change Password Form -->
                <div class="profile-form-container">
                    <?php if (isset($success_message)): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <?= htmlspecialchars($success_message) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            <?= htmlspecialchars($error_message) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="profile-form change-password-form">
                        <div class="form-section">
                            <h3>Thay đổi mật khẩu</h3>
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label for="currentPassword">Mật khẩu hiện tại <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-lock"></i>
                                        <input type="password" id="currentPassword" name="currentPassword" required>
                                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('currentPassword')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="newPassword">Mật khẩu mới <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-key"></i>
                                        <input type="password" id="newPassword" name="newPassword" required minlength="8">
                                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('newPassword')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="password-strength">
                                        <div class="strength-meter">
                                            <div class="strength-fill"></div>
                                        </div>
                                        <span class="strength-text">Độ mạnh mật khẩu</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="confirmPassword">Xác nhận mật khẩu mới <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-check"></i>
                                        <input type="password" id="confirmPassword" name="confirmPassword" required minlength="8">
                                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('confirmPassword')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="password-match"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary" id="changePasswordBtn">
                                <i class="fas fa-shield-alt"></i>
                                Đổi mật khẩu
                            </button>
                            <button type="reset" class="btn btn-outline">
                                <i class="fas fa-undo"></i>
                                Làm mới
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Recent Security Activity -->
                <div class="security-activity">
                    <h3>Hoạt động bảo mật gần đây</h3>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon success">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="activity-info">
                                <p>Đăng nhập thành công</p>
                                <small>Hôm nay, 14:30 - IP: 192.168.1.1</small>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon info">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="activity-info">
                                <p>Đổi mật khẩu</p>
                                <small>3 ngày trước, 09:15</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Password visibility toggle
function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const button = input.parentNode.querySelector('.toggle-password i');
    
    if (input.type === 'password') {
        input.type = 'text';
        button.classList.remove('fa-eye');
        button.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        button.classList.remove('fa-eye-slash');
        button.classList.add('fa-eye');
    }
}

// Password strength checker
document.getElementById('newPassword').addEventListener('input', function() {
    const password = this.value;
    const strengthMeter = document.querySelector('.strength-fill');
    const strengthText = document.querySelector('.strength-text');
    
    let score = 0;
    let feedback = '';
    
    // Length check
    if (password.length >= 8) score += 25;
    
    // Character variety checks
    if (/[a-z]/.test(password)) score += 25;
    if (/[A-Z]/.test(password)) score += 25;
    if (/[0-9]/.test(password)) score += 12.5;
    if (/[^A-Za-z0-9]/.test(password)) score += 12.5;
    
    // Set meter width and color
    strengthMeter.style.width = score + '%';
    
    if (score < 50) {
        strengthMeter.style.backgroundColor = '#e74c3c';
        feedback = 'Yếu';
    } else if (score < 75) {
        strengthMeter.style.backgroundColor = '#f39c12';
        feedback = 'Trung bình';
    } else {
        strengthMeter.style.backgroundColor = '#27ae60';
        feedback = 'Mạnh';
    }
    
    strengthText.textContent = feedback ? `Độ mạnh: ${feedback}` : 'Độ mạnh mật khẩu';
});

// Password confirmation check
document.getElementById('confirmPassword').addEventListener('input', function() {
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = this.value;
    const matchDiv = document.querySelector('.password-match');
    
    if (confirmPassword) {
        if (newPassword === confirmPassword) {
            matchDiv.innerHTML = '<i class="fas fa-check text-success"></i> Mật khẩu khớp';
            matchDiv.className = 'password-match success';
        } else {
            matchDiv.innerHTML = '<i class="fas fa-times text-error"></i> Mật khẩu không khớp';
            matchDiv.className = 'password-match error';
        }
    } else {
        matchDiv.innerHTML = '';
        matchDiv.className = 'password-match';
    }
});
</script>
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="security-content">
                            <h2>Đổi mật khẩu</h2>
                            <p>Để bảo mật tài khoản, vui lòng sử dụng mật khẩu mạnh và không chia sẻ với người khác.</p>
                        </div>
                    </div>

                    <!-- User Info Card -->
                    <div class="user-info-card">
                        <div class="user-details">
                            <h3><?= htmlspecialchars($userInfo['fullName']) ?></h3>
                            <p><?= htmlspecialchars($userInfo['email']) ?></p>
                        </div>
                        <div class="security-status">
                            <span class="status-badge active">
                                <i class="fas fa-check-circle"></i>
                                Tài khoản hoạt động
                            </span>
                        </div>
                    </div>

                    <!-- Password Form -->
                    <form class="change-password-form" method="POST">
                        <div class="form-section">
                            <h3><i class="fas fa-key"></i> Thông tin mật khẩu</h3>
                            
                            <div class="form-group">
                                <label for="currentPassword">Mật khẩu hiện tại *</label>
                                <div class="password-input-wrapper">
                                    <input type="password" 
                                           id="currentPassword" 
                                           name="currentPassword" 
                                           class="form-control password-input" 
                                           placeholder="Nhập mật khẩu hiện tại"
                                           required>
                                    <button type="button" class="password-toggle" onclick="togglePassword('currentPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="newPassword">Mật khẩu mới *</label>
                                <div class="password-input-wrapper">
                                    <input type="password" 
                                           id="newPassword" 
                                           name="newPassword" 
                                           class="form-control password-input" 
                                           placeholder="Nhập mật khẩu mới"
                                           required>
                                    <button type="button" class="password-toggle" onclick="togglePassword('newPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="password-strength" id="passwordStrength"></div>
                                <div class="password-requirements">
                                    <p>Mật khẩu phải có:</p>
                                    <ul>
                                        <li id="length-req">Ít nhất 6 ký tự</li>
                                        <li id="letter-req">Chữ cái</li>
                                        <li id="number-req">Số</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirmPassword">Xác nhận mật khẩu mới *</label>
                                <div class="password-input-wrapper">
                                    <input type="password" 
                                           id="confirmPassword" 
                                           name="confirmPassword" 
                                           class="form-control password-input" 
                                           placeholder="Nhập lại mật khẩu mới"
                                           required>
                                    <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="password-match" id="passwordMatch"></div>
                            </div>
                        </div>

                        <!-- Security Tips -->
                        <div class="security-tips">
                            <h4><i class="fas fa-lightbulb"></i> Mẹo bảo mật</h4>
                            <ul>
                                <li>Sử dụng mật khẩu duy nhất cho mỗi tài khoản</li>
                                <li>Kết hợp chữ hoa, chữ thường, số và ký tự đặc biệt</li>
                                <li>Không sử dụng thông tin cá nhân dễ đoán</li>
                                <li>Thay đổi mật khẩu định kỳ</li>
                            </ul>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo"></i>
                                Đặt lại
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Cập nhật mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Toggle password visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const toggle = input.nextElementSibling;
    const icon = toggle.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password strength checker
document.getElementById('newPassword').addEventListener('input', function() {
    const password = this.value;
    const strengthDiv = document.getElementById('passwordStrength');
    const lengthReq = document.getElementById('length-req');
    const letterReq = document.getElementById('letter-req');
    const numberReq = document.getElementById('number-req');
    
    // Check requirements
    const hasLength = password.length >= 6;
    const hasLetter = /[a-zA-Z]/.test(password);
    const hasNumber = /\d/.test(password);
    
    // Update requirement indicators
    lengthReq.className = hasLength ? 'valid' : '';
    letterReq.className = hasLetter ? 'valid' : '';
    numberReq.className = hasNumber ? 'valid' : '';
    
    // Calculate strength
    let strength = 0;
    if (hasLength) strength++;
    if (hasLetter) strength++;
    if (hasNumber) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[^a-zA-Z0-9]/.test(password)) strength++;
    
    // Update strength indicator
    let strengthText = '';
    let strengthClass = '';
    
    if (password.length === 0) {
        strengthText = '';
        strengthClass = '';
    } else if (strength <= 2) {
        strengthText = 'Yếu';
        strengthClass = 'weak';
    } else if (strength <= 3) {
        strengthText = 'Trung bình';
        strengthClass = 'medium';
    } else {
        strengthText = 'Mạnh';
        strengthClass = 'strong';
    }
    
    strengthDiv.textContent = strengthText;
    strengthDiv.className = 'password-strength ' + strengthClass;
});

// Password match checker
document.getElementById('confirmPassword').addEventListener('input', function() {
    const password = document.getElementById('newPassword').value;
    const confirmPassword = this.value;
    const matchDiv = document.getElementById('passwordMatch');
    
    if (confirmPassword.length === 0) {
        matchDiv.textContent = '';
        matchDiv.className = 'password-match';
    } else if (password === confirmPassword) {
        matchDiv.textContent = 'Mật khẩu khớp';
        matchDiv.className = 'password-match match';
    } else {
        matchDiv.textContent = 'Mật khẩu không khớp';
        matchDiv.className = 'password-match no-match';
    }
});

// Reset form
function resetForm() {
    document.querySelector('.change-password-form').reset();
    document.getElementById('passwordStrength').textContent = '';
    document.getElementById('passwordMatch').textContent = '';
    document.getElementById('passwordStrength').className = 'password-strength';
    document.getElementById('passwordMatch').className = 'password-match';
    
    // Reset requirement indicators
    document.getElementById('length-req').className = '';
    document.getElementById('letter-req').className = '';
    document.getElementById('number-req').className = '';
}

// Form validation
document.querySelector('.change-password-form').addEventListener('submit', function(e) {
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (newPassword !== confirmPassword) {
        e.preventDefault();
        alert('Mật khẩu xác nhận không khớp!');
        return false;
    }
    
    if (newPassword.length < 6) {
        e.preventDefault();
        alert('Mật khẩu phải có ít nhất 6 ký tự!');
        return false;
    }
});
</script>
                                        <input type="password" id="currentPassword" required>
                                        <button type="button" class="toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="newPassword">Mật khẩu mới *</label>
                                    <div class="password-input">
                                        <input type="password" id="newPassword" required>
                                        <button type="button" class="toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="password-strength">
                                        <div class="strength-bar">
                                            <div class="strength-fill"></div>
                                        </div>
                                        <span class="strength-text">Độ mạnh mật khẩu</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="confirmPassword">Xác nhận mật khẩu mới *</label>
                                    <div class="password-input">
                                        <input type="password" id="confirmPassword" required>
                                        <button type="button" class="toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="password-match">
                                        <span class="match-text"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="password-requirements">
                                <h4>Yêu cầu mật khẩu:</h4>
                                <ul class="requirements-list">
                                    <li class="requirement" data-requirement="length">
                                        <i class="fas fa-times"></i>
                                        <span>Ít nhất 8 ký tự</span>
                                    </li>
                                    <li class="requirement" data-requirement="uppercase">
                                        <i class="fas fa-times"></i>
                                        <span>Có ít nhất 1 chữ hoa</span>
                                    </li>
                                    <li class="requirement" data-requirement="lowercase">
                                        <i class="fas fa-times"></i>
                                        <span>Có ít nhất 1 chữ thường</span>
                                    </li>
                                    <li class="requirement" data-requirement="number">
                                        <i class="fas fa-times"></i>
                                        <span>Có ít nhất 1 số</span>
                                    </li>
                                    <li class="requirement" data-requirement="special">
                                        <i class="fas fa-times"></i>
                                        <span>Có ít nhất 1 ký tự đặc biệt</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="security-tips">
                                <h4>Mẹo bảo mật:</h4>
                                <ul>
                                    <li>Sử dụng mật khẩu duy nhất cho mỗi tài khoản</li>
                                    <li>Không sử dụng thông tin cá nhân dễ đoán</li>
                                    <li>Thay đổi mật khẩu định kỳ (3-6 tháng)</li>
                                    <li>Bật xác thực 2 yếu tố nếu có thể</li>
                                    <li>Không chia sẻ mật khẩu với người khác</li>
                                </ul>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                                <button type="button" class="btn btn-outline">Hủy</button>
                            </div>
                        </form>

                        <div class="two-factor-auth">
                            <h3>Xác thực 2 yếu tố</h3>
                            <p>Tăng cường bảo mật tài khoản bằng cách bật xác thực 2 yếu tố</p>
                            <div class="two-factor-options">
                                <div class="auth-option">
                                    <div class="auth-icon">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                    <div class="auth-info">
                                        <h4>SMS</h4>
                                        <p>Nhận mã xác thực qua tin nhắn</p>
                                    </div>
                                    <div class="auth-action">
                                        <label class="switch-item">
                                            <input type="checkbox">
                                            <span class="switch"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="auth-option">
                                    <div class="auth-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="auth-info">
                                        <h4>Email</h4>
                                        <p>Nhận mã xác thực qua email</p>
                                    </div>
                                    <div class="auth-action">
                                        <label class="switch-item">
                                            <input type="checkbox" checked>
                                            <span class="switch"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="auth-option">
                                    <div class="auth-icon">
                                        <i class="fas fa-qrcode"></i>
                                    </div>
                                    <div class="auth-info">
                                        <h4>Ứng dụng xác thực</h4>
                                        <p>Sử dụng Google Authenticator hoặc tương tự</p>
                                    </div>
                                    <div class="auth-action">
                                        <button class="btn btn-outline btn-sm">Thiết lập</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="login-history">
                            <h3>Lịch sử đăng nhập</h3>
                            <div class="history-list">
                                <div class="history-item">
                                    <div class="history-info">
                                        <div class="device-info">
                                            <i class="fas fa-desktop"></i>
                                            <div>
                                                <span class="device">Windows - Chrome</span>
                                                <span class="location">TP. Hồ Chí Minh, Việt Nam</span>
                                            </div>
                                        </div>
                                        <div class="login-time">
                                            <span>15/12/2024 - 14:30</span>
                                            <span class="current">Hiện tại</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="history-item">
                                    <div class="history-info">
                                        <div class="device-info">
                                            <i class="fas fa-mobile-alt"></i>
                                            <div>
                                                <span class="device">iPhone - Safari</span>
                                                <span class="location">TP. Hồ Chí Minh, Việt Nam</span>
                                            </div>
                                        </div>
                                        <div class="login-time">
                                            <span>14/12/2024 - 09:15</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="history-item">
                                    <div class="history-info">
                                        <div class="device-info">
                                            <i class="fas fa-tablet-alt"></i>
                                            <div>
                                                <span class="device">iPad - Safari</span>
                                                <span class="location">TP. Hồ Chí Minh, Việt Nam</span>
                                            </div>
                                        </div>
                                        <div class="login-time">
                                            <span>13/12/2024 - 20:45</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline">Xem tất cả</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>