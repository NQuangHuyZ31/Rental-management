<!-- 
	Author: Huy Nguyen
	Date: 2025-11-30
	Purpose: Introduce Page for Hosty
-->

<div class="max-w-6xl mx-auto px-6 py-12">
	<!-- Hero -->
	<section class="bg-white rounded-xl shadow p-8 mb-8">
		<div class="flex flex-col lg:flex-row items-center gap-8">
			<div class="flex-1">
				<h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">HOSTY — Nền tảng quản lý & cho thuê nhà</h1>
				<p class="text-gray-600 mb-6">Kết nối chủ nhà và người thuê, tối ưu hoá quy trình quản lý cho thuê và bảo vệ cộng đồng người dùng.</p>
				<div class="flex gap-3">
					<p class="inline-block px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-500">Duyệt tin thuê</p>
					<p class="inline-block px-5 py-2 border border-gray-200 rounded-lg hover:bg-gray-100">Liên hệ hỗ trợ</p>
				</div>
			</div>
			<div class="w-full lg:w-1/3">
				<div class="aspect-w-4 aspect-h-3 bg-gradient-to-br from-blue-50 to-white rounded-lg flex items-center justify-center border border-gray-100">
					<div class="text-center p-6">
						<img src="<?= BASE_URL  ?>/Public/images/admin/hosty-removebg.png" alt="logo" class="mx-auto mb-4 w-60 h-40">
						<p class="mt-4 text-sm text-gray-600">Quản lý tin, giao dịch và hỗ trợ cộng đồng an toàn</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Mission & Values -->
	<section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
		<article class="bg-white p-6 rounded-lg shadow">
			<h3 class="text-lg font-semibold mb-2">Sứ mệnh</h3>
			<p class="text-gray-600 text-sm">Giúp việc cho thuê trở nên minh bạch, an toàn và hiệu quả cho cả chủ nhà lẫn người thuê.</p>
		</article>
		<article class="bg-white p-6 rounded-lg shadow">
			<h3 class="text-lg font-semibold mb-2">Giá trị cốt lõi</h3>
			<ul class="text-gray-600 text-sm space-y-1">
				<li>• An toàn & tin cậy</li>
				<li>• Minh bạch & công bằng</li>
				<li>• Hỗ trợ nhanh chóng</li>
			</ul>
		</article>
		<article class="bg-white p-6 rounded-lg shadow">
			<h3 class="text-lg font-semibold mb-2">Cam kết</h3>
			<p class="text-gray-600 text-sm">Bảo vệ cộng đồng, xử lý báo cáo kịp thời và nâng cao trải nghiệm người dùng.</p>
		</article>
	</section>

	<!-- Features -->
	<section class="bg-white p-8 rounded-lg shadow mb-8">
		<h2 class="text-xl font-semibold mb-4">Tính năng nổi bật</h2>
		<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
			<div class="flex gap-4 items-start">
				<div class="flex-shrink-0 w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">🔍</div>
				<div>
					<h4 class="font-medium">Duyệt & quản lý bài đăng</h4>
					<p class="text-sm text-gray-600">Quản lý bài đăng, phê duyệt hoặc từ chối kèm lý do rõ ràng.</p>
				</div>
			</div>
			<div class="flex gap-4 items-start">
				<div class="flex-shrink-0 w-10 h-10 bg-green-50 rounded-full flex items-center justify-center text-green-600">💬</div>
				<div>
					<h4 class="font-medium">Quản lý nhà trọ</h4>
					<p class="text-sm text-gray-600">Quản lý nhà trọ, phòng trọ và tiện ích hiệu quả.</p>
				</div>
			</div>
			<div class="flex gap-4 items-start">
				<div class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-full flex items-center justify-center text-purple-600">📊</div>
				<div>
					<h4 class="font-medium">Thanh toán</h4>
					<p class="text-sm text-gray-600">Theo dõi hóa đơn trên trang web, hỗ trợ thanh toán online.</p>
				</div>
			</div>
			<div class="flex gap-4 items-start">
				<div class="flex-shrink-0 w-10 h-10 bg-yellow-50 rounded-full flex items-center justify-center text-yellow-600">🔒</div>
				<div>
					<h4 class="font-medium">Bảo mật & quyền riêng tư</h4>
					<p class="text-sm text-gray-600">Quy trình xác thực, ẩn danh và bảo vệ dữ liệu người dùng.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- How it works -->
	<section class="mb-8">
		<h2 class="text-xl font-semibold mb-4">Cách hoạt động</h2>
		<ol class="bg-white p-6 rounded-lg shadow list-decimal list-inside space-y-3 text-gray-700">
			<li>Người dùng đăng tin cho thuê.</li>
			<li>Đội ngũ kiểm duyệt rà soát và xử lý vi phạm.</li>
			<li>Hỗ trợ & kết nối chủ nhà với người thuê.</li>
		</ol>
	</section>

	<!-- CTA & Contact -->
	<section class="bg-white p-8 rounded-lg shadow">
		<div class="flex flex-col md:flex-row items-center justify-between gap-6">
			<div>
				<h3 class="text-lg font-semibold">Bắt đầu với <?= $siteNameEsc ?></h3>
				<p class="text-gray-600 text-sm">Bạn là quản trị viên, chủ nhà hay người thuê? Chúng tôi sẽ hỗ trợ ngay.</p>
			</div>
			<div class="flex gap-3">
				<a href="<?= BASE_URL ?>/register" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500">Đăng ký</a>
			</div>
		</div>
		<p class="mt-4 text-xs text-gray-500">Email hỗ trợ: <a href="mailto:support@hosty.com" class="text-blue-600">support@hosty.com</a></p>
	</section>
</div>