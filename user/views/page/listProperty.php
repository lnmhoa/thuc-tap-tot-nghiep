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
                    <form method="POST" action="index.php?act=listProperty" id="property-filter-form">
                        <div class="filter-section">
                            <h3 style="position: unset !important;">Bộ lọc tìm kiếm</h3>
                            <div class="filter-group">
                                <label for="search">Tìm kiếm</label>
                                <input type="text" id="search" name="search-property"
                                    placeholder="Nhập từ khóa tìm kiếm..."
                                    value="<?= htmlspecialchars($_SESSION['search-property'] ?? '') ?>"
                                    class="form-input">
                            </div>

                            <div class="filter-group">
                                <label style="font-size: 1.1rem; font-weight:bold; margin: 10px 0">Loại giao dịch</label>
                                <div class="checkbox-group">
                                    <label class="checkbox-item">
                                        <input type="radio" name="filter-transactionType" value="rent" <?= ($_SESSION['filter-transactionType'] ?? '') == 'rent' ? 'checked' : '' ?>>
                                        <span>Cho thuê</span>
                                    </label>
                                    <label class="checkbox-item">
                                        <input type="radio" name="filter-transactionType" value="sale" <?= ($_SESSION['filter-transactionType'] ?? '') == 'sale' ? 'checked' : '' ?>>
                                        <span>Bán</span>
                                    </label>
                                    <label class="checkbox-item">
                                        <input type="radio" name="filter-transactionType" value="" <?= empty($_SESSION['filter-transactionType'] ?? '') ? 'checked' : '' ?>>
                                        <span>Tất cả</span>
                                    </label>
                                </div>
                            </div>

                            <div class="filter-group">
                                <label style="font-size: 1.1rem; font-weight:bold; margin: 10px 0">Loại bất động sản</label>
                                <select class="form-select" name="filter-type">
                                    <option value="">Tất cả</option>
                                    <?php if (isset($propertyTypes)): ?>
                                        <?php foreach ($propertyTypes as $type): ?>
                                            <option value="<?= $type['id'] ?>" <?= ($_SESSION['filter-type'] ?? 0) == $type['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($type['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="filter-group">
                                <label style="font-size: 1.1rem; font-weight:bold; margin: 10px 0">Khu vực</label>
                                <select class="form-select" name="filter-location">
                                    <option value="">Chọn khu vực</option>
                                    <?php if (isset($locations)): ?>
                                        <?php foreach ($locations as $location): ?>
                                            <option value="<?= $location['id'] ?>" <?= ($_SESSION['filter-location'] ?? 0) == $location['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($location['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="filter-group">
                                <label style="font-size: 1.1rem; font-weight:bold; margin: 10px 0">Khoảng giá (VNĐ)</label>
                                <div class="price-range">
                                    <input type="text" name="filter-minPrice" placeholder="Từ (VNĐ)" class="form-input price-input"
                                        value="<?= ($_SESSION['filter-minPrice'] ?? 0) > 0 ? number_format($_SESSION['filter-minPrice'], 0, ',', '.') : '' ?>"
                                        inputmode="numeric">
                                    <span>-</span>
                                    <input type="text" name="filter-maxPrice" placeholder="Đến (VNĐ)" class="form-input price-input"
                                        value="<?= ($_SESSION['filter-maxPrice'] ?? 0) > 0 ? number_format($_SESSION['filter-maxPrice'], 0, ',', '.') : '' ?>"
                                        inputmode="numeric">
                                </div>
                            </div>

                            <div class="filter-group">
                                <label style="font-size: 1.1rem; font-weight:bold; margin: 10px 0">Diện tích (m²)</label>
                                <div class="area-range">
                                    <input type="number" name="filter-minArea" placeholder="Từ (m²)" class="form-input"
                                        value="<?= ($_SESSION['filter-minArea'] ?? 0) > 0 ? $_SESSION['filter-minArea'] : '' ?>"
                                        min="0" step="1">
                                    <span>-</span>
                                    <input type="number" name="filter-maxArea" placeholder="Đến (m²)" class="form-input"
                                        value="<?= ($_SESSION['filter-maxArea'] ?? 0) > 0 ? $_SESSION['filter-maxArea'] : '' ?>"
                                        min="0" step="1">
                                </div>
                            </div>

                            <div class="filter-group">
                                <label style="font-size: 1.1rem; font-weight:bold; margin: 10px 0">Số phòng ngủ</label>
                                <select class="form-select" name="filter-bedrooms">
                                    <option value="">Tất cả</option>
                                    <option value="1" <?= ($_SESSION['filter-bedrooms'] ?? 0) == 1 ? 'selected' : '' ?>>1 phòng</option>
                                    <option value="2" <?= ($_SESSION['filter-bedrooms'] ?? 0) == 2 ? 'selected' : '' ?>>2 phòng</option>
                                    <option value="3" <?= ($_SESSION['filter-bedrooms'] ?? 0) == 3 ? 'selected' : '' ?>>3 phòng</option>
                                    <option value="4" <?= ($_SESSION['filter-bedrooms'] ?? 0) >= 4 ? 'selected' : '' ?>>4+ phòng</option>
                                </select>
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                    Tìm kiếm
                                </button>
                                <button type="submit" name="clear-filter" class="btn btn-outline" style="padding: 14px;">
                                    <i class="fas fa-times"></i>
                                    Xóa bộ lọc
                                </button>
                            </div>
                        </div>
                    </form>
                </aside>

                <div class="content-area">
                    <div class="content-header">
                        <div class="results-info">
                            <span>Tìm thấy <strong><?= $totalRecords ?? 0 ?></strong> bất động sản</span>
                        </div>
                        <div class="sort-options">
                            <label>Sắp xếp:</label>
                            <form method="POST" action="index.php?act=listProperty">
                                <select class="form-select" name="sort-property" onchange="this.form.submit()">
                                    <option value="newest" <?= ($_SESSION['sort-property'] ?? 'newest') == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                                    <option value="oldest" <?= ($_SESSION['sort-property'] ?? 'newest') == 'oldest' ? 'selected' : '' ?>>Cũ nhất</option>
                                    <option value="price-low" <?= ($_SESSION['sort-property'] ?? 'newest') == 'price-low' ? 'selected' : '' ?>>Giá thấp đến cao</option>
                                    <option value="price-high" <?= ($_SESSION['sort-property'] ?? 'newest') == 'price-high' ? 'selected' : '' ?>>Giá cao đến thấp</option>
                                    <option value="area-small" <?= ($_SESSION['sort-property'] ?? 'newest') == 'area-small' ? 'selected' : '' ?>>Diện tích nhỏ đến lớn</option>
                                    <option value="area-large" <?= ($_SESSION['sort-property'] ?? 'newest') == 'area-large' ? 'selected' : '' ?>>Diện tích lớn đến nhỏ</option>
                                </select>
                            </form>
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
                                            >

                                        <div class="property-badge <?= $item['transactionType'] === 'sale' ? 'sale' : 'rent' ?>">
                                            <?= $item['transactionType'] === 'sale' ? 'Bán' : 'Thuê' ?>
                                        </div>
                                        <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="property_id" value="<?= $item['id'] ?>">
                                                <button type="submit" name="save-property" class="save-btn <?= $item['isSaved'] ? 'saved' : '' ?>" title="<?= $item['isSaved'] ? 'Đã lưu - Click để bỏ lưu' : 'Lưu tin' ?>">
                                                    <i class="<?= $item['isSaved'] ? 'fas fa-heart' : 'far fa-heart' ?>"></i>
                                                </button>
                                            </form>
                                        <?php } ?>
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
                                                        <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                                            <span class="agent-phone"><?= htmlspecialchars($item['brokerPhone']) ?></span>
                                                        <?php }else{ ?>
                                                        <span class="agent-phone"><?= substr($item['brokerPhone'], 0 , 7) ?>***</span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="agent-actions">
                                                    <a href="index.php?act=broker&id=<?= $item['brokerId'] ?? '' ?>"
                                                        class="btn btn-outline" style="padding: 0.475rem 1rem;" title="Xem hồ sơ">
                                                        <i class="fas fa-user"></i>
                                                    </a>
                                                    <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                                        <a href="tel:<?= $item['brokerPhone'] ?>"
                                                            class="btn btn-sm btn-primary" style="padding: 0.475rem 1rem;" title="Gọi điện">
                                                            <i class="fas fa-phone"></i>
                                                        </a>
                                                    <?php }else{
                                                        echo '<button disabled  class="btn btn-sm btn-primary" title="Vui lòng đăng nhập để liên hệ" style="padding: 0.475rem 1rem; background-color: #ccc;" title="Đăng nhập để gọi điện">
                                                                <i class="fas fa-phone"></i>
                                                            </button>';
                                                    } ?>
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
                                    <button type="submit" name="clear-filter" form="property-filter-form" class="btn btn-outline">Xóa bộ lọc</button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($properties)): ?>
                        <?php
                        $totalPages = isset($totalPage) ? $totalPage : 1;
                        $currentPage = isset($currentPage) ? $currentPage : 1;
                        ?>
                        <div class="pagination">
                            <?php if ($currentPage > 1): ?>
                                <a href="index.php?act=listProperty&page=<?= $currentPage - 1 ?>" class="page-btn">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            <?php endif; ?>

                            <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                <a href="index.php?act=listProperty&page=<?= $i ?>" class="page-btn<?= $i == $currentPage ? ' active' : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <a href="index.php?act=listProperty&page=<?= $currentPage + 1 ?>" class="page-btn">
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