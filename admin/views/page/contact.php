<div class="main-content">
    <header class="top-header">
        <h2>Quản lý Yêu cầu & Hỗ trợ</h2>
        <div class="user-info">
            <span>Xin chào, Admin!</span>
            <button>Đăng xuất</button>
        </div>
    </header>
    <div class="content-area">
        <div class="controls">
            <div class="filter-section">
                <label for="filter-ticket-status">Lọc theo trạng thái:</label>
                <select id="filter-ticket-status">
                    <option value="all">Tất cả</option>
                    <option value="new">Mới</option>
                    <option value="in-progress">Đang xử lý</option>
                    <option value="resolved">Đã hoàn thành</option>
                    <option value="closed">Đã đóng</option>
                    <option value="rejected">Bị từ chối</option>
                </select>
            </div>
            <div class="search-section">
                <input type="text" placeholder="Tìm kiếm yêu cầu..." class="search-input">
                <button class="search-button">Tìm</button>
            </div>
            <button class="add-ticket-button">Tạo yêu cầu mới</button>
        </div>

        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Người gửi</th>
                        <th>Căn hộ</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>RQ001</td>
                        <td>Sửa vòi nước nhà vệ sinh</td>
                        <td>Nguyễn Thị D</td>
                        <td>A101</td>
                        <td>2025-07-18</td>
                        <td><span class="status new">Mới</span></td>
                        <td>
                            <button class="action-button view">Xem</button>
                            <button class="action-button edit">Sửa</button>
                            <button class="action-button assign">Gán</button>
                        </td>
                    </tr>
                    <tr>
                        <td>RQ002</td>
                        <td>Lỗi Internet tại B203</td>
                        <td>Trần Văn E</td>
                        <td>B203</td>
                        <td>2025-07-17</td>
                        <td><span class="status in-progress">Đang xử lý</span></td>
                        <td>
                            <button class="action-button view">Xem</button>
                            <button class="action-button edit">Sửa</button>
                            <button class="action-button resolved">Hoàn thành</button>
                        </td>
                    </tr>
                    <tr>
                        <td>RQ003</td>
                        <td>Thắc mắc về hóa đơn tiền nước</td>
                        <td>Lê Thị F</td>
                        <td>C305</td>
                        <td>2025-07-16</td>
                        <td><span class="status resolved">Đã hoàn thành</span></td>
                        <td>
                            <button class="action-button view">Xem</button>
                        </td>
                    </tr>
                    <tr>
                        <td>RQ004</td>
                        <td>Phản ánh tiếng ồn</td>
                        <td>Phạm Văn G</td>
                        <td>D402</td>
                        <td>2025-07-15</td>
                        <td><span class="status closed">Đã đóng</span></td>
                        <td>
                            <button class="action-button view">Xem</button>
                        </td>
                    </tr>
                     <tr>
                        <td>RQ005</td>
                        <td>Yêu cầu sửa điều hòa</td>
                        <td>Đỗ Văn H</td>
                        <td>E501</td>
                        <td>2025-07-14</td>
                        <td><span class="status rejected">Bị từ chối</span></td>
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

<div id="ticketModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h3 id="modalTicketTitle">Chi tiết Yêu cầu</h3>
        <form id="ticketForm">
            <label for="modal-ticket-id">ID Yêu cầu:</label>
            <input type="text" id="modal-ticket-id" readonly><br>

            <label for="modal-ticket-title">Tiêu đề:</label>
            <input type="text" id="modal-ticket-title" required><br>

            <label for="modal-ticket-sender">Người gửi:</label>
            <input type="text" id="modal-ticket-sender" required><br>

            <label for="modal-ticket-apartment">Căn hộ liên quan:</label>
            <input type="text" id="modal-ticket-apartment"><br>

            <label for="modal-ticket-content">Nội dung yêu cầu:</label>
            <textarea id="modal-ticket-content" rows="6" required></textarea><br>

            <label for="modal-ticket-date">Ngày gửi:</label>
            <input type="date" id="modal-ticket-date" readonly><br>

            <label for="modal-ticket-status">Trạng thái:</label>
            <select id="modal-ticket-status">
                <option value="new">Mới</option>
                <option value="in-progress">Đang xử lý</option>
                <option value="resolved">Đã hoàn thành</option>
                <option value="closed">Đã đóng</option>
                <option value="rejected">Bị từ chối</option>
            </select><br>

            <label for="modal-ticket-handler">Người xử lý:</label>
            <input type="text" id="modal-ticket-handler"><br>

            <label for="modal-ticket-notes">Ghi chú nội bộ:</label>
            <textarea id="modal-ticket-notes" rows="4"></textarea><br>

            <button type="submit" id="saveTicketButton">Lưu</button>
            <button type="button" id="cancelModalButton">Hủy</button>
        </form>
    </div>
</div>

<div id="confirmTicketActionModal" class="modal">
    <div class="modal-content small-modal">
        <span class="close-button" id="closeConfirmTicketAction">&times;</span>
        <h3 id="confirmTicketActionTitle">Xác nhận</h3>
        <p id="confirmTicketActionMessage"></p>
        <div class="modal-actions">
            <button id="confirmTicketActionButton" class="action-button">Xác nhận</button>
            <button id="cancelConfirmButton" class="action-button view">Hủy</button>
        </div>
    </div>
</div>

<script src="./views/js/contact.js"></script>