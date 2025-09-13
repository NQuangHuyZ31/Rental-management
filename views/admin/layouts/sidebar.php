<!-- 
    Author: Huy Nguyen
    Date: 2025-09-09
    Purpose: Sidebar for admin
-->
    
<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform sidebar-transition">
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
            <div class="space-y-1">
                <button onclick="toggleSubmenu('users-menu')" class="group w-full flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                    <i class="fas fa-users mr-3 flex-shrink-0 h-6 w-6"></i>
                    Quản lý tài khoản
                    <i class="fas fa-chevron-down ml-auto flex-shrink-0 h-4 w-4" id="users-chevron"></i>
                </button>
                <div id="users-menu" class="hidden space-y-1 ml-8">
                    <a href="<?= BASE_URL ?>/admin/users" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-list mr-3 flex-shrink-0 h-4 w-4"></i>
                        Danh sách người dùng
                    </a>
                    <a href="<?= BASE_URL ?>/admin/users/landlords" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-home mr-3 flex-shrink-0 h-4 w-4"></i>
                        Chủ nhà
                    </a>
                    <a href="<?= BASE_URL ?>/admin/users/tenants" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-user mr-3 flex-shrink-0 h-4 w-4"></i>
                        Người thuê
                    </a>
                    <a href="<?= BASE_URL ?>/admin/users/admins" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-user-shield mr-3 flex-shrink-0 h-4 w-4"></i>
                        Quản trị viên
                    </a>
                </div>
            </div>
            
            <!-- Quản lý bài đăng -->
            <div class="space-y-1">
                <button onclick="toggleSubmenu('posts-menu')" class="group w-full flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                    <i class="fas fa-newspaper mr-3 flex-shrink-0 h-6 w-6"></i>
                    Quản lý bài đăng
                    <i class="fas fa-chevron-down ml-auto flex-shrink-0 h-4 w-4" id="posts-chevron"></i>
                </button>
                <div id="posts-menu" class="hidden space-y-1 ml-8">
                    <a href="<?= BASE_URL ?>/admin/posts" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-list mr-3 flex-shrink-0 h-4 w-4"></i>
                        Tất cả bài đăng
                    </a>
                    <a href="<?= BASE_URL ?>/admin/posts/pending" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-clock mr-3 flex-shrink-0 h-4 w-4"></i>
                        Chờ duyệt
                        <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded-full"><?= $pendingPost ?></span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/posts/approved" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-check mr-3 flex-shrink-0 h-4 w-4"></i>
                        Đã duyệt
                    </a>
                    <a href="<?= BASE_URL ?>/admin/posts/rejected" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-times mr-3 flex-shrink-0 h-4 w-4"></i>
                        Từ chối
                    </a>
                </div>
            </div>
            
            <!-- Quản lý báo cáo -->
            <div class="space-y-1">
                <button onclick="toggleSubmenu('reports-menu')" class="group w-full flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                    <i class="fas fa-flag mr-3 flex-shrink-0 h-6 w-6"></i>
                    Báo cáo vi phạm
                    <i class="fas fa-chevron-down ml-auto flex-shrink-0 h-4 w-4" id="reports-chevron"></i>
                </button>
                <div id="reports-menu" class="hidden space-y-1 ml-8">
                    <a href="<?= BASE_URL ?>/admin/reports" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-list mr-3 flex-shrink-0 h-4 w-4"></i>
                        Tất cả báo cáo
                    </a>
                    <a href="<?= BASE_URL ?>/admin/reports/pending" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-clock mr-3 flex-shrink-0 h-4 w-4"></i>
                        Chờ xử lý
                        <span class="ml-auto bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded-full">2</span>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/reports/resolved" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-check mr-3 flex-shrink-0 h-4 w-4"></i>
                        Đã xử lý
                    </a>
                </div>
            </div>
            
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
                    <a href="<?= BASE_URL ?>/admin/locations" class="group flex items-center px-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900">
                        <i class="fas fa-map-marker-alt mr-3 flex-shrink-0 h-4 w-4"></i>
                        Khu vực
                    </a>
                </div>
            </div>
            
            <!-- Thống kê -->
            <a href="<?= BASE_URL ?>/admin/statistics" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <i class="fas fa-chart-bar mr-3 flex-shrink-0 h-6 w-6"></i>
                Thống kê
            </a>
            
            <!-- Cài đặt hệ thống -->
            <div class="space-y-1">
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
            </div>
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
