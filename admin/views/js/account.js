document.addEventListener("DOMContentLoaded", () => {
    const userModal = document.getElementById("userModal");
    const closeButton = userModal.querySelector(".close-button");
    const deleteConfirmModal = document.getElementById("deleteConfirmModal");
    const closeDeleteConfirmButton = document.getElementById("closeDeleteConfirm");
    const cancelButton = document.getElementById("cancelButton");
    const userForm = document.getElementById("userForm");
    const modalTitle = document.getElementById("modalTitle");

    const dataTable = document.querySelector(".data-table table tbody");

    const confirmDeleteButton = document.getElementById("confirmDeleteButton");
    const cancelDeleteButton = document.getElementById("cancelDeleteButton");
    const userNameToDelete = document.getElementById("userNameToDelete");
    const userIdToDelete = document.getElementById("userIdToDelete");

    let currentUserIdToDelete = null;

    const addFormArea = document.getElementById("addFormArea");
    const addButton = document.querySelector(".add-user-button");
    const addAccountForm = document.getElementById("addAccountForm");
    const cancelAddButton = document.getElementById("cancelAddButton");

    function openUserModal() {
        userModal.style.display = "flex";
    }

    function closeUserModal() {
        userModal.style.display = "none";
        userForm.reset();
    }

    function openDeleteConfirmModal(userId, userStatus) {
      if(userStatus === "Hoạt động"){
         userNameToDelete.textContent = "khóa";
        confirmDeleteButton.textContent = "Khóa";
        confirmDeleteButton.style.backgroundColor = "#e74c3c";
      }else{
        userNameToDelete.textContent = "mở khóa";
        confirmDeleteButton.textContent = "Mở khóa";
        confirmDeleteButton.style.backgroundColor = "#2ecc71";
      }
       
        currentUserIdToDelete = userId;
        deleteConfirmModal.style.display = "flex";
    }

    function closeDeleteConfirmModal() {
        deleteConfirmModal.style.display = "none";
        currentUserIdToDelete = null;
    }

    addButton.addEventListener("click", () => {
        addFormArea.style.display = "flex";
        addAccountForm.reset();
    });

    cancelAddButton.addEventListener("click", () => {
        addFormArea.style.display = "none";
    });

    dataTable.addEventListener("click", (event) => {
        const target = event.target;
        const row = target.closest("tr");
        if (!row) return;
        const userId = row.getAttribute('data-user-id');
        const userName = row.getAttribute('data-user-name');
        const userEmail = row.getAttribute('data-user-email');
        const userPhone = row.getAttribute('data-user-phone');
        const userStatus = row.getAttribute('data-user-status');
        const dateCreated = row.getAttribute('data-user-created');
        if (target.classList.contains("action-button")) {
            if (target.classList.contains("view")) {
                modalTitle.textContent = "Chi Tiết Người Dùng";
                document.getElementById("modal-name").value = userName;
                document.getElementById("modal-phone").value = userPhone;
                document.getElementById("modal-email").value = userEmail;
                document.getElementById("modal-date").value = dateCreated;
                const modalStatusSelect = document.getElementById("modal-status");
                const statusValue = userStatus === 'Hoạt động' ? 'active' : 'pending';
                modalStatusSelect.value = statusValue;
                
                openUserModal();

            } else if (target.classList.contains("lock")) {
                openDeleteConfirmModal(userId, userStatus);
            }
        }
    });
    closeButton.addEventListener("click", closeUserModal); 
    cancelButton.addEventListener("click", closeUserModal);
    closeDeleteConfirmButton.addEventListener("click", closeDeleteConfirmModal);
    cancelDeleteButton.addEventListener("click", closeDeleteConfirmModal);

    window.addEventListener("click", (event) => {
        if (event.target === userModal) closeUserModal();
        if (event.target === deleteConfirmModal) closeDeleteConfirmModal();
        if (event.target === addFormArea) addFormArea.style.display = "none";
    });


    addAccountForm.addEventListener("submit", (event) => {
        event.preventDefault();
        var name = document.getElementById("add-name").value;
        var phone = document.getElementById("add-phone").value;
        var email = document.getElementById("add-email").value;
        var password = document.getElementById("add-password").value;
        if (
            name.trim() === "" ||
            phone.trim() === "" ||
            email.trim() === "" ||
            password.trim() === ""
        ) {
            Swal.fire({
                title: "Thông báo",
                text: "Vui lòng nhập các thông tin bắt buộc.",
                icon: "warning",
                showConfirmButton: true,
            });
            return;
        }
        const newUserData = {
            name,
            phone,
            email,
            password,
        };

        $.ajax({
            type: "POST",
            url: "./services/account/add.php",
            dataType: "json",
            data: newUserData,
            success: function (result) {
                Swal.fire({
                    title: "Thông báo",
                    text: result.message,
                    icon: result.status,
                    showConfirmButton: true,
                }).then(function () {
                    if (result.path) {
                        addAccountForm.reset();
                        addFormArea.style.display = "none";
                        window.location.assign(result.path);
                    }
                });
                return;
            },
            error: function (e) {
                Swal.fire({
                    title: "Thông báo",
                    text: "Lỗi",
                    icon: "error",
                    showConfirmButton: true,
                });
                return;
            },
        });
    });

    confirmDeleteButton.addEventListener("click", () => {
        if (currentUserIdToDelete) {
             $.ajax({
            type: "POST",
            url: "./services/account/lock.php",
            dataType: "json",
            data: { userId: currentUserIdToDelete },
            success: function (result) {
                Swal.fire({
                    title: "Thông báo",
                    text: result.message,
                    icon: result.status,
                    showConfirmButton: true,
                }).then(function () {
                    if (result.path) {
                        addAccountForm.reset();
                        addFormArea.style.display = "none";
                        window.location.assign(result.path);
                    }
                });
                return;
            },
            error: function (e) {
                Swal.fire({
                    title: "Thông báo",
                    text: "Lỗi",
                    icon: "error",
                    showConfirmButton: true,
                });
                return;
            },
        });
            
        }
        closeDeleteConfirmModal();
    });
});