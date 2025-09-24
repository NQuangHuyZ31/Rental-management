<?php

use Core\CSRF;
?>
<!--
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Forgot password page
-->
<?php
$flashData = $request->getFlashData();
$errors = $flashData['errors'] ?? [];
$success = $flashData['success'] ?? '';
if ($errors) {
	$status = 'error';
}
if ($success) {
	$status = 'success';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=BASE_URL?>/Public/images/favicon.ico">
    <title>Quên mật khẩu - HOSTY</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />

    <style>
        body {
            background-color: #f7fafc;
            background: url('<?=BASE_URL?>/Public/images/admin/login-background.jpg') no-repeat;
            background-size: contain;
            background-position-y: 60%;
            min-height: 100vh;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-lock text-green-600 text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Quên mật khẩu</h1>
            <p class="text-gray-600">Nhập email của bạn để nhận link đặt lại mật khẩu</p>
        </div>

        <!-- Forgot Password Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form id="forgotPasswordForm">
                <!-- CSRF Token -->
                <?= CSRF::getTokenField() ?>
                
                <!-- Email Input -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2"></i>Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           required
                           placeholder="Nhập email của bạn"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors">
                </div>

                <!-- Submit Button -->
                <button type="button" 
                        id="sendLinkResetPassword"
                        class="w-full bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-105 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Gửi link đặt lại mật khẩu
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="<?=BASE_URL?>/login" class="text-green-600 hover:text-green-800 text-sm font-medium">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Quay lại đăng nhập
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-gray-500 text-sm">
                &copy; 2025 HOSTY
            </p>
        </div>
    </div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js" ></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="<?=BASE_URL?>/Public/js/app.js"></script>
    <script src="<?=BASE_URL?>/Public/js/auth.js"></script>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			let error = "<?= $error ?>" ?? '';
			let success = "<?= $success ?>" ?? '';
			let status = "<?= $status ?>" ?? '';
			if (status === 'error') {
				showErrorMessage(error);
				error = '';
			}
			if (status === 'success') {
				showSuccessMessage(success);
				success = '';
			}
		});
	</script>
</body>
</html>
