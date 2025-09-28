<main class="broker-detail">
    <section class="page-header">
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a>
            <span>/</span>
            <a href="index.php?act=listBroker">Môi giới</a>
            <span>/</span>
            <span><?= htmlspecialchars($broker['fullName']) ?></span>
        </div>
</section>
        <div class="broker-profile">
            <div class="broker-profile-header">
                <div class="broker-avatar-large">
                    <img src="<?= !empty($broker['avatar']) ? '../uploads/user/' . $broker['avatar'] : '../uploads/system/default_user.jpg'; ?>" 
                        alt="<?= htmlspecialchars($broker['fullName'] ?? 'Broker'); ?>">
                </div>
                <div class="broker-info">
                    <h1><?= htmlspecialchars($broker['fullName'] ?? 'Chưa có tên'); ?></h1>
                    <p class="broker-title">
                        <?= htmlspecialchars($broker['shortIntro'] ?? 'Chuyên viên tư vấn BĐS cao cấp'); ?></p>

                        <div style="display: flex; gap: 3rem; color: #e74c3c;">
                             <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                <p style="font-size: 1.5rem; font-weight: 600;"><i class="fas fa-phone"></i>
                                    <?= htmlspecialchars($broker['phoneNumber'] ?? 'Chưa có số điện thoại'); ?></p>
                                <?php }else{ ?>
                                <p style="font-size: 1.5rem; font-weight: 600;"><i class="fas fa-phone"></i>
                                    <?= substr($broker['phoneNumber'], 0, 7)?>***</p>
                                <?php } ?>
                                <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                <p style="font-size: 1.5rem; font-weight: 600;">   <i class="fas fa-envelope"></i>
                                    <?= htmlspecialchars($broker['email'] ?? 'Chưa có email'); ?></p>
                                <?php }else{ ?>
                                <p style="font-size: 1.5rem; font-weight: 600;">   <i class="fas fa-envelope"></i>
                                    ****@***.***</p>
                                <?php } ?>
                        </div>
                    <div class="broker-rating-large">
                        <div class="stars">
                            <?php
                            $rating = $ratingStats['avg_rating'] ? round($ratingStats['avg_rating'], 1) : 0;
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '<i class="fas fa-star"></i>';
                                } elseif ($i - 0.5 <= $rating) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                            ?>
                        </div>
                        <span><?= number_format($rating, 1); ?>/5 (<?= number_format($ratingStats['total_reviews']); ?> đánh giá)</span>
                    </div>
                    <div class="broker-meta">
                        <span><i class="fas fa-briefcase"></i> 
                            <?php 
                            $joinDate = new DateTime($broker['createdAt']);
                            $now = new DateTime();
                            $experience = $now->diff($joinDate)->y;
                            echo $experience > 0 ? $experience . ' năm kinh nghiệm' : 'Mới tham gia';
                            ?>
                        </span>
                        <span><i class="fas fa-calendar"></i> Tham gia từ 
                            <?= date('m/Y', strtotime($broker['createdAt'] ?? '2019-01-01')); ?></span>
                        <span><i class="fas fa-map-marker-alt"></i> 
                            <?= htmlspecialchars($broker['mainArea'] ?? 'TP. Hồ Chí Minh'); ?></span>
                    </div>
                    <div class="broker-languages">
                        <?php
                        $languages = !empty($broker['language']) ? explode(',', $broker['language']) : ['Tiếng Việt', 'English'];
                        foreach ($languages as $lang) {
                            echo '<span class="language-tag">' . htmlspecialchars(trim($lang)) . '</span>';
                        }
                        ?>
                    </div>
                </div>
                <div class="broker-actions">
                    <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                        <a href="tel:<?= htmlspecialchars($broker['phoneNumber']) ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-phone"></i>
                                              Gọi ngay
                                        </a>
                                        <?php }else{ ?>
                                        <button onclick="alert('Vui lòng đăng nhập để sử dụng chức năng này!')" class="btn btn-sm btn-primary" title="Vui lòng đăng nhập để liên hệ" style="background-color: #ccc;" title="Đăng nhập để gọi điện">
                                                                                <i class="fas fa-phone"></i> Gọi ngay
                                                                            </button>
                                        <?php } ?>
                      <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                        <a href="mailto:<?= htmlspecialchars($broker['email']) ?>" class="btn btn-outline btn-sm">
                                            <i class="fas fa-envelope"></i>
                                              Nhắn tin
                                        </a>
                                        <?php }else{ ?>
                                        <button onclick="alert('Vui lòng đăng nhập để sử dụng chức năng này!')"  class="btn btn-sm btn-primary" title="Vui lòng đăng nhập để liên hệ" style="background-color: #ccc;" title="Đăng nhập để gọi điện">
                                                                                <i class="fas fa-envelope"></i> Nhắn tin
                                                                            </button>
                                        <?php } ?>
                                        <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="broker_id" value="<?= $broker['id'] ?>">
                                            <button type="submit" name="follow-broker" class="btn <?= $broker['isFollowed'] ? 'btn-success' : 'btn-secondary' ?> btn-sm" style="border: 1px solid #e74c3c; <?= $broker['isFollowed'] ? 'font-size: 12px;' : '' ?>" title="<?= $broker['isFollowed'] ? 'Đang theo dõi - Click để bỏ theo dõi' : 'Theo dõi môi giới' ?>">
                                                    <i class="fas <?= $broker['isFollowed'] ? 'fa-user-check' : 'fa-plus' ?>"></i>  <?= $broker['isFollowed'] ? 'Đã theo dõi' : 'Theo dõi' ?>
                                                </button>
                                            </form>
                                        <?php }else{ ?>
                                        <button onclick="alert('Vui lòng đăng nhập để sử dụng chức năng này!')"  class="btn btn-sm btn-primary" title="Vui lòng đăng nhập để liên hệ" style="background-color: #ccc;" title="Đăng nhập để gọi điện">
                                                                                <i class="fas fa-plus"></i>Theo dõi
                                                                            </button>
                                        <?php } ?>
                </div>
            </div>
            <div class="broker-stats-detailed">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= number_format($propertyStats['active_properties']); ?></h3>
                        <p>BĐS đang bán/cho thuê</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= number_format($propertyStats['completed_deals']); ?></h3>
                        <p>Giao dịch thành công</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= number_format($ratingStats['total_reviews']); ?></h3>
                        <p>Khách hàng đánh giá</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="broker-details">
            <div class="detail-tabs">
                <button class="tab-btn active" data-tab="about">Giới thiệu</button>
                <button class="tab-btn" data-tab="properties">BĐS đăng bán</button>
                <button class="tab-btn" data-tab="reviews">Đánh giá</button>
            </div>

            <div class="tab-content active" id="about">
                <div class="about-content">
                    <div class="about-section">
                        <h3>Về tôi</h3>
                        <p><?= htmlspecialchars($broker['shortIntro']); ?></p>
                    </div>

                    <div class="about-section">
                        <h3>Chuyên môn</h3>
                        <div class="specialties-grid">
                            <?php if (!empty($brokerExpertises)): ?>
                                <?php foreach ($brokerExpertises as $expertise): ?>
                                    <div class="specialty-item">
                                        <i class="<?= htmlspecialchars($expertise['icon'] ?? 'fas fa-briefcase'); ?>"></i>
                                        <div>
                                            <h4><?= htmlspecialchars($expertise['name']); ?></h4>
                                            <p><?= htmlspecialchars($expertise['description'] ?? 'Chuyên tư vấn về lĩnh vực này'); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="specialty-item">
                                    <i class="fas fa-home"></i>
                                    <div>
                                        <h4>Bất động sản</h4>
                                        <p>Tư vấn chuyên nghiệp về bất động sản</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="about-section">
                        <h3>Khu vực hoạt động</h3>
                        <div class="areas-list">
                            <?php
                            $areas = !empty($broker['mainArea']) ? explode(',', $broker['mainArea']) : ['Quận 1', 'Quận 3', 'Quận 7', 'Bình Thạnh', 'Phú Nhuận'];
                            foreach ($areas as $area) {
                                echo '<span class="area-tag">' . htmlspecialchars(trim($area)) . '</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="properties">
                <div class="properties-section">
                    <div class="section-header">
                                                <h3>Bất động sản (<?= number_format($propertyStats['active_properties']); ?>)</h3>
                    </div>

                    <div class="broker-properties-grid">
                        <?php if (!empty($properties)) { ?>
                            <?php foreach ($properties as $property) { ?>
                                <div class="property-card">
                                    <div class="property-image">
                                        <img src="/placeholder.svg?height=200&width=300" alt="Căn hộ">
                                        <div class="property-badge"><?= htmlspecialchars($property['typeName'] ?? 'Chưa rõ'); ?></div>
                                        <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="property_id" value="<?= $property['id'] ?>">
                                                <button type="submit" name="save-property" class="save-btn <?= $property['isSaved'] ? 'saved' : '' ?>" title="<?= $property['isSaved'] ? 'Đã lưu - Click để bỏ lưu' : 'Lưu tin' ?>">
                                                    <i class="<?= $property['isSaved'] ? 'fas fa-heart' : 'far fa-heart' ?>"></i>
                                                </button>
                                            </form>
                                        <?php } ?>
                                    </div>
                                    <div class="property-info">
                                        <h3><a href="index.php?act=property&id=<?= htmlspecialchars($property['id'] ?? '0'); ?>"><?= htmlspecialchars($property['title'] ?? 'Chưa có tiêu đề'); ?></a></h3>
                                        <p class="location"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($property['locationName'] ?? 'Chưa rõ'); ?></p>
                                        <p class="price"><?= htmlspecialchars($property['description'] ?? ''); ?></p>
                                        <div class="property-features">
                                            <span><i class="fas fa-bed"></i> <?= htmlspecialchars($property['bedrooms'] ?? '0'); ?> phòng ngủ</span>
                                            <span><i class="fas fa-bath"></i> <?= htmlspecialchars($property['bathrooms'] ?? '0'); ?> phòng tắm</span>
                                            <span><i class="fas fa-expand-arrows-alt"></i> <?= htmlspecialchars($property['area'] ?? '0'); ?>m²</span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="reviews">
                <div class="reviews-section">
                    <div class="reviews-summary">
                        <div class="rating-overview">
                            <div class="rating-score">
                                <span class="score"><?= $ratingStats['avg_rating'] ? number_format($ratingStats['avg_rating'], 1) : '0.0' ?></span>
                                <div class="stars">
                                    <?php
                                    $rating = $ratingStats['avg_rating'] ? round($ratingStats['avg_rating'], 1) : 0;
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<i class="fas fa-star"></i>';
                                        } elseif ($i - 0.5 <= $rating) {
                                            echo '<i class="fas fa-star-half-alt"></i>';
                                        } else {
                                            echo '<i class="far fa-star"></i>';
                                        }
                                    }
                                    ?>
                                </div>
                                <p><?= number_format($ratingStats['total_reviews']) ?> đánh giá</p>
                            </div>
                            <div class="rating-breakdown">
                                <?php 
                                $totalReviews = $ratingStats['total_reviews'];
                                $ratings = [
                                    5 => $ratingStats['five_star'],
                                    4 => $ratingStats['four_star'],
                                    3 => $ratingStats['three_star'],
                                    2 => $ratingStats['two_star'],
                                    1 => $ratingStats['one_star']
                                ];
                                
                                for ($star = 5; $star >= 1; $star--) {
                                    $count = $ratings[$star] ?? 0;
                                    $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                ?>
                                <div class="rating-item">
                                    <span><?= $star ?> sao</span>
                                    <div class="rating-bar">
                                        <div class="rating-fill" style="width: <?= number_format($percentage, 1) ?>%"></div>
                                    </div>
                                    <span><?= $count ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                  <?php  if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                    <?php if(mysqli_num_rows($checkRating) > 0) { ?>
                        <form action="" method="post">
                             <button class="btn btn-primary" type="submit" name="delete-rating" style="background-color: red; border-color: red; margin-bottom: 0.5rem">
                            Xóa đánh giá
                        </button>
                        </form>
                        
                    <?php } else { ?>
                        <button class="btn btn-primary" id="add-review-btn" style="margin-bottom: 0.5rem">
                            <i class="fas fa-plus"></i>
                            Thêm đánh giá
                        </button>
                    <?php } ?>
                    <?php  }else { ?>
                        <button onclick="alert('Vui lòng đăng nhập để sử dụng chức năng này!')" class="btn btn-primary" style="background-color: gray; border-color: gray; margin-bottom: 0.5rem">
                            <i class="fas fa-plus"></i>
                            Thêm đánh giá
                        </button>
                    <?php } ?>
                    <div class="reviews-list">
                        <h1>Danh sách đánh giá</h1>
                        <?php foreach ($reviews as $review) { ?>
                        <div class="review-item" data-review-index="<?= $review['id'] ?>">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img <?php if(!empty($review['avatar'])){ echo 'src="../uploads/user/'.htmlspecialchars($review['avatar']).'?height=80&width=80"'; } else { echo 'src="../uploads/system/default_user.jpg?height=80&width=80"'; } ?> alt="Reviewer">
                                    <div>
                                        <h4><?= htmlspecialchars($review['fullName'] ?? 'Người dùng'); ?></h4>
                                    </div>
                                </div>
                                <div class="review-meta">
                                    <div class="stars">
                                        <?php
                                        $reviewRating = $review['rating'] ?? 0;
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $reviewRating) {
                                                echo '<i class="fas fa-star"></i>';
                                            } else {
                                                echo '<i class="far fa-star"></i>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <span><?= date('d/m/Y', strtotime($review['createdAt'] ?? '2024-01-01')); ?></span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p><?= htmlspecialchars($review['note'] ?? ''); ?></p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="add-review-section"> 
                        <div class="review-form-container" id="review-form-container" style="display: none;">
                            <div class="review-form-overlay">
                                <div class="review-form">
                                    <div class="form-header">
                                        <h3>Đánh giá môi giới</h3>
                                        <button class="close-form" id="close-review-form">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <form id="review-form" action="" method="post">
                                        <div class="form-group">
                                            <label>Đánh giá của bạn *</label>
                                            <div class="rating-input">
                                                <input type="radio" id="star5" name="rating" value="5" />
                                                <label for="star5" title="5 sao"><i class="fas fa-star"></i></label>
                                                <input type="radio" id="star4" name="rating" value="4" />
                                                <label for="star4" title="4 sao"><i class="fas fa-star"></i></label>
                                                <input type="radio" id="star3" name="rating" value="3" />
                                                <label for="star3" title="3 sao"><i class="fas fa-star"></i></label>
                                                <input type="radio" id="star2" name="rating" value="2" />
                                                <label for="star2" title="2 sao"><i class="fas fa-star"></i></label>
                                                <input type="radio" id="star1" name="rating" value="1" />
                                                <label for="star1" title="1 sao"><i class="fas fa-star"></i></label>
                                            </div>
                                        </div>                                  
                                        <div class="form-group">
                                            <label for="review-note">Nội dung đánh giá *</label>
                                            <textarea id="review-note" name="note" rows="4" required 
                                                placeholder="Chia sẻ trải nghiệm của bạn với môi giới này..."></textarea>
                                        </div>
                                        <div class="form-actions">
                                            <button type="button" class="btn btn-outline" id="cancel-review">Hủy</button>
                                            <button type="submit" class="btn btn-primary" name="submit-review">Gửi đánh giá</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
<?php if(count($reviews) > 3) { ?>
                    <div class="load-more-reviews" id="load-more-section">
                        <button class="btn btn-outline" id="load-more-btn">Xem thêm đánh giá</button>
                    </div>
<?php } ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="./views/js/brokerDetail.js"></script>