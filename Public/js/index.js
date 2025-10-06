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
});
