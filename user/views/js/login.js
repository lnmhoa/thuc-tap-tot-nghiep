document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('.auth-form');
    const phoneInput = document.getElementById('login-phone');
    const passwordInput = document.getElementById('login-password');
    
    // Create error message elements and append them
    const phoneError = document.createElement('span');
    const passwordError = document.createElement('span');
    phoneError.className = 'error-message';
    passwordError.className = 'error-message';
    phoneInput.parentNode.insertBefore(phoneError, phoneInput.nextSibling);
    passwordInput.parentNode.insertBefore(passwordError, passwordInput.nextSibling);

    // Function to show error messages and add invalid class
    function showError(input, errorElement, message) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
        input.classList.add('is-invalid');
    }

    // Function to hide error messages and remove invalid class
    function hideError(input, errorElement) {
        errorElement.textContent = '';
        errorElement.style.display = 'none';
        input.classList.remove('is-invalid');
    }

    // --- Validation functions for each field ---
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
        
        if (passwordValue.length < 6) {
            showError(passwordInput, passwordError, 'Mật khẩu phải có ít nhất 6 ký tự.');
            return false;
        }
        
        hideError(passwordInput, passwordError);
        return true;
    }

    // --- Add event listeners for real-time validation (on blur) ---
    phoneInput.addEventListener('blur', validatePhone);
    passwordInput.addEventListener('blur', validatePassword);

    // --- Main form submission handler ---
    loginForm.addEventListener('submit', function(event) {
        // Run all validation functions on submit
        const isPhoneValid = validatePhone();
        const isPasswordValid = validatePassword();
        
        // If any validation fails, prevent form submission
        if (!isPhoneValid || !isPasswordValid) {
            event.preventDefault();
        }
    });
});