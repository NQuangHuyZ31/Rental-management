<!-- 
Author: Nguyen Xuan Duong
Date: 2025-08-28
Purpose: Build Register Page 
-->

<?php
//require_once '../../Config/config.php';

use Core\CSRF;
use Core\Session;

$flashData = $request->getFlashData();
$errors = $flashData['errors'] ?? [];
$old = $flashData['old'] ?? [];

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - HOSTY</title>
    <link rel="icon" href="<?= BASE_URL ?>/Public/images/favicon.ico">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f7fafc;
            background: url('<?= BASE_URL ?>/Public/images/admin/login-background.jpg') no-repeat;
            background-size: contain;
            background-position-y: 60%;
            min-height: 100vh;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-4xl px-6">
        <!-- Logo and Title Section -->
        <div class="text-center mb-8">
            <!-- Logo -->
            <div class="mb-4">
                <img src="<?= BASE_URL ?>/Public/images/admin/hosty-removebg.jpg" alt="HOSTY Logo" class="w-18 h-20 mx-auto">
            </div>
            <!-- Title Text -->
            <h1 class="text-[#3C9E46] text-4xl font-bold text-center leading-tight whitespace-nowrap">
                Quản lý nhà trọ chuyên nghiệp!
            </h1>
        </div>

        <!-- Register Form Box -->
        <div class="bg-white rounded-lg shadow-2xl p-6 max-w-2xl mx-auto">
            <!-- Form Title -->
            <h2 class="text-xl font-bold text-gray-800 text-center mb-4">
                Đăng ký tài khoản
            </h2>

            <!-- Register Form -->
            <form action="<?= BASE_URL ?>/register" method="POST">
                <!-- Username and Email Row -->
                <?= CSRF::getTokenField() ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-gray-700 text-sm font-medium mb-1">
                            Tên người dùng <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Nhập tên người dùng"
                            value="<?= $old['username'] ?? '' ?>">
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Nhập email của bạn"
                            value="<?= $old['email'] ?? '' ?>">
                    </div>
                </div>

                <!-- Phone Number and Role Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Phone Number Field -->
                    <div>
                        <label for="phone" class="block text-gray-700 text-sm font-medium mb-1">
                            Số điện thoại <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Nhập số điện thoại của bạn"
                            value="<?= $old['phone'] ?? '' ?>">
                    </div>

                    <!-- Role Selection Field -->
                    <div>
                        <label for="role" class="block text-gray-700 text-sm font-medium mb-1">
                            Vai trò <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="role"
                            name="role"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>" <?php if ($old['role'] == $role['id']) echo 'selected'; ?>><?= $role['vn_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Password and Confirm Password Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-1">
                            Mật khẩu <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Nhập mật khẩu của bạn">
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="confirm_password" class="block text-gray-700 text-sm font-medium mb-1">
                            Xác nhận mật khẩu <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Nhập lại mật khẩu">
                    </div>
                </div>
                <!-- Added by Huy Nguyen on 2025-08-31 to show errors -->
                <?php if (!empty($errors)): ?>
                    <div class="mb-4 text-center">
                        <div class="text-red-500 text-sm"><?= $errors ?></div>
                    </div>
                <?php endif; ?>
                <!-- Register Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-2 px-8 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-102 flex items-center justify-center">
                    <i class="fas fa-user-plus mr-3 text-lg"></i>
                    Đăng ký
                </button>
            </form>

            <!-- Additional Links -->
            <div class="mt-6 text-center">
                <span class="text-gray-600 text-sm">
                    Đã có tài khoản?
                </span>
                <a href="<?= BASE_URL ?>/login" class="text-green-600 hover:text-green-800 text-sm font-medium ml-1">
                    Đăng nhập ngay
                </a>
            </div>
        </div>
    </div>

    <!-- Library js -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="<?= BASE_URL ?>/Public/js/app.js"></script>

    <!-- Config Toastr -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const message = "<?= $error ?>" ?? '';
            if (message) {
                showErrorMessage(message); // lúc này hàm đã có
            }
        });
    </script>
</body>

</html>