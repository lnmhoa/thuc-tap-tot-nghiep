<div class="main-content">
    <header class="top-header">
        <h2>Quản Lý Nhân Viên</h2>
        <div class="user-info">
            <span>Xin chào, Admin!</span>
            <button><i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng Xuất</button>
        </div>
    </header>
    <div class="content-area">
        <div style="display:flex; justify-content: space-between; padding: 10px 0 5px;align-items: center;">
            <div style="display:flex; gap: 5px; justify-content: center; padding: 0 0 5px;align-items: center;">
                <fieldset>
                    <legend>Tìm kiếm</legend>
                    <form action="" method="post" class="admin__form-search">
                        <input type="text" value="<?php echo isset($_SESSION['search-broker']) && $_SESSION['search-broker'] !== '' ? htmlspecialchars($_SESSION['search-broker']) : ''; ?>" name="search-broker" placeholder="Số điện thoại" autocomplete="off">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </fieldset>
                <fieldset>
                    <legend>Sắp xếp</legend>
                    <form action="" method="post" class="admin__form-search">
                        <select name="sort-broker-admin" id="">
                            <option value="desc" <?php if ($_SESSION['sort-broker-admin'] === 'desc') echo 'selected' ?>>
                                Mới nhất
                            </option>
                            <option value="asc" <?php if ($_SESSION['sort-broker-admin'] === 'asc') echo 'selected' ?>>Cũ
                                nhất
                            </option>
                        </select>
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </fieldset>
                <fieldset>
                    <legend>Trạng thái</legend>
                    <form action="" method="post" class="admin__form-search">
                        <select name="sort-status-broker" id="">
                            <option value="all" <?php if ($_SESSION['sort-status-broker'] === 'all') echo 'selected' ?>>
                                Tất cả
                            </option>
                            <option value="active" <?php if ($_SESSION['sort-status-broker'] === 'active') echo 'selected' ?>>
                                Hoạt động
                            </option>
                            <option value="inactive" <?php if ($_SESSION['sort-status-broker'] === 'inactive') echo 'selected' ?>>
                                Đã khóa
                            </option>
                        </select>
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </fieldset>
            </div>
            <button class="add-broker-button"><i class="fa-solid fa-plus"></i> Thêm Nhân Viên</button>
        </div>
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%; text-align: center;">STT</th>
                        <th style="width: 22%">Họ tên</th>
                        <th style="width: 13%; text-align: center;">Avatar</th>
                        <th style="width: 12%">Số điện thoại</th>
                        <th style="display: none">Email</th>
                        <th style="display: none">Link facebook</th>
                        <th style="display: none">Link youtube</th>
                        <th style="display: none">Link website</th>
                        <th style="display: none">Giới thiệu</th>
                        <th style="width: 10%">Trạng thái</th>
                        <th style="display: none">Khu vực</th>
                        <th style="display: none">Giờ làm việc</th>
                        <th style="display: none">Giao tiếp</th>
                        <th style="display: none">Chuyên môn</th>
                        <th style="display: none">Ngày tạo</th>
                        <th style="display: none">id</th>
                        <th style="display: none">accountId</th>
                        <th style="width: 13%">Số bài đăng</th>
                        <th style="width: 14%">Lượt cho thuê</th>
                        <th style="width: 12%; text-align: center;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = (($current_page - 1) * $limit) + 1;
                    foreach ($listBroker as $key => $value) {
                        if ($value["status"] == 'active') {
                            $status = "Hoạt động";
                            $statusClass = "active";
                        } else {
                            $status = "Khóa";
                            $statusClass = "pending";
                        }
                    ?>
                        <tr>
                            <td data-label="STT" style="text-align: center;"><?= $stt ?></td>
                            <td data-label="Tên"><?= $value["fullName"] ?></td>
                            <td data-label="Avatar" style="text-align: center;"><img style="width: 80px" src='../admin/uploads/broker/<?= $value["avatar"] ?>' alt="" srcset=""></td>
                            <td data-label="Số điện thoại" style="text-align: center;"><?= $value["phoneNumber"] ?></td>
                            <td data-label="Email" style="display: none"><span><?= $value["email"] ?></span></td>
                            <td data-label="Link facebook" style="display: none"><span><?= $value["linkFacebook"] ?></span></td>
                            <td data-label="Link youtube" style="display: none"><span><?= $value["linkYoutube"] ?></span></td>
                            <td data-label="Link website" style="display: none"><span><?= $value["linkWebsite"] ?></span></td>
                            <td data-label="Giới thiệu" style="display: none"><span><?= $value["shortIntro"] ?></span></td>
                            <td data-label="Trạng thái"><span class="status <?= $statusClass ?>"><?= $status ?></span></td>
                            <td data-label="Khu vực" style="display: none"><span><?= $value["mainArea"] ?></span></td>
                            <td data-label="Giờ làm việc" style="display: none"><span><?= $value["workingHours"] ?></span></td>
                            <td data-label="Giao tiếp" style="display: none"><span><?= $value["language"] ?></span></td>
                            <td data-label="Chuyên môn" style="display: none"><span><?= $value["expertise"] ?></span></td>
                            <td data-label="Ngày tạo" style="display: none"><span><?= date("d-m-Y", strtotime($value["createdAt"])) ?></span></td>
                            <td data-label="Mã nhân viên" style="display: none"><span><?= $value["id"] ?></span></td>
                            <td data-label="Mã tài khoản" style="display: none"><span><?= $value["accountId"] ?></span></td>
                            <td data-label="Số bài đăng" style="text-align: center;"><span>1</span></td>
                            <td data-label="Lượt cho thuê" style="text-align: center;"><span>2</span></td>
                            <td data-label="Hành động" style="text-align: center;">
                                <button class="action-button view">Xem</button>
                                <button class="action-button edit">Sửa</button>
                            </td>
                        </tr>
                    <?php
                        $stt++;
                    } ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <div>
                <?php
                if ($total_page > 1) {
                    if ($current_page > 1) {
                        echo ' <a href="?act=broker&page=' . ($current_page - 1) . '"><button class="page-button"><i class="fa-solid fa-angle-left"></i></button></a>';
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($i != $current_page) {
                            if ($i > $current_page - 3 && $i < $current_page + 3) {
                                echo '<a href="?act=broker&page=' . $i . '"><button class="page-button">' . $i . '</button></a>';
                            }
                        } else {
                            echo '<button class="page-button active" disable>' . $i . '</button>';
                        }
                    }
                    if ($current_page < $total_page) {
                        echo ' <a href="?act=broker&page=' . ($current_page + 1) . '"><button class="page-button"><i class="fa-solid fa-angle-right"></i></button></a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div id="addFormArea" class="modal">
        <div class="modal-content">
            <span class="close-button" id="cancelAddButton">&times;</span>
            <h3 style="color:dodgerblue">THÊM NHÂN VIÊN MỚI</h3>
            <form id="addBrokerForm" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px">
                <div>
                    <label for="add-avatar"><i class="fa-solid fa-image-portrait"></i> Ảnh đại diện:</label>
                    <input type="file" id="add-avatar" style="padding: 7px; width: 90%" name="avatar" accept="image/*">
                    <label for="add-name"><i class="fa-solid fa-signature"></i> Tên:</label>
                    <input style="width: 90%" type="text" id="add-name" required>
                    <label for="add-phone"><i class="fa-solid fa-phone"></i> Số điện thoại:</label>
                    <input style="width: 90%" type="number" id="add-phone" required>
                    <label for="add-email"><i class="fa-solid fa-envelope"></i> Email:</label>
                    <input style="width: 90%" type="email" id="add-email" required>
                    <label for="add-password"><i class="fa-solid fa-lock"></i> Mật khẩu:</label>
                    <input type="password" style="width: 90%" id="add-password" minlength="6" required>
                    <button type="submit" class="action-button add">Thêm</button>
                </div>
                <div>
                    <label for="add-facebook"><i class="fa-brands fa-facebook"></i> Link facebook:</label>
                    <input type="text" style="width: 90%" id="add-facebook">
                    <label for="add-youtube"><i class="fa-brands fa-youtube"></i> Link youtube:</label>
                    <input type="text" style="width: 90%" id="add-youtube">
                    <label for="add-website"><i class="fa-brands fa-internet-explorer"></i> Link website:</label>
                    <input type="text" style="width: 90%" id="add-website">
                    <label for="add-intro"><i class="fa-solid fa-clipboard"></i> Giới thiệu:</label>
                    <input type="text" style="width: 90%" id="add-intro">
                    <label for="add-hour"><i class="fa-solid fa-clock"></i> Giờ làm việc:</label>
                    <input type="text" style="width: 90%" id="add-hour">
                </div>
                <div>
                    <div>
                        <label for="add-language"><i class="fa-solid fa-language"></i> Giao tiếp:</label>
                        <select id="add-language" multiple size="3">
                            <option value="Tiếng Việt">Tiếng Việt</option>
                            <option value="Tiếng Anh">Tiếng Anh</option>
                            <option value="Tiếng Trung">Tiếng Trung</option>
                            <option value="Tiếng Hàn">Tiếng Hàn</option>
                            <option value="Tiếng Nhật">Tiếng Nhật</option>
                        </select>
                        <label for="add-expertise"><i class="fa-solid fa-street-view"></i> Chuyên môn:</label>
                        <select id="add-expertise" multiple size="3">
                            <?php foreach ($listExpertises as $expertises) { ?>
                                <option value="<?php echo htmlspecialchars($expertises['name']); ?>">
                                    <?php echo htmlspecialchars($expertises['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label for="add-area"><i class="fa-solid fa-earth-americas"></i> Khu vực:</label>
                        <select id="add-area">
                            <?php foreach ($listLocation as $location) { ?>
                                <option value="<?php echo htmlspecialchars($location['name']); ?>">
                                    <?php echo htmlspecialchars($location['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="brokerModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h3 id="modalTitle" style="color:dodgerblue">CHI TIẾT NGƯỜI DÙNG</h3>
            <form id="brokerForm" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px">
                <div>
                    <div id="modal-avatar-container">
                        <label for="modal-avatar"><i class="fa-solid fa-image-portrait"></i> Ảnh đại diện:</label>
                        <img id="modal-avatar-img" src="" alt="Avatar" style="width: 100px; height: 100px; display: none; object-fit: cover; border-radius: 5px; margin-bottom: 10px;">
                        <input type="file" id="modal-avatar" style="padding: 7px; width: 90%" name="avatar" accept="image/*">
                    </div>
                    <label for="modal-name"><i class="fa-solid fa-signature"></i> Tên:</label>
                    <input style="width: 90%" type="text" id="modal-name" required>
                    <label for="modal-phone"><i class="fa-solid fa-phone"></i> Số điện thoại:</label>
                    <input style="width: 90%" type="number" id="modal-phone" required>
                    <label for="modal-email"><i class="fa-solid fa-envelope"></i> Email:</label>
                    <input style="width: 90%" type="email" id="modal-email" required>
                     <label for="modal-created">Ngày tạo:</label>
                    <input type="text" style="width: 90%" id="modal-created" readonly>
                      <label for="modal-password"><i class="fa-solid fa-lock"></i> Mật khẩu:</label>
                    <input style="width: 90%" type="password" id="modal-password">
                    <button type="submit" id="saveBrokerButton" style="background-color: #218838; color: white">Lưu</button>
                    <button type="button" id="cancelButton" class="action-button view">Hủy</button>
                </div>
                <div>
                    <label for="modal-facebook"><i class="fa-brands fa-facebook"></i> Link facebook:</label>
                    <input style="width: 90%" type="text" id="modal-facebook">
                    <label for="modal-youtube"><i class="fa-brands fa-youtube"></i> Link youtube:</label>
                    <input style="width: 90%" type="text" id="modal-youtube">
                    <label for="modal-website"><i class="fa-brands fa-internet-explorer"></i> Link website:</label>
                    <input style="width: 90%" type="text" id="modal-website">
                    <label for="modal-intro"><i class="fa-solid fa-clipboard"></i> Giới thiệu:</label>
                    <input style="width: 90%" type="text" id="modal-intro">
                    <label for="modal-status">Trạng thái:</label>
                    <select id="modal-status">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Khóa</option>
                    </select>
                     
                </div>
                <div>
                    <label for="modal-area"><i class="fa-solid fa-earth-americas"></i> Khu vực:</label>
                    <select id="modal-area">
                        <?php foreach ($listLocation as $location) { ?>
                            <option value="<?php echo htmlspecialchars($location['name']); ?>">
                                <?php echo htmlspecialchars($location['name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <div>
                        <label for="modal-language"><i class="fa-solid fa-language"></i> Giao tiếp:</label>
                        <select id="modal-language" multiple size="2">
                            <option value="Tiếng Việt">Tiếng Việt</option>
                            <option value="Tiếng Anh">Tiếng Anh</option>
                            <option value="Tiếng Trung">Tiếng Trung</option>
                            <option value="Tiếng Hàn">Tiếng Hàn</option>
                            <option value="Tiếng Nhật">Tiếng Nhật</option>
                        </select>
                        <label for="modal-expertise"><i class="fa-solid fa-street-view"></i> Chuyên môn:</label>
                        <select id="modal-expertise" multiple size="2">
                            <?php foreach ($listExpertises as $expertises) { ?>
                                <option value="<?php echo htmlspecialchars($expertises['name']); ?>">
                                    <?php echo htmlspecialchars($expertises['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                          <label for="modal-hour"><i class="fa-solid fa-clock"></i> Giờ làm việc:</label>
                    <input type="text" id="modal-hour">
                    </div>
                    <input style="display:none" type="text" id="modal-brokerId">
                    <input style="display:none" type="text" id="modal-accountId">
                   
                </div>
            </form>
        </div>
    </div>
    <script src="./views/js/broker.js"></script>
</div>