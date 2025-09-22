document.addEventListener("DOMContentLoaded", () => {
  const typeRentalPropertyModal = document.getElementById("typeRentalPropertyModal");
  const closeButton = typeRentalPropertyModal.querySelector(".close-button");
  const deleteConfirmModal = document.getElementById("deleteConfirmModal");
  const closeDeleteConfirmButton = document.getElementById("closeDeleteConfirm");
  const cancelButton = document.getElementById("cancelButton");
  const typeRentalPropertyForm = document.getElementById("typeRentalPropertyForm");
  const saveTypeRentalPropertyButton = document.getElementById("saveTypeRentalPropertyButton");
  const modalTitle = document.getElementById("modalTitle");

  const confirmDeleteButton = document.getElementById("confirmDeleteButton");
  const cancelDeleteButton = document.getElementById("cancelDeleteButton");
  const dataTable = document.querySelector(".data-table table tbody");
  let currentTypeRentalPropertyIdToDelete = null;

  const addFormArea = document.getElementById("addFormArea");
  const addButton = document.querySelector(".add-typeRentalProperty-button");
  const addTypeRentalPropertyForm = document.getElementById("addTypeRentalPropertyForm");
  const cancelAddButton = document.getElementById("cancelAddButton");

  function setTypeRentalPropertyModalFieldsReadOnly(readOnlyState) {
    document.getElementById("modal-name").readOnly = readOnlyState;
    document.getElementById("modal-description").readOnly = readOnlyState;
  }

  function openTypeRentalPropertyModal() {
    typeRentalPropertyModal.style.display = "flex";
  }

  function closeTypeRentalPropertyModal() {
    typeRentalPropertyModal.style.display = "none";
    typeRentalPropertyForm.reset();
    saveTypeRentalPropertyButton.style.display = "none";
    setTypeRentalPropertyModalFieldsReadOnly(true);
  }

  function closeDeleteConfirmModal() {
    deleteConfirmModal.style.display = "none";
    currentTypeRentalPropertyIdToDelete = null;
  }

  addButton.addEventListener("click", () => {
    addFormArea.style.display = "flex";
    addTypeRentalPropertyForm.reset();
  });

  cancelAddButton.addEventListener("click", () => {
    addFormArea.style.display = "none";
  });

  dataTable.addEventListener("click", (event) => {
    const target = event.target;
    const row = target.closest("tr");
    if (!row) return;
    const cells = row.querySelectorAll("td");
    const typeRentalPropertyId = cells[3] ? cells[3].textContent.trim() : '';
    const typeRentalPropertyName = cells[1] ? cells[1].textContent.trim() : '';
    const typeRentalPropertyDescription = cells[2] ? cells[2].textContent.trim() : '';

    if (target.classList.contains("action-button")) {
      if (target.classList.contains("view")) {
        modalTitle.textContent = "CHI TIẾT LOẠI BẤT ĐỘNG SẢN";
        document.getElementById("modal-name").value = typeRentalPropertyName;
        document.getElementById("modal-description").value = typeRentalPropertyDescription;
        document.getElementById("modal-typeId").value = typeRentalPropertyId;
        setTypeRentalPropertyModalFieldsReadOnly(true);
        saveTypeRentalPropertyButton.style.display = "none";
        openTypeRentalPropertyModal();
      } else if (target.classList.contains("edit")) {
        modalTitle.textContent = "CHỈNH SỬA LOẠI BẤT ĐỘNG SẢN";
        document.getElementById("modal-name").value = typeRentalPropertyName;
        document.getElementById("modal-description").value = typeRentalPropertyDescription;
        document.getElementById("modal-typeId").value = typeRentalPropertyId;
        setTypeRentalPropertyModalFieldsReadOnly(false);
        saveTypeRentalPropertyButton.style.display = "inline-block";
        openTypeRentalPropertyModal();
      } else if (target.classList.contains("del")) {
        currentTypeRentalPropertyIdToDelete = typeRentalPropertyId;
        deleteConfirmModal.style.display = "flex";
      }
    }
  });

  closeButton.addEventListener("click", closeTypeRentalPropertyModal);
  cancelButton.addEventListener("click", closeTypeRentalPropertyModal);

  window.addEventListener("click", (event) => {
    if (event.target === typeRentalPropertyModal) closeTypeRentalPropertyModal();
    if (event.target === addFormArea) addFormArea.style.display = "none";
    if (event.target === deleteConfirmModal) closeDeleteConfirmModal();
  });

  typeRentalPropertyForm.addEventListener("submit", (event) => {
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
      url: "./services/typeRentalProperty/edit.php",
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
          text: "Lỗi khi cập nhật loại bất động sản.",
          icon: "error",
          showConfirmButton: true,
        });
      },
    });

    closeTypeRentalPropertyModal();
  });

  addTypeRentalPropertyForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const name = document.getElementById("add-name").value;
    const description = document.getElementById("add-description").value;

    if (name.trim() === "") {
      Swal.fire({
        title: "Thông báo",
        text: "Vui lòng nhập tên loại bất động sản.",
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
      url: "./services/typeRentalProperty/add.php",
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
          text: "Lỗi khi thêm mới loại bất động sản.",
          icon: "error",
          showConfirmButton: true,
        });
      },
    });
  });

  closeDeleteConfirmButton.addEventListener("click", closeDeleteConfirmModal);
  cancelDeleteButton.addEventListener("click", closeDeleteConfirmModal);

  confirmDeleteButton.addEventListener("click", () => {
    if (currentTypeRentalPropertyIdToDelete) {
      const formData = new FormData();
      formData.append("typeId", currentTypeRentalPropertyIdToDelete);

      $.ajax({
        type: "POST",
        url: "./services/typeRentalProperty/delete.php",
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
            text: "Lỗi khi xóa loại bất động sản.",
            icon: "error",
            showConfirmButton: true,
          });
        },
      });
    }
    closeDeleteConfirmModal();
  });
});