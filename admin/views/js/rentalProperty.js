document.addEventListener('DOMContentLoaded', () => {
    const apartmentModal = document.getElementById('apartmentModal');
    const closeButton = apartmentModal.querySelector('.close-button');
    const cancelButton = document.getElementById('cancelButton');
    const apartmentForm = document.getElementById('apartmentForm');
    const saveApartmentButton = document.getElementById('saveApartmentButton');

    const dataTable = document.querySelector('.data-table table tbody');
    function openApartmentModal() {
        if (apartmentModal) {
            apartmentModal.style.display = 'flex';
        }
    }

    function closeApartmentModal() {
        if (apartmentModal) {
            apartmentModal.style.display = 'none';
            if (apartmentForm) {
                apartmentForm.reset();
            }
            document.getElementById('modal-name').readOnly = false;
            document.getElementById('modal-address').readOnly = false;
            document.getElementById('modal-area').readOnly = false;
            document.getElementById('modal-price').readOnly = false;
            document.getElementById('modal-status').disabled = false;
            document.getElementById('modal-date').readOnly = true;
            
            if (saveApartmentButton) {
                saveApartmentButton.style.display = 'inline-block';
            }
        }
    }

    if (dataTable) {
        dataTable.addEventListener('click', async (event) => {
            const target = event.target;
            const row = target.closest('tr');
            if (!row) return;

            if (target.classList.contains('edit')) {
                const propertyId = row.dataset.propertyId;
                
                if (!propertyId) {
                    alert('Không tìm thấy ID bất động sản!');
                    return;
                }

                try {
                    const formData = new FormData();
                    formData.append('propertyId', propertyId);
                    const response = await fetch('./services/rentalProperty/getData.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();
                    if (result.status === 'success') {
                        openEditModal(result.data);
                    } else {
                        alert('Lỗi: ' + result.message);
                    } 
                } catch (error) {
                    alert('Lỗi kết nối: ' + error.message);
                }
            }
        });
    }


    function openEditModal(propertyData) {
        if (!propertyData) return;

        console.log('=== OPENING EDIT MODAL ===');
        console.log('Property Data:', propertyData);

        const fieldsMapping = {
            'modal-title': propertyData.title,
            'modal-description': propertyData.description,
            'modal-address': propertyData.address,
            'modal-location_name': propertyData.location_name,
            'modal-type_name': propertyData.type_name,
            'modal-broker': propertyData.broker_name+' ('+propertyData.broker_phone+')',
            'modal-status': propertyData.status,
            'modal-transactionType': propertyData.transactionType,
            'modal-price': propertyData.price,
            'modal-area': propertyData.area,
            'modal-bedrooms': propertyData.bedrooms,
            'modal-bathrooms': propertyData.bathrooms,
            'modal-floors': propertyData.floors,
            'modal-frontage': propertyData.frontage,
            'modal-furniture': propertyData.furniture,
            'modal-parking': propertyData.parking,
            'modal-createdAt': propertyData.createdAt
        };

        Object.keys(fieldsMapping).forEach(fieldId => {
            const element = document.getElementById(fieldId);
            const value = fieldsMapping[fieldId] || '';
        });

        if (saveApartmentButton) {
            saveApartmentButton.style.display = 'inline-block';
        }

        openApartmentModal();
        console.log('=== MODAL OPENED ===');
    }

    if (closeButton) closeButton.addEventListener('click', closeApartmentModal);
    if (cancelButton) cancelButton.addEventListener('click', closeApartmentModal);

    window.addEventListener('click', (event) => {
        if (apartmentModal && event.target === apartmentModal) {
            closeApartmentModal();
        }
    });
});