 <!-- FORM HỖ TRỢ -->
 <section class="bg-white p-8 rounded-2xl shadow-md max-w-">
 	<img src="<?= BASE_URL ?>/Public/images/banner-1.jpg" alt="image">
 	<div class="max-w-screen-md mx-auto mt-2 py-2">
 		<h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Gửi yêu cầu hỗ trợ</h2>
 		<form id="supportForm" class="space-y-5">
 			<?= \Core\CSRF::getTokenField() ?>
 			<div>
 				<label class="block text-gray-700 font-medium mb-1">Họ và tên <span class="text-red-500">*</span></label>
 				<input type="text" placeholder="Nhập họ và tên của bạn" name="customer_name"
 					class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
 			</div>

 			<div>
 				<label class="block text-gray-700 font-medium mb-1">Email <span class="text-red-500">*</span></label>
 				<input type="email" placeholder="Nhập email liên hệ" name="customer_email"
 					class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
 			</div>

 			<div>
 				<label class="block text-gray-700 font-medium mb-1">Loại vấn đề <span class="text-red-500">*</span></label>
 				<select name="support_type" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
 					<option value="">Chọn loại vấn đề</option>
 					<option value="Tìm trọ, tìm nhà">Tìm trọ, tìm nhà</option>
 					<option value="Thanh toán">Thanh toán</option>
 					<option value="Tài khoản">Tài khoản</option>
 					<option value="Kỹ thuâth">Kỹ thuật</option>
 					<option value="Góp ý">Góp ý / Phản hồi</option>
 				</select>
 			</div>

 			<div>
 				<label class="block text-gray-700 font-medium mb-1">Nội dung <span class="text-red-500">*</span></label>
 				<textarea rows="4" placeholder="Mô tả vấn đề bạn gặp phải..." name="description_problem"
 					class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none" required></textarea>
 			</div>
 			<div>
 				<label class="block text-gray-700 font-medium mb-1">Hình ảnh kèm theo (nếu có)</label>
 				<input type="file" name="image_problem[]" multiple accept="image/*"
 					class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"></input>
 			</div>

 			<button type="button" id="supportBtn"
 				class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold w-full">
 				Gửi yêu cầu
 			</button>
 		</form>
 	</div>
 </section>