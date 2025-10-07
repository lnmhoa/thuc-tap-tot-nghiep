<div class="main-content">
    <header class="top-header">
        <h2>Quản Lý Tin Tức</h2>
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
                    <legend>Tìm kiếm</legend>
                    <form action="" method="post" class="admin__form-search">
                        <input type="text" value="<?php echo isset($_SESSION['search-news']) && $_SESSION['search-news'] !== '' ? htmlspecialchars($_SESSION['search-news']) : ''; ?>" name="search-news" placeholder="Tiêu đề tin tức" autocomplete="off">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </fieldset>
                <fieldset>
                    <legend>Sắp xếp</legend>
                    <form action="" method="post" class="admin__form-search">
                        <select name="sort-news" id="" onchange="this.form.submit()">
                            <option value="desc" <?php if ($_SESSION['sort-news'] === 'desc') echo 'selected' ?>>
                                Mới nhất
                            </option>
                            <option value="asc" <?php if ($_SESSION['sort-news'] === 'asc') echo 'selected' ?>>Cũ
                                nhất
                            </option>
                        </select>
                    </form>
                </fieldset>
            </div>
            <button class="add-news-button"><i class="fa-solid fa-plus"></i> Thêm Tin Tức</button>
        </div>
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%; text-align: center;">STT</th>
                        <th style="width: 36%">Tiêu đề</th>
                        <th style="width: 10% ;text-align: center;">Ảnh bìa</th>
                        <th style="display: none">Nội dung</th>
                        <th style="width: 10%;">Thể loại</th>
                        <th style="width: 10%">Ngày đăng</th>
                        <th style="width: 9%">Lượt xem</th>
                        <th style="display: none">newsId</th>
                        <th style="width: 20%; text-align: center;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stt = (($current_page - 1) * $limit) + 1;
                    foreach ($listNews as $key => $value) {
                    ?>
                        <tr>
                            <td data-label="STT" style="text-align: center;"><?= $stt ?></td>
                            <td data-label="Tiêu đề"><?= $value["title"] ?></td>
                            <td data-label="Ảnh bìa"><img style="width: 80px; text-align: center;" <?php if ($value["image"] === '') { echo 'src="../uploads/system/default_news.jpg"'; } else { echo 'src="../uploads/news/' . $value["image"] . '"'; } ?> alt="" srcset=""></td>
                            <td data-label="Nội dung" style="display: none"><?= $value["content"] ?></td>
                            <td data-label="Thể loại" class="type-news-class"><?= $value["typeName"] ?></td>
                            <td data-label="Ngày đăng" style="text-align: center;"><?= date("d-m-Y", strtotime($value["createdAt"])) ?></td>
                            <td data-label="Lượt xem" style="text-align: center;"><?= $value["views"] ?></td>
                            <td data-label="Mã" style="display: none"><?= $value["id"] ?></td>
                            <td data-label="Hành động" style="justify-content: center; display: flex;">
                                <button class="action-button edit">Sửa</button>
                                <button class="action-button del">Xóa</button>                                <?php if ($value['pin'] == 0) { ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="news-id" value="<?= $value['id'] ?>">
                                    <button class="action-button edit pin-news" name="change-pin" style="background-color: orange;">Ghim</button>
                                    </form>
                                <?php } else { ?>
                                                                       <button class="action-button edit pin-news" style="background-color: gray;" disabled>Ghim</button>
                                <?php } ?>
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
                        echo ' <a href="?act=news&page=' . ($current_page - 1) . '"><button class="page-button"><i class="fa-solid fa-angle-left"></i></button></a>';
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($i != $current_page) {
                            if ($i > $current_page - 3 && $i < $current_page + 3) {
                                echo '<a href="?act=news&page=' . $i . '"><button class="page-button">' . $i . '</button></a>';
                            }
                        } else {
                            echo '<button class="page-button active" disable>' . $i . '</button>';
                        }
                    }
                    if ($current_page < $total_page) {
                        echo ' <a href="?act=news&page=' . ($current_page + 1) . '"><button class="page-button"><i class="fa-solid fa-angle-right"></i></button></a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div id="addFormArea" class="modal">
        <div class="modal-content">
            <span class="close-button" id="cancelAddButton">&times;</span>
            <h3 style="color:dodgerblue">THÊM TIN TỨC MỚI</h3>
            <form id="addNewsForm">
                <div>
                    <label for="add-title"><i class="fa-solid fa-signature"></i> Tiêu đề:</label>
                    <input type="text" id="add-title" required>
                    <label for="add-image"><i class="fa-solid fa-image"></i> Ảnh bìa:</label>
                    <input type="file" id="add-image" style="padding: 7px; width: 99%" name="image" accept="image/*">
                    <label for="add-content" style="margin-bottom: 5px;"><i class="fa-solid fa-image-portrait"></i> Nội dung:</label>
                    <textarea id="add-content"></textarea>
                    <label for="add-type">Loại tin:</label>
                    <select id="add-type">
                        <?php foreach ($listTypeNews as $type) : ?>
                            <option value="<?= $type['id'] ?>"><?= $type['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button style="margin-top: 10px;" type="submit" class="action-button add">Thêm</button>
                </div>
            </form>
        </div>
    </div>

    <div id="newsModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h3 id="modalTitle" style="color:dodgerblue">CHỈNH SỬA TIN TỨC</h3>
            <form id="newsForm">
                <div>
                    <label for="modal-title" style="margin: 5px 0;"><i class="fa-solid fa-signature"></i> Tiêu đề:</label>
                    <input style="margin-bottom: 5px;" type="text" id="modal-title" required>
                    <div style="display: flex; gap: 40px;">
                        <div><label for="modal-image"><i class="fa-solid fa-image"></i> Chọn ảnh bìa mới:</label>
                            <input type="file" id="modal-image" style="padding: 7px; width: 100%; margin-bottom: 5px" name="image" accept="image/*">
                        </div>
                        <div> <label for="modal-type">Loại tin:</label>
                            <select id="modal-type" style="width: 290%; font-size: 12.5px;">
                                <?php foreach ($listTypeNews as $type) : ?>
                                    <option value="<?= $type['id'] ?>"><?= $type['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <label for="modal-content" style="margin: 5px 0;"><i class="fa-regular fa-rectangle-list"></i> Nội dung:</label>
                    <textarea name="" id="modal-content"></textarea>
                    <div style="display: flex; gap: 120px;">
                        <div>
                            <label for="modal-createdAt" style="margin: 5px 0;"><i class="fa-solid fa-calendar-days"></i> Ngày đăng:</label>
                            <input style=" width: 140%" type="text" id="modal-createdAt">
                        </div>
                        <div> <label for="modal-views" style="margin: 5px 0;"><i class="fa-regular fa-eye"></i></i> Lượt xem:</label>
                            <input style="width: 140%" type="text" id="modal-views">
                        </div>
                    </div>
                    <input style="display:none" type="text" id="modal-newsId">
                    <button type="submit" id="saveNewsButton" style="background-color: #218838; color: white">Lưu</button>
                    <button type="button" id="cancelButton" class="action-button view">Hủy</button>
                </div>
            </form>
        </div>
    </div>
    <div id="deleteConfirmModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeDeleteConfirm">&times;</span>
            <h3>Xác Nhận Xóa</h3>
            <p>Bạn có chắc chắn muốn xóa tin tức này không?</p>
            <div class="modal-actions">
                <button id="confirmDeleteButton" class="action-button del">Xóa</button>
                <button id="cancelDeleteButton" class="action-button view">Hủy</button>
            </div>
        </div>
    </div>
    <script src="./views/js/news.js"></script>