<!-- 
    Author: Huy Nguyen
    Date: 2025-09-09
    Purpose: Index for admin
-->

<!-- Welcome Section -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Chào mừng trở lại, Admin!</h1>
    <p class="mt-2 text-gray-600">Đây là tổng quan về hệ thống quản lý cho thuê nhà của bạn.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Tổng người dùng</dt>
                        <dd class="text-lg font-medium text-gray-900">1,234</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="<?= BASE_URL ?>/admin/users" class="font-medium text-blue-600 hover:text-blue-500">Xem chi tiết</a>
            </div>
        </div>
    </div>

    <!-- Total Posts -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-home text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Tổng bài đăng</dt>
                        <dd class="text-lg font-medium text-gray-900">567</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="<?= BASE_URL ?>/admin/posts" class="font-medium text-green-600 hover:text-green-500">Xem chi tiết</a>
            </div>
        </div>
    </div>

    <!-- Pending Posts -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Chờ duyệt</dt>
                        <dd class="text-lg font-medium text-gray-900">23</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="<?= BASE_URL ?>/admin/posts/pending" class="font-medium text-yellow-600 hover:text-yellow-500">Xem chi tiết</a>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Doanh thu tháng</dt>
                        <dd class="text-lg font-medium text-gray-900">12.5M VNĐ</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="<?= BASE_URL ?>/admin/transactions" class="font-medium text-purple-600 hover:text-purple-500">Xem chi tiết</a>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Revenue Chart -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Doanh thu theo tháng</h3>
        <canvas id="revenueChart" width="400" height="200"></canvas>
    </div>

    <!-- User Growth Chart -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Tăng trưởng người dùng</h3>
        <canvas id="userGrowthChart" width="400" height="200"></canvas>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Posts -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Bài đăng gần đây</h3>
        </div>
        <div class="divide-y divide-gray-200">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Nhà cho thuê tại Quận 1</p>
                        <p class="text-sm text-gray-500">Chủ nhà: Nguyễn Văn A</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Chờ duyệt
                        </span>
                        <button class="text-blue-600 hover:text-blue-500">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Căn hộ cao cấp Quận 7</p>
                        <p class="text-sm text-gray-500">Chủ nhà: Trần Thị B</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Đã duyệt
                        </span>
                        <button class="text-blue-600 hover:text-blue-500">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Nhà trọ sinh viên Quận 10</p>
                        <p class="text-sm text-gray-500">Chủ nhà: Lê Văn C</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Từ chối
                        </span>
                        <button class="text-blue-600 hover:text-blue-500">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            <a href="<?= BASE_URL ?>/admin/posts" class="text-sm font-medium text-blue-600 hover:text-blue-500">Xem tất cả bài đăng</a>
        </div>
    </div>

    <!-- Recent Reports -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Báo cáo gần đây</h3>
        </div>
        <div class="divide-y divide-gray-200">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Báo cáo spam</p>
                        <p class="text-sm text-gray-500">Người báo cáo: user123</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Chờ xử lý
                        </span>
                        <button class="text-blue-600 hover:text-blue-500">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Thông tin sai lệch</p>
                        <p class="text-sm text-gray-500">Người báo cáo: user456</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Đã xử lý
                        </span>
                        <button class="text-blue-600 hover:text-blue-500">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Vi phạm quy định</p>
                        <p class="text-sm text-gray-500">Người báo cáo: user789</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Đang xử lý
                        </span>
                        <button class="text-blue-600 hover:text-blue-500">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            <a href="<?= BASE_URL ?>/admin/reports" class="text-sm font-medium text-blue-600 hover:text-blue-500">Xem tất cả báo cáo</a>
        </div>
    </div>
</div>

<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: [8.5, 9.2, 10.1, 11.3, 12.0, 12.5],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + 'M';
                        }
                    }
                }
            }
        }
    });

    // User Growth Chart
    const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(userGrowthCtx, {
        type: 'bar',
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
            datasets: [{
                label: 'Người dùng mới',
                data: [120, 150, 180, 200, 220, 250],
                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>