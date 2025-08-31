<!-- 
Author: Nguyen Xuan Duong
Date: 2025-08-28
Purpose: Build Register Page 
-->

<?php
//require_once '../../Config/config.php';

use Core\CSRF;
use Core\Session;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - LOZIDO</title>
    <link rel="icon" href="<?= BASE_URL ?>/Public/images/favicon.ico">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
     <!-- Modify by Huy Nguyen on 2025-08-31 to use tailwindcss from package.json--> 
    
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
            <form action="#" method="POST">
                <!-- Username and Email Row -->
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
                        >
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
                        >
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
                        >
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="">Chọn vai trò</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
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
                            placeholder="Nhập mật khẩu của bạn"
                        >
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
                            placeholder="Nhập lại mật khẩu"
                        >
                    </div>
                </div>
                
                <!-- Register Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-2 px-8 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-102 flex items-center justify-center"
                >
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
    
    <!-- JavaScript for form handling -->
    <script>
        // Handle register form submission
        const registerForm = document.querySelector('form');
        
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(registerForm);
            const email = formData.get('email');
            
            // Here you would typically send the registration data to your backend
            console.log('Submitting registration form...');
            
            // Redirect to OTP verification page with email parameter
            window.location.href = `verify-otp.php?email=${encodeURIComponent(email)}`;
        });
    </script>
</body>
</html>
