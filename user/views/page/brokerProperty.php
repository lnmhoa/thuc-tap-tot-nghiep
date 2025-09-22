  <div class="page-header broker-property-page">
        <div class="container">
            <h1>Bất động sản của tôi</h1>
            <div class="breadcrumb">
                <a href="http://localhost/luan_van_tot_nghiep/user">Trang chủ</a>
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
                        <h3>24</h3>
                        <p>Tổng BĐS</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon active">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-content">
                        <h3>18</h3>
                        <p>Đang hiển thị</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3>3</h3>
                        <p>Chờ duyệt</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon hidden">
                        <i class="fas fa-eye-slash"></i>
                    </div>
                    <div class="stat-content">
                        <h3>3</h3>
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
                            <button class="tab-btn active" data-status="all">Tất cả (24)</button>
                            <button class="tab-btn" data-status="active">Đang hiển thị (18)</button>
                            <button class="tab-btn" data-status="pending">Chờ duyệt (3)</button>
                            <button class="tab-btn" data-status="hidden">Đã ẩn (3)</button>
                        </div>
                    </div>
                    <div class="header-right">
                        <div class="search-box">
                            <input type="text" placeholder="Tìm kiếm BĐS..." id="searchInput">
                            <i class="fas fa-search"></i>
                        </div>
                        <select class="sort-select" id="sortSelect">
                            <option value="newest">Mới nhất</option>
                            <option value="oldest">Cũ nhất</option>
                            <option value="price-high">Giá cao nhất</option>
                            <option value="price-low">Giá thấp nhất</option>
                            <option value="views">Lượt xem nhiều</option>
                        </select>
                        <a href="add-property.html" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Đăng tin mới
                        </a>
                    </div>
                </div>

                <!-- Properties List -->
                <div class="properties-list" id="propertiesList">
                    <!-- Property Item 1 -->
                    <div class="property-item" data-status="active">
                        <div class="property-image">
                            <img src="/placeholder.svg?height=200&width=300" alt="Chung cư cao cấp">
                            <div class="property-status active">Đang hiển thị</div>
                            <div class="property-views">
                                <i class="fas fa-eye"></i>
                                1,234 lượt xem
                            </div>
                        </div>
                        <div class="property-content">
                            <div class="property-header">
                                <h3>Chung cư cao cấp Vinhomes Central Park</h3>
                                <div class="property-id">#BDS001</div>
                            </div>
                            <div class="property-details">
                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Quận Bình Thạnh, TP.HCM
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                    85m²
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-bed"></i>
                                    2 phòng ngủ
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-bath"></i>
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
                <div class="pagination">
                    <button class="page-btn" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <span class="page-dots">...</span>
                    <button class="page-btn">8</button>
                    <button class="page-btn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </main>