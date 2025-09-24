<main class="broker-detail">
    <section class="page-header">
        <div class="breadcrumb">
            <a href="index.php">Trang chủ</a>
            <span>/</span>
            <a href="index.php?act=listBroker">Môi giới</a>
            <span>/</span>
            <span><?= htmlspecialchars($account['fullName']) ?></span>
        </div>
</section>

        <div class="broker-profile">
            <div class="broker-profile-header">
                <div class="broker-avatar-large">
                    <img src="<?= !empty($account['avatar']) ? $account['avatar'] : '/placeholder.svg?height=150&width=150'; ?>"
                        alt="<?= htmlspecialchars($account['fullName'] ?? 'Broker'); ?>">

                </div>
                <div class="broker-info">
                    <h1><?= htmlspecialchars($account['fullName'] ?? 'Chưa có tên'); ?></h1>
                    <p class="broker-title">
                        <?= htmlspecialchars($broker['shortIntro'] ?? 'Chuyên viên tư vấn BĐS cao cấp'); ?></p>
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
                        <span><?= number_format($rating, 1); ?>/5 (127 đánh giá)</span>
                    </div>
                    <div class="broker-meta">
                        <span><i class="fas fa-briefcase"></i> 5 năm kinh nghiệm</span>
                        <span><i class="fas fa-calendar"></i> Tham gia từ
                            <?= date('Y', strtotime($account['createdAt'] ?? '2019-01-01')); ?></span>
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
                    <button class="btn btn-primary">
                        <i class="fas fa-phone"></i>
                        Gọi ngay
                    </button>
                    <button class="btn btn-outline">
                        <i class="fas fa-envelope"></i>
                        Nhắn tin
                    </button>
                    <button class="btn btn-secondary btn-follow">
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
                        <h3><?= $propertyCount; ?>+</h3>
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
                        <h3>Bất động sản (<?= $propertyCount; ?>)</h3>
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
                        <button class="btn btn-primary" id="add-review-btn" style="margin-bottom: 0.5rem">
                            <i class="fas fa-plus"></i>
                            Thêm đánh giá
                        </button>
                    <div class="reviews-list">
                        <h1>Danh sách đánh giá</h1>
                        <div class="review-item" data-review-index="1">
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

                        <div class="review-item" data-review-index="2">
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

                        <div class="review-item" data-review-index="3">
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
                        
                        <!-- Hidden reviews - Review 4 -->
                        <div class="review-item hidden-review" data-review-index="4" style="display: none;">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/placeholder.svg?height=50&width=50" alt="Reviewer">
                                    <div>
                                        <h4>Phạm Minh Tuấn</h4>
                                        <p>Khách hàng mua căn hộ</p>
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
                                    <span>02/12/2024</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Rất hài lòng với dịch vụ tư vấn. Anh An đã giúp tôi tìm được căn hộ phù hợp với ngân sách 
                                và yêu cầu. Quá trình giao dịch diễn ra thuận lợi và minh bạch.</p>
                            </div>
                        </div>

                        <!-- Review 5 -->
                        <div class="review-item hidden-review" data-review-index="5" style="display: none;">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/placeholder.svg?height=50&width=50" alt="Reviewer">
                                    <div>
                                        <h4>Võ Thị Lan</h4>
                                        <p>Khách hàng bán nhà</p>
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
                                    <span>28/11/2024</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Anh An hỗ trợ bán nhà rất tốt, tìm được khách mua nhanh chóng với giá hợp lý. 
                                Thái độ phục vụ chuyên nghiệp, luôn cập nhật tình hình thị trường.</p>
                            </div>
                        </div>

                        <!-- Review 6 -->
                        <div class="review-item hidden-review" data-review-index="6" style="display: none;">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/placeholder.svg?height=50&width=50" alt="Reviewer">
                                    <div>
                                        <h4>Nguyễn Văn Đức</h4>
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
                                    <span>25/11/2024</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Tư vấn đầu tư bất động sản rất chi tiết và chính xác. Anh An có kinh nghiệm và hiểu biết sâu 
                                về thị trường, giúp tôi đưa ra quyết định đầu tư đúng đắn.</p>
                            </div>
                        </div>

                        <!-- Review 7 -->
                        <div class="review-item hidden-review" data-review-index="7" style="display: none;">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/placeholder.svg?height=50&width=50" alt="Reviewer">
                                    <div>
                                        <h4>Trần Thị Kim</h4>
                                        <p>Khách hàng thuê văn phòng</p>
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
                                    <span>20/11/2024</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Dịch vụ tư vấn thuê văn phòng tốt, tìm được địa điểm phù hợp với nhu cầu kinh doanh. 
                                Giá cả hợp lý và thủ tục nhanh gọn.</p>
                            </div>
                        </div>

                        <!-- Review 8 -->
                        <div class="review-item hidden-review" data-review-index="8" style="display: none;">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/placeholder.svg?height=50&width=50" alt="Reviewer">
                                    <div>
                                        <h4>Lê Minh Hoàng</h4>
                                        <p>Khách hàng mua đất</p>
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
                                    <span>18/11/2024</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Anh An tư vấn mua đất rất chi tiết, từ pháp lý đến tiềm năng phát triển. 
                                Nhờ tư vấn của anh mà tôi mua được lô đất có vị trí tốt với giá hợp lý.</p>
                            </div>
                        </div>

                        <!-- Review 9 -->
                        <div class="review-item hidden-review" data-review-index="9" style="display: none;">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/placeholder.svg?height=50&width=50" alt="Reviewer">
                                    <div>
                                        <h4>Phạm Thị Nga</h4>
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
                                    <span>15/11/2024</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Hỗ trợ cho thuê căn hộ rất tốt, tìm được khách thuê uy tín nhanh chóng. 
                                Anh An rất nhiệt tình và chu đáo trong quá trình hỗ trợ.</p>
                            </div>
                        </div>

                        <!-- Review 10 -->
                        <div class="review-item hidden-review" data-review-index="10" style="display: none;">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/placeholder.svg?height=50&width=50" alt="Reviewer">
                                    <div>
                                        <h4>Đặng Văn Long</h4>
                                        <p>Khách hàng mua biệt thự</p>
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
                                    <span>12/11/2024</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Dịch vụ tư vấn mua biệt thự xuất sắc! Anh An hiểu rõ nhu cầu và tìm được căn biệt thự 
                                hoàn hảo cho gia đình tôi. Quá trình giao dịch minh bạch và chuyên nghiệp.</p>
                            </div>
                        </div>
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
                                    
                                    <form id="review-form">
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
                                            <label for="review-content">Nội dung đánh giá *</label>
                                            <textarea id="review-content" name="content" rows="4" required 
                                                placeholder="Chia sẻ trải nghiệm của bạn với môi giới này..."></textarea>
                                        </div>
                                        
                                        <div class="form-actions">
                                            <button type="button" class="btn btn-outline" id="cancel-review">Hủy</button>
                                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="load-more-reviews" id="load-more-section">
                        <button class="btn btn-outline" id="load-more-btn">Xem thêm đánh giá</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="./views/js/brokerDetail.js"></script>