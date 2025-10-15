document.addEventListener("DOMContentLoaded", () => {
    const brokerModal = document.getElementById("brokerModal");
    const closeButton = brokerModal.querySelector(".close-button");
    const cancelButton = document.getElementById("cancelButton");
    const brokerForm = document.getElementById("brokerForm");
    const saveBrokerButton = document.getElementById("saveBrokerButton");
    const modalTitle = document.getElementById("modalTitle");
    const avatarInput = document.getElementById("modal-avatar");
    const passwordInput = document.getElementById("modal-password");
    const passwordLabel = document.querySelector('label[for="modal-password"]');

    const dataTable = document.querySelector(".data-table table tbody");

    const addFormArea = document.getElementById("addFormArea");
    const addButton = document.querySelector(".add-broker-button");
    const addBrokerForm = document.getElementById("addBrokerForm");
    const cancelAddButton = document.getElementById("cancelAddButton");

    function setBrokerModalFieldsReadOnly(readOnlyState) {
        document.getElementById("modal-name").readOnly = readOnlyState;
        document.getElementById("modal-email").readOnly = readOnlyState;
        document.getElementById("modal-phone").readOnly = readOnlyState;
        document.getElementById("modal-intro").readOnly = readOnlyState;
        document.getElementById("modal-location").disabled = readOnlyState;
        document.getElementById("modal-hour").readOnly = readOnlyState;
        document.getElementById("modal-language").disabled = readOnlyState;
        document.getElementById("modal-expertise").disabled = readOnlyState;
        document.getElementById("modal-status").disabled = readOnlyState;
        avatarInput.style.display = readOnlyState ? 'none' : 'block';
    }

    function setAvatarDisplay(isReadOnly, avatarSrc) {
        const modalAvatarImg = document.getElementById("modal-avatar-img");
        if (isReadOnly) {
            modalAvatarImg.src = `../uploads/user/${avatarSrc}`;
            modalAvatarImg.style.display = 'block';
            avatarInput.style.display = 'none';
        } else {
            modalAvatarImg.style.display = 'none';
            avatarInput.style.display = 'block';
        }
    }

    function openBrokerModal() {
        brokerModal.style.display = "flex";
    }

    function closeBrokerModal() {
        brokerModal.style.display = "none";
        brokerForm.reset();
        saveBrokerButton.style.display = "none";
        setBrokerModalFieldsReadOnly(true);
    }

    addButton.addEventListener("click", () => {
        addFormArea.style.display = "flex";
        addBrokerForm.reset();
    });

    cancelAddButton.addEventListener("click", () => {
        addFormArea.style.display = "none";
    });

    dataTable.addEventListener("click", (event) => {
        const target = event.target;
        const row = target.closest("tr");
        if (!row) return;

        const cells = row.querySelectorAll("td");
        const brokerId = cells[12] ? cells[12].textContent.trim() : '';
        const accountId = cells[13] ? cells[13].textContent.trim() : '';
        const brokerName = cells[1] ? cells[1].textContent.trim() : '';
        const brokerAvatar = cells[2] ? cells[2].querySelector('img').getAttribute('src').split('/').pop() : '';
        const brokerPhone = cells[3] ? cells[3].textContent.trim() : '';
        const brokerEmail = cells[4] ? cells[4].textContent.trim() : '';
        const brokerIntro = cells[5] ? cells[5].textContent.trim() : '';
        const brokerLocation = cells[7] ? cells[7].textContent.trim() : '';
        const brokerHour = cells[8] ? cells[8].textContent.trim() : '';
        const brokerLanguage = cells[9] ? cells[9].textContent.trim() : '';
        const brokerExpertise = cells[10] ? cells[10].textContent.trim() : '';
        const brokerCreated = cells[11] ? cells[11].textContent.trim() : '';
        const statusElement = cells[6] ? cells[6].querySelector(".status") : null;
        const statusText = statusElement ? statusElement.textContent.trim() : "";

        const modalLanguageSelect = document.getElementById("modal-language");
        const modalExpertiseSelect = document.getElementById("modal-expertise");

        function updateSelectOptions(selectElement, selectedValues) {
            const valuesArray = selectedValues.split(',').map(item => item.trim());
            for (const option of selectElement.options) {
                option.selected = valuesArray.includes(option.value);
            }
        }

        if (target.classList.contains("action-button")) {
            if (target.classList.contains("view")) {
                isEditing = false;
                modalTitle.textContent = "CHI TIẾT NGƯỜI DÙNG";
                document.getElementById("modal-name").value = brokerName;
                document.getElementById("modal-email").value = brokerEmail;
                document.getElementById("modal-phone").value = brokerPhone;
                document.getElementById("modal-intro").value = brokerIntro;
                document.getElementById("modal-location").value = brokerLocation;
                document.getElementById("modal-hour").value = brokerHour;
                document.getElementById("modal-created").value = brokerCreated;

                updateSelectOptions(modalLanguageSelect, brokerLanguage);
                updateSelectOptions(modalExpertiseSelect, brokerExpertise);

                const modalStatusSelect = document.getElementById("modal-status");
                for (let i = 0; i < modalStatusSelect.options.length; i++) {
                    if (modalStatusSelect.options[i].text === statusText) {
                        modalStatusSelect.selectedIndex = i;
                        break;
                    }
                }

                setBrokerModalFieldsReadOnly(true);
                setAvatarDisplay(true, brokerAvatar);
                document.getElementById("modal-created").disabled = true;
                
                passwordInput.style.display = "none";
                if(passwordLabel) passwordLabel.style.display = "none";

                saveBrokerButton.style.display = "none";
                openBrokerModal();

            } else if (target.classList.contains("edit")) {
                isEditing = true;
                modalTitle.textContent = "CHỈNH SỬA NGƯỜI DÙNG";

                document.getElementById("modal-name").value = brokerName;
                document.getElementById("modal-email").value = brokerEmail;
                document.getElementById("modal-phone").value = brokerPhone;
                document.getElementById("modal-intro").value = brokerIntro;
                document.getElementById("modal-location").value = brokerLocation;
                document.getElementById("modal-hour").value = brokerHour;
                document.getElementById("modal-created").value = brokerCreated;
                document.getElementById("modal-brokerId").value = brokerId;
                document.getElementById("modal-accountId").value = accountId;

                updateSelectOptions(modalLanguageSelect, brokerLanguage);
                updateSelectOptions(modalExpertiseSelect, brokerExpertise);

                const modalStatusSelect = document.getElementById("modal-status");
                for (let i = 0; i < modalStatusSelect.options.length; i++) {
                    if (modalStatusSelect.options[i].text === statusText) {
                        modalStatusSelect.selectedIndex = i;
                        break;
                    }
                }

                setBrokerModalFieldsReadOnly(false);
                setAvatarDisplay(false, brokerAvatar);
                document.getElementById("modal-created").disabled = true;
                document.getElementById("modal-status").disabled = false;
            
                passwordInput.style.display = "block";
                if(passwordLabel) passwordLabel.style.display = "block";

                saveBrokerButton.style.display = "inline-block";
                openBrokerModal();
            }
        }
    });

    closeButton.addEventListener("click", closeBrokerModal);
    cancelButton.addEventListener("click", closeBrokerModal);

    window.addEventListener("click", (event) => {
        if (event.target === brokerModal) closeBrokerModal();
        if (event.target === addFormArea) addFormArea.style.display = "none";
    });

    brokerForm.addEventListener("submit", (event) => {
        event.preventDefault();

        if (!isEditing) {
            Swal.fire({
                title: "Thông báo",
                text: "Đã có lỗi xảy ra vui lòng thử lại sau.",
                icon: "error",
                showConfirmButton: true,
            });
            return;
        }

        const modalLanguageSelect = document.getElementById("modal-language");
        const modalExpertiseSelect = document.getElementById("modal-expertise");

        var name = document.getElementById("modal-name").value;
        var phone = document.getElementById("modal-phone").value;
        var email = document.getElementById("modal-email").value;
        var password = document.getElementById("modal-password").value;
        var intro = document.getElementById("modal-intro").value;
        var location = document.getElementById("modal-location").value;
        var hour = document.getElementById("modal-hour").value;
        var language = Array.from(modalLanguageSelect.options).filter(option => option.selected).map(option => option.value).join(", ");
        var expertise = Array.from(modalExpertiseSelect.options).filter(option => option.selected).map(option => option.value).join(", ");
        var brokerId = document.getElementById("modal-brokerId").value;
        var accountId = document.getElementById("modal-accountId").value;
        var status = document.getElementById("modal-status").value;

        const avatarInput = document.getElementById("modal-avatar");
        let avatarFile = null;

        if (avatarInput && avatarInput.files && avatarInput.files.length > 0) {
            avatarFile = avatarInput.files[0];
        }

        const formData = new FormData();
        formData.append("name", name);
        formData.append("phone", phone);
        formData.append("email", email);
        formData.append("password", password);
        formData.append("intro", intro);
        formData.append("location", location);
        formData.append("hour", hour);
        formData.append("language", language);
        formData.append("expertise", expertise);
        formData.append("brokerId", brokerId);
        formData.append("accountId", accountId);
        formData.append("status", status);

        if (avatarFile) {
            formData.append("avatar", avatarFile);
        }

        $.ajax({
            type: "POST",
            url: "./services/broker/edit.php",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                Swal.fire({
                    title: "Thông báo",
                    text: result.message,
                    icon: result.status,
                    showConfirmButton: true,
                }).then(function() {
                    if (result.path) {
                        window.location.assign(result.path);
                    } else {
                        closeBrokerModal();
                    }
                });
            },
            error: function(e) {
                Swal.fire({
                    title: "Thông báo",
                    text: "Lỗi khi cập nhật môi giới.",
                    icon: "error",
                    showConfirmButton: true,
                });
            },
        });
    });

    addBrokerForm.addEventListener("submit", (event) => {
        event.preventDefault();

        const addLanguageSelect = document.getElementById("add-language");
        const addExpertiseSelect = document.getElementById("add-expertise");

        var name = document.getElementById("add-name").value;
        var phone = document.getElementById("add-phone").value;
        var email = document.getElementById("add-email").value;
        var password = document.getElementById("add-password").value;
        var intro = document.getElementById("add-intro").value;
        var hour = document.getElementById("add-hour").value;
        var language = Array.from(addLanguageSelect.options).filter(option => option.selected).map(option => option.value).join(", ");
        var expertise = Array.from(addExpertiseSelect.options).filter(option => option.selected).map(option => option.value).join(", ");
        var location = document.getElementById("add-location").value;

        var avatarFile = document.getElementById("add-avatar").files[0];

        if (name.trim() === "" || phone.trim() === "" || email.trim() === "" || password.trim() === "") {
            Swal.fire({
                title: "Thông báo",
                text: "Vui lòng nhập các thông tin bắt buộc.",
                icon: "warning",
                showConfirmButton: true,
            });
            return;
        }

        if (language.trim() === "" || expertise.trim() === "") {
            Swal.fire({
                title: "Thông báo",
                text: "Vui lòng chọn ít nhất một giá trị cho ngôn ngữ, chuyên môn và khu vực.",
                icon: "warning",
                showConfirmButton: true,
            });
            return;
        }

        const formData = new FormData();
        formData.append("name", name);
        formData.append("phone", phone);
        formData.append("email", email);
        formData.append("password", password);
        formData.append("intro", intro);
        formData.append("location", location);
        formData.append("hour", hour);
        formData.append("language", language);
        formData.append("expertise", expertise);
        if (avatarFile) {
            formData.append("avatar", avatarFile);
        }
        $.ajax({
            type: "POST",
            url: "./services/broker/add.php",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                Swal.fire({
                    title: "Thông báo",
                    text: result.message,
                    icon: result.status,
                    showConfirmButton: true,
                }).then(function() {
                    if (result.path) {
                        window.location.assign(result.path);
                    }
                });
            },
            error: function(e) {
                Swal.fire({
                    title: "Thông báo",
                    text: "Lỗi",
                    icon: "error",
                    showConfirmButton: true,
                });
            },
        });
    });
});