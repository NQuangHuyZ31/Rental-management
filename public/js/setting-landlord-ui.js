$(document).ready(function () {
    // ===================================================Common Functions===================================================

    // Generic CRUD functions for settings
    const SettingsManager = {
        // Generic save function
        save: function (config) {
            const data = {
                [config.idField]: $('#' + config.idField).val(),
                [config.nameField]: $('#' + config.nameField).val(),
                [config.statusField]: $('#' + config.statusField).is(':checked') ? 'active' : 'inactive',
                csrf_token: App.getToken(),
            };

            $.ajax({
                url: App.appURL + config.saveUrl,
                type: 'POST',
                data: data,
                success: function (response) {
                    if (response.status === 'success') {
                        showSuccessMessage(response.message);
                        App.setToken(response.token);
                        SettingsManager.closeModal(config.modalId);
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
        },

        // Generic delete function
        delete: function (config, itemId) {
            App.showModalConfirm(config.deleteConfirmMessage).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: App.appURL + config.deleteUrl,
                        type: 'POST',
                        data: {
                            [config.idField]: itemId,
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
        },

        // Generic modal functions
        openCreateModal: function (modalId, titleId, titleText) {
            $('#' + modalId).removeClass('hidden');
            $('#' + titleId).text(titleText);
        },

        openEditModal: function (modalId, titleId, titleText, item, config) {
            $('#' + modalId).removeClass('hidden');
            $('#' + titleId).text(titleText);
            $('#' + config.idField).val(item.id);
            $('#' + config.nameField).val(item[config.nameField]);
            $('#' + config.statusField).prop('checked', item[config.statusField] === 'active');
        },

        closeModal: function (modalId) {
            $('#' + modalId).addClass('hidden');
        },
    };

    // Tab management
    const TabManager = {
        switchTab: function (tabName, storageKey) {
            // Hide all tab contents
            $('.tab-item').each((index, content) => {
                $(content).addClass('hidden');
            });

            // Remove active class from all tabs
            $('.tab-button').each((index, button) => {
                $(button).removeClass('border-blue-500 text-blue-600');
                $(button).addClass('border-transparent text-gray-500');
            });

            // Show selected tab content
            $(`#${tabName}-categories, #${tabName}-amenities`).removeClass('hidden');

            // Add active class to selected tab
            const activeTab = $(`#${tabName}-tab`);
            $(activeTab).removeClass('border-transparent text-gray-500');
            $(activeTab).addClass('border-blue-500 text-blue-600');

            // Save current tab to localStorage
            localStorage.setItem(storageKey, tabName);
        },

        loadSavedTab: function (storageKey, defaultTab) {
            const savedTab = localStorage.getItem(storageKey);
            if (savedTab && (savedTab === 'system' || savedTab === 'user')) {
                TabManager.switchTab(savedTab, storageKey);
            } else {
                TabManager.switchTab(defaultTab, storageKey);
            }
        },
    };

    // ===================================================Bank Settings===================================================

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

    const categoryConfig = {
        idField: 'categoryId',
        nameField: 'rental_category_name',
        statusField: 'rental_category_status',
        modalId: 'categoryModal',
        titleId: 'modalTitle',
        saveUrl: 'landlord/setting/categories/create',
        deleteUrl: 'landlord/setting/categories/delete',
        deleteConfirmMessage: 'Bạn có chắc chắn muốn xóa danh mục này?',
    };

    // Save category
    $('.saveCategoryBtn').on('click', function (e) {
        e.preventDefault();
        SettingsManager.save(categoryConfig);
    });

    // Category modal functions
    window.openCreateModal = function () {
        SettingsManager.openCreateModal(categoryConfig.modalId, categoryConfig.titleId, 'Thêm danh mục mới');
        $('#categoryForm')[0].reset();
        $('#' + categoryConfig.idField).val('');
        $('#' + categoryConfig.statusField).prop('checked', true);
    };

    window.openEditModal = function (category) {
        SettingsManager.openEditModal(categoryConfig.modalId, categoryConfig.titleId, 'Chỉnh sửa danh mục', category, categoryConfig);
    };

    window.deleteCategory = function (categoryId) {
        SettingsManager.delete(categoryConfig, categoryId);
    };

    window.closeModal = function () {
        SettingsManager.closeModal(categoryConfig.modalId);
    };

    // ===================================================Amenities===================================================

    const amenityConfig = {
        idField: 'amenityId',
        nameField: 'rental_amenity_name',
        statusField: 'rental_amenity_status',
        modalId: 'amenityModal',
        titleId: 'modalTitle',
        saveUrl: 'landlord/setting/amenities/create',
        deleteUrl: 'landlord/setting/amenities/delete',
        deleteConfirmMessage: 'Bạn có chắc chắn muốn xóa tiện ích này?',
    };

    // Save amenity
    $('.saveAmenityBtn').on('click', function (e) {
        e.preventDefault();
        SettingsManager.save(amenityConfig);
    });

    // Amenity modal functions
    window.openCreateAmenityModal = function () {
        SettingsManager.openCreateModal(amenityConfig.modalId, amenityConfig.titleId, 'Thêm tiện ích mới');
        $('#amenityForm')[0].reset();
        $('#' + amenityConfig.idField).val('');
        $('#' + amenityConfig.statusField).prop('checked', true);
    };

    window.openEditAmenityModal = function (amenity) {
        SettingsManager.openEditModal(amenityConfig.modalId, amenityConfig.titleId, 'Chỉnh sửa tiện ích', amenity, amenityConfig);
    };

    window.deleteAmenity = function (amenityId) {
        SettingsManager.delete(amenityConfig, amenityId);
    };

    window.closeAmenityModal = function () {
        SettingsManager.closeModal(amenityConfig.modalId);
    };

    // ===================================================Tab Management===================================================

    // Tab switching functionality
    window.switchTab = function (tabName) {
        // Determine storage key based on current page
        const storageKey = window.location.pathname.includes('amenities') ? 'amenities_active_tab' : 'categories_active_tab';
        TabManager.switchTab(tabName, storageKey);
    };

    // Load saved tab on page load
    window.loadSavedTab = function () {
        const storageKey = window.location.pathname.includes('amenities') ? 'amenities_active_tab' : 'categories_active_tab';
        TabManager.loadSavedTab(storageKey, 'system');
    };

    // Initialize tabs on page load
    loadSavedTab();
});
