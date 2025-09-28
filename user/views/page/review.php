 <section class="page-header">
        <div class="container">
            <h1>Đánh giá chất lượng</h1>
            <p>Chia sẻ trải nghiệm của bạn về môi giới và bất động sản</p>
            <div class="breadcrumb">
                <a href="http://localhost/thuc-tap-tot-nghiep/user">Trang chủ</a>
                <span>/</span>
                <span>Đánh giá chất lượng</span>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="reviews-page">
        <div class="container">
            <div class="page-layout">
                <!-- Review Tabs -->
                <div class="review-tabs">
                    <button class="tab-btn active" data-tab="write-review">
                        <i class="fas fa-edit"></i>
                        Viết đánh giá
                    </button>
                    <button class="tab-btn" data-tab="my-reviews">
                        <i class="fas fa-star"></i>
                        Đánh giá của tôi
                    </button>
                    <button class="tab-btn" data-tab="received-reviews">
                        <i class="fas fa-comments"></i>
                        Đánh giá nhận được
                    </button>
                </div>

                <!-- Write Review Tab -->
                <div class="tab-content active" id="write-review">
                    <div class="review-form-container">
                        <div class="form-header">
                            <h2>Viết đánh giá mới</h2>
                            <p>Chia sẻ trải nghiệm của bạn để giúp cộng đồng</p>
                        </div>

                        <form class="review-form" id="reviewForm">
                            <!-- Review Type Selection -->
                            <div class="form-section">
                                <h3>Loại đánh giá</h3>
                                <div class="review-type-selection">
                                    <label class="type-card">
                                        <input type="radio" name="review_type" value="agent" checked>
                                        <div class="card-content">
                                            <i class="fas fa-user-tie"></i>
                                            <h4>Đánh giá môi giới</h4>
                                            <p>Đánh giá về dịch vụ và thái độ của môi giới</p>
                                        </div>
                                    </label>
                                    <label class="type-card">
                                        <input type="radio" name="review_type" value="property">
                                        <div class="card-content">
                                            <i class="fas fa-home"></i>
                                            <h4>Đánh giá bất động sản</h4>
                                            <p>Đánh giá về chất lượng và tiện ích của BĐS</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Agent Review Form -->
                            <div class="review-form-content" id="agent-review-form">
                                <div class="form-section">
                                    <h3>Thông tin môi giới</h3>
                                    <div class="search-agent">
                                        <div class="form-group">
                                            <label>Tìm kiếm môi giới</label>
                                            <div class="search-input">
                                                <input type="text" id="agentSearch" placeholder="Nhập tên hoặc mã môi giới">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </div>
                                        <div class="agent-suggestions" id="agentSuggestions">
                                            <!-- Agent suggestions will appear here -->
                                        </div>
                                        <div class="selected-agent" id="selectedAgent" style="display: none;">
                                            <div class="agent-info">
                                                <img src="/placeholder.svg?height=60&width=60" alt="Agent">
                                                <div class="agent-details">
                                                    <h4>Tên môi giới</h4>
                                                    <p>Mã: MB001</p>
                                                    <p>Công ty: ABC Real Estate</p>
                                                </div>
                                            </div>
                                            <button type="button" class="remove-btn">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h3>Đánh giá chi tiết</h3>
                                    <div class="rating-categories">
                                        <div class="rating-item">
                                            <label>Chuyên môn</label>
                                            <div class="star-rating" data-category="expertise">
                                                <i class="fas fa-star" data-rating="1"></i>
                                                <i class="fas fa-star" data-rating="2"></i>
                                                <i class="fas fa-star" data-rating="3"></i>
                                                <i class="fas fa-star" data-rating="4"></i>
                                                <i class="fas fa-star" data-rating="5"></i>
                                            </div>
                                        </div>
                                        <div class="rating-item">
                                            <label>Thái độ phục vụ</label>
                                            <div class="star-rating" data-category="service">
                                                <i class="fas fa-star" data-rating="1"></i>
                                                <i class="fas fa-star" data-rating="2"></i>
                                                <i class="fas fa-star" data-rating="3"></i>
                                                <i class="fas fa-star" data-rating="4"></i>
                                                <i class="fas fa-star" data-rating="5"></i>
                                            </div>
                                        </div>
                                        <div class="rating-item">
                                            <label>Tốc độ phản hồi</label>
                                            <div class="star-rating" data-category="response">
                                                <i class="fas fa-star" data-rating="1"></i>
                                                <i class="fas fa-star" data-rating="2"></i>
                                                <i class="fas fa-star" data-rating="3"></i>
                                                <i class="fas fa-star" data-rating="4"></i>
                                                <i class="fas fa-star" data-rating="5"></i>
                                            </div>
                                        </div>
                                        <div class="rating-item">
                                            <label>Độ tin cậy</label>
                                            <div class="star-rating" data-category="reliability">
                                                <i class="fas fa-star" data-rating="1"></i>
                                                <i class="fas fa-star" data-rating="2"></i>
                                                <i class="fas fa-star" data-rating="3"></i>
                                                <i class="fas fa-star" data-rating="4"></i>
                                                <i class="fas fa-star" data-rating="5"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="overall-rating">
                                        <label>Đánh giá tổng thể</label>
                                        <div class="star-rating large" data-category="overall">
                                            <i class="fas fa-star" data-rating="1"></i>
                                            <i class="fas fa-star" data-rating="2"></i>
                                            <i class="fas fa-star" data-rating="3"></i>
                                            <i class="fas fa-star" data-rating="4"></i>
                                            <i class="fas fa-star" data-rating="5"></i>
                                        </div>
                                        <span class="rating-text">Chưa đánh giá</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Property Review Form -->
                            <div class="review-form-content" id="property-review-form" style="display: none;">
                                <div class="form-section">
                                    <h3>Thông tin bất động sản</h3>
                                    <div class="search-property">
                                        <div class="form-group">
                                            <label>Tìm kiếm bất động sản</label>
                                            <div class="search-input">
                                                <input type="text" id="propertySearch" placeholder="Nhập tên hoặc địa chỉ BĐS">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </div>
                                        <div class="property-suggestions" id="propertySuggestions">
                                            <!-- Property suggestions will appear here -->
                                        </div>
                                        <div class="selected-property" id="selectedProperty" style="display: none;">
                                            <div class="property-info">
                                                <img src="/placeholder.svg?height=80&width=120" alt="Property">
                                                <div class="property-details">
                                                    <h4>Tên bất động sản</h4>
                                                    <p>Địa chỉ</p>
                                                    <p>Giá: 25 triệu/tháng</p>
                                                </div>
                                            </div>
                                            <button type="button" class="remove-btn">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h3>Đánh giá chi tiết</h3>
                                    <div class="rating-categories">
                                        <div class="rating-item">
                                            <label>Vị trí</label>
                                            <div class="star-rating" data-category="location">
                                                <i class="fas fa-star" data-rating="1"></i>
                                                <i class="fas fa-star" data-rating="2"></i>
                                                <i class="fas fa-star" data-rating="3"></i>
                                                <i class="fas fa-star" data-rating="4"></i>
                                                <i class="fas fa-star" data-rating="5"></i>
                                            </div>
                                        </div>
                                        <div class="rating-item">
                                            <label>Chất lượng xây dựng</label>
                                            <div class="star-rating" data-category="quality">
                                                <i class="fas fa-star" data-rating="1"></i>
                                                <i class="fas fa-star" data-rating="2"></i>
                                                <i class="fas fa-star" data-rating="3"></i>
                                                <i class="fas fa-star" data-rating="4"></i>
                                                <i class="fas fa-star" data-rating="5"></i>
                                            </div>
                                        </div>
                                        <div class="rating-item">
                                            <label>Tiện ích</label>
                                            <div class="star-rating" data-category="amenities">
                                                <i class="fas fa-star" data-rating="1"></i>
                                                <i class="fas fa-star" data-rating="2"></i>
                                                <i class="fas fa-star" data-rating="3"></i>
                                                <i class="fas fa-star" data-rating="4"></i>
                                                <i class="fas fa-star" data-rating="5"></i>
                                            </div>
                                        </div>
                                        <div class="rating-item">
                                            <label>Giá trị so với giá cả</label>
                                            <div class="star-rating" data-category="value">
                                                <i class="fas fa-star" data-rating="1"></i>
                                                <i class="fas fa-star" data-rating="2"></i>
                                                <i class="fas fa-star" data-rating="3"></i>
                                                <i class="fas fa-star" data-rating="4"></i>
                                                <i class="fas fa-star" data-rating="5"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="overall-rating">
                                        <label>Đánh giá tổng thể</label>
                                        <div class="star-rating large" data-category="overall">
                                            <i class="fas fa-star" data-rating="1"></i>
                                            <i class="fas fa-star" data-rating="2"></i>
                                            <i class="fas fa-star" data-rating="3"></i>
                                            <i class="fas fa-star" data-rating="4"></i>
                                            <i class="fas fa-star" data-rating="5"></i>
                                        </div>
                                        <span class="rating-text">Chưa đánh giá</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Review Content -->
                            <div class="form-section">
                                <h3>Nội dung đánh giá</h3>
                                <div class="form-group">
                                    <label for="reviewTitle">Tiêu đề đánh giá</label>
                                    <input type="text" id="reviewTitle" name="title" placeholder="Tóm tắt trải nghiệm của bạn">
                                </div>
                                <div class="form-group">
                                    <label for="reviewContent">Chi tiết đánh giá</label>
                                    <textarea id="reviewContent" name="content" rows="6" placeholder="Chia sẻ chi tiết về trải nghiệm của bạn..."></textarea>
                                    <div class="char-count">0/1000 ký tự</div>
                                </div>
                            </div>

                            <!-- Review Options -->
                            <div class="form-section">
                                <h3>Tùy chọn</h3>
                                <div class="review-options">
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="anonymous" value="1">
                                        <span>Đánh giá ẩn danh</span>
                                    </label>
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="recommend" value="1">
                                        <span>Tôi sẽ giới thiệu cho bạn bè</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-outline">
                                    <i class="fas fa-times"></i>
                                    Hủy
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i>
                                    Gửi đánh giá
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- My Reviews Tab -->
                <div class="tab-content" id="my-reviews">
                    <div class="reviews-header">
                        <h2>Đánh giá của tôi</h2>
                        <div class="reviews-stats">
                            <div class="stat-item">
                                <span class="number">12</span>
                                <span class="label">Tổng đánh giá</span>
                            </div>
                            <div class="stat-item">
                                <span class="number">4.5</span>
                                <span class="label">Điểm trung bình</span>
                            </div>
                        </div>
                    </div>

                    <div class="reviews-list">
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-target">
                                    <img src="/placeholder.svg?height=50&width=50" alt="Agent">
                                    <div class="target-info">
                                        <h4>Nguyễn Văn A</h4>
                                        <p>Môi giới bất động sản</p>
                                        <span class="review-type">Đánh giá môi giới</span>
                                    </div>
                                </div>
                                <div class="review-meta">
                                    <div class="rating">
                                        <div class="stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-number">5.0</span>
                                    </div>
                                    <span class="review-date">15/01/2024</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <h5>Dịch vụ tuyệt vời, rất chuyên nghiệp</h5>
                                <p>Anh A rất nhiệt tình và chuyên nghiệp. Đã giúp tôi tìm được căn hộ ưng ý trong thời gian ngắn. Rất hài lòng với dịch vụ.</p>
                            </div>
                            <div class="review-actions">
                                <button class="action-btn edit">
                                    <i class="fas fa-edit"></i>
                                    Chỉnh sửa
                                </button>
                                <button class="action-btn delete">
                                    <i class="fas fa-trash"></i>
                                    Xóa
                                </button>
                            </div>
                        </div>

                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-target">
                                    <img src="/placeholder.svg?height=50&width=75" alt="Property">
                                    <div class="target-info">
                                        <h4>Căn hộ Vinhomes Central Park</h4>
                                        <p>Quận 1, TP.HCM</p>
                                        <span class="review-type">Đánh giá BĐS</span>
                                    </div>
                                </div>
                                <div class="review-meta">
                                    <div class="rating">
                                        <div class="stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <span class="rating-number">4.0</span>
                                    </div>
                                    <span class="review-date">10/01/2024</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <h5>Căn hộ đẹp, vị trí thuận tiện</h5>
                                <p>Căn hộ có view đẹp, nội thất hiện đại. Vị trí gần trung tâm, đi lại thuận tiện. Tuy nhiên giá hơi cao so với mặt bằng chung.</p>
                            </div>
                            <div class="review-actions">
                                <button class="action-btn edit">
                                    <i class="fas fa-edit"></i>
                                    Chỉnh sửa
                                </button>
                                <button class="action-btn delete">
                                    <i class="fas fa-trash"></i>
                                    Xóa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Received Reviews Tab -->
                <div class="tab-content" id="received-reviews">
                    <div class="reviews-header">
                        <h2>Đánh giá nhận được</h2>
                        <div class="reviews-stats">
                            <div class="stat-item">
                                <span class="number">8</span>
                                <span class="label">Tổng đánh giá</span>
                            </div>
                            <div class="stat-item">
                                <span class="number">4.8</span>
                                <span class="label">Điểm trung bình</span>
                            </div>
                        </div>
                    </div>

                    <div class="reviews-list">
                        <div class="review-item received">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/placeholder.svg?height=50&width=50" alt="Reviewer">
                                    <div class="reviewer-details">
                                        <h4>Trần Thị B</h4>
                                        <p>Khách hàng</p>
                                    </div>
                                </div>
                                <div class="review-meta">
                                    <div class="rating">
                                        <div class="stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-number">5.0</span>
                                    </div>
                                    <span class="review-date">20/01/2024</span>
                                </div>
                            </div>
                            <div class="review-content">
                                <h5>Dịch vụ tuyệt vời</h5>
                                <p>Rất hài lòng với dịch vụ. Nhân viên nhiệt tình, chuyên nghiệp. Sẽ giới thiệu cho bạn bè.</p>
                            </div>
                            <div class="review-actions">
                                <button class="action-btn reply">
                                    <i class="fas fa-reply"></i>
                                    Phản hồi
                                </button>
                                <button class="action-btn report">
                                    <i class="fas fa-flag"></i>
                                    Báo cáo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>