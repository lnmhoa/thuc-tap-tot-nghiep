<div class="property-list">
    <section class="page-header">
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a>
            <span>/</span>
            <span>Bất động sản</span>
        </div>
</section>

<main class="main-content">
    <div class="container">
        <div class="content-layout">
            <aside class="sidebar">
                <form method="GET" action="index.php" id="property-filter-form">
                    <input type="hidden" name="act" value="listProperty">
                    <div class="filter-section">
                        <h3 style="position: unset !important;">Bộ lọc tìm kiếm</h3>
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
                                            <?= number_format($item['price'], 0, ',', '.') ?> <?= $item['transactionType'] === 'sale' ? ' VNĐ' : ' VNĐ/tháng' ?>
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
                                                            alt="<?= htmlspecialchars($item['brokerName']) ?>">
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
                                                    class="btn btn-outline" style="padding: 0.475rem 1rem;" title="Xem hồ sơ">
                                                 
                                                            <i class="fas fa-user"></i>
                                                 
                                                </a>
                                                <?php if (!empty($item['brokerPhone'])): ?>
                                                    <a href="tel:<?= $item['brokerPhone'] ?>"
                                                        class="btn btn-sm btn-primary" style="padding: 0.475rem 1rem;"  title="Gọi điện">
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
                                        <span class="updated-date" title="Lượt xem: <?= $item['views'] ?>">
                                            <i class="fas fa-eye"></i>
                                                <?= $item['views'] ?> lượt xem
                                        </span>
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
    </div>

<script src="./views/js/listProperty.js"></script>