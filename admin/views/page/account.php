<div class="main-content">
    <header class="top-header">
        <h2>Quản Lý Tài Khoản</h2>
        <div class="user-info">
            <span>Xin chào, Admin!</span>
            <button>Đăng Xuất</button>
        </div>
    </header>
    <div class="content-area">
        <div style="display:flex; justify-content: space-between; padding: 10px 0 5px;align-items: center;">
            <div style="display:flex; gap: 5px; justify-content: center; padding: 0 0 5px;align-items: center;">
                <fieldset>
                    <legend>Tìm kiếm</legend>
                    <form action="" method="post" class="admin__form-search">
                        <input type="text" value="<?php echo isset($_SESSION['search-account']) && $_SESSION['search-account'] !== '' ? htmlspecialchars($_SESSION['search-account']) : ''; ?>" name="search-account" placeholder="Số điện thoại, email" autocomplete="off">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </fieldset>
                <fieldset>
                    <legend>Sắp xếp</legend>
                    <form action="" method="post" class="admin__form-search">
                        <select name="sort-account" id="" onchange="this.form.submit()">
                            <option value="desc" <?php if ($_SESSION['sort-account'] === 'desc')
                                                                echo 'selected' ?>>
                                Mới nhất
                            </option>
                            <option value="asc" <?php if ($_SESSION['sort-account'] === 'asc')
                                                            echo 'selected' ?>>Cũ
                                nhất
                            </option>
                             <option value="active" <?php if ($_SESSION['sort-account'] === 'active')
                                                            echo 'selected' ?>>Hoạt động
                            </option>
                             <option value="inactive" <?php if ($_SESSION['sort-account'] === 'inactive')
                                                            echo 'selected' ?>>Đã khóa
                            </option>
                        </select>
                    </form>
                </fieldset>
            </div>
            <button class="add-user-button">Thêm Người Dùng</button>
        </div>
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th style="width: 1%; text-align: center;">STT</th>
                        <th style="width: 20%">Họ tên</th>
                        <th style="width: 1%; text-align: center;">Avatar</th>
                        <th style="width: 14%">Email</th>
                        <th style="width: 14%">Số điện thoại</th>
                        <th style="width: 14%">Trạng thái</th>
                        <th style="width: 10%">Ngày tạo</th>
                        <th style="width: 20%; text-align: center;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = (($current_page - 1) * $limit) + 1;

                    foreach ($listAccount as $key => $value) {
                        if ($value["status"] == 'active') {
                            $status = "Hoạt động";
                            $statusClass = "active";
                            $buttonText = "<i class=\"fa-solid fa-lock\"></i> Khóa";
                        } else {
                            $status = "Đã khóa";
                            $statusClass = "inactive";
                            $buttonText = "<i class=\"fa-solid fa-unlock\"></i> Mở khóa";
                        }
                    ?>
                        <tr data-user-id="<?= $value["id"] ?>" data-user-name="<?= $value["fullName"] ?>" data-user-email="<?= $value["email"] ?>" data-user-phone="<?= $value["phoneNumber"] ?>" data-user-status="<?= $status ?>" data-user-created="<?= $value["createdAt"] ?>">
                            <td data-label="STT" style="text-align: center;"><?= $stt ?></td>
                            <td data-label="Tên"><?= $value["fullName"] ?></td>
                            <td data-label="Avatar" style="text-align: center;"><img style="width: 80px; border-radius: 50%;" <?php if(!empty($value["avatar"])) echo 'src="../uploads/user/'.$value["avatar"].'"'; else echo 'src="../uploads/system/default_user.jpg"'; ?> alt="" srcset=""></td>
                            <td data-label="Email"><?= $value["email"] ?></td>
                            <td data-label="Số điện thoại" style="text-align: center;"><?= $value["phoneNumber"] ?></td>
                            <td data-label="Trạng thái"><span class="status <?= $statusClass ?>"><?= $status ?></span></td>
                            <td data-label="Ngày tạo"><?php $date = new DateTime($value["createdAt"]); echo $date->format('d/m/Y'); ?></td>
                            <td data-label="Hành động" style="text-align: center;">
                                <button class="action-button view">Xem</button>
                                <button class="action-button lock" <?php if($statusClass === "inactive") {echo 'style="background-color: green;"';}else{echo 'style="background-color: red; padding: 6px 16px"';} ?>><?= $buttonText ?></button>
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
                        echo ' <a href="?act=account&page=' . ($current_page - 1) . '"><button class="page-button"><i class="fa-solid fa-angle-left"></i></button></a>';
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($i != $current_page) {
                            if ($i > $current_page - 3 && $i < $current_page + 3) {
                                echo '<a href="?act=account&page=' . $i . '"><button class="page-button">' . $i . '</button></a>';
                            }
                        } else {
                            echo '<button class="page-button active" disable>' . $i . '</button>';
                        }
                    }
                    if ($current_page < $total_page) {
                        echo ' <a href="?act=account&page=' . ($current_page + 1) . '"><button class="page-button"><i class="fa-solid fa-angle-right"></i></button></a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div id="addFormArea" class="modal">
    <div class="modal-content">
        <span class="close-button" id="cancelAddButton">&times;</span>
        <h3>Thêm Người Dùng Mới</h3>
        <form id="addAccountForm">
            <label for="add-name">Tên:</label>
            <input type="text" id="add-name" required>
            <label for="add-phone">Số điện thoại:</label>
            <input type="number" id="add-phone" required>
            <label for="add-email">Email:</label>
            <input type="email" id="add-email" required>
            <label for="add-password">Mật khẩu:</label>
            <input type="password" id="add-password" minlength="6" required>
            <button type="submit" class="action-button add">Thêm</button>
        </form>
    </div>
</div>

<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h3 id="modalTitle">Chi Tiết Người Dùng</h3>
        <form id="userForm">
            <label for="modal-name">Tên:</label>
            <input type="text" id="modal-name" readonly>
            <label for="modal-phone">Số điện thoại:</label>
            <input type="text" id="modal-phone" readonly>
            <label for="modal-email">Email:</label>
            <input type="email" id="modal-email" readonly>
            <label for="modal-status">Trạng thái:</label>
            <select id="modal-status" disabled>
                <option value="active">Hoạt động</option>
                <option value="pending">Đã khóa</option>
            </select>
            <label for="modal-date">Ngày tạo:</label>
            <input type="text" id="modal-date" readonly>
            <button type="button" id="cancelButton" class="action-button view">Đóng</button>
        </form>
    </div>
</div>

<div id="deleteConfirmModal" class="modal">
    <div class="modal-content">
        <span class="close-button" id="closeDeleteConfirm">&times;</span>
        <h3>Xác Nhận Thay Đổi Quyền Truy Cập</h3>
        <p>Bạn có chắc chắn muốn <strong id="userNameToDelete"></strong> tài khoản không?</p>
        <div class="modal-actions">
            <button id="confirmDeleteButton" class="action-button lock" style="background-color"></button>
            <button id="cancelDeleteButton" class="action-button view">Hủy</button>
        </div>
    </div>
</div>
<script src="./views/js/account.js"></script>