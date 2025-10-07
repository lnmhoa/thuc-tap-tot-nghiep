document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.form-step');
    const progressSteps = document.querySelectorAll('.progress-step');
    const nextButtons = document.querySelectorAll('.next-step');
    const prevButtons = document.querySelectorAll('.prev-step');
    let currentStep = 0;
    showStep(currentStep);

    nextButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
                updatePreview();
            }
        });
    });
    prevButtons.forEach(button => {
        button.addEventListener('click', () => {
            currentStep--;
            showStep(currentStep);
        });
    });

    function showStep(step) {
        steps.forEach((stepElement, index) => {
            stepElement.style.display = index === step ? 'block' : 'none';
        });
        progressSteps.forEach((progressStep, index) => {
            progressStep.classList.remove('active', 'completed');
            if (index < step) {
                progressStep.classList.add('completed');
            } else if (index === step) {
                progressStep.classList.add('active');
            }
        });

        document.querySelector('.form-container').scrollTop = 0;
    }

    function validateStep(step) {
        const currentStepElement = steps[step];
        const requiredFields = currentStepElement.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('error');
                isValid = false;
            } else {
                field.classList.remove('error');
            }
        });

        if (!isValid) {
            showAlert('Vui lòng điền đầy đủ thông tin bắt buộc', 'error');
        }

        return isValid;
    }

    function updatePreview() {
        const title = document.getElementById('title')?.value || 'Tiêu đề bất động sản';
        const transactionType = document.querySelector('input[name="transactionType"]:checked')?.value || 'sell';
        const address = document.getElementById('address')?.value || 'Địa chỉ';
        const area = document.getElementById('area')?.value || '0';
        const bedrooms = document.getElementById('bedrooms')?.value || '0';
        const bathrooms = document.getElementById('bathrooms')?.value || '0';
        const price = document.getElementById('price')?.value || '0';

        document.getElementById('previewTitle').textContent = title;
        document.getElementById('previewPurpose').textContent = transactionType === 'sell' ? 'Bán' : 'Cho thuê';
        document.getElementById('previewLocation').textContent = address;
        document.getElementById('previewArea').innerHTML = `<i class="fas fa-expand-arrows-alt"></i> ${area}m²`;
        document.getElementById('previewBedrooms').innerHTML = `<i class="fas fa-bed"></i> ${bedrooms} phòng ngủ`;
        document.getElementById('previewBathrooms').innerHTML = `<i class="fas fa-bath"></i> ${bathrooms} phòng tắm`;
        document.getElementById('previewPrice').textContent = formatPrice(price) + ' VNĐ';
    }
    const uploadArea = document.getElementById('uploadArea');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const uploadLink = document.querySelector('.upload-link');
    let uploadedImages = [];
    uploadArea.addEventListener('click', () => imageInput.click());
    uploadLink.addEventListener('click', (e) => {
        e.stopPropagation();
        imageInput.click();
    });
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        handleFiles(files);
    });
    imageInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });

    function handleFiles(files) {
        Array.from(files).forEach(file => {
            if (uploadedImages.length >= 20) {
                showAlert('Tối đa 20 ảnh được phép tải lên', 'warning');
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                showAlert(`File ${file.name} quá lớn (>5MB)`, 'error');
                return;
            }

            if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                showAlert(`File ${file.name} không đúng định dạng`, 'error');
                return;
            }

            uploadedImages.push(file);
            displayImagePreview(file, uploadedImages.length - 1);
        });

        if (uploadedImages.length > 0 && uploadedImages[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById('previewMainImage').src = e.target.result;
            };
            reader.readAsDataURL(uploadedImages[0]);
        }
    }

    function displayImagePreview(file, index) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const imageDiv = document.createElement('div');
            imageDiv.className = 'image-item';
            imageDiv.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <div class="image-actions">
                    <button type="button" class="btn-icon set-main" onclick="setMainImage(${index})" title="Đặt làm ảnh chính">
                        <i class="fas fa-star"></i>
                    </button>
                    <button type="button" class="btn-icon remove" onclick="removeImage(${index})" title="Xóa ảnh">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                ${index === 0 ? '<div class="main-badge">Ảnh chính</div>' : ''}
            `;
            imagePreview.appendChild(imageDiv);
        };
        reader.readAsDataURL(file);
    }

    window.setMainImage = function(index) {
        const image = uploadedImages[index];
        uploadedImages.splice(index, 1);
        uploadedImages.unshift(image);

        refreshImagePreview();
        updatePreview();
    };

    window.removeImage = function(index) {
        uploadedImages.splice(index, 1);
        refreshImagePreview();
        if (uploadedImages.length > 0) {
            updatePreview();
        }
    };

    function refreshImagePreview() {
        imagePreview.innerHTML = '';
        uploadedImages.forEach((file, index) => {
            displayImagePreview(file, index);
        });
    }

    function formatPrice(price) {
        if (!price) return '0';
        return parseInt(price).toLocaleString('vi-VN');
    }

    const priceInput = document.getElementById('price');
    if (priceInput) {
        priceInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            if (value) {
                e.target.value = parseInt(value).toLocaleString('vi-VN');
            }
        });

        priceInput.addEventListener('blur', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            e.target.value = value;
        });
    }

    const form = document.querySelector('.property-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!validateStep(currentStep)) {
            return;
        }

        if (uploadedImages.length === 0) {
            showAlert('Vui lòng tải lên ít nhất 1 hình ảnh', 'error');
            return;
        }

        const formData = new FormData(form);

        formData.delete('images[]');

        uploadedImages.forEach((file, index) => {
            formData.append('images[]', file);
        });

        const submitBtn = document.querySelector('.submit-btn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
        submitBtn.disabled = true;

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes('success') || data.includes('thành công')) {
                showAlert('Đăng tin thành công!', 'success');
                setTimeout(() => {
                    window.location.href = '/user/controllers/brokerPropertyController/';
                }, 2000);
            } else {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');
                const errorMessages = doc.querySelectorAll('.error-message');
                
                if (errorMessages.length > 0) {
                    let errors = [];
                    errorMessages.forEach(msg => {
                        errors.push(msg.textContent.trim());
                    });
                    showAlert(errors.join('<br>'), 'error');
                } else {
                    showAlert('Có lỗi xảy ra, vui lòng thử lại', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Có lỗi xảy ra, vui lòng thử lại', 'error');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

    function showAlert(message, type = 'info') {
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());

        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <div class="alert-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
                <span>${message}</span>
            </div>
            <button class="alert-close">&times;</button>
        `;

        document.body.appendChild(alert);
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);

        alert.querySelector('.alert-close').addEventListener('click', () => {
            alert.remove();
        });
    }
});
