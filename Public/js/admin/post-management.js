$(document).ready(function () {
    const role = App.getRole();
    const btnApprovePostOnPage = $('button.approved-all-post-on-page');
    const btnApproveAllPost = $('button.approved-all-post');
    var btnApprove = $('button.approval-post');
    var btnReject = $('button.rejection-post');
    var btnRestore = $('button.restore-post');
    var btnConfirmReject = $('#confirmRejectBtn');
    var btnReviewReject = $('button.review-reject-detail');

    // Approve single post
    btnApprove.on('click', function (e) {
        e.preventDefault();
        const postIds = btnApprove.closest('tr').data('post-id');

        App.showModalConfirm('Bạn có chắc chắn muốn duyệt bài đăng này không?').then((result) => {
            if (result.isConfirmed) {
                approvePost(postIds, 'single');
            }
        });
    });

    // Reject single post
    btnReject.on('click', function (e) {
        e.preventDefault();
        const postIds = $(this).closest('tr').data('post-id');
        $('#rejectPostModal').find('input[name="post_id"]').val(postIds);
        $('#rejectPostModal').find('select[name="violation_type"]').val('');
        $('#rejectPostModal').find('textarea[name="violation_content"]').val('');
        $('#rejectPostModal').find('button#confirmRejectBtn').show();
    });

    // Confirm reject post
    btnConfirmReject.on('click', function (e) {
        e.preventDefault();
        const formData = new FormData($('#rejectPostForm')[0]);
        formData.append('csrf_token', App.getToken());

        $.ajax({
            type: 'POST',
            url: App.appURL + role + '/posts/reject',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                App.setToken(response.token);
                if (response.status == 'success') {
                    showSuccessMessage(response.msg);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
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

    // View rejection details
    btnReviewReject.on('click', function (e) {
        e.preventDefault();
        const postIds = $(this).closest('tr').data('post-id');
        $.ajax({
            type: 'GET',
            url: App.appURL + role + '/posts/rejection-detail',
            data: { post_id: postIds },
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                    $('form#rejectPostForm')
                        .find('select[name="violation_type"]')
                        .find('option')
                        .filter(function () {
                            return $(this).val() === response.data.violation_type;
                        })
                        .prop('selected', true);

                    $('form#rejectPostForm').find('textarea[name="violation_content"]').val(response.data.violation_content);
                    $('form#rejectPostForm').find('button#confirmRejectBtn').hide();
                }
            },
            error: function (xhr, status, error) {
                if (xhr.responseJSON.status == 'error') {
                    showErrorMessage(xhr.responseJSON.msg);
                    return;
                }
            },
        });
    });

    // Restore single post
    btnRestore.on('click', function (e) {
        e.preventDefault();
        const postIds = $(this).closest('tr').data('post-id');
        App.showModalConfirm('Bạn có chắc chắn muốn duyệt lại bài đăng này không?').then((result) => {
            if (result.isConfirmed) {
                approvePost(postIds, 'single');
            }
        });
    });

    // Approve all selected posts on current page
    btnApprovePostOnPage.on('click', function (e) {
        e.preventDefault();
        const selectedPostIds = [];
        $('input.check-item-pending:checked').each(function () {
            const postId = $(this).closest('tr').data('post-id');
            selectedPostIds.push(postId);
        });

        if (selectedPostIds.length === 0) {
            showErrorMessage('Vui lòng chọn ít nhất một bài đăng để duyệt.');
            return;
        }

        App.showModalConfirm('Bạn có chắc chắn muốn duyệt các bài đăng đã chọn không?').then((result) => {
            if (result.isConfirmed) {
                approvePost(selectedPostIds, 'onpage');
            }
        });
    });

    // Approve all pending posts
    btnApproveAllPost.on('click', function (e) {
        e.preventDefault();
        App.showModalConfirm('Bạn có chắc chắn muốn duyệt tất cả bài đăng đang chờ không?').then((result) => {
            if (result.isConfirmed) {
                approvePost([], 'all');
            }
        });
    });

    // Approve posts function
    function approvePost(postIds, type) {
        $.ajax({
            type: 'POST',
            url: App.appURL + role + '/posts/approve',
            data: { posts_id: postIds, type: type, csrf_token: App.getToken() },
            dataType: 'json',
            success: function (response) {
                App.setToken(response.token);
                if (response.status == 'success') {
                    showSuccessMessage(response.msg);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
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
    }
});
