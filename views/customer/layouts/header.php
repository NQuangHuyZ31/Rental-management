<!--
    Author: Huy Nguyen
    Date: 2025-09-01
    Purpose: Header for customer layout - LOZIDO style
-->
<?php

use Core\Session;

$modelDataHelper = new \Helpers\DataModelHelper();
?>
<header class="w-full fixed top-0 left-0 right-0 z-50">
    <!-- Warning Banner -->
    <div class="bg-yellow-200 text-black py-2 px-4">
        <div class="container mx-auto flex items-center justify-center">
            <i class="fas fa-shield-check text-green-600 mr-2"></i>
            <span class="text-sm font-medium">
                HOSTY chỉ cung cấp dịch vụ & chương trình trên các trang chính thức. Hãy cảnh giác với các hình thức liên hệ dưới tên HOSTY!
            </span>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <div class="bg-green-600 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-2">
                <!-- Logo Section -->
                <a href="<?= BASE_URL ?>/" class="flex items-center">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center mr-2">
                            <span class="text-green-600 font-bold text-lg"><img class="w-20 h-14" src="<?= BASE_URL ?>/Public/images/admin/hosty-removebg.png" alt="HOSTY Logo"></span>
                        </div>
                        <div class="text-[12px]">
                            <h1 class="text-base font-bold text-white">HOSTY</h1>
                            <div class="bg-orange-500 text-white text-[9px] px-2 py-1 rounded-full inline-block">
                                TÌM TRỌ - CĂN HỘ
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Center Navigation -->
                <nav class="hidden lg:flex items-center space-x-2" id="main-nav">
                    <a href="<?= BASE_URL . '/phong-tro-nha-tro' ?>" class="nav-item text-white bg-green-500 px-3 py-2 rounded-lg flex gap-2 text-nowrap items-center transition-colors" data-nav="home">
                        <i class="fas fa-home"></i>
                        <span class="text-[12px]">Tìm trọ, căn hộ</span>
                    </a>
                    <a href="<?= BASE_URL ?>/tim-viec" class="nav-item text-white hover:bg-green-700 px-3 py-2 rounded-lg flex gap-2 text-nowrap items-center transition-colors" data-nav="jobs">
                        <i class="fas fa-briefcase"></i>
                        <span class="text-[12px]">Tìm việc làm</span>
                    </a>
                    <a href="<?= BASE_URL ?>/hosty-plus" class="nav-item text-white hover:bg-green-700 px-3 py-2 rounded-lg flex gap-2 text-nowrap items-center transition-colors" data-nav="plus">
                        <i class="fas fa-plus"></i>
                        <span class="text-[12px]">HOSTY Plus+</span>
                    </a>
                    <a href="<?= BASE_URL ?>/ho-tro" class="nav-item text-white hover:bg-green-700 px-3 py-2 rounded-lg flex gap-2 text-nowrap items-center transition-colors" data-nav="recruitment">
                        <i class="fas fa-question-circle"></i>
                        <span class="text-[12px]">Hỗ trợ</span>
                    </a>
                    <a href="<?= BASE_URL ?>/gioi-thieu" class="nav-item text-white hover:bg-green-700 px-3 py-2 rounded-lg flex gap-2 text-nowrap items-center transition-colors" data-nav="about">
                        <i class="fas fa-info-circle"></i>
                        <span class="text-[12px]">Giới thiệu</span>
                    </a>
                </nav>

                <!-- Right Side Actions -->
                <div class="flex items-center space-x-3">
                    <!-- Bookmark with notification -->
                    <div class="relative">
                        <a href="<?= BASE_URL ?>/customer/interests" class="w-10 h-10 bg-green-600 hover:bg-green-700 rounded-full flex items-center justify-center transition-colors">
                            <i class="fas fa-bookmark"></i>
                        </a>
                        <span class="allPostInterest absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"><?= htmlspecialchars($modelDataHelper->countPostInterestById(), ENT_QUOTES, 'UTF-8') ?></span>
                    </div>

                    <!-- Tenant/Job Seeker Button -->
                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-lg">
                        <div class="text-xs flex text-nowrap gap-2 items-center">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-user text-[16px]"></i>
                            </div>
                            <?php if (\Core\Session::has('user') && \Core\Session::get('user')['role'] == '3') { ?>
                                <div class="text-xs text-nowrap flex flex-col flex-start">
                                    <div class="font-medium text-[9px]">Khách thuê, tìm việc</div>
                                    <div class="text-xs text-nowrap flex gap-2 items-center underline">
                                        <a href="<?php echo BASE_URL ?>/customer/profile" class="hover:text-green-900">Xin chào, <?php echo htmlspecialchars(\Core\Session::get('user')['username'], ENT_QUOTES, 'UTF-8') ?>!</a> |
                                        <a href="<?php echo BASE_URL ?>/logout" class="hover:text-green-900">Đăng xuất</a>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="text-xs text-nowrap flex flex-col flex-start">
                                    <div class="font-medium text-[9px]">Khách thuê, tìm việc</div>
                                    <div class="text-xs text-nowrap flex gap-2 items-center underline">
                                        <a href="<?php echo BASE_URL ?>/login?type=customer" class="hover:text-green-900">Đăng nhập</a> |
                                        <a href="<?php echo BASE_URL ?>/register" class="hover:text-green-900">Đăng ký</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Landlord Button -->
                    <?php if (!Session::has('user') || (Session::has('user') && Session::get('user')['role'] == '2')) { ?>
                        <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-lg">
                            <a href="<?= BASE_URL ?><?= Session::has('user') ? '/landlord/post-news' : '/login?type=landlord' ?>" class="text-xs flex text-nowrap gap-2 items-center">
                                <div class="flex items-center justify-center text-nowrap">
                                    <i class="fas fa-file-alt text-[16px]"></i>
                                    <i class="fas fa-plus text-yellow-500 ml-1 text-xs"></i>
                                </div>
                                <div class="flex flex-col flex-start">
                                    <div class="font-medium text-[9px]">Chủ nhà</div>
                                    <div class="text-xs text-nowrap">Đăng tin & Lấp phòng trống</div>
                                </div>
                            </a>
                        </div>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Sub Navigation Bar -->
    <?php if ($subNav) { ?>
        <div class="bg-white border-b border-gray-200">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-center gap-10 py-2 overflow-x-auto" id="sub-nav">
                    <a href="<?= BASE_URL . '/phong-tro-nha-tro' ?>" class="sub-nav-item flex items-center text-gray-700 px-3 py-2 rounded-lg space-x-2 hover:text-green-600 transition-colors whitespace-nowrap" data-sub-nav="room">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-home text-gray-600"></i>
                        </div>
                        <span class="text-sm">Phòng trọ, nhà trọ</span>
                    </a>
                    <a href="<?= BASE_URL . '/ky-tuc-xa-sleepbox' ?>" class="sub-nav-item flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-700 hover:text-green-600 transition-colors whitespace-nowrap" data-sub-nav="dormitory">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-bed text-gray-600"></i>
                        </div>
                        <span class="text-sm">Ký túc xá, sleepbox</span>
                    </a>
                    <a href="<?= BASE_URL . '/nha-cho-thue' ?>" class="sub-nav-item flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-700 hover:text-green-600 transition-colors whitespace-nowrap" data-sub-nav="house">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-home text-gray-600"></i>
                        </div>
                        <span class="text-sm">Nhà cho thuê</span>
                    </a>
                    <a href="<?= BASE_URL . '/can-ho-chung-cu' ?>" class="sub-nav-item flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-700 hover:text-green-600 transition-colors whitespace-nowrap" data-sub-nav="apartment">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-building text-gray-600"></i>
                        </div>
                        <span class="text-sm">Căn hộ chung cư</span>
                    </a>
                    <a href="<?= BASE_URL . '/van-phong' ?>" class="sub-nav-item flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-700 hover:text-green-600 transition-colors whitespace-nowrap" data-sub-nav="office">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-briefcase text-gray-600"></i>
                        </div>
                        <span class="text-sm">Văn phòng</span>
                    </a>
                    <a href="<?= BASE_URL . '/o-ghep-pass-phong' ?>" class="sub-nav-item flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-700 hover:text-green-600 transition-colors whitespace-nowrap" data-sub-nav="roommate">
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-gray-600"></i>
                        </div>
                        <span class="text-sm font-medium">Ở ghép & pass phòng</span>
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>
</header>

<!-- Header Spacer to prevent content from being hidden behind fixed header -->
<div class="h-32"></div>