/*
	Author: Huy Nguyen
	Date: 01/09/2025
	Purpose: provide common functions for the application
*/

// Config
window.App = {
    appURL: '/Rental-management',

    getToken: function () {
        return $('input[name="csrf_token"]').val();
    },

    setToken: function (token) {
        $('input[name="csrf_token"]').val(token);
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
    };

    // Config Loading Overplay
    JsLoadingOverlay.setOptions({
        overlayBackgroundColor: '#FFFFFF',
        overlayOpacity: '0.7',
        spinnerIcon: 'ball-clip-rotate-multiple',
        spinnerColor: '#DE812F',
        spinnerSize: '1x',
        overlayIDName: 'overlay',
        spinnerIDName: 'spinner',
        offsetX: 0,
        offsetY: 0,
        containerID: null,
        lockScroll: false,
        overlayZIndex: 9998,
        spinnerZIndex: 9999,
    });
});
