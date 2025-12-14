<?php

use Helpers\DataModelHelper;

$dataModelHelper = new DataModelHelper();
?>
<!-- 
    Author: Huy Nguyen
    Date: 2025-09-09
    Purpose: Sidebar for admin
-->

<aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform sidebar-transition">
    <div class="flex items-center justify-center h-16 px-4 bg-blue-600">
        <h1 class="text-xl font-bold text-white">Admin Panel</h1>
    </div>

    <nav class="mt-5 px-2">
        <div class="space-y-1">
            <!-- Dashboard -->
            <a href="<?= BASE_URL ?>/admin/dashboard" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md <?= (basename($_SERVER['REQUEST_URI']) == 'admin/dashboard' || $_SERVER['REQUEST_URI'] == '/admin/dashboard') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
                <i class="fas fa-tachometer-alt mr-3 flex-shrink-0 h-6 w-6"></i>
                Dashboard
            </a>

            <!-- Quản lý tài khoản -->
            <a href="<?= BASE_URL ?>/admin/users" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                <i class="fas fa-users mr-3 flex-shrink-0 h-6 w-6"></i>
                Quản lý tài khoản
            </a>

            <!-- Quản lý bài đăng -->
            <!-- <div class="space-y-1"> -->
            <!-- <button onclick="toggleSubmenu('posts-menu')" class="group w-full flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                    <i class="fas fa-newspaper mr-3 flex-shrink-0 h-6 w-6"></i>
                    Quản lý bài đăng
                    <i class="fas fa-chevron-down ml-auto flex-shrink-0 h-4 w-4" id="posts-chevron"></i>
                </button> -->
            <!-- <div id="posts-menu" class="hidden space-y-1 ml-8"> -->
            <a href="<?= BASE_URL ?>/admin/posts" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                <i class="fas fa-list mr-3 flex-shrink-0 h-4 w-4"></i>
                Quản lý bài đăng
                <span class="ml-auto bg-orange-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded-full <?= htmlspecialchars($dataModelHelper->getRentalPostStatus('pending')) > 0 ? '' : 'hidden'  ?> ?>"><?= htmlspecialchars($dataModelHelper->getRentalPostStatus('pending'), ENT_QUOTES, 'UTF-8') ?></span>
            </a>
            <!-- <a href="<?= BASE_URL ?>/admin/posts/pending" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-clock mr-3 flex-shrink-0 h-4 w-4"></i>
                        Chờ duyệt
                        <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded-full"><?= htmlspecialchars($dataModelHelper->getRentalPostStatus('pending'), ENT_QUOTES, 'UTF-8') ?></span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/posts/approved" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-check mr-3 flex-shrink-0 h-4 w-4"></i>
                        Đã duyệt
                    </a>
                    <a href="<?= BASE_URL ?>/admin/posts/rejected" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-times mr-3 flex-shrink-0 h-4 w-4"></i>
                        Từ chối
                    </a> -->
            <!-- </div> -->
            <!-- </div> -->

            <!-- Quản lý báo cáo -->
            <a href="<?= BASE_URL ?>/admin/reports" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <i class="fas fa-flag mr-3 flex-shrink-0 h-6 w-6"></i>
                Báo cáo vi phạm
                <span class="ml-auto bg-red-100 text-orange-800 text-xs font-medium px-2 py-0.5 rounded-full <?= $dataModelHelper->getReportCountByStatus('pending') > 0 ? '' : 'hidden'  ?>"><?= htmlspecialchars($dataModelHelper->getReportCountByStatus('pending'), ENT_QUOTES, 'UTF-8') ?></span>
            </a>

            <!-- Hỗ trợ khách hàng -->
            <a href="<?= BASE_URL ?>/admin/customer-supports" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <i class="fas fa-headset mr-3 flex-shrink-0 h-6 w-6"></i>
                Hỗ trợ khách hàng
                <span class="ml-auto bg-yellow-200 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded-full <?= $dataModelHelper->getCustomerSupportCountNotProcessed() > 0 ? '' : 'hidden'  ?>"><?= htmlspecialchars($dataModelHelper->getCustomerSupportCountNotProcessed(), ENT_QUOTES, 'UTF-8') ?></span>
            </a>

            <!-- Quản lý giao dịch -->
            <a href="<?= BASE_URL ?>/admin/transactions" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <i class="fas fa-credit-card mr-3 flex-shrink-0 h-6 w-6"></i>
                Giao dịch
            </a>

            <!-- Quản lý danh mục -->
            <div class="space-y-1">
                <button onclick="toggleSubmenu('categories-menu')" class="group w-full flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                    <i class="fas fa-tags mr-3 flex-shrink-0 h-6 w-6"></i>
                    Danh mục
                    <i class="fas fa-chevron-down ml-auto flex-shrink-0 h-4 w-4" id="categories-chevron"></i>
                </button>
                <div id="categories-menu" class="hidden space-y-1 ml-8">
                    <a href="<?= BASE_URL ?>/admin/categories" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-list mr-3 flex-shrink-0 h-4 w-4"></i>
                        Loại nhà
                    </a>
                    <a href="<?= BASE_URL ?>/admin/amenities" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-star mr-3 flex-shrink-0 h-4 w-4"></i>
                        Tiện ích
                    </a>
                </div>
            </div>

            <!-- Cài đặt hệ thống -->
            <!-- <div class="space-y-1">
                <button onclick="toggleSubmenu('settings-menu')" class="group w-full flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                    <i class="fas fa-cog mr-3 flex-shrink-0 h-6 w-6"></i>
                    Cài đặt
                    <i class="fas fa-chevron-down ml-auto flex-shrink-0 h-4 w-4" id="settings-chevron"></i>
                </button>
                <div id="settings-menu" class="hidden space-y-1 ml-8">
                    <a href="<?= BASE_URL ?>/admin/settings/general" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-sliders-h mr-3 flex-shrink-0 h-4 w-4"></i>
                        Cài đặt chung
                    </a>
                    <a href="<?= BASE_URL ?>/admin/settings/email" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-envelope mr-3 flex-shrink-0 h-4 w-4"></i>
                        Email
                    </a>
                    <a href="<?= BASE_URL ?>/admin/settings/payment" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-credit-card mr-3 flex-shrink-0 h-4 w-4"></i>
                        Thanh toán
                    </a>
                </div>
            </div> -->
        </div>
    </nav>

    <!-- User info at bottom -->
    <div class="absolute bottom-0 w-full p-4 border-t border-gray-200">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-white"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">Admin User</p>
                <p class="text-xs text-gray-500">admin@example.com</p>
            </div>
        </div>
    </div>
</aside>

<script>
    function toggleSubmenu(menuId) {
        const menu = document.getElementById(menuId);
        const chevron = document.getElementById(menuId.replace('-menu', '-chevron'));

        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            chevron.classList.add('rotate-180');
        } else {
            menu.classList.add('hidden');
            chevron.classList.remove('rotate-180');
        }
    }
</script>