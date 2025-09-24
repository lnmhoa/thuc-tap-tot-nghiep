<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng tin bất động sản - PropertyHub</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../css/addProperty.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <?php 
    // Display error messages if exist
    if (isset($_SESSION['errors'])) {
        echo '<script>window.formErrors = ' . json_encode($_SESSION['errors']) . ';</script>';
        unset($_SESSION['errors']);
    }
    if (isset($_SESSION['success'])) {
        echo '<script>window.formSuccess = ' . json_encode($_SESSION['success']) . ';</script>';
        unset($_SESSION['success']);
    }
    ?>
</head>

<body>
    <?php require_once('../header.php'); ?>

    <main class="add-property-container">
        <div class="form-container">
            <!-- Progress Steps -->
            <div class="progress-container">
                <div class="progress-steps">
                    <div class="progress-step active" data-step="1">
                        <div class="step-circle">1</div>
                        <div class="step-label">Thông tin cơ bản</div>
                    </div>
                    <div class="progress-step" data-step="2">
                        <div class="step-circle">2</div>
                        <div class="step-label">Chi tiết BĐS</div>
                    </div>
                    <div class="progress-step" data-step="3">
                        <div class="step-circle">3</div>
                        <div class="step-label">Hình ảnh</div>
                    </div>
                    <div class="progress-step" data-step="4">
                        <div class="step-circle">4</div>
                        <div class="step-label">Xác nhận</div>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="form-content">
                <form class="property-form" method="POST" enctype="multipart/form-data"
                </div>
            </div>

            <!-- Add Property Form -->
            <div class="add-property-form">
                <form id="addPropertyForm" method="POST" enctype="multipart/form-data">
                    <!-- Step 1: Basic Information -->
                    <div class="form-step active" id="step1">
                        <div class="step-header">
                            <h2>Thông tin cơ bản</h2>
                            <p>Nhập thông tin cơ bản về bất động sản của bạn</p>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="typeId">Loại bất động sản <span class="required">*</span></label>
                                <select id="typeId" name="typeId" class="form-select" required>
                                    <option value="">Chọn loại bất động sản</option>
                                    <?php foreach ($propertyTypes as $type): ?>
                                        <option value="<?= $type['id'] ?>"><?= htmlspecialchars($type['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="transactionType">Mục đích <span class="required">*</span></label>
                                <select id="transactionType" name="transactionType" class="form-select" required>
                                    <option value="">Chọn mục đích</option>
                                    <option value="sale">Bán</option>
                                    <option value="rent">Cho thuê</option>
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label for="title">Tiêu đề tin đăng <span class="required">*</span></label>
                                <input type="text" id="title" name="title" class="form-input" 
                                       placeholder="VD: Chung cư cao cấp 2PN view sông Sài Gòn" required maxlength="255">
                                <div class="char-count">
                                    <span id="titleCount">0</span>/255 ký tự
                                </div>
                            </div>

                            <div class="form-group full-width">
                                <label for="description">Mô tả chi tiết</label>
                                <textarea id="description" name="description" class="form-textarea" rows="6"
                                          placeholder="Mô tả chi tiết về bất động sản, vị trí, tiện ích xung quanh..."></textarea>
                                <div class="char-count">
                                    <span id="descCount">0</span>/2000 ký tự
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="locationId">Khu vực</label>
                                <select id="locationId" name="locationId" class="form-select">
                                    <option value="">Chọn khu vực</option>
                                    <?php foreach ($locations as $location): ?>
                                        <option value="<?= $location['id'] ?>"><?= htmlspecialchars($location['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="address">Địa chỉ cụ thể <span class="required">*</span></label>
                                <input type="text" id="address" name="address" class="form-input" 
                                       placeholder="VD: 123 Đường Nguyễn Văn A, Phường 1, Quận 1" required>
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
                                       placeholder="VD: 85" min="1" step="0.1" required>
                            </div>

                            <div class="form-group">
                                <label for="price">Giá (VNĐ) <span class="required">*</span></label>
                                <input type="number" id="price" name="price" class="form-input" 
                                       placeholder="VD: 15000000" min="0" required>
                            </div>

                            <div class="form-group">
                                <label for="bedrooms">Số phòng ngủ</label>
                                <select id="bedrooms" name="bedrooms" class="form-select">
                                    <option value="0">Studio</option>
                                    <option value="1">1 phòng</option>
                                    <option value="2">2 phòng</option>
                                    <option value="3">3 phòng</option>
                                    <option value="4">4 phòng</option>
                                    <option value="5">5+ phòng</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="bathrooms">Số phòng tắm</label>
                                <select id="bathrooms" name="bathrooms" class="form-select">
                                    <option value="1">1 phòng</option>
                                    <option value="2">2 phòng</option>
                                    <option value="3">3 phòng</option>
                                    <option value="4">4+ phòng</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="floors">Số tầng</label>
                                <input type="number" id="floors" name="floors" class="form-input" 
                                       placeholder="VD: 2" min="1" value="1">
                            </div>

                            <div class="form-group">
                                <label for="frontage">Mặt tiền (m)</label>
                                <input type="number" id="frontage" name="frontage" class="form-input" 
                                       placeholder="VD: 5.2" min="0" step="0.1">
                            </div>

                            <div class="form-group">
                                <label for="direction">Hướng nhà</label>
                                <select id="direction" name="direction" class="form-select">
                                    <option value="">Chọn hướng</option>
                                    <option value="Bắc">Bắc</option>
                                    <option value="Nam">Nam</option>
                                    <option value="Đông">Đông</option>
                                    <option value="Tây">Tây</option>
                                    <option value="Đông Bắc">Đông Bắc</option>
                                    <option value="Tây Bắc">Tây Bắc</option>
                                    <option value="Đông Nam">Đông Nam</option>
                                    <option value="Tây Nam">Tây Nam</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="legalStatus">Tình trạng pháp lý</label>
                                <select id="legalStatus" name="legalStatus" class="form-select">
                                    <option value="">Chọn tình trạng</option>
                                    <option value="Sổ đỏ">Sổ đỏ</option>
                                    <option value="Sổ hồng">Sổ hồng</option>
                                    <option value="Đang chờ sổ">Đang chờ sổ</option>
                                    <option value="Hợp đồng mua bán">Hợp đồng mua bán</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="furniture">Nội thất</label>
                                <select id="furniture" name="furniture" class="form-select">
                                    <option value="none">Không có nội thất</option>
                                    <option value="basic">Nội thất cơ bản</option>
                                    <option value="full">Nội thất đầy đủ</option>
                                </select>
                            </div>
                        </div>

                        <!-- Amenities -->
                        <div class="amenities-section">
                            <h3>Tiện ích</h3>
                            <div class="amenities-grid">
                                <label class="amenity-item">
                                    <input type="checkbox" name="parking" value="1">
                                    <span class="checkmark"></span>
                                    <i class="fas fa-car"></i>
                                    Chỗ đậu xe
                                </label>
                            </div>
                        </div>
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
                                        <small>Hỗ trợ: JPG, PNG, WEBP (tối đa 5MB/ảnh, tối đa 20 ảnh)</small>
                                    </div>
                                </div>
                                <input type="file" name="images[]" id="imageInput" multiple accept="image/jpeg,image/png,image/webp" style="display: none;">
                            </div>

                            <div class="image-preview" id="imagePreview">
                                <!-- Uploaded images will appear here -->
                            </div>

                            <?php if (isset($_SESSION['errors']['images'])): ?>
                                <div class="error-message">
                                    <?php echo $_SESSION['errors']['images']; ?>
                                </div>
                            <?php endif; ?>
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
                                    <img id="previewMainImage" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDMwMCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIzMDAiIGhlaWdodD0iMjAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0xNTAgMTAwTDE3MCA4MEwxMzAgODBMMTUwIDEwMFoiIGZpbGw9IiNBN0I3QzgiLz4KPHN2Zz4K" alt="Preview">
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
                            <button type="submit" class="btn btn-primary submit-btn" name="submit_property">
                                <i class="fas fa-check"></i>
                                Đăng tin ngay
                            </button>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="status" value="1">
                        <input type="hidden" name="featured" value="0">
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php require_once('../footer.php'); ?>

    <!-- JavaScript -->
    <script src="../js/addProperty.js"></script>
</body>
</html>