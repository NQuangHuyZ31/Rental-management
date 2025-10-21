<!--
	Author: Huy Nguyen
	Date: 2025-09-01
	Purpose: provide home page for customer
-->
<?php

use Helpers\Format;
?>
<!-- Hero Section with Full Background -->
<section class="relative min-h-screen bg-gradient-to-br from-teal-400 via-blue-500 to-teal-600 overflow-hidden" style="background-image: url('<?= BASE_URL ?>/Public/images/backgroud_plaform.jpeg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
	<!-- Main Content -->
	<div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16">
		<!-- Main Heading -->
		<div class="text-center mb-12">
			<h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
				Kênh tìm phòng trọ, căn hộ, ký túc xá cho thuê
				<span class="text-yellow-400">TOP</span> Việt Nam
			</h1>
			<p class="text-xl md:text-2xl text-white font-medium">
				Chất lượng - Giá tốt - Nhanh chóng.
			</p>
		</div>

		<!-- Search Bar -->
		<form action="<?= BASE_URL ?>/phong-tro-nha-tro" method="GET" class="max-w-screen-lg mx-auto mb-16">
			<div class="bg-inherit rounded-2xl shadow-2xl p-2">
				<?php require_once ROOT_PATH . '/views/customer/layouts/filters.php' ?>
			</div>
		</form>

		<!-- Bottom Content -->
		<div class="grid lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
			<!-- App Download Card -->
			<div class="bg-white rounded-2xl shadow-xl p-6">
				<div class="flex items-start space-x-6">
					<!-- QR Code -->
					<div class="flex-shrink-0">
						<div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
							<div class="w-20 h-20 bg-green-500 rounded-lg flex items-center justify-center">
								<span class="text-white font-bold text-2xl">H</span>
							</div>
						</div>
					</div>

					<!-- Content -->
					<div class="flex-1">
						<h3 class="text-lg font-bold text-gray-900 mb-3">
							Tải APP tìm phòng trọ, căn hộ, việc làm!
						</h3>

						<!-- Rating -->
						<div class="flex items-center mb-3">
							<div class="flex items-center">
								<i class="fas fa-star text-yellow-400"></i>
								<i class="fas fa-star text-yellow-400"></i>
								<i class="fas fa-star text-yellow-400"></i>
								<i class="fas fa-star text-yellow-400"></i>
								<i class="fas fa-star text-gray-300"></i>
							</div>
							<span class="text-sm text-gray-600 ml-2">4.5+ rating, hơn 10.000+ đồng minh tải APP & sử dụng</span>
						</div>

						<p class="text-sm text-gray-600 mb-4">
							Cơ hội trải nghiệm đa dịch vụ tại HOSTY. Bạn đã sẵn sàng chưa?
						</p>

						<!-- Download Buttons -->
						<div class="flex space-x-3">
							<button class="flex items-center bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
								<i class="fab fa-apple text-xl mr-2"></i>
								<div class="text-left">
									<div class="text-xs">Tải về trên</div>
									<div class="text-sm font-medium">App Store</div>
								</div>
							</button>
							<button class="flex items-center bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
								<i class="fab fa-google-play text-xl mr-2"></i>
								<div class="text-left">
									<div class="text-xs">TẢI TRÊN</div>
									<div class="text-sm font-medium">Google Play</div>
								</div>
							</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Features Card -->
			<div class="bg-white rounded-2xl shadow-xl p-6">
				<h3 class="text-lg font-bold text-gray-900 mb-4">Tính năng nổi bật</h3>
				<ul class="space-y-3">
					<li class="flex items-center">
						<i class="fas fa-check-circle text-green-500 mr-3"></i>
						<span class="text-gray-700">Tìm việc tiện lợi</span>
					</li>
					<li class="flex items-center">
						<i class="fas fa-check-circle text-green-500 mr-3"></i>
						<span class="text-gray-700">Theo dõi khu vực tìm phòng của bạn</span>
					</li>
					<li class="flex items-center">
						<i class="fas fa-check-circle text-green-500 mr-3"></i>
						<span class="text-gray-700">Không bỏ lỡ thông báo tìm phòng</span>
					</li>
					<li class="flex items-center">
						<i class="fas fa-check-circle text-green-500 mr-3"></i>
						<span class="text-gray-700">Và nhiều tiện ích khác...</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>

<div class="mt-4 max-w-screen-xl mx-auto">
	<!-- Programs Section -->
	<section class="py-4 bg-white rounded-md">
		<div class="container mx-auto px-4 sm:px-6 lg:px-8">
			<!-- Section Title -->
			<div class="flex items-center mb-4">
				<div class="w-1 h-5 rounded-md bg-green-500 mr-4"></div>
				<h2 class="text-lg font-bold text-gray-900">CHƯƠNG TRÌNH - HOSTY</h2>
			</div>

			<!-- Programs Grid -->
			<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
				<!-- Program 1 -->
				<div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow cursor-pointer">
					<div class="h-36 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative overflow-hidden">
						<div class="absolute inset-0 bg-yellow-300 opacity-20"></div>
						<div class="absolute top-4 left-4 w-8 h-8 bg-yellow-400 rounded-full"></div>
						<div class="absolute bottom-4 right-4 w-6 h-6 bg-blue-300 rounded-full"></div>
						<div class="relative z-10 text-center">
							<div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-2">
								<i class="fas fa-graduation-cap text-blue-600 text-2xl"></i>
							</div>
							<div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto">
								<i class="fas fa-tablet-alt text-blue-600 text-xl"></i>
							</div>
						</div>
					</div>
					<div class="p-4 text-center">
						<p class="text-sm text-gray-700 leading-relaxed">
							Hỗ trợ tân sinh viên nhập học. Hòa nhập môi trường mới
						</p>
					</div>
				</div>

				<!-- Program 2 -->
				<div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow cursor-pointer">
					<div class="h-36 bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center relative overflow-hidden">
						<div class="absolute top-4 left-4 text-white">
							<i class="fas fa-arrow-up text-2xl transform rotate-45"></i>
						</div>
						<div class="absolute bottom-4 right-4 text-white">
							<i class="fas fa-arrow-down text-2xl transform rotate-45"></i>
						</div>
						<div class="relative z-10 text-center">
							<h3 class="text-2xl font-bold text-purple-800 mb-2">GIẢM GIÁ</h3>
							<h3 class="text-2xl font-bold text-purple-800">CỰC SÂU</h3>
						</div>
					</div>
					<div class="p-4 text-center">
						<p class="text-sm text-gray-700 leading-relaxed">
							Hỗ trợ giảm giá cực sâu chỉ có tại HOSTY
						</p>
					</div>
				</div>

				<!-- Program 3 -->
				<div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow cursor-pointer">
					<div class="h-36 bg-gradient-to-br from-blue-300 to-blue-400 flex items-center justify-center relative overflow-hidden">
						<div class="absolute top-4 right-4 w-8 h-8 bg-yellow-300 rounded-full opacity-60"></div>
						<div class="relative z-10 flex items-center justify-center space-x-4">
							<div class="w-16 h-20 bg-white rounded-lg shadow-md flex items-center justify-center">
								<i class="fas fa-mobile-alt text-blue-600 text-2xl"></i>
							</div>
							<div class="w-12 h-16 bg-white rounded-lg shadow-md flex items-center justify-center">
								<i class="fas fa-phone text-blue-600 text-xl"></i>
							</div>
						</div>
					</div>
					<div class="p-4 text-center">
						<p class="text-sm text-gray-700 leading-relaxed">
							Hỗ trợ kết nối chủ nhà. Giúp bạn theo dõi hóa đơn, ký hợp đồng...
						</p>
					</div>
				</div>

				<!-- Program 4 -->
				<div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow cursor-pointer">
					<div class="h-36 bg-gradient-to-br from-orange-400 to-pink-500 flex items-center justify-center relative overflow-hidden">
						<div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-orange-500 opacity-80"></div>
						<div class="absolute top-2 right-2 text-white text-xs font-bold">NINH THUẬN TRAVELS</div>
						<div class="absolute bottom-2 left-2 text-white">
							<div class="text-lg font-bold">CHỈ VỚI 2.999k NGƯỜI</div>
							<div class="text-yellow-300 text-sm">TRẢI NGHIỆM NGAY!</div>
						</div>
						<div class="relative z-10 text-center">
							<i class="fas fa-ship text-white text-4xl mb-2"></i>
							<div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto">
								<i class="fas fa-mountain text-white text-2xl"></i>
							</div>
						</div>
					</div>
					<div class="p-4 text-center">
						<p class="text-sm text-gray-700 leading-relaxed">
							Tung vé xe Hót - Bùng sức Trẻ, tại Ninh Thuận chỉ với 2.999K/Người
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Cities Section -->
	<section class="py-4 bg-white rounded-md">
		<div class="container mx-auto px-4 sm:px-6 lg:px-8">
			<!-- Section Title -->
			<div class="flex items-center mb-4">
				<div class="w-1 h-5 rounded-md bg-green-500 mr-4"></div>
				<h2 class="text-lg font-bold text-gray-900">TÌM PHÒNG TRỌ THEO TỈNH / THÀNH PHỐ</h2>
			</div>

			<!-- Cities Grid -->
			<div class="grid md:grid-cols-2 lg:grid-cols-6 gap-6">
				<!-- Hồ Chí Minh -->
				<a href="<?= BASE_URL ?>/phong-tro-nha-tro?province=Thành phố Hồ Chí Minh" class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow cursor-pointer group">
					<div class="h-64 flex items-end relative overflow-hidden" style="background-image: url('<?= BASE_URL ?>/Public/images/ho-chi-minh.webp'); background-size: cover; background-position: center; background-repeat: no-repeat;">
						<div class="absolute top-4 left-4 w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
						<div class="absolute top-4 left-8 w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
						<div class="absolute top-4 left-12 w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
						<div class="relative z-10 p-4 text-white">
							<h3 class="text-xl font-bold mb-1">Hồ Chí Minh</h3>
							<p class="text-sm opacity-90">Phòng trọ Hồ Chí Minh</p>
						</div>
					</div>
				</a>

				<!-- Hà Nội -->
				<a href="<?= BASE_URL ?>/phong-tro-nha-tro?province=Thành phố Hà Nội" class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow cursor-pointer group">
					<div class="h-64 flex items-end relative overflow-hidden" style="background-image: url('<?= BASE_URL ?>/Public/images/ha-noi.webp'); background-size: cover; background-position: center; background-repeat: no-repeat;">
						<div class="absolute inset-0 bg-black bg-opacity-20"></div>
						<div class="absolute top-4 right-4 w-8 h-8 bg-white bg-opacity-20 rounded-full"></div>
						<div class="absolute bottom-8 left-4 w-6 h-6 bg-white bg-opacity-20 rounded-full"></div>
						<div class="relative z-10 p-4 text-white">
							<h3 class="text-xl font-bold mb-1">Hà Nội</h3>
							<p class="text-sm opacity-90">Phòng trọ Hà Nội</p>
						</div>
					</div>
				</a>

				<!-- Cần Thơ -->
				<a href="<?= BASE_URL ?>/phong-tro-nha-tro?province=Thành phồ Cần Thơ" class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow cursor-pointer group">
					<div class="h-64 flex items-end relative overflow-hidden" style="background-image: url('<?= BASE_URL ?>/Public/images/can-tho.webp'); background-size: cover; background-position: center; background-repeat: no-repeat;">
						<div class="absolute inset-0 bg-black bg-opacity-20"></div>
						<div class="absolute top-4 left-4 w-4 h-4 bg-white bg-opacity-30 rounded-full"></div>
						<div class="absolute top-8 left-8 w-3 h-3 bg-white bg-opacity-30 rounded-full"></div>
						<div class="absolute top-12 left-12 w-2 h-2 bg-white bg-opacity-30 rounded-full"></div>
						<div class="relative z-10 p-4 text-white">
							<h3 class="text-xl font-bold mb-1">Cần Thơ</h3>
							<p class="text-sm opacity-90">Phòng trọ Cần Thơ</p>
						</div>
					</div>
				</a>

				<!-- Bình Dương -->
				<a href="<?= BASE_URL ?>/phong-tro-nha-tro?province=Đồng Nai" class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow cursor-pointer group">
					<div class="h-64 flex items-end relative overflow-hidden" style="background-image: url('<?= BASE_URL ?>/Public/images/binh-duong.webp'); background-size: cover; background-position: center; background-repeat: no-repeat;">
						<div class="absolute inset-0 bg-black bg-opacity-20"></div>
						<div class="absolute top-4 right-4 w-6 h-6 bg-white bg-opacity-20 rounded"></div>
						<div class="absolute top-8 right-8 w-4 h-4 bg-white bg-opacity-20 rounded"></div>
						<div class="relative z-10 p-4 text-white">
							<h3 class="text-xl font-bold mb-1">Đồng Nai</h3>
							<p class="text-sm opacity-90">Phòng trọ Đồng Nai</p>
						</div>
					</div>
				</a>

				<!-- Đà Nẵng -->
				<a href="<?= BASE_URL ?>/phong-tro-nha-tro?province=Thành phố Đà Nẵng" class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow cursor-pointer group">
					<div class="h-64 flex items-end relative overflow-hidden" style="background-image: url('<?= BASE_URL ?>/Public/images/da-nang.webp'); background-size: cover; background-position: center; background-repeat: no-repeat;">
						<div class="absolute inset-0 bg-black bg-opacity-20"></div>
						<div class="absolute top-4 left-4 w-3 h-3 bg-yellow-300 rounded-full"></div>
						<div class="absolute top-6 left-6 w-2 h-2 bg-yellow-300 rounded-full"></div>
						<div class="absolute top-8 left-8 w-1 h-1 bg-yellow-300 rounded-full"></div>
						<div class="relative z-10 p-4 text-white">
							<h3 class="text-xl font-bold mb-1">Đà Nẵng</h3>
							<p class="text-sm opacity-90">Phòng trọ Đà Nẵng</p>
						</div>
					</div>
				</a>

				<!-- Đồng Nai -->
				<a href="<?= BASE_URL ?>/phong-tro-nha-tro?province=Đồng Tháp" class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow cursor-pointer group">
					<div class="h-64 flex items-end relative overflow-hidden" style="background-image: url('<?= BASE_URL ?>/Public/images/dong-nai.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
						<div class="absolute inset-0 bg-black bg-opacity-30"></div>
						<div class="absolute top-4 right-4 w-4 h-4 bg-blue-400 rounded-full"></div>
						<div class="absolute top-8 right-8 w-3 h-3 bg-blue-400 rounded-full"></div>
						<div class="absolute top-12 right-12 w-2 h-2 bg-blue-400 rounded-full"></div>
						<div class="relative z-10 p-4 text-white">
							<h3 class="text-xl font-bold mb-1">Đồng Tháp</h3>
							<p class="text-sm opacity-90">Phòng trọ Đồng Tháp</p>
						</div>
					</div>
				</a>
			</div>
		</div>
	</section>

	<!-- Hot Deal Section -->
	<section class="py-4 bg-white rounded-md">
		<div class="container mx-auto px-4 sm:px-6 lg:px-8">
			<!-- Section Header -->
			<div class="flex items-center justify-between mb-6">
				<div class="flex items-center">
					<div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center mr-3">
						<span class="text-white font-bold text-sm"><i class="fa fa-calendar-alt"></i></span>
					</div>
					<div class="w-1 h-6 bg-green-500 mr-4"></div>
					<div>
						<div class="flex items-center mb-1">
							<i class="fas fa-fire text-orange-500 text-lg mr-2"></i>
							<i class="fas fa-fire text-orange-500 text-lg mr-2"></i>
							<i class="fas fa-fire text-orange-500 text-lg mr-2"></i>
							<h2 class="text-lg font-bold text-red-600">KHUYẾN MÃI - HOTDEAL</h2>
						</div>
						<p class="text-sm text-gray-600">Độc quyền chỉ có tại HOSTY</p>
					</div>
				</div>
			</div>

			<!-- Property Cards Grid -->
			<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
				<!-- Property Card 1 -->
				<?php foreach ($rentalHotDeals as $rentalHotDeal) { ?>
					<a href="<?= BASE_URL ?>/rental-post/<?= \Helpers\CreateSlug::createSlug($rentalHotDeal['rental_post_title']) . '-' . $rentalHotDeal['id'] ?>" class="bg-white rounded-lg cursor-pointer shadow-md overflow-visible hover:shadow-lg transition-shadow">
						<!-- Image Area -->
						<div class="relative h-60 bg-gray-200 overflow-visible">
							<div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center">
								<img src="<?= json_decode($rentalHotDeal['images'])[0] ?>" alt="Post Image" class="w-full h-full object-cover rounded-lg">
							</div>
							<!-- Verified Badge -->
							<div class="absolute bottom-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs flex items-center">
								<i class="fas fa-check text-white mr-1"></i>
								Đã xác minh
							</div>
							<!-- Camera -->
							<div class="absolute top-2 right-4 bg-white bg-opacity-90 rounded-full w-8 h-8 flex items-center justify-center	">
								<i class="fas fa-camera text-gray-600"></i>
								<span class="absolute -top-1 -right-1 bg-red-500 text-white text-nowrap text-xs rounded-full w-4 h-4 flex items-center justify-center z-10"><?php echo count(json_decode($rentalHotDeal['images'])) ?></span>
							</div>
						</div>

						<!-- Content Area -->
						<div class="p-4">
							<h3 class="font-semibold text-gray-900 mb-2 text-sm leading-tight h-8">
								<?= $rentalHotDeal['rental_post_title'] ?>
							</h3>
							<div class="flex items-center text-sm text-gray-600 mb-3 text-nowrap overflow-hidden">
								<i class="fas fa-user text-gray-400 mr-2"></i>
								<span><?= $rentalHotDeal['contact'] ?> - <?= $rentalHotDeal['province'] ?> . <?= $rentalHotDeal['ward'] ?></span>
							</div>
							<div class="flex items-start justify-between flex-col">
								<div class="flex items-center gap-2">
									<span class="text-gray-400 line-through text-sm mr-2 <?= $rentalHotDeal['price_discount'] > 0 ? '' : 'hidden' ?>"><?= Format::forMatPrice($rentalHotDeal['price']) ?>₫</span>
									<span class="bg-red-500 text-white text-nowrap text-[9px] px-2 py-1 rounded <?= $rentalHotDeal['price_discount'] > 0 ? '' : 'hidden' ?>"><?= round(($rentalHotDeal['price'] - $rentalHotDeal['price_discount']) / $rentalHotDeal['price'] * 100) ?>% OFF</span>
								</div>
								<div class="text-right flex w-full items-center justify-between pt-1">
									<div class="text-[16px] font-bold text-red-600"><?= $rentalHotDeal['price_discount'] > 0 ? Format::forMatPrice($rentalHotDeal['price_discount']) :  Format::forMatPrice($rentalHotDeal['price']) ?>đ/tháng</div>
									<div class="text-sm text-gray-600 font-medium mr-3"><?= $rentalHotDeal['area'] ?> m²</div>
								</div>
							</div>
						</div>
					</a>
				<?php } ?>
			</div>
		</div>
	</section>

	<!-- Move-in Ready Section -->
	<section class="py-4 bg-white rounded-md">
		<div class="container mx-auto px-4 sm:px-6 lg:px-8">
			<!-- Section Header -->
			<div class="flex items-center mb-6">
				<div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center mr-3">
					<i class="fas fa-medal text-white"></i>
				</div>
				<div class="w-1 h-6 bg-green-500 mr-4"></div>
				<div>
					<div class="flex items-center mb-1">
						<i class="fas fa-home text-green-600 text-lg mr-2"></i>
						<i class="fas fa-home text-green-600 text-lg mr-2"></i>
						<i class="fas fa-home text-green-600 text-lg mr-2"></i>
						<h2 class="text-lg font-bold text-gray-900">PHÒNG DỌN VÀO Ở NGAY - <span class="text-green-600">NOW</span></h2>
					</div>
					<p class="text-sm text-gray-600">Bạn có thể thuê & vào ở ngay hôm nay</p>
				</div>
			</div>

			<!-- Property Cards Grid -->
			<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
				<?php foreach ($rentalStayNow as $rentalStayNow) { ?>
					<a href="<?= BASE_URL ?>/rental-post/<?= \Helpers\CreateSlug::createSlug($rentalStayNow['rental_post_title']) . '-' . $rentalStayNow['id'] ?>" class="bg-white rounded-lg cursor-pointer shadow-md overflow-visible hover:shadow-lg transition-shadow">
						<!-- Image Area -->
						<div class="relative h-60 bg-gray-200 overflow-visible">
							<div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center">
								<img src="<?= json_decode($rentalStayNow['images'])[0] ?>" alt="Post Image" class="w-full h-full object-cover rounded-lg">
								</img>
							</div>
							<!-- Verified Badge -->
							<div class="absolute bottom-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs flex items-center">
								<i class="fas fa-check text-white mr-1"></i>
								Đã xác minh
							</div>
							<!-- NOW Badge -->
							<div class="absolute bottom-2 right-2 bg-green-600 text-white px-2 py-1 rounded text-xs font-bold">
								NOW
							</div>
							<!-- Camera -->
							<div class="absolute top-2 right-4 bg-white bg-opacity-90 rounded-full w-8 h-8 flex items-center justify-center">
								<i class="fas fa-camera text-gray-600"></i>
								<span class="absolute -top-1 -right-1 bg-red-500 text-white text-nowrap text-xs rounded-full w-4 h-4 flex items-center justify-center z-10"><?= count(json_decode($rentalStayNow['images'])) ?></span>
							</div>
						</div>

						<!-- Content Area -->
						<div class="p-4">
							<h3 class="font-semibold text-gray-900 mb-2 text-sm leading-tight h-8">
								<?= $rentalStayNow['rental_post_title'] ?>
							</h3>
							<div class="flex items-center text-sm text-gray-600 mb-3 text-nowrap overflow-hidden">
								<i class="fas fa-user text-gray-400 mr-2"></i>
								<span><?= $rentalStayNow['contact'] ?> - <?= $rentalStayNow['province'] ?> . <?= $rentalStayNow['ward'] ?></span>
							</div>
							<div class="flex items-start justify-between flex-col">
								<div class="flex items-center gap-2">
									<span class="text-gray-400 line-through text-sm mr-2 <?= $rentalStayNow['price_discount'] > 0 ? '' : 'hidden' ?>"><?= Format::forMatPrice($rentalStayNow['price']) ?>₫</span>
									<span class="bg-red-500 text-white text-nowrap text-[9px] px-2 py-1 rounded <?= $rentalStayNow['price_discount'] > 0 ? '' : 'hidden' ?>"><?= round(($rentalStayNow['price'] - $rentalStayNow['price_discount']) / $rentalStayNow['price'] * 100) ?>% OFF</span>
								</div>
								<div class="text-right flex w-full items-center justify-between pt-1">
									<div class="text-[16px] font-bold text-red-600"><?= $rentalStayNow['price_discount'] > 0 ? Format::forMatPrice($rentalStayNow['price_discount']) :  Format::forMatPrice($rentalStayNow['price']) ?>đ/tháng</div>
									<div class="text-sm text-gray-600 font-medium mr-3"><?= $rentalStayNow['area'] ?> m²</div>
								</div>
							</div>
						</div>
					</a>
				<?php } ?>
			</div>
		</div>
	</section>

	<!-- Latest Rooms Section -->
	<section class="py-4 bg-white rounded-md">
		<div class="container mx-auto px-4 sm:px-6 lg:px-8">
			<!-- Section Header -->
			<div class="flex items-center mb-4">
				<div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
					<i class="fas fa-star text-white"></i>
				</div>
				<div class="w-1 h-5 rounded-md bg-green-500 mr-4"></div>
				<div>
					<h2 class="text-lg font-bold text-green-600">PHÒNG TRỌ - MỚI NHẤT</h2>
					<p class="text-sm text-gray-600">Phòng vừa được phê duyệt</p>
				</div>
			</div>

			<!-- Property Cards Grid - Horizontal Layout -->
			<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
				<?php foreach ($rentalNewPosts as $rentalNewPost) { ?>
					<a href="<?= BASE_URL ?>/rental-post/<?= \Helpers\CreateSlug::createSlug($rentalNewPost['rental_post_title']) . '-' . $rentalNewPost['id'] ?>" class="bg-white rounded-lg cursor-pointer shadow-md overflow-visible hover:shadow-lg transition-shadow flex">
						<!-- Image Area -->
						<div class="relative w-48 h-40 bg-gray-200 flex-shrink-0 overflow-visible">
							<div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center">
								<img src="<?= json_decode($rentalNewPost['images'])[0] ?>" alt="Post Image" class="w-full h-full object-cover rounded-lg">
							</div>
							<!-- Verified Badge -->
							<div class="absolute bottom-1 left-1 bg-green-500 text-white px-1 py-0.5 rounded text-[10px] flex items-center">
								<i class="fas fa-check text-white mr-1"></i>
								Đã xác minh
							</div>
							<!-- Camera -->
							<div class="absolute top-1 right-4 bg-white bg-opacity-90 rounded-full w-6 h-6 flex items-center justify-center">
								<i class="fas fa-camera text-gray-600 text-xs"></i>
								<span class="absolute -top-1 -right-1 bg-red-500 text-white text-nowrap text-[8px] rounded-full w-3 h-3 flex items-center justify-center z-10"><?= count(json_decode($rentalNewPost['images'])) ?></span>
							</div>
						</div>

						<!-- Content Area -->
						<div class="p-3 flex-1">
							<h3 class="font-semibold text-gray-900 mb-1 text-sm leading-tight h-10">
								<?= $rentalNewPost['rental_post_title'] ?>
							</h3>
							<div class="flex items-center text-xs text-gray-600 mb-2">
								<i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
								<span class="truncate"><?= $rentalNewPost['contact'] ?> - <?= $rentalNewPost['province'] ?> . <?= $rentalNewPost['ward'] ?></span>
							</div>
							<div class="flex items-center justify-between mb-2">
								<div class="flex items-start justify-between flex-col">
									<div class="flex items-center gap-2">
										<span class="text-gray-400 line-through text-sm mr-2 <?= $rentalNewPost['price_discount'] > 0 ? '' : 'hidden' ?>"><?= Format::forMatPrice($rentalNewPost['price']) ?>₫</span>
										<span class="bg-red-500 text-white text-nowrap text-[9px] px-2 py-1 rounded <?= $rentalNewPost['price_discount'] > 0 ? '' : 'hidden' ?>"><?= round(($rentalNewPost['price'] - $rentalNewPost['price_discount']) / $rentalNewPost['price'] * 100) ?>% OFF</span>
									</div>
									<div class="text-right flex w-full items-center justify-between pt-1">
										<div class="text-[16px] font-bold text-red-600"><?= $rentalNewPost['price_discount'] > 0 ? Format::forMatPrice($rentalNewPost['price_discount']) :  Format::forMatPrice($rentalNewPost['price']) ?>đ/tháng</div>
									</div>
								</div>
								<div class="text-xs text-gray-600 font-medium"><?= $rentalNewPost['area'] ?> m²</div>
							</div>
							<div class="flex items-center justify-between">
								<div class="flex items-center text-xs text-gray-500">
									<div class="w-4 h-4 bg-gray-300 rounded-full mr-1 flex items-center justify-center">
										<i class="fas fa-user text-gray-600 text-[8px]"></i>
									</div>
									<span><?= $rentalNewPost['contact'] ?></span>
									<span class="ml-1"></span>
								</div>
							</div>
						</div>
					</a>
				<?php } ?>
			</div>
		</div>
	</section>
</div>