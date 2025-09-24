<div class="contact-page">
        <div class="contact-content">
            <div class="contact-grid">
                <div class="contact-form-section">
                    <div class="form-card">
                        <div class="form-header">
                            <h3><i class="fas fa-envelope"></i> Gửi Tin Nhắn</h3>
                            <p>Điền thông tin bên dưới và chúng tôi sẽ liên hệ lại với bạn</p>
                        </div>

                        <form method="POST" class="contact-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name"><i class="fas fa-user"></i> Họ và tên *</label>
                                    <input type="text" id="name" name="name" 
                                           value="<?php echo isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : ''; ?>" 
                                           required>
                                </div>
                                <div class="form-group">
                                    <label for="phone"><i class="fas fa-phone"></i> Số điện thoại *</label>
                                    <input type="tel" id="phone" name="phone" 
                                           value="<?php echo isset($_SESSION['form_data']['phone']) ? htmlspecialchars($_SESSION['form_data']['phone']) : ''; ?>" 
                                           required>
                                </div>
                            </div>

                       <div class="form-row">
                                    <div class="form-group">
                                        <label for="location"><i class="fas fa-map-marker-alt"></i> Khu vực *</label>
                                        <select id="location" name="location" required>
                                            <option value="">-- Chọn khu vực --</option>
                                            <?php foreach ($locations as $loc) { ?>
                                                <option value="<?= $loc['name'] ?>" 
                                                    <?= (isset($_SESSION['mainArea']['location']) && $_SESSION['mainArea']['location'] == $loc['name']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($loc['name']) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject"><i class="fas fa-tag"></i> Chủ đề *</label>
                                        <select id="subject" name="subject" required>
                                            <option value="">-- Chọn chủ đề --</option>
                                            <option value="Tư vấn mua bán">Tư vấn mua bán</option>
                                            <option value="Tư vấn cho thuê">Tư vấn cho thuê</option>
                                            <option value="Khiếu nại">Khiếu nại</option>
                                            <option value="Khác">Khác</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="price"><i class="fas fa-dollar-sign"></i> Giá mong muốn</label>
                                    <select id="price" name="price" required>
                                    <option value="">-- Chọn giá mong muốn --</option>
                                    <option value="Dưới 3 triệu">Dưới 3 triệu</option>
                                    <option value="3 - 5 triệu">3 - 5 triệu</option>
                                    <option value="5 - 8 triệu">5 - 8 triệu</option>
                                    <option value="Trên 8 triệu">Trên 8 triệu</option>
                                </select>
                             
                            </div>
                           
                            <div class="form-group">
                                <label for="message"><i class="fas fa-comment"></i> Nội dung tin nhắn *</label>
                                <textarea id="message" name="message" rows="6" 
                                          placeholder="Vui lòng mô tả chi tiết nhu cầu của bạn..." required><?php echo isset($_SESSION['form_data']['message']) ? htmlspecialchars($_SESSION['form_data']['message']) : ''; ?></textarea>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Gửi Tin Nhắn
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Làm Mới
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="contact-info-section">
                    <div class="info-card">
                        <div class="card-header">
                            <h3><i class="fas fa-building"></i> Thông Tin Công Ty</h3>
                        </div>
                        <div class="card-content">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-details">
                                    <strong>Địa chỉ</strong>
                                    <p>123 Nguyễn Huệ, Q1, TP.HCM</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-details">
                                    <strong>Điện thoại</strong>
                                    <p><a href="tel:1900 1234">1900 1234</a></p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-details">
                                    <strong>Email</strong>
                                    <p><a href="mailto:info@ehome.vn">info@ehome.vn</a></p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-details">
                                    <strong>Giờ làm việc</strong>
                                    <p>8:00 - 17:00</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="info-card emergency-card">
                        <div class="card-header">
                            <h3><i class="fas fa-phone-volume"></i> Hotline 24/7</h3>
                        </div>
                        <div class="card-content">
                            <div class="hotline-number">
                                <a href="tel:1900 1234">
                                    1900 1234
                                </a>
                            </div>
                            <p>Hỗ trợ khách hàng 24/7</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>