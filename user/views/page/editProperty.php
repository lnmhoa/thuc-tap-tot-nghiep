<div class="user-profile-wrapper">
<main class="profile-main">
    <div class="container">
        <div class="profile-layout">
            <aside class="profile-sidebar">
                <div class="profile-user-card">
                    <div class="user-avatar">
                      <?php if (!empty($_SESSION['user']['avatar'])): ?>
                            <img src="../uploads/user/<?= $_SESSION['user']['avatar'] ?>" alt="Avatar" id="avatarPreview">
                        <?php else: ?>
                            <img src="../uploads/system/default_user.jpg" alt="Default Avatar" id="avatarPreview">
                        <?php endif; ?>
                    </div>
                    <div class="user-info">
                        <h3><?= htmlspecialchars($_SESSION['user']['fullName'] ?? 'Người dùng') ?></h3>
                        <div class="user-badge">
                            <i class="fas fa-shield-alt"></i>
                            Môi giới
                        </div>
                    </div>
                </div>
                
                <nav class="profile-menu">
                    <a href="?act=profile" class="menu-item">
                        <i class="fas fa-user"></i>
                        <span>Thông tin cá nhân</span>
                    </a>
                    <a href="?act=changePassword" class="menu-item">
                        <i class="fas fa-lock"></i>
                        <span>Đổi mật khẩu</span>
                    </a>
                    <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['role'] === '2' && $_SESSION['user']['status'] === 'active'): ?>
                    <a href="?act=myProperty" class="menu-item">
                        <i class="fas fa-home"></i>
                        <span>BĐS của tôi</span>
                    </a>
                       <a href="?act=addProperty" class="menu-item active">
                        <i class="fas fa-plus"></i>
                        <span>Thêm BĐS</span>
                    </a>
                    <?php endif; ?>
                    <a href="?act=saveProperty" class="menu-item">
                        <i class="fas fa-heart"></i>
                        <span>BĐS đã lưu</span>
                    </a>
                    <a href="?act=followBroker" class="menu-item">
                        <i class="fas fa-user-friends"></i>
                        <span>Môi giới theo dõi</span>
                    </a>
                    <a href="?act=consultationRequest" class="menu-item">
                        <i class="fas fa-comments"></i>
                        <span>Yêu cầu tư vấn</span>
                    </a>
                </nav>
            </aside>
            <div class="profile-content" style="padding: 2rem">
            <div class="form-section" style="margin-bottom: 0.5rem;">
                <h3 class="section-title" style="margin-bottom:0.5rem;">Chỉnh sửa bất động sản</h3>
            </div>
                <form method="POST" enctype="multipart/form-data" class="add-property-form" style="gap: 0">
                   <div class="form-section" style="margin-bottom: 0">
                            <div class="form-grid">
                                <div class="form-group full-width">
                                    <label>Ảnh chính <span class="required">*</span></label>
                                    <div class="main-image-upload" style="display: flex; align-items: center; gap: 2rem;">
                                        <div class="main-image-preview property-image" style="width: 180px; height: 180px; border-radius: 12px; border: 1.5px solid #e9ecef; background: #f8f9fa; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                            <img id="mainImagePreview" src="../uploads/system/default_property.jpg" alt="Ảnh chính" style="width: 100%; height: 100%; object-fit: cover; display: block;" />
                                        </div>
                                        <div class="upload-info">
                                            <input type="file" id="mainImage" name="mainImage" accept="image/*" style="display:none;" required>
                                            <button type="button" class="btn btn-outline" onclick="document.getElementById('mainImage').click()"><i class="fas fa-upload"></i> Chọn ảnh chính</button>
                                            <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #6c757d;">Chỉ nhận 1 ảnh, định dạng JPG, PNG, JPEG, WEBP. Kích thước tối đa 5MB.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group full-width">
                                    <label>Ảnh phụ (có thể chọn nhiều)</label>
                                    <div class="sub-images-upload">
                                        <input type="file" id="subImages" name="subImages[]" accept="image/*" multiple style="display:none;">
                                        <button type="button" class="btn btn-outline" onclick="document.getElementById('subImages').click()"><i class="fas fa-images"></i> Chọn ảnh phụ</button>
                                        <div id="subImagesPreview" style="display: flex; gap: 1rem; margin-top: 1rem; flex-wrap: wrap;"></div>
                                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #6c757d;">Có thể chọn nhiều ảnh, định dạng JPG, PNG, JPEG, WEBP. Mỗi ảnh tối đa 5MB.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                <div class="form-section" style="margin-bottom: 0">
                        <div class="form-grid" style="padding-bottom: 0">
                            <div class="input-group" style="display: block">
                                <label for="title">Tiêu đề <span class="required">*</span></label>
                                <input type="text" id="title" name="title" style="margin-top:0.43rem; padding: 0.75rem 1rem" required 
                                       placeholder="VD: Căn hộ 2PN view sông, tầng cao, nội thất đầy đủ"
                                       value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="transactionType">Loại giao dịch <span class="required">*</span></label>
                                <select id="transactionType" name="transactionType" required>
                                    <option value="rent" <?= ($_POST['transactionType'] ?? '') === 'rent' ? 'selected' : '' ?>>Cho thuê</option>
                                    <option value="sale" <?= ($_POST['transactionType'] ?? '') === 'sale' ? 'selected' : '' ?>>Bán</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="typeId">Loại BĐS <span class="required">*</span></label>
                                <select id="typeId" name="typeId" required>
                                    <?php foreach ($propertyTypes as $type): ?>
                                        <option value="<?= $type['id'] ?>" 
                                            <?= ($_POST['typeId'] ?? '') == $type['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($type['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="locationId">Khu vực <span class="required">*</span></label>
                                <select id="locationId" name="locationId" required>
                                    <?php foreach ($locations as $location): ?>
                                        <option value="<?= $location['id'] ?>" 
                                            <?= ($_POST['locationId'] ?? '') == $location['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($location['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-group  full-width" style="display: block">
                                <label for="address">Địa chỉ cụ thể <span class="required">*</span></label>
                                <input type="text" id="address" name="address" required  style="margin-top:0.43rem; padding: 0.75rem 1rem" 
                                       placeholder="VD: 123 Nguyễn Văn Linh, Phường Tân Thuận Tây"
                                       value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
                            </div>
                            <div class="form-group full-width" style="margin-bottom: 0;">
                                <label for="description">Mô tả chi tiết <span class="required">*</span></label>
                                <textarea id="description" name="description" rows="4" required 
                                          placeholder="Mô tả chi tiết về bất động sản: vị trí, tiện ích, đặc điểm nổi bật..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                            </div>
                            </div>
                        </div>
                           <div class="form-section" style="margin-bottom: 0">
                        <div class="form-grid">
                            <div class="input-group" style="display: block">
                                <label for="price">Giá <span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="type" id="price" name="price" required min="0" style="margin-top:0.43rem; padding: 0.75rem 1rem"  
                                           placeholder="0" value="<?= $_POST['price'] ?? '' ?>">
                                    <span class="input-suffix">VNĐ</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="area">Diện tích <span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="number" id="area" name="area" style=" padding: 0.75rem 1rem"   required min="0" step="0.1" 
                                           placeholder="0" value="<?= $_POST['area'] ?? '' ?>">
                                    <span class="input-suffix">m²</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bedrooms">Số phòng ngủ</label>
                                <select id="bedrooms" name="bedrooms">
                                    <option value="0" <?= ($_POST['bedrooms'] ?? '0') === '0' ? 'selected' : '' ?>>0</option>
                                    <option value="1" <?= ($_POST['bedrooms'] ?? '') === '1' ? 'selected' : '' ?>>1</option>
                                    <option value="2" <?= ($_POST['bedrooms'] ?? '') === '2' ? 'selected' : '' ?>>2</option>
                                    <option value="3" <?= ($_POST['bedrooms'] ?? '') === '3' ? 'selected' : '' ?>>3</option>
                                    <option value="4" <?= ($_POST['bedrooms'] ?? '') === '4' ? 'selected' : '' ?>>4</option>
                                    <option value="5" <?= ($_POST['bedrooms'] ?? '') === '5' ? 'selected' : '' ?>>5+</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="bathrooms">Số phòng tắm</label>
                                <select id="bathrooms" name="bathrooms">
                                    <option value="0" <?= ($_POST['bathrooms'] ?? '0') === '0' ? 'selected' : '' ?>>0</option>
                                    <option value="1" <?= ($_POST['bathrooms'] ?? '') === '1' ? 'selected' : '' ?>>1</option>
                                    <option value="2" <?= ($_POST['bathrooms'] ?? '') === '2' ? 'selected' : '' ?>>2</option>
                                    <option value="3" <?= ($_POST['bathrooms'] ?? '') === '3' ? 'selected' : '' ?>>3</option>
                                    <option value="4" <?= ($_POST['bathrooms'] ?? '') === '4' ? 'selected' : '' ?>>4</option>
                                    <option value="5" <?= ($_POST['bathrooms'] ?? '') === '5' ? 'selected' : '' ?>>5+</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="floors">Số tầng</label>
                                <select id="floors" name="floors">
                                    <option value="1" <?= ($_POST['floors'] ?? '1') === '1' ? 'selected' : '' ?>>1</option>
                                    <option value="2" <?= ($_POST['floors'] ?? '') === '2' ? 'selected' : '' ?>>2</option>
                                    <option value="3" <?= ($_POST['floors'] ?? '') === '3' ? 'selected' : '' ?>>3</option>
                                    <option value="4" <?= ($_POST['floors'] ?? '') === '4' ? 'selected' : '' ?>>4</option>
                                    <option value="5" <?= ($_POST['floors'] ?? '') === '5' ? 'selected' : '' ?>>5+</option>
                                </select>
                            </div>
                            <div class="input-group" style="display: block">
                                <label for="frontage">Mặt tiền (m)</label>
                                <input type="text" id="frontage" name="frontage" min="0" step="0.1" style="margin-top:0.43rem; padding: 0.75rem 1rem"
                                       placeholder="0" value="<?= $_POST['frontage'] ?? '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="direction">Hướng nhà</label>
                                <select id="direction" name="direction">
                                    <option value="Đông" <?= ($_POST['direction'] ?? '') === 'Đông' ? 'selected' : '' ?>>Đông</option>
                                    <option value="Tây" <?= ($_POST['direction'] ?? '') === 'Tây' ? 'selected' : '' ?>>Tây</option>
                                    <option value="Nam" <?= ($_POST['direction'] ?? '') === 'Nam' ? 'selected' : '' ?>>Nam</option>
                                    <option value="Bắc" <?= ($_POST['direction'] ?? '') === 'Bắc' ? 'selected' : '' ?>>Bắc</option>
                                    <option value="Đông Nam" <?= ($_POST['direction'] ?? '') === 'Đông Nam' ? 'selected' : '' ?>>Đông Nam</option>
                                    <option value="Đông Bắc" <?= ($_POST['direction'] ?? '') === 'Đông Bắc' ? 'selected' : '' ?>>Đông Bắc</option>
                                    <option value="Tây Nam" <?= ($_POST['direction'] ?? '') === 'Tây Nam' ? 'selected' : '' ?>>Tây Nam</option>
                                    <option value="Tây Bắc" <?= ($_POST['direction'] ?? '') === 'Tây Bắc' ? 'selected' : '' ?>>Tây Bắc</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="furniture">Nội thất</label>
                                <select id="furniture" name="furniture">
                                    <option value="none" <?= ($_POST['furniture'] ?? 'none') === 'none' ? 'selected' : '' ?>>Không có</option>
                                    <option value="basic" <?= ($_POST['furniture'] ?? '') === 'basic' ? 'selected' : '' ?>>Cơ bản</option>
                                    <option value="full" <?= ($_POST['furniture'] ?? '') === 'full' ? 'selected' : '' ?>>Đầy đủ</option>
                                </select>
                            </div>
                             <div class="form-group">
                                <label for="parking">Chỗ đậu xe</label>
                                <select id="parking" name="parking">
                                    <option value="0" <?= ($_POST['parking'] ?? '0') === '0' ? 'selected' : '' ?>>Không có</option>
                                    <option value="1" <?= ($_POST['parking'] ?? '') === '1' ? 'selected' : '' ?>>Có</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="submit_property" class="btn btn-primary">
                            <i class="fas fa-check"></i>
                            Đăng tin
                        </button>
                        <button type="button" class="btn btn-outline" onclick="history.back()">
                            <i class="fas fa-times"></i>
                            Hủy
                        </button>
                    </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</div>
    <script>
    document.getElementById('mainImage').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('mainImagePreview').src = ev.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('subImages').addEventListener('change', function(e) {
        const files = e.target.files;
        const previewContainer = document.getElementById('subImagesPreview');
        previewContainer.innerHTML = '';
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.style.width = '90px';
                    img.style.height = '90px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '8px';
                    img.style.border = '1px solid #e9ecef';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    });
    </script>