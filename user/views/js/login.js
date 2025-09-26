document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('.auth-form');
    const phoneInput = document.getElementById('login-phone');
    const passwordInput = document.getElementById('login-password');

    const phoneError = document.createElement('span');
    const passwordError = document.createElement('span');
    phoneError.className = 'error-message';
    passwordError.className = 'error-message';
    phoneInput.parentNode.insertBefore(phoneError, phoneInput.nextSibling);
    passwordInput.parentNode.insertBefore(passwordError, passwordInput.nextSibling);

    function showError(input, errorElement, message) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
        input.classList.add('is-invalid');
    }

    function hideError(input, errorElement) {
        errorElement.textContent = '';
        errorElement.style.display = 'none';
        input.classList.remove('is-invalid');
    }

    function validatePhone() {
        const phoneValue = phoneInput.value.trim();
        const phoneRegex = /^(0|\+84)[3|5|7|8|9][0-9]{8}$/;

        if (phoneValue === '') {
            showError(phoneInput, phoneError, 'Vui lòng nhập số điện thoại của bạn.');
            return false;
        } 
        
        if (!phoneRegex.test(phoneValue)) {
            showError(phoneInput, phoneError, 'Số điện thoại không hợp lệ.');
            return false;
        }

        hideError(phoneInput, phoneError);
        return true;
    }

    function validatePassword() {
        const passwordValue = passwordInput.value.trim();

        if (passwordValue === '') {
            showError(passwordInput, passwordError, 'Vui lòng nhập mật khẩu.');
            return false;
        } 
        
        if (passwordValue.length < 8) {
            showError(passwordInput, passwordError, 'Mật khẩu phải có ít nhất 8 ký tự.');
            return false;
        }
         if (passwordValue.length > 255) {
            showError(passwordInput, passwordError, 'Mật khẩu không được vượt quá 255 ký tự.');
            return false;
        }
        
        hideError(passwordInput, passwordError);
        return true;
    }

    phoneInput.addEventListener('blur', validatePhone);
    passwordInput.addEventListener('blur', validatePassword);

    loginForm.addEventListener('submit', function(event) {
        const isPhoneValid = validatePhone();
        const isPasswordValid = validatePassword();
        if (!isPhoneValid || !isPasswordValid) {
            event.preventDefault();
        }
    });
});