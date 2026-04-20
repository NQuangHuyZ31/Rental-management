<?php

use Core\CSRF;
?>
<!--
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Reset password page
-->

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=BASE_URL?>/Public/images/favicon.ico">
    <title>Đặt lại mật khẩu - HOSTY</title>

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
                <i class="fas fa-key text-green-600 text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Đặt lại mật khẩu</h1>
            <p class="text-gray-600">Nhập mật khẩu mới cho tài khoản của bạn</p>
        </div>

        <!-- Reset Password Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form id="resetPasswordForm">
                <!-- CSRF Token -->
                <?=CSRF::getTokenField()?>

                <!-- Hidden token field -->
                <input type="hidden" id="resetToken" name="token" value="<?=$token ?? ''?>">
                <input type="hidden" name="verify_account" value="<?=$_GET['verify_account'] ?? ''?>">

                <!-- New Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2"></i>Mật khẩu mới
                    </label>
                    <div class="relative">
                        <input type="password"
                            id="password"
                            name="password"
                            required
                            placeholder="Nhập mật khẩu mới"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors">
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="passwordIcon"></i>
                        </button>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        <p>Mật khẩu phải có ít nhất 8 ký tự</p>
                    </div>
                </div>

                <!-- Confirm Password Input -->
                <div class="mb-6">
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2"></i>Xác nhận mật khẩu mới
                    </label>
                    <div class="relative">
                        <input type="password"
                            id="confirm_password"
                            name="confirm_password"
                            required
                            placeholder="Nhập lại mật khẩu mới"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-colors">
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            onclick="togglePassword('confirm_password')">
                            <i class="fas fa-eye" id="confirm_passwordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                 <button type="button"
                     id="resetPasswordBtn"
                     class="w-full bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-105 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                     <i class="fas fa-save mr-2"></i>
                     <?= $_GET['verify_account'] != 1 ? 'Đặt lại mật khẩu' : 'Kích hoạt tài khoản' ?>
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

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="<?=BASE_URL?>/Public/js/app.js"></script>
    <script src="<?=BASE_URL?>/Public/js/auth.js"></script>

    <script>
        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + 'Icon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>