<div class="main-content">
    <header class="top-header">
        <h2>Quản lý bất động sản</h2>
        <div class="user-info">
            <span>Xin chào, <?= $_SESSION['user']['fullName'] ?? 'Admin' ?>!</span>
            <form method="post" style="display:inline;">
                <button name="logout" type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng Xuất</button>
            </form>
        </div>
    </header>
    <div class="content-area">
        <div style="display:flex; justify-content: space-between; padding: 10px 0 5px;align-items: center;">
            <div style="display:flex; gap: 5px; justify-content: center; padding: 0 0 5px;align-items: center;">
                <fieldset>
                    <legend>Sắp xếp</legend>
                    <form action="" method="post" class="admin__form-search">
                        <select name="sort-rental-property-admin" onchange="this.form.submit()">
                            <option value="desc" <?php if ($_SESSION['sort-rental-property-admin'] === 'desc') echo 'selected'; ?>>
                                Mới nhất
                            </option>
                            <option value="asc" <?php if ($_SESSION['sort-rental-property-admin'] === 'asc') echo 'selected'; ?>>
                                Cũ nhất
                            </option>
                        </select>
                    </form>
                </fieldset>
                <fieldset>
                    <legend>Khu vực</legend>
                    <form action="" method="post" class="admin__form-search">
                        <select name="sort-rental-property-location-admin" onchange="this.form.submit()">
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
                    </form>
                </fieldset>
                <fieldset>
                    <legend>Loại</legend>
                    <form action="" method="post" class="admin__form-search">
                        <select name="sort-rental-type-admin" onchange="this.form.submit()">
                            <option value="all" <?php if ($_SESSION['sort-rental-type-admin'] === 'all') echo 'selected'; ?>>
                                Tất cả
                            </option>
                            <?php foreach ($listTypeRentalProperty as $expertises) { ?>
                                <option value="<?php echo htmlspecialchars($expertises['id']); ?>"
                                    <?php if ($_SESSION['sort-rental-type-admin'] == $expertises['id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($expertises['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </form>
                </fieldset>
            </div>
       </div>
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th style="width: 0%; text-align: center;">STT</th>
                        <th style="display: none;">ID</th>
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
                        }elseif ($value['status'] == 'sold') {
                            $status = 'Đã bán';
                        }
                         else {
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
                        <tr data-property-id="<?= $value['id'] ?>">
                            <td data-label="STT" style="text-align: center;"><?= $stt ?></td>
                            <td data-label="ID" style="display: none;"><?= $value['id'] ?></td>
                            <td data-label="Tiêu đề"><?= htmlspecialchars($value['title']) ?></td>
                            <td data-label="Ảnh bìa" style="text-align: center;">
                                <?php if (!empty($mainImage) || $mainImage !== null) { ?>
                                    <img style="width: 80px; text-align: center;" src="../uploads/property/<?= htmlspecialchars($mainImage) ?>"  alt="<?= htmlspecialchars($value['title']) ?>">
                                <?php } else{ ?>
                                     <img style="width: 80px; text-align: center;" src="../uploads/system/default_property.jpg"  alt="<?= htmlspecialchars($value['title']) ?>">
                                <?php } ?>
                            </td>
                            <td data-label="Khu vực" style="text-align: center;"><?= htmlspecialchars($value['location_name']) ?></td>
                            <td data-label="Loại" style="text-align: center;"><?= htmlspecialchars($value['property_type_name']) ?></td>
                            <td data-label="Ngày đăng" style="text-align: center;"><?= date("d-m-Y", strtotime($value['createdAt'])) ?></td>
                            <td data-label="Lượt xem" style="text-align: center;"><?= htmlspecialchars($value['views']) ?></td>
                            <td data-label="Trạng thái" style="text-align: center;"><?= $status ?></td>
                            <td data-label="Hành động" style="text-align: center;">
                                <button class="action-button edit">Xem</button>
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
    <div class="modal-content" style="max-width: 800px; !important;">
        <span class="close-button">&times;</span>
        <h3 id="modalTitle">Chi tiết bất động sản</h3>
        <form id="apartmentForm">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                <div>  
                    <label for="modal-title">Tiêu đề:</label>
                    <input style="width:92%; margin-bottom: 5px;" type="text" id="modal-title"><br></div>
                <div>
                    <label for="modal-description">Mô tả:</label>
                    <input style="width:92%; margin-bottom: 5px;" type="text" id="modal-description"><br></div>
                <div>
                    <label for="modal-address">Địa chỉ:</label>
                    <input style="width:92%; margin-bottom: 5px;" type="text" id="modal-address"><br></div>
            </div>
             <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                <div>
                    <label for="modal-location_name">Khu vực:</label>
                    <input style="width:92%; margin-bottom: 5px;" name="modal-location_name" id="modal-location_name">
                </div>
                <div>
                    <label for="modal-type_name">Loại:</label>
                    <input style="width:92%; margin-bottom: 5px;" name="modal-type_name" id="modal-type_name"></div>
                <div>  
                    <label for="modal-broker">Môi giới:</label>
                    <input style="width:92%; margin-bottom: 5px;" type="text" id="modal-broker"><br></div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                <div>
                    <label for="modal-status">Trạng thái:</label>
                    <input style="width:92%; margin-bottom: 5px;" id="modal-status">
                </div>
                <div>
                    <label for="modal-transactionType">Loại giao dịch:</label>
                    <input style="width:92%; margin-bottom: 5px;" id="modal-transactionType">
                </div>
                <div>
                    <label for="modal-price">Giá(VNĐ):</label>
                    <input style="width:92%; margin-bottom: 5px;" type="number" id="modal-price" min="0" ><br></div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                <div>
                    <label for="modal-area">Diện tích:</label>
                    <input style="width:92%; margin-bottom: 5px;" type="text" id="modal-area"><br>
                </div>
                <div>  
                    <label for="modal-bedrooms">Số phòng ngủ:</label>
                    <input style="width:92%; margin-bottom: 5px;" type="text" id="modal-bedrooms"><br>
                </div>  
                <div>  
                    <label for="modal-bathrooms">Số phòng tắm:</label>
                    <input style="width:92%; margin-bottom: 5px;" type="text" id="modal-bathrooms"><br>
                </div>  
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                <div>
                    <label for="modal-floors">Số tầng:</label>
                    <input style="width:92%; margin-bottom: 5px;" type="text" id="modal-floors"><br>
                </div>
                <div>  
                    <label for="modal-frontage">Mặt tiền:</label>
                    <input style="width:92%; margin-bottom: 5px;" type="text" id="modal-frontage"><br>
                </div>  
                 <div>
                    <label for="modal-furniture">Nội thất:</label>
                    <input style="width:92%; margin-bottom: 5px;" id="modal-furniture">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                 <div>
                    <label for="modal-parking">Bãi đậu xe:</label>
                    <input style="width:92%; margin-bottom: 5px;" id="modal-parking">
                </div>
                 <div>
                    <label for="modal-createdAt">Ngày tạo:</label>
                    <input style="width:92%; margin-bottom: 5px;" type="text" id="modal-createdAt"><br>
                </div>  
                 <div>
                    <label for="modal-updatedAt">Ngày cập nhật:</label>
                    <input style="width:92%; margin-bottom: 5px;" type="text" id="modal-updatedAt"><br>
                </div>  
            </div>
        </form>
    </div>
</div>

<script src="./views/js/rentalProperty.js"></script>