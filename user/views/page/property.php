<section class="page-header">
    <div class="container">
        <h1>Danh sách bất động sản</h1>
        <div class="breadcrumb">
            <a href="http://localhost/luan_van_tot_nghiep/user">Trang chủ</a>
            <span>/</span>
            <span>Bất động sản</span>
        </div>
    </div>
</section>

<main class="main-content">
    <div class="container">
        <div class="content-layout">
            <aside class="sidebar">
                <div class="filter-section">
                    <h3>Bộ lọc tìm kiếm</h3>
                    <form action="" method="GET">
                        <div class="filter-group">
                            <label>Loại giao dịch</label>
                            <div class="checkbox-group">
                                <label class="checkbox-item">
                                    <input type="checkbox" name="transactionType[]" value="rent" <?= isset($_GET['transactionType']) && in_array('rent', (array)$_GET['transactionType']) ? 'checked' : '' ?>>
                                    <span>Cho thuê</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="transactionType[]" value="sale" <?= isset($_GET['transactionType']) && in_array('sale', (array)$_GET['transactionType']) ? 'checked' : '' ?>>
                                    <span>Bán</span>
                                </label>
                            </div>
                        </div>

                        <div class="filter-group">
                            <label>Loại bất động sản</label>
                            <select class="form-select" name="propertyType">
                                <option value="">Tất cả</option>
                                <?php if (isset($propertyTypes)): ?>
                                    <?php foreach ($propertyTypes as $type): ?>
                                        <option value="<?= $type['id'] ?>" <?= isset($_GET['propertyType']) && $_GET['propertyType'] == $type['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($type['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Khu vực</label>
                            <select class="form-select" name="locationId">
                                <option value="">Chọn khu vực</option>
                                <?php if (isset($locations)): ?>
                                    <?php foreach ($locations as $location): ?>
                                        <option value="<?= $location['id'] ?>" <?= isset($_GET['locationId']) && $_GET['locationId'] == $location['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($location['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Khoảng giá</label>
                            <div class="price-range">
                                <input type="number" name="minPrice" placeholder="Từ" class="form-input" value="<?= isset($_GET['minPrice']) ? htmlspecialchars($_GET['minPrice']) : '' ?>">
                                <span>-</span>
                                <input type="number" name="maxPrice" placeholder="Đến" class="form-input" value="<?= isset($_GET['maxPrice']) ? htmlspecialchars($_GET['maxPrice']) : '' ?>">
                            </div>
                        </div>

                        <div class="filter-group">
                            <label>Diện tích (m²)</label>
                            <div class="area-range">
                                <input type="number" name="minArea" placeholder="Từ" class="form-input" value="<?= isset($_GET['minArea']) ? htmlspecialchars($_GET['minArea']) : '' ?>">
                                <span>-</span>
                                <input type="number" name="maxArea" placeholder="Đến" class="form-input" value="<?= isset($_GET['maxArea']) ? htmlspecialchars($_GET['maxArea']) : '' ?>">
                            </div>
                        </div>

                        <div class="filter-group">
                            <label>Số phòng ngủ</label>
                            <div class="checkbox-group">
                                <label class="checkbox-item">
                                    <input type="checkbox" name="bedrooms[]" value="1" <?= isset($_GET['bedrooms']) && in_array('1', (array)$_GET['bedrooms']) ? 'checked' : '' ?>>
                                    <span>1 phòng</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="bedrooms[]" value="2" <?= isset($_GET['bedrooms']) && in_array('2', (array)$_GET['bedrooms']) ? 'checked' : '' ?>>
                                    <span>2 phòng</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="bedrooms[]" value="3" <?= isset($_GET['bedrooms']) && in_array('3', (array)$_GET['bedrooms']) ? 'checked' : '' ?>>
                                    <span>3 phòng</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="bedrooms[]" value="4" <?= isset($_GET['bedrooms']) && in_array('4', (array)$_GET['bedrooms']) ? 'checked' : '' ?>>
                                    <span>4+ phòng</span>
                                </label>
                            </div>
                        </div>

                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            <button type="button" class="btn btn-outline" onclick="clearFilters()">Xóa bộ lọc</button>
                        </div>
                    </form>
                </div>
            </aside>

            <div class="content-area">
                <div class="content-header">
                    <div class="results-info">
                        <span>Tìm thấy <strong><?= isset($total) ? $total : 0 ?></strong> bất động sản</span>
                    </div>
                    <div class="sort-options">
                        <label>Sắp xếp:</label>
                        <select class="form-select" onchange="updateSort(this.value)">
                            <option value="newest" <?= isset($_GET['sortBy']) && $_GET['sortBy'] == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                            <option value="price-low" <?= isset($_GET['sortBy']) && $_GET['sortBy'] == 'price-low' ? 'selected' : '' ?>>Giá thấp đến cao</option>
                            <option value="price-high" <?= isset($_GET['sortBy']) && $_GET['sortBy'] == 'price-high' ? 'selected' : '' ?>>Giá cao đến thấp</option>
                            <option value="area-small" <?= isset($_GET['sortBy']) && $_GET['sortBy'] == 'area-small' ? 'selected' : '' ?>>Diện tích nhỏ đến lớn</option>
                            <option value="area-large" <?= isset($_GET['sortBy']) && $_GET['sortBy'] == 'area-large' ? 'selected' : '' ?>>Diện tích lớn đến nhỏ</option>
                        </select>
                    </div>
                </div>

                <div class="properties-grid">
                    <?php if (!empty($properties)): ?>
                        <?php foreach ($properties as $item): ?>
                            <div class="property-card">
                                <div class="property-image">
                                    <img src="./<?= htmlspecialchars($item['mainImage']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" style="height:200px;width:300px;object-fit:cover;">
                                    <div class="property-badge<?= $item['transactionType']==='sale' ? ' sale' : '' ?>">
                                        <?= $item['transactionType']==='sale' ? 'Bán' : 'Cho thuê' ?>
                                    </div>
                                    <a href="#" class="save-btn" onclick="toggleSaveProperty(<?= $item['id'] ?>)"><i class="far fa-heart"></i></a>
                                </div>
                                <div class="property-info">
                                    <h3><a href="/user/controllers/propertyController/propertyDetail.php?id=<?= $item['id'] ?>">
                                        <?= htmlspecialchars($item['title']) ?>
                                    </a></h3>
                                    <p class="location"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($item['locationName']) ?></p>
                                    <p class="price">
                                        <?= number_format($item['price'], 0, ',', '.') ?><?= $item['transactionType']==='sale' ? ' VNĐ' : ' VNĐ/tháng' ?>
                                    </p>
                                    <div class="property-features">
                                        <span><?= $item['area'] ?> m²</span> |
                                        <span><?= $item['bedrooms'] ?> PN</span> |
                                        <span><?= $item['bathrooms'] ?> WC</span>
                                    </div>
                                    <div class="property-agent">
                                        <img src="/<?= htmlspecialchars($item['brokerAvatar']) ?>" alt="<?= htmlspecialchars($item['brokerName']) ?>" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                                        <span><?= htmlspecialchars($item['brokerName']) ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Không tìm thấy bất động sản phù hợp.</p>
                    <?php endif; ?>
                </div>

                <?php
                $totalPages = isset($total) ? ceil($total / $limit) : 1;
                $currentPage = isset($page) ? $page : 1;
                $currentQuery = $_GET;
                ?>
                <div class="pagination">
                    <button class="page-btn" <?= $currentPage <= 1 ? 'disabled' : '' ?> onclick="window.location='?<?= http_build_query(array_merge($currentQuery, ['page' => $currentPage-1])) ?>'">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <button class="page-btn<?= $i == $currentPage ? ' active' : '' ?>" onclick="window.location='?<?= http_build_query(array_merge($currentQuery, ['page' => $i])) ?>'">
                            <?= $i ?>
                        </button>
                    <?php endfor; ?>
                    <button class="page-btn" <?= $currentPage >= $totalPages ? 'disabled' : '' ?> onclick="window.location='?<?= http_build_query(array_merge($currentQuery, ['page' => $currentPage+1])) ?>'">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>