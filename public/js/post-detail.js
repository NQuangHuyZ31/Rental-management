$(document).ready(function () {
    const postId = $('input[name="post_id"]').val();
    // Add post interesting
    $('button#addPostInterest').click(function (e) {
        $.ajax({
            type: 'POST',
            url: App.appURL + 'addPostInterest',
            data: {
                postId,
                csrf_token: App.getToken,
            },
            dataType: 'json',
            success: (response) => {
                App.setToken(response.token);
                $('.allPostInterest').text(response.total_post_interest);
                showSuccessMessage(response.msg);
            },
            error: (xhr, status, error) => {
                App.setToken(xhr.responseJSON.token);

                if (xhr.status == 401) {
                    showErrorMessage('Vui lòng đăng nhập để thêm.');
                    return;
                }

                showErrorMessage(xhr.responseJSON.msg);
                return;
            },
        });
    });

    // Report violation
    $('button#sendReportViolation').click(function (e) {
        e.preventDefault();
        const targetType = $('select[name="target_type"]').val();
        const title = $('input[name="target_title"]').val();
        const violationType = $('select[name="violation_type"]').val();
        const description = $('textarea[name="description"]').val();

        if (targetType == '' || title == '' || violationType == '' || description == '') {
            showErrorMessage('Vui lòng nhập đẩy đủ thông tin');
            return;
        }

        const formData = new FormData($('form#reportForm')[0]);
        formData.append('postId', postId);
        formData.append('csrf_token', App.getToken());

        $.ajax({
            url: App.appURL + 'sendReportViolation',
            type: 'POST',
            data: formData, // Gửi trực tiếp FormData
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    showSuccessMessage(response.msg);
                    // Reset form nếu cần
                    $('button#cancel').trigger('click');
                    $('form#reportForm')[0].reset();
                    App.setToken(response.token);
                }
            },
            error: function (xhr, status, error) {
                showErrorMessage(xhr.responseJSON.msg);
                App.setToken(xhr.responseJSON.token);
                return;
            },
        });
    });
});
