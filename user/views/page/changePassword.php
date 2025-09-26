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
                    </div>
                    <div class="user-info">
                        <h3><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Người dùng') ?></h3>
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
</div>
<script>
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

document.getElementById('newPassword').addEventListener('input', function() {
    const password = this.value;
    const strengthDiv = document.getElementById('passwordStrength');
    const lengthReq = document.getElementById('length-req');
    const letterReq = document.getElementById('letter-req');
    const numberReq = document.getElementById('number-req');

    const hasLength = password.length >= 6;
    const hasLetter = /[a-zA-Z]/.test(password);
    const hasNumber = /\d/.test(password);

    lengthReq.className = hasLength ? 'valid' : '';
    letterReq.className = hasLetter ? 'valid' : '';
    numberReq.className = hasNumber ? 'valid' : '';
    
    let strength = 0;
    if (hasLength) strength++;
    if (hasLetter) strength++;
    if (hasNumber) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[^a-zA-Z0-9]/.test(password)) strength++;
    
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

function resetForm() {
    document.querySelector('.change-password-form').reset();
    document.getElementById('passwordStrength').textContent = '';
    document.getElementById('passwordMatch').textContent = '';
    document.getElementById('passwordStrength').className = 'password-strength';
    document.getElementById('passwordMatch').className = 'password-match';

    document.getElementById('length-req').className = '';
    document.getElementById('letter-req').className = '';
    document.getElementById('number-req').className = '';
}

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