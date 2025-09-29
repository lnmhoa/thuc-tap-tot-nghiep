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
                    <a href="?act=profile" class="menu-item active">
                        <i class="fas fa-user"></i>
                        <span>Thông tin cá nhân</span>
                    </a>
                    <a href="?act=changePassword" class="menu-item">
                        <i class="fas fa-lock"></i>
                        <span>Đổi mật khẩu</span>
                    </a>
                    <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['role'] === '2' && $_SESSION['user']['status'] === 'active'): ?>
                    <a href="?act=myProperty" class="menu-item">
                        <i class="fas fa-home"></i>
                        <span>BĐS của tôi</span>
                    </a>
                    <?php endif; ?>
                    <a href="?act=saveProperty" class="menu-item">
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
            <div class="profile-content">
                <div class="profile-form-container">
                    <form method="POST" enctype="multipart/form-data" class="profile-form">
                        <div class="form-section">
                            <h3>Ảnh đại diện</h3>
                            <div class="avatar-upload">
                                <div class="avatar-preview">
                                    <?php if (!empty($_SESSION['user']['avatar'])): ?>
                                        <img src="../uploads/user/<?= $_SESSION['user']['avatar'] ?>" alt="Avatar" id="avatarDisplay">
                                    <?php else: ?>
                                        <img src="../uploads/system/default_user.jpg" alt="Default Avatar" id="avatarDisplay">
                                    <?php endif; ?>
                                    <div class="upload-overlay">
                                        <i class="fas fa-camera"></i>
                                        <span>Thay đổi</span>
                                    </div>
                                </div>
                                <input type="file" id="avatar" name="avatar" accept="image/jpg, image/png" hidden>
                                <div class="upload-info">
                                    <p>Tải lên ảnh đại diện mới</p>
                                    <small>Định dạng: JPG, PNG. Kích thước tối đa: 5MB</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-section">
                            <h3>Thông tin cá nhân</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="fullName">Họ và tên <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-user"></i>
                                        <input type="text" id="fullName" name="fullName" 
                                               value="<?= htmlspecialchars($_SESSION['user']['fullName'] ?? '') ?>" 
                                               required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-envelope"></i>
                                        <input type="email" id="email" name="email" 
                                               value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phoneNumber">Số điện thoại <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-phone"></i>
                                        <input type="tel" id="phoneNumber" required name="phoneNumber" 
                                               value="<?= htmlspecialchars($_SESSION['user']['phoneNumber'] ?? '') ?>">
                                    </div>
                                </div>
                                <?php if($_SESSION['user']['role'] != 1){ ?>
                                <div class="form-group">
                                    <label for="location">Khu vực <span class="required">*</span></label>
                                    <select id="location" name="location" required>
                                        <?php if (!empty($listLocation)): ?>
                                            <?php foreach ($listLocation as $location): ?>
                                                <option value="<?= htmlspecialchars($location['id']) ?>" 
                                                    <?= (isset($_SESSION['user']['broker_info']['location']) && $_SESSION['user']['broker_info']['location'] == $location['id']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($location['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                              <div class="form-group">
                                <label for="language">Ngôn ngữ <span class="required">*</span></label>
                                <select name="language[]" id="language" multiple size="2" required>
                                    <?php
                                    $selectedLanguages = [];
                                    if (isset($_SESSION['user']['broker_info']['language']) && !empty($_SESSION['user']['broker_info']['language'])) {
                                        $selectedLanguages = array_map('trim', explode(',', $_SESSION['user']['broker_info']['language']));
                                    }
                                    
                                    $allLanguages = ['Tiếng Việt', 'Tiếng Anh', 'Tiếng Trung'];
                                    foreach ($allLanguages as $language):
                                    ?>
                                        <option value="<?= htmlspecialchars($language) ?>" 
                                            <?= in_array($language, $selectedLanguages) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($language) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="expertise">Kinh nghiệm lĩnh vực <span class="required">*</span></label>
                                <select id="expertise" name="expertise[]" required multiple size="2">
                                    <?php 
                                    $selectedExpertises = [];
                                    if (isset($_SESSION['user']['broker_info']['expertise']) && !empty($_SESSION['user']['broker_info']['expertise'])) {
                                        $selectedExpertises = array_map('trim', explode(',', $_SESSION['user']['broker_info']['expertise']));
                                    }
                                    
                                    if (!empty($listExpertises)): 
                                        foreach ($listExpertises as $expertise): 
                                            $is_selected = in_array($expertise['name'], $selectedExpertises); 
                                    ?>
                                            <option value="<?= htmlspecialchars($expertise['name']) ?>" 
                                                <?= $is_selected ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($expertise['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        <?php } ?>
                            <?php if($_SESSION['user']['role'] != 1){ ?>
                                <div class="form-group">
                                    <label for="address">Địa chỉ</label>
                                    <div class="input-group">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <input type="text" id="address" name="address" 
                                               value="<?= htmlspecialchars($_SESSION['user']['address'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="working_hours">Thời gian làm việc <span class="required">*</span></label>
                                    <div class="input-group">
                                        <i class="fas fa-clock"></i>
                                        <input type="text" id="working_hours" name="working_hours" 
                                               value="<?= htmlspecialchars($_SESSION['user']['broker_info']['workingHours'] ?? '') ?>" required>
                                    </div>
                                </div>
                           <?php }else{ ?>
                               <div class="form-group full-width">
                                   <label for="address">Địa chỉ</label>
                                   <div class="input-group">
                                       <i class="fas fa-map-marker-alt"></i>
                                       <input type="text" id="address" name="address" 
                                              value="<?= htmlspecialchars($_SESSION['user']['address'] ?? '') ?>">
                                   </div>
                               </div>
                           <?php } ?>
                            <?php if($_SESSION['user']['role'] != 1){ ?>
                                 <div class="form-group full-width" >
                                    <label for="shortIntro">Giới thiệu bản thân <span class="required">*</span></label>
                                    <div class="input-group">
                                        <textarea id="shortIntro" name="shortIntro" rows="4" required><?= htmlspecialchars($_SESSION['user']['broker_info']['shortIntro'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            <?php } ?>  
                            </div> 
                        </div>
                        <div class="form-actions">
                            <button type="submit" name="update_profile" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Lưu thay đổi
                            </button>
                            <button type="reset" class="btn btn-outline">
                                <i class="fas fa-undo"></i>
                                Khôi phục
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    const avatarDisplay = document.getElementById('avatarDisplay');
    const avatarPreview = document.getElementById('avatarPreview');
    const uploadOverlay = document.querySelector('.upload-overlay');
    const form = document.querySelector('.profile-form');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phoneNumber');

    const phoneRegex = /^(0|\+84)(3|5|7|8|9)\d{8}$/;
    function showValidationError(inputElement, message) {
        inputElement.setCustomValidity(message);
        inputElement.reportValidity(); 
    }
    function clearValidationError(inputElement) {
        inputElement.setCustomValidity('');
    }
    if (uploadOverlay) {
        uploadOverlay.addEventListener('click', function() {
            avatarInput.click();
        });
    }

    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (avatarDisplay) avatarDisplay.src = e.target.result;
                    if (avatarPreview) avatarPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const phoneValue = phoneInput.value.trim();
            const cleanPhone = phoneValue.replace(/[^0-9+]/g, '');
            if (cleanPhone !== "" && !phoneRegex.test(cleanPhone)) {
                showValidationError(phoneInput, 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam 10 số.');
                isValid = false;
            } else {
                clearValidationError(phoneInput);
            }
        });
    }
});
</script>
