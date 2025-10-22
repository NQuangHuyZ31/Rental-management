<?php

use Core\CSRF;
use Helpers\Format;

?>
<!--
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Customer profile management page
-->

<!-- Profile Header -->
<div class="mb-8">
	<h1 class="text-3xl font-bold text-gray-900 mb-2">Thông tin cá nhân</h1>
	<p class="text-gray-600">Quản lý thông tin tài khoản và cài đặt cá nhân</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
	<!-- Left Column - Profile Info -->
	<div class="lg:col-span-2">
		<!-- Personal Information -->
		<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
			<div class="p-6 border-b border-gray-200">
				<h2 class="text-xl font-bold text-gray-900">Thông tin cơ bản</h2>
				<p class="text-gray-600 text-sm mt-1">Cập nhật thông tin cá nhân của bạn</p>
			</div>
			<div class="p-6">
				<form id="profileForm" class="space-y-6">
					<?= CSRF::getTokenField() ?>
					<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
						<!-- Full Name -->
						<div>
							<label for="username" class="block text-sm font-medium text-gray-700 mb-2">Họ và tên</label>
							<input type="text" id="username" name="username" value="<?= $user['username'] ?>"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
						</div>

						<!-- Phone -->
						<div>
							<label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
							<input type="tel" id="phone" name="phone" value="<?= $user['phone'] ?>"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
						</div>

						<!-- Date of Birth -->
						<div>
							<label for="birthday" class="block text-sm font-medium text-gray-700 mb-2">Ngày sinh</label>
							<input type="date" id="birthday" name="birthday" value="<?= $user['birthday'] ?>"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
						</div>

						<!-- Gender -->
						<div>
							<label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Giới tính</label>
							<select id="gender" name="gender"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
								<option value="male" <?= $user['gender'] == 'male' ? 'selected' : '' ?>>Nam</option>
								<option value="female" <?= $user['gender'] == 'female' ? 'selected' : '' ?>>Nữ</option>
							</select>
						</div>

						<!-- Occupation -->
						<div>
							<label for="job" class="block text-sm font-medium text-gray-700 mb-2">Nghề nghiệp</label>
							<input type="text" id="job" name="job" value="<?= $user['job'] ?>"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
						</div>
					</div>

					<!-- Address Section -->
					<div class="space-y-4">
						<h3 class="text-lg font-semibold text-gray-900">Địa chỉ hiện tại</h3>

						<!-- Province/City -->
						<div>
							<label for="province" class="block text-sm font-medium text-gray-700 mb-2">Tỉnh/Thành phố</label>
							<select id="province" name="province"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
								data-default="<?= htmlspecialchars($user['province'] ?? '', ENT_QUOTES) ?>">
								<option value="">Chọn tỉnh/thành phố</option>
							</select>
						</div>
						<!-- Ward -->
						<div>
							<label for="ward" class="block text-sm font-medium text-gray-700 mb-2">Phường/Xã</label>
							<select id="ward" name="ward"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
								data-default="<?= htmlspecialchars($user['ward'] ?? '', ENT_QUOTES) ?>">
								<option value="">Chọn phường/xã</option>
							</select>
						</div>

						<!-- Street Address -->
						<div>
							<label for="address" class="block text-sm font-medium text-gray-700 mb-2">Số nhà, tên đường</label>
							<input type="text" id="address" name="address" value="<?= $user['address'] ?>"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
								placeholder="Nhập số nhà và tên đường">
						</div>
					</div>
					<!-- Save Button -->
					<div class="flex justify-end">
						<button type="button" id="updateProfile"
							class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
							<i class="fas fa-save mr-2"></i>
							Lưu thay đổi
						</button>
					</div>
				</form>
			</div>
		</div>
		<!-- Change Password -->
		<div class="bg-white rounded-lg shadow-sm border border-gray-200">
			<div class="p-6 border-b border-gray-200">
				<h2 class="text-xl font-bold text-gray-900">Đổi mật khẩu</h2>
				<p class="text-gray-600 text-sm mt-1">Cập nhật mật khẩu để bảo mật tài khoản</p>
			</div>
			<div class="p-6">
				<form id="changePasswordForm">
					<div>
						<label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu hiện tại</label>
						<input type="password" id="current_password" name="current_password"
							class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
					</div>

					<div>
						<label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu mới</label>
						<input type="password" id="password" name="password"
							class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
					</div>

					<div>
						<label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Xác nhận mật khẩu mới</label>
						<input type="password" id="confirm_password" name="confirm_password"
							class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
					</div>

					<div class="flex justify-end mt-2">
						<button type="button" id="changePassword"
							class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
							<i class="fas fa-key mr-2"></i>
							Đổi mật khẩu
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Right Column -->
	<div class="space-y-8">
		<!-- Profile Picture -->
		<div class="bg-white rounded-lg shadow-sm border border-gray-200">
			<div class="p-6 border-b border-gray-200">
				<h2 class="text-xl font-bold text-gray-900">Ảnh đại diện</h2>
			</div>
			<div class="p-6">
				<div class="text-center">
					<div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
						<?= $user['avatar'] != '' ? '<img src=" ' . $user['avatar'] . '" alt="Ảnh đại diện" class="w-full h-full object-cover rounded-full">' : '<i class="fas fa-user text-gray-400 text-4xl"></i>' ?>
					</div>
					<input type="file" id="profilePicture" name="profilePicture" class="hidden" accept="image/*">
					<button id="updateProfilePictureTrigger" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
						<i class="fas fa-camera mr-2"></i>
						Thay đổi ảnh
					</button>
					<p class="text-sm text-gray-600 mt-2">JPG, PNG tối đa 2MB</p>
				</div>
			</div>
		</div>

		<!-- Account Status -->
		<div class="bg-white rounded-lg shadow-sm border border-gray-200">
			<div class="p-6 border-b border-gray-200">
				<h2 class="text-xl font-bold text-gray-900">Trạng thái tài khoản</h2>
			</div>
			<div class="p-6">
				<div class="space-y-4">
					<div class="flex items-center justify-between">
						<span class="text-sm font-medium text-gray-700">Xác thực email</span>
						<span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
							<i class="fas fa-check mr-1"></i>Đã xác thực
						</span>
					</div>

					<div class="flex items-center justify-between">
						<span class="text-sm font-medium text-gray-700">Xác thực số điện thoại</span>
						<span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
							<i class="fas fa-check mr-1"></i>Đã xác thực
						</span>
					</div>

					<div class="flex items-center justify-between">
						<span class="text-sm font-medium text-gray-700">Xác thực CCCD</span>
						<span class="inline-block bg-<?= $user['citizen_id'] ? 'green' : 'yellow' ?>-100 text-<?= $user['citizen_id'] ? 'green' : 'yellow' ?>-800 text-xs px-2 py-1 rounded-full">
							<i class="fas fa-<?= $user['citizen_id'] ? 'check' : 'clock' ?> mr-1"></i><?= $user['citizen_id'] ? 'Đã xác thực' : 'Chưa cập nhật' ?>
						</span>
					</div>
				</div>
			</div>
		</div>

		<!-- Account Statistics -->
		<div class="bg-white rounded-lg shadow-sm border border-gray-200">
			<div class="p-6 border-b border-gray-200">
				<h2 class="text-xl font-bold text-gray-900">Thống kê tài khoản</h2>
			</div>
			<div class="p-6">
				<div class="space-y-4">
					<div class="flex items-center justify-between">
						<span class="text-sm font-medium text-gray-700">Ngày tham gia</span>
						<span class="text-sm text-gray-600"><?= date('d/m/Y', strtotime($user['created_at'])) ?></span>
					</div>

					<div class="flex items-center justify-between">
						<span class="text-sm font-medium text-gray-700">Phòng đang thuê</span>
						<span class="text-sm text-gray-600"><?= $countRentedRooms ?></span>
					</div>

					<div class="flex items-center justify-between">
						<span class="text-sm font-medium text-gray-700">Tổng chi phí</span>
						<span class="text-sm text-gray-600"><?= Format::forMatPrice($totalPaymentHistory) ?> VNĐ</span>
					</div>
				</div>
			</div>
		</div>

		<!-- Danger Zone -->
		<div class="bg-white rounded-lg shadow-sm border border-red-200">
			<div class="p-6 border-b border-red-200">
				<h2 class="text-xl font-bold text-red-600">Vùng nguy hiểm</h2>
			</div>
			<div class="p-6">
				<div class="space-y-4">
					<div>
						<h3 class="font-medium text-gray-900 mb-2">Xóa tài khoản</h3>
						<p class="text-sm text-gray-600 mb-4">Xóa vĩnh viễn tài khoản và tất cả dữ liệu liên quan. Hành động này không thể hoàn tác.</p>
						<button id="deleteAccount" data-modal-target="deleteAccountModal" data-modal-toggle="deleteAccountModal" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
							<i class="fas fa-trash mr-2"></i>
							Xóa tài khoản
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include_once ROOT_PATH .'/views/partials/deleted-account-modal.php'; ?>