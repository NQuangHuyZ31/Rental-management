<!--
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Customer favorites page
-->

<!-- Navigation Tabs -->
<?= \Core\CSRF::getTokenField() ?>
<div class="mb-8">
    <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg w-fit">
        <button class="tab-button active px-6 py-3 rounded-md font-semibold text-sm transition-all duration-200 bg-white text-gray-900 shadow-sm" data-tab="posts">
            Tin đăng
        </button>
        <button class="tab-button px-6 py-3 rounded-md font-semibold text-sm transition-all duration-200 text-gray-600 hover:text-gray-900" data-tab="recruitment">
            Tin tuyển dụng
        </button>
    </div>
</div>

<!-- Bookmarks Content -->
<div id="posts-tab" class="tab-content">
    <!-- Bookmark Card -->
    <?php

    use Helpers\Format;

    if (count($posts) > 0) {
        foreach ($posts as $post) { ?>
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-6">
                <div class="flex">
                    <!-- Left Section - Image -->
                    <div class="w-80 h-64 relative flex-shrink-0">
                        <img src="<?= json_decode($post['images'])[0] ?>"
                            alt="Room Image" class="w-full h-full object-cover">

                        <!-- Verified Badge -->
                        <div class="absolute bottom-3 left-3 bg-green-500 text-white px-2 py-1 rounded text-xs flex items-center">
                            <i class="fas fa-check text-white mr-1"></i>
                            Đã xác minh
                        </div>

                        <!-- Photo Count Badge -->
                        <div class="absolute top-3 right-3 bg-white bg-opacity-90 rounded-full w-8 h-8 flex items-center justify-center">
                            <i class="fas fa-camera text-gray-600 text-sm"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center"><?= count(json_decode($post['images'])) ?></span>
                        </div>
                    </div>

                    <!-- Right Section - Details -->
                    <div class="flex-1 p-6">
                        <!-- Title -->
                        <h3 class="text-lg font-bold text-blue-600 hover:text-blue-800 mb-2 cursor-pointer">
                            <a href="<?= BASE_URL ?>/rental-post/<?= \Helpers\CreateSlug::createSlug($post['rental_post_title']) . '-' . $post['id'] ?>"><?= $post['rental_post_title'] ?></a>
                        </h3>

                        <!-- Address -->
                        <p class="text-sm text-gray-600 mb-2 flex items-center">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                            <?= $post['address'] ?>, <?= $post['ward'] ?>, <?= $post['province'] ?>
                        </p>

                        <!-- Price Section -->
                        <div class="flex items-center gap-2">
                            <?php if ($post['price_discount'] > 0) { ?>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-gray-400 line-through text-sm"><?= Format::forMatPrice($post['price']) ?>₫</span>
                                    <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full"><?= round(($post['price'] - $post['price_discount']) / $post['price'] * 100) ?>% OFF</span>
                                </div>
                            <?php } ?>
                            <div class="text-lg font-bold text-red-600">
                                <?= $post['price_discount'] > 0 ? Format::forMatPrice($post['price_discount']) : Format::forMatPrice($post['price']) ?> đ/tháng
                            </div>
                        </div>

                        <!-- Poster Info -->
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-gray-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900"><?= $post['contact'] ?></p>
                                <?php
                                $date = new DateTime($post['created_at']);
                                $now = new DateTime();
                                $interval = $date->diff($now);
                                $dateDiff = '';

                                if ($interval->y > 0) {
                                    $dateDiff .= $interval->y . ' ' . 'năm';
                                } elseif ($interval->m > 0) {
                                    $dateDiff .= $interval->m . ' ' . 'tháng';
                                } elseif ($interval->d > 0) {
                                    $dateDiff .= $interval->d . ' ' . 'ngày';
                                } else {
                                    $dateDiff .= '1 ngày';
                                }
                                ?>
                                <p class="text-xs text-gray-500"><?= $dateDiff . ' trước' ?></p>
                            </div>
                        </div>

                        <!-- Specifications -->
                        <div class="flex items-center gap-6 text-sm text-gray-600 mb-6">
                            <span class="flex items-center">
                                <i class="fas fa-expand-arrows-alt mr-1"></i>
                                <?= $post['area'] ?> m²
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-tint mr-1"></i>
                                <?= Format::formatNumber($post['water_fee']) ?>₫/Khối
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-bolt mr-1"></i>
                                <?= Format::formatNumber($post['electric_fee']) ?>₫/Kw
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button onclick="deleteInterestPost('<?= $post['id'] ?>')" class="bg-red-100 hover:bg-red-200 text-red-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                                <i class="fas fa-trash mr-2"></i>
                                Bỏ lưu trữ
                            </button>
                            <button onclick="window.open('https://zalo.me/<?= $post['phone'] ?>', '_blank')" class="bg-blue-100 hover:bg-blue-200 text-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                                <i class="fab fa-zalo mr-2"></i>
                                Zalo
                            </button>
                            <button onclick="this.innerText = '<?= $post['phone'] ?>'" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                                <i class="fas fa-phone mr-2"></i>
                                Xem SĐT
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    } else { ?>
        <!-- Recruitment Tab Content -->
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-house text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có bài đăng nào</h3>
            <p class="text-gray-600 mb-6">Bạn chưa lưu tin đăng nào. Hãy tìm kiếm và lưu những bài đăng bạn quan tâm.</p>
            <a href="<?= BASE_URL ?>/phong-tro-nha-tro" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                <i class="fas fa-search mr-2"></i>
                Tìm phòng ngay
            </a>
        </div>
    <?php } ?>

    <!-- Pagination -->
    <?php if (!empty($pagination) && $pagination['total_pages'] > 1) : ?>
        <div class="mt-8">
            <?= \Helpers\Pagination::render($pagination, '', []) ?>
        </div>
    <?php endif; ?>
</div>

<!-- Recruitment Tab Content -->
<div id="recruitment-tab" class="tab-content hidden">
    <div class="text-center py-12">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-briefcase text-gray-400 text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có tin tuyển dụng</h3>
        <p class="text-gray-600 mb-6">Bạn chưa lưu tin tuyển dụng nào. Hãy tìm kiếm và lưu những công việc bạn quan tâm.</p>
        <a href="<?= BASE_URL ?>/" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
            <i class="fas fa-search mr-2"></i>
            Tìm việc ngay
        </a>
    </div>
</div>

<!-- Empty State (when no favorites) -->
<div id="emptyState" class="hidden text-center py-12">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-heart text-gray-400 text-3xl"></i>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có phòng yêu thích</h3>
    <p class="text-gray-600 mb-6">Bạn chưa lưu phòng nào. Hãy tìm kiếm và lưu những phòng bạn quan tâm.</p>
    <a href="' . BASE_URL . '/" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
        <i class="fas fa-search mr-2"></i>
        Tìm phòng ngay
    </a>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');

                // Remove active class from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('active', 'bg-white', 'text-gray-900', 'shadow-sm');
                    btn.classList.add('text-gray-600');
                });

                // Add active class to clicked button
                this.classList.add('active', 'bg-white', 'text-gray-900', 'shadow-sm');
                this.classList.remove('text-gray-600');

                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Show target tab content
                const targetContent = document.getElementById(targetTab + '-tab');
                if (targetContent) {
                    targetContent.classList.remove('hidden');
                }
            });
        });
    });
</script>