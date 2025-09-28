<div class="broker-page"><section class="page-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.php">Trang chủ</a>
                <span>/</span>
                <span>Môi giới</span>
            </div>
    </div>
</section>

<main class="main-content">
    <div class="container">
        <div class="content-layout">
            <aside class="sidebar">
                <form method="POST" id="filterForm">
                    <div class="filter-section">
                        <h3>Bộ lọc tìm kiếm</h3>
                        <div class="filter-group">
                            <label>Khu vực hoạt động</label>
                            <div class="collapsible-filter">
                                <div class="checkbox-group-grid">
                                    <?php
                                    $displayCount = 8;
                                    $location_display = array_slice($location, 0, $displayCount);
                                    $listLocation = array_slice($location, $displayCount);

                                    foreach ($location_display as $location) { ?>
                                        <label class="checkbox-item">
                                            <input type="checkbox" name="filter-area[]" value="<?= $location['id'] ?>"
                                                <?= (is_array($_SESSION['filter-area']) && in_array($location['id'], $_SESSION['filter-area'])) ? 'checked' : '' ?>>
                                            <span><?= htmlspecialchars($location['name']) ?></span>
                                        </label>
                                    <?php } ?>
                                </div>

                                <?php if (count($listLocation) > 0) { ?>
                                    <div class="more-options" style="display: none;">
                                        <div class="checkbox-group-grid">
                                            <?php foreach ($listLocation as $location) { ?>
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="filter-area[]" value="<?= $location['id'] ?>"
                                                        <?= (is_array($_SESSION['filter-area']) && in_array($location['id'], $_SESSION['filter-area'])) ? 'checked' : '' ?>>
                                                    <span><?= htmlspecialchars($location['name']) ?></span>
                                                </label>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <button type="button" class="show-more-btn" onclick="toggleMoreOptions(this)">
                                        <span class="show-text">Xem thêm (+<?= count($listLocation) ?>)</span>
                                        <span class="hide-text" style="display: none;">Thu gọn</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="filter-group">
                            <label>Chuyên môn</label>
                            <div class="checkbox-group">
                                <?php foreach ($expertises as $expertise) { ?>
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="filter-expertise[]" value="<?= $expertise['name'] ?>"
                                            <?= (is_array($_SESSION['filter-expertise']) && in_array($expertise['name'], $_SESSION['filter-expertise'])) ? 'checked' : '' ?>>
                                        <span>
                                            <?php if (!empty($expertise['icon'])) { ?>
                                                <i class="<?= $expertise['icon'] ?>"></i>
                                            <?php } ?>
                                            <?= htmlspecialchars($expertise['name']) ?>
                                        </span>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="filter-group">
                            <label>Ngôn ngữ</label>
                            <div class="checkbox-group">
                                <label class="checkbox-item">
                                    <input type="checkbox" name="filter-language[]" value="Tiếng Việt"
                                        <?= (is_array($_SESSION['filter-language']) && in_array('Tiếng Việt', $_SESSION['filter-language'])) ? 'checked' : '' ?>>
                                    <span>Tiếng Việt</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="filter-language[]" value="Tiếng Anh"
                                        <?= (is_array($_SESSION['filter-language']) && in_array('Tiếng Anh', $_SESSION['filter-language'])) ? 'checked' : '' ?>>
                                    <span>English</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" name="filter-language[]" value="Tiếng Trung"
                                        <?= (is_array($_SESSION['filter-language']) && in_array('Tiếng Trung', $_SESSION['filter-language'])) ? 'checked' : '' ?>>
                                    <span>中文</span>
                                </label>
                            </div>
                        </div>

                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            <button type="submit" name="clear-filter" class="btn btn-outline">Xóa bộ lọc</button>
                        </div>
                    </div>
                </form>
            </aside>

            <div class="content-area">
                <div class="content-header">
                    <div class="results-info">
                        <span>Tìm thấy <strong><?= $totalBrokers ?></strong> môi giới</span>
                    </div>
                    <div class="sort-options">
                        <label>Sắp xếp:</label>
                        <form method="POST" style="display: inline;">
                            <select class="form-select" name="sort-broker" onchange="this.form.submit()">
                                <option value="rating" <?= $_SESSION['sort-broker'] == 'rating' ? 'selected' : '' ?>>Đánh giá cao nhất</option>
                                <option value="experience" <?= $_SESSION['sort-broker'] == 'experience' ? 'selected' : '' ?>>Kinh nghiệm nhiều nhất</option>
                                <option value="newest" <?= $_SESSION['sort-broker'] == 'newest' ? 'selected' : '' ?>>Mới tham gia</option>
                            </select>
                        </form>
                    </div>
                </div>
                <?php unset($broker); ?>
                <div class="brokers-grid">
                    <?php foreach ($listBrokers as $broker) {
                        $experienceYears = date('Y') - date('Y', strtotime($broker['createdAt']));
                        if ($experienceYears == 0) $experienceYears = "Dưới 1";
                    ?>
                        <div class="broker-card-detailed">
                            <div class="broker-header">
                                <div class="broker-avatar">
                                    <img <?php if(!empty($broker['avatar'])) { echo 'src="../uploads/user/'.htmlspecialchars($broker['avatar']).'" alt="'.htmlspecialchars($broker['fullName']).'"'; } else { echo 'src="../uploads/system/default_user.jpg" alt="default_user"'; } ?>>
                                </div>
                                <div class="broker-basic-info">
                                    <h3><a href="index.php?act=broker&id=<?= $broker['id'] ?>"><?= htmlspecialchars($broker['fullName']) ?></a></h3>
                                    <p class="broker-title"><?= htmlspecialchars($broker['shortIntro']) ?></p>
                                    <div class="broker-rating">
                                        <div class="stars">
                                            <?php
                                            $currentRating = $broker['avg_rating'] ? round($broker['avg_rating']) : 0;
                                            for ($i = 1; $i <= 5; $i++) { ?>
                                                <i class="<?= $i <= $currentRating ? 'fas' : 'far' ?> fa-star"></i>
                                            <?php } ?>
                                        </div>
                                        <span><?= number_format($broker['avg_rating'], 1) ?>/5</span>
                                    </div>
                                    <div class="broker-experience">
                                        <i class="fas fa-briefcase"></i>
                                        <span><?= $experienceYears ?> năm kinh nghiệm</span>
                                    </div>
                                </div>
                                <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                <div class="broker-actions">
                                    <form action="" method="post">
                                        <input type="hidden" name="broker_id" value="<?= $broker['id'] ?>">
                                        <button type="submit" name="follow-broker" class="follow-btn <?= $broker['isFollowed'] ? 'followed' : '' ?>" title="<?= $broker['isFollowed'] ? 'Đang theo dõi - Click để bỏ theo dõi' : 'Theo dõi môi giới' ?>">
                                            <i class="fas <?= $broker['isFollowed'] ? 'fa-user-check' : 'fa-plus' ?>"></i>
                                        </button>
                                    </form>
                                </div>
                                <?php } ?>
                            </div>

                       <div class="broker-stats">
                                <div class="stat-item">
                                    <i class="fas fa-clock"></i>
                                    <div class="stat-info">
                                        <span class="stat-number">
                                            <?php 
                                            if (!empty($broker['workingHours'])) {
                                                echo htmlspecialchars($broker['workingHours']);
                                            } else {
                                                echo "Chưa có thông tin";
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div class="stat-info">
                                        <span class="stat-number">
                                            <?php 
                                            if (!empty($broker['mainArea'])) {
                                                echo htmlspecialchars($broker['mainArea']);
                                            } else {
                                                echo "Chưa có thông tin";
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-language"></i>
                                    <div class="stat-info">
                                        <span class="stat-number">
                                            <?php 
                                            if (!empty($broker['language'])) {
                                                echo htmlspecialchars($broker['language']);
                                            } else {
                                                echo "Chưa có thông tin";
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="broker-specialties">
                                <?php
                                $expertiseArray = explode(',', $broker['expertise']);
                                foreach ($expertiseArray as $expertise) {
                                    $expertise = trim($expertise);
                                    if (!empty($expertise)) {
                                ?>
                                        <span class="specialty-tag"><?= htmlspecialchars($expertise) ?></span>
                                <?php }
                                } ?>
                            </div>

                            <div class="broker-contact-info">
                                <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                    <span><?= htmlspecialchars($broker['phoneNumber']) ?></span>
                                    <?php } else { ?>
                                   <span><?= substr($broker['phoneNumber'], 0 , 7) ?>***</span>
                                    <?php } ?>
                                </div>
                                <div class="contact-item">  
                                    <i class="fas fa-envelope"></i>
                                    <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                    <span><?= htmlspecialchars($broker['email']) ?></span>
                                    <?php } else { ?>
                                    <span>****@***.***</span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="broker-footer">
                                  <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                        <a href="tel:<?= htmlspecialchars($broker['phoneNumber']) ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-phone"></i>
                                            Liên hệ
                                        </a>
                                        <?php }else{ ?>
                                        <button onclick="alert('Vui lòng đăng nhập để sử dụng chức năng này!')" class="btn btn-sm btn-primary" title="Vui lòng đăng nhập để liên hệ" style="padding: 0.475rem 1rem; background-color: #ccc;" title="Đăng nhập để gọi điện">
                                                                                <i class="fas fa-phone"></i> Liên hệ
                                                                            </button>
                                        <?php } ?>
                                         <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                        <a href="mailto:<?= htmlspecialchars($broker['email']) ?>" class="btn btn btn-outline btn-sm">
                                            <i class="fas fa-envelope"></i>
                                            Nhắn tin
                                        </a>
                                        <?php }else{ ?>
                                        <button onclick="alert('Vui lòng đăng nhập để sử dụng chức năng này!')" class="btn btn-sm btn btn-primary" title="Vui lòng đăng nhập để nhắn tin" style="padding: 0.475rem 1rem; background-color: #ccc;" title="Đăng nhập để gọi điện">
                                                                                <i class="fas fa-envelope"></i> Nhắn tin
                                                                            </button>
                                        <?php } ?>
                                <button class="btn btn-outline" onclick="window.location.href='index.php?act=broker&id=<?= $broker['id'] ?>'">
                                    <i class="fas fa-eye"></i>
                                    Xem chi tiết
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <?php if (empty($listBrokers)) { ?>
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <h3>Không tìm thấy môi giới nào</h3>
                        <p>Hãy thử thay đổi bộ lọc tìm kiếm</p>
                    </div>
                <?php } ?>

                <?php if ($total_page > 1) { ?>
                    <div class="pagination">
                        <?php if ($current_page > 1) { ?>
                            <a href="index.php?act=listBroker&page=<?= $current_page - 1 ?>" class="page-btn"><i class="fas fa-chevron-left"></i></a>
                        <?php } else { ?>
                            <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                        <?php } ?>

                        <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                            <?php if ($i == $current_page) { ?>
                                <button class="page-btn active"><?= $i ?></button>
                            <?php } else { ?>
                                <a href="index.php?act=listBroker&page=<?= $i ?>" class="page-btn"><?= $i ?></a>
                            <?php } ?>
                        <?php } ?>

                        <?php if ($current_page < $total_page) { ?>
                            <a href="index.php?act=listBroker&page=<?= $current_page + 1 ?>" class="page-btn"><i class="fas fa-chevron-right"></i></a>
                        <?php } else { ?>
                            <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main></div>

<script src="./views/js/listBroker.js"></script>