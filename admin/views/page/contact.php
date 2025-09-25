<div class="main-content">
    <header class="top-header">
        <h2>Quản lý Yêu cầu & Hỗ trợ</h2>
        <div class="user-info">
            <span>Xin chào, Admin!</span>
            <button>Đăng xuất</button>
        </div>
    </header>
    <div class="content-area">
        <div style="display:flex; justify-content: space-between; padding: 10px 0 5px;align-items: center;">
            <div style="display:flex; gap: 5px; justify-content: center; padding: 0 0 5px;align-items: center;">
                <fieldset>
                    <legend>Tìm kiếm</legend>
                    <form action="" method="post" class="admin__form-search">
                        <input type="text" value="<?php echo isset($_SESSION['search-contact']) && $_SESSION['search-contact'] !== '' ? htmlspecialchars($_SESSION['search-contact']) : ''; ?>" name="search-contact" placeholder="Tiêu đề, người gửi, căn hộ" autocomplete="off">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </fieldset>
                <fieldset>
                    <legend>Trạng thái</legend>
                    <form action="" method="post" class="admin__form-search">
                        <select name="status-contact" id="">
                           <option value="all" <?php if (isset($_SESSION['status-contact']) && $_SESSION['status-contact'] === 'all') echo 'selected' ?>>
                                Tất cả
                            </option>
                            <option value="pending" <?php if (isset($_SESSION['status-contact']) && $_SESSION['status-contact'] === 'pending') echo 'selected' ?>>
                                Đang chờ
                            </option>
                            <option value="inProgress" <?php if (isset($_SESSION['status-contact']) && $_SESSION['status-contact'] === 'inProgress') echo 'selected' ?>>
                                Đang xử lý
                            </option>
                            <option value="completed" <?php if (isset($_SESSION['status-contact']) && $_SESSION['status-contact'] === 'completed') echo 'selected' ?>>
                                Hoàn thành
                            </option>
                            <option value="canceled" <?php if (isset($_SESSION['status-contact']) && $_SESSION['status-contact'] === 'canceled') echo 'selected' ?>>
                                Đã hủy
                            </option>
                        </select>
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </fieldset>
                <fieldset>
                    <legend>Sắp xếp</legend>
                    <form action="" method="post" class="admin__form-search">
                        <select name="sort-contact" id="">
                            <option value="desc" <?php if (isset($_SESSION['sort-contact']) && $_SESSION['sort-contact'] === 'desc') echo 'selected' ?>>
                                Mới nhất
                            </option>
                            <option value="asc" <?php if (isset($_SESSION['sort-contact']) && $_SESSION['sort-contact'] === 'asc') echo 'selected' ?>>
                                Cũ nhất
                            </option>
                        </select>
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </fieldset>
            </div>
            <button class="action-button add add-contact-button" style="padding: 13px">Tạo yêu cầu mới</button>
        </div>
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th style="width: 1%; text-align: center;">STT</th>
                        <th style="width: 20%">Tên</th>
                        <th style="width: 10%">Số ĐT</th>
                        <th style="width: 10%">Khu vực</th>
                        <th style="width: 14%">Loại</th>
                        <th style="width: 14%">Khoảng giá</th>
                        <th style="width: 9%">Ngày gửi</th>
                        <th style="width: 11%">Trạng thái</th>
                        <th style="width: 11%; text-align: center;">Hành động</th>
                        <th style="display: none">Môi giới</th>
                        <th style="display: none">Nội dung</th>
                        <th style="display: none">ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = 1; 
                    foreach ($listContact as $key => $value) {
                        $statusText = '';
                        $statusClass = '';
                        switch ($value["status"]) {
                            case 'pending':
                                $statusText = 'Chờ xử lý';
                                $statusClass = 'pending';
                                break;
                            case 'inProgress':
                                $statusText = 'Đang xử lý';
                                $statusClass = 'inProgress';
                                break;
                            case 'completed':
                                $statusText = 'Hoàn thành';
                                $statusClass = 'completed';
                                break;
                            case 'canceled':
                                $statusText = 'Đã hủy';
                                $statusClass = 'canceled';
                                break;
                        }
                    ?>
                        <tr data-contact-id="<?= $value["id"] ?>" 
                            data-name="<?= htmlspecialchars($value["name"]) ?>"
                            data-phone="<?= $value["phone"] ?>"
                            data-email="<?= htmlspecialchars($value["email"] ?? '') ?>"
                            data-subject="<?= htmlspecialchars($value["subject"]) ?>"
                            data-description="<?= htmlspecialchars($value["description"] ?? '') ?>"
                            data-price="<?= htmlspecialchars($value["price"]) ?>"
                            data-status="<?= $value["status"] ?>"
                            data-broker-id="<?= $value["brokerId"] ?? '' ?>">
                            <td data-label="STT" style="text-align: center;"><?= $stt ?></td>
                            <td data-label="Tên"><?= $value["name"] ?></td>
                            <td data-label="Số ĐT"><?= $value["phone"] ?></td>
                            <td data-label="Khu vực"><?= $value["location_name"] ?></td>
                            <td data-label="Loại"><?= $value["subject"] ?></td>
                            <td data-label="Khoảng giá"><?= $value["price"] ?></td>
                            <td data-label="Ngày gửi"><?= date("d-m-Y", strtotime($value['createdAt'])) ?></td>
                            <td data-label="Trạng thái"><span class="status <?= $statusClass ?>"><?= $statusText ?></span></td>
                            <td data-label="Hành động" style="text-align: center;">
                                <button <?php if(($value["status"] === 'completed') || ($value["status"] === 'canceled')): ?> disabled style="cursor: not-allowed; background-color: gray;" <?php endif; ?> class="action-button edit">Sửa</button>
                            </td>
                             <td data-label="Môi giới" style="display: none"><?= $value["brokerId"] ?? '' ?></td>
                             <td data-label="Nội dung" style="display: none"><?= $value["note"] ?? '' ?></td>
                             <td data-label="ID" style="display: none"><?= $value["id"] ?? '' ?></td>
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
                        echo ' <a href="?act=contact&page=' . ($current_page - 1) . '"><button class="page-button"><i class="fa-solid fa-angle-left"></i></button></a>';
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($i != $current_page) {
                            if ($i > $current_page - 3 && $i < $current_page + 3) {
                                echo '<a href="?act=contact&page=' . $i . '"><button class="page-button">' . $i . '</button></a>';
                            }
                        } else {
                            echo '<button class="page-button active" disable>' . $i . '</button>';
                        }
                    }
                    if ($current_page < $total_page) {
                        echo ' <a href="?act=contact&page=' . ($current_page + 1) . '"><button class="page-button"><i class="fa-solid fa-angle-right"></i></button></a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div id="addContactModal" class="modal">
    <div class="modal-content">
        <span class="close-button" id="closeAddModalButton">&times;</span>
        <h3>Tạo Yêu cầu Mới</h3>
        <form id="addContactForm" action="" method="post">
            <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                <div>
                    <label for="add-name">Tên:</label>
                    <input style="margin-bottom: 5px; width: 93%" type="text" id="add-name" name="add-name" required>
                </div>
                <div>
                    <label for="add-phone">Số điện thoại:</label>
                    <input style="margin-bottom: 5px; width: 93%" type="text" id="add-phone" name="add-phone" required>
                </div>
            </div>
            <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                <div>
                    <label for="add-location">Khu vực:</label>
                    <select style="margin-bottom: 5px; width: 100%;" name="add-location" id="add-location">
                         <?php foreach ($listLocation as $location) {?>
                         <option value="<?=$location['id'] ?>"><?=$location['name'] ?></option>
                         <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="add-subject">Loại:</label>
                    <select style="margin-bottom: 5px; width: 100%;" name="add-subject" id="add-subject" required>
                        <option value="Tư vấn mua bán">Tư vấn mua bán</option>
                        <option value="Tư vấn cho thuê">Tư vấn cho thuê</option>
                        <option value="Khiếu nại">Khiếu nại</option>
                        <option value="Khác">Khác</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="add-broker">Môi giới:</label>
                <select style="margin-bottom: 5px; width: 100%;" name="add-broker" id="add-broker" required>
                    <?php foreach ($listBroker as $broker) {?>
                    <option value="<?=$broker['id'] ?>"><?=$broker['fullName'] ?> - <?=$broker['phoneNumber'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div>
                <label for="add-note">Nội dung:</label>
                <textarea style="margin-bottom: 5px; width: 100%; box-sizing: border-box;" id="add-note" name="add-note" rows="6" required></textarea>
                <button type="submit" name="addContact" class="action-button add">Thêm</button>
            </div>
        </form>
    </div>
</div>


<div id="editContactModal" class="modal">
    <div class="modal-content">
        <span class="close-button" id="closeEditModalButton">&times;</span>
        <h3>Chỉnh sửa Yêu cầu</h3>
        <form id="editContactForm" method="POST">
            <input type="hidden" id="edit-id" name="edit-id">
            <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap: 2rem;"> 
                <div>
                    <label for="edit-name">Tên:</label>
                    <input style="margin-bottom: 5px" type="text" id="edit-name" name="edit-name" required>
                </div>
                <div>
                    <label for="edit-phone">Số điện thoại:</label>
                    <input style="margin-bottom: 5px" type="text" id="edit-phone" name="edit-phone" required>
                </div>
                
            </div>
        
            <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap: 2rem;">
                <div>
                    <label for="edit-location">Khu vực:</label>
                   <input type="text" id="edit-location" name="edit-location" readonly>
                </div>
                <div>
                    <label for="edit-subject">Loại:</label>
                    <input style="margin-bottom: 5px" type="text" id="edit-subject" name="edit-subject" readonly>
                </div>
            </div>
            <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap: 2rem;">
                <div>
                    <label for="edit-price">Khoảng giá:</label>
                    <input type="text" id="edit-price" name="edit-price" readonly>
                </div>
                <div>
                    <label for="edit-createdAt">Ngày gửi:</label>
                    <input style="margin-bottom: 5px" type="text" id="edit-createdAt" name="edit-createdAt" readonly>
                </div>
            </div>
            <div>
                <label for="edit-status">Trạng thái:</label>
                <select style="margin-bottom: 5px; width: 100%;" id="edit-status" name="edit-status">
                    <option value="pending">Chờ xử lý</option>
                    <option value="inProgress">Đang xử lý</option>
                    <option value="completed">Hoàn thành</option>
                    <option value="canceled">Đã huỷ</option>
                </select>
              <label for="edit-broker">Môi giới: </label>
                 <select style="margin-bottom: 5px; width: 100%;" name="edit-broker" id="edit-broker" required>
                    <?php foreach ($listBroker as $broker) { ?>
                        <option value="<?=$broker['id'] ?>" <?php if ($broker['id'] == $value['brokerId']) echo 'selected'; ?>><?=$broker['fullName'] ?> - <?=$broker['phoneNumber'] ?></option>
                     <?php } ?>
                </select>
            <label for="edit-note">Nội dung:</label>
            <textarea style="margin-bottom: 5px; width: 100%; box-sizing: border-box;" id="edit-note" name="edit-note" rows="6"></textarea>
         
            <button type="submit" name="editContact" style="background-color: blue; color: white;" class="action-button edit">Lưu</button>
            <button type="button" style="background-color: red; color: white;" class="action-button cancel-edit">Hủy</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#add-broker').select2({
            placeholder: "Chọn hoặc tìm kiếm môi giới",
            allowClear: true
        });
    });
</script>

<script src="./views/js/contact.js"></script>