<div class="user-profile-wrapper">
    <main class="profile-main">
        <div class="container">
            <div class="profile-layout">
                <aside class="profile-sidebar">
                    <div class="profile-user-card">
                        <div class="user-avatar">
                           <?php if (!empty($_SESSION['user']['avatar'])): ?>
                            <img src="../uploads/user/<?= $_SESSION['user']['avatar'] ?>" alt="Avatar" id="avatarPreview">
                        <?php else: ?>
                            <img src="../uploads/system/default_user.jpg" alt="Default Avatar" id="avatarPreview">
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
                                            <input type="password" id="currentPassword" name="currentPassword" required minlength="8">
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
                                        <div class="password-match" id="passwordMatch"></div> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" id="changePasswordBtn">
                                    <i class="fas fa-shield-alt"></i>
                                    Đổi mật khẩu
                                </button>
                                <button type="reset" class="btn btn-outline" onclick="resetForm()">
                                    <i class="fas fa-undo"></i>
                                    Làm mới
                                </button>
                            </div>
                        </form>
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
    function showValidationError(inputElement, message) {
        inputElement.setCustomValidity(message);
        inputElement.reportValidity(); 
    }

    function clearValidationError(inputElement) {
        inputElement.setCustomValidity('');
    }

    function validatePasswordRules(passwordInput) {
        const password = passwordInput.value;
        const passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)/;
        const minLength = 8; 
        const maxLength = 255;
        clearValidationError(passwordInput);
        if (password.length === 0) {
            showValidationError(passwordInput, 'Mật khẩu không được để trống.');
            return false;
        }
        if (password.length < minLength) {
            showValidationError(passwordInput, `Mật khẩu phải có ít nhất ${minLength} ký tự.`);
            return false;
        }
        if (password.length > maxLength) {
            showValidationError(passwordInput, `Mật khẩu không được vượt quá ${maxLength} ký tự.`);
            return false;
        }
        if (!passwordRegex.test(password)) {
            showValidationError(passwordInput, 'Mật khẩu phải chứa ít nhất 1 chữ cái và 1 số.');
            return false;
        }
        return true;
    }
    function checkPasswordMatch() {
        const newPasswordInput = document.getElementById('newPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const password = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        const matchDiv = document.getElementById('passwordMatch');
        clearValidationError(confirmPasswordInput); 
        if (confirmPassword.length === 0) {
            matchDiv.textContent = '';
            matchDiv.className = 'password-match';
            return false;
        } else if (password === confirmPassword) {
            matchDiv.textContent = 'Mật khẩu khớp';
            matchDiv.className = 'password-match match';
            return true;
        } else {
            matchDiv.textContent = 'Mật khẩu không khớp';
            matchDiv.className = 'password-match no-match';
            showValidationError(confirmPasswordInput, 'Mật khẩu xác nhận không khớp.');
            return false;
        }
    }
    function resetForm() {
        document.querySelector('.change-password-form').reset(); 
        clearValidationError(document.getElementById('currentPassword'));
        clearValidationError(document.getElementById('newPassword'));
        clearValidationError(document.getElementById('confirmPassword'));
        const matchDiv = document.getElementById('passwordMatch');
        if (matchDiv) {
            matchDiv.textContent = '';
            matchDiv.className = 'password-match';
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        const currentPasswordInput = document.getElementById('currentPassword');
        const newPasswordInput = document.getElementById('newPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const form = document.querySelector('.change-password-form');
        if (currentPasswordInput) {
            currentPasswordInput.addEventListener('blur', function() {
                validatePasswordRules(currentPasswordInput);
            });
        }
        if (newPasswordInput) {
            newPasswordInput.addEventListener('blur', function() {
                validatePasswordRules(newPasswordInput);
                if (confirmPasswordInput.value.length > 0) {
                    checkPasswordMatch();
                }
            });
            newPasswordInput.addEventListener('input', checkPasswordMatch);
        }
        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener('blur', function() {
                if (validatePasswordRules(confirmPasswordInput)) {
                    checkPasswordMatch();
                }
            });
            confirmPasswordInput.addEventListener('input', checkPasswordMatch);
        }
        if (form) {
            form.addEventListener('submit', function(e) {
                let isValid = true;
                if (!validatePasswordRules(currentPasswordInput)) {
                    isValid = false;
                }
                if (!validatePasswordRules(newPasswordInput)) {
                    isValid = false;
                }
                if (!validatePasswordRules(confirmPasswordInput) || !checkPasswordMatch()) {
                    isValid = false; 
                }
                if (!isValid) {
                    e.preventDefault(); 
                }
            });
        }
    });
</script>