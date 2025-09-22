<main class="broker-detail">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a>
            <span>/</span>
            <a href="index.php?act=listBroker">Môi giới</a>
            <span>/</span>
            <span><?php echo htmlspecialchars($account['fullName'] ?? 'Chưa có tên'); ?></span>
        </div>

        <!-- broker Profile -->
        <div class="broker-profile">
            <div class="broker-profile-header">
                <div class="broker-avatar-large">
                    <img src="<?php echo !empty($account['avatar']) ? $account['avatar'] : '/placeholder.svg?height=150&width=150'; ?>"
                        alt="<?php echo htmlspecialchars($account['fullName'] ?? 'Broker'); ?>">
                    <div class="online-status"></div>
                    <div class="verified-badge">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                <div class="broker-info">
                    <h1><?php echo htmlspecialchars($account['fullName'] ?? 'Chưa có tên'); ?></h1>
                    <p class="broker-title">
                        <?php echo htmlspecialchars($broker['shortIntro'] ?? 'Chuyên viên tư vấn BĐS cao cấp'); ?></p>
                    <div class="broker-rating-large">
                        <div class="stars">
                            <?php
                            $rating = $broker['rate'] ?? 4.9;
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '<i class="fas fa-star"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                            ?>
                        </div>
                        <span><?php echo number_format($rating, 1); ?>/5 (127 đánh giá)</span>
                    </div>
                    <div class="broker-meta">
                        <span><i class="fas fa-briefcase"></i> 5 năm kinh nghiệm</span>
                        <span><i class="fas fa-calendar"></i> Tham gia từ
                            <?php echo date('Y', strtotime($account['createdAt'] ?? '2019-01-01')); ?></span>
                        <span><i class="fas fa-map-marker-alt"></i>
                            <?php echo htmlspecialchars($broker['mainArea'] ?? 'TP. Hồ Chí Minh'); ?></span>
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
                    <button class="btn btn-primary">
                        <i class="fas fa-phone"></i>
                        Gọi ngay
                    </button>
                    <button class="btn btn-outline">
                        <i class="fas fa-envelope"></i>
                        Nhắn tin
                    </button>
                    <button class="follow-btn">
                        <i class="fas fa-plus"></i>
                        Theo dõi
                    </button>
                </div>
            </div>

            <div class="broker-stats-detailed">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $propertyCount; ?>+</h3>
                        <p>Bất động sản đang bán</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="stat-content">
                        <h3>89</h3>
                        <p>Giao dịch thành công</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3>234</h3>
                        <p>Khách hàng hài lòng</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3>
                            < 2h</h3>
                                <p>Thời gian phản hồi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- broker Details -->
        <div class="broker-details">
            <div class="detail-tabs">
                <button class="tab-btn active" data-tab="about">Giới thiệu</button>
                <button class="tab-btn" data-tab="properties">BĐS đăng bán</button>
                <button class="tab-btn" data-tab="reviews">Đánh giá</button>
                <button class="tab-btn" data-tab="contact">Liên hệ</button>
            </div>

            <div class="tab-content active" id="about">
                <div class="about-content">
                    <div class="about-section">
                        <h3>Về tôi</h3>
                        <p><?php echo htmlspecialchars($broker['shortIntro']); ?></p>

                        <p>Với phương châm "Khách hàng là trung tâm", tôi luôn đặt lợi ích của khách hàng lên hàng đầu
                            và cam kết mang đến những dịch vụ tư vấn chuyên nghiệp, uy tín và hiệu quả nhất.</p>
                    </div>

                    <div class="about-section">
                        <h3>Chuyên môn</h3>
                        <div class="specialties-grid">
                            <div class="specialty-item">
                                <i class="fas fa-building"></i>
                                <div>
                                    <h4>Căn hộ cao cấp</h4>
                                    <p>Chuyên tư vấn các dự án căn hộ luxury, penthouse</p>
                                </div>
                            </div>
                            <div class="specialty-item">
                                <i class="fas fa-chart-line"></i>
                                <div>
                                    <h4>Đầu tư BĐS</h4>
                                    <p>Tư vấn đầu tư sinh lời, phân tích thị trường</p>
                                </div>
                            </div>
                            <div class="specialty-item">
                                <i class="fas fa-handshake"></i>
                                <div>
                                    <h4>Mua bán</h4>
                                    <p>Hỗ trợ thủ tục pháp lý, thương lượng giá</p>
                                </div>
                            </div>
                            <div class="specialty-item">
                                <i class="fas fa-home"></i>
                                <div>
                                    <h4>Cho thuê</h4>
                                    <p>Tìm kiếm khách thuê uy tín, quản lý tài sản</p>
                                </div>
                            </div>
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

                    <div class="about-section">
                        <h3>Chứng chỉ & Thành tích</h3>
                        <div class="achievements">
                            <div class="achievement-item">
                                <i class="fas fa-certificate"></i>
                                <span>Chứng chỉ hành nghề BĐS</span>
                            </div>
                            <div class="achievement-item">
                                <i class="fas fa-trophy"></i>
                                <span>Top 10 môi giới xuất sắc 2023</span>
                            </div>
                            <div class="achievement-item">
                                <i class="fas fa-medal"></i>
                                <span>Giải thưởng dịch vụ khách hàng</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="properties">
                <div class="properties-section">
                    <div class="section-header">
                        <h3>Bất động sản đang bán (<?php echo $propertyCount; ?>)</h3>
                        <div class="property-filters">
                            <select class="form-select">
                                <option value="all">Tất cả</option>
                                <option value="sale">Bán</option>
                                <option value="rent">Cho thuê</option>
                            </select>
                            <select class="form-select">
                                <option value="newest">Mới nhất</option>
                                <option value="price-low">Giá thấp đến cao</option>
                                <option value="price-high">Giá cao đến thấp</option>
                            </select>
                        </div>
                    </div>

                    <div class="broker-properties-grid">
                        <div class="property-card">
                            <div class="property-image">
                                <img src="/placeholder.svg?height=200&width=300" alt="Căn hộ">
                                <div class="property-badge">Cho thuê</div>
                                <button class="save-btn"><i class="far fa-heart"></i></button>
                            </div>
                            <div class="property-info">
                                <h3><a href="property-detail.html">Căn hộ cao cấp Vinhomes Central Park</a></h3>
                                <p class="location"><i class="fas fa-map-marker-alt"></i> Quận 1, TP.HCM</p>
                                <p class="price">25 triệu/tháng</p>
                                <div class="property-features">
                                    <span><i class="fas fa-bed"></i> 2 phòng ngủ</span>
                                    <span><i class="fas fa-bath"></i> 2 phòng tắm</span>
                                    <span><i class="fas fa-expand-arrows-alt"></i> 80m²</span>
                                </div>
                            </div>
                        </div>

                        <div class="property-card">
                            <div class="property-image">
                                <img src="/placeholder.svg?height=200&width=300" alt="Penthouse">
                                <div class="property-badge sale">Bán</div>
                                <button class="save-btn"><i class="far fa-heart"></i></button>
                            </div>
                            <div class="property-info">
                                <h3><a href="property-detail.html">Penthouse view sông Sài Gòn</a></h3>
                                <p class="location"><i class="fas fa-map-marker-alt"></i> Quận 2, TP.HCM</p>
                                <p class="price">15.8 tỷ</p>
                                <div class="property-features">
                                    <span><i class="fas fa-bed"></i> 3 phòng ngủ</span>
                                    <span><i class="fas fa-bath"></i> 3 phòng tắm</span>
                                    <span><i class="fas fa-expand-arrows-alt"></i> 150m²</span>
                                </div>
                            </div>
                        </div>

                        <div class="property-card">
                            <div class="property-image">
                                <img src="/placeholder.svg?height=200&width=300" alt="Căn hộ">
                                <div class="property-badge">Cho thuê</div>
                                <button class="save-btn"><i class="far fa-heart"></i></button>
                            </div>
                            <div class="property-info">
                                <h3><a href="property-detail.html">Căn hộ Landmark 81</a></h3>
                                <p class="location"><i class="fas fa-map-marker-alt"></i> Quận 1, TP.HCM</p>
                                <p class="price">45 triệu/tháng</p>
                                <div class="property-features">
                                    <span><i class="fas fa-bed"></i> 2 phòng ngủ</span>
                                    <span><i class="fas fa-bath"></i> 2 phòng tắm</span>
                                    <span><i class="fas fa-expand-arrows-alt"></i> 95m²</span>
                                </div>
                            </div>
                        </div>

                        <div class="property-card">
                            <div class="property-image">
                                <img src="/placeholder.svg?height=200&width=300" alt="Căn hộ">
                                <div class="property-badge sale">Bán</div>
                                <button class="save-btn"><i class="far fa-heart"></i></button>
                            </div>
                            <div class="property-info">
                                <h3><a href="property-detail.html">Căn hộ The Nassim Thảo Điền</a></h3>
                                <p class="location"><i class="fas fa-map-marker-alt"></i> Quận 2, TP.HCM</p>
                                <p class="price">8.2 tỷ</p>
                                <div class="property-features">
                                    <span><i class="fas fa-bed"></i> 2 phòng ngủ</span>
                                    <span><i class="fas fa-bath"></i> 2 phòng tắm</span>
                                    <span><i class="fas fa-expand-arrows-alt"></i> 78m²</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="view-all-properties">
                        <button class="btn btn-outline">Xem tất cả BĐS (150)</button>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="reviews">
                <div class="reviews-section">
                    <div class="reviews-summary">
                        <div class="rating-overview">
                            <div class="rating-score">
                                <span class="score">4.9</span>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p>127 đánh giá</p>
                            </div>
                            <div class="rating-breakdown">
                                <div class="rating-item">
                                    <span>5 sao</span>
                                    <div class="rating-bar">
                                        <div class="rating-fill" style="width: 85%"></div>
                                    </div>
                                    <span>108</span>
                                </div>
                                <div class="rating-item">
                                    <span>4 sao</span>
                                    <div class="rating-bar">
                                        <div class="rating-fill" style="width: 12%"></div>
                                    </div>
                                    <span>15</span>
                                </div>
                                <div class="rating-item">
                                    <span>3 sao</span>
                                    <div class="rating-bar">
                                        <div class="rating-fill" style="width: 2%"></div>
                                    </div>
                                    <span>3</span>
                                </div>
                                <div class="rating-item">
                                    <span>2 sao</span>
                                    <div class="rating-bar">
                                        <div class="rating-fill" style="width: 1%"></div>
                                    </div>
                                    <span>1</span>
                                </div>
                                <div class="rating-item">
                                    <span>1 sao</span>
                                    <div class="rating-bar">
                                        <div class="rating-fill" style="width: 0%"></div>
                                    </div>
                                    <span>0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="reviews-list">
                        <div class="review-item">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/placeholder.svg?height=50&width=50" alt="Reviewer">
                                    <div>
                                        <h4>Nguyễn Thị Mai</h4>
                                        <p>Khách hàng đã mua nhà</p>
                                    </div>
                                </div>
                                <div class="review-meta">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span>15/12/2024</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Anh An rất chuyên nghiệp và nhiệt tình. Đã hỗ trợ tôi tìm được căn hộ ưng ý với giá
                                    tốt. Thủ tục pháp lý được xử lý nhanh chóng và minh bạch. Rất hài lòng với dịch vụ!
                                </p>
                            </div>
                        </div>

                        <div class="review-item">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/placeholder.svg?height=50&width=50" alt="Reviewer">
                                    <div>
                                        <h4>Trần Văn Hùng</h4>
                                        <p>Khách hàng đầu tư</p>
                                    </div>
                                </div>
                                <div class="review-meta">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span>10/12/2024</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Tư vấn đầu tư rất chính xác và có tầm nhìn. Anh An đã giúp tôi chọn được những bất
                                    động sản có tiềm năng tăng giá tốt. Phản hồi nhanh, luôn sẵn sàng hỗ trợ 24/7.</p>
                            </div>
                        </div>

                        <div class="review-item">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/placeholder.svg?height=50&width=50" alt="Reviewer">
                                    <div>
                                        <h4>Lê Thị Hoa</h4>
                                        <p>Khách hàng cho thuê</p>
                                    </div>
                                </div>
                                <div class="review-meta">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span>05/12/2024</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Dịch vụ tốt, tìm được khách thuê nhanh chóng. Anh An rất am hiểu thị trường và biết
                                    cách định giá hợp lý. Sẽ tiếp tục hợp tác trong tương lai.</p>
                            </div>
                        </div>
                    </div>

                    <div class="load-more-reviews">
                        <button class="btn btn-outline">Xem thêm đánh giá</button>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="contact">
                <div class="contact-section">
                    <div class="contact-info-detailed">
                        <h3>Thông tin liên hệ</h3>
                        <div class="contact-methods">
                            <div class="contact-method">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>Điện thoại</h4>
                                    <p><?php echo htmlspecialchars($account['phone'] ?? '0901 234 567'); ?></p>
                                    <button class="btn btn-primary">Gọi ngay</button>
                                </div>
                            </div>
                            <div class="contact-method">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>Email</h4>
                                    <p><?php echo htmlspecialchars($account['email'] ?? 'nguyenvanan@email.com'); ?></p>
                                    <button class="btn btn-outline">Gửi email</button>
                                </div>
                            </div>
                            <div class="contact-method">
                                <div class="contact-icon">
                                    <i class="fab fa-zalo"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>Zalo</h4>
                                    <p>0901 234 567</p>
                                    <button class="btn btn-outline">Chat Zalo</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="contact-form-section">
                        <h3>Gửi tin nhắn</h3>
                        <form class="contact-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Họ và tên *</label>
                                    <input type="text" id="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Số điện thoại *</label>
                                    <input type="tel" id="phone" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email">
                            </div>
                            <div class="form-group">
                                <label for="subject">Chủ đề</label>
                                <select id="subject">
                                    <option value="">Chọn chủ đề</option>
                                    <option value="buy">Mua bất động sản</option>
                                    <option value="sell">Bán bất động sản</option>
                                    <option value="rent">Cho thuê</option>
                                    <option value="invest">Tư vấn đầu tư</option>
                                    <option value="other">Khác</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message">Tin nhắn *</label>
                                <textarea id="message" rows="5" required
                                    placeholder="Nhập nội dung tin nhắn..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi tin nhắn</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>