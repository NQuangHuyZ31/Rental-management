$(document).ready(function () {
    const PROVINCE = $('select[name="province"]');
    const WARD = $('select[name="ward"]');

    // Add event listener for province select
    $(PROVINCE).on('click', function () {
        App.getProvinceData().then(function (data) {
            if (!data || !Array.isArray(data)) {
                console.error('Không lấy được dữ liệu tỉnh', data);
                return;
            }

            $.each(data, function (index, province) {
                $(PROVINCE).append(
                    `<option value="${province.name}" data-code="${province.code}">
                        ${province.name}
                    </option>`
                );
            });
        });
    });

    // Add event listener for ward select
    $(PROVINCE).on('change', function () {
        const code = $(this).find(':selected').data('code');
        console.log(code);
        App.getWardData(code).then(function (data) {
            console.log(data);
            $(WARD).html('<option value="">Chọn phường/xã</option>');
            $.each(data.wards, function (index, district) {
                $(WARD).append(`<option value="${district.name}" data-code="${district.code}">${district.name}</option>`);
            });
        });
    });
});
