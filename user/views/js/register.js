document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('register-form');
    const fullnameInput = document.getElementById('register-fullname');
    const phoneInput = document.getElementById('register-phone');
    const passwordInput = document.getElementById('register-password');
    const passwordConfirmInput = document.getElementById('register-password-confirm');
    
    const fullnameError = document.getElementById('fullname-error');
    const phoneError = document.getElementById('phone-error');
    const passwordError = document.getElementById('password-error');
    const passwordConfirmError = document.getElementById('password-confirm-error');

    function showError(element, message, input) {
        element.textContent = message;
        input.classList.add('is-invalid');
    }
    function hideError(element, input) {
        element.textContent = '';
        input.classList.remove('is-invalid');
    }

    function validateFullname() {
        const value = fullnameInput.value.trim();
        const nameRegex = /^[a-zA-Z\s\u00C0-\u1EF9]+$/u;
        
        if (value === '') {
            showError(fullnameError, 'Họ và tên không được để trống.', fullnameInput);
            return false;
        }
        if (value.length < 2) {
            showError(fullnameError, 'Họ và tên phải có ít nhất 2 ký tự.', fullnameInput);
            return false;
        }
        if (value.length > 100) {
            showError(fullnameError, 'Họ và tên không được vượt quá 100 ký tự.', fullnameInput);
            return false;
        }
        if (!nameRegex.test(value)) {
            showError(fullnameError, 'Họ và tên chỉ được chứa chữ cái và khoảng trắng.', fullnameInput);
            return false;
        }
        
        hideError(fullnameError, fullnameInput);
        return true;
    }

    function validatePhone() {
        const value = phoneInput.value.trim();
        const phoneRegex = /^(0|\+84)[3|5|7|8|9][0-9]{8}$/;
        
        if (value === '') {
            showError(phoneError, 'Số điện thoại không được để trống.', phoneInput);
            return false;
        }
        if (!phoneRegex.test(value)) {
            showError(phoneError, 'Số điện thoại không hợp lệ. Vui lòng nhập đúng định dạng (0xxxxxxxxx).', phoneInput);
            return false;
        }
        
        hideError(phoneError, phoneInput);
        return true;
    }

    function validatePassword() {
        const value = passwordInput.value;
        const passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)/;
        
        if (value.length === 0) {
            showError(passwordError, 'Mật khẩu không được để trống.', passwordInput);
            return false;
        }
        if (value.length < 8) {
            showError(passwordError, 'Mật khẩu phải có ít nhất 8 ký tự.', passwordInput);
            return false;
        }
        if (value.length > 255) {
            showError(passwordError, 'Mật khẩu không được vượt quá 255 ký tự.', passwordInput);
            return false;
        }
        if (!passwordRegex.test(value)) {
            showError(passwordError, 'Mật khẩu phải chứa ít nhất 1 chữ cái và 1 số.', passwordInput);
            return false;
        }
        
        hideError(passwordError, passwordInput);
        if (passwordConfirmInput.value.length > 0) {
            validatePasswordConfirm();
        }
        
        return true;
    }

    function validatePasswordConfirm() {
        const value = passwordConfirmInput.value;
        const passwordValue = passwordInput.value;
        
        if (value === '') {
            showError(passwordConfirmError, 'Vui lòng nhập lại mật khẩu.', passwordConfirmInput);
            return false;
        }
        if (passwordValue !== value) {
            showError(passwordConfirmError, 'Mật khẩu xác nhận không khớp.', passwordConfirmInput);
            return false;
        }
        
        hideError(passwordConfirmError, passwordConfirmInput);
        return true;
    }
    fullnameInput.addEventListener('blur', validateFullname);
    fullnameInput.addEventListener('input', function() {
        if (this.classList.contains('is-invalid')) {
            validateFullname();
        }
    });

    phoneInput.addEventListener('blur', validatePhone);
    phoneInput.addEventListener('input', function() {
        if (this.classList.contains('is-invalid')) {
            validatePhone();
        }
    });

    passwordInput.addEventListener('blur', validatePassword);
    passwordInput.addEventListener('input', function() {
        if (this.classList.contains('is-invalid')) {
            validatePassword();
        }
    });

    passwordConfirmInput.addEventListener('blur', validatePasswordConfirm);
    passwordConfirmInput.addEventListener('input', function() {
        if (this.classList.contains('is-invalid')) {
            validatePasswordConfirm();
        }
    });

    phoneInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.startsWith('84')) {
            value = '+84' + value.substring(2);
        } else if (value.startsWith('0')) {
        } else if (value.length > 0) {
            value = '0' + value;
        }
        this.value = value;
    });
});