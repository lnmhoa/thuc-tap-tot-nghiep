document.addEventListener("DOMContentLoaded", () => {
  const typeNewsModal = document.getElementById("typeNewsModal");
  const closeButton = typeNewsModal.querySelector(".close-button");
  const deleteConfirmModal = document.getElementById("deleteConfirmModal");
  const closeDeleteConfirmButton = document.getElementById("closeDeleteConfirm");
  const cancelButton = document.getElementById("cancelButton");
  const typeNewsForm = document.getElementById("typeNewsForm");
  const saveTypeNewsButton = document.getElementById("saveTypeNewsButton");
  const modalTitle = document.getElementById("modalTitle");

  const confirmDeleteButton = document.getElementById("confirmDeleteButton");
  const cancelDeleteButton = document.getElementById("cancelDeleteButton");
  const dataTable = document.querySelector(".data-table table tbody");
  let currentTypeNewsIdToDelete = null;

  const addFormArea = document.getElementById("addFormArea");
  const addButton = document.querySelector(".add-typeNews-button");
  const addTypeNewsForm = document.getElementById("addTypeNewsForm");
  const cancelAddButton = document.getElementById("cancelAddButton");

  function setTypeNewsModalFieldsReadOnly(readOnlyState) {
    document.getElementById("modal-name").readOnly = readOnlyState;
    document.getElementById("modal-description").readOnly = readOnlyState;
  }

  function openTypeNewsModal() {
    typeNewsModal.style.display = "flex";
  }

  function closeTypeNewsModal() {
    typeNewsModal.style.display = "none";
    typeNewsForm.reset();
    saveTypeNewsButton.style.display = "none";
    setTypeNewsModalFieldsReadOnly(true);
  }

  function closeDeleteConfirmModal() {
    deleteConfirmModal.style.display = "none";
    currentTypeNewsIdToDelete = null;
  }

  addButton.addEventListener("click", () => {
    addFormArea.style.display = "flex";
    addTypeNewsForm.reset();
  });

  cancelAddButton.addEventListener("click", () => {
    addFormArea.style.display = "none";
  });

  dataTable.addEventListener("click", (event) => {
    const target = event.target;
    const row = target.closest("tr");
    if (!row) return;
    const cells = row.querySelectorAll("td");
    const typeNewsId = cells[3] ? cells[3].textContent.trim() : '';
    const typeNewsName = cells[1] ? cells[1].textContent.trim() : '';
    const typeNewsDescription = cells[2] ? cells[2].textContent.trim() : '';

    if (target.classList.contains("action-button")) {
      if (target.classList.contains("view")) {
        modalTitle.textContent = "Chi Tiết Loại Tin Tức";
        document.getElementById("modal-name").value = typeNewsName;
        document.getElementById("modal-description").value = typeNewsDescription;
        document.getElementById("modal-typeId").value = typeNewsId;
        setTypeNewsModalFieldsReadOnly(true);
        saveTypeNewsButton.style.display = "none";
        openTypeNewsModal();
      } else if (target.classList.contains("edit")) {
        modalTitle.textContent = "Chỉnh Sửa Loại Tin Tức";
        document.getElementById("modal-name").value = typeNewsName;
        document.getElementById("modal-description").value = typeNewsDescription;
        document.getElementById("modal-typeId").value = typeNewsId;
        setTypeNewsModalFieldsReadOnly(false);
        saveTypeNewsButton.style.display = "inline-block";
        openTypeNewsModal();
      } else if (target.classList.contains("del")) {
        currentTypeNewsIdToDelete = typeNewsId;
        deleteConfirmModal.style.display = "flex";
      }
    }
  });

  closeButton.addEventListener("click", closeTypeNewsModal);
  cancelButton.addEventListener("click", closeTypeNewsModal);

  window.addEventListener("click", (event) => {
    if (event.target === typeNewsModal) closeTypeNewsModal();
    if (event.target === addFormArea) addFormArea.style.display = "none";
    if (event.target === deleteConfirmModal) closeDeleteConfirmModal();
  });

  typeNewsForm.addEventListener("submit", (event) => {
    event.preventDefault();

    const name = document.getElementById("modal-name").value;
    const description = document.getElementById("modal-description").value;
    const typeId = document.getElementById("modal-typeId").value;

    const formData = new FormData();
    formData.append("name", name);
    formData.append("description", description);
    formData.append("typeId", typeId);

    $.ajax({
      type: "POST",
      url: "./services/typeNews/edit.php",
      dataType: "json",
      data: formData,
      processData: false,
      contentType: false,
      success: function (result) {
        Swal.fire({
          title: "Thông báo",
          text: result.message,
          icon: result.status,
          showConfirmButton: true,
        }).then(function () {
          if (result.path) {
            window.location.assign(result.path);
          }
        });
      },
      error: function (e) {
        Swal.fire({
          title: "Thông báo",
          text: "Lỗi khi cập nhật loại tin tức.",
          icon: "error",
          showConfirmButton: true,
        });
      },
    });

    closeTypeNewsModal();
  });

  addTypeNewsForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const name = document.getElementById("add-name").value;
    const description = document.getElementById("add-description").value;

    if (name.trim() === "") {
      Swal.fire({
        title: "Thông báo",
        text: "Vui lòng nhập tên loại tin tức.",
        icon: "warning",
        showConfirmButton: true,
      });
      return;
    }

    const formData = new FormData();
    formData.append("name", name);
    formData.append("description", description);

    $.ajax({
      type: "POST",
      url: "./services/typeNews/add.php",
      dataType: "json",
      data: formData,
      processData: false,
      contentType: false,
      success: function (result) {
        Swal.fire({
          title: "Thông báo",
          text: result.message,
          icon: result.status,
          showConfirmButton: true,
        }).then(function () {
          if (result.path) {
            window.location.assign(result.path);
          }
        });
      },
      error: function (e) {
        Swal.fire({
          title: "Thông báo",
          text: "Lỗi khi thêm mới loại tin tức.",
          icon: "error",
          showConfirmButton: true,
        });
      },
    });
  });

  closeDeleteConfirmButton.addEventListener("click", closeDeleteConfirmModal);
  cancelDeleteButton.addEventListener("click", closeDeleteConfirmModal);

  confirmDeleteButton.addEventListener("click", () => {
    if (currentTypeNewsIdToDelete) {
      const formData = new FormData();
      formData.append("typeId", currentTypeNewsIdToDelete);

      $.ajax({
        type: "POST",
        url: "./services/typeNews/delete.php",
        dataType: "json",
        data: formData,
        processData: false,
        contentType: false,
        success: function (result) {
          Swal.fire({
            title: "Thông báo",
            text: result.message,
            icon: result.status,
            showConfirmButton: true,
          }).then(function () {
            if (result.path) {
              window.location.assign(result.path);
            }
          });
        },
        error: function (e) {
          Swal.fire({
            title: "Thông báo",
            text: "Lỗi khi xóa loại tin tức.",
            icon: "error",
            showConfirmButton: true,
          });
        },
      });
    }
    closeDeleteConfirmModal();
  });
});