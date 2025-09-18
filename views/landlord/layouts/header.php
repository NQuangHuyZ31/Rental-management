<!--
Author: Nguyen Xuan Duong
Date: 2025-08-29
Purpose: Build Header for Landlord Layout
-->
<header class="bg-[#15A05C] shadow-lg">
    <nav class="max-w-screen-xl container mx-auto px-4">
        <div class="flex items-center h-24">
            <!-- Logo Section -->
            <div class="flex items-center mr-8">
                <div>
                    <img src="<?= BASE_URL ?>/Public/images/admin/hosty-removebg.png" 
                         alt="HOSTY Logo" 
                         class="h-20 w-35">
                </div>
            </div>

            <!-- All Navigation Items -->
            <div class="flex items-center space-x-4"></div>
                <!-- Quản lý nhà (House Management) - Active -->
                <a href="<?= BASE_URL ?>/landlord" class="nav-item active flex flex-col items-center px-6 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded">
                    <i class="fas fa-home text-lg mb-1"></i>
                    <span class="text-sm whitespace-nowrap">Quản lý nhà</span>
                </a>

                <!-- Tổng báo cáo (General Report) -->
                <a href="#" class="nav-item flex flex-col items-center px-6 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded">
                    <i class="fas fa-chart-pie text-lg mb-1"></i>
                    <span class="text-sm whitespace-nowrap">Tổng báo cáo</span>
                </a>

                <!-- Khách chuyển khoản (Customer Transfer) -->
                <a href="#" class="nav-item flex flex-col items-center px-6 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded">
                    <i class="fas fa-dollar-sign text-lg mb-1"></i>
                    <span class="text-sm whitespace-nowrap">Khách chuyển khoản</span>
                </a>

                <!-- Đăng tin (Post News) -->
                <a href="<?= BASE_URL ?>/landlord/post-news" class="nav-item flex flex-col items-center px-6 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded">
                    <i class="fas fa-plus text-lg mb-1"></i>
                    <span class="text-sm whitespace-nowrap">Đăng tin</span>
                </a>

                <!-- Thông báo (Notifications) -->
                <button class="nav-item flex flex-col items-center px-6 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded">
                    <i class="fas fa-bell text-lg mb-1"></i>
                    <span class="text-sm whitespace-nowrap">Thông báo</span>
                </button>

                <!-- Tài khoản (Account) -->
                <a href="#" class="nav-item flex flex-col items-center px-6 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded">
                    <i class="fas fa-user text-lg mb-1"></i>
                    <span class="text-sm whitespace-nowrap">Tài khoản</span>
                </a>

                <!-- Cài đặt chung (General Settings) -->
                <a href="<?= BASE_URL ?>/landlord/setting/payment" class="nav-item flex flex-col items-center px-6 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded">
                    <i class="fas fa-cog text-lg mb-1"></i>
                    <span class="text-sm whitespace-nowrap">Cài đặt chung</span>
                </a>

                <!-- Đăng xuất (Logout) -->
                <a href="<?= BASE_URL ?>/logout" class="nav-item flex flex-col items-center px-6 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded">
                    <i class="fas fa-sign-out-alt text-lg mb-1"></i>
                    <span class="text-sm whitespace-nowrap">Đăng xuất</span>
                </a>
            </div>
        </div>
    </nav>
</header>

<script>
// Add active class management
document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Remove active class from all items
            navItems.forEach(nav => nav.classList.remove('active'));
            // Add active class to clicked item
            this.classList.add('active');
        });
    });
});
</script>
