<!-- Author: Nguyen Xuan Duong
Date: 2025-08-27
Purpose: Build Login Page -->

<?php
use Core\CSRF;
use Core\Session;
use Helpers\Log;
// Session::destroy();
Log::write(json_encode(['redirect' => Session::get('current_url'), 'message' => 'success']), Log::LEVEL_ERROR);
if (Session::has('user')) {
    header('location: ' . Session::get('current_url'));
    exit();
}

$flashData = $request->getFlashData();
$errors = $flashData['errors'] ?? [];
$old = $flashData['old'] ?? [];
$message = $flashData['success'] ?? '';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=BASE_URL?>/Public/images/favicon.ico">
    <title>Đăng nhập - HOSTY</title>

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

<body class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-2xl px-6">
        <!-- Logo and Title Section -->
        <div class="text-center mb-8">
            <!-- Logo -->
            <div class="mb-4">
                <img src=" <?=BASE_URL?>/Public/images/admin/hosty-removebg.jpg" onclick="window.location(<?= BASE_URL ?>)/"alt="HOSTY Logo" class="w-18 h-20 mx-auto">
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

            <!-- Added by Huy Nguyen on 2025-08-31 to select role -->
            <!-- Role Selection -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-3">
                    Vai trò của bạn <span class="text-red-500">*</span>
                </label>
                <div class="flex space-x-3">
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="role" value="landlord" class="sr-only peer" <?=$old['selected_role'] == 'landlord' || $_GET['type'] == 'landlord' ? 'checked' : ''?>>
                        <div class="p-2 text-center rounded-lg border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-500 peer-checked:text-white transition-all duration-200 hover:border-gray-300">
                            <i class="fas fa-home text-lg mb-1"></i>
                            <span class="text-sm font-medium">Tôi là Chủ nhà</span>
                        </div>
                    </label>

                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="role" value="customer" class="sr-only peer" <?=!isset($_GET['type']) || $old['selected_role'] == 'customer' || $_GET['type'] == 'customer' ? 'checked' : ''?>>
                        <div class="p-2 text-center rounded-lg border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-500 peer-checked:text-white transition-all duration-200 hover:border-gray-300">
                            <i class="fas fa-search text-lg mb-1"></i>
                            <span class="text-sm font-medium">Tôi tìm nhà</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Login Form -->
            <form action="<?=BASE_URL?>/login" method="POST">
                <input type="hidden" name="selected_role" id="selectedRole" value="<?=$old['selected_role'] ?? 'customer'?>">
                <?=CSRF::getTokenField()?>
                <!-- Email Field -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?=$old['email']?>"
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
                <?php if (!empty($errors)): ?>
                    <div class="mb-4 text-center">
                        <div class="text-red-500 text-sm">
                            <?=$errors?>
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
            <!-- Additional Links -->
            <div class="mt-6 text-center">
                <a href="<?=BASE_URL?>/forgot-password" class="text-green-600 hover:text-green-800 text-sm">
                    Quên mật khẩu?
                </a>
                <span class="mx-2 text-gray-400">|</span>
                <a href="<?=BASE_URL?>/register" class="text-green-600 hover:text-green-800 text-sm">
                    Đăng ký tài khoản
                </a>
            </div>
        </div>
    </div>

    <!-- Library js -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js" ></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- JavaScript for Role Selection -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleInputs = document.querySelectorAll('input[name="role"]');
            const selectedRoleInput = document.getElementById('selectedRole');

            roleInputs.forEach(input => {
                input.addEventListener('change', function() {
                    selectedRoleInput.value = this.value;

                    // Remove active class from all role containers
                    document.querySelectorAll('input[name="role"]').forEach(radio => {
                        radio.nextElementSibling.classList.remove('border-blue-500', 'bg-blue-500', 'text-white');
                        radio.nextElementSibling.classList.add('border-gray-200', 'text-gray-700');
                    });

                    // Add active class to selected role container
                    if (this.checked) {
                        this.nextElementSibling.classList.remove('border-gray-200', 'text-gray-700');
                        this.nextElementSibling.classList.add('border-blue-500', 'bg-blue-500', 'text-white');
                    }
                });
            });

            // Set initial active state for default selected role
            const defaultRole = document.querySelector('input[name="role"]:checked');
            if (defaultRole) {
                defaultRole.nextElementSibling.classList.remove('border-gray-200', 'text-gray-700');
                defaultRole.nextElementSibling.classList.add('border-blue-500', 'bg-blue-500', 'text-white');
            }
        });
    </script>

    <!-- Config Toastr -->
     <script>
        const message = "<?=$message?>" ?? '';
        console.log(message);
        if (message) {
            toastr.success(message);
        }
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
            }
     </script>
</body>

</html>