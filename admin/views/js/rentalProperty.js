document.addEventListener('DOMContentLoaded', () => {
    const apartmentModal = document.getElementById('apartmentModal');
    const deactivateConfirmModal = document.getElementById('deactivateConfirmModal');
    const closeButton = apartmentModal.querySelector('.close-button');
    const closeDeactivateConfirmButton = document.getElementById('closeDeactivateConfirm');
    const cancelButton = document.getElementById('cancelButton');
    const apartmentForm = document.getElementById('apartmentForm');
    const saveApartmentButton = document.getElementById('saveApartmentButton');
    const modalTitle = document.getElementById('modalTitle');

    const dataTable = document.querySelector('.data-table table tbody');

    const confirmDeactivateButton = document.getElementById('confirmDeactivateButton');
    const cancelDeactivateButton = document.getElementById('cancelDeactivateButton');
    const apartmentNameToDeactivate = document.getElementById('apartmentNameToDeactivate');
    const apartmentIdToDeactivate = document.getElementById('apartmentIdToDeactivate');

    let currentApartmentIdToDeactivate = null;
    let isAdding = false; // true nếu đang thêm mới, false nếu đang sửa/xem

    const addApartmentButton = document.querySelector('.add-apartment-button');

    // Hàm để mở modal chi tiết căn hộ
    function openApartmentModal() {
        if (apartmentModal) {
            apartmentModal.style.display = 'block';
        }
    }

    // Hàm để đóng modal chi tiết căn hộ
    function closeApartmentModal() {
        if (apartmentModal) {
            apartmentModal.style.display = 'none';
            if (apartmentForm) {
                apartmentForm.reset(); // Đặt lại form về trạng thái ban đầu
            }
            // Đặt lại trạng thái mặc định của các trường sau khi đóng
            document.getElementById('modal-id').readOnly = true;
            document.getElementById('modal-name').readOnly = false;
            document.getElementById('modal-address').readOnly = false;
            document.getElementById('modal-area').readOnly = false;
            document.getElementById('modal-price').readOnly = false;
            document.getElementById('modal-status').disabled = false;
            document.getElementById('modal-date').readOnly = true;
            
            if (saveApartmentButton) {
                saveApartmentButton.style.display = 'inline-block'; // Mặc định hiển thị nút lưu khi mở, sẽ ẩn nếu là chế độ xem
            }
        }
    }

    // Hàm để mở modal xác nhận ngừng hoạt động
    function openDeactivateConfirmModal(apartmentId, apartmentName) {
        if (apartmentIdToDeactivate) apartmentIdToDeactivate.textContent = apartmentId;
        if (apartmentNameToDeactivate) apartmentNameToDeactivate.textContent = apartmentName;
        currentApartmentIdToDeactivate = apartmentId; // Lưu ID vào biến toàn cục
        if (deactivateConfirmModal) {
            deactivateConfirmModal.style.display = 'block';
        }
    }

    // Hàm để đóng modal xác nhận ngừng hoạt động
    function closeDeactivateConfirmModal() {
        if (deactivateConfirmModal) {
            deactivateConfirmModal.style.display = 'none';
        }
        currentApartmentIdToDeactivate = null; // Xóa ID đã lưu
    }

    // --- Xử lý nút "Thêm căn hộ" (mở apartmentModal ở chế độ thêm) ---
    if (addApartmentButton) {
        addApartmentButton.addEventListener('click', () => {
            isAdding = true;
            if (modalTitle) modalTitle.textContent = 'Thêm Căn Hộ Mới';
            if (apartmentForm) apartmentForm.reset(); // Đảm bảo form trống

            // Thiết lập giá trị mặc định cho các trường khi thêm mới
            document.getElementById('modal-id').value = 'Tự động tạo'; // ID tự động tạo
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            document.getElementById('modal-date').value = `${year}-${month}-${day}`; // Ngày tạo là ngày hiện tại

            // Đặt các trường có thể chỉnh sửa
            document.getElementById('modal-id').readOnly = true; // ID luôn readonly
            document.getElementById('modal-name').readOnly = false;
            document.getElementById('modal-address').readOnly = false;
            document.getElementById('modal-area').readOnly = false;
            document.getElementById('modal-price').readOnly = false;
            document.getElementById('modal-status').disabled = false;
            document.getElementById('modal-date').readOnly = true; // Ngày tạo luôn readonly

            if (saveApartmentButton) saveApartmentButton.style.display = 'inline-block'; // Hiện nút Lưu
            openApartmentModal();
        });
    }

    // --- Trình nghe sự kiện cho các nút trong bảng (Sử dụng Event Delegation) ---
    if (dataTable) {
        dataTable.addEventListener('click', (event) => {
            const target = event.target;
            const row = target.closest('tr');
            if (!row) return;

            const cells = row.querySelectorAll('td');
            const apartmentId = cells[0].textContent; // STT
            const apartmentName = cells[1].textContent;
            const apartmentAddress = cells[2].textContent;
            const apartmentArea = cells[3].textContent; // Lấy giá trị chuỗi "75"
            const apartmentPrice = cells[4].textContent; // Lấy giá trị chuỗi "8.000.000 VNĐ"
            const statusElement = cells[5].querySelector('.status');
            const statusText = statusElement ? statusElement.textContent.trim() : '';
            const dateCreated = cells[6].textContent;

            // Xử lý giá trị diện tích và giá thuê để hiển thị đúng trong input number
            const areaValue = parseFloat(apartmentArea.replace('m²', '').trim());
            const priceValue = parseFloat(apartmentPrice.replace(/\./g, '').replace('VNĐ', '').trim());

            if (target.classList.contains('action-button')) {
                if (target.classList.contains('view')) {
                    isAdding = false; // Không phải chế độ thêm
                    if (modalTitle) modalTitle.textContent = 'Chi tiết căn hộ';
                    
                    document.getElementById('modal-id').value = apartmentId;
                    document.getElementById('modal-name').value = apartmentName;
                    document.getElementById('modal-address').value = apartmentAddress;
                    document.getElementById('modal-area').value = areaValue;
                    document.getElementById('modal-price').value = priceValue;

                    const modalStatusSelect = document.getElementById('modal-status');
                    if (modalStatusSelect) {
                        // Tìm và chọn option dựa trên text hoặc value (ở đây dùng text để match với "Còn trống", "Đã thuê"...)
                        for (let i = 0; i < modalStatusSelect.options.length; i++) {
                            if (modalStatusSelect.options[i].text === statusText) {
                                modalStatusSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }
                    document.getElementById('modal-date').value = dateCreated;

                    // Đặt các trường chỉ đọc cho chế độ "Xem"
                    document.getElementById('modal-id').readOnly = true;
                    document.getElementById('modal-name').readOnly = true;
                    document.getElementById('modal-address').readOnly = true;
                    document.getElementById('modal-area').readOnly = true;
                    document.getElementById('modal-price').readOnly = true;
                    document.getElementById('modal-status').disabled = true;
                    document.getElementById('modal-date').readOnly = true;

                    if(saveApartmentButton) saveApartmentButton.style.display = 'none'; // Ẩn nút lưu khi chỉ xem

                    openApartmentModal();
                } else if (target.classList.contains('edit')) {
                    isAdding = false; // Không phải chế độ thêm
                    if (modalTitle) modalTitle.textContent = 'Chỉnh sửa căn hộ';

                    document.getElementById('modal-id').value = apartmentId;
                    document.getElementById('modal-name').value = apartmentName;
                    document.getElementById('modal-address').value = apartmentAddress;
                    document.getElementById('modal-area').value = areaValue;
                    document.getElementById('modal-price').value = priceValue;

                    const modalStatusSelect = document.getElementById('modal-status');
                    if (modalStatusSelect) {
                        for (let i = 0; i < modalStatusSelect.options.length; i++) {
                            if (modalStatusSelect.options[i].text === statusText) {
                                modalStatusSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }
                    document.getElementById('modal-date').value = dateCreated;

                    // Cho phép chỉnh sửa các trường (ID và Ngày tạo vẫn chỉ đọc)
                    document.getElementById('modal-id').readOnly = true;
                    document.getElementById('modal-name').readOnly = false;
                    document.getElementById('modal-address').readOnly = false;
                    document.getElementById('modal-area').readOnly = false;
                    document.getElementById('modal-price').readOnly = false;
                    document.getElementById('modal-status').disabled = false;
                    document.getElementById('modal-date').readOnly = true;

                    if(saveApartmentButton) saveApartmentButton.style.display = 'inline-block'; // Hiện nút Lưu
                    openApartmentModal();
                } else if (target.classList.contains('deactive')) {
                    openDeactivateConfirmModal(apartmentId, apartmentName);
                }
            }
        });
    }

    // --- Xử lý đóng modal ---
    if (closeButton) closeButton.addEventListener('click', closeApartmentModal);
    if (cancelButton) cancelButton.addEventListener('click', closeApartmentModal);
    if (closeDeactivateConfirmButton) closeDeactivateConfirmButton.addEventListener('click', closeDeactivateConfirmModal);
    if (cancelDeactivateButton) cancelDeactivateButton.addEventListener('click', closeDeactivateConfirmModal);

    // Đóng modal nếu nhấp ra ngoài
    window.addEventListener('click', (event) => {
        if (apartmentModal && event.target === apartmentModal) {
            closeApartmentModal();
        }
        if (deactivateConfirmModal && event.target === deactivateConfirmModal) {
            closeDeactivateConfirmModal();
        }
    });

    // --- Xử lý gửi biểu mẫu trong apartmentModal (Thêm mới HOẶC Cập nhật) ---
    if (apartmentForm) {
        apartmentForm.addEventListener('submit', (event) => {
            event.preventDefault();

            const apartmentData = {
                id: document.getElementById('modal-id')?.value,
                name: document.getElementById('modal-name')?.value,
                address: document.getElementById('modal-address')?.value,
                area: document.getElementById('modal-area')?.value,
                price: document.getElementById('modal-price')?.value,
                status: document.getElementById('modal-status')?.value,
                dateCreated: document.getElementById('modal-date')?.value
            };

            if (isAdding) {
                // Logic THÊM MỚI căn hộ
                console.log('Thêm căn hộ mới:', apartmentData);
                alert('Đã thêm căn hộ mới! (Xem console để biết chi tiết)');
                // Trong ứng dụng thực, gửi dữ liệu này đến máy chủ để tạo căn hộ mới
            } else {
                // Logic CẬP NHẬT căn hộ
                console.log('Cập nhật căn hộ:', apartmentData);
                alert(`Đã cập nhật căn hộ STT: ${apartmentData.id}! (Xem console để biết chi tiết)`);
                // Trong ứng dụng thực, gửi dữ liệu này đến máy chủ để cập nhật
            }
            
            closeApartmentModal();
        });
    }

    // Xử lý xác nhận ngừng hoạt động căn hộ
    if (confirmDeactivateButton) {
        confirmDeactivateButton.addEventListener('click', () => {
            if (currentApartmentIdToDeactivate) {
                console.log('Xác nhận ngừng hoạt động căn hộ STT:', currentApartmentIdToDeactivate);
                alert(`Đã ngừng hoạt động căn hộ STT: ${currentApartmentIdToDeactivate} (trong ứng dụng thực sẽ gửi yêu cầu đến server)`);
                // Trong một ứng dụng thực, bạn sẽ gửi yêu cầu AJAX (Fetch API) để thay đổi trạng thái căn hộ này
                // Sau khi thành công, bạn sẽ cần cập nhật trạng thái trong bảng HTML
            }
            closeDeactivateConfirmModal(); // Đóng modal xác nhận sau khi xử lý
        });
    }
});