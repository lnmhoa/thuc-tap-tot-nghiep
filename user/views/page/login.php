<section class="auth-section login-section">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Đăng nhập tài khoản</h2>
                <p>Chào mừng bạn quay lại E-HOME!</p>
            </div>
            <form class="auth-form" method="post" action="">
                <div class="form-group">
                    <label for="login-phone">Số điện thoại</label>
                    <input type="tel" id="login-phone" name="phone" class="form-input" placeholder="Nhập số điện thoại" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Mật khẩu</label>
                    <input type="password" id="login-password" name="password" class="form-input" placeholder="Nhập mật khẩu" required>
                </div>
                <div class="form-options">
                    <label class="checkbox-inline" for="remember-me">
                        <input type="checkbox" id="remember-me" name="remember_me"> Ghi nhớ đăng nhập
                    </label>
                </div>
                <button type="submit" name="login_submit" class="btn btn-primary btn-block">Đăng nhập</button>
            </form>
            <div class="auth-footer">
                <span>Bạn chưa có tài khoản?</span>
                <a href="?act=register" class="switch-link">Đăng ký ngay</a>
            </div>
        </div>
    </div>
</section>
<script src="./views/js/login.js"></script>