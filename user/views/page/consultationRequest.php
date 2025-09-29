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
                    <a href="?act=profile" class="menu-item">
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
                    <a href="?act=consultationRequest" class="menu-item active">
                        <i class="fas fa-comments"></i>
                        <span>Yêu cầu tư vấn</span>
                    </a>
                </nav>
            </aside>

                <div class="profile-content" style="padding: 2rem">
                      <div class="form-section" style="margin-bottom: 0.5rem;">
                <h3 class="section-title" style="margin-bottom:0.5rem;">Yêu cầu tư vấn đã gửi</h3>
                <div class="content-filters">
                    <div class="filter-actions">
                        <form method="POST" action="" class="sort-options">
                            <label>Sắp xếp theo:</label>
                            <select class="form-select" onchange="this.form.submit()" name="sort">
                                <option <?php if ($_SESSION['sort-consultation-request'] === 'desc') echo 'selected'; ?> value="desc">Mới nhất</option>
                                <option <?php if ($_SESSION['sort-consultation-request'] === 'asc') echo 'selected'; ?> value="asc">Cũ nhất</option>
                            </select>
                        </form>
                    </div>
                </div>
                </div>
                 <div class="saved-broker-grid">
                    <?php if (!empty($listConsultationRequest)) { ?>
                        <?php foreach ($listConsultationRequest as $consultationRequest){ 
                            $status = $consultationRequest['status'];
                            if ($status == 'pending') {
                                $statusText = 'Đang chờ';
                                $statusClass = 'status-pending';
                            } elseif ($status == 'inProgress') {
                                $statusText = 'Đang xử lý';
                                 $statusClass = 'status-in-progress';
                            } elseif ($status == 'completed') {
                                $statusText = 'Hoàn thành';
                                $statusClass = 'status-completed';
                            } elseif ($status == 'canceled') {
                                $statusText = 'Đã hủy';
                                $statusClass = 'status-canceled';
                            } else {
                                $statusText = 'Không xác định';
                                $statusClass = '';
                            }
                            ?>
                            <div class="saved-broker-card" data-type="broker" >
                                <div class="broker-image" style="height: 0;">
                                    <div class="broker-badge broker <?= $statusClass ?>"><?= $statusText ?></div>
                                </div>
                                <div class="broker-details">
                                    <div class="broker-title">
                                        <?php if($consultationRequest['brokerName']) { ?>
                                        <h3 style="cursor: pointer;" onclick="window.location.href='?act=broker&id=<?= $consultationRequest['brokerId'] ?>'">Môi giới: <?= htmlspecialchars($consultationRequest['brokerName']) ?></h3>
                                        <?php } else { ?>
                                            <h3>Đang phân công môi giới</h3>
                                        <?php } ?>
                                    </div>
                                    <p class="broker-location">
                                        <i class="fas fa-phone"></i>
                                        <?= htmlspecialchars($consultationRequest['phone']) ?>
                                    </p>
                                     <p class="broker-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?= htmlspecialchars($consultationRequest['location']) ?>
                                    </p>
                                     <p class="broker-location">
                                        <i class="fas fa-tasks"></i>
                                        <?= htmlspecialchars($consultationRequest['subject']) ?>
                                    </p>
                                    <p class="broker-location">
                                        <i class="fas fa-dollar-sign"></i>
                                        <?= htmlspecialchars($consultationRequest['price']) ?>
                                    </p>
                                     <p class="broker-location">
                                        <i class="fas fa-comment-dots"></i>
                                        <?= htmlspecialchars($consultationRequest['message']) ?>
                                    </p>
                                    <div class="broker-price">
                                        <span class="follow-date">
                                            <i class="fas fa-calendar"></i>
                                            Thời gian gửi <?= date('H:i:s d/m/Y', strtotime($consultationRequest['createdAt'])) ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="broker-contact">
                                    <button <?php if($consultationRequest['status'] == 'pending' || $consultationRequest['status'] == 'completed' || $consultationRequest['status'] == 'canceled') echo 'disabled style="background: #e9ecef; color: #6c757d; cursor: not-allowed; border: 1px solid #e9ecef;"'; ?> class="btn btn-primary btn-sm" onclick="window.location.href='?act=broker&id=<?= $consultationRequest['brokerId'] ?>'">
                                        <i class="fas fa-phone"></i>
                                        Liên hệ môi giới
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="empty-state" style="width:207%">
                            <div class="empty-icon">
                               <i class="fa-regular fa-comment-dots"></i>
                            </div>
                            <h3>Chưa gửi bất kì yêu cầu tư vấn nào</h3>
                            <p>Bạn chưa gửi bất kì yêu cầu tư vấn nào. Gửi yêu cầu ngay nếu cần bất kì trợ giúp nào!</p>
                            <a href="?act=contact" class="btn btn-primary">
                               <i class="fa-solid fa-comment-medical"></i>
                                Gửi yêu cầu tư vấn
                            </a>
                        </div>
                    <?php } ?>
                    </div>
            </div>
        </div>
    </main>
</div>