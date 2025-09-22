<div class="main-content">
    <header class="top-header">
        <h2>Quản lý Thanh toán & Hóa đơn</h2>
        <div class="user-info">
            <span>Xin chào, Admin!</span>
            <button>Đăng xuất</button>
        </div>
    </header>
    <div class="content-area">
        <div class="controls">
            <div class="filter-section">
                <label for="filter-invoice-status">Lọc theo trạng thái:</label>
                <select id="filter-invoice-status">
                    <option value="all">Tất cả</option>
                    <option value="paid">Đã thanh toán</option>
                    <option value="unpaid">Chưa thanh toán</option>
                    <option value="overdue">Quá hạn</option>
                </select>
            </div>
            <div class="search-section">
                <input type="text" placeholder="Tìm kiếm hóa đơn..." class="search-input">
                <button class="search-button">Tìm</button>
            </div>
            <button class="add-invoice-button">Tạo hóa đơn mới</button>
        </div>

        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>ID Hóa đơn</th>
                        <th>Mã HĐ</th>
                        <th>Người thuê</th>
                        <th>Kỳ hạn</th>
                        <th>Tổng tiền</th>
                        <th>Ngày tạo</th>
                        <th>Ngày đáo hạn</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>INV001</td>
                        <td>HD001</td>
                        <td>Nguyễn Thị D</td>
                        <td>Tháng 7/2025</td>
                        <td>8.500.000 VNĐ</td>
                        <td>2025-07-01</td>
                        <td>2025-07-05</td>
                        <td><span class="status paid">Đã thanh toán</span></td>
                        <td>
                            <button class="action-button view">Xem</button>
                            <button class="action-button print">In</button>
                        </td>
                    </tr>
                    <tr>
                        <td>INV002</td>
                        <td>HD002</td>
                        <td>Trần Văn E</td>
                        <td>Tháng 7/2025</td>
                        <td>12.200.000 VNĐ</td>
                        <td>2025-07-01</td>
                        <td>2025-07-05</td>
                        <td><span class="status unpaid">Chưa thanh toán</span></td>
                        <td>
                            <button class="action-button view">Xem</button>
                            <button class="action-button edit">Sửa</button>
                            <button class="action-button mark-paid">Ghi nhận TT</button>
                        </td>
                    </tr>
                    <tr>
                        <td>INV003</td>
                        <td>HD003</td>
                        <td>Lê Thị F</td>
                        <td>Tháng 6/2025</td>
                        <td>6.800.000 VNĐ</td>
                        <td>2025-06-01</td>
                        <td>2025-06-05</td>
                        <td><span class="status overdue">Quá hạn</span></td>
                        <td>
                            <button class="action-button view">Xem</button>
                            <button class="action-button edit">Sửa</button>
                            <button class="action-button mark-paid">Ghi nhận TT</button>
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

<div id="invoiceModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h3 id="modalInvoiceTitle">Chi tiết Hóa đơn</h3>
        <form id="invoiceForm">
            <label for="modal-invoice-id">ID Hóa đơn:</label>
            <input type="text" id="modal-invoice-id" readonly><br>

            <label for="modal-contract-id">Mã HĐ liên quan:</label>
            <input type="text" id="modal-contract-id" required><br>

            <label for="modal-tenant-name">Người thuê:</label>
            <input type="text" id="modal-tenant-name" required><br>

            <label for="modal-invoice-period">Kỳ hạn:</label>
            <input type="text" id="modal-invoice-period" placeholder="VD: Tháng 7/2025" required><br>

            <label for="modal-total-amount">Tổng tiền (VNĐ):</label>
            <input type="number" id="modal-total-amount" min="0" required><br>

            <label for="modal-invoice-details">Các khoản mục chi tiết:</label>
            <textarea id="modal-invoice-details" rows="5" placeholder="Tiền thuê: 8.000.000; Điện: 200.000; Nước: 50.000; Phí QL: 250.000"></textarea><br>

            <label for="modal-created-date">Ngày tạo:</label>
            <input type="date" id="modal-created-date" required><br>

            <label for="modal-due-date">Ngày đáo hạn:</label>
            <input type="date" id="modal-due-date" required><br>

            <label for="modal-paid-date">Ngày thanh toán:</label>
            <input type="date" id="modal-paid-date"><br>

            <label for="modal-invoice-status">Trạng thái:</label>
            <select id="modal-invoice-status">
                <option value="paid">Đã thanh toán</option>
                <option value="unpaid">Chưa thanh toán</option>
                <option value="overdue">Quá hạn</option>
            </select><br>

            <button type="submit" id="saveInvoiceButton">Lưu</button>
            <button type="button" id="cancelModalButton">Hủy</button>
        </form>
    </div>
</div>

<div id="confirmPaymentModal" class="modal">
    <div class="modal-content small-modal">
        <span class="close-button" id="closeConfirmPayment">&times;</span>
        <h3 id="confirmPaymentTitle">Xác nhận thanh toán</h3>
        <p id="confirmPaymentMessage"></p>
        <div class="modal-actions">
            <button id="confirmPaymentButton" class="action-button mark-paid">Xác nhận</button>
            <button id="cancelConfirmButton" class="action-button view">Hủy</button>
        </div>
    </div>
</div>

<script src="./views/js/payment.js"></script>