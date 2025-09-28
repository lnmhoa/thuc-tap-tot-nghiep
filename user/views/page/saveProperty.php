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
                            Thành viên
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
                    <a href="?act=brokerProperty" class="menu-item">
                        <i class="fas fa-home"></i>
                        <span>BĐS của tôi</span>
                    </a>
                    <?php endif; ?>
                    <a href="?act=saveProperty" class="menu-item active">
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
                <h3 class="section-title" style="margin-bottom:0.5rem;">Bất động sản đã lưu</h3>
                <div class="content-filters">
                    <div class="filter-actions">
                        <form method="POST" action="" class="sort-options">
                            <label>Sắp xếp theo:</label>
                            <select class="form-select" onchange="this.form.submit()" name="sort">
                                <option <?php if ($_SESSION['sort-property-profile'] === 'desc') echo 'selected'; ?> value="desc">Mới nhất</option>
                                <option <?php if ($_SESSION['sort-property-profile'] === 'asc') echo 'selected'; ?> value="asc">Cũ nhất</option>
                            </select>
                        </form>
                    </div>
                </div>
                </div>
                

                <div class="saved-properties-grid">
                    <?php foreach ($listSavedProperties as $property): ?>
                        <?php if($property['transactionType'] === 'rent'): ?>
                            <div class="saved-property-card" data-type="rent">
                        <?php else: ?>
                            <div class="saved-property-card" data-type="sale">
                        <?php endif; ?>
                            <div class="property-image">
                                <img src="<?php if(!empty($property['image'])) { echo '../uploads/system/' . $property['image']; } else { echo '../uploads/system/default_property.jpg'; } ?>" alt="<?= htmlspecialchars($property['title'] ?? 'Bất động sản') ?>">
                                <?php if($property['transactionType'] === 'rent'): ?>
                                <div class="property-badge rent">Cho thuê</div>
                                <?php else: ?>
                                <div class="property-badge sale">Bán</div>
                                <?php endif; ?>
                                <div class="save-date">
                                    <i class="fas fa-calendar"></i>
                                    <?= date('d/m/Y', strtotime($property['createdAt'])); ?>
                                </div>
                            </div>
                            <div class="property-content">
                                <h3 class="property-title" onclick="location.href='?act=property&id=<?= $property['id'] ?>'" style="cursor: pointer;"><?= htmlspecialchars($property['title'] ?? 'Bất động sản') ?></h3>
                                <p class="property-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?= htmlspecialchars($property['address'] ?? 'Địa chỉ không xác định') ?>
                                </p>
                                <div class="property-price"><?= number_format($property['price'], 0, ',', '.') ?> <?php if(($property['transactionType'] === 'rent')){echo 'vnđ/tháng';}else{echo 'vnđ';} ?></div>
                                <div class="property-features">
                                    <span><i class="fas fa-bed"></i> 2 PN</span>
                                    <span><i class="fas fa-bath"></i> 2 WC</span>
                                    <span><i class="fas fa-expand-arrows-alt"></i> 80m²</span>
                                </div>
                                <div class="property-status">
                                    <span class="status available">
                                        <i class="fas fa-check-circle"></i>
                                        Còn trống
                                    </span>
                                </div>
                                <div class="property-actions-bottom">
                                    <a href="?act=property&id=1" class="btn btn-outline btn-sm">
                                        <i class="fas fa-eye"></i>
                                        Xem chi tiết
                                    </a>
                                    <a href="?act=broker&id=<?= $property['brokerId'] ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-phone"></i>
                                        Liên hệ
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (empty($listSavedProperties)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-heart-broken"></i>
                        </div>
                        <h3>Chưa có BĐS đã lưu</h3>
                        <p>Bạn chưa lưu bất động sản nào. Hãy khám phá và lưu những BĐS yêu thích!</p>
                        <a href="?act=listProperty" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Khám phá BĐS
                        </a>
                    </div>
                <?php endif; ?>
                </div>
        </div>
    </div>
</main>