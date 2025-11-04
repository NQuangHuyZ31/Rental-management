/*
	Author: Huy Nguyen
	Date: 01/09/2025
	Purpose: provide common functions for the application
*/

// Config
window.App = {
    appURL: '/Rental-management/',
    PROVINCE: null,
    WARD: null,

    getToken: function () {
        return $('input[name="csrf_token"]').val() ?? '';
    },

    setToken: function (token) {
        console.log('setToken', token);
        $('input[name="csrf_token"]').val(token);
    },

    getRole: function () {
        return $('input[name="role"]').val() ?? '';
    },

    showSuccessMessage: function (message, status) {
        Swal.fire({
            icon: status,
            title: 'Thông báo',
            text: message,
        });
    },

    // Function for showing messages in modal with higher z-index
    showModalMessage: function (message, status) {
        Swal.fire({
            icon: status,
            title: 'Thông báo',
            text: message,
            backdrop: false, // Don't show backdrop since we're in a modal
            allowOutsideClick: false,
        });
    },

    // Function for confirmation in modal
    showModalConfirm: function (message) {
        return Swal.fire({
            icon: 'warning',
            title: 'Xác nhận',
            text: message,
            showCancelButton: true,
            confirmButtonText: 'Có',
            cancelButtonText: 'Không',
            customClass: {
                container: 'swal2-modal-high-z',
            },
            backdrop: false,
            allowOutsideClick: false,
        });
    },

    getProvinceData: function () {
        return fetch('https://provinces.open-api.vn/api/v2/').then((response) => response.json());
    },

    getWardData: function (provinceCode) {
        return fetch(`https://provinces.open-api.vn/api/v2/p/${provinceCode}?depth=2`).then((response) => response.json());
    },

    setProvinceData: function (Element, provinceName = '') {
        return this.getProvinceData().then(function (data) {
            if (!data || !Array.isArray(data)) {
                console.error('Không lấy được dữ liệu tỉnh', data);
                return;
            }

            $.each(data, function (index, province) {
                $(Element).append(
                    `<option value="${province.name}" ${province.name == provinceName ? 'selected' : ''} data-code="${province.code}">
                        ${province.name}
                    </option>`
                );
            });
        });
    },

    setWardData: function (provinceCode, Element, wardName = '') {
        return this.getWardData(provinceCode).then(function (data) {
            $.each(data.wards, function (index, ward) {
                $(Element).append(`<option value="${ward.name}" ${ward.name == wardName ? 'selected' : ''} data-code="${ward.code}">${ward.name}</option>`);
            });
        });
    },
};

// config toastr
document.addEventListener('DOMContentLoaded', function () {
    // Config toastr
    toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: false,
        progressBar: false,
        positionClass: 'toast-top-right',
        preventDuplicates: false,
        onclick: null,
        showDuration: '2000',
        hideDuration: '2000',
        timeOut: '2000',
        extendedTimeOut: '2000',
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut',
        target: 'body',
    };

    // Config Loading Overplay
    JsLoadingOverlay.setOptions({
        containerID: null, // append trực tiếp vào body
        overlayBackgroundColor: '#FFFFFF',
        overlayOpacity: 0.7,
        spinnerIcon: 'ball-clip-rotate-multiple',
        spinnerColor: '#DE812F',
        spinnerSize: '1x',
        overlayIDName: 'overlay',
        spinnerIDName: 'spinner',
        overlayZIndex: 10000, // cao hơn modal
        spinnerZIndex: 10001, // cao hơn cả overlay
    });

    $('.cleave-input').each(function () {
        const type = $(this).data('type');

        let cleaveConfig = {};

        switch (type) {
            case 'currency':
                cleaveConfig = {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand',
                    numeralPositiveOnly: true,
                };
                break;

            case 'number':
                cleaveConfig = {
                    numeral: true,
                    numeralThousandsGroupStyle: 'none', // không có dấu phẩy
                    numeralDecimalScale: 0, // chỉ cho số nguyên
                    numeralPositiveOnly: true,
                };
                break;

            case 'percent':
                cleaveConfig = {
                    numeral: true,
                    numeralThousandsGroupStyle: 'none',
                    numeralPositiveOnly: true,
                    numeralDecimalScale: 2, // cho phép 2 số thập phân
                    onValueChanged: function (e) {
                        // Giới hạn max 100
                        if (parseFloat(e.target.rawValue) > 100) {
                            e.target.setRawValue(100);
                        }
                    },
                };
                break;
        }

        const cleaveInstance = new Cleave(this, cleaveConfig);

        // Nếu input đã có value từ trước => format lại
        if ($(this).val()) {
            cleaveInstance.setRawValue($(this).val());
        }
    });

    // Helper function to show message
    // Configure SweetAlert
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
    });

    // Function to show success message
    window.showSuccessMessage = function (message) {
        Toast.fire({
            icon: 'success',
            title: message,
        });
    };

    // Function to show error message
    window.showErrorMessage = function (message) {
        Toast.fire({
            icon: 'error',
            title: message,
        });
    };

    // Function to show warning message
    window.showWarningMessage = function (message) {
        Toast.fire({
            icon: 'warning',
            title: message,
        });
    };

    // Function to show info message
    window.showInfoMessage = function (message) {
        Toast.fire({
            icon: 'info',
            title: message,
        });
    };
});
