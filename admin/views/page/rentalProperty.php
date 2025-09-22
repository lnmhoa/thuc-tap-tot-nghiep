<div class="main-content">
    <header class="top-header">
        <h2>Quản lý căn hộ</h2>
        <div class="user-info">
            <span>Xin chào, Admin!</span>
            <button>Đăng xuất</button>
        </div>
    </header>
    <div class="content-area">
        <div style="display:flex; justify-content: space-between; padding: 10px 0 5px;align-items: center;">
            <div style="display:flex; gap: 5px; justify-content: center; padding: 0 0 5px;align-items: center;">
                <fieldset>
                    <legend>Sắp xếp</legend>
                    <form action="" method="post" class="admin__form-search">
                        <select name="sort-rental-property-admin">
                            <option value="desc" <?php if ($_SESSION['sort-rental-property-admin'] === 'desc') echo 'selected'; ?>>
                                Mới nhất
                            </option>
                            <option value="asc" <?php if ($_SESSION['sort-rental-property-admin'] === 'asc') echo 'selected'; ?>>
                                Cũ nhất
                            </option>
                        </select>
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </fieldset>
                <fieldset>
                    <legend>Khu vực</legend>
                    <form action="" method="post" class="admin__form-search">
                        <select name="sort-rental-property-location-admin">
                            <option value="all" <?php if ($_SESSION['sort-rental-property-location-admin'] === 'all') echo 'selected'; ?>>
                                Tất cả
                            </option>
                            <?php foreach ($listLocation as $location) { ?>
                                <option value="<?php echo htmlspecialchars($location['id']); ?>"
                                    <?php if ($_SESSION['sort-rental-property-location-admin'] == $location['id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($location['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </fieldset>
                <fieldset>
                    <legend>Loại</legend>
                    <form action="" method="post" class="admin__form-search">
                        <select name="sort-rental-property-expertises-admin">
                            <option value="all" <?php if ($_SESSION['sort-rental-property-expertises-admin'] === 'all') echo 'selected'; ?>>
                                Tất cả
                            </option>
                            <?php foreach ($listExpertises as $expertises) { ?>
                                <option value="<?php echo htmlspecialchars($expertises['id']); ?>"
                                    <?php if ($_SESSION['sort-rental-property-expertises-admin'] == $expertises['id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($expertises['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </fieldset>
            </div>
            <button class="add-apartment-button">Thêm Bất Động Sản</button>
        </div>
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th style="width: 0%; text-align: center;">STT</th>
                        <th style="width: 25%">Tiêu đề</th>
                        <th style="width: 10% ;text-align: center;">Ảnh bìa</th>
                        <th style="width: 10%;text-align: center;">Khu vực</th>
                        <th style="width: 10%;text-align: center;">Loại</th>
                        <th style="width: 11%;text-align: center;">Ngày đăng</th>
                        <th style="width: 12%;text-align: center;">Lượt xem</th>
                        <th style="width: 11%;text-align: center;">Trạng thái</th>
                        <th style="width: 12%;text-align: center; text-align: center;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = (($current_page - 1) * $limit) + 1;
                    foreach ($listRentalProperty as $key => $value) {
                        if($value['status'] == 'active') {
                            $status = 'Còn trống';
                        } elseif ($value['status'] == 'rented') {
                            $status = 'Đã thuê';
                        } else {
                            $status = 'Không xác định';
                        }           
                        $images = json_decode('[' . $value['images'] . ']', true);
                        $mainImage = '';
                        if (!empty($images)) {
                            $foundMain = false;
                            foreach ($images as $image) {
                                if (isset($image['isMain']) && $image['isMain'] == 1) {
                                    $mainImage = $image['imagePath'];
                                    $foundMain = true;
                                    break;
                                }
                            }
                            if (!$foundMain) {
                                $mainImage = $images[0]['imagePath'];
                            }
                        }
                    ?>
                        <tr>
                            <td data-label="STT" style="text-align: center;"><?= $stt ?></td>
                            <td data-label="Tiêu đề"><?= htmlspecialchars($value['title']) ?></td>
                            <td data-label="Ảnh bìa" style="text-align: center;">
                                <?php if (!empty($mainImage)) { ?>
                                    <img style="width: 80px; text-align: center;" src="../admin/uploads/rentalProperty/<?= htmlspecialchars($mainImage) ?>" alt="<?= htmlspecialchars($value['title']) ?>">
                                <?php } else { ?>
                                    Không có ảnh
                                <?php } ?>
                            </td>
                            <td data-label="Khu vực" style="text-align: center;"><?= htmlspecialchars($value['location_name']) ?></td>
                            <td data-label="Loại" style="text-align: center;"><?= htmlspecialchars($value['property_type_name']) ?></td>
                            <td data-label="Ngày đăng" style="text-align: center;"><?= date("d-m-Y", strtotime($value['createdAt'])) ?></td>
                            <td data-label="Lượt xem" style="text-align: center;"><?= htmlspecialchars($value['views']) ?></td>
                            <td data-label="Trạng thái" style="text-align: center;"><?= $status ?></td>
                            <td data-label="Hành động" style="text-align: center;">
                                <button class="action-button edit">Sửa</button>
                                <button class="action-button del">Xóa</button>
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
                        echo ' <a href="?act=rentalProperty&page=' . ($current_page - 1) . '"><button class="page-button"><i class="fa-solid fa-angle-left"></i></button></a>';
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($i != $current_page) {
                            if ($i > $current_page - 3 && $i < $current_page + 3) {
                                echo '<a href="?act=rentalProperty&page=' . $i . '"><button class="page-button">' . $i . '</button></a>';
                            }
                        } else {
                            echo '<button class="page-button active" disable>' . $i . '</button>';
                        }
                    }
                    if ($current_page < $total_page) {
                        echo ' <a href="?act=rentalProperty&page=' . ($current_page + 1) . '"><button class="page-button"><i class="fa-solid fa-angle-right"></i></button></a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div id="apartmentModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h3 id="modalTitle">Chi tiết căn hộ</h3>
        <form id="apartmentForm">
            <label for="modal-id">STT:</label>
            <input type="text" id="modal-id" readonly><br>

            <label for="modal-name">Tên căn hộ:</label>
            <input type="text" id="modal-name" required><br>

            <label for="modal-address">Địa chỉ:</label>
            <input type="text" id="modal-address" required><br>

            <label for="modal-area">Diện tích (m²):</label>
            <input type="number" id="modal-area" min="1" required><br>

            <label for="modal-price">Giá thuê (VNĐ):</label>
            <input type="number" id="modal-price" min="0" required><br>

            <label for="modal-status">Trạng thái:</label>
            <select id="modal-status">
                <option value="available">Còn trống</option>
                <option value="rented">Đã thuê</option>
                <option value="maintenance">Đang bảo trì</option>
            </select><br>

            <label for="modal-date">Ngày tạo:</label>
            <input type="date" id="modal-date" readonly><br>

            <button type="submit" id="saveApartmentButton">Lưu</button>
            <button type="button" id="cancelButton">Hủy</button>
        </form>
    </div>
</div>

<div id="deactivateConfirmModal" class="modal">
    <div class="modal-content small-modal">
        <span class="close-button" id="closeDeactivateConfirm">&times;</span>
        <h3>Xác nhận ngừng hoạt động</h3>
        <p>Bạn có chắc chắn muốn ngừng hoạt động căn hộ <strong id="apartmentNameToDeactivate"></strong> (STT: <strong id="apartmentIdToDeactivate"></strong>) không?</p>
        <div class="modal-actions">
            <button id="confirmDeactivateButton" class="action-button deactive">Ngừng hoạt động</button>
            <button id="cancelDeactivateButton" class="action-button view">Hủy</button>
        </div>
    </div>
</div>

<script src="./views/js/rentalProperty.js"></script>