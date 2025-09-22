<div class="main-content">
    <header class="top-header">
        <h2>Quản Lý Loại Tin Tức</h2>
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
                        <input type="text" value="<?php echo isset($_SESSION['search-type-news']) && $_SESSION['search-type-news'] !== '' ? htmlspecialchars($_SESSION['search-type-news']) : ''; ?>" name="search-type-news" placeholder="Tên thể loại" autocomplete="off">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </fieldset>
                <fieldset>
                    <legend>Sắp xếp</legend>
                    <form action="" method="post" class="admin__form-search">
                        <select name="sort-type-news" id="">
                            <option value="desc" <?php if ($_SESSION['sort-type-news'] === 'desc') echo 'selected' ?>>
                                Mới nhất
                            </option>
                            <option value="asc" <?php if ($_SESSION['sort-type-news'] === 'asc') echo 'selected' ?>>Cũ
                                nhất
                            </option>
                        </select>
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </fieldset>
            </div>
            <button class="add-typeNews-button"><i class="fa-solid fa-plus"></i> Thêm Loại Tin Tức</button>
        </div>
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%; text-align: center;">STT</th>
                        <th style="width: 40%">Tên</th>
                        <th style="width: 34%">Mô tả</th>
                        <th style="display: none">typeId</th>
                        <th style="width: 6%">Số tin</th>
                        <th style="width: 15%; text-align: center;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = (($current_page - 1) * $limit) + 1;
                    foreach ($listTypeNews as $key => $value) {
                    ?>
                        <tr>
                            <td data-label="STT" style="text-align: center;"><?= $stt ?></td>
                            <td data-label="Tên"><?= $value["name"] ?></td>
                            <td data-label="Mô tả"><?= $value["description"] ?></td>
                            <td data-label="Mã" style="display: none"><?= $value["id"] ?></td>
                            <td data-label="Số tin" style="text-align: center;"><?= $value["newsCount"] ?></td>
                            <td data-label="Hành động" style="text-align: center;">
                                <button class="action-button view">Xem</button>
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
                        echo ' <a href="?act=typeNews&page=' . ($current_page - 1) . '"><button class="page-button"><i class="fa-solid fa-angle-left"></i></button></a>';
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($i != $current_page) {
                            if ($i > $current_page - 3 && $i < $current_page + 3) {
                                echo '<a href="?act=typeNews&page=' . $i . '"><button class="page-button">' . $i . '</button></a>';
                            }
                        } else {
                            echo '<button class="page-button active" disable>' . $i . '</button>';
                        }
                    }
                    if ($current_page < $total_page) {
                        echo ' <a href="?act=typeNews&page=' . ($current_page + 1) . '"><button class="page-button"><i class="fa-solid fa-angle-right"></i></button></a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div id="addFormArea" class="modal">
        <div class="modal-content">
            <span class="close-button" id="cancelAddButton">&times;</span>
            <h3 style="color:dodgerblue">THÊM LOẠI TIN TỨC MỚI</h3>
            <form id="addTypeNewsForm">
                <div>
                    <label for="add-name"><i class="fa-solid fa-signature"></i> Tên thể loại:</label>
                    <input type="text" id="add-name" required>
                    <label for="add-description"><i class="fa-solid fa-image-portrait"></i> Mô tả:</label>
                    <textarea id="add-description"></textarea>
                    <button type="submit" class="action-button add">Thêm</button>
                </div>
            </form>
        </div>
    </div>

    <div id="typeNewsModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h3 id="modalTitle" style="color:dodgerblue">CHI TIẾT LOẠI TIN TỨC</h3>
            <form id="typeNewsForm">
                <div>
                    <label for="modal-name"><i class="fa-solid fa-signature"></i> Tên loại:</label>
                    <input type="text" id="modal-name" required>
                    <label for="modal-description"><i class="fa-regular fa-rectangle-list"></i> Mô tả:</label>
                    <textarea name="" id="modal-description"></textarea>
                    <input style="display:none" type="text" id="modal-typeId">
                    <button type="submit" id="saveTypeNewsButton" style="background-color: #218838; color: white">Lưu</button>
                    <button type="button" id="cancelButton" class="action-button view">Hủy</button>
                </div>
            </form>
        </div>
    </div>
    <div id="deleteConfirmModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeDeleteConfirm">&times;</span>
            <h3>Xác Nhận Xóa</h3>
            <p>Bạn có chắc chắn muốn xóa loại tin tức này không?</p>
            <div class="modal-actions">
                <button id="confirmDeleteButton" class="action-button del">Xóa</button>
                <button id="cancelDeleteButton" class="action-button view">Hủy</button>
            </div>
        </div>
    </div>
    <script src="./views/js/typeNews.js"></script>