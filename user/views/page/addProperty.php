<div class="page-header">
        <div class="container">
            <h1>Đăng tin bất động sản</h1>
            <div class="breadcrumb">
                <a href="http://localhost/luan_van_tot_nghiep/user">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Đăng tin mới</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Progress Steps -->
            <div class="progress-steps">
                <div class="step active" data-step="1">
                    <div class="step-number">1</div>
                    <div class="step-label">Thông tin cơ bản</div>
                </div>
                <div class="step" data-step="2">
                    <div class="step-number">2</div>
                    <div class="step-label">Chi tiết BĐS</div>
                </div>
                <div class="step" data-step="3">
                    <div class="step-number">3</div>
                    <div class="step-label">Hình ảnh</div>
                </div>
                <div class="step" data-step="4">
                    <div class="step-number">4</div>
                    <div class="step-label">Xác nhận</div>
                </div>
            </div>

            <!-- Add Property Form -->
            <div class="add-property-form">
                <form id="addPropertyForm">
                    <!-- Step 1: Basic Information -->
                    <div class="form-step active" id="step1">
                        <div class="step-header">
                            <h2>Thông tin cơ bản</h2>
                            <p>Nhập thông tin cơ bản về bất động sản của bạn</p>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="propertyType">Loại bất động sản <span class="required">*</span></label>
                                <select id="propertyType" name="propertyType" class="form-select" required>
                                    <option value="">Chọn loại bất động sản</option>
                                    <option value="apartment">Chung cư</option>
                                    <option value="house">Nhà riêng</option>
                                    <option value="villa">Biệt thự</option>
                                    <option value="land">Đất nền</option>
                                    <option value="office">Văn phòng</option>
                                    <option value="shop">Cửa hàng</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="purpose">Mục đích <span class="required">*</span></label>
                                <select id="purpose" name="purpose" class="form-select" required>
                                    <option value="">Chọn mục đích</option>
                                    <option value="sell">Bán</option>
                                    <option value="rent">Cho thuê</option>
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label for="title">Tiêu đề tin đăng <span class="required">*</span></label>
                                <input type="text" id="title" name="title" class="form-input" 
                                       placeholder="VD: Chung cư cao cấp 2PN view sông Sài Gòn" required>
                                <div class="char-count">
                                    <span id="titleCount">0</span>/100 ký tự
                                </div>
                            </div>

                            <div class="form-group full-width">
                                <label for="description">Mô tả chi tiết <span class="required">*</span></label>
                                <textarea id="description" name="description" class="form-textarea" rows="6"
                                          placeholder="Mô tả chi tiết về bất động sản, vị trí, tiện ích xung quanh..." required></textarea>
                                <div class="char-count">
                                    <span id="descCount">0</span>/2000 ký tự
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="province">Tỉnh/Thành phố <span class="required">*</span></label>
                                <select id="province" name="province" class="form-select" required>
                                    <option value="">Chọn tỉnh/thành</option>
                                    <option value="hanoi">Hà Nội</option>
                                    <option value="hcm">TP. Hồ Chí Minh</option>
                                    <option value="danang">Đà Nẵng</option>
                                    <option value="haiphong">Hải Phòng</option>
                                    <option value="cantho">Cần Thơ</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="district">Quận/Huyện <span class="required">*</span></label>
                                <select id="district" name="district" class="form-select" required>
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label for="address">Địa chỉ cụ thể <span class="required">*</span></label>
                                <input type="text" id="address" name="address" class="form-input" 
                                       placeholder="VD: 123 Đường Nguyễn Văn A, Phường 1" required>
                            </div>
                        </div>

                        <div class="step-actions">
                            <button type="button" class="btn btn-primary next-step">
                                Tiếp theo
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Property Details -->
                    <div class="form-step" id="step2">
                        <div class="step-header">
                            <h2>Chi tiết bất động sản</h2>
                            <p>Nhập thông tin chi tiết về diện tích, giá cả và đặc điểm</p>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="area">Diện tích (m²) <span class="required">*</span></label>
                                <input type="number" id="area" name="area" class="form-input" 
                                       placeholder="VD: 85" min="1" required>
                            </div>

                            <div class="form-group">
                                <label for="price">Giá <span class="required">*</span></label>
                                <input type="number" id="price" name="price" class="form-input" 
                                       placeholder="VD: 3200000000" min="0" required>
                            </div>

                            <div class="form-group">
                                <label for="bedrooms">Số phòng ngủ</label>
                                <select id="bedrooms" name="bedrooms" class="form-select">
                                    <option value="">Chọn số phòng</option>
                                    <option value="1">1 phòng</option>
                                    <option value="2">2 phòng</option>
                                    <option value="3">3 phòng</option>
                                    <option value="4">4 phòng</option>
                                    <option value="5+">5+ phòng</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="bathrooms">Số phòng tắm</label>
                                <select id="bathrooms" name="bathrooms" class="form-select">
                                    <option value="">Chọn số phòng</option>
                                    <option value="1">1 phòng</option>
                                    <option value="2">2 phòng</option>
                                    <option value="3">3 phòng</option>
                                    <option value="4+">4+ phòng</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="direction">Hướng nhà</label>
                                <select id="direction" name="direction" class="form-select">
                                    <option value="">Chọn hướng</option>
                                    <option value="north">Bắc</option>
                                    <option value="south">Nam</option>
                                    <option value="east">Đông</option>
                                    <option value="west">Tây</option>
                                    <option value="northeast">Đông Bắc</option>
                                    <option value="northwest">Tây Bắc</option>
                                    <option value="southeast">Đông Nam</option>
                                    <option value="southwest">Tây Nam</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="legalStatus">Tình trạng pháp lý</label>
                                <select id="legalStatus" name="legalStatus" class="form-select">
                                    <option value="">Chọn tình trạng</option>
                                    <option value="red-book">Sổ đỏ</option>
                                    <option value="pink-book">Sổ hồng</option>
                                    <option value="waiting">Đang chờ sổ</option>
                                    <option value="contract">Hợp đồng mua bán</option>
                                </select>
                            </div>
                        </div>

                        <!-- Amenities -->
                        <div class="amenities-section">
                            <h3>Tiện ích</h3>
                            <div class="amenities-grid">
                                <label class="amenity-item">
                                    <input type="checkbox" name="amenities" value="parking">
                                    <span class="checkmark"></span>
                                    <i class="fas fa-car"></i>
                                    Chỗ đậu xe
                                </label>
                                <label class="amenity-item">
                                    <input type="checkbox" name="amenities" value="elevator">
                                    <span class="checkmark"></span>
                                    <i class="fas fa-elevator"></i>
                                    Thang máy
                                </label>
                                <label class="amenity-item">
                                    <input type="checkbox" name="amenities" value="balcony">
                                    <span class="checkmark"></span>
                                    <i class="fas fa-building"></i>
                                    Ban công
                                </label>
                                <label class="amenity-item">
                                    <input type="checkbox" name="amenities" value="garden">
                                    <span class="checkmark"></span>
                                    <i class="fas fa-seedling"></i>
                                    Sân vườn
                                </label>
                                <label class="amenity-item">
                                    <input type="checkbox" name="amenities" value="pool">
                                    <span class="checkmark"></span>
                                    <i class="fas fa-swimming-pool"></i>
                                    Hồ bơi
                                </label>
                                <label class="amenity-item">
                                    <input type="checkbox" name="amenities" value="gym">
                                    <span class="checkmark"></span>
                                    <i class="fas fa-dumbbell"></i>
                                    Phòng gym
                                </label>
                                <label class="amenity-item">
                                    <input type="checkbox" name="amenities" value="security">
                                    <span class="checkmark"></span>
                                    <i class="fas fa-shield-alt"></i>
                                    Bảo vệ 24/7
                                </label>
                                <label class="amenity-item">
                                    <input type="checkbox" name="amenities" value="furnished">
                                    <span class="checkmark"></span>
                                    <i class="fas fa-couch"></i>
                                    Nội thất
                                </label>
                            </div>
                        </div>

                        <div class="step-actions">
                            <button type="button" class="btn btn-outline prev-step">
                                <i class="fas fa-arrow-left"></i>
                                Quay lại
                            </button>
                            <button type="button" class="btn btn-primary next-step">
                                Tiếp theo
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Images -->
                    <div class="form-step" id="step3">
                        <div class="step-header">
                            <h2>Hình ảnh bất động sản</h2>
                            <p>Tải lên hình ảnh để thu hút khách hàng (tối đa 20 ảnh)</p>
                        </div>

                        <div class="image-upload-section">
                            <div class="upload-area" id="uploadArea">
                                <div class="upload-content">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <h3>Kéo thả ảnh vào đây</h3>
                                    <p>hoặc <span class="upload-link">chọn từ máy tính</span></p>
                                    <div class="upload-info">
                                        <small>Hỗ trợ: JPG, PNG, GIF (tối đa 5MB/ảnh)</small>
                                    </div>
                                </div>
                                <input type="file" id="imageInput" multiple accept="image/*" style="display: none;">
                            </div>

                            <div class="image-preview" id="imagePreview">
                                <!-- Uploaded images will appear here -->
                            </div>
                        </div>

                        <div class="step-actions">
                            <button type="button" class="btn btn-outline prev-step">
                                <i class="fas fa-arrow-left"></i>
                                Quay lại
                            </button>
                            <button type="button" class="btn btn-primary next-step">
                                Tiếp theo
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 4: Confirmation -->
                    <div class="form-step" id="step4">
                        <div class="step-header">
                            <h2>Xác nhận và đăng tin</h2>
                            <p>Kiểm tra lại thông tin và chọn gói đăng tin</p>
                        </div>

                        <!-- Property Preview -->
                        <div class="property-preview">
                            <h3>Xem trước tin đăng</h3>
                            <div class="preview-card">
                                <div class="preview-image">
                                    <img id="previewMainImage" src="/placeholder.svg?height=200&width=300" alt="Preview">
                                    <div class="preview-badge">
                                        <span id="previewPurpose">Bán</span>
                                    </div>
                                </div>
                                <div class="preview-content">
                                    <h4 id="previewTitle">Tiêu đề bất động sản</h4>
                                    <div class="preview-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span id="previewLocation">Địa chỉ</span>
                                    </div>
                                    <div class="preview-features">
                                        <span id="previewArea"><i class="fas fa-expand-arrows-alt"></i> 0m²</span>
                                        <span id="previewBedrooms"><i class="fas fa-bed"></i> 0 phòng ngủ</span>
                                        <span id="previewBathrooms"><i class="fas fa-bath"></i> 0 phòng tắm</span>
                                    </div>
                                    <div class="preview-price" id="previewPrice">0 VNĐ</div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Plans -->
                        <div class="pricing-plans">
                            <h3>Chọn gói đăng tin</h3>
                            <div class="plans-grid">
                                <div class="plan-card">
                                    <div class="plan-header">
                                        <h4>Gói Cơ bản</h4>
                                        <div class="plan-price">
                                            <span class="price">500,000</span>
                                            <span class="currency">VNĐ</span>
                                        </div>
                                        <div class="plan-duration">30 ngày</div>
                                    </div>
                                    <div class="plan-features">
                                        <div class="feature">
                                            <i class="fas fa-check"></i>
                                            Hiển thị trong danh sách
                                        </div>
                                        <div class="feature">
                                            <i class="fas fa-check"></i>
                                            Tối đa 10 hình ảnh
                                        </div>
                                        <div class="feature">
                                            <i class="fas fa-check"></i>
                                            Hỗ trợ cơ bản
                                        </div>
                                    </div>
                                    <label class="plan-select">
                                        <input type="radio" name="plan" value="basic" checked>
                                        <span class="radio-custom"></span>
                                        Chọn gói này
                                    </label>
                                </div>

                                <div class="plan-card featured">
                                    <div class="plan-badge">Phổ biến</div>
                                    <div class="plan-header">
                                        <h4>Gói Nổi bật</h4>
                                        <div class="plan-price">
                                            <span class="price">1,200,000</span>
                                            <span class="currency">VNĐ</span>
                                        </div>
                                        <div class="plan-duration">30 ngày</div>
                                    </div>
                                    <div class="plan-features">
                                        <div class="feature">
                                            <i class="fas fa-check"></i>
                                            Hiển thị ưu tiên
                                        </div>
                                        <div class="feature">
                                            <i class="fas fa-check"></i>
                                            Tối đa 20 hình ảnh
                                        </div>
                                        <div class="feature">
                                            <i class="fas fa-check"></i>
                                            Đánh dấu "Nổi bật"
                                        </div>
                                        <div class="feature">
                                            <i class="fas fa-check"></i>
                                            Hỗ trợ ưu tiên
                                        </div>
                                    </div>
                                    <label class="plan-select">
                                        <input type="radio" name="plan" value="featured">
                                        <span class="radio-custom"></span>
                                        Chọn gói này
                                    </label>
                                </div>

                                <div class="plan-card">
                                    <div class="plan-header">
                                        <h4>Gói VIP</h4>
                                        <div class="plan-price">
                                            <span class="price">2,500,000</span>
                                            <span class="currency">VNĐ</span>
                                        </div>
                                        <div class="plan-duration">30 ngày</div>
                                    </div>
                                    <div class="plan-features">
                                        <div class="feature">
                                            <i class="fas fa-check"></i>
                                            Hiển thị đầu trang
                                        </div>
                                        <div class="feature">
                                            <i class="fas fa-check"></i>
                                            Không giới hạn ảnh
                                        </div>
                                        <div class="feature">
                                            <i class="fas fa-check"></i>
                                            Video giới thiệu
                                        </div>
                                        <div class="feature">
                                            <i class="fas fa-check"></i>
                                            Hỗ trợ 24/7
                                        </div>
                                    </div>
                                    <label class="plan-select">
                                        <input type="radio" name="plan" value="vip">
                                        <span class="radio-custom"></span>
                                        Chọn gói này
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="step-actions">
                            <button type="button" class="btn btn-outline prev-step">
                                <i class="fas fa-arrow-left"></i>
                                Quay lại
                            </button>
                            <button type="submit" class="btn btn-primary submit-btn">
                                <i class="fas fa-check"></i>
                                Đăng tin ngay
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>