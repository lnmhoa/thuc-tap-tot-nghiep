document.addEventListener('DOMContentLoaded', () => {
    // Lấy các phần tử DOM của modal chính (chi tiết hóa đơn)
    const invoiceModal = document.getElementById('invoiceModal'); // Corrected ID
    const closeInvoiceModalButton = invoiceModal ? invoiceModal.querySelector('.close-button') : null;
    const cancelModalButton = document.getElementById('cancelModalButton'); // Nút hủy trong modal chính
    const invoiceForm = document.getElementById('invoiceForm');
    const saveInvoiceButton = document.getElementById('saveInvoiceButton');
    const modalInvoiceTitle = document.getElementById('modalInvoiceTitle'); // Tiêu đề modal chính (Invoice)

    // Lấy các phần tử DOM của modal xác nhận thanh toán
    const confirmPaymentModal = document.getElementById('confirmPaymentModal'); // Corrected ID
    const closeConfirmPaymentModalButton = document.getElementById('closeConfirmPayment'); // Corrected ID
    const confirmPaymentButton = document.getElementById('confirmPaymentButton'); // Corrected ID
    const cancelConfirmButton = document.getElementById('cancelConfirmButton');
    const confirmPaymentTitle = document.getElementById('confirmPaymentTitle'); // Corrected ID
    const confirmPaymentMessage = document.getElementById('confirmPaymentMessage'); // Corrected ID

    const dataTable = document.querySelector('.data-table table tbody');

    let currentInvoiceIdForAction = null; // Để lưu ID hóa đơn cần thao tác
    let currentActionType = ''; // 'mark-paid', 'delete' (nếu có)
    let isAdding = false; // true nếu đang tạo mới, false nếu đang sửa/xem

    const addInvoiceButton = document.querySelector('.add-invoice-button'); // Corrected class name

    // Hàm để mở modal chi tiết hóa đơn
    function openInvoiceModal() {
        if (invoiceModal) {
            invoiceModal.style.display = 'flex'; // Dùng flex để căn giữa
        }
    }

    // Hàm để đóng modal chi tiết hóa đơn
    function closeInvoiceModal() {
        if (invoiceModal) {
            invoiceModal.style.display = 'none';
            if (invoiceForm) {
                invoiceForm.reset(); // Đặt lại form về trạng thái ban đầu
            }
            // Đặt lại trạng thái mặc định của các trường sau khi đóng
            document.getElementById('modal-invoice-id').readOnly = true; // ID luôn readonly
            document.getElementById('modal-contract-id').readOnly = false;
            document.getElementById('modal-tenant-name').readOnly = false;
            document.getElementById('modal-invoice-period').readOnly = false;
            document.getElementById('modal-total-amount').readOnly = false;
            document.getElementById('modal-invoice-details').readOnly = false;
            document.getElementById('modal-created-date').readOnly = false;
            document.getElementById('modal-due-date').readOnly = false;
            document.getElementById('modal-paid-date').readOnly = false;
            document.getElementById('modal-invoice-status').disabled = false;
            
            if (saveInvoiceButton) {
                saveInvoiceButton.style.display = 'inline-block'; // Mặc định hiển thị nút lưu khi mở, sẽ ẩn nếu là chế độ xem
            }
        }
    }

    // Hàm để mở modal xác nhận thao tác (ghi nhận TT)
    function openConfirmPaymentModal(title, message, invoiceId, actionType) {
        if (confirmPaymentTitle) confirmPaymentTitle.textContent = title;
        if (confirmPaymentMessage) confirmPaymentMessage.innerHTML = message;
        currentInvoiceIdForAction = invoiceId;
        currentActionType = actionType;

        // Cập nhật text và class cho nút xác nhận
        if (confirmPaymentButton) {
            if (actionType === 'mark-paid') {
                confirmPaymentButton.textContent = 'Xác nhận';
                confirmPaymentButton.className = 'action-button mark-paid'; // Màu xanh lá cho ghi nhận TT
            }
            // Thêm các loại hành động khác nếu cần
        }
        
        if (confirmPaymentModal) {
            confirmPaymentModal.style.display = 'flex'; // Dùng flex để căn giữa
        }
    }

    // Hàm để đóng modal xác nhận thao tác
    function closeConfirmPaymentModal() {
        if (confirmPaymentModal) {
            confirmPaymentModal.style.display = 'none';
        }
        currentInvoiceIdForAction = null;
        currentActionType = '';
    }

    // --- Xử lý nút "Tạo hóa đơn mới" ---
    if (addInvoiceButton) {
        addInvoiceButton.addEventListener('click', () => {
            isAdding = true;
            if (modalInvoiceTitle) modalInvoiceTitle.textContent = 'Tạo Hóa Đơn Mới';
            if (invoiceForm) invoiceForm.reset(); // Đảm bảo form trống

            // Thiết lập giá trị mặc định cho các trường khi tạo mới
            document.getElementById('modal-invoice-id').value = 'Tự động tạo'; // Hoặc để trống nếu ID được tạo ở backend
            document.getElementById('modal-created-date').valueAsDate = new Date(); // Ngày hiện tại

            // Đặt các trường có thể chỉnh sửa
            document.getElementById('modal-contract-id').readOnly = false;
            document.getElementById('modal-tenant-name').readOnly = false;
            document.getElementById('modal-invoice-period').readOnly = false;
            document.getElementById('modal-total-amount').readOnly = false;
            document.getElementById('modal-invoice-details').readOnly = false;
            document.getElementById('modal-created-date').readOnly = false;
            document.getElementById('modal-due-date').readOnly = false;
            document.getElementById('modal-paid-date').readOnly = false; // Có thể để trống ban đầu
            document.getElementById('modal-invoice-status').disabled = false;
            document.getElementById('modal-invoice-status').value = 'unpaid'; // Mặc định là chưa thanh toán

            if (saveInvoiceButton) saveInvoiceButton.style.display = 'inline-block'; // Hiện nút Lưu
            openInvoiceModal();
        });
    }

    // --- Trình nghe sự kiện cho các nút trong bảng (Sử dụng Event Delegation) ---
    if (dataTable) {
        dataTable.addEventListener('click', (event) => {
            const target = event.target;
            const row = target.closest('tr');
            if (!row) return;

            const cells = row.querySelectorAll('td');
            const invoiceId = cells[0].textContent;
            const contractId = cells[1].textContent;
            const tenantName = cells[2].textContent;
            const invoicePeriod = cells[3].textContent;
            const totalAmount = cells[4].textContent.replace(' VNĐ', '').replace(/\./g, ''); // Loại bỏ VNĐ và dấu chấm
            const createdDate = cells[5].textContent;
            const dueDate = cells[6].textContent;
            const statusElement = cells[7].querySelector('.status');
            const statusText = statusElement ? statusElement.textContent.trim() : '';
            // Giả sử các khoản mục chi tiết và ngày thanh toán được lấy từ một API hoặc lưu trữ riêng
            const invoiceDetails = `Chi tiết hóa đơn cho "${invoicePeriod}": Tiền thuê: ${totalAmount} VNĐ. (Dữ liệu mẫu)`;
            let paidDate = ''; // Mặc định trống nếu chưa thanh toán hoặc lấy từ API

            if (statusText === 'Đã thanh toán') {
                // Trong thực tế, bạn sẽ cần một trường `Ngày thanh toán` trong dữ liệu HTML hoặc từ API
                // Tạm thời, giả sử nó là ngày tạo + vài ngày nếu status là "Đã thanh toán"
                paidDate = createdDate; // placeholder
            }

            if (target.classList.contains('action-button')) {
                if (target.classList.contains('view')) {
                    isAdding = false;
                    if (modalInvoiceTitle) modalInvoiceTitle.textContent = 'Chi tiết Hóa đơn';
                    
                    document.getElementById('modal-invoice-id').value = invoiceId;
                    document.getElementById('modal-contract-id').value = contractId;
                    document.getElementById('modal-tenant-name').value = tenantName;
                    document.getElementById('modal-invoice-period').value = invoicePeriod;
                    document.getElementById('modal-total-amount').value = totalAmount;
                    document.getElementById('modal-invoice-details').value = invoiceDetails; 
                    document.getElementById('modal-created-date').value = createdDate;
                    document.getElementById('modal-due-date').value = dueDate;
                    document.getElementById('modal-paid-date').value = paidDate;

                    const modalStatusSelect = document.getElementById('modal-invoice-status');
                    if (modalStatusSelect) {
                        for (let i = 0; i < modalStatusSelect.options.length; i++) {
                            if (modalStatusSelect.options[i].text === statusText) {
                                modalStatusSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }

                    // Đặt các trường chỉ đọc cho chế độ "Xem"
                    document.getElementById('modal-invoice-id').readOnly = true;
                    document.getElementById('modal-contract-id').readOnly = true;
                    document.getElementById('modal-tenant-name').readOnly = true;
                    document.getElementById('modal-invoice-period').readOnly = true;
                    document.getElementById('modal-total-amount').readOnly = true;
                    document.getElementById('modal-invoice-details').readOnly = true;
                    document.getElementById('modal-created-date').readOnly = true;
                    document.getElementById('modal-due-date').readOnly = true;
                    document.getElementById('modal-paid-date').readOnly = true;
                    document.getElementById('modal-invoice-status').disabled = true;

                    if(saveInvoiceButton) saveInvoiceButton.style.display = 'none'; // Ẩn nút lưu khi chỉ xem

                    openInvoiceModal();
                } else if (target.classList.contains('edit')) {
                    isAdding = false;
                    if (modalInvoiceTitle) modalInvoiceTitle.textContent = 'Chỉnh sửa Hóa đơn';

                    document.getElementById('modal-invoice-id').value = invoiceId;
                    document.getElementById('modal-contract-id').value = contractId;
                    document.getElementById('modal-tenant-name').value = tenantName;
                    document.getElementById('modal-invoice-period').value = invoicePeriod;
                    document.getElementById('modal-total-amount').value = totalAmount;
                    document.getElementById('modal-invoice-details').value = invoiceDetails; 
                    document.getElementById('modal-created-date').value = createdDate;
                    document.getElementById('modal-due-date').value = dueDate;
                    document.getElementById('modal-paid-date').value = paidDate; // Để cho phép chỉnh sửa nếu chưa có

                    const modalStatusSelect = document.getElementById('modal-invoice-status');
                    if (modalStatusSelect) {
                        for (let i = 0; i < modalStatusSelect.options.length; i++) {
                            if (modalStatusSelect.options[i].text === statusText) {
                                modalStatusSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }

                    // Cho phép chỉnh sửa các trường (ID, ngày tạo, ngày thanh toán có thể vẫn readonly tùy nghiệp vụ)
                    document.getElementById('modal-invoice-id').readOnly = true;
                    document.getElementById('modal-contract-id').readOnly = false;
                    document.getElementById('modal-tenant-name').readOnly = false;
                    document.getElementById('modal-invoice-period').readOnly = false;
                    document.getElementById('modal-total-amount').readOnly = false;
                    document.getElementById('modal-invoice-details').readOnly = false;
                    document.getElementById('modal-created-date').readOnly = true; // Thường không sửa ngày tạo
                    document.getElementById('modal-due-date').readOnly = false;
                    document.getElementById('modal-paid-date').readOnly = false;
                    document.getElementById('modal-invoice-status').disabled = false;

                    if(saveInvoiceButton) saveInvoiceButton.style.display = 'inline-block'; // Hiện nút Lưu
                    openInvoiceModal();
                } else if (target.classList.contains('print')) {
                    alert(`In hóa đơn ID: ${invoiceId}. (Tính năng này sẽ mở tab in hoặc tạo PDF)`);
                    console.log('In hóa đơn ID:', invoiceId);
                } else if (target.classList.contains('mark-paid')) {
                    const msg = `Bạn có chắc chắn muốn ghi nhận hóa đơn **"${invoiceId}"** của **${tenantName}** đã được thanh toán không?`;
                    openConfirmPaymentModal('Ghi nhận Thanh toán', msg, invoiceId, 'mark-paid');
                }
            }
        });
    }

    // --- Xử lý đóng modal ---
    if (closeInvoiceModalButton) closeInvoiceModalButton.addEventListener('click', closeInvoiceModal);
    if (cancelModalButton) cancelModalButton.addEventListener('click', closeInvoiceModal);
    if (closeConfirmPaymentModalButton) closeConfirmPaymentModalButton.addEventListener('click', closeConfirmPaymentModal);
    if (cancelConfirmButton) cancelConfirmButton.addEventListener('click', closeConfirmPaymentModal);

    // Đóng modal nếu nhấp ra ngoài
    window.addEventListener('click', (event) => {
        if (invoiceModal && event.target === invoiceModal) {
            closeInvoiceModal();
        }
        if (confirmPaymentModal && event.target === confirmPaymentModal) {
            closeConfirmPaymentModal();
        }
    });

    // --- Xử lý gửi biểu mẫu trong invoiceModal (Thêm mới HOẶC Cập nhật) ---
    if (invoiceForm) {
        invoiceForm.addEventListener('submit', (event) => {
            event.preventDefault();

            const invoiceData = {
                id: document.getElementById('modal-invoice-id')?.value,
                contractId: document.getElementById('modal-contract-id')?.value,
                tenantName: document.getElementById('modal-tenant-name')?.value,
                invoicePeriod: document.getElementById('modal-invoice-period')?.value,
                totalAmount: document.getElementById('modal-total-amount')?.value,
                invoiceDetails: document.getElementById('modal-invoice-details')?.value,
                createdDate: document.getElementById('modal-created-date')?.value,
                dueDate: document.getElementById('modal-due-date')?.value,
                paidDate: document.getElementById('modal-paid-date')?.value,
                status: document.getElementById('modal-invoice-status')?.value
            };

            if (isAdding) {
                console.log('Tạo hóa đơn mới:', invoiceData);
                alert('Đã tạo hóa đơn mới! (Xem console để biết chi tiết)');
                // Gửi dữ liệu này đến máy chủ để tạo hóa đơn mới
            } else {
                console.log('Cập nhật hóa đơn:', invoiceData);
                alert(`Đã cập nhật hóa đơn "${invoiceData.id}"! (Xem console để biết chi tiết)`);
                // Gửi dữ liệu này đến máy chủ để cập nhật
            }
            
            closeInvoiceModal();
        });
    }

    // Xử lý xác nhận hành động (ghi nhận thanh toán)
    if (confirmPaymentButton) {
        confirmPaymentButton.addEventListener('click', () => {
            if (currentInvoiceIdForAction && currentActionType === 'mark-paid') {
                console.log('Xác nhận ghi nhận thanh toán cho hóa đơn ID:', currentInvoiceIdForAction);
                alert(`Đã ghi nhận thanh toán cho hóa đơn ID: ${currentInvoiceIdForAction}! (Trong ứng dụng thực sẽ gửi yêu cầu đến server)`);
                // Thực hiện AJAX call để cập nhật trạng thái hóa đơn trên server
                // Sau khi thành công, có thể cần tải lại dữ liệu bảng hoặc cập nhật dòng tương ứng
            }
            closeConfirmPaymentModal(); // Đóng modal xác nhận sau khi xử lý
        });
    }
});