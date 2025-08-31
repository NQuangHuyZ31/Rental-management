<!-- Author: Nguyen Xuan Duong
Date: 2025-08-27
Purpose: Build Login Page -->

<?php
use Core\CSRF;
use Helpers\Log;

$flashData = $request->getFlashData();
$errors = $flashData['errors'] ??[];
$old = $flashData['old'] ??[];
Log::write(json_encode($old['selected_role']), Log::LEVEL_ERROR);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= BASE_URL ?>/Public/images/favicon.ico">
    <title>Đăng nhập Admin- HOSTY</title>

    <!-- Tailwind CSS -->
     <!-- Modify by Huy Nguyen on 2025-08-31 to use tailwindcss from package.json-->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/Public/css/output.css">  

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
                <img src=" <?= BASE_URL ?>/Public/images/admin/hosty-removebg.jpg" alt="HOSTY Logo" class="w-18 h-20 mx-auto">
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
                Đăng nhập tài khoản Admin
            </h2>

            <!-- Login Form -->
            <form action="<?= BASE_URL ?>/login" method="POST">
                <input type="hidden" name="selected_role" id="selectedRole" value="<?= $old['selected_role'] ?? 'customer' ?>">
                <?= CSRF::getTokenField() ?>
                <!-- Email Field -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= $old['email'] ?>"
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

                <!-- Added by Huy Nguyen on 2025-08-31 to show errors -->
                <?php if (!empty($errors)) : ?>
                    <div class="mb-4 text-center">
                        <div class="text-red-500 text-sm">
                            <?= $errors ?>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-105 flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-3 text-lg"></i>
                    Đăng nhập
                </button>
            </form>
        </div>
    </div>
</body>

</html>