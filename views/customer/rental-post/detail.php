<!--
    Author: Huy Nguyen
    Date: 2025-01-15
    Purpose: Rental post detail page
-->
<?php

use Core\CSRF;
use Core\Session;
use Helpers\Format;

$post = isset($post) ? $post : [];
$images = isset($post['images']) ? json_decode($post['images'], true) : [];
?>

<div class="min-h-screen bg-gray-50 mt-4">
    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
    <?= CSRF::getTokenField() ?>
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Image Gallery -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="relative">
                        <div class="aspect-[4/3] bg-gray-100">
                            <?php if (!empty($images)) { ?>
                                <img id="mainImage" src="<?= $images[0] ?>" alt="Property Image" class="w-full h-full object-cover">
                            <?php } else { ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-6xl"></i>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Image Navigation -->
                        <?php if (count($images) > 1) { ?>
                            <button id="prevImage" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg transition-all">
                                <i class="fas fa-chevron-left text-gray-700"></i>
                            </button>
                            <button id="nextImage" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg transition-all">
                                <i class="fas fa-chevron-right text-gray-700"></i>
                            </button>
                        <?php } ?>

                        <!-- Image Counter -->
                        <?php if (!empty($images)) { ?>
                            <div class="absolute bottom-4 right-4 bg-black/70 text-white text-sm px-3 py-1 rounded-full">
                                <span id="currentImage">1</span>/<?= count($images) ?> hình ảnh
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Thumbnail Gallery -->
                    <?php if (count($images) > 1) { ?>
                        <div class="p-4 border-t border-gray-200">
                            <div class="flex gap-2 overflow-x-auto">
                                <?php foreach ($images as $index => $image) { ?>
                                    <button class="thumbnail-btn flex-shrink-0 w-20 h-16 rounded-lg overflow-hidden border-2 border-transparent hover:border-green-500 transition-all <?= $index === 0 ? 'border-green-500' : '' ?>" data-index="<?= $index ?>">
                                        <img src="<?= $image ?>" alt="Thumbnail <?= $index + 1 ?>" class="w-full h-full object-cover">
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- Property Information -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <!-- Title and Price -->
                    <div class="mb-4">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2"><?= $post['house_id'] > 0 ? htmlspecialchars($post['house_name'], ENT_QUOTES, 'UTF-8') . ' - ' . htmlspecialchars($post['rental_post_title'], ENT_QUOTES, 'UTF-8') : htmlspecialchars($post['rental_post_title'], ENT_QUOTES, 'UTF-8') ?></h1>
                        <div class="flex items-center gap-2 text-gray-600 mb-3">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                            <span><?= htmlspecialchars($post['address'] . '-' . $post['ward'] . '-' . $post['province']) ?></span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-lg font-bold text-red-600"><?= $post['price_discount'] > 0 ? Format::forMatPrice($post['price_discount']) : Format::forMatPrice($post['price']) ?>đ/tháng</div>
                            <span class="text-gray-400 line-through text-[16px] <?= $post['price_discount'] > 0 ? '' : 'hidden' ?>"><?= Format::forMatPrice($post['price']) ?>₫</span>
                        </div>
                    </div>

                    <!-- Key Information Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600">Tiền cọc</div>
                                <div class="font-semibold text-gray-900"><?= !empty($post['rental_deposit']) ? \Helpers\Format::forMatPrice($post['rental_deposit']) : \Helpers\Format::forMatPrice($post['price']) ?> đ</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-expand-arrows-alt text-green-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600">Diện tích</div>
                                <div class="font-semibold text-gray-900"><?= $post['area'] ?> m²</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-bolt text-yellow-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600">Tiền điện</div>
                                <div class="font-semibold text-gray-900"><?= \Helpers\Format::forMatPrice($post['electric_fee']) ?> đ/Kw</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tint text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600">Tiền nước</div>
                                <div class="font-semibold text-gray-900"><?= \Helpers\Format::forMatPrice($post['water_fee']) ?> đ/Khối</div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-3">Thông tin cơ bản</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Chuyên mục:</span>
                                        <span class="text-gray-900"><?= $category ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tình trạng:</span>
                                        <span class="text-green-600">Đang cho thuê</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Giờ giấc:</span>
                                        <span class="text-gray-900"><?= ($post['rental_open_time'] == 'all' && $post['rental_close_time'] == 'all') ? 'tự do' : $post['rental_open_time'] . ' a.m - ' . $post['rental_close_time'] . ' p.m' ?></span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="font-semibold text-gray-900 mb-3">Thông tin bổ sung</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Ngày vào ở:</span>
                                        <span class="text-gray-900"><?= date('d/m/Y', strtotime($post['stay_start_date'])) ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Kiểm duyệt:</span>
                                        <span class="text-green-600">Đã phê duyệt</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tối đa người ở:</span>
                                        <span class="text-gray-900"><?= $post['max_number_of_people'] ?> người</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <div class="w-1 h-6 bg-green-500 rounded"></div>
                            THÔNG TIN MÔ TẢ
                        </h3>
                    </div>

                    <div class="prose max-w-none">
                        <div class="text-gray-700 leading-relaxed">
                            <?= nl2br(htmlspecialchars($post['description'])) ?>
                        </div>
                    </div>
                </div>

                <!-- Amenities -->
                <?php if (!empty($post['rental_amenities'])) { ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tiện ích</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php
                            $amenities = json_decode($post['rental_amenities'], true);
                            foreach ($amentity as $item) { ?>
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-check text-green-500"></i>
                                    <span class="text-gray-700"><?= htmlspecialchars($item['rental_amenity_name']) ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <!-- Same address -->
                <?php if (count($sameAddressPosts) > 0) { ?>
                    <div class="bg-white rounded-md shadow-sm border border-gray-200 p-3">
                        <h3 class="text-sm font-semibold text-gray-900 pb-2 uppercase border-b"><?= $category ?> cùng địa chỉ</h3>
                        <div class="mt-2">
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- Property Card 1 -->
                                <?php foreach ($sameAddressPosts as $sameAddressPost) { ?>
                                    <a href="<?= BASE_URL ?>/rental-post/<?= \Helpers\CreateSlug::createSlug($sameAddressPost['rental_post_title']) . '-' . $sameAddressPost['id'] ?>" class="bg-white rounded-lg cursor-pointer shadow-md overflow-visible hover:shadow-lg transition-shadow">
                                        <!-- Image Area -->
                                        <div class="relative h-60 bg-gray-200 overflow-visible">
                                            <div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center">
                                                <img src="<?= json_decode($sameAddressPost['images'])[0] ?>" alt="Post Image" class="w-full h-full object-cover rounded-lg">
                                            </div>
                                            <!-- Verified Badge -->
                                            <div class="absolute bottom-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs flex items-center">
                                                <i class="fas fa-check text-white mr-1"></i>
                                                Đã xác minh
                                            </div>
                                            <!-- Camera -->
                                            <div class="absolute top-2 right-4 bg-white bg-opacity-90 rounded-full w-8 h-8 flex items-center justify-center	">
                                                <i class="fas fa-camera text-gray-600"></i>
                                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-nowrap text-xs rounded-full w-4 h-4 flex items-center justify-center z-10"><?php echo count(json_decode($sameAddressPost['images'])) ?></span>
                                            </div>
                                        </div>

                                        <!-- Content Area -->
                                        <div class="p-4">
                                            <h3 class="font-semibold text-gray-900 mb-2 text-sm leading-tight h-8">
                                                <?= $sameAddressPost['rental_post_title'] ?>
                                            </h3>
                                            <div class="flex items-center text-sm text-gray-600 mb-3 text-nowrap overflow-hidden">
                                                <i class="fas fa-user text-gray-400 mr-2"></i>
                                                <span><?= $sameAddressPost['contact'] ?> - <?= $sameAddressPost['province'] ?> . <?= $sameAddressPost['ward'] ?></span>
                                            </div>
                                            <div class="flex items-start justify-between flex-col">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-gray-400 line-through text-sm mr-2 <?= $sameAddressPost['price_discount'] > 0 ? '' : 'hidden' ?>"><?= Format::forMatPrice($sameAddressPost['price']) ?>₫</span>
                                                    <span class="bg-red-500 text-white text-nowrap text-[9px] px-2 py-1 rounded <?= $sameAddressPost['price_discount'] > 0 ? '' : 'hidden' ?>"><?= round(($sameAddressPost['price'] - $sameAddressPost['price_discount']) / $sameAddressPost['price'] * 100) ?>% OFF</span>
                                                </div>
                                                <div class="text-right flex w-full items-center justify-between pt-1">
                                                    <div class="text-[16px] font-bold text-red-600"><?= $sameAddressPost['price_discount'] > 0 ? Format::forMatPrice($sameAddressPost['price_discount']) : Format::forMatPrice($sameAddressPost['price']) ?>đ/tháng</div>
                                                    <div class="text-sm text-gray-600 font-medium mr-3"><?= $sameAddressPost['area'] ?> m²</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Contact Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-6">
                    <!-- Profile Section -->
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900"><?= htmlspecialchars($post['contact']) ?></h3>
                        <div class="flex items-center justify-center gap-1 text-green-600 text-sm mt-1">
                            <i class="fas fa-check-circle"></i>
                            <span>Đã được chứng thực</span>
                        </div>
                    </div>

                    <!-- Contact Buttons -->
                    <div class="space-y-3 mb-6">
                        <button onclick="window.open('https://zalo.me/<?= $post['phone'] ?>', '_blank')" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-comments"></i>
                            Nhắn tin Zalo
                        </button>

                        <button id="showPhoneNumber" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-phone"></i>
                            Xem số điện thoại
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-2 mb-6">
                        <button id="addPostInterest" class="w-full bg-blue-50 hover:bg-blue-100 text-blue-700 py-2 px-4 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-thumbs-up"></i>
                            Quan tâm tin
                        </button>

                        <button id="reportModal" data-modal-target="reportViolationModal" data-modal-toggle="reportViolationModal" class="w-full bg-red-50 hover:bg-red-100 text-red-700 py-2 px-4 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            Báo cáo tin đăng
                        </button>
                    </div>

                    <!-- Feedback Message -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-sm text-yellow-800">
                            Vui lòng cho chúng tôi biết nếu thông tin không chính xác. Chúng tôi sẽ xác minh và xử lý kịp thời. Cảm ơn bạn!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal report violation -->
    <?php include_once ROOT_PATH . '/views/partials/report-violation-modal.php'; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showPhoneNumberBtn = document.getElementById('showPhoneNumber');
        const numberPhone = '<?= $post['phone'] ?>';

        showPhoneNumberBtn.addEventListener('click', function() {
            showPhoneNumberBtn.innerText = numberPhone;
        })

        const images = <?= json_encode($images) ?>;
        let currentImageIndex = 0;

        if (images.length <= 1) return;

        const mainImage = document.getElementById('mainImage');
        const currentImageSpan = document.getElementById('currentImage');
        const prevBtn = document.getElementById('prevImage');
        const nextBtn = document.getElementById('nextImage');
        const thumbnailBtns = document.querySelectorAll('.thumbnail-btn');

        function updateImage(index) {
            mainImage.src = images[index];
            currentImageSpan.textContent = index + 1;

            // Update thumbnail selection
            thumbnailBtns.forEach((btn, i) => {
                btn.classList.toggle('border-green-500', i === index);
                btn.classList.toggle('border-transparent', i !== index);
            });
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            updateImage(currentImageIndex);
        }

        function prevImage() {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            updateImage(currentImageIndex);
        }

        // Event listeners
        nextBtn.addEventListener('click', nextImage);
        prevBtn.addEventListener('click', prevImage);

        thumbnailBtns.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                currentImageIndex = index;
                updateImage(currentImageIndex);
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'ArrowRight') nextImage();
        });
    });
</script>