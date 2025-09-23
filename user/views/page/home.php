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
                            <a href="?act=consultationRequest" class="btn btn-secondary">
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
                            <a href="?act=consultationRequest" class="btn btn-secondary">
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
            <div class="property-card">
                <div class="property-image">
                    <img src="../4.webp" alt="Căn hộ cao cấp">
                    <div class="property-badge rent">Cho thuê</div>
                    <button class="save-btn" onclick="toggleSave(this)">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="property-content">
                    <h3 class="property-title">Căn hộ cao cấp Vinhomes Central Park</h3>
                    <p class="property-location">
                        <i class="fas fa-map-marker-alt"></i>
                        Quận Bình Thạnh, TP.HCM
                    </p>
                    <div class="property-price">25 triệu/tháng</div>
                    <div class="property-features">
                        <span><i class="fas fa-bed"></i> 2 PN</span>
                        <span><i class="fas fa-bath"></i> 2 WC</span>
                        <span><i class="fas fa-expand-arrows-alt"></i> 80m²</span>
                    </div>
                    <div class="property-meta">
                        <div class="property-views">
                            <i class="fas fa-eye"></i> 1,234 lượt xem
                        </div>
                        <div class="property-date">2 ngày trước</div>
                    </div>
                </div>
            </div>
            
            <div class="property-card">
                <div class="property-image">
                    <img src="../1.jpg" alt="Nhà phố">
                    <div class="property-badge sale">Bán</div>
                    <button class="save-btn" onclick="toggleSave(this)">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="property-content">
                    <h3 class="property-title">Nhà phố liền kề khu Sài Gòn South</h3>
                    <p class="property-location">
                        <i class="fas fa-map-marker-alt"></i>
                        Quận 7, TP.HCM
                    </p>
                    <div class="property-price">8.5 tỷ</div>
                    <div class="property-features">
                        <span><i class="fas fa-bed"></i> 4 PN</span>
                        <span><i class="fas fa-bath"></i> 3 WC</span>
                        <span><i class="fas fa-expand-arrows-alt"></i> 120m²</span>
                    </div>
                    <div class="property-meta">
                        <div class="property-views">
                            <i class="fas fa-eye"></i> 892 lượt xem
                        </div>
                        <div class="property-date">1 tuần trước</div>
                    </div>
                </div>
            </div>
            
            <div class="property-card">
                <div class="property-image">
                    <img src="../3.jpg" alt="Chung cư">
                    <div class="property-badge rent">Cho thuê</div>
                    <button class="save-btn" onclick="toggleSave(this)">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="property-content">
                    <h3 class="property-title">Chung cư Masteri Thảo Điền</h3>
                    <p class="property-location">
                        <i class="fas fa-map-marker-alt"></i>
                        Quận 2, TP.HCM
                    </p>
                    <div class="property-price">18 triệu/tháng</div>
                    <div class="property-features">
                        <span><i class="fas fa-bed"></i> 1 PN</span>
                        <span><i class="fas fa-bath"></i> 1 WC</span>
                        <span><i class="fas fa-expand-arrows-alt"></i> 55m²</span>
                    </div>
                    <div class="property-meta">
                        <div class="property-views">
                            <i class="fas fa-eye"></i> 567 lượt xem
                        </div>
                        <div class="property-date">3 ngày trước</div>
                    </div>
                </div>
            </div>
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
            <div class="broker-card">
                <div class="broker-avatar">
                    <img src="../admin/uploads/broker/688614ebb3040.png" alt="Môi giới" onerror="this.src='../logo.jpg'">
                </div>
                <div class="broker-info">
                    <h3 class="broker-name">Nguyễn Văn Minh</h3>
                    <p class="broker-title">Chuyên viên tư vấn BĐS</p>
                    <div class="broker-stats">
                        <div class="stat-item">
                            <i class="fas fa-home"></i>
                            <span>150+ BĐS</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-star"></i>
                            <span>4.8/5</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-handshake"></i>
                            <span>200+ GD</span>
                        </div>
                    </div>
                    <div class="broker-actions">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-phone"></i>
                            Liên hệ
                        </button>
                        <button class="btn btn-outline btn-sm">
                            <i class="fas fa-user-plus"></i>
                            Theo dõi
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="broker-card">
                <div class="broker-avatar">
                    <img src="../admin/uploads/broker/688615b882eef.png" alt="Môi giới" onerror="this.src='../logo.jpg'">
                </div>
                <div class="broker-info">
                    <h3 class="broker-name">Trần Thị Hương</h3>
                    <p class="broker-title">Chuyên gia đầu tư BĐS</p>
                    <div class="broker-stats">
                        <div class="stat-item">
                            <i class="fas fa-home"></i>
                            <span>200+ BĐS</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-star"></i>
                            <span>4.9/5</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-handshake"></i>
                            <span>350+ GD</span>
                        </div>
                    </div>
                    <div class="broker-actions">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-phone"></i>
                            Liên hệ
                        </button>
                        <button class="btn btn-outline btn-sm">
                            <i class="fas fa-user-plus"></i>
                            Theo dõi
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="broker-card">
                <div class="broker-avatar">
                    <img src="../admin/uploads/broker/68861612add95.png" alt="Môi giới" onerror="this.src='../logo.jpg'">
                </div>
                <div class="broker-info">
                    <h3 class="broker-name">Lê Văn Cường</h3>
                    <p class="broker-title">Chuyên viên cho thuê</p>
                    <div class="broker-stats">
                        <div class="stat-item">
                            <i class="fas fa-home"></i>
                            <span>120+ BĐS</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-star"></i>
                            <span>4.7/5</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-handshake"></i>
                            <span>180+ GD</span>
                        </div>
                    </div>
                    <div class="broker-actions">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-phone"></i>
                            Liên hệ
                        </button>
                        <button class="btn btn-outline btn-sm">
                            <i class="fas fa-user-plus"></i>
                            Theo dõi
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="broker-card">
                <div class="broker-avatar">
                    <img src="../admin/uploads/broker/6886164232e4f.png" alt="Môi giới" onerror="this.src='../logo.jpg'">
                </div>
                <div class="broker-info">
                    <h3 class="broker-name">Phạm Thị Lan</h3>
                    <p class="broker-title">Giám đốc kinh doanh</p>
                    <div class="broker-stats">
                        <div class="stat-item">
                            <i class="fas fa-home"></i>
                            <span>300+ BĐS</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-star"></i>
                            <span>5.0/5</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-handshake"></i>
                            <span>500+ GD</span>
                        </div>
                    </div>
                    <div class="broker-actions">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-phone"></i>
                            Liên hệ
                        </button>
                        <button class="btn btn-outline btn-sm">
                            <i class="fas fa-user-plus"></i>
                            Theo dõi
                        </button>
                    </div>
                </div>
            </div>
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