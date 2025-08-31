<!-- 
Author: Nguyen Xuan Duong
Date: 2025-08-28
Purpose: Build Verify OTP Page 
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
    <title>Xác thực OTP - LOZIDO</title>
    
    <!-- Tailwind CSS -->
     <!-- Modify by Huy Nguyen on 2025-08-31 to use tailwindcss from package.json-->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/Public/css/output.css">  
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f7fafc;
            background: url('../../Public/images/admin/login-background.jpg') no-repeat;
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
                <img src="../../Public/images/admin/Icon-lozido-white.jpg" alt="LOZIDO Logo" class="w-20 h-20 mx-auto">
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
                <span class="text-gray-800 font-medium ml-1" id="userEmail">user@example.com</span>
            </div>
            
            <!-- OTP Input Form -->
            <form id="otpForm" class="space-y-4">
                <!-- OTP Input Fields -->
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
                <div id="errorMessage" class="hidden bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm text-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span id="errorText">Mã OTP không đúng. Vui lòng thử lại.</span>
                </div>
                
                <!-- Success Message -->
                <div id="successMessage" class="hidden bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg text-sm text-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>Xác thực thành công! Đang chuyển hướng...</span>
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
                <a href="register.php" class="text-gray-600 hover:text-gray-800 text-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay lại đăng ký
                </a>
            </div>
        </div>
    </div>
    
    <!-- JavaScript for OTP functionality -->
    <script>
        // OTP Input handling
        const otpInputs = document.querySelectorAll('[data-otp]');
        const completeOtpInput = document.getElementById('completeOtp');
        const errorMessage = document.getElementById('errorMessage');
        const successMessage = document.getElementById('successMessage');
        const errorText = document.getElementById('errorText');
        const verifyBtn = document.getElementById('verifyBtn');
        const resendBtn = document.getElementById('resendOtp');
        const countdownSpan = document.getElementById('countdown');
        const userEmail = document.getElementById('userEmail');
        
        let countdown = 60;
        let countdownTimer;
        let isVerifying = false;
        
        // Get email from URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const email = urlParams.get('email');
        if (email) {
            userEmail.textContent = email;
        }
        
        // Auto-focus next input when typing
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                // Only allow numbers
                this.value = this.value.replace(/[^0-9]/g, '');
                
                if (this.value.length === 1) {
                    if (index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                }
                updateCompleteOtp();
                hideMessages();
            });
            
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
            
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
                if (pastedData.length === 6) {
                    otpInputs.forEach((input, i) => {
                        input.value = pastedData[i] || '';
                    });
                    updateCompleteOtp();
                    hideMessages();
                }
            });
        });
        
        // Update complete OTP value
        function updateCompleteOtp() {
            const otpValue = Array.from(otpInputs).map(input => input.value).join('');
            completeOtpInput.value = otpValue;
        }
        
        // Hide error and success messages
        function hideMessages() {
            errorMessage.classList.add('hidden');
            successMessage.classList.add('hidden');
        }
        
        // Show error message
        function showError(message) {
            errorText.textContent = message;
            errorMessage.classList.remove('hidden');
            successMessage.classList.add('hidden');
        }
        
        // Show success message
        function showSuccess() {
            successMessage.classList.remove('hidden');
            errorMessage.classList.add('hidden');
        }
        
        // Handle OTP form submission
        document.getElementById('otpForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (isVerifying) return;
            
            const otpValue = completeOtpInput.value;
            if (otpValue.length !== 6) {
                showError('Vui lòng nhập đầy đủ 6 chữ số OTP');
                return;
            }
            
            // Start verification
            isVerifying = true;
            verifyBtn.disabled = true;
            verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3 text-lg"></i>Đang xác thực...';
            
            // Simulate API call
            setTimeout(() => {
                // For demo purposes, accept any 6-digit code
                if (otpValue === '123456') {
                    showSuccess();
                    // Redirect after 2 seconds
                    setTimeout(() => {
                        window.location.href = '../host/index.php';
                    }, 2000);
                } else {
                    showError('Mã OTP không đúng. Vui lòng thử lại.');
                    // Clear inputs
                    otpInputs.forEach(input => input.value = '');
                    otpInputs[0].focus();
                }
                
                isVerifying = false;
                verifyBtn.disabled = false;
                verifyBtn.innerHTML = '<i class="fas fa-check mr-3 text-lg"></i>Xác thực';
            }, 1500);
        });
        
        // Resend OTP functionality
        resendBtn.addEventListener('click', function() {
            if (countdown <= 0 && !isVerifying) {
                startCountdown();
                // Here you would typically trigger resend OTP API call
                console.log('Resending OTP to:', email);
                
                // Show temporary message
                const originalText = resendBtn.textContent;
                resendBtn.textContent = 'Đang gửi...';
                resendBtn.disabled = true;
                
                setTimeout(() => {
                    resendBtn.textContent = originalText;
                    resendBtn.disabled = false;
                }, 2000);
            }
        });
        
        // Countdown timer
        function startCountdown() {
            countdown = 60;
            resendBtn.disabled = true;
            resendBtn.classList.add('text-gray-400', 'cursor-not-allowed');
            
            countdownTimer = setInterval(() => {
                countdown--;
                countdownSpan.textContent = countdown;
                
                if (countdown <= 0) {
                    clearInterval(countdownTimer);
                    resendBtn.disabled = false;
                    resendBtn.classList.remove('text-gray-400', 'cursor-not-allowed');
                    countdownSpan.textContent = '0';
                }
            }, 1000);
        }
        
        // Start countdown on page load
        startCountdown();
        
        // Focus first input on page load
        otpInputs[0].focus();
    </script>
</body>
</html>
