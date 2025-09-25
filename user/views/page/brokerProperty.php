  <div class="page-header broker-property-page">
        <div class="container">
            <h1>Bất động sản của tôi</h1>
            <div class="breadcrumb">
                <a href="http://localhost/van_van-1p/user">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Bất động sản của tôi</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Dashboard Stats -->
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $stats['total'] ?></h3>
                        <p>Tổng BĐS</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon active">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $stats['active'] ?></h3>
                        <p>Đang hiển thị</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $stats['pending'] ?></h3>
                        <p>Chờ duyệt</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon hidden">
                        <i class="fas fa-eye-slash"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= $stats['inactive'] ?></h3>
                        <p>Đã ẩn</p>
                    </div>
                </div>
            </div>

            <!-- Properties Management -->
            <div class="properties-management">
                <div class="management-header">
                    <div class="header-left">
                        <h2>Quản lý bất động sản</h2>
                        <div class="filter-tabs">
                            <button class="tab-btn <?= empty($statusFilter) || $statusFilter === 'all' ? 'active' : '' ?>" data-status="all">
                                Tất cả (<?= $stats['total'] ?>)
                            </button>
                            <button class="tab-btn <?= $statusFilter === 'active' ? 'active' : '' ?>" data-status="active">
                                Đang hiển thị (<?= $stats['active'] ?>)
                            </button>
                            <button class="tab-btn <?= $statusFilter === 'pending' ? 'active' : '' ?>" data-status="pending">
                                Chờ duyệt (<?= $stats['pending'] ?>)
                            </button>
                            <button class="tab-btn <?= $statusFilter === 'inactive' ? 'active' : '' ?>" data-status="inactive">
                                Đã ẩn (<?= $stats['inactive'] ?>)
                            </button>
                        </div>
                    </div>
                    <div class="header-right">
                        <div class="search-box">
                            <input type="text" placeholder="Tìm kiếm BĐS..." id="searchInput" value="<?= htmlspecialchars($searchFilter ?? '') ?>">
                            <i class="fas fa-search"></i>
                        </div>
                        <select class="sort-select" id="sortSelect">
                            <option value="newest">Mới nhất</option>
                            <option value="oldest">Cũ nhất</option>
                            <option value="price-high">Giá cao nhất</option>
                            <option value="price-low">Giá thấp nhất</option>
                            <option value="views">Lượt xem nhiều</option>
                        </select>
                        <a href="?act=addProperty" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Đăng tin mới
                        </a>
                    </div>
                </div>

                <!-- Properties List -->
                <div class="properties-list" id="propertiesList">
                    <?php if (!empty($properties)): ?>
                        <?php foreach ($properties as $property): ?>
                            <div class="property-item" data-status="<?= $property['status'] ?>">
                                <div class="property-image">
                                    <?php 
                                    $imagePath = !empty($property['mainImage']) ? 
                                        "./uploads/rentalProperty/" . $property['mainImage'] : 
                                        "../logo.jpg";
                                    ?>
                                    <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($property['title']) ?>">
                                    <div class="property-status <?= $property['status'] ?>">
                                        <?php 
                                        switch($property['status']) {
                                            case 'active': echo 'Đang hiển thị'; break;
                                            case 'pending': echo 'Chờ duyệt'; break;
                                            case 'inactive': echo 'Đã ẩn'; break;
                                            default: echo 'Không xác định';
                                        }
                                        ?>
                                    </div>
                                    <div class="property-views">
                                        <i class="fas fa-eye"></i>
                                        <?= number_format($property['views']) ?> lượt xem
                                    </div>
                                </div>
                                <div class="property-content">
                                    <div class="property-header">
                                        <h3><?= htmlspecialchars($property['title']) ?></h3>
                                        <div class="property-id">#BDS<?= str_pad($property['id'], 3, '0', STR_PAD_LEFT) ?></div>
                                    </div>
                                    <div class="property-details">
                                        <div class="detail-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?= htmlspecialchars($property['address']) ?>
                                        </div>
                                        <div class="detail-item">
                                            <i class="fas fa-expand-arrows-alt"></i>
                                            <?= number_format($property['area'], 1) ?>m²
                                        </div>
                                        <div class="detail-item">
                                            <i class="fas fa-bed"></i>
                                            <?= $property['bedrooms'] ?> phòng ngủ
                                        </div>
                                        <div class="detail-item">
                                            <i class="fas fa-bath"></i>
                                            <?= $property['bathrooms'] ?> phòng tắm
                                        </div>
                                    </div>
                                    <div class="property-price">
                                        <span class="price"><?= number_format($property['price']) ?> VNĐ/tháng</span>
                                        <span class="price-per-m2"><?= number_format($property['price'] / $property['area']) ?> VNĐ/m²</span>
                                    </div>
                                    <div class="property-meta">
                                        <div class="meta-item">
                                            <i class="fas fa-calendar"></i>
                                            Đăng: <?= date('d/m/Y', strtotime($property['createdAt'])) ?>
                                        </div>
                                        <div class="meta-item">
                                            <i class="fas fa-images"></i>
                                            <?= $property['imageCount'] ?> hình ảnh
                                        </div>
                                    </div>
                                    <div class="property-actions">
                                        <a href="?act=property&id=<?= $property['id'] ?>" class="btn btn-outline btn-sm">
                                            <i class="fas fa-eye"></i>
                                            Xem chi tiết
                                        </a>
                                        <button class="btn btn-outline btn-sm" onclick="editProperty(<?= $property['id'] ?>)">
                                            <i class="fas fa-edit"></i>
                                            Chỉnh sửa
                                        </button>
                                        <button class="btn btn-outline btn-sm toggle-status-btn" 
                                                onclick="toggleStatus(<?= $property['id'] ?>, '<?= $property['status'] ?>')">
                                            <i class="fas fa-<?= $property['status'] === 'active' ? 'eye-slash' : 'eye' ?>"></i>
                                            <?= $property['status'] === 'active' ? 'Ẩn tin' : 'Hiện tin' ?>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteProperty(<?= $property['id'] ?>)">
                                            <i class="fas fa-trash"></i>
                                            Xóa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <h3>Chưa có bất động sản nào</h3>
                            <p>Bạn chưa đăng tin bất động sản nào. Hãy bắt đầu đăng tin để tiếp cận khách hàng!</p>
                            <a href="?act=addProperty" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Đăng tin ngay
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                                    2 phòng tắm
                                </div>
                            </div>
                            <div class="property-price">
                                <span class="price">3.2 tỷ VNĐ</span>
                                <span class="price-per-m2">37.6 triệu/m²</span>
                            </div>
                            <div class="property-meta">
                                <span class="post-date">
                                    <i class="fas fa-calendar"></i>
                                    Đăng ngày 15/12/2024
                                </span>
                                <span class="expire-date">
                                    <i class="fas fa-clock"></i>
                                    Hết hạn 15/01/2025
                                </span>
                            </div>
                        </div>
                        <div class="property-actions">
                            <button class="action-btn view-btn" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn edit-btn" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn hide-btn" title="Ẩn tin">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                            <button class="action-btn extend-btn" title="Gia hạn">
                                <i class="fas fa-calendar-plus"></i>
                            </button>
                            <button class="action-btn delete-btn" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Property Item 2 -->
                    <div class="property-item" data-status="pending">
                        <div class="property-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Biệt thự sang trọng">
                            <div class="property-status pending">Chờ duyệt</div>
                            <div class="property-views">
                                <i class="fas fa-eye"></i>
                                0 lượt xem
                            </div>
                        </div>
                        <div class="property-content">
                            <div class="property-header">
                                <h3>Biệt thự sang trọng Thảo Điền</h3>
                                <div class="property-id">#BDS002</div>
                            </div>
                            <div class="property-details">
                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Quận 2, TP.HCM
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                    250m²
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-bed"></i>
                                    4 phòng ngủ
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-bath"></i>
                                    3 phòng tắm
                                </div>
                            </div>
                            <div class="property-price">
                                <span class="price">12.5 tỷ VNĐ</span>
                                <span class="price-per-m2">50 triệu/m²</span>
                            </div>
                            <div class="property-meta">
                                <span class="post-date">
                                    <i class="fas fa-calendar"></i>
                                    Đăng ngày 20/12/2024
                                </span>
                                <span class="expire-date pending">
                                    <i class="fas fa-clock"></i>
                                    Đang chờ duyệt
                                </span>
                            </div>
                        </div>
                        <div class="property-actions">
                            <button class="action-btn view-btn" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn edit-btn" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn delete-btn" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Property Item 3 -->
                    <div class="property-item" data-status="hidden">
                        <div class="property-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Văn phòng cho thuê">
                            <div class="property-status hidden">Đã ẩn</div>
                            <div class="property-views">
                                <i class="fas fa-eye"></i>
                                567 lượt xem
                            </div>
                        </div>
                        <div class="property-content">
                            <div class="property-header">
                                <h3>Văn phòng cho thuê Quận 1</h3>
                                <div class="property-id">#BDS003</div>
                            </div>
                            <div class="property-details">
                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Quận 1, TP.HCM
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                    120m²
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-building"></i>
                                    Tầng 15
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-car"></i>
                                    2 chỗ đậu xe
                                </div>
                            </div>
                            <div class="property-price">
                                <span class="price">45 triệu/tháng</span>
                                <span class="price-per-m2">375k/m²/tháng</span>
                            </div>
                            <div class="property-meta">
                                <span class="post-date">
                                    <i class="fas fa-calendar"></i>
                                    Đăng ngày 10/12/2024
                                </span>
                                <span class="expire-date">
                                    <i class="fas fa-clock"></i>
                                    Hết hạn 10/01/2025
                                </span>
                            </div>
                        </div>
                        <div class="property-actions">
                            <button class="action-btn view-btn" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn edit-btn" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn show-btn" title="Hiển thị">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn extend-btn" title="Gia hạn">
                                <i class="fas fa-calendar-plus"></i>
                            </button>
                            <button class="action-btn delete-btn" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?act=brokerProperty&page=<?= $page - 1 ?>&status=<?= $statusFilter ?>&search=<?= urlencode($searchFilter) ?>" class="page-btn">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php else: ?>
                        <button class="page-btn" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    <?php endif; ?>

                    <?php
                    $startPage = max(1, $page - 2);
                    $endPage = min($totalPages, $page + 2);
                    
                    if ($startPage > 1) {
                        echo '<a href="?act=brokerProperty&page=1&status=' . $statusFilter . '&search=' . urlencode($searchFilter) . '" class="page-btn">1</a>';
                        if ($startPage > 2) {
                            echo '<span class="page-dots">...</span>';
                        }
                    }
                    
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $activeClass = ($i == $page) ? 'active' : '';
                        echo '<a href="?act=brokerProperty&page=' . $i . '&status=' . $statusFilter . '&search=' . urlencode($searchFilter) . '" class="page-btn ' . $activeClass . '">' . $i . '</a>';
                    }
                    
                    if ($endPage < $totalPages) {
                        if ($endPage < $totalPages - 1) {
                            echo '<span class="page-dots">...</span>';
                        }
                        echo '<a href="?act=brokerProperty&page=' . $totalPages . '&status=' . $statusFilter . '&search=' . urlencode($searchFilter) . '" class="page-btn">' . $totalPages . '</a>';
                    }
                    ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?act=brokerProperty&page=<?= $page + 1 ?>&status=<?= $statusFilter ?>&search=<?= urlencode($searchFilter) ?>" class="page-btn">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <button class="page-btn" disabled>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
    function toggleStatus(propertyId, currentStatus) {
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        const actionText = newStatus === 'active' ? 'hiện' : 'ẩn';
        
        if (confirm(`Bạn có chắc muốn ${actionText} tin đăng này?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="action" value="toggle_status">
                <input type="hidden" name="propertyId" value="${propertyId}">
                <input type="hidden" name="status" value="${newStatus}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    function deleteProperty(propertyId) {
        if (confirm('Bạn có chắc muốn xóa tin đăng này? Hành động này không thể hoàn tác.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="propertyId" value="${propertyId}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    function editProperty(propertyId) {
        window.location.href = `?act=addProperty&edit=${propertyId}`;
    }

    // Filter tabs functionality
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const status = this.dataset.status;
            const currentUrl = new URL(window.location);
            if (status === 'all') {
                currentUrl.searchParams.delete('status');
            } else {
                currentUrl.searchParams.set('status', status);
            }
            currentUrl.searchParams.delete('page'); // Reset to page 1
            window.location.href = currentUrl.toString();
        });
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const currentUrl = new URL(window.location);
            if (this.value.trim()) {
                currentUrl.searchParams.set('search', this.value.trim());
            } else {
                currentUrl.searchParams.delete('search');
            }
            currentUrl.searchParams.delete('page'); // Reset to page 1
            window.location.href = currentUrl.toString();
        }
    });
    </script>