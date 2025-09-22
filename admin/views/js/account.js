document.addEventListener("DOMContentLoaded", () => {
  const userModal = document.getElementById("userModal");
  const closeButton = userModal.querySelector(".close-button");
  const deleteConfirmModal = document.getElementById("deleteConfirmModal");
  const closeDeleteConfirmButton =
    document.getElementById("closeDeleteConfirm");
  const cancelButton = document.getElementById("cancelButton");
  const userForm = document.getElementById("userForm");
  const saveUserButton = document.getElementById("saveUserButton");
  const modalTitle = document.getElementById("modalTitle");

  const dataTable = document.querySelector(".data-table table tbody");

  const confirmDeleteButton = document.getElementById("confirmDeleteButton");
  const cancelDeleteButton = document.getElementById("cancelDeleteButton");
  const userNameToDelete = document.getElementById("userNameToDelete");
  const userIdToDelete = document.getElementById("userIdToDelete");

  let currentUserIdToDelete = null;
  let isEditing = false;

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
    document.getElementById("modal-name").readOnly = false;
    document.getElementById("modal-email").readOnly = false;
    document.getElementById("modal-status").disabled = false;
    document.getElementById("modal-date").readOnly = true;
    saveUserButton.style.display = "none";
  }

  function openDeleteConfirmModal(userId, userName) {
    userIdToDelete.textContent = userId;
    userNameToDelete.textContent = userName;
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

    const cells = row.querySelectorAll("td");
    const userId = cells[0].textContent;
    const userName = cells[1].textContent;
    const userEmail = cells[2].textContent;
    const statusElement = cells[3].querySelector(".status");
    const statusText = statusElement ? statusElement.textContent.trim() : "";
    const dateCreated = cells[4].textContent;

    if (target.classList.contains("action-button")) {
      if (target.classList.contains("view")) {
        isEditing = false;
        modalTitle.textContent = "Chi Tiết Người Dùng";
        document.getElementById("modal-name").value = userName;
        document.getElementById("modal-email").value = userEmail;
        const modalStatusSelect = document.getElementById("modal-status");
        for (let i = 0; i < modalStatusSelect.options.length; i++) {
          if (modalStatusSelect.options[i].text === statusText) {
            modalStatusSelect.selectedIndex = i;
            break;
          }
        }
        document.getElementById("modal-date").value = dateCreated;
        document.getElementById("modal-name").readOnly = true;
        document.getElementById("modal-email").readOnly = true;
        document.getElementById("modal-status").disabled = true;
        saveUserButton.style.display = "none";
        openUserModal();
      } else if (target.classList.contains("edit")) {
        isEditing = true;
        modalTitle.textContent = "Chỉnh Sửa Người Dùng";
        document.getElementById("modal-name").value = userName;
        document.getElementById("modal-email").value = userEmail;
        const modalStatusSelect = document.getElementById("modal-status");
        for (let i = 0; i < modalStatusSelect.options.length; i++) {
          if (modalStatusSelect.options[i].text === statusText) {
            modalStatusSelect.selectedIndex = i;
            break;
          }
        }
        document.getElementById("modal-date").value = dateCreated;
        document.getElementById("modal-name").readOnly = false;
        document.getElementById("modal-email").readOnly = false;
        document.getElementById("modal-status").disabled = false;
        saveUserButton.style.display = "inline-block";
        openUserModal();
      } else if (target.classList.contains("lock")) {
        openDeleteConfirmModal(userId, userName);
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

  userForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const userData = {
      id: document.getElementById("modal-id").value,
      name: document.getElementById("modal-name").value,
      email: document.getElementById("modal-email").value,
      status: document.getElementById("modal-status").value,
      dateCreated: document.getElementById("modal-date").value,
    };
    if (isEditing) {
      console.log("Cập nhật người dùng:", userData);
      alert(`Đã cập nhật người dùng với ID: ${userData.id}!`);
    }
    closeUserModal();
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
      console.log("Khóa người dùng với ID:", currentUserIdToDelete);
      alert(`Đã khóa người dùng với ID: ${currentUserIdToDelete}`);
    }
    closeDeleteConfirmModal();
  });
});
