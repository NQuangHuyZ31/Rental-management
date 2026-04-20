/*
	Author: Huy Nguyen
	Date: 2025-10-21
	Purpose: handle logic post interest
*/

function deleteInterestPost(postId) {
    $.ajax({
        type: 'POST',
        url: App.appURL + 'customer/interests/delete',
        data: {
            postId,
            csrf_token: App.getToken(),
        },
        dataType: 'json',
        success: (response) => {
            App.setToken(response.token);

            if (response.status == 'success') {
                showSuccessMessage(response.msg);
                setTimeout(() => {
                    location.reload();
                }, 3000);
            }
        },
        error: (xhr, status, error) => {
            App.setToken(xhr.responseJSON.token);

            if (xhr.responseJSON.status == 'error') {
                showErrorMessage(xhr.responseJSON.msg);
                return;
            }
        },
    });
}
