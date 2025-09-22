<section class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a>
            <span>/</span>
            <span>Bất động sản</span>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        <div class="content-layout">
            <!-- Sidebar Filter -->
            <aside class="sidebar">
                <form method="GET" action="index.php" id="property-filter-form">
                    <input type="hidden" name="act" value="listProperty">
                    <div class="filter-section">
                        <h3 style="position: unset !important;">Bộ lọc tìm kiếm</h3>

                        <!-- Search Box -->
                        <div class="filter-group">
                            <label for="search">Tìm kiếm</label>
                            <input type="text" id="search" name="search"
                                placeholder="Nhập từ khóa tìm kiếm..."
                                value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                                class="form-input">
                        </div>

                        <div class="filter-group">
                            <label style="font-size: 1.1rem; font-weight:bold; margin: 10px 0">Loại giao dịch</label>
                            <div class="checkbox-group">
                                <label class="checkbox-item">
                                    <input type="radio" name="transactionType" value="rent" <?= ($filters['transactionType'] ?? '') == 'rent' ? 'checked' : '' ?>>
                                    <span>Cho thuê</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="radio" name="transactionType" value="sale" <?= ($filters['transactionType'] ?? '') == 'sale' ? 'checked' : '' ?>>
                                    <span>Bán</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="radio" name="transactionType" value="" <?= empty($filters['transactionType'] ?? '') ? 'checked' : '' ?>>
                                    <span>Tất cả</span>
                                </label>
                            </div>
                        </div>

                        <div class="filter-group">
                            <label style="font-size: 1.1rem; font-weight:bold; margin: 10px 0">Loại bất động sản</label>
                            <select class="form-select" name="propertyType">
                                <option value="">Tất cả</option>
                                <?php if (isset($propertyTypes)): ?>
                                    <?php foreach ($propertyTypes as $type): ?>
                                        <option value="<?= $type['id'] ?>" <?= ($filters['propertyType'] ?? 0) == $type['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($type['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label style="font-size: 1.1rem; font-weight:bold; margin: 10px 0">Khu vực</label>
                            <select class="form-select" name="locationId">
                                <option value="">Chọn khu vực</option>
                                <?php if (isset($locations)): ?>
                                    <?php foreach ($locations as $location): ?>
                                        <option value="<?= $location['id'] ?>" <?= ($filters['locationId'] ?? 0) == $location['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($location['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label style="font-size: 1.1rem; font-weight:bold; margin: 10px 0">Khoảng giá (VNĐ)</label>
                            <div class="price-range">
                                <input type="text" name="minPrice" placeholder="Từ (VNĐ)" class="form-input price-input"
                                    value="<?= ($filters['minPrice'] ?? 0) > 0 ? number_format($filters['minPrice'], 0, ',', '.') : '' ?>"
                                    inputmode="numeric">

                                <span>-</span>

                                <input type="text" name="maxPrice" placeholder="Đến (VNĐ)" class="form-input price-input"
                                    value="<?= ($filters['maxPrice'] ?? 0) > 0 ? number_format($filters['maxPrice'], 0, ',', '.') : '' ?>"
                                    inputmode="numeric">
                            </div>
                        </div>

                        <div class="filter-group">
                            <label style="font-size: 1.1rem; font-weight:bold; margin: 10px 0">Diện tích (m²)</label>
                            <div class="area-range">
                                <input type="number" name="minArea" placeholder="Từ (m²)" class="form-input"
                                    value="<?= ($filters['minArea'] ?? 0) > 0 ? $filters['minArea'] : '' ?>"
                                    min="0" step="1">
                                <span>-</span>
                                <input type="number" name="maxArea" placeholder="Đến (m²)" class="form-input"
                                    value="<?= ($filters['maxArea'] ?? 0) > 0 ? $filters['maxArea'] : '' ?>"
                                    min="0" step="1">
                            </div>
                        </div>

                        <div class="filter-group">
                            <label style="font-size: 1.1rem; font-weight:bold; margin: 10px 0">Số phòng ngủ</label>
                            <select class="form-select" name="bedrooms">
                                <option value="">Tất cả</option>
                                <option value="1" <?= ($filters['bedrooms'] ?? 0) == 1 ? 'selected' : '' ?>>1 phòng</option>
                                <option value="2" <?= ($filters['bedrooms'] ?? 0) == 2 ? 'selected' : '' ?>>2 phòng</option>
                                <option value="3" <?= ($filters['bedrooms'] ?? 0) == 3 ? 'selected' : '' ?>>3 phòng</option>
                                <option value="4" <?= ($filters['bedrooms'] ?? 0) >= 4 ? 'selected' : '' ?>>4+ phòng</option>
                            </select>
                        </div>

                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Tìm kiếm
                            </button>
                            <a style="padding: 6px;" href="index.php?act=listProperty" class="btn btn-outline">
                                <i class="fas fa-times"></i>
                                Xóa bộ lọc
                            </a>
                        </div>
                    </div>
                </form>
            </aside>

            <!-- Main Content Area -->
            <div class="content-area">
                <div class="content-header">
                    <div class="results-info">
                        <?php if (isset($stats) && $stats['total'] > 0): ?>
                            <span>Hiển thị <strong><?= number_format($stats['page_start']) ?>-<?= number_format($stats['page_end']) ?></strong>
                                trong tổng số <strong><?= number_format($stats['total']) ?></strong> bất động sản</span>
                        <?php else: ?>
                            <span>Không tìm thấy bất động sản phù hợp</span>
                        <?php endif; ?>
                    </div>
                    <div class="sort-options">
                        <label>Sắp xếp:</label>
                        <select class="form-select" onchange="updateSort(this.value)">
                            <option value="newest" <?= ($filters['sortBy'] ?? 'newest') == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                            <option value="oldest" <?= ($filters['sortBy'] ?? 'newest') == 'oldest' ? 'selected' : '' ?>>Cũ nhất</option>
                            <option value="price-low" <?= ($filters['sortBy'] ?? 'newest') == 'price-low' ? 'selected' : '' ?>>Giá thấp đến cao</option>
                            <option value="price-high" <?= ($filters['sortBy'] ?? 'newest') == 'price-high' ? 'selected' : '' ?>>Giá cao đến thấp</option>
                            <option value="area-small" <?= ($filters['sortBy'] ?? 'newest') == 'area-small' ? 'selected' : '' ?>>Diện tích nhỏ đến lớn</option>
                            <option value="area-large" <?= ($filters['sortBy'] ?? 'newest') == 'area-large' ? 'selected' : '' ?>>Diện tích lớn đến nhỏ</option>
                        </select>
                    </div>
                </div>

                <div class="properties-grid" id="properties-grid">
                    <?php if (!empty($properties)): ?>
                        <?php foreach ($properties as $item): ?>
                            <div class="property-card" data-property-id="<?= $item['id'] ?>">
                                <div class="property-image">
                                    <?php
                                    $imagePath = !empty($item['mainImage']) ? $item['mainImage'] : './uploads/broker/logo.jpg';
                                    ?>
                                    <img src="<?= htmlspecialchars($imagePath) ?>"
                                        alt="<?= htmlspecialchars($item['title']) ?>"
                                        class="property-img"
                                        loading="lazy"
                                        onerror="this.src='./uploads/broker/logo.jpg'">

                                    <div class="property-badge <?= $item['transactionType'] === 'sale' ? 'sale' : 'rent' ?>">
                                        <?= $item['transactionType'] === 'sale' ? 'Bán' : 'Thuê' ?>
                                    </div>

                                    <button class="save-btn <?= isset($item['saveCount']) && $item['saveCount'] > 0 ? 'saved' : '' ?>"
                                        onclick="toggleSaveProperty(<?= $item['id'] ?>)"
                                        title="Lưu bất động sản">
                                        <i class="<?= isset($item['saveCount']) && $item['saveCount'] > 0 ? 'fas' : 'far' ?> fa-heart"></i>
                                    </button>

                                    <?php if (isset($item['saveCount']) && $item['saveCount'] > 0): ?>
                                        <div class="save-count">
                                            <i class="fas fa-heart"></i>
                                            <?= $item['saveCount'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="property-info">
                                    <h3 class="property-title">
                                        <a href="index.php?act=property&id=<?= $item['id'] ?>"
                                            title="<?= htmlspecialchars($item['title']) ?>">
                                            <?= htmlspecialchars(mb_strlen($item['title']) > 60 ? mb_substr($item['title'], 0, 60) . '...' : $item['title']) ?>
                                        </a>
                                    </h3>

                                    <div class="property-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span><?= htmlspecialchars($item['locationName'] ?? $item['address']) ?></span>
                                    </div>

                                    <div class="property-price">
                                        <span class="price-amount">
                                            <?= number_format($item['price'], 0, ',', '.') ?>
                                        </span>
                                        <span class="price-unit">
                                            <?= $item['transactionType'] === 'sale' ? ' VNĐ' : ' VNĐ/tháng' ?>
                                        </span>
                                    </div>

                                    <div class="property-features">
                                        <div class="feature-item">
                                            <i class="fas fa-expand-arrows-alt"></i>
                                            <span><?= number_format($item['area'] ?? 0, 0, ',', '.') ?> m²</span>
                                        </div>
                                        <?php if (isset($item['bedrooms']) && $item['bedrooms'] > 0): ?>
                                            <div class="feature-item">
                                                <i class="fas fa-bed"></i>
                                                <span><?= $item['bedrooms'] ?> PN</span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($item['bathrooms']) && $item['bathrooms'] > 0): ?>
                                            <div class="feature-item">
                                                <i class="fas fa-bath"></i>
                                                <span><?= $item['bathrooms'] ?> WC</span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="feature-item">
                                            <i class="fas fa-home"></i>
                                            <span><?= htmlspecialchars($item['propertyType'] ?? 'N/A') ?></span>
                                        </div>
                                    </div>

                                    <?php if (!empty($item['brokerName'])): ?>
                                        <div class="property-agent">
                                            <div class="agent-info">
                                                <div class="agent-avatar">
                                                    <?php if (!empty($item['brokerAvatar'])): ?>
                                                        <img src="<?= htmlspecialchars($item['brokerAvatar']) ?>"
                                                            alt="<?= htmlspecialchars($item['brokerName']) ?>"
                                                            onerror="this.src='../assets/images/default-avatar.png'">
                                                    <?php else: ?>
                                                        <div class="avatar-placeholder">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="agent-details">
                                                    <span class="agent-name"><?= htmlspecialchars($item['brokerName']) ?></span>
                                                    <?php if (!empty($item['brokerPhone'])): ?>
                                                        <span class="agent-phone"><?= htmlspecialchars($item['brokerPhone']) ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="agent-actions">
                                                <a href="index.php?act=broker&id=<?= $item['brokerId'] ?? '' ?>"
                                                    class="btn btn-sm btn-outline" title="Xem hồ sơ">
                                                 
                                                            <i class="fas fa-user" style="width: 4px"></i>
                                                 
                                                </a>
                                                <?php if (!empty($item['brokerPhone'])): ?>
                                                    <a href="tel:<?= $item['brokerPhone'] ?>"
                                                        class="btn btn-sm btn-primary" title="Gọi điện">
                                                        <i class="fas fa-phone"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="property-meta">
                                        <span class="posted-date" title="Ngày đăng: <?= date('d/m/Y H:i', strtotime($item['createdAt'])) ?>">
                                            <i class="fas fa-calendar-alt"></i>
                                            <?php
                                            if (function_exists('timeAgo')) {
                                                echo timeAgo($item['createdAt']);
                                            } else {
                                                echo date('d/m/Y', strtotime($item['createdAt']));
                                            }
                                            ?>
                                        </span>
                                        <?php if (!empty($item['updatedAt']) && $item['updatedAt'] !== $item['createdAt']): ?>
                                            <span class="updated-date" title="Cập nhật: <?= date('d/m/Y H:i', strtotime($item['updatedAt'])) ?>">
                                                <i class="fas fa-sync-alt"></i>
                                                Cập nhật
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-results">
                            <div class="no-results-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3>Không tìm thấy bất động sản phù hợp</h3>
                            <p>Hãy thử điều chỉnh bộ lọc tìm kiếm hoặc xem tất cả bất động sản có sẵn.</p>
                            <div class="no-results-actions">
                                <a href="index.php?act=listProperty" class="btn btn-primary">Xem tất cả</a>
                                <button type="button" class="btn btn-outline" onclick="clearFilters()">Xóa bộ lọc</button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($properties)): ?>
                    <?php
                    $totalPages = isset($total) ? ceil($total / $limit) : 1;
                    $currentPage = isset($page) ? $page : 1;
                    ?>
                    <div class="pagination">
                        <?php if ($currentPage > 1): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage - 1])) ?>" class="page-btn">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
                                class="page-btn<?= $i == $currentPage ? ' active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage + 1])) ?>" class="page-btn">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
    function updateSort(sortBy) {
        const url = new URL(window.location);
        url.searchParams.set('sortBy', sortBy);
        window.location.href = url.href;
    }

    // Price range validation
    document.addEventListener('DOMContentLoaded', function() {
        const minPriceInput = document.querySelector('input[name="minPrice"]');
        const maxPriceInput = document.querySelector('input[name="maxPrice"]');
        const minAreaInput = document.querySelector('input[name="minArea"]');
        const maxAreaInput = document.querySelector('input[name="maxArea"]');

        // Price range validation and auto-fill
        function validatePriceRange() {
            const minPrice = parseFloat(minPriceInput.value) || 0;
            const maxPrice = parseFloat(maxPriceInput.value) || 0;

            if (minPrice > 0 && maxPrice > 0 && minPrice > maxPrice) {
                maxPriceInput.setCustomValidity('Giá đến phải lớn hơn giá từ');
                maxPriceInput.style.borderColor = '#e74c3c';
                return false;
            } else {
                maxPriceInput.setCustomValidity('');
                maxPriceInput.style.borderColor = '#e1e5e9';
                return true;
            }
        }

        // Auto-fill and set min for price range
        function handleMinPriceChange() {
            const minPrice = parseFloat(minPriceInput.value) || 0;

            if (minPrice > 0) {
                // Set minimum value for max price input
                maxPriceInput.setAttribute('min', minPrice);

                // Auto-fill max price if it's empty or less than min price
                const currentMaxPrice = parseFloat(maxPriceInput.value) || 0;
                if (currentMaxPrice === 0 || currentMaxPrice < minPrice) {
                    // Auto-suggest a reasonable max price (double the min price or add common increments)
                    let suggestedMax;
                    if (minPrice < 1000000) { // < 1 triệu
                        suggestedMax = minPrice + 500000; // +500k
                    } else if (minPrice < 10000000) { // < 10 triệu
                        suggestedMax = minPrice + 5000000; // +5 triệu
                    } else if (minPrice < 50000000) { // < 50 triệu
                        suggestedMax = minPrice + 20000000; // +20 triệu
                    } else {
                        suggestedMax = minPrice * 2; // Double for high prices
                    }
                    maxPriceInput.value = suggestedMax;

                    // Add visual feedback
                    maxPriceInput.style.backgroundColor = '#e8f5e8';
                    maxPriceInput.style.borderColor = '#27ae60';

                    // Remove visual feedback after 2 seconds
                    setTimeout(() => {
                        maxPriceInput.style.backgroundColor = '#fff';
                        maxPriceInput.style.borderColor = '#e1e5e9';
                    }, 2000);
                }
            } else {
                // Remove min constraint if no min price
                maxPriceInput.removeAttribute('min');
            }

            validatePriceRange();
        }

        // Auto-fill and set min for area range
        function handleMinAreaChange() {
            const minArea = parseFloat(minAreaInput.value) || 0;

            if (minArea > 0) {
                // Set minimum value for max area input
                maxAreaInput.setAttribute('min', minArea);

                // Auto-fill max area if it's empty or less than min area
                const currentMaxArea = parseFloat(maxAreaInput.value) || 0;
                if (currentMaxArea === 0 || currentMaxArea < minArea) {
                    // Auto-suggest a reasonable max area
                    let suggestedMax;
                    if (minArea < 50) { // < 50m2
                        suggestedMax = minArea + 20; // +20m2
                    } else if (minArea < 100) { // < 100m2
                        suggestedMax = minArea + 50; // +50m2
                    } else if (minArea < 200) { // < 200m2
                        suggestedMax = minArea + 100; // +100m2
                    } else {
                        suggestedMax = minArea + 200; // +200m2 for large areas
                    }
                    maxAreaInput.value = suggestedMax;

                    // Add visual feedback
                    maxAreaInput.style.backgroundColor = '#e8f5e8';
                    maxAreaInput.style.borderColor = '#27ae60';

                    // Remove visual feedback after 2 seconds
                    setTimeout(() => {
                        maxAreaInput.style.backgroundColor = '#fff';
                        maxAreaInput.style.borderColor = '#e1e5e9';
                    }, 2000);
                }
            } else {
                // Remove min constraint if no min area
                maxAreaInput.removeAttribute('min');
            }

            validateAreaRange();
        }

        // Validate area range
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

        // Add event listeners
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

        // Form submission validation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const priceValid = validatePriceRange();
                const areaValid = validateAreaRange();

                if (!priceValid || !areaValid) {
                    e.preventDefault();
                    alert('Vui lòng kiểm tra lại các khoảng giá trị nhập vào!');
                }
            });
        }

        // Format number inputs
        function formatNumberInput(input) {
            input.addEventListener('blur', function() {
                const value = parseFloat(this.value);
                if (!isNaN(value) && value > 0) {
                    this.value = Math.round(value).toString();
                }
            });
        }

        [minPriceInput, maxPriceInput, minAreaInput, maxAreaInput].forEach(input => {
            if (input) formatNumberInput(input);
        });
    });

    // Additional JavaScript for enhanced functionality
    document.addEventListener('DOMContentLoaded', function() {
        initializePriceFormatter();
        initializeFilterForm();
        initializeSaveProperty();

        function initializePriceFormatter() {
            const priceInputs = document.querySelectorAll('.price-input');
            priceInputs.forEach(input => {
                input.addEventListener('input', function() {
                    let value = this.value.replace(/[^\d]/g, '');
                    if (value) {
                        value = parseInt(value).toLocaleString('vi-VN');
                        this.value = value;
                    }
                });
            });
        }

        function initializeFilterForm() {
            const filterForm = document.getElementById('property-filter-form');
            const searchInput = document.querySelector('input[name="search"]');

            // Real-time search with debounce
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

            // Auto-submit on filter change
            const filterElements = filterForm.querySelectorAll('select, input[type="radio"]');
            filterElements.forEach(element => {
                element.addEventListener('change', function() {
                    if (this.type === 'radio' || this.tagName === 'SELECT') {
                        setTimeout(() => filterForm.submit(), 100);
                    }
                });
            });
        }

        function initializeSaveProperty() {
            window.toggleSaveProperty = function(propertyId) {
                const saveBtn = document.querySelector(`[data-property-id="${propertyId}"] .save-btn`);
                const icon = saveBtn.querySelector('i');

                // Toggle UI immediately
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

                // Send AJAX request (implement backend endpoint)
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
                    })
                    .catch(error => console.error('Error:', error));
            };
        }
    });

    // Sort and pagination functions
    function updateSort(sortValue) {
        const url = new URL(window.location);
        url.searchParams.set('sortBy', sortValue);
        window.location.href = url.toString();
    }

    function goToPage(page) {
        const url = new URL(window.location);
        url.searchParams.set('page', page);
        window.location.href = url.toString();
    }
</script>