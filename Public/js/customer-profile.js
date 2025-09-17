$(document).ready(function () {
    // Update customer information
    $('#updateProfile').click(function (e) {
        e.preventDefault();
        const button = $(this);
        button.prop('disabled', true);

        const formData = new FormData($('#profileForm')[0]);
        formData.append('csrf_token', App.getToken());
        JsLoadingOverlay.show();

        $.ajax({
            url: App.appURL + 'customer/profile/update',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                JsLoadingOverlay.hide();
                toastr['success'](response.message);
                App.setToken(response.token);

                setTimeout(() => {
                    button.prop('disabled', false);
                }, 3000);
            },
            error: function (xhr, status, error) {
                JsLoadingOverlay.hide();
                toastr['error'](xhr.responseJSON.message);
                App.setToken(xhr.responseJSON.token);

                setTimeout(() => {
                    button.prop('disabled', false);
                }, 3000);
            },
        });
    });
});
