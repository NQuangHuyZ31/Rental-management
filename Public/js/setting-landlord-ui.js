$(document).ready(function () {
    // Set bank code when select bank name
    $('#bank_account_name').on('change', function () {
        const bankCode = $(this).find(':selected').data('bank-code');
        $('#bank_code').val(bankCode);
    });

    // Confirm when change api key
    $('#saveChangeApiKey').on('click', function (e) {
        e.preventDefault();
        App.showModalConfirm('Bạn có chắc chắn muốn thay đổi API Key?').then((result) => {
            if (result.isConfirmed) {
                $('#apiKeyForm').submit();
            }
        });
    });

    // ===================================================Categories===================================================
    // Create category
    $('.saveCategoryBtn').on('click', function (e) {
        e.preventDefault();
        saveCategory();
    });

    // Save category
    function saveCategory() {
        const categoryName = $('#rental_category_name').val();
        const categoryStatus = $('#rental_category_status').is(':checked') ? 'active' : 'inactive';
        const categoryId = $('#categoryId').val();

        $.ajax({
            url: App.appURL + 'landlord/setting/categories/create',
            type: 'POST',
            data: {
                category_id: categoryId,
                rental_category_name: categoryName,
                rental_category_status: categoryStatus,
                csrf_token: App.getToken(),
            },
            success: function (response) {
                if (response.status === 'success') {
                    showSuccessMessage(response.message);
                    App.setToken(response.token);
                    closeModal();
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                }
            },
            error: function (xhr, status, error) {
                showErrorMessage(xhr.responseJSON.message);
                App.setToken(xhr.responseJSON.token);
                return;
            },
        });
    }

    // Open create modal
    window.openCreateModal = function () {
        $('#categoryModal').removeClass('hidden');
    };

    // Open edit modal
    window.openEditModal = function (category) {
        $('#categoryModal').removeClass('hidden');
        $('#categoryId').val(category.id);
        $('#rental_category_name').val(category.rental_category_name);
        $('#rental_category_status').prop('checked', category.rental_category_status === 'active');
    };

    // Delete category
    window.deleteCategory = function (categoryId) {
        App.showModalConfirm('Bạn có chắc chắn muốn xóa danh mục này?').then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: App.appURL + 'landlord/setting/categories/delete',
                    type: 'POST',
                    data: {
                        category_id: categoryId,
                        csrf_token: App.getToken(),
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            showSuccessMessage(response.message);
                            App.setToken(response.token);
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        }
                    },
                    error: function (xhr, status, error) {
                        showErrorMessage(xhr.responseJSON.message);
                        App.setToken(xhr.responseJSON.token);
                        return;
                    },
                });
            }
        });
    };

    // Close modal
    window.closeModal = function () {
        $('#categoryModal').addClass('hidden');
    };
});
