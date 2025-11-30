<!-- 
	Author: Huy Nguyen
	Date: 2025-09-05
	Purpose: Build Posts Index
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOSTY - Quản lý bài đăng</title>
    <!-- Include Libraries -->
    <?php

    use Helpers\Format;

    include VIEW_PATH . '/landlord/layouts/app.php'; ?>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <?php include VIEW_PATH . '/landlord/layouts/header.php'; ?>
    <!-- Main Content -->
    <main class="min-h-screen bg-gray-100 w-full">
        <input type="hidden" name="role" value="landlord">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Tin đăng cho thuê</h1>
                        <p class="text-gray-600">Tất cả tin đăng cho thuê</p>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="bg-white rounded-lg shadow-sm mb-6">
                <div class="border-b border-gray-200">
                    <nav class="flex">
                        <button class="bg-green-500 text-white px-6 py-3 rounded-tl-lg font-medium flex items-center gap-2">
                            <i class="fas fa-home"></i>
                            Tin đăng cho thuê
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Posts List Section -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-2">Danh sách tin đăng</h2>
                            <p class="text-gray-600">Danh sách tin đăng tìm kiếm khách thuê</p>
                        </div>
                        <button data-modal-target="default-modal" id="openModalBtn" data-modal-toggle="default-modal" class="bg-green-500 hover:bg-green-600 text-white w-11 h-11 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all" type="button">
                            <i class="fas fa-plus text-2xl"></i>
                        </button>
                    </div>

                    <!-- Posts Table -->
                    <div id="postsTable" class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <!-- Table Header -->
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <div class="grid grid-cols-12 gap-4 items-center text-sm font-medium text-gray-600">
                                <div class="col-span-4">Tiêu đề</div>
                                <div class="col-span-2">Giá phòng</div>
                                <div class="col-span-1">Trạng thái</div>
                                <div class="col-span-2">Trạng thái duyệt</div>
                                <div class="col-span-2">Nguyên nhân từ chối</div>
                                <div class="col-span-1">Hành động</div>
                            </div>
                        </div>

                        <!-- Posts List -->
                        <div class="divide-y divide-gray-200">
                            <!-- Post Row 1 -->
                            <?php foreach ($rentalPosts as $rentalPost) { ?>
                                <div class="px-6 py-4 hover:bg-gray-50 transition-colors cursor-pointer rental-post-row" data-id="<?= $rentalPost['id'] ?>">
                                    <div class="grid grid-cols-12 gap-4 items-center">
                                        <!-- Title Column -->
                                        <div class="col-span-4 flex items-start space-x-4">
                                            <img src="<?= json_decode($rentalPost['images'])[0] ?>" alt="Post Image" class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-blue-600 mb-1">#<?= $rentalPost['id'] ?>: <?= $rentalPost['rental_post_title'] ?></div>
                                                <div class="text-xs text-gray-500 mb-2"><?= $rentalPost['address'] . ', ' . $rentalPost['ward'] . ', ' . $rentalPost['province'] ?></div>
                                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                                    <div class="flex items-center space-x-1">
                                                        <i class="fas fa-calendar"></i>
                                                        <span>Ngày vào ở</span>
                                                    </div>
                                                    <div class="flex items-center space-x-1">
                                                        <i class="fas fa-calendar-plus"></i>
                                                        <span>Ngày đăng</span>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-4 text-xs mt-1">
                                                    <span><?= date('d/m/Y', strtotime($rentalPost['stay_start_date'])) ?></span>
                                                    <span><?= date('d/m/Y', strtotime($rentalPost['created_at'])) ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Price Column -->
                                        <div class="col-span-2">
                                            <div class="flex flex-col">
                                                <?php if ($rentalPost['price_discount'] > 0) { ?>
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="text-gray-400 line-through text-sm"><?= Format::forMatPrice($rentalPost['price']) ?>₫</span>
                                                        <span class="bg-red-500 text-white text-[9px] px-2 py-0.5 rounded-full"><?= round(($rentalPost['price'] - $rentalPost['price_discount']) / $rentalPost['price'] * 100) ?>% OFF</span>
                                                    </div>
                                                <?php } ?>
                                                <div class="text-sm font-bold text-red-600">
                                                    <?= $rentalPost['price_discount'] > 0 ? Format::forMatPrice($rentalPost['price_discount']) : Format::forMatPrice($rentalPost['price']) ?> đ/tháng
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Status Column -->
                                        <div class="col-span-1">
                                            <?php
                                            $statusClass = 'bg-gray-100 text-gray-800';
                                            switch ($rentalPost['status']) {
                                                case 'active':
                                                    $statusClass = 'bg-green-100 text-green-800';
                                                    break;
                                                case 'inactive':
                                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                                    break;
                                            }
                                            ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusClass ?>">
                                                <?= $rentalPost['status'] ?>
                                            </span>
                                        </div>

                                        <!-- Approval Status Column -->
                                        <div class="col-span-2">
                                            <?php
                                            $approvalClass = 'bg-gray-100 text-gray-800';
                                            switch ($rentalPost['approval_status']) {
                                                case 'pending':
                                                    $approvalClass = 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                case 'approved':
                                                    $approvalClass = 'bg-green-100 text-green-800';
                                                    break;
                                                case 'rejected':
                                                    $approvalClass = 'bg-red-100 text-red-800';
                                                    break;
                                            }
                                            ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $approvalClass ?>">
                                                <?= $rentalPost['approval_status'] ?>
                                            </span>
                                        </div>

                                        <!-- Rejection Reason Column -->
                                        <div class="col-span-2">
                                            <span class="text-sm <?= $rentalPost['rejection_reason'] ? 'text-red-600' : 'text-gray-500' ?>">
                                                <?= $rentalPost['approval_reason'] ?: '-' ?>
                                            </span>
                                        </div>

                                        <!-- Actions Column -->
                                        <div class="col-span-1">
                                            <div class="relative inline-block">
                                                <button class="p-2 rounded-full hover:bg-gray-100 transition-colors" onclick="toggleActionMenu(this)">
                                                    <i class="fas fa-ellipsis-v text-gray-400"></i>
                                                </button>
                                                <div class="hidden absolute right-0 top-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                                                    <div class="py-1">
                                                        <div onclick="viewPost(<?= $rentalPost['id'] ?>)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                            <i class="fas fa-eye mr-2"></i>Xem chi tiết
                                                        </div>
                                                        <?php if ($rentalPost['status'] == 'active'): ?>
                                                            <div onclick="hidePost(<?= $rentalPost['id'] ?>, 'inactive')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                <i class="fas fa-eye-slash mr-2"></i>Ẩn tin
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if ($rentalPost['status'] == 'inactive'): ?>
                                                            <div onclick="hidePost(<?= $rentalPost['id'] ?>, 'active')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                <i class="fas fa-eye-slash mr-2"></i>Hiện tin
                                                            </div>
                                                        <?php endif; ?>
                                                        <div onclick="deletePost(<?= $rentalPost['id'] ?>)" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                            <i class="fas fa-trash mr-2"></i>Xóa
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- Pagination -->
                            <?php if (!empty($pagination) && $pagination['total_pages'] > 1) : ?>
                                <div class="mt-8">
                                    <?= \Helpers\Pagination::render($pagination, '', $queryParams) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    <!-- Post modal -->
    <?php include_once ROOT_PATH . '/views/partials/edit-post.php'; ?>
    <!-- Footer -->
    <?php include VIEW_PATH . '/landlord/layouts/footer.php'; ?>

    <!-- JavaScript for Table Actions -->
    <script>
        // Toggle action menu dropdown
        function toggleActionMenu(button) {
            const dropdown = button.nextElementSibling;
            const allDropdowns = document.querySelectorAll('.absolute.right-0.mt-2');

            // Close all other dropdowns
            allDropdowns.forEach(dd => {
                if (dd !== dropdown) {
                    dd.classList.add('hidden');
                }
            });

            // Toggle current dropdown
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const isButton = event.target.closest('button[onclick*="toggleActionMenu"]');
            const isDropdown = event.target.closest('.absolute.right-0.mt-2');

            if (!isButton && !isDropdown) {
                const allDropdowns = document.querySelectorAll('.absolute.right-0.mt-2');
                allDropdowns.forEach(dd => dd.classList.add('hidden'));
            }
        });
    </script>
    <!-- Include index.js -->
    <script src="<?= BASE_URL ?>/Public/js/index.js"></script>
    <!-- Include posts.js -->
    <script src="<?= BASE_URL ?>/Public/js/posts.js"></script>
</body>

</html>