<div class="user-profile-wrapper">
    <main class="profile-main">
        <div class="container">
            <div class="profile-layout">
                
               <aside class="profile-sidebar">
                <div class="profile-user-card">
                    <div class="user-avatar">
                        <?php if (isset($_SESSION['user']['avatar']) && !empty($_SESSION['user']['avatar'])): ?>
                            <img src="./uploads/avatar/<?= $_SESSION['user']['avatar'] ?>" alt="Avatar">
                        <?php else: ?>
                            <img src="../logo.jpg" alt="Default Avatar">
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
                    <a href="?act=saveProperty" class="menu-item">
                        <i class="fas fa-heart"></i>
                        <span>BĐS đã lưu</span>
                    </a>
                    <!-- <a href="?act=userRentals" class="menu-item">
                        <i class="fas fa-history"></i>
                        <span>Lịch sử thuê</span>
                    </a> -->
                    <a href="?act=followBroker" class="menu-item active">
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
                <h3 class="section-title" style="margin-bottom:0.5rem;">Môi giới đang theo dõi</h3>
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

                 <div class="saved-broker-grid">
                    <?php if (!empty($listFollowedBrokers)): ?>
                        <?php foreach ($listFollowedBrokers as $broker): ?>
                            <div class="saved-broker-card" data-type="broker" >
                                <div class="broker-image">
                                    <img src="<?= htmlspecialchars($broker['avatar']) ?>" alt="<?= htmlspecialchars($broker['brokerName']) ?>" onerror="this.src='../logo.jpg'">
                                    <div class="broker-badge broker">Môi giới</div>
                                    <div class="broker-actions">
                                           <form action="" method="post">
                                                <input type="hidden" name="broker_id" value="<?= $broker['brokerId'] ?>" >
                                            <button type="submit" name="follow-broker" class="action-btn saved" title="Bỏ theo dõi">
                                                    <i class="fas fa-user-minus"></i>
                                                </button>
                                            </form>
                                    </div>
                                </div>
                                <div class="broker-details">
                                    <div class="broker-title">
                                        <h3><?= htmlspecialchars($broker['brokerName']) ?></h3>
                                    </div>
                                    <p class="broker-location">
                                        <i class="fas fa-briefcase"></i>
                                        <?= htmlspecialchars($broker['mainArea']) ?>
                                    </p>
                                     <p class="broker-location">
                                        <i class="fas fa-calendar"></i>
                                        <?= htmlspecialchars($broker['brokerExpertise']) ?>
                                    </p>
                                     <p class="broker-location">
                                        <i class="fas fa-language"></i>
                                        <?= htmlspecialchars($broker['brokerLanguage']) ?>
                                    </p>

                                    <div class="broker-price">
                                        <span class="follow-date">
                                            <i class="fas fa-calendar"></i>
                                            Theo dõi từ <?= $broker['createdAt'] ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="broker-contact">
                                    <button class="btn btn-primary btn-sm" onclick="window.location.href='?act=broker&id=<?= $broker['brokerId'] ?>'">
                                        <i class="fas fa-phone"></i>
                                        Liên hệ
                                    </button>
                                    <a href="?act=broker&id=<?= $broker['brokerId'] ?>" class="btn btn-outline btn-sm">
                                        <i class="fas fa-home"></i>
                                        Xem BĐS
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state" style="width:207%">
                            <div class="empty-icon">
                                <i class="fas fa-heart-broken"></i>
                            </div>
                            <h3>Chưa theo dõi môi giới nào</h3>
                            <p>Bạn chưa theo dõi môi giới nào. Hãy khám phá và theo dõi những môi giới yêu thích!</p>
                            <a href="?act=listBroker" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Khám phá môi giới
                            </a>
                        </div>
                    <?php endif; ?>
                    </div>
            </div>
        </div>
    </main>
</div>