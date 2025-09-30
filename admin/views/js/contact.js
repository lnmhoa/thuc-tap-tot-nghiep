document.addEventListener('DOMContentLoaded', () => {
    const addContactModal = document.getElementById('addContactModal');
    const closeAddModalButton = document.getElementById('closeAddModalButton');
    const addContactForm = document.getElementById('addContactForm');
    const addContactButton = document.querySelector('.add-contact-button');

    const editContactModal = document.getElementById('editContactModal');
    const closeEditModalButton = document.getElementById('closeEditModalButton');
    const editContactForm = document.getElementById('editContactForm');
    const cancelEditButton = editContactModal.querySelector('.cancel-edit');

    const dataTable = document.querySelector('.data-table table tbody');

    function openAddModal() {
        if (addContactModal) {
            addContactModal.style.display = 'flex';
        }
    }

    function closeAddModal() {
        if (addContactModal) {
            addContactModal.style.display = 'none';
            if (addContactForm) {
                addContactForm.reset();
            }
        }
    }

    function openEditModal(contactData) {
        if (editContactModal && contactData) {
            document.getElementById('edit-name').value = contactData.name;
            document.getElementById('edit-phone').value = contactData.phone;
            document.getElementById('edit-location').value = contactData.location;
            document.getElementById('edit-note').value = contactData.note;
            document.getElementById('edit-subject').value = contactData.subject;
            document.getElementById('edit-price').value = contactData.price;
            document.getElementById('edit-createdAt').value = contactData.createdAt;
            document.getElementById('edit-status').value = contactData.status;
            document.getElementById('edit-broker').value = contactData.broker;
            document.getElementById('edit-message').value = contactData.message;
            document.getElementById('edit-id').value = contactData.id;
            editContactModal.style.display = 'flex';
        }
    }

    function closeEditModal() {
        if (editContactModal) {
            editContactModal.style.display = 'none';
            if (editContactForm) {
                editContactForm.reset();
            }
        }
    }
    if (addContactButton) {
        addContactButton.addEventListener('click', openAddModal);
    }

    if (closeAddModalButton) {
        closeAddModalButton.addEventListener('click', closeAddModal);
    }

    if (closeEditModalButton) {
        closeEditModalButton.addEventListener('click', closeEditModal);
    }

    if (cancelEditButton) {
        cancelEditButton.addEventListener('click', closeEditModal);
    }

    if (dataTable) {
        dataTable.addEventListener('click', (event) => {
            const target = event.target;
            const row = target.closest('tr');
            if (!row) return;

            if (target.classList.contains('edit')) {
                const cells = row.querySelectorAll('td');
                const contactData = {
                    name: cells[1]?.textContent.trim(),
                    phone: cells[2]?.textContent.trim(),
                    location: cells[12]?.textContent.trim(),
                    note: cells[13]?.textContent.trim(),
                    subject: cells[4]?.textContent.trim(),
                    price: cells[5]?.textContent.trim(),
                    createdAt: cells[6]?.textContent.trim(),
                    status: cells[7]?.querySelector('.status')?.classList[1] || '',
                    broker: cells[9]?.textContent.trim(),
                    message: cells[10]?.textContent.trim(),
                    id: cells[11]?.textContent.trim(),
                };
                openEditModal(contactData);
            }
        });
    }


    window.addEventListener('click', (event) => {
        if (event.target === addContactModal) {
            closeAddModal();
        }
        if (event.target === editContactModal) {
            closeEditModal();
        }
    });
});