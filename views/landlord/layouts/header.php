<header class="bg-[#15A05C] shadow-lg">
    <nav class="container mx-auto px-4">
        <div class="flex items-center h-20">
            <!-- Logo Section -->
            <div class="flex items-center mr-8">
                <img src="../../Public/images/admin/Icon-lozido-white.jpg" 
                     alt="LOZIDO Logo" 
                     class="w-12 h-12 mr-3">
                <div class="text-white">
                    <div class="text-xl font-bold">LOZIDO</div>
                    <div class="bg-lozido-orange text-white text-xs px-2 py-1 rounded">
                        QUẢN LÝ NHÀ CHO THUÊ
                    </div>
                </div>
            </div>

            <!-- All Navigation Items -->
            <div class="flex items-center space-x-4">
                <!-- Quản lý nhà (House Management) - Active -->
                <a href="#" class="nav-item active flex flex-col items-center px-6 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded">
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
                <a href="#" class="nav-item flex flex-col items-center px-6 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded">
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

                <!-- Đăng xuất (Logout) -->
                <a href="#" class="nav-item flex flex-col items-center px-6 py-2 text-white hover:bg-white hover:bg-opacity-10 rounded">
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
