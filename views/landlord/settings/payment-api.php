<!--
    Author: Huy Nguyen
    Date: 2025-09-17
    Purpose: Payment API for landlord
-->
<?php

use Core\Session;

$flashData = Session::get('flash_data');
$errors = $flashData['errors'] ?? [];
?>
<div class="max-w-full mx-auto">
	<!-- Header -->
	<div class="mb-8">
		<h1 class="text-3xl font-bold text-gray-900">Thay đổi API Key</h1>
		<p class="text-gray-600 mt-2">Quản lý API Key để tích hợp với Sepay và các dịch vụ thanh toán</p>
	</div>

	<!-- Current API Key Status -->
	<div class="bg-white rounded-lg shadow-md p-6 mb-8">
		<div class="flex items-center justify-between mb-4">
			<div class="flex items-center">
				<div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
					<i class="fas fa-key text-blue-600 text-xl"></i>
				</div>
				<div>
					<h2 class="text-xl font-semibold text-gray-900">Trạng thái API Key hiện tại</h2>
					<p class="text-gray-600">Kiểm tra và quản lý API Key của bạn</p>
				</div>
			</div>
			<div class="flex items-center space-x-2">
				<?php if (!empty($userBanking['api_key'])): ?>
					<span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
						<i class="fas fa-check mr-1"></i>Đã cấu hình
					</span>
				<?php else: ?>
					<span class="px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">
						<i class="fas fa-times mr-1"></i>Chưa cấu hình
					</span>
				<?php endif; ?>
			</div>
		</div>

		<div class="bg-gray-50 rounded-lg p-4">
			<div class="flex items-center justify-between">
				<div>
					<h3 class="font-semibold text-gray-900 mb-1">API Key hiện tại:</h3>
					<div class="flex items-center space-x-2">
						<?php if (!empty($userBanking['api_key'])): ?>
							<code class="text-sm bg-white px-3 py-2 rounded border font-mono" id="currentApiKey">
								<?= str_repeat('*', strlen($userBanking['api_key']) - 8) . substr($userBanking['api_key'], -8) ?>
							</code>
							<button onclick="toggleApiKeyVisibility()" class="text-gray-500 hover:text-gray-700">
								<i class="fas fa-eye" id="toggleIcon"></i>
							</button>
						<?php else: ?>
							<span class="text-gray-500 italic">Chưa có API Key</span>
						<?php endif; ?>
					</div>
				</div>
				<div class="text-sm text-gray-500">
					<p>Cập nhật lần cuối: <?= !empty($userBanking['updated_at']) ? date('d/m/Y H:i', strtotime($userBanking['updated_at'])) : 'Chưa có' ?></p>
				</div>
			</div>
		</div>
		<?php if (empty($userBanking['api_key'])): ?>
			<a href="<?= BASE_URL ?>/landlord/setting/payment" class="px-4 py-2 mt-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
				<i class="fas fa-plus mr-2"></i>
				Thêm thông tin cấu hình thanh toán
			</a>
		<?php endif; ?>
	</div>

	<!-- Change API Key Form -->
	<?php if (!empty($userBanking['api_key'])): ?>
		<div class="bg-white rounded-lg shadow-md p-6 mb-8">
			<div class="flex items-center mb-6">
				<div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
					<i class="fas fa-edit text-green-600 text-xl"></i>
				</div>
				<div>
					<h2 class="text-xl font-semibold text-gray-900">Thay đổi API Key</h2>
					<p class="text-gray-600">Nhập API Key mới từ Sepay hoặc dịch vụ thanh toán</p>
				</div>
			</div>

			<form action="<?= BASE_URL ?>/landlord/setting/payment/update-api-key" method="POST" id="apiKeyForm">
				<?= \Core\CSRF::getTokenField() ?>
				<input type="hidden" name="user_bank_id" value="<?= $userBanking['id'] ?? '' ?>">
				<div class="space-y-6">
					<!-- API Key Input -->
					<div>
						<label for="api_key" class="block text-sm font-medium text-gray-700 mb-2">
							API Key mới <span class="text-red-500">*</span>
						</label>
						<div class="relative">
							<input type="password"
								id="api_key"
								name="api_key"
								required
								placeholder="Nhập API Key mới từ Sepay"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pr-12">
							<button type="button"
								onclick="togglePasswordVisibility('api_key')"
								class="absolute right-3 top-3/4 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
								<i class="fas fa-eye" id="api_key_toggle"></i>
							</button>
						</div>
						<p class="text-sm text-gray-500 mt-1">
							<i class="fas fa-info-circle mr-1"></i>
							API Key được cung cấp bởi Sepay sau khi đăng ký tài khoản
						</p>
					</div>

					<!-- Confirm API Key -->
					<div>
						<label for="confirm_api_key" class="block text-sm font-medium text-gray-700 mb-2">
							Xác nhận API Key <span class="text-red-500">*</span>
						</label>
						<div class="relative">
							<input type="password"
								id="confirm_api_key"
								name="confirm_api_key"
								required
								placeholder="Nhập lại API Key để xác nhận"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pr-12">
							<button type="button"
								onclick="togglePasswordVisibility('confirm_api_key')"
								class="absolute right-3 top-3/4 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
								<i class="fas fa-eye" id="confirm_api_key_toggle"></i>
							</button>
						</div>
					</div>
					<?php if (!empty($errors)): ?>
						<div class="text-red-500 text-sm text-center">
							<?= $errors ?>
						</div>
					<?php endif; ?>
					<!-- Warning Message -->
					<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
						<div class="flex items-start">
							<i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
							<div>
								<h3 class="font-semibold text-yellow-800 mb-1">Lưu ý quan trọng:</h3>
								<ul class="text-sm text-yellow-700 space-y-1">
									<li>• Thay đổi API Key sẽ ảnh hưởng đến tất cả giao dịch thanh toán</li>
									<li>• Đảm bảo API Key mới đã được kích hoạt trên Sepay</li>
									<li>• Thông báo cho khách hàng về thời gian bảo trì nếu có</li>
								</ul>
							</div>
						</div>
					</div>

					<!-- Action Buttons -->
					<div class="flex items-center justify-end pt-4 border-t border-gray-200">
						<div class="flex items-center space-x-3">
							<button type="button" id="saveChangeApiKey"
								class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
								<i class="fas fa-save mr-2"></i>
								Lưu thay đổi
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	<?php endif; ?>
</div>

<script>
	// Toggle password visibility
	function togglePasswordVisibility(inputId) {
		const input = document.getElementById(inputId);
		const toggle = document.getElementById(inputId + '_toggle');

		if (input.type === 'password') {
			input.type = 'text';
			toggle.className = 'fas fa-eye-slash';
		} else {
			input.type = 'password';
			toggle.className = 'fas fa-eye';
		}
	}

	// Toggle current API key visibility
	function toggleApiKeyVisibility() {
		const apiKeyElement = document.getElementById('currentApiKey');
		const toggleIcon = document.getElementById('toggleIcon');

		if (apiKeyElement.textContent.includes('*')) {
			apiKeyElement.textContent = '<?= !empty($userBanking['api_key']) ? $userBanking['api_key'] : '' ?>';
			toggleIcon.className = 'fas fa-eye-slash';
		} else {
			apiKeyElement.textContent = '<?= !empty($userBanking['api_key']) ? str_repeat('*', strlen($userBanking['api_key']) - 8) . substr($userBanking['api_key'], -8) : '' ?>';
			toggleIcon.className = 'fas fa-eye';
		}
	}
</script>