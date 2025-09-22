document.addEventListener("DOMContentLoaded", () => {
  let addEditor;
  let editEditor;
  ClassicEditor.create(document.querySelector("#add-content"))
    .then((editor) => {
      addEditor = editor;
    })
    .catch((error) => {
      console.error(error);
    });

  ClassicEditor.create(document.querySelector("#modal-content"))
    .then((editor) => {
      editEditor = editor;
    })
    .catch((error) => {
      console.error(error);
    });
  const newsModal = document.getElementById("newsModal");
  const closeButton = newsModal.querySelector(".close-button");
  const deleteConfirmModal = document.getElementById("deleteConfirmModal");
  const closeDeleteConfirmButton =
    document.getElementById("closeDeleteConfirm");
  const cancelButton = document.getElementById("cancelButton");
  const newsForm = document.getElementById("newsForm");
  const saveNewsButton = document.getElementById("saveNewsButton");
  const modalTitle = document.getElementById("modalTitle");
  const confirmDeleteButton = document.getElementById("confirmDeleteButton");
  const cancelDeleteButton = document.getElementById("cancelDeleteButton");
  const dataTable = document.querySelector(".data-table table tbody");
  let currentNewsIdToDelete = null;
  const addFormArea = document.getElementById("addFormArea");
  const addButton = document.querySelector(".add-news-button");
  const addNewsForm = document.getElementById("addNewsForm");
  const cancelAddButton = document.getElementById("cancelAddButton");
  function setNewsModalFieldsReadOnly(readOnlyState) {
    document.getElementById("modal-views").readOnly = true;
    document.getElementById("modal-createdAt").readOnly = true;
  }
  function openNewsModal() {
    newsModal.style.display = "flex";
  }
  function closeNewsModal() {
    newsModal.style.display = "none";
    newsForm.reset();
    saveNewsButton.style.display = "none";
    setNewsModalFieldsReadOnly(true);
    if (editEditor) {
      editEditor.setData("");
    }
  }
  function closeDeleteConfirmModal() {
    deleteConfirmModal.style.display = "none";
    currentNewsIdToDelete = null;
  }
  addButton.addEventListener("click", () => {
    addFormArea.style.display = "flex";
    addNewsForm.reset();
    if (addEditor) {
      addEditor.setData("");
    }
  });
  cancelAddButton.addEventListener("click", () => {
    addFormArea.style.display = "none";
  });
  dataTable.addEventListener("click", (event) => {
    const target = event.target;
    const row = target.closest("tr");
    if (!row) return;
    const cells = row.querySelectorAll("td");
    const newsId = cells[7] ? cells[7].textContent.trim() : "";
    const title = cells[1] ? cells[1].textContent.trim() : "";
    const content = cells[3] ? cells[3].innerHTML.trim() : "";
    const createdAt = cells[5] ? cells[5].textContent.trim() : "";
           console.log("Type Text 11:", cells[4].textContent.trim());
    const views = cells[6] ? cells[6].textContent.trim() : "";
     const typeElement = cells[4] ? cells[4].textContent.trim() : null;
   const typeText = typeElement ? typeElement : "";
    if (target.classList.contains("action-button")) {
      if (target.classList.contains("edit")) {
        modalTitle.textContent = "Chỉnh Sửa Tin Tức";
        document.getElementById("modal-title").value = title;
        if (editEditor) {
          editEditor.setData(content);
        }
        document.getElementById("modal-createdAt").value = createdAt;
        document.getElementById("modal-views").value = views;
        document.getElementById("modal-newsId").value = newsId;
 
        
        const modalTypeSelect = document.getElementById("modal-type");
        for (let i = 0; i < modalTypeSelect.options.length; i++) {
          if (modalTypeSelect.options[i].text === typeText) {
            modalTypeSelect.selectedIndex = i;
            break;
          }
        }
        setNewsModalFieldsReadOnly(true);
        saveNewsButton.style.display = "inline-block";
        openNewsModal();
      } else if (target.classList.contains("del")) {
        currentNewsIdToDelete = newsId;
        deleteConfirmModal.style.display = "flex";
      }
    }
  });
  closeButton.addEventListener("click", closeNewsModal);
  cancelButton.addEventListener("click", closeNewsModal);
  window.addEventListener("click", (event) => {
    if (event.target === newsModal) closeNewsModal();
    if (event.target === addFormArea) addFormArea.style.display = "none";
    if (event.target === deleteConfirmModal) closeDeleteConfirmModal();
  });
  newsForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const title = document.getElementById("modal-title").value;
    const content = editEditor
      ? editEditor.getData()
      : document.getElementById("modal-content").value;
    const newsId = document.getElementById("modal-newsId").value;
    const image = document.getElementById("modal-image").files[0];
       const typeId = document.getElementById("modal-type").value;
    const formData = new FormData();
    formData.append("title", title);
    formData.append("content", content);
    formData.append("newsId", newsId);
    formData.append("typeId", typeId);
    if (image) {
      formData.append("image", image);
    }
    $.ajax({
      type: "POST",
      url: "./services/news/edit.php",
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
          text: "Lỗi khi cập nhật tin tức.",
          icon: "error",
          showConfirmButton: true,
        });
        console.error("Error updating news:", e);
      },
    });
    closeNewsModal();
  });
  addNewsForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const title = document.getElementById("add-title").value;
    const image = document.getElementById("add-image").files[0];
    const typeId = document.getElementById("add-type").value;
    const content = addEditor
      ? addEditor.getData()
      : document.getElementById("add-content").value;
    if (title.trim() === "") {
      Swal.fire({
        title: "Thông báo",
        text: "Vui lòng nhập tiêu đề tin tức.",
        icon: "warning",
        showConfirmButton: true,
      });
      return;
    }
    const formData = new FormData();
    formData.append("title", title);
    formData.append("content", content);
    formData.append("typeId", typeId);
    if (image) {
      formData.append("image", image);
    }
    $.ajax({
      type: "POST",
      url: "./services/news/add.php",
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
          text: "Lỗi khi thêm mới tin tức.",
          icon: "error",
          showConfirmButton: true,
        });
      },
    });
  });
  closeDeleteConfirmButton.addEventListener("click", closeDeleteConfirmModal);
  cancelDeleteButton.addEventListener("click", closeDeleteConfirmModal);
  confirmDeleteButton.addEventListener("click", () => {
    if (currentNewsIdToDelete) {
      const formData = new FormData();
      formData.append("newsId", currentNewsIdToDelete);
      $.ajax({
        type: "POST",
        url: "./services/news/delete.php",
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
            text: "Lỗi khi xóa tin tức.",
            icon: "error",
            showConfirmButton: true,
          });
        },
      });
    }
    closeDeleteConfirmModal();
  });
});
