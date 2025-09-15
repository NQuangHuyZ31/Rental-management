$(document).ready(function () {
    const PROVINCE = '#province';
    const WARD = '#ward';

    // Add event listener for province select
    $(PROVINCE).on('click', function () {
        App.setProvinceData(PROVINCE).then(function () {});
    });

    // Add event listener for province change
    $(PROVINCE).on('change', function () {
        $(WARD).html('<option value="">Chọn phường/xã</option>');
        const selectedValue = $(this).val();
        const code = $(this).find(':selected').data('code');

        if (code) {
            App.setWardData(code, WARD).then(function () {
                // Re-set province value sau khi load xong
                $(PROVINCE).val(selectedValue);
            });
        }
    });
});
