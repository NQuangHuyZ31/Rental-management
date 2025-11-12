$(document).ready(function () {
    const role = App.getRole();
    const btnApprovePostOnPage = $('button.approved-all-post-on-page');
    const btnApproveAllPost = $('button.approved-all-post');
    var btnApprove = $('button.pending-post');

    btnApprove.on('click', function (e) {
        e.preventDefault();
        const postIds = btnApprove.closest('tr').data('post-id');

        App.showModalConfirm('Bạn có chắc chắn muốn duyệt bài đăng này không?').then((result) => {
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
