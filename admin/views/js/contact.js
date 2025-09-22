document.addEventListener('DOMContentLoaded', () => {
    // Lấy các phần tử DOM của modal chính (chi tiết yêu cầu)
    const ticketModal = document.getElementById('ticketModal');
    const closeTicketModalButton = ticketModal ? ticketModal.querySelector('.close-button') : null;
    const cancelModalButton = document.getElementById('cancelModalButton'); // Nút hủy trong modal chính
    const ticketForm = document.getElementById('ticketForm');
    const saveTicketButton = document.getElementById('saveTicketButton');
    const modalTicketTitle = document.getElementById('modalTicketTitle'); // Tiêu đề modal chính

    // Lấy các phần tử DOM của modal xác nhận
    const confirmTicketActionModal = document.getElementById('confirmTicketActionModal');
    const closeConfirmTicketActionModalButton = document.getElementById('closeConfirmTicketAction');
    const confirmTicketActionButton = document.getElementById('confirmTicketActionButton');
    const cancelConfirmButton = document.getElementById('cancelConfirmButton');
    const confirmTicketActionTitle = document.getElementById('confirmTicketActionTitle');
    const confirmTicketActionMessage = document.getElementById('confirmTicketActionMessage');

    const dataTable = document.querySelector('.data-table table tbody');

    let currentTicketIdForAction = null; // Để lưu ID yêu cầu cần thao tác
    let currentActionType = ''; // 'delete', 'resolved', 'assign', 'reject'
    let isAdding = false; // true nếu đang tạo mới, false nếu đang sửa/xem

    const addTicketButton = document.querySelector('.add-ticket-button');

    // Hàm để mở modal chi tiết yêu cầu
    function openTicketModal() {
        if (ticketModal) {
            ticketModal.style.display = 'flex'; // Dùng flex để căn giữa
        }
    }

    // Hàm để đóng modal chi tiết yêu cầu
    function closeTicketModal() {
        if (ticketModal) {
            ticketModal.style.display = 'none';
            if (ticketForm) {
                ticketForm.reset(); // Đặt lại form về trạng thái ban đầu
            }
            // Đặt lại trạng thái mặc định của các trường sau khi đóng
            document.getElementById('modal-ticket-id').readOnly = true; // ID luôn readonly
            document.getElementById('modal-ticket-title').readOnly = false;
            document.getElementById('modal-ticket-sender').readOnly = false;
            document.getElementById('modal-ticket-apartment').readOnly = false;
            document.getElementById('modal-ticket-content').readOnly = false;
            document.getElementById('modal-ticket-date').readOnly = true; // Ngày gửi có thể mặc định là readonly khi xem/sửa
            document.getElementById('modal-ticket-status').disabled = false;
            document.getElementById('modal-ticket-handler').readOnly = false;
            document.getElementById('modal-ticket-notes').readOnly = false;
            
            if (saveTicketButton) {
                saveTicketButton.style.display = 'inline-block'; // Mặc định hiển thị nút lưu khi mở, sẽ ẩn nếu là chế độ xem
            }
        }
    }

    // Hàm để mở modal xác nhận thao tác
    function openConfirmActionModal(title, message, actionId, actionType) {
        if (confirmTicketActionTitle) confirmTicketActionTitle.textContent = title;
        if (confirmTicketActionMessage) confirmTicketActionMessage.innerHTML = message;
        currentTicketIdForAction = actionId;
        currentActionType = actionType;

        // Cập nhật text và class cho nút xác nhận
        if (confirmTicketActionButton) {
            confirmTicketActionButton.textContent = 'Xác nhận'; // Mặc định là xác nhận
            confirmTicketActionButton.className = 'action-button'; // Reset class
            if (actionType === 'resolved') {
                confirmTicketActionButton.classList.add('resolved');
            } else if (actionType === 'assign') {
                confirmTicketActionButton.classList.add('assign');
            } else if (actionType === 'reject') {
                confirmTicketActionButton.classList.add('delete'); // Sử dụng màu đỏ như delete cho Reject
            }
            // Thêm các loại hành động khác nếu cần
        }
        
        if (confirmTicketActionModal) {
            confirmTicketActionModal.style.display = 'flex'; // Dùng flex để căn giữa
        }
    }

    // Hàm để đóng modal xác nhận thao tác
    function closeConfirmActionModal() {
        if (confirmTicketActionModal) {
            confirmTicketActionModal.style.display = 'none';
        }
        currentTicketIdForAction = null;
        currentActionType = '';
    }

    // --- Xử lý nút "Tạo yêu cầu mới" ---
    if (addTicketButton) {
        addTicketButton.addEventListener('click', () => {
            isAdding = true;
            if (modalTicketTitle) modalTicketTitle.textContent = 'Tạo Yêu Cầu Mới';
            if (ticketForm) ticketForm.reset(); // Đảm bảo form trống

            // Thiết lập giá trị mặc định cho các trường khi tạo mới
            document.getElementById('modal-ticket-id').value = 'Tự động tạo'; // Hoặc để trống nếu ID được tạo ở backend
            document.getElementById('modal-ticket-date').valueAsDate = new Date(); // Ngày hiện tại

            // Đặt các trường có thể chỉnh sửa
            document.getElementById('modal-ticket-title').readOnly = false;
            document.getElementById('modal-ticket-sender').readOnly = false;
            document.getElementById('modal-ticket-apartment').readOnly = false;
            document.getElementById('modal-ticket-content').readOnly = false;
            document.getElementById('modal-ticket-status').disabled = false;
            document.getElementById('modal-ticket-handler').readOnly = false;
            document.getElementById('modal-ticket-notes').readOnly = false;

            if (saveTicketButton) saveTicketButton.style.display = 'inline-block'; // Hiện nút Lưu
            openTicketModal();
        });
    }

    // --- Trình nghe sự kiện cho các nút trong bảng (Sử dụng Event Delegation) ---
    if (dataTable) {
        dataTable.addEventListener('click', (event) => {
            const target = event.target;
            const row = target.closest('tr');
            if (!row) return;

            const cells = row.querySelectorAll('td');
            const ticketId = cells[0].textContent;
            const title = cells[1].textContent;
            const sender = cells[2].textContent;
            const apartment = cells[3].textContent;
            const dateSent = cells[4].textContent;
            const statusElement = cells[5].querySelector('.status');
            const statusText = statusElement ? statusElement.textContent.trim() : '';
            // Lấy thêm nội dung yêu cầu, người xử lý, ghi chú từ API/đối tượng thực tế
            const content = `Nội dung chi tiết của yêu cầu "${title}" từ ${sender}. Đây là dữ liệu mẫu.`;
            const handler = "Chưa gán"; // Dữ liệu mẫu
            const notes = "Chưa có ghi chú."; // Dữ liệu mẫu


            if (target.classList.contains('action-button')) {
                if (target.classList.contains('view')) {
                    isAdding = false;
                    if (modalTicketTitle) modalTicketTitle.textContent = 'Chi tiết Yêu cầu';
                    
                    document.getElementById('modal-ticket-id').value = ticketId;
                    document.getElementById('modal-ticket-title').value = title;
                    document.getElementById('modal-ticket-sender').value = sender;
                    document.getElementById('modal-ticket-apartment').value = apartment;
                    document.getElementById('modal-ticket-content').value = content; 
                    document.getElementById('modal-ticket-date').value = dateSent;
                    document.getElementById('modal-ticket-handler').value = handler;
                    document.getElementById('modal-ticket-notes').value = notes;

                    const modalStatusSelect = document.getElementById('modal-ticket-status');
                    if (modalStatusSelect) {
                        for (let i = 0; i < modalStatusSelect.options.length; i++) {
                            if (modalStatusSelect.options[i].text === statusText) {
                                modalStatusSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }

                    // Đặt các trường chỉ đọc cho chế độ "Xem"
                    document.getElementById('modal-ticket-id').readOnly = true;
                    document.getElementById('modal-ticket-title').readOnly = true;
                    document.getElementById('modal-ticket-sender').readOnly = true;
                    document.getElementById('modal-ticket-apartment').readOnly = true;
                    document.getElementById('modal-ticket-content').readOnly = true;
                    document.getElementById('modal-ticket-date').readOnly = true;
                    document.getElementById('modal-ticket-status').disabled = true;
                    document.getElementById('modal-ticket-handler').readOnly = true;
                    document.getElementById('modal-ticket-notes').readOnly = true;


                    if(saveTicketButton) saveTicketButton.style.display = 'none'; // Ẩn nút lưu khi chỉ xem

                    openTicketModal();
                } else if (target.classList.contains('edit')) {
                    isAdding = false;
                    if (modalTicketTitle) modalTicketTitle.textContent = 'Chỉnh sửa Yêu cầu';

                    document.getElementById('modal-ticket-id').value = ticketId;
                    document.getElementById('modal-ticket-title').value = title;
                    document.getElementById('modal-ticket-sender').value = sender;
                    document.getElementById('modal-ticket-apartment').value = apartment;
                    document.getElementById('modal-ticket-content').value = content;
                    document.getElementById('modal-ticket-date').value = dateSent;
                    document.getElementById('modal-ticket-handler').value = handler;
                    document.getElementById('modal-ticket-notes').value = notes;

                    const modalStatusSelect = document.getElementById('modal-ticket-status');
                    if (modalStatusSelect) {
                        for (let i = 0; i < modalStatusSelect.options.length; i++) {
                            if (modalStatusSelect.options[i].text === statusText) {
                                modalStatusSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }

                    // Cho phép chỉnh sửa các trường
                    document.getElementById('modal-ticket-id').readOnly = true;
                    document.getElementById('modal-ticket-title').readOnly = false;
                    document.getElementById('modal-ticket-sender').readOnly = false;
                    document.getElementById('modal-ticket-apartment').readOnly = false;
                    document.getElementById('modal-ticket-content').readOnly = false;
                    document.getElementById('modal-ticket-date').readOnly = true; // Ngày gửi thường không sửa
                    document.getElementById('modal-ticket-status').disabled = false;
                    document.getElementById('modal-ticket-handler').readOnly = false;
                    document.getElementById('modal-ticket-notes').readOnly = false;

                    if(saveTicketButton) saveTicketButton.style.display = 'inline-block'; // Hiện nút Lưu
                    openTicketModal();
                } else if (target.classList.contains('assign')) {
                    const msg = `Bạn có muốn gán yêu cầu **"${title}"** cho một người xử lý không?`;
                    openConfirmActionModal('Gán Yêu cầu', msg, ticketId, 'assign');
                } else if (target.classList.contains('resolved')) {
                    const msg = `Bạn có chắc chắn muốn đánh dấu yêu cầu **"${title}"** là **đã hoàn thành** không?`;
                    openConfirmActionModal('Hoàn thành Yêu cầu', msg, ticketId, 'resolved');
                }
                // Thêm logic cho các nút hành động khác nếu có (ví dụ: reject)
            }
        });
    }

    // --- Xử lý đóng modal ---
    if (closeTicketModalButton) closeTicketModalButton.addEventListener('click', closeTicketModal);
    if (cancelModalButton) cancelModalButton.addEventListener('click', closeTicketModal);
    if (closeConfirmTicketActionModalButton) closeConfirmTicketActionModalButton.addEventListener('click', closeConfirmActionModal);
    if (cancelConfirmButton) cancelConfirmButton.addEventListener('click', closeConfirmActionModal);

    // Đóng modal nếu nhấp ra ngoài
    window.addEventListener('click', (event) => {
        if (ticketModal && event.target === ticketModal) {
            closeTicketModal();
        }
        if (confirmTicketActionModal && event.target === confirmTicketActionModal) {
            closeConfirmActionModal();
        }
    });

    // --- Xử lý gửi biểu mẫu trong ticketModal (Thêm mới HOẶC Cập nhật) ---
    if (ticketForm) {
        ticketForm.addEventListener('submit', (event) => {
            event.preventDefault();

            const ticketData = {
                id: document.getElementById('modal-ticket-id')?.value,
                title: document.getElementById('modal-ticket-title')?.value,
                sender: document.getElementById('modal-ticket-sender')?.value,
                apartment: document.getElementById('modal-ticket-apartment')?.value,
                content: document.getElementById('modal-ticket-content')?.value,
                dateSent: document.getElementById('modal-ticket-date')?.value,
                status: document.getElementById('modal-ticket-status')?.value,
                handler: document.getElementById('modal-ticket-handler')?.value,
                notes: document.getElementById('modal-ticket-notes')?.value
            };

            if (isAdding) {
                console.log('Tạo yêu cầu mới:', ticketData);
                alert('Đã tạo yêu cầu mới! (Xem console để biết chi tiết)');
                // Gửi dữ liệu này đến máy chủ để tạo yêu cầu mới
            } else {
                console.log('Cập nhật yêu cầu:', ticketData);
                alert(`Đã cập nhật yêu cầu "${ticketData.title}"! (Xem console để biết chi tiết)`);
                // Gửi dữ liệu này đến máy chủ để cập nhật
            }
            
            closeTicketModal();
        });
    }

    // Xử lý xác nhận hành động (resolved, assign, reject)
    if (confirmTicketActionButton) {
        confirmTicketActionButton.addEventListener('click', () => {
            if (currentTicketIdForAction && currentActionType) {
                if (currentActionType === 'resolved') {
                    console.log('Xác nhận hoàn thành yêu cầu ID:', currentTicketIdForAction);
                    alert(`Đã đánh dấu yêu cầu ID: ${currentTicketIdForAction} là hoàn thành!`);
                    // Thực hiện AJAX call để cập nhật trạng thái trên server
                } else if (currentActionType === 'assign') {
                    console.log('Xác nhận gán yêu cầu ID:', currentTicketIdForAction);
                    alert(`Đã gán yêu cầu ID: ${currentTicketIdForAction} (trong ứng dụng thực sẽ có form chọn người xử lý)!`);
                    // Thực hiện AJAX call để gán yêu cầu trên server
                } else if (currentActionType === 'reject') {
                    console.log('Xác nhận từ chối yêu cầu ID:', currentTicketIdForAction);
                    alert(`Đã từ chối yêu cầu ID: ${currentTicketIdForAction}!`);
                    // Thực hiện AJAX call để từ chối yêu cầu trên server
                }
                // Sau khi thành công, bạn có thể cần cập nhật lại bảng HTML
            }
            closeConfirmActionModal(); // Đóng modal xác nhận sau khi xử lý
        });
    }
});