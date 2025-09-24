function toggleSaveProperty(propertyId) {
    const saveBtn = document.querySelector(`[data-property-id="${propertyId}"] .save-btn`);
    const icon = saveBtn.querySelector('i');
    const isSaved = icon.classList.contains('fas');

    if (isSaved) {
        icon.classList.remove('fas');
        icon.classList.add('far');
        saveBtn.classList.remove('saved');
    } else {
        icon.classList.remove('far');
        icon.classList.add('fas');
        saveBtn.classList.add('saved');
    }

    fetch('index.php?act=toggleSaveProperty', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            propertyId: propertyId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success && data.message === 'login_required') {
            window.location.href = 'index.php?act=login';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const minPriceInput = document.querySelector('input[name="filter-minPrice"]');
    const maxPriceInput = document.querySelector('input[name="filter-maxPrice"]');

    function formatNumber(input) {
        let value = input.value.replace(/\./g, '');
        if (value) {
            value = parseInt(value, 10).toLocaleString('vi-VN');
            input.value = value;
        }
    }

    if (minPriceInput) {
        minPriceInput.addEventListener('input', () => formatNumber(minPriceInput));
        minPriceInput.addEventListener('blur', () => formatNumber(minPriceInput));
    }
    if (maxPriceInput) {
        maxPriceInput.addEventListener('input', () => formatNumber(maxPriceInput));
        maxPriceInput.addEventListener('blur', () => formatNumber(maxPriceInput));
    }

    const filterForm = document.getElementById('property-filter-form');
    if (filterForm) {
        const searchInput = filterForm.querySelector('input[name="search-property"]');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (this.value.length >= 3 || this.value.length === 0) {
                        filterForm.submit();
                    }
                }, 500);
            });
        }

        const filterElements = filterForm.querySelectorAll('select, input[type="radio"]');
        filterElements.forEach(element => {
            element.addEventListener('change', function() {
                setTimeout(() => filterForm.submit(), 100);
            });
        });
    }
});