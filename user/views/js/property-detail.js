// Property Detail and Global JavaScript
document.addEventListener('DOMContentLoaded', function() {
    
    // --- Image gallery functionality ---
    const mainImage = document.querySelector('.main-image img');
    const galleryImages = document.querySelectorAll('.image-gallery img');
    
    if (mainImage && galleryImages.length > 0) {
        galleryImages.forEach(img => {
            img.addEventListener('click', function() {
                const tempSrc = mainImage.src;
                mainImage.src = this.src;
                this.src = tempSrc;
            });
        });
    }

    // --- Contact broker button ---
    const contactBtn = document.querySelector('.contact-btn');
    if (contactBtn) {
        contactBtn.addEventListener('click', function() {
            const brokerPhone = document.querySelector('.broker-contact .fas.fa-phone')?.parentElement?.textContent?.trim();
            if (brokerPhone) {
                window.open(`tel:${brokerPhone.replace(/[^\d+]/g, '')}`, '_self');
            } else {
                alert('Thông tin liên hệ không khả dụng');
            }
        });
    }

    // --- Save property functionality ---
    const saveBtn = document.querySelector('.save-property');
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            const isLiked = icon.classList.contains('fas');
            
            if (isLiked) {
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.innerHTML = '<i class="far fa-heart"></i> Lưu tin';
            } else {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.innerHTML = '<i class="fas fa-heart"></i> Đã lưu';
            }
            
            // Add AJAX call here
        });
    }

    // --- Share property functionality ---
    const shareBtn = document.querySelector('.share-property');
    if (shareBtn) {
        shareBtn.addEventListener('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: document.querySelector('.property-header h1')?.textContent || 'Bất động sản',
                    text: 'Xem bất động sản này',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Đã sao chép link vào clipboard!');
                }).catch(() => {
                    const textArea = document.createElement('textarea');
                    textArea.value = window.location.href;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    alert('Đã sao chép link vào clipboard!');
                });
            }
        });
    }

    // --- Smooth scroll for internal links ---
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // --- Back to top functionality ---
    const backToTop = document.createElement('button');
    backToTop.innerHTML = '<i class="fas fa-chevron-up"></i>';
    backToTop.className = 'back-to-top';
    backToTop.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        z-index: 1000;
        transition: all 0.3s;
    `;
    
    document.body.appendChild(backToTop);
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            backToTop.style.display = 'block';
        } else {
            backToTop.style.display = 'none';
        }
    });
    
    backToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // --- Image lazy loading for related properties ---
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            }
        });
    }, observerOptions);

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });

    // --- Code for number formatting and form handling ---
    const minPriceInput = document.querySelector('input[name="minPrice"]');
    const maxPriceInput = document.querySelector('input[name="maxPrice"]');
    const minAreaInput = document.querySelector('input[name="minArea"]');
    const maxAreaInput = document.querySelector('input[name="maxArea"]');
    
    function formatNumber(value) {
        const cleanValue = value.toString().replace(/[^0-9]/g, '');
        if (cleanValue === '') return '';
        return new Intl.NumberFormat('vi-VN').format(cleanValue);
    }

    function cleanNumber(value) {
        return value.toString().replace(/[^0-9]/g, '');
    }

    function handleInputFormatting(event) {
        const input = event.target;
        const cleanValue = cleanNumber(input.value);
        input.value = formatNumber(cleanValue);
    }

    if (minPriceInput) minPriceInput.addEventListener('input', handleInputFormatting);
    if (maxPriceInput) maxPriceInput.addEventListener('input', handleInputFormatting);
    
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            minPriceInput.value = cleanNumber(minPriceInput.value);
            maxPriceInput.value = cleanNumber(maxPriceInput.value);
            // The area inputs are already type="number", so no need to clean them
        });
    }

    // --- Existing Price and Area Range Validation ---
    function validatePriceRange() {
        // Your existing validation logic
    }
    
    function handleMinPriceChange() {
        // Your existing auto-fill and min/max logic
    }
    
    // Add event listeners for your existing functions
    if (minPriceInput && maxPriceInput) {
        minPriceInput.addEventListener('input', handleMinPriceChange);
        minPriceInput.addEventListener('blur', handleMinPriceChange);
        maxPriceInput.addEventListener('input', validatePriceRange);
        maxPriceInput.addEventListener('blur', validatePriceRange);
    }
    
    if (minAreaInput && maxAreaInput) {
        minAreaInput.addEventListener('input', handleMinAreaChange);
        minAreaInput.addEventListener('blur', handleMinAreaChange);
        maxAreaInput.addEventListener('input', validateAreaRange);
        maxAreaInput.addEventListener('blur', validateAreaRange);
    }
    
    // Your existing area validation and auto-fill functions (handleMinAreaChange, validateAreaRange)
    function handleMinAreaChange() {
        const minArea = parseFloat(minAreaInput.value) || 0;
        if (minArea > 0) {
            maxAreaInput.setAttribute('min', minArea);
            const currentMaxArea = parseFloat(maxAreaInput.value) || 0;
            if (currentMaxArea === 0 || currentMaxArea < minArea) {
                let suggestedMax;
                if (minArea < 50) { suggestedMax = minArea + 20; } 
                else if (minArea < 100) { suggestedMax = minArea + 50; } 
                else if (minArea < 200) { suggestedMax = minArea + 100; } 
                else { suggestedMax = minArea + 200; }
                maxAreaInput.value = suggestedMax;
                maxAreaInput.style.backgroundColor = '#e8f5e8';
                maxAreaInput.style.borderColor = '#27ae60';
                setTimeout(() => {
                    maxAreaInput.style.backgroundColor = '#fff';
                    maxAreaInput.style.borderColor = '#e1e5e9';
                }, 2000);
            }
        } else {
            maxAreaInput.removeAttribute('min');
        }
        validateAreaRange();
    }
    
    function validateAreaRange() {
        const minArea = parseFloat(minAreaInput.value) || 0;
        const maxArea = parseFloat(maxAreaInput.value) || 0;
        if (minArea > 0 && maxArea > 0 && minArea > maxArea) {
            maxAreaInput.setCustomValidity('Diện tích đến phải lớn hơn diện tích từ');
            maxAreaInput.style.borderColor = '#e74c3c';
            return false;
        } else {
            maxAreaInput.setCustomValidity('');
            maxAreaInput.style.borderColor = '#e1e5e9';
            return true;
        }
    }
});

// --- Property comparison functionality (outside DOMContentLoaded as it's a separate component) ---
let comparisonList = JSON.parse(localStorage.getItem('propertyComparison') || '[]');

function addToComparison(propertyId) {
    if (comparisonList.length >= 3) {
        alert('Bạn chỉ có thể so sánh tối đa 3 bất động sản');
        return;
    }
    
    if (!comparisonList.includes(propertyId)) {
        comparisonList.push(propertyId);
        localStorage.setItem('propertyComparison', JSON.stringify(comparisonList));
        updateComparisonUI();
    }
}

function removeFromComparison(propertyId) {
    comparisonList = comparisonList.filter(id => id !== propertyId);
    localStorage.setItem('propertyComparison', JSON.stringify(comparisonList));
    updateComparisonUI();
}

function updateComparisonUI() {
    const compareBtn = document.querySelector('.compare-properties');
    if (compareBtn) {
        if (comparisonList.length > 0) {
            compareBtn.style.display = 'block';
            compareBtn.textContent = `So sánh (${comparisonList.length})`;
        } else {
            compareBtn.style.display = 'none';
        }
    }
}