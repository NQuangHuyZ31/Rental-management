<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="relative p-4 max-w-1/2 max-h-full">
		<!-- Modal content -->
		<form id="formNewPost">
		<div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
			<!-- Modal header -->
			<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
				<input type="hidden" name="post_id" value="">
				<?= \Core\CSRF::getTokenField() ?>
				<!-- Modal Header with Icon -->
				<div class="flex items-center gap-3">
					<div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
						<i class="fas fa-building text-green-600 text-lg"></i>
					</div>
					<h3 id="modalNewPost-title" class="text-xl font-semibold text-gray-900">Thêm tin đăng</h3>
				</div>
				<button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white modalNewPost-button-close" data-modal-hide="default-modal">
					<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
					</svg>
					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<div class="p-4 md:p-5 space-y-4">
				<!-- Thông tin chủ nhà -->
				<div class="mb-6">
					<div class="border-l-4 border-green-500 pl-4 mb-4">
						<div class="flex items-center gap-2 mb-2">
							<i class="fas fa-user-tie text-green-600"></i>
							<h4 class="text-lg font-medium text-gray-900">Thông tin chủ nhà</h4>
						</div>
						<div class="text-sm text-gray-600 mb-2">
							<p class="mb-1">Nhập các thông tin về người cho thuê</p>
							<p class="text-gray-500"><span class="font-medium">*Tiêu đề tốt:</span> Cho thuê + loại hình phòng trọ + diện tích + giá + tên đường/quận</p>
						</div>
						<div class="alert alert-info p-2">
							<div class="flex items-start gap-2">
								<i class="fas fa-lightbulb text-info"></i>
								<div>
									<p class="text-sm font-medium mb-1">Ví dụ:</p>
									<p class="text-sm italic">Cho thuê phòng trọ 18m2 giá rẻ tại Bình Thạnh</p>
								</div>
							</div>
						</div>
					</div>

					<!-- Form Fields -->
					<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
						<div class="form-control">
							<label class="label">
								<span class="label-text">
									<i class="fas fa-edit text-gray-500 mr-1"></i>
									Tiêu đề <span class="text-red-500">*</span>
								</span>
							</label>
							<input type="text" name="title" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Nhập tiêu đề" />
						</div>
						<div class="form-control">
							<label class="label">
								<span class="label-text">
									<i class="fas fa-list text-gray-500 mr-1"></i>
									Danh mục thuê
								</span>
							</label>
							<select name="category" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors">
								<?php foreach ($rentalCategories as $rentalCategory) { ?>
									<option value="<?php echo $rentalCategory['id']; ?>"><?php echo $rentalCategory['rental_category_name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>

					<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
						<div class="form-control">
							<label class="label"></label>
							<span class="label-text">
								<i class="fas fa-user text-gray-500 mr-1"></i>
								Tên người liên hệ <span class="text-red-500">*</span>
							</span>
							</label>
							<input type="text" name="contact_name" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Nhập tên người liên hệ" />
						</div>
						<div class="form-control">
							<label class="label">
								<span class="label-text">
									<i class="fas fa-phone text-gray-500 mr-1"></i>
									SĐT <span class="text-red-500">*</span>
								</span>
							</label>
							<input type="tel" name="contact_phone" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Nhập số điện thoại" />
						</div>
					</div>
				</div>

				<!-- Mô tả -->
				<div class="mb-6">
					<div class="border-l-4 border-green-500 pl-4 mb-4">
						<div class="flex items-center gap-2 mb-2">
							<i class="fas fa-align-left text-green-600"></i>
							<h4 class="text-lg font-medium text-gray-900">Mô tả</h4>
						</div>
						<p class="text-sm text-gray-600">Nhập mô tả về nhà cho thuê</p>
					</div>
					<div class="form-control">
						<label class="label">
							<span class="label-text">
								<i class="fas fa-paragraph text-gray-500 mr-1"></i>
								Nhập mô tả</span>
							</span>
						</label>
						<textarea name="description" id="editor" cols="30" rows="5" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Mô tả chi tiết về căn phòng/nhà cho thuê..."></textarea>
					</div>
				</div>

				<!-- Thông tin cơ bản & giá -->
				<div class="mb-6">
					<div class="border-l-4 border-green-500 pl-4 mb-4">
						<div class="flex items-center gap-2 mb-2">
							<i class="fas fa-info-circle text-green-600"></i>
							<h4 class="text-lg font-medium text-gray-900">Thông tin cơ bản & giá</h4>
						</div>
						<p class="text-sm text-gray-600">Nhập các thông tin về phòng cho thuê</p>
					</div>

					<!-- Price Fields Row 1 -->
					<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
						<div class="form-control">
							<label class="block text-sm font-medium text-gray-700 mb-2">
								Giá thuê <span class="text-red-500">*</span>
							</label>
							<input type="text" name="price" data-type="currency" class="cleave-input w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Nhập giá thuê" />
						</div>
						<div class="form-control">
							<label class="block text-sm font-medium text-gray-700 mb-2">
								Giá thuê khuyến mãi
							</label>
							<input type="text" name="promotional_price" data-type="currency" class="cleave-input w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Giá khuyến mãi" />
						</div>
						<div class="form-control">
							<label class="block text-sm font-medium text-gray-700 mb-2">
								Tiền cọc
							</label>
							<input type="text" name="deposit" data-type="currency" class="cleave-input w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Tiền cọc" />
						</div>
					</div>

					<!-- Price Fields Row 2 -->
					<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
						<div class="form-control">
							<label class="block text-sm font-medium text-gray-700 mb-2">
								Diện tích <span class="text-red-500">*</span>
							</label>
							<input type="text" name="area" data-type="number" class="cleave-input w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Diện tích (m²)" />
						</div>
						<div class="form-control">
							<label class="block text-sm font-medium text-gray-700 mb-2">
								Giá điện <span class="text-red-500">*</span>
							</label>
							<input type="text" name="electricity_price" data-type="currency" class="cleave-input w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Giá điện/kWh" />
						</div>
						<div class="form-control">
							<label class="block text-sm font-medium text-gray-700 mb-2">
								Giá nước <span class="text-red-500">*</span>
							</label>
							<input type="text" name="water_price" data-type="currency" class="cleave-input w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Giá nước/m³" />
						</div>
					</div>

					<!-- Additional Fields -->
					<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
						<div class="form-control">
							<label class="block text-sm font-medium text-gray-700 mb-2">
								Tối đa người ở / phòng
							</label>
							<select name="max_occupants" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors">
								<option value="1">1 người ở</option>
								<option value="2">2 người ở</option>
								<option value="3">3 người ở</option>
								<option value="4">4 người ở</option>
								<option value="5">5+ người ở</option>
								<option value="unknown">Không xác định</option>
							</select>
						</div>
						<div class="form-control">
							<label class="block text-sm font-medium text-gray-700 mb-2">
								Ngày có thể vào ở <span class="text-red-500">*</span>
							</label>
							<div class="relative">
								<input type="date" name="available_date" data-type="date" class="cleave-input w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors" />
								<i class="fas fa-calendar-alt absolute right-3 top-3 text-gray-400 pointer-events-none"></i>
							</div>
						</div>
					</div>
				</div>

				<!-- Tiện ích cho thuê -->
				<div class="mb-6">
					<div class="border-l-4 border-emerald-500 pl-4 mb-4">
						<div class="flex items-center gap-2 mb-2">
							<i class="fas fa-star text-emerald-600"></i>
							<h4 class="text-lg font-medium text-gray-900">Tiện ích cho thuê</h4>
						</div>
						<p class="text-sm text-gray-600">Tùy chọn tiện ích của nhà cho thuê</p>
					</div>

					<div class="bg-gray-50 p-4 rounded-lg">
						<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
							<?php foreach ($rentalAmenities as $amenity): ?>
								<label class="flex items-center gap-2 p-2 bg-white rounded-lg border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 transition-all cursor-pointer group">
									<input
										type="checkbox"
										name="amenities[]"
										value="<?= $amenity['id']; ?>"
										class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 focus:ring-2" />
									<span class="text-sm text-gray-700 group-hover:text-emerald-700 font-medium select-none">
										<?= htmlspecialchars($amenity['rental_amenity_name']); ?>
									</span>
								</label>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<!-- Quy định giờ giấc -->
				<div class="mb-6">
					<div class="border-l-4 border-green-500 pl-4 mb-4">
						<div class="flex items-center gap-2 mb-2">
							<i class="fas fa-clock text-green-600"></i>
							<h4 class="text-lg font-medium text-gray-900">Quy định giờ giấc</h4>
						</div>
						<p class="text-sm text-gray-600">Tùy chọn thời gian hoạt động của nhà cho thuê</p>
					</div>

					<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
						<div class="form-control">
							<label class="block text-sm font-medium text-gray-700 mb-2">
								Giờ mở cửa
							</label>
							<select name="opening_time" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors">
								<option value="5:00">5 giờ sáng</option>
								<option value="6:00">6 giờ sáng</option>
								<option value="7:00">7 giờ sáng</option>
								<option value="8:00">8 giờ sáng</option>
								<option value="9:00">9 giờ sáng</option>
								<option value="10:00">10 giờ sáng</option>
								<option value="all">Giờ tự do</option>
							</select>
						</div>
						<div class="form-control">
							<label class="block text-sm font-medium text-gray-700 mb-2">
								Giờ đóng cửa
							</label>
							<select name="closing_time" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors">
								<option value="20:00">20 giờ tối</option>
								<option value="21:00">21 giờ tối</option>
								<option value="22:00">22 giờ tối</option>
								<option value="23:00">23 giờ tối</option>
								<option value="24:00">24 giờ tối</option>
								<option value="all">Giờ tự do</option>
							</select>
						</div>
					</div>
				</div>

				<!-- Địa chỉ -->
				<div class="mb-6">
					<div class="border-l-4 border-green-500 pl-4 mb-4">
						<div class="flex items-center gap-2 mb-2">
							<i class="fas fa-map-marker-alt text-green-600"></i>
							<h4 class="text-lg font-medium text-gray-900">Địa chỉ</h4>
						</div>
						<p class="text-sm text-gray-600">Vui lòng nhập địa chỉ chính xác để có thể tìm đến nhà cho thuê của bạn</p>
					</div>

					<!-- Tỉnh/Thành phố và Quận/Huyện -->
					<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
						<div class="form-control">
							<label class="block text-sm font-medium text-gray-700 mb-2">
								Chọn Tỉnh/Thành phố <span class="text-red-500">*</span>
							</label>
							<select id="province" name="province" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors cursor-pointer">
								<option value="">Chọn Tỉnh/Thành phố</option>
							</select>
						</div>

						<!-- Phường/Xã -->
						<div class="form-control mb-4">
							<label class="block text-sm font-medium text-gray-700 mb-2">
								Chọn Phường/Xã <span class="text-red-500">*</span>
							</label>
							<select id="ward" name="ward" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors cursor-pointer">
								<option value="">Chọn Phường/Xã</option>
							</select>
						</div>

						<!-- Địa chỉ chi tiết -->
						<div class="form-control">
							<label class="block text-sm font-medium text-gray-700 mb-2">
								Địa chỉ chi tiết. Ví dụ: 122 - Đường Nguyễn Duy Trinh <span class="text-red-500">*</span>
							</label>
							<textarea name="address" rows="3" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Nhập địa chỉ chi tiết: số nhà, tên đường, ghi chú thêm..."></textarea>
						</div>
					</div>

					<!-- Chọn hình ảnh -->
					<div class="mb-6">
						<div class="border-l-4 border-green-500 pl-4 mb-4">
							<div class="flex items-center gap-2 mb-2">
								<i class="fas fa-images text-green-600"></i>
								<h4 class="text-lg font-medium text-gray-900">Chọn hình ảnh <span class="text-red-500">*</span></h4>
							</div>
							<p class="text-sm text-gray-600">Chọn hình ảnh, tối đa 5 ảnh</p>
						</div>

						<!-- Upload Area -->
						<div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-emerald-400 transition-colors">
							<div class="mb-4">
								<i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
								<p class="text-lg font-medium text-gray-700 mb-2">Kéo thả hoặc chọn file để tải lên</p>
								<p class="text-sm text-gray-500">PNG, JPG, JPEG up to 10MB</p>
							</div>

							<input type="file" id="imageUpload" name="images[]" multiple accept="image/*" class="hidden" max="5" />
							<label for="imageUpload" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg cursor-pointer transition-colors">
								<i class="fas fa-plus"></i>
								Chọn hình ảnh
							</label>
						</div>

						<!-- Preview Images -->
						<div id="imagePreview" class="grid-cols-2 md:grid-cols-5 gap-4 mt-4 hidden">
							<!-- Images will be displayed here -->
						</div>

						<!-- Image Counter -->
						<div class="mt-2 text-right">
							<span id="imageCounter" class="text-sm text-gray-500">0/5 ảnh đã chọn</span>
						</div>
					</div>

					<!-- error message -->
					<div id="errorMessage" class="text-red-500 text-center w-full"></div>
					<!-- Modal footer -->
					<div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 modal-action">
						<button type="button" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2 addNewPostBtn">
							<i class="fas fa-save"></i>
							Tạo tin đăng
						</button>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>