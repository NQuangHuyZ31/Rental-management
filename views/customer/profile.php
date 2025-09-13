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
					<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
						<!-- Full Name -->
						<div>
							<label for="fullName" class="block text-sm font-medium text-gray-700 mb-2">Họ và tên</label>
							<input type="text" id="fullName" name="fullName" value="Nguyễn Văn A"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
						</div>

						<!-- Email -->
						<div>
							<label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
							<input type="email" id="email" name="email" value="nguyenvana@email.com"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
						</div>

						<!-- Phone -->
						<div>
							<label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
							<input type="tel" id="phone" name="phone" value="0901234567"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
						</div>

						<!-- Date of Birth -->
						<div>
							<label for="dateOfBirth" class="block text-sm font-medium text-gray-700 mb-2">Ngày sinh</label>
							<input type="date" id="dateOfBirth" name="dateOfBirth" value="1995-05-15"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
						</div>

						<!-- Gender -->
						<div>
							<label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Giới tính</label>
							<select id="gender" name="gender"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
								<option value="male" selected>Nam</option>
								<option value="female">Nữ</option>
								<option value="other">Khác</option>
							</select>
						</div>

						<!-- Occupation -->
						<div>
							<label for="occupation" class="block text-sm font-medium text-gray-700 mb-2">Nghề nghiệp</label>
							<input type="text" id="occupation" name="occupation" value="Nhân viên văn phòng"
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
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
								<option value="">Chọn tỉnh/thành phố</option>
							</select>
						</div>
						<!-- Ward -->
						<div>
							<label for="ward" class="block text-sm font-medium text-gray-700 mb-2">Phường/Xã</label>
							<select id="ward" name="ward"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
								<option value="">Chọn phường/xã</option>
								<option value="phuong-tan-dinh" selected>Phường Tân Định</option>
								<option value="phuong-da-kao">Phường Đa Kao</option>
								<option value="phuong-ben-nghe">Phường Bến Nghé</option>
								<option value="phuong-ben-thanh">Phường Bến Thành</option>
								<option value="phuong-nguyen-thai-binh">Phường Nguyễn Thái Bình</option>
								<option value="phuong-pham-ngu-lao">Phường Phạm Ngũ Lão</option>
								<option value="phuong-cau-ong-lanh">Phường Cầu Ông Lãnh</option>
								<option value="phuong-cau-kho">Phường Cầu Kho</option>
								<option value="phuong-nguyen-cu-trhinh">Phường Nguyễn Cư Trinh</option>
								<option value="phuong-co-giang">Phường Cô Giang</option>
							</select>
						</div>

						<!-- Street Address -->
						<div>
							<label for="streetAddress" class="block text-sm font-medium text-gray-700 mb-2">Số nhà, tên đường</label>
							<input type="text" id="streetAddress" name="streetAddress" value="123 Đường ABC"
								class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
								placeholder="Nhập số nhà và tên đường">
						</div>
					</div>
					<!-- Save Button -->
					<div class="flex justify-end">
						<button type="submit"
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
				<form id="changePasswordForm" class="space-y-6">
					<div>
						<label for="currentPassword" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu hiện tại</label>
						<input type="password" id="currentPassword" name="currentPassword"
							class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
					</div>

					<div>
						<label for="newPassword" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu mới</label>
						<input type="password" id="newPassword" name="newPassword"
							class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
					</div>

					<div>
						<label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Xác nhận mật khẩu mới</label>
						<input type="password" id="confirmPassword" name="confirmPassword"
							class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
					</div>

					<div class="flex justify-end">
						<button type="submit"
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
						<i class="fas fa-user text-gray-400 text-4xl"></i>
					</div>
					<button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
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
						<span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
							<i class="fas fa-clock mr-1"></i>Chưa cập nhật
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
						<span class="text-sm text-gray-600">15/08/2024</span>
					</div>

					<div class="flex items-center justify-between">
						<span class="text-sm font-medium text-gray-700">Phòng đã thuê</span>
						<span class="text-sm text-gray-600">2</span>
					</div>

					<div class="flex items-center justify-between">
						<span class="text-sm font-medium text-gray-700">Tổng chi phí</span>
						<span class="text-sm text-gray-600">12.5M VNĐ</span>
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
						<button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
							<i class="fas fa-trash mr-2"></i>
							Xóa tài khoản
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	// Profile form submission
	document.getElementById("profileForm").addEventListener("submit", function(e) {
		e.preventDefault();

		// Show loading
		const submitBtn = this.querySelector("button[type=submit]");
		const originalText = submitBtn.innerHTML;
		submitBtn.innerHTML = "<i class=\"fas fa-spinner fa-spin mr-2\"></i>Đang lưu...";
		submitBtn.disabled = true;

		// Simulate API call
		setTimeout(() => {
			submitBtn.innerHTML = originalText;
			submitBtn.disabled = false;

			// Show success message
			toastr.success("Thông tin đã được cập nhật thành công!");
		}, 2000);
	});

	// Change password form submission
	document.getElementById("changePasswordForm").addEventListener("submit", function(e) {
		e.preventDefault();

		const newPassword = document.getElementById("newPassword").value;
		const confirmPassword = document.getElementById("confirmPassword").value;

		if (newPassword !== confirmPassword) {
			toastr.error("Mật khẩu xác nhận không khớp!");
			return;
		}

		if (newPassword.length < 6) {
			toastr.error("Mật khẩu phải có ít nhất 6 ký tự!");
			return;
		}

		// Show loading
		const submitBtn = this.querySelector("button[type=submit]");
		const originalText = submitBtn.innerHTML;
		submitBtn.innerHTML = "<i class=\"fas fa-spinner fa-spin mr-2\"></i>Đang đổi...";
		submitBtn.disabled = true;

		// Simulate API call
		setTimeout(() => {
			submitBtn.innerHTML = originalText;
			submitBtn.disabled = false;

			// Clear form
			this.reset();

			// Show success message
			toastr.success("Mật khẩu đã được thay đổi thành công!");
		}, 2000);
	});
</script>