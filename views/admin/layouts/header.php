<!--
    Author: Huy Nguyen
    Date: 2025-09-09
    Purpose: Header for admin
-->

<header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
    <div class="flex items-center justify-between">
        <!-- Left side - Mobile menu button and breadcrumb -->
        <div class="flex items-center space-x-4">
            <!-- Mobile menu button -->
            <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        
        <!-- Right side - Search, notifications, and user menu -->
        <div class="flex items-center space-x-4">
            <!-- Search -->
            <div class="hidden md:block relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" placeholder="Tìm kiếm..." 
                       class="block w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <!-- Notifications -->
            <div class="relative">
                <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-md relative">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
                </button>
                
                <!-- Notifications dropdown -->
                <div class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50 hidden" id="notifications-dropdown">
                    <div class="px-4 py-2 border-b border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900">Thông báo</h3>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-yellow-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">Có 5 bài đăng mới cần duyệt</p>
                                    <p class="text-xs text-gray-500">2 phút trước</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-user-plus text-green-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">3 tài khoản mới đăng ký</p>
                                    <p class="text-xs text-gray-500">10 phút trước</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-flag text-red-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">2 báo cáo vi phạm mới</p>
                                    <p class="text-xs text-gray-500">1 giờ trước</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="px-4 py-2 border-t border-gray-200">
                        <a href="<?= BASE_URL ?>/admin/notifications" class="text-sm text-blue-600 hover:text-blue-800">Xem tất cả</a>
                    </div>
                </div>
            </div>
            
            <!-- User menu -->
            <div class="relative">
                <button onclick="toggleUserMenu()" class="flex items-center space-x-3 p-2 rounded-md hover:bg-gray-100">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-medium text-gray-900">Admin</p>
                        <p class="text-xs text-gray-500">Quản trị viên</p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </button>
                
                <!-- User dropdown -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden" id="user-menu">
                    <div class="border-t border-gray-100"></div>
                    <a href="<?= BASE_URL ?>/admin/auth/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Toggle notifications dropdown
    document.querySelector('button[onclick="toggleSidebar()"]').addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Toggle notifications dropdown
    document.querySelector('.relative button').addEventListener('click', function(e) {
        e.stopPropagation();
        const dropdown = document.getElementById('notifications-dropdown');
        dropdown.classList.toggle('hidden');
    });
    
    // Toggle user menu
    function toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        menu.classList.toggle('hidden');
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        const notificationsDropdown = document.getElementById('notifications-dropdown');
        const userMenu = document.getElementById('user-menu');
        
        if (!e.target.closest('.relative')) {
            notificationsDropdown.classList.add('hidden');
            userMenu.classList.add('hidden');
        }
    });
</script>
