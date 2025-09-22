document.addEventListener('DOMContentLoaded', () => {
    const rentalModal = document.getElementById('rentalModal');
    const cancelRentalConfirmModal = document.getElementById('cancelRentalConfirmModal');
    const closeButton = rentalModal.querySelector('.close-button');
    const closeCancelRentalConfirmButton = document.getElementById('closeCancelRentalConfirm');
    const cancelModalButton = document.getElementById('cancelModalButton'); // Nút hủy trong modal chính
    const rentalForm = document.getElementById('rentalForm');
    const saveRentalButton = document.getElementById('saveRentalButton');
    const modalTitle = document.getElementById('modalTitle');

    const dataTable = document.querySelector('.data-table table tbody');

    const confirmCancelRentalButton = document.getElementById('confirmCancelRentalButton');
    const cancelConfirmButton = document.getElementById('cancelConfirmButton');
    const rentalIdToCancel = document.getElementById('rentalIdToCancel');
    const apartmentNameToCancel = document.getElementById('apartmentNameToCancel');

    let currentRentalIdToCancel = null;
    let isAdding = false; // true nếu đang thêm mới, false nếu đang sửa/xem

    const addRentalButton = document.querySelector('.add-rental-button');

    // Hàm để mở modal chi tiết hợp đồng thuê
    function openRentalModal() {
        if (rentalModal) {
            rentalModal.style.display = 'block';
        }
    }

    // Hàm để đóng modal chi tiết hợp đồng thuê
    function closeRentalModal() {
        if (rentalModal) {
            rentalModal.style.display = 'none';
            if (rentalForm) {
                rentalForm.reset(); // Đặt lại form về trạng thái ban đầu
            }
            // Đặt lại trạng thái mặc định của các trường sau khi đóng
            document.getElementById('modal-contract-id').readOnly = true; // Mã HĐ luôn readonly
            document.getElementById('modal-apartment-name').readOnly = false;
            document.getElementById('modal-tenant-name').readOnly = false;
            document.getElementById('modal-start-date').readOnly = false;
            document.getElementById('modal-end-date').readOnly = false;
            document.getElementById('modal-monthly-price').readOnly = false;
            document.getElementById('modal-rental-status').disabled = false;
            
            if (saveRentalButton) {
                saveRentalButton.style.display = 'inline-block'; // Mặc định hiển thị nút lưu khi mở, sẽ ẩn nếu là chế độ xem
            }
        }
    }

    // Hàm để mở modal xác nhận hủy hợp đồng
    function openCancelRentalConfirmModal(rentalId, apartmentName) {
        if (rentalIdToCancel) rentalIdToCancel.textContent = rentalId;
        if (apartmentNameToCancel) apartmentNameToCancel.textContent = apartmentName;
        currentRentalIdToCancel = rentalId; // Lưu ID vào biến toàn cục
        if (cancelRentalConfirmModal) {
            cancelRentalConfirmModal.style.display = 'block';
        }
    }

    // Hàm để đóng modal xác nhận hủy hợp đồng
    function closeCancelRentalConfirmModal() {
        if (cancelRentalConfirmModal) {
            cancelRentalConfirmModal.style.display = 'none';
        }
        currentRentalIdToCancel = null; // Xóa ID đã lưu
    }

    // --- Xử lý nút "Thêm hợp đồng thuê" ---
    if (addRentalButton) {
        addRentalButton.addEventListener('click', () => {
            isAdding = true;
            if (modalTitle) modalTitle.textContent = 'Thêm Hợp Đồng Thuê Mới';
            if (rentalForm) rentalForm.reset(); // Đảm bảo form trống

            // Thiết lập giá trị mặc định cho các trường khi thêm mới
            document.getElementById('modal-contract-id').value = 'Tự động tạo'; // Mã HĐ tự động tạo
            // Các trường khác để trống để người dùng nhập

            // Đặt các trường có thể chỉnh sửa
            document.getElementById('modal-contract-id').readOnly = true;
            document.getElementById('modal-apartment-name').readOnly = false;
            document.getElementById('modal-tenant-name').readOnly = false;
            document.getElementById('modal-start-date').readOnly = false;
            document.getElementById('modal-end-date').readOnly = false;
            document.getElementById('modal-monthly-price').readOnly = false;
            document.getElementById('modal-rental-status').disabled = false; // Có thể chọn trạng thái ban đầu

            if (saveRentalButton) saveRentalButton.style.display = 'inline-block'; // Hiện nút Lưu
            openRentalModal();
        });
    }

    // --- Trình nghe sự kiện cho các nút trong bảng (Sử dụng Event Delegation) ---
    if (dataTable) {
        dataTable.addEventListener('click', (event) => {
            const target = event.target;
            const row = target.closest('tr');
            if (!row) return;

            const cells = row.querySelectorAll('td');
            const contractId = cells[1].textContent; // Mã HĐ
            const apartmentName = cells[2].textContent;
            const tenantName = cells[3].textContent;
            const startDate = cells[4].textContent;
            const endDate = cells[5].textContent;
            const monthlyPrice = cells[6].textContent; // "8.000.000 VNĐ"
            const statusElement = cells[7].querySelector('.status');
            const statusText = statusElement ? statusElement.textContent.trim() : '';

            // Xử lý giá thuê để hiển thị đúng trong input number
            const priceValue = parseFloat(monthlyPrice.replace(/\./g, '').replace('VNĐ', '').trim());

            if (target.classList.contains('action-button')) {
                if (target.classList.contains('view')) {
                    isAdding = false;
                    if (modalTitle) modalTitle.textContent = 'Chi tiết hợp đồng thuê';
                    
                    document.getElementById('modal-contract-id').value = contractId;
                    document.getElementById('modal-apartment-name').value = apartmentName;
                    document.getElementById('modal-tenant-name').value = tenantName;
                    document.getElementById('modal-start-date').value = startDate;
                    document.getElementById('modal-end-date').value = endDate;
                    document.getElementById('modal-monthly-price').value = priceValue;

                    const modalStatusSelect = document.getElementById('modal-rental-status');
                    if (modalStatusSelect) {
                        for (let i = 0; i < modalStatusSelect.options.length; i++) {
                            if (modalStatusSelect.options[i].text === statusText) {
                                modalStatusSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }

                    // Đặt các trường chỉ đọc cho chế độ "Xem"
                    document.getElementById('modal-contract-id').readOnly = true;
                    document.getElementById('modal-apartment-name').readOnly = true;
                    document.getElementById('modal-tenant-name').readOnly = true;
                    document.getElementById('modal-start-date').readOnly = true;
                    document.getElementById('modal-end-date').readOnly = true;
                    document.getElementById('modal-monthly-price').readOnly = true;
                    document.getElementById('modal-rental-status').disabled = true;

                    if(saveRentalButton) saveRentalButton.style.display = 'none'; // Ẩn nút lưu khi chỉ xem

                    openRentalModal();
                } else if (target.classList.contains('edit')) {
                    isAdding = false;
                    if (modalTitle) modalTitle.textContent = 'Chỉnh sửa hợp đồng thuê';

                    document.getElementById('modal-contract-id').value = contractId;
                    document.getElementById('modal-apartment-name').value = apartmentName;
                    document.getElementById('modal-tenant-name').value = tenantName;
                    document.getElementById('modal-start-date').value = startDate;
                    document.getElementById('modal-end-date').value = endDate;
                    document.getElementById('modal-monthly-price').value = priceValue;

                    const modalStatusSelect = document.getElementById('modal-rental-status');
                    if (modalStatusSelect) {
                        for (let i = 0; i < modalStatusSelect.options.length; i++) {
                            if (modalStatusSelect.options[i].text === statusText) {
                                modalStatusSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }

                    // Cho phép chỉnh sửa các trường (Mã HĐ vẫn chỉ đọc)
                    document.getElementById('modal-contract-id').readOnly = true;
                    document.getElementById('modal-apartment-name').readOnly = false;
                    document.getElementById('modal-tenant-name').readOnly = false;
                    document.getElementById('modal-start-date').readOnly = false;
                    document.getElementById('modal-end-date').readOnly = false;
                    document.getElementById('modal-monthly-price').readOnly = false;
                    document.getElementById('modal-rental-status').disabled = false;

                    if(saveRentalButton) saveRentalButton.style.display = 'inline-block'; // Hiện nút Lưu
                    openRentalModal();
                } else if (target.classList.contains('cancel-rental')) {
                    openCancelRentalConfirmModal(contractId, apartmentName);
                }
            }
        });
    }

    // --- Xử lý đóng modal ---
    if (closeButton) closeButton.addEventListener('click', closeRentalModal);
    if (cancelModalButton) cancelModalButton.addEventListener('click', closeRentalModal);
    if (closeCancelRentalConfirmButton) closeCancelRentalConfirmButton.addEventListener('click', closeCancelRentalConfirmModal);
    if (cancelConfirmButton) cancelConfirmButton.addEventListener('click', closeCancelRentalConfirmModal);

    // Đóng modal nếu nhấp ra ngoài
    window.addEventListener('click', (event) => {
        if (rentalModal && event.target === rentalModal) {
            closeRentalModal();
        }
        if (cancelRentalConfirmModal && event.target === cancelRentalConfirmModal) {
            closeCancelRentalConfirmModal();
        }
    });

    // --- Xử lý gửi biểu mẫu trong rentalModal (Thêm mới HOẶC Cập nhật) ---
    if (rentalForm) {
        rentalForm.addEventListener('submit', (event) => {
            event.preventDefault();

            const rentalData = {
                contractId: document.getElementById('modal-contract-id')?.value,
                apartmentName: document.getElementById('modal-apartment-name')?.value,
                tenantName: document.getElementById('modal-tenant-name')?.value,
                startDate: document.getElementById('modal-start-date')?.value,
                endDate: document.getElementById('modal-end-date')?.value,
                monthlyPrice: document.getElementById('modal-monthly-price')?.value,
                status: document.getElementById('modal-rental-status')?.value
            };

            if (isAdding) {
                // Logic THÊM MỚI hợp đồng thuê
                console.log('Thêm hợp đồng thuê mới:', rentalData);
                alert('Đã thêm hợp đồng thuê mới! (Xem console để biết chi tiết)');
                // Trong ứng dụng thực, gửi dữ liệu này đến máy chủ để tạo hợp đồng mới
            } else {
                // Logic CẬP NHẬT hợp đồng thuê
                console.log('Cập nhật hợp đồng thuê:', rentalData);
                alert(`Đã cập nhật hợp đồng ${rentalData.contractId}! (Xem console để biết chi tiết)`);
                // Trong ứng dụng thực, gửi dữ liệu này đến máy chủ để cập nhật
            }
            
            closeRentalModal();
        });
    }

    // Xử lý xác nhận hủy hợp đồng thuê
    if (confirmCancelRentalButton) {
        confirmCancelRentalButton.addEventListener('click', () => {
            if (currentRentalIdToCancel) {
                console.log('Xác nhận hủy hợp đồng thuê:', currentRentalIdToCancel);
                alert(`Đã hủy hợp đồng ${currentRentalIdToCancel} (trong ứng dụng thực sẽ gửi yêu cầu đến server)`);
                // Trong một ứng dụng thực, bạn sẽ gửi yêu cầu AJAX (Fetch API) để thay đổi trạng thái hợp đồng này
                // Sau khi thành công, bạn sẽ cần cập nhật trạng thái trong bảng HTML
            }
            closeCancelRentalConfirmModal(); // Đóng modal xác nhận sau khi xử lý
        });
    }
});