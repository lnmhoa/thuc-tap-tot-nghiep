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
                       <a href="?act=addProperty" class="menu-item">
                        <i class="fas fa-plus"></i>
                        <span>Thêm BĐS</span>
                    </a>
                      <a href="?act=contactRequest" class="menu-item active">
                        <i class="fas fa-envelope"></i>
                        <span>Liên hệ phân công</span>
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
                <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['role'] === '1' && $_SESSION['user']['status'] === 'active'): ?>
                    <a href="?act=consultationRequest" class="menu-item">
                        <i class="fas fa-comments"></i>
                        <span>Yêu cầu tư vấn</span>
                    </a>
                    <?php endif; ?>
                </nav>
            </aside>
            <div class="profile-content" style="padding: 2rem">
            <div class="form-section" style="margin-bottom: 0.5rem;">
                <h3 class="section-title" style="margin-bottom:0.5rem;">Thông tin liên hệ</h3>
            </div>
                <form method="POST" enctype="multipart/form-data" class="add-property-form" style="gap: 0">
                <div class="form-section" style="margin-bottom: 0">
                        <div class="form-grid" style="padding-bottom: 0">
                            <div class="input-group" style="display: block">
                                <label for="name">Họ tên người gửi <span class="required">*</span></label>
                                <input type="text" id="name" name="name" style="margin-top:0.43rem; padding: 0.75rem 1rem" required 
                                       value="<?= htmlspecialchars($detailsContactRequest['name'] ?? '') ?>">
                            </div>
                            <div class="input-group" style="display: block">
                                <label for="phone">Số điện thoại <span class="required">*</span></label>
                                <input type="text" id="phone" name="phone" style="margin-top:0.43rem; padding: 0.75rem 1rem" required 
                                       value="<?= htmlspecialchars($detailsContactRequest['phone'] ?? '') ?>">
                            </div>
                             <div class="input-group" style="display: block">
                                <label for="subject">Loại liên hệ <span class="required">*</span></label>
                                <input type="text" id="subject" name="subject" style="margin-top:0.43rem; padding: 0.75rem 1rem" required 
                                       value="<?= htmlspecialchars($detailsContactRequest['subject'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="location">Khu vực <span class="required">*</span></label>
                                <select id="location" name="location"  disabled>
                                    <?php foreach ($locations as $location): ?>
                                        <option value="<?= $location['id'] ?>" 
                                            <?= ($detailsContactRequest['location'] ?? '') == $location['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($location['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-group" style="display: block">
                                <label for="price">Giá mong muốn <span class="required">*</span></label>
                                <input type="text" id="price" name="price" required  style="margin-top:0.43rem; padding: 0.75rem 1rem" 
                                       placeholder="VD: 123 Nguyễn Văn Linh, Phường Tân Thuận Tây"
                                       value="<?= htmlspecialchars($detailsContactRequest['price'] ?? '') ?>">
                            </div>
                              <div class="form-group">
                                <label for="status">Trạng thái <span class="required">*</span></label>
                                 <select id="status" name="status" required>
                                    <option value="inProgress" <?= ($detailsContactRequest['status'] ?? 'inProgress') == 'inProgress' ? 'selected' : '' ?>>Đang xử lý</option>
                                    <option value="completed" <?= ($detailsContactRequest['status'] ?? 'completed') == 'completed' ? 'selected' : '' ?>>Đã hoàn thành</option>
                                    <option value="canceled" <?= ($detailsContactRequest['status'] ?? 'canceled') == 'canceled' ? 'selected' : '' ?>>Đã hủy</option>
                                </select>
                            </div>
                            <div class="form-group full-width" style="margin-bottom: 0;">
                                <label for="message">Nội dung <span class="required">*</span></label>
                                <textarea id="message" name="message" rows="4" required ><?= htmlspecialchars($detailsContactRequest['message'] ?? '') ?></textarea>
                            </div>
                             <div class="form-group full-width" style="margin-bottom: 0;">
                                <label for="note">Ghi chú</label>
                                <textarea id="note" name="note" rows="4" ><?= htmlspecialchars($detailsContactRequest['note'] ?? '') ?></textarea>
                            </div>
                            </div>
                        </div>
                    <div class="form-actions">
                        <?php if (($detailsContactRequest['status']) == 'inProgress') { ?>
                        <button type="submit" name="submit_contact" class="btn btn-primary">
                            <i class="fas fa-check"></i>
                            Cập nhật
                        </button>
                        <?php } ?>
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