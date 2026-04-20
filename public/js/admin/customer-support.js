$(document).ready(function () {
    const role = App.getRole();
    var btnResolveSupport = $('button.resolve-customer-support');
    var btnConfirmResolve = $('#confirmResolveBtn');

    // Resolve customer support request
    window.showCSDetail = function (des) {
        const supportId = btnResolveSupport.closest('tr').data('cs-id');
        $('#resolved_type').val('');
        $('#resolved_content').val('');
        $('#customer_support_id').val(supportId);
        $('#problem_support').val(des);
    };

    $('select[name="resolved_type"]').on('change', function () {
        const selectedType = $('select[name="resolved_type"] option:selected').val();
        console.log(selectedType);

        if (selectedType == 'Gửi email') {
            $('#resolved_content_label').text('Nội dung email');
        } else {
            $('#resolved_content_label').text('Nội dung hỗ trợ');
        }
    });

    // Confirm resolve customer support
    btnConfirmResolve.on('click', function () {
        const formData = new FormData($('#customerSupportResolvedForm')[0]);
        formData.append('csrf_token', App.getToken());

        $.ajax({
            type: 'POST',
            url: App.appURL + role + '/customer-supports',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                App.setToken(response.token);
                if (response.status == 'success') {
                    showSuccessMessage(response.msg);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            },
            error: function (xhr, status, error) {
                App.setToken(xhr.responseJSON.token);

                if (xhr.responseJSON.status == 'error') {
                    showErrorMessage(xhr.responseJSON.msg);
                    return;
                }
            },
        });
    });

    window.deleteCS = function (csId) {
        App.showModalConfirm('Bạn có chắc chắn muốn xóa hỗ trợ này không?').then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: App.appURL + role + '/customer-supports/delete',
                    data: { cs_id: csId, csrf_token: App.getToken() },
                    dataType: 'json',
                    success: function (response) {
                        App.setToken(response.token);
                        if (response.status == 'success') {
                            showSuccessMessage(response.msg);
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function (xhr, status, error) {
                        App.setToken(xhr.responseJSON.token);

                        if (xhr.responseJSON.status == 'error') {
                            showErrorMessage(xhr.responseJSON.msg);
                            return;
                        }
                    },
                });
            }
        });
    };
});
