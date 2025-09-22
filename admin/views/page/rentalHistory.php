<div class="main-content">
    <header class="top-header">
        <h2>Lịch sử thuê căn hộ</h2>
        <div class="user-info">
            <span>Xin chào, Admin!</span>
            <button>Đăng xuất</button>
        </div>
    </header>
    <div class="content-area">
        <div class="controls">
            <div class="filter-section">
                <label for="filter">Lọc theo trạng thái:</label>
                <select id="filter">
                    <option value="all">Tất cả</option>
                    <option value="active">Đang thuê</option>
                    <option value="completed">Đã hoàn tất</option>
                    <option value="cancelled">Đã hủy</option>
                </select>
            </div>
            <div class="search-section">
                <input type="text" placeholder="Tìm kiếm hợp đồng..." class="search-input">
                <button class="search-button">Tìm</button>
            </div>
            <button class="add-rental-button">Thêm hợp đồng thuê</button>
        </div>

        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã HĐ</th>
                        <th>Tên căn hộ</th>
                        <th>Người thuê</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Giá thuê (tháng)</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>HD001</td>
                        <td>Căn hộ A101</td>
                        <td>Nguyễn Thị D</td>
                        <td>2024-01-01</td>
                        <td>2024-12-31</td>
                        <td>8.000.000 VNĐ</td>
                        <td><span class="status active-rental">Đang thuê</span></td>
                        <td>
                            <button class="action-button view">Xem</button>
                            <button class="action-button edit">Sửa</button>
                            <button class="action-button cancel-rental">Hủy HĐ</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>HD002</td>
                        <td>Căn hộ B203</td>
                        <td>Trần Văn E</td>
                        <td>2023-05-10</td>
                        <td>2024-05-10</td>
                        <td>12.000.000 VNĐ</td>
                        <td><span class="status completed-rental">Đã hoàn tất</span></td>
                        <td>
                            <button class="action-button view">Xem</button>
                            </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>HD003</td>
                        <td>Căn hộ C305</td>
                        <td>Lê Thị F</td>
                        <td>2024-07-01</td>
                        <td>2025-06-30</td>
                        <td>6.500.000 VNĐ</td>
                        <td><span class="status active-rental">Đang thuê</span></td>
                        <td>
                            <button class="action-button view">Xem</button>
                            <button class="action-button edit">Sửa</button>
                            <button class="action-button cancel-rental">Hủy HĐ</button>
                        </td>
                    </tr>
                     <tr>
                        <td>4</td>
                        <td>HD004</td>
                        <td>Căn hộ A101</td>
                        <td>Phạm Văn G</td>
                        <td>2023-01-01</td>
                        <td>2023-12-31</td>
                        <td>8.000.000 VNĐ</td>
                        <td><span class="status completed-rental">Đã hoàn tất</span></td>
                        <td>
                            <button class="action-button view">Xem</button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>HD005</td>
                        <td>Căn hộ D402</td>
                        <td>Hoàng Thị H</td>
                        <td>2024-06-01</td>
                        <td>2024-06-05</td>
                        <td>7.000.000 VNĐ</td>
                        <td><span class="status cancelled-rental">Đã hủy</span></td>
                        <td>
                            <button class="action-button view">Xem</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <button class="page-button disabled">Trước</button>
            <button class="page-button active">1</button>
            <button class="page-button">2</button>
            <button class="page-button">3</button>
            <button class="page-button">Sau</button>
        </div>
    </div>
</div>

<div id="rentalModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h3 id="modalTitle">Chi tiết hợp đồng thuê</h3>
        <form id="rentalForm">
            <label for="modal-contract-id">Mã HĐ:</label>
            <input type="text" id="modal-contract-id" readonly><br>

            <label for="modal-apartment-name">Tên căn hộ:</label>
            <input type="text" id="modal-apartment-name" required><br>

            <label for="modal-tenant-name">Người thuê:</label>
            <input type="text" id="modal-tenant-name" required><br>

            <label for="modal-start-date">Ngày bắt đầu:</label>
            <input type="date" id="modal-start-date" required><br>

            <label for="modal-end-date">Ngày kết thúc:</label>
            <input type="date" id="modal-end-date" required><br>

            <label for="modal-monthly-price">Giá thuê (tháng):</label>
            <input type="number" id="modal-monthly-price" min="0" required><br>

            <label for="modal-rental-status">Trạng thái:</label>
            <select id="modal-rental-status">
                <option value="active">Đang thuê</option>
                <option value="completed">Đã hoàn tất</option>
                <option value="cancelled">Đã hủy</option>
            </select><br>

            <button type="submit" id="saveRentalButton">Lưu</button>
            <button type="button" id="cancelModalButton">Hủy</button>
        </form>
    </div>
</div>

<div id="cancelRentalConfirmModal" class="modal">
    <div class="modal-content small-modal">
        <span class="close-button" id="closeCancelRentalConfirm">&times;</span>
        <h3>Xác nhận hủy hợp đồng</h3>
        <p>Bạn có chắc chắn muốn hủy hợp đồng <strong id="rentalIdToCancel"></strong> của căn hộ <strong id="apartmentNameToCancel"></strong> không?</p>
        <div class="modal-actions">
            <button id="confirmCancelRentalButton" class="action-button cancel-rental">Hủy HĐ</button>
            <button id="cancelConfirmButton" class="action-button view">Hủy</button>
        </div>
    </div>
</div>

<script src="./views/js/rentalHistory.js"></script>