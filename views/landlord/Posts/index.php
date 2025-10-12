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
    <!-- Modal New Post -->
    <dialog id="modalNewPost" class="modal">
        <div class="modal-box w-11/12 max-w-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 modalNewPost-button-close">✕</button>
            </form>
            <input type="hidden" name="post_id" value="">
            <form id="formNewPost">
                <?= \Core\CSRF::getTokenField() ?>

                <!-- Modal Header with Icon -->
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-building text-green-600 text-lg"></i>
                    </div>
                    <h3 id="modalNewPost-title" class="text-xl font-semibold text-gray-900">Thêm tin đăng</h3>
                </div>

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
                        <div class="alert alert-info">
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
                        <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Mô tả chi tiết về căn phòng/nhà cho thuê..."></textarea>
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

                    <!-- Form Actions -->
                    <div class="modal-action">
                        <button type="button" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2 addNewPostBtn">
                            <i class="fas fa-save"></i>
                            Tạo tin đăng
                        </button>
                    </div>
            </form>
        </div>
    </dialog>
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