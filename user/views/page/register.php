<section class="auth-section register-section">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Đăng ký tài khoản</h2>
                <p>Tham gia cộng đồng E-HOME ngay hôm nay!</p>
            </div>
            <form id="register-form" class="auth-form" method="POST" action="?act=register">
                <div class="form-group">
                    <label for="register-fullname">Họ và tên</label>
                    <input type="text" id="register-fullname" class="form-input" name="fullname" placeholder="Nhập họ và tên" required>
                    <div class="error-message" id="fullname-error"></div>
                </div>
                <div class="form-group">
                    <label for="register-phone">Số điện thoại</label>
                    <input type="tel" id="register-phone" class="form-input" name="phone" placeholder="Nhập số điện thoại" required>
                    <div class="error-message" id="phone-error"></div>
                </div>
                
                <div class="form-group">
                    <label for="register-password">Mật khẩu</label>
                    <input type="password" id="register-password" class="form-input" name="password" placeholder="Tạo mật khẩu" required>
                    <div class="error-message" id="password-error"></div>
                </div>
                <div class="form-group">
                    <label for="register-password-confirm">Nhập lại mật khẩu</label>
                    <input type="password" id="register-password-confirm" class="form-input" name="password-confirm" placeholder="Nhập lại mật khẩu" required>
                    <div class="error-message" id="password-confirm-error"></div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
            </form>
            <div class="auth-footer">
                <span>Đã có tài khoản?</span>
                <a href="?act=login" class="switch-link">Đăng nhập</a>
            </div>
        </div>
    </div>
</section>
<script src="./views/js/register.js"></script>