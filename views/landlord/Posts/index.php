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
                        <button id="openModalBtn" onclick="modalNewPost.showModal()" class="bg-green-500 hover:bg-green-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all">
                            <i class="fas fa-plus text-xl"></i>
                        </button>
                    </div>

                    <!-- Posts Table -->
                    <div id="postsTable" class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <!-- Table Header -->
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <div class="grid grid-cols-14 gap-4 items-center text-sm font-medium text-gray-600">
                                <div class="col-span-5">Tiêu đề</div>
                                <div class="col-span-2">Giá phòng</div>
                                <div class="col-span-1">Trạng thái</div>
                                <div class="col-span-2">Trạng thái duyệt</div>
                                <div class="col-span-2">Nguyên nhân từ chối</div>
                                <div class="col-span-2">Hành động</div>
                            </div>
                        </div>

                        <!-- Posts List -->
                        <div class="divide-y divide-gray-200">
                            <!-- Post Row 1 -->
                            <?php foreach ($rentalPosts as $rentalPost) { ?>
                                <div class="px-6 py-4 hover:bg-gray-50 transition-colors cursor-pointer rental-post-row" data-id="<?= $rentalPost['id'] ?>">
                                    <div class="grid grid-cols-14 gap-4 items-center">
                                        <!-- Title Column -->
                                        <div class="col-span-5 flex items-start space-x-4">
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
                                                <?= $rentalPost['rejection_reason'] ?: '-' ?>
                                            </span>
                                        </div>

                                        <!-- Actions Column -->
                                        <div class="col-span-2">
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

                            <!-- Pagination Footer -->
                            <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
                                <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                                    <div class="flex flex-1 justify-between sm:hidden">
                                        <?php if ($pagination['current_page'] > 1): ?>
                                            <a href="?page=<?= $pagination['current_page'] - 1 ?>" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Trước</a>
                                        <?php else: ?>
                                            <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-gray-100 px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">Trước</span>
                                        <?php endif; ?>

                                        <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                            <a href="?page=<?= $pagination['current_page'] + 1 ?>" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Sau</a>
                                        <?php else: ?>
                                            <span class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-gray-100 px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">Sau</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm text-gray-700">
                                                Hiển thị
                                                <span class="font-medium"><?= $pagination['showing_from'] ?></span>
                                                đến
                                                <span class="font-medium"><?= $pagination['showing_to'] ?></span>
                                                trong số
                                                <span class="font-medium"><?= $pagination['total_posts'] ?></span>
                                                tin đăng
                                            </p>
                                        </div>

                                        <div>
                                            <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-xs">
                                                <!-- Previous Button -->
                                                <?php if ($pagination['current_page'] > 1): ?>
                                                    <a href="?page=<?= $pagination['current_page'] - 1 ?>" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                                        <span class="sr-only">Trước</span>
                                                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                                            <path d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-300 ring-1 ring-inset ring-gray-300 cursor-not-allowed">
                                                        <span class="sr-only">Trước</span>
                                                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                                            <path d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                <?php endif; ?>

                                                <!-- Page Numbers -->
                                                <?php
                                                $start_page = max(1, $pagination['current_page'] - 2);
                                                $end_page = min($pagination['total_pages'], $pagination['current_page'] + 2);

                                                // Show first page if not in range
                                                if ($start_page > 1): ?>
                                                    <a href="?page=1" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">1</a>
                                                    <?php if ($start_page > 2): ?>
                                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                                                    <?php if ($i == $pagination['current_page']): ?>
                                                        <a href="#" aria-current="page" class="relative z-10 inline-flex items-center bg-green-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"><?= $i ?></a>
                                                    <?php else: ?>
                                                        <a href="?page=<?= $i ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"><?= $i ?></a>
                                                    <?php endif; ?>
                                                <?php endfor; ?>

                                                <!-- Show last page if not in range -->
                                                <?php if ($end_page < $pagination['total_pages']): ?>
                                                    <?php if ($end_page < $pagination['total_pages'] - 1): ?>
                                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                                                    <?php endif; ?>
                                                    <a href="?page=<?= $pagination['total_pages'] ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"><?= $pagination['total_pages'] ?></a>
                                                <?php endif; ?>

                                                <!-- Next Button -->
                                                <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                                    <a href="?page=<?= $pagination['current_page'] + 1 ?>" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                                        <span class="sr-only">Sau</span>
                                                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                                            <path d="M8.22 14.78a.75.75 0 0 1 0-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 1.06-1.06l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-300 ring-1 ring-inset ring-gray-300 cursor-not-allowed">
                                                        <span class="sr-only">Sau</span>
                                                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
                                                            <path d="M8.22 14.78a.75.75 0 0 1 0-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 1.06-1.06l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                <?php endif; ?>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    <!-- Post modal -->
     <?php include_once ROOT_PATH .'/views/partials/edit-post.php'; ?>
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

    <!-- Include posts.js -->
    <script src="<?= BASE_URL ?>/Public/js/posts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</body>

</html>