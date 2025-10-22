$(document).ready(function () {
    window.initProfileHandlers = function (options) {
        const role = options?.role || (window.location.pathname.includes('landlord') ? 'landlord' : 'customer');
        const defaultBase = role === 'landlord' ? 'landlord/profile' : 'customer/profile';

        const updateUrl = options?.updateUrl || App.appURL + defaultBase + '/update';
        const changePasswordUrl = options?.changePasswordUrl || App.appURL + defaultBase + '/change-password';
        const updateProfilePictureUrl = options?.updateProfilePictureUrl || App.appURL + defaultBase + '/update-profile-picture';
        const deleteAccount = options?.updateProfilePictureUrl || App.appURL + defaultBase + '/delete-account';

        const $updateBtn = $('#updateProfile');
        const $profileForm = $('#profileForm');
        const $changePasswordForm = $('#changePasswordForm');
        const $updateProfilePictureTrigger = $('#updateProfilePictureTrigger');
        const $profilePictureInput = $('#profilePicture');
        const $deleteAccountBtn = $('button#confirmDeleteBtn');

        if ($updateBtn.length && $profileForm.length) {
            $updateBtn.off('click.profile').on('click.profile', function (e) {
                e.preventDefault();
                const button = $(this);
                button.prop('disabled', true);

                const formData = new FormData($profileForm[0]);
                formData.append('csrf_token', App.getToken());
                if (window.JsLoadingOverlay?.show) JsLoadingOverlay.show();

                $.ajax({
                    url: updateUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (window.JsLoadingOverlay?.hide) JsLoadingOverlay.hide();
                        showSuccessMessage(response.message);
                        if (response.token) App.setToken(response.token);
                        setTimeout(() => button.prop('disabled', false), 1500);
                    },
                    error: function (xhr) {
                        if (window.JsLoadingOverlay?.hide) JsLoadingOverlay.hide();
                        const json = xhr.responseJSON || {};
                        showErrorMessage(json.message || 'Có lỗi xảy ra');
                        if (json.token) App.setToken(json.token);
                        setTimeout(() => button.prop('disabled', false), 1500);
                    },
                });
            });
        }

        if ($changePasswordForm.length) {
            // Prevent form submission on Enter key
            $changePasswordForm.off('submit').on('submit', function (e) {
                e.preventDefault();
                return false;
            });

            $('#changePassword')
                .off('click')
                .on('click', function (e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Xác nhận',
                        text: 'Bạn có chắc chắn muốn đổi mật khẩu không?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Có',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const button = $(this);
                            button.prop('disabled', true);
                            const formData = new FormData($changePasswordForm[0]);
                            formData.append('csrf_token', App.getToken());
                            if (window.JsLoadingOverlay?.show) JsLoadingOverlay.show();

                            $.ajax({
                                url: changePasswordUrl,
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                dataType: 'json',
                                success: function (response) {
                                    if (window.JsLoadingOverlay?.hide) JsLoadingOverlay.hide();
                                    showSuccessMessage(response.message);
                                    if (response.token) App.setToken(response.token);
                                    $changePasswordForm[0].reset();
                                    setTimeout(() => button.prop('disabled', false), 1500);
                                },
                                error: function (xhr) {
                                    if (window.JsLoadingOverlay?.hide) JsLoadingOverlay.hide();
                                    const json = xhr.responseJSON || {};
                                    showErrorMessage(json.message || 'Có lỗi xảy ra');
                                    if (json.token) App.setToken(json.token);
                                    $changePasswordForm[0].reset();
                                    setTimeout(() => button.prop('disabled', false), 1500);
                                },
                            });
                        }
                    });
                });
        }

        if ($updateProfilePictureTrigger.length && $profilePictureInput.length) {
            $updateProfilePictureTrigger.off('click').on('click', function (e) {
                e.preventDefault();
                $profilePictureInput.trigger('click');
            });

            $profilePictureInput.off('change.profile').on('change.profile', function () {
                const file = this.files && this.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('profilePicture', file);
                formData.append('csrf_token', App.getToken());
                if (window.JsLoadingOverlay?.show) JsLoadingOverlay.show();

                $.ajax({
                    url: updateProfilePictureUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (window.JsLoadingOverlay?.hide) JsLoadingOverlay.hide();
                        showSuccessMessage(response.message || 'Cập nhật ảnh đại diện thành công');
                        if (response.token) App.setToken(response.token);
                        // Optional: reload to reflect new avatar
                        setTimeout(() => window.location.reload(), 2000);
                    },
                    error: function (xhr) {
                        if (window.JsLoadingOverlay?.hide) JsLoadingOverlay.hide();
                        const json = xhr.responseJSON || {};
                        showErrorMessage(json.message || 'Có lỗi xảy ra');
                        if (json.token) App.setToken(json.token);
                    },
                });
            });
        }

        // Delete Account
        if ($deleteAccountBtn.length) {
            $('button#confirmDeleteBtn')
                .off('click')
                .on('click', function (e) {
                    e.preventDefault();

                    $.ajax({
                        type: 'POST',
                        url: deleteAccount,
                        data: {
                            csrf_token: App.getToken(),
                        },
                        dataType: 'json',
                        success: function (response) {
                            App.setToken(response.token);

                            if (response.status == 'success') {
                                showSuccessMessage(response.msg);
                                $('button#cancelDeleteAccount').trigger('click');
                                setTimeout(() => {
                                    location.reload();
                                }, 3000);
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
        }
    };
});

// Load province and ward when on page
window.loadProvince = function (province) {
    return App.setProvinceData('#province', province);
};

window.loadWard = function (ward) {
    const code = $('#province').find(':selected').data('code');
    if (!code) return;
    App.setWardData(code, '#ward', ward);
};
