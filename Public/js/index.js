$(document).ready(function () {
    const PROVINCE = $('select[name="province"]');
    const WARD = $('select[name="ward"]');

    // Add event listener for province select
    $(PROVINCE).on('click', function () {
        App.setProvinceData(PROVINCE).then(function () {});
    });

    // Add event listener for province change
    $(PROVINCE).on('change', function () {
        const selectedValue = $(this).val();
        const code = $(this).find(':selected').data('code');

        if (code) {
            App.setWardData(code, WARD).then(function () {
                // Keep the selected province value
                PROVINCE.val(selectedValue);
            });
        }
    });
});
