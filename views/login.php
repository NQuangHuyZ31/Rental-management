<?php

use Core\CSRF;

$csrf = CSRF::generateToken();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - LOZIDO</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
    <div class="w-full max-w-2xl px-6">
        <!-- Logo and Title Section -->
        <div class="text-center mb-8">
            <!-- Logo -->
            <div class="mb-4">
                <img src=" <?= BASE_URL ?>/Public/images/admin/Icon-lozido-white.jpg" alt="LOZIDO Logo" class="w-20 h-20 mx-auto">
            </div>
            <!-- Title Text -->
            <h1 class="text-[#3C9E46] text-4xl font-bold text-center leading-tight whitespace-nowrap">
                Quản lý nhà trọ chuyên nghiệp!
            </h1>
        </div>

        <!-- Login Form Box -->
        <div class="bg-white rounded-lg shadow-2xl p-8 max-w-md mx-auto">
            <!-- Form Title -->
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">
                Đăng nhập tài khoản
            </h2>

            <!-- Login Form -->
            <form action="#" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                <!-- Email Field -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Nhập email của bạn">
                </div>

                <!-- Password Field -->
                <div class="mb-8">
                    <label for="password" class="block text-gray-700 text-sm font-medium mb-2">
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

                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-105 flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-3 text-lg"></i>
                    Đăng nhập
                </button>
            </form>

            <!-- Additional Links -->
            <div class="mt-6 text-center">
                <a href="#" class="text-green-600 hover:text-green-800 text-sm">
                    Quên mật khẩu?
                </a>
                <span class="mx-2 text-gray-400">|</span>
                <a href="register.php" class="text-green-600 hover:text-green-800 text-sm">
                    Đăng ký tài khoản
                </a>
            </div>
        </div>
    </div>
</body>

</html>