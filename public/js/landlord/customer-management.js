/*
    Author: Huy Nguyen
    Date: 2025-10-29
    Purpose: handle logic customer management
*/

$(document).ready(function () {
    const findCustomerBtn = $('#searchCustomerBtn');
    const error = '_error';
    const editElement = 'edit_';
    const role = App.getRole();
    const PROVINCE = $('.customer-info-address').find('select[name="province"]');
    const WARD = $('.customer-info-address').find('select[name="ward"]');
    const formAdd = $('form#tenantForm');
    const formEdit = $('form#editTenantForm');

    // find customer
    findCustomerBtn.on('click', function (e) {
        e.preventDefault();

        if ($('input[name="email"]').val() == '') {
            showErrorMessage('Vui lòng nhập email');
            return;
        }

        $('.customer-info-block, .customer-info-address, .customer-rental-block').addClass('hidden');
        $('.create-customer-checkbox').find('input[name="check-create-customer"]').prop('checked', false);
        $('input[name="tenant_id"]').val('');
        $('#email_error').text('');
        $('.customer-info-block, .customer-info-address')
            .find('input, select, textarea')
            .each(function () {
                $(this).val('').attr('readonly', false).removeClass('opacity-50 pointer-events-none');
            });

        $.ajax({
            type: 'POST',
            url: App.appURL + role + '/tenant/find',
            data: {
                csrf_token: App.getToken(),
                email: $('input[name="email"]').val(),
            },
            dataType: 'json',
            success: function (response) {
                App.setToken(response.token);

                if (response.data != null) {
                    $('.customer-info-block, .customer-info-address, .customer-rental-block').removeClass('hidden');
                    $('.create-customer-checkbox').addClass('hidden').removeClass('flex');
                    displayCustomerInfo(response.data);
                } else {
                    $('#email_error').text('Khách hàng không tồn tại').css('display', 'block');
                    $('.create-customer-checkbox').removeClass('hidden').addClass('flex');
                }
            },
            error: function (xhr, status, error) {
                App.setToken(xhr.responseJSON.token);
                showErrorMessage(xhr.responseJSON.msg);
                return;
            },
        });
    });

    // ===========================================EDIT===================================
    // ===================================FUNCTION==============================
    window.editTenant = function (tenantId, roomId) {
        $.ajax({
            type: 'GET',
            url: App.appURL + App.getRole() + '/tenant/edit',
            data: {
                tenant_id: tenantId,
                room_id: roomId,
            },
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                    $('input[name="email"]').val(response.data.user.email);
                    $('input[name="citizen_id"]').val(response.data.user.citizen_id);
                    $('input[name="join_date"]').val(response.data.room.join_date);
                    if (response.data.room.is_primary == 1) {
                        $('input[name="is_primary"]').prop('checked', true);
                    }
                    $('input[name="note"]').val(response.data.room.note);
                    $('input#edit_selected_room_id').val(response.data.room.room_id);
                    displayCustomerInfo(response.data.user, true);

                    //
                    $('#edit_current_room_display').html(`
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-medium text-gray-900">${response.data.room.room_name || 'N/A'}</div>
                                <div class="text-sm text-gray-500">${response.data.room.house_name || 'N/A'}</div>
                            </div>
                            <div class="text-sm text-gray-500">
                                <i class="fas fa-home mr-1"></i>
                                    Phòng hiện tại
                            </div>
                        </div>
                    `);
                    // show modal
                    showEditModal();
                }
            },
            error: function (xhr, status, error) {
                if (xhr.responseJSON.status == 'error') {
                    showErrorMessage(xhr.responseJSON.msg);
                    return;
                }
            },
        });
    };

    // Handle edit form submit
    formEdit.find('button#editSubmitBtn').on('click', function (e) {
        e.preventDefault();
        const formData = new FormData(formEdit[0]);

        $.ajax({
            type: 'POST',
            url: App.appURL + role + '/tenant/update',
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                    App.setToken(response.token);
                    showSuccessMessage(response.msg);
                    closeEditTenantModal();
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                }
            },
            error: function (xhr, status, error) {
                if (xhr.responseJSON.status == 'error') {
                    App.setToken(xhr.responseJSON.token);
                    showErrorMessage(xhr.responseJSON.msg);
                    return;
                }
            },
        });
    });

    // display customer info
    function displayCustomerInfo(customer, edit = false) {
        const province = edit ? formEdit.find('select[name="province"]') : formAdd.find('select[name="province"]');
        const ward = edit ? formEdit.find('select[name="ward"]') : formAdd.find('select[name="ward"]');
        $('input[name="tenant_id"]').val(customer.id);
        $('input[name="username"]').val(customer.username);
        $('input[name="phone"]').val(customer.phone);
        $('input[name="birthday"]').val(customer.birthday);
        $('select[name="gender"]').val(customer.gender);
        $('input[name="job"]').val(customer.job);
        $('textarea[name="address"]').val(customer.address);
        // selected province
        province
            .find('option')
            .filter(function () {
                return $(this).val() === customer.province;
            })
            .prop('selected', true);

        const provinceCode = province.find('option:selected').data('code');
        App.setWardData(provinceCode, ward, customer.ward);
        $(`${edit ? '.customer-info-block_edit' : '.customer-info-block'}, ${edit ? '.customer-info-address_edit' : '.customer-info-address'}`)
            .find('input, select, textarea')
            .each(function () {
                const $el = $(this);

                if ($el.is('input, textarea')) {
                    // Input: dùng readonly
                    $el.attr('readonly', true).addClass('opacity-75');
                } else if ($el.is('select')) {
                    // Select: khóa thao tác nhưng vẫn submit
                    $el.addClass('pointer-events-none opacity-75');
                }
            });
    }

    // Added customer for room
    formAdd.find('button#submitBtn').on('click', function (e) {
        e.preventDefault();
        const createInput = $('.create-customer-checkbox').find('input[name="check-create-customer"]');
        const formData = new FormData(formAdd[0]);
        formData.append('csrf_token', App.getToken());

        createInput.is(':checked') ? formData.append('is_create', 1) : formData.append('is_create', 0);

        $.ajax({
            type: 'POST',
            url: App.appURL + role + '/tenant/create',
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                    App.setToken(response.token);
                    showSuccessMessage(response.msg);
                    $('button#closeAddTenantModal').trigger('click');
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                }
            },
            error: function (xhr, status, error) {
                if (xhr.responseJSON.status == 'error') {
                    App.setToken(xhr.responseJSON.token);
                    showErrorMessage(xhr.responseJSON.msg);
                    return;
                }
            },
        });
    });

    // checkbox create new customer
    $('input[name="check-create-customer"]').on('change', function () {
        $('.customer-info-block, .customer-info-address, .customer-rental-block').toggleClass('hidden');
    });

    // Show edit modal
    window.showEditModal = function () {
        formEdit.closest('#editTenantModal').removeClass('hidden');
    };

    // Close edit modal
    window.closeEditTenantModal = function () {
        formEdit.closest('#editTenantModal').addClass('hidden');
        formEdit[0].reset();
        formAdd[0].reset();
    };

    // Load province for edit modal
    loadProvince(formEdit.find('select[name="province"]'), null, formEdit.find('select[name="ward"]'), null);

    // Province change event
    $(PROVINCE).on('change', function () {
        $(WARD).html('<option value="">Chọn phường/xã</option>');
        const code = $(this).find(':selected').data('code');
        if (code) {
            App.setWardData(code, WARD);
            $(WARD).attr('disabled', false);
        }
    });
});
