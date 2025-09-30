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
                    <a href="?act=myProperty" class="menu-item active">
                        <i class="fas fa-home"></i>
                        <span>BĐS của tôi</span>
                    </a>
                       <a href="?act=addProperty" class="menu-item">
                        <i class="fas fa-plus"></i>
                        <span>Thêm BĐS</span>
                    </a>
                      <a href="?act=contactRequest" class="menu-item">
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
                <h3 class="section-title" style="margin-bottom:0.5rem;">Bất động sản đã lưu</h3>
                 <form method="POST" class="filter-actions" style="position: static; margin-bottom: 1rem;">
                        <div class="sort-options" style="position: absolute; top: 6.5rem; right: 8rem;">
                            <label for="sort">Sắp xếp:</label>
                            <select name="sort" id="sort" onchange="this.form.submit()">
                                <option value="desc" <?= $_SESSION['sort-my-property'] === 'desc' ? 'selected' : '' ?>>Mới nhất</option>
                                <option value="asc" <?= $_SESSION['sort-my-property'] === 'asc' ? 'selected' : '' ?>>Cũ nhất</option>
                            </select>
                        </div>
                    </form>
                 <div class="header-actions" style="position: absolute; top: 7rem; right: 31rem;">
                        <a href="?act=addProperty" class="btn btn-primary" style="padding: 0.2rem 1rem;">
                            <i class="fas fa-plus"></i>
                            Thêm BĐS mới
                        </a>
                    </div>
            </div>
                <?php if (!empty($myProperties)): ?>
                <div class="properties-grid">
                    <?php foreach ($myProperties as $property): ?>
                    <div class="property-card">
                        <div class="property-image">
                            <?php if (!empty($property['image'])): ?>
                                <img src="../uploads/property/<?= htmlspecialchars($property['image']) ?>" alt="<?= htmlspecialchars($property['title']) ?>">
                            <?php else: ?>
                                <img src="../uploads/system/default_property.jpg" alt="<?= htmlspecialchars($property['title']) ?>">
                            <?php endif; ?>
                            
                            <div class="property-status status-<?= $property['status'] ?>">
                                <?php
                                switch($property['status']) {
                                    case 'active': echo 'Còn trống'; break;
                                    case 'rented': echo 'Đã cho thuê'; break;
                                    case 'sold': echo 'Đã bán'; break;
                                    default: echo 'Không xác định';
                                }
                                ?>
                            </div>
                        </div>
                        
                        <div class="property-info">
                            <h3 class="property-title"><?= htmlspecialchars($property['title']) ?></h3>
                            <div class="property-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?= htmlspecialchars($property['locationName'] ?? 'Không xác định') ?></span>
                            </div>
                            <div class="property-details">
                                <div class="detail-item">
                                    <i class="fas fa-home"></i>
                                    <span><?= htmlspecialchars($property['typeName'] ?? 'Không xác định') ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-expand-arrows-alt"></i> 
                                    <span><?= number_format($property['area'], 1) ?> m²</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-bed"></i> 
                                    <span><?= $property['bedrooms'] ?> phòng ngủ</span>
                                </div>
                            </div>
                            
                            <div class="property-price"> 
                                <?= number_format($property['price']) ?> VNĐ
                                <small>/<?= $property['transactionType'] === 'rent' ? 'tháng' : 'tổng' ?></small>
                            </div>
                            
                            <div class="property-stats">
                                <div class="stat-item">
                                    <i class="fas fa-eye"></i> 
                                    <span><?= number_format($property['views']) ?> lượt xem</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-heart"></i> 
                                    <span><?= number_format($property['saveCount']) ?> lưu</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="property-actions">
                            <?php if ($property['status'] === 'active'){ ?>
                            <a href="?act=property&id=<?= $property['id'] ?>" class="btn btn-outline btn-sm">
                                <i class="fas fa-eye"></i>
                                Xem
                            </a>
                            <?php } else { ?>
                            <button class="btn btn-outline btn-sm">
                                <i class="fas fa-eye"></i>
                                Xem
                            </button>
                            <?php } ?>
                            <a href="?act=editProperty&id=<?= $property['id'] ?>" dis class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i>
                                Chỉnh sửa
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3>Chưa có bất động sản nào</h3>
                    <p>Bạn chưa đăng bất động sản nào. Hãy thêm BĐS đầu tiên của bạn!</p>
                    <a href="?act=addProperty" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Thêm BĐS đầu tiên
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
</div>