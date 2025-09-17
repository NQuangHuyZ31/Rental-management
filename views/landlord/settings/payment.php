<!-- 
    Author: Huy Nguyen
    Date: 2025-01-15
    Purpose: Payment settings for landlord
-->
<?php

use Core\Session;

$flashData = Session::get('flash_data');
$errors = $flashData['errors'] ?? [];
?>
<div class="max-w-full mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Cài đặt thanh toán</h1>
        <p class="text-gray-600 mt-2">Cấu hình thông tin ngân hàng và API để nhận thanh toán với <span class="text-blue-600">Sepay</span></p>
    </div>

    <!-- Banking Information Form -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-university text-green-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Thông tin ngân hàng</h2>
                <p class="text-gray-600">Cấu hình tài khoản ngân hàng để nhận thanh toán</p>
            </div>
        </div>

        <form id="paymentForm" class="space-y-6" method="post" action="<?= BASE_URL ?>/landlord/setting/payment/update">
            <?= \Core\CSRF::getTokenField() ?>
            <input type="hidden" name="user_bank_id" value="<?= $userBanking['id'] ?? '' ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Bank Name -->
                <div>
                    <label for="bank_account_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Tên ngân hàng <span class="text-red-500">*</span>
                    </label>
                    <select id="bank_account_name" name="bank_account_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        <option data-bank-code="" value="">Chọn ngân hàng</option>
                        <option data-bank-code="VPB" value="VPBank" <?= isset($userBanking['bank_account_name']) && $userBanking['bank_account_name'] == 'VPBank' ? 'selected' : '' ?>>VPBank</option>
                        <option data-bank-code="TPB" value="TPBank" <?= isset($userBanking['bank_account_name']) && $userBanking['bank_account_name'] == 'TPBank' ? 'selected' : '' ?>>TPBank</option>
                        <option data-bank-code="VTB" value="VietinBank" <?= isset($userBanking['bank_account_name']) && $userBanking['bank_account_name'] == 'VietinBank' ? 'selected' : '' ?>>VietinBank</option>
                        <option data-bank-code="ACB" value="ACB" <?= isset($userBanking['bank_account_name']) && $userBanking['bank_account_name'] == 'ACB' ? 'selected' : '' ?>>ACB</option>
                        <option data-bank-code="BIDV" value="BIDV" <?= isset($userBanking['bank_account_name']) && $userBanking['bank_account_name'] == 'BIDV' ? 'selected' : '' ?>>BIDV</option>
                        <option data-bank-code="MB" value="MBBank" <?= isset($userBanking['bank_account_name']) && $userBanking['bank_account_name'] == 'MBBank' ? 'selected' : '' ?>>MBBank</option>
                        <option data-bank-code="OCB" value="OCB" <?= isset($userBanking['bank_account_name']) && $userBanking['bank_account_name'] == 'OCB' ? 'selected' : '' ?>>OCB</option>
                        <option data-bank-code="UMEE" value="KienLongBank" <?= isset($userBanking['bank_account_name']) && $userBanking['bank_account_name'] == 'KienLongBank' ? 'selected' : '' ?>>KienLongBank</option>
                        <option data-bank-code="MSB" value="MSB" <?= isset($userBanking['bank_account_name']) && $userBanking['bank_account_name'] == 'MSB' ? 'selected' : '' ?>>MSB</option>
                    </select>
                </div>

                <!-- Bank Code -->
                <div>
                    <label for="bank_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Mã ngân hàng <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="bank_code" name="bank_code" 
                           value="<?= $userBanking['bank_code'] ?? '' ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                           placeholder="VD: VCB, TPB, BID..." required readonly>
                </div>

                <!-- Account Number -->
                <div>
                    <label for="bank_account_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Số tài khoản <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="bank_account_number" name="bank_account_number" 
                           value="<?= $userBanking['bank_account_number'] ?? '' ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                           placeholder="Nhập số tài khoản" required>
                </div>

                <!-- Account Holder Name -->
                <div>
                    <label for="user_bank_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Tên chủ tài khoản <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="user_bank_name" name="user_bank_name" 
                           value="<?= $userBanking['user_bank_name'] ?? '' ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                           placeholder="Tên chủ tài khoản" required>
                </div>
            </div>

            <!-- API Key -->
            <div>
                <label for="api_key" class="block text-sm font-medium text-gray-700 mb-2">
                    API Key
                </label>
                <div class="relative">
                    <input type="password" id="api_key" name="api_key" 
                           value="<?= $userBanking['api_key'] ?? '' ?>"
                           class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                           placeholder="Nhập API key từ ngân hàng" <?= isset($userBanking['api_key']) && $userBanking['api_key'] != '' ? 'readonly' : '' ?>>
                    <button type="button" onclick="toggleApiKey()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                    </button>
                </div>
                <p class="text-sm text-gray-500 mt-1">API key để xác thực webhook từ ngân hàng</p>
            </div>
            <?php if (!empty($errors)): ?>
                <div class="text-red-500 text-sm text-center">
                    <?= $errors ?>
                </div>
            <?php endif; ?>
            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Lưu cài đặt
                </button>
            </div>
        </form>
    </div>

    <!-- Instructions -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Hướng dẫn cấu hình</h3>
                <ul class="text-sm text-blue-800 space-y-2">
                    <li class="flex items-start">
                        <span class="font-medium mr-2">1.</span>
                        <span>Đăng ký tài khoản <span class="text-blue-600"><a href="https://sepay.vn/" target="_blank">Sepay</a></span></span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-medium mr-2">2.</span>
                        <span>Liên kết tài khoản ngân hàng với Sepay</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-medium mr-2">3.</span>
                        <span>Cấu hình Webhook URL: <code class="bg-blue-100 px-2 py-1 rounded">https://hosty.shoplands.store/payment/callback</code></span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-medium mr-2">4.</span>
                        <span>Tạo API key và lấy API key từ Sepay thêm vào webhook</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-medium mr-2">5.</span>
                        <span>Điền đầy đủ thông tin ngân hàng và API key vào lưu lại</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-medium mr-2">6.</span>
                        <span>Xem hướng dẫn chi tiết cấu hình <span class="text-blue-600"><a href="<?= BASE_URL ?>/landlord/setting/payment/guide" target="_blank">Tại đây</a></span></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle API key visibility
function toggleApiKey() {
    const apiKeyInput = document.getElementById('api_key');
    const toggleIcon = document.querySelector('#api_key + button i');
    
    if (apiKeyInput.type === 'password') {
        apiKeyInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        apiKeyInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
