<!-- 
Author: Nguyen Xuan Duong
Date: 2025-08-28
Purpose: Build Verify OTP Page 
-->


<?php
//require_once '../../Config/config.php';

use Core\CSRF;
use Core\Session;

// Added by Huy Nguyen on 01/09/2025 to non allow direct access
if (!Session::has('verify')) {
    $request->redirect('/');
    exit;
}

$flashData = $request->getFlashData();
$errors = $flashData['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= BASE_URL ?>/Public/images/favicon.ico">
    <title>Xác thực OTP - HOSTY</title>
    
    <!-- Tailwind CSS -->
     <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Toastr -->
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
                <img src="<?= BASE_URL ?>/Public/images/admin/Icon-lozido-white.jpg" alt="LOZIDO Logo" class="w-20 h-20 mx-auto">
            </div>
            <!-- Title Text -->
            <h1 class="text-[#3C9E46] text-4xl font-bold text-center leading-tight whitespace-nowrap">
                Quản lý nhà trọ chuyên nghiệp!
            </h1>
        </div>
        
        <!-- OTP Verification Box -->
        <div class="bg-white rounded-lg shadow-2xl p-6 max-w-md mx-auto">
            <!-- Form Title -->
            <div class="text-center mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-envelope text-green-600 text-xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-1">
                    Xác thực email
                </h2>
                <p class="text-gray-600 text-sm">
                    Chúng tôi đã gửi mã xác thực đến email của bạn
                </p>
            </div>
            
            <!-- Email Display -->
            <div class="bg-gray-50 rounded-lg p-3 mb-4 text-center">
                <span class="text-gray-600 text-sm">Email:</span>
                <span class="text-gray-800 font-medium ml-1" id="userEmail"><?= $email ?></span>
            </div>
            
            <!-- OTP Input Form -->
            <form id="otpForm" class="space-y-4" action="<?= BASE_URL ?>/verify-account" method="post">
                <!-- OTP Input Fields -->
                 <!-- Added by Huy Nguyen on 01/09/2025 to add hidden input for complete OTP -->
                  <?php echo CSRF::getTokenField(); ?>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2 text-center">
                        Nhập mã xác thực 6 chữ số
                    </label>
                    <div class="flex justify-center space-x-2">
                        <input type="text" maxlength="1" class="w-10 h-10 text-center text-lg font-bold border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none transition-colors" data-otp="1">
                        <input type="text" maxlength="1" class="w-10 h-10 text-center text-lg font-bold border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none transition-colors" data-otp="2">
                        <input type="text" maxlength="1" class="w-10 h-10 text-center text-lg font-bold border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none transition-colors" data-otp="3">
                        <input type="text" maxlength="1" class="w-10 h-10 text-center text-lg font-bold border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none transition-colors" data-otp="4">
                        <input type="text" maxlength="1" class="w-10 h-10 text-center text-lg font-bold border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none transition-colors" data-otp="5">
                        <input type="text" maxlength="1" class="w-10 h-10 text-center text-lg font-bold border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none transition-colors" data-otp="6">
                    </div>
                </div>
                
                <!-- Hidden input for complete OTP -->
                <input type="hidden" name="otp" id="completeOtp">
                
                <!-- Error Message -->
                <div id="errorMessage" class="<?php echo $errors ? 'block' : 'hidden'; ?> bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm text-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span id="errorText"><?php echo $errors; ?></span>
                </div>

                <!-- Verify Button -->
                <button 
                    type="submit" 
                    id="verifyBtn"
                    class="w-full bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-2 px-8 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-102 flex items-center justify-center"
                >
                    <i class="fas fa-check mr-3 text-lg"></i>
                    Xác thực
                </button>
                
                <!-- Resend OTP -->
                <div class="text-center">
                    <span class="text-gray-600 text-sm">Không nhận được mã?</span>
                    <button type="button" id="resendOtp" class="text-green-600 hover:text-green-800 text-sm font-medium ml-1">
                        Gửi lại mã
                    </button>
                    <span class="text-gray-500 text-xs ml-1">(<span id="countdown">60</span>s)</span>
                </div>
            </form>
            
            <!-- Back to Register -->
            <div class="mt-4 text-center">
                <a href="<?= BASE_URL ?>/register" class="text-gray-600 hover:text-gray-800 text-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay lại đăng ký
                </a>
            </div>
        </div>
    </div>
    <!-- Load JS -->
    <script src="<?= BASE_URL ?>/Public/js/jquery-3.7.1.min.js"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Loading Overlay -->
    <script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
    <script src="<?= BASE_URL ?>/Public/js/lazysizes.min.js"></script>
    <script src="<?= BASE_URL ?>/Public/js/lity.min.js"></script>
    <script src="<?= BASE_URL ?>/Public/js/app.js"></script>
    <script src="<?= BASE_URL ?>/Public/js/auth.js"></script>
    <!-- JavaScript for OTP functionality -->
    <script>
    </script>
</body>
</html>
