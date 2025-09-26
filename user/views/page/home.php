<div class="home-container">
    <div class="hero-banner-wrapper">
        <section class="hero-section">
        <div class="hero-slider">
            <div class="hero-slide active">
                <img src="../1.jpg" alt="Tìm ngôi nhà mơ ước">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <div class="container">
                        <h1 class="hero-title">Tìm ngôi nhà mơ ước của bạn</h1>
                        <p class="hero-subtitle">Khám phá hàng nghìn bất động sản chất lượng cao với giá cả hợp lý</p>
                        <div class="hero-buttons">
                            <a href="?act=listProperty" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Khám phá ngay
                            </a>
                            <a href="?act=about" class="btn btn-secondary">
                                <i class="fas fa-info-circle"></i>
                                Tìm hiểu thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-slide">
                <img src="../2.png" alt="Đầu tư thông minh">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <div class="container">
                        <h1 class="hero-title">Đầu tư bất động sản thông minh</h1>
                        <p class="hero-subtitle">Cơ hội đầu tư sinh lời cao với đội ngũ chuyên gia tư vấn</p>
                        <div class="hero-buttons">
                            <a href="?act=listProperty" class="btn btn-primary">
                                <i class="fas fa-chart-line"></i>
                                Bắt đầu đầu tư
                            </a>
                            <a href="?act=contact" class="btn btn-secondary">
                                <i class="fas fa-handshake"></i>
                                Tư vấn miễn phí
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-slide">
                <img src="../3.jpg" alt="Đội ngũ chuyên nghiệp">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <div class="container">
                        <h1 class="hero-title">Đội ngũ môi giới chuyên nghiệp</h1>
                        <p class="hero-subtitle">Hỗ trợ tư vấn 24/7 từ các chuyên gia hàng đầu trong lĩnh vực BĐS</p>
                        <div class="hero-buttons">
                            <a href="?act=listBroker" class="btn btn-primary">
                                <i class="fas fa-users"></i>
                                Xem môi giới
                            </a>
                            <a href="?act=contact" class="btn btn-secondary">
                                <i class="fas fa-phone"></i>
                                Liên hệ ngay
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-dots">
            <span class="dot active" onclick="setHeroSlide(0)"></span>
            <span class="dot" onclick="setHeroSlide(1)"></span>
            <span class="dot" onclick="setHeroSlide(2)"></span>
        </div>
        </section>
    </div>
<section class="features-section">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>Tìm kiếm nhanh</h3>
                <p>Đội ngũ tư vấn viên chuyên nghiệp giúp tìm bất động sản phù hợp nhất với nhu cầu của bạn</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Giao dịch an toàn</h3>
                <p>Đảm bảo tính pháp lý và minh bạch trong mọi giao dịch bất động sản</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Hỗ trợ 24/7</h3>
                <p>Đội ngũ tư vấn viên chuyên nghiệp luôn sẵn sàng hỗ trợ bạn mọi lúc</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Phân tích thị trường</h3>
                <p>Cập nhật xu hướng và báo cáo thị trường bất động sản mới nhất</p>
            </div>
        </div>
    </div>
</section>

<section class="properties-section">
    <div class="container" style="padding: 0 20px;">
        <div class="section-header">
            <div class="section-title">
                <h2>Bất động sản nổi bật</h2>
                <p>Khám phá những bất động sản chất lượng cao được nhiều người quan tâm</p>
            </div>
            <a href="?act=listProperty" class="btn btn-outline">
                Xem tất cả
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="properties-carousel">
            <?php if (!empty($featuredProperties)) { 
                foreach ($featuredProperties as $property) { 
                    $images = json_decode($property['images'], true);
                    $firstImage = !empty($images) ? '../admin/uploads/rentalProperty/' . $images[0] : '../logo.jpg';
                    
                    $price = number_format($property['price'], 0, ',', '.') . ' ';
                    if ($property['transactionType'] == 'rent') {
                        $price .= ($property['priceUnit'] == 'month') ? 'đ/tháng' : 'đ';
                    } else {
                        $price .= 'đ';
                    }
            ?>
            <div class="property-card">
                <div class="property-image">
                    <img src="<?= $firstImage ?>" alt="<?= htmlspecialchars($property['title']) ?>" onerror="this.src='../logo.jpg'">
                    <div class="property-badge <?= $property['transactionType'] ?>">
                        <?= $property['transactionType'] == 'rent' ? 'Cho thuê' : 'Bán' ?>
                    </div>
                    <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                        <form action="" method="post">
                            <input type="hidden" name="property_id" value="<?= $property['id'] ?>">
                           <button type="submit" name="save-property" class="save-btn <?= $property['isSaved'] ? 'saved' : '' ?>" title="<?= $property['isSaved'] ? 'Đã lưu' : 'Lưu tin' ?>">
                                <i class="<?= $property['isSaved'] ? 'fas fa-heart' : 'far fa-heart' ?>"></i>
                            </button>
                        </form>
                    <?php } ?>
                </div>
                <div class="property-content">
                    <h3 class="property-title" onclick="window.location.href='?act=property&id=<?= $property['id'] ?>'"><?= htmlspecialchars($property['title']) ?></h3>
                    <p class="property-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <?= htmlspecialchars($property['locationName'] ?? $property['address']) ?>
                    </p>
                    <div class="property-price"><?= $price ?></div>
                    <div class="property-features">
                        <?php if ($property['bedrooms'] > 0) { ?>
                        <span><i class="fas fa-bed"></i> <?= $property['bedrooms'] ?> PN</span>
                        <?php } ?>
                        <?php if ($property['bathrooms'] > 0) { ?>
                        <span><i class="fas fa-bath"></i> <?= $property['bathrooms'] ?> WC</span>
                        <?php } ?>
                        <?php if ($property['area'] > 0) { ?>
                        <span><i class="fas fa-expand-arrows-alt"></i> <?= number_format($property['area'], 0) ?>m²</span>
                        <?php } ?>
                    </div>
                    <div class="property-meta">
                        <div class="property-views">
                            <i class="fas fa-eye"></i> <?= number_format($property['views']) ?> lượt xem
                        </div>
                        <div class="property-date">
                            <?php
                            $createdDate = new DateTime($property['createdAt']);
                            $now = new DateTime();
                            $interval = $now->diff($createdDate);
                            if ($interval->days == 0) {
                                echo "Hôm nay";
                            } elseif ($interval->days == 1) {
                                echo "1 ngày trước";
                            } else {
                                echo $interval->days . " ngày trước";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                } 
            } else { 
            ?>
            <div class="no-properties">
                <p>Chưa có bất động sản nào được đăng</p>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<section class="brokers-section">
    <div class="container" style="padding: 0 20px;">
        <div class="section-header">
            <div class="section-title">
                <h2>Môi giới uy tín</h2>
                <p>Đội ngũ môi giới chuyên nghiệp với kinh nghiệm và uy tín hàng đầu</p>
            </div>
            <a href="?act=listBroker" class="btn btn-outline">
                Xem tất cả
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="brokers-grid">
            <?php if (!empty($topBrokers)) { 
                foreach ($topBrokers as $broker) { 
                    $avatar = $broker['avatar'] ? '../admin/uploads/broker/' . $broker['avatar'] : '../logo.jpg';
                    $rating = $broker['avgRating'] ? number_format($broker['avgRating'], 1) : '0';
                    $ratingCount = $broker['ratingCount'] ? $broker['ratingCount'] : 0;
            ?>
            <div class="broker-card">
                <div class="broker-avatar">
                    <img src="<?= $avatar ?>" alt="<?= htmlspecialchars($broker['fullName']) ?>" onerror="this.src='../logo.jpg'">
                </div>
                <div class="broker-info">
                    <h3 class="broker-name" onclick="window.location.href='?act=broker&id=<?= $broker['id'] ?>'"><?= htmlspecialchars($broker['fullName']) ?></h3>
                    <p class="broker-title"><?= htmlspecialchars($broker['shortIntro'] ?? 'Chuyên viên tư vấn BĐS') ?></p>
                    <div class="broker-stats">
                        <div class="stat-item">
                            <i class="fas fa-home"></i>
                            <span><?= number_format($broker['propertyCount']) ?>+ BĐS</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-star"></i>
                            <span><?= $rating ?>/5 (<?= $ratingCount ?>)</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-handshake"></i>
                            <span><?= number_format($broker['dealCount']) ?>+ GD</span>
                        </div>
                    </div>
                    <div class="broker-actions">
                        <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != '') { ?>
                        <a href="tel:<?= htmlspecialchars($broker['phoneNumber']) ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-phone"></i> 
                            Liên hệ
                        </a>
                        <?php }else{ ?>
                        <button disabled  class="btn btn-sm btn-primary" title="Vui lòng đăng nhập để liên hệ" style="padding: 0.475rem 1rem; background-color: #ccc;" title="Đăng nhập để gọi điện">
                                                                <i class="fas fa-phone"></i> Liên hệ
                                                            </button>
                        <?php } ?>
                        <a href="?act=broker&id=<?= $broker['id'] ?>" class="btn btn-outline btn-sm">
                            <i class="fas fa-user"></i>
                            Xem hồ sơ
                        </a>
                    </div>
                </div>
            </div>
            <?php 
                } 
            } else { 
            ?>
            <div class="no-brokers">
                <p>Chưa có thông tin môi giới</p>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<section class="news-section">
    <div class="container" style="padding: 0 20px;">
        <div class="section-header">
            <div class="section-title">
                <h2>Tin tức bất động sản</h2>
                <p>Cập nhật những thông tin mới nhất về thị trường bất động sản</p>
            </div>
            <a href="?act=listNews" class="btn btn-outline">
                Xem tất cả
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="news-grid">
            <?php if (!empty($pinNewsHome)): ?>
            <article class="news-card featured">
                <div class="news-image">
                    <img src="../admin/uploads/news/<?= $pinNewsHome[0]['image'] ?>" alt="<?= ($pinNewsHome[0]['title']) ?>">
                    <div class="news-badge">Tin nổi bật</div>
                </div>
                <div class="news-content">
                    <div class="news-category"><?= ($pinNewsHome[0]['name']) ?></div>
                    <h3 class="news-title"><?= ($pinNewsHome[0]['title']) ?></h3>
                    <p class="news-excerpt"><?= strip_tags($pinNewsHome[0]['content']) ?></p>
                    <div class="news-meta">
                        <span class="news-date">
                            <i class="fas fa-calendar"></i>
                            <?= date('d/m/Y', strtotime($pinNewsHome[0]['createdAt'])) ?>
                        </span>
                        <span class="news-views">
                            <i class="fas fa-eye"></i>
                            <?= number_format($pinNewsHome[0]['views']) ?> lượt xem
                        </span>
                    </div>
                </div>
            </article>
            <?php endif; ?>
            
            <div class="news-list">
                <?php foreach ($listNewsHome as $news): ?>
                <article class="news-item">
                    <div class="news-info">
                        <h4 class="news-title"><div class="news-category small"><?= $news['name'] ?></div><?= $news['title'] ?></h4>
                        <p class="news-excerpt"><?= strip_tags($news['content']) ?></p>
                        <div class="news-meta">
                            <span class="news-date">
                                <i class="fas fa-calendar"></i>
                                <?= date('d/m/Y', strtotime($news['createdAt'])) ?>
                            </span>
                             <span class="news-views">
                            <i class="fas fa-eye"></i>
                            <?= number_format($news['views']) ?> lượt xem
                        </span>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<script src="./views/js/home.js"></script>