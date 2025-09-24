<!-- 
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Customer sidebar navigation
-->

<!-- Sidebar -->
<aside id="sidebar" class="w-70 bg-white shadow-lg border-r border-gray-200 sidebar-transition sidebar-hidden lg:sidebar-visible z-30 flex-shrink-0 h-full overflow-y-auto overflow-x-hidden mr-3">
    <div class="p-4">
        <!-- Navigation Menu -->
        <nav class="space-y-2">
            <!-- Profile Management -->
            <a href="<?= BASE_URL ?>/customer/profile" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors <?= (strpos($_SERVER['REQUEST_URI'], '/customer/profile') !== false) ? 'bg-green-50 text-green-600 border-r-2 border-green-500' : '' ?>">
                <i class="fas fa-user-edit text-lg"></i>
                <span class="font-medium">Thông tin cá nhân</span>
            </a>

            <!-- Rented Rooms -->
            <a href="<?= BASE_URL ?>/customer/rented-rooms" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors <?= (strpos($_SERVER['REQUEST_URI'], '/customer/rented-rooms') !== false) ? 'bg-green-50 text-green-600 border-r-2 border-green-500' : '' ?>">
                <i class="fas fa-home text-lg"></i>
                <span class="font-medium">Phòng đang thuê</span>
                <span class="ml-auto bg-green-500 text-white text-xs px-2 py-1 rounded-full <?= $sidebarData['room'] > 0 ? 'block' : 'hidden' ?>"><?= $sidebarData['room'] ?></span>
            </a>

            <!-- Bills -->
            <a href="<?= BASE_URL ?>/customer/bills" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors <?= (strpos($_SERVER['REQUEST_URI'], '/customer/bills') !== false) ? 'bg-green-50 text-green-600 border-r-2 border-green-500' : '' ?>">
                <i class="fas fa-file-invoice-dollar text-lg"></i>
                <span class="font-medium">Hóa đơn</span>
                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full <?= $sidebarData['invoicePending'] > 0 ? 'block' : 'hidden' ?>"><?= $sidebarData['invoicePending'] ?></span>
            </a>

            <!-- Notifications -->
            <a href="<?= BASE_URL ?>/customer/payment-history" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors <?= (strpos($_SERVER['REQUEST_URI'], '/customer/payment-history') !== false) ? 'bg-green-50 text-green-600 border-r-2 border-green-500' : '' ?>">
                <i class="fas fa-history text-lg"></i>
                <span class="font-medium">Lịch sử thanh toán</span>
            </a>

            <!-- Favorites -->
            <a href="<?= BASE_URL ?>/customer/interests" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors <?= (strpos($_SERVER['REQUEST_URI'], '/customer/interests') !== false) ? 'bg-green-50 text-green-600 border-r-2 border-green-500' : '' ?>">
                <i class="fas fa-heart text-lg"></i>
                <span class="font-medium">Quan tâm</span>
            </a>

            <!-- Settings -->
            <a href="<?= BASE_URL ?>/customer/settings" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors <?= (strpos($_SERVER['REQUEST_URI'], '/customer/settings') !== false) ? 'bg-green-50 text-green-600 border-r-2 border-green-500' : '' ?>">
                <i class="fas fa-cog text-lg"></i>
                <span class="font-medium">Cài đặt</span>
            </a>

            <!-- Help & Support -->
            <a href="<?= BASE_URL ?>/customer/support" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors <?= (strpos($_SERVER['REQUEST_URI'], '/customer/support') !== false) ? 'bg-green-50 text-green-600 border-r-2 border-green-500' : '' ?>">
                <i class="fas fa-question-circle text-lg"></i>
                <span class="font-medium">Hỗ trợ</span>
            </a>
        </nav>
    </div>
</aside>
<!-- Sidebar JavaScript -->
<script>
    // Sidebar toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (sidebarToggle && sidebar && sidebarOverlay) {
            // Toggle sidebar
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('sidebar-hidden');
                sidebar.classList.toggle('sidebar-visible');
                sidebarOverlay.classList.toggle('hidden');
            });

            // Close sidebar when clicking overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.add('sidebar-hidden');
                sidebar.classList.remove('sidebar-visible');
                sidebarOverlay.classList.add('hidden');
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('sidebar-hidden');
                    sidebar.classList.add('sidebar-visible');
                    sidebarOverlay.classList.add('hidden');
                } else {
                    sidebar.classList.add('sidebar-hidden');
                    sidebar.classList.remove('sidebar-visible');
                }
            });
        }
    });
</script>