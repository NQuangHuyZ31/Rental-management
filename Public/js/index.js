$(document).ready(function () {
    const PROVINCE = '#province';
    const WARD = '#ward';

    // Hàm load Province
    function loadProvince(defaultValue = null, defaultWard = null) {
        $(PROVINCE).html('<option value="">Chọn tỉnh/thành phố</option>');
        return App.setProvinceData(PROVINCE).then(function () {
            if (defaultValue) {
                $(PROVINCE).val(defaultValue).trigger('change');

                // Sau khi chọn province xong -> load ward
                if (defaultWard) {
                    const code = $(PROVINCE).find(':selected').data('code');
                    if (code) {
                        $(WARD).html('<option value="">Chọn phường/xã</option>');
                        App.setWardData(code, WARD, defaultWard);
                    }
                }
            }
        });
    }

    // Province change event
    $(PROVINCE).on('change', function () {
        $(WARD).html('<option value="">Chọn phường/xã</option>');
        const code = $(this).find(':selected').data('code');
        if (code) {
            App.setWardData(code, WARD);
        }
    });

    // --- chạy 1 lần khi load page ---
    const defaultProvince = $(PROVINCE).data('default');
    const defaultWard = $(WARD).data('default');
    loadProvince(defaultProvince, defaultWard);

    // Send customer-support
    $('button#supportBtn').on('click', function (e) {
        const button = $(this);
        button.prop('disabled', true);
        const formData = new FormData($('form#supportForm')[0]);
        console.log(formData);

        if (window.JsLoadingOverlay?.show) JsLoadingOverlay.show();

        $.ajax({
            url: App.appURL + 'ho-tro',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                if (window.JsLoadingOverlay?.hide) JsLoadingOverlay.hide();
                showSuccessMessage(response.msg);
                if (response.token) App.setToken(response.token);
                $('form#supportForm')[0].reset();
                setTimeout(() => button.prop('disabled', false), 1500);
            },
            error: function (xhr) {
                if (window.JsLoadingOverlay?.hide) JsLoadingOverlay.hide();
                const json = xhr.responseJSON || {};
                showErrorMessage(json.msg || 'Có lỗi xảy ra');
                if (json.token) App.setToken(json.token);
                setTimeout(() => button.prop('disabled', false), 1500);
            },
        });
    });
});
