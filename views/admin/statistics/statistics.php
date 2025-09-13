<?php
$title = 'Thống kê';
$breadcrumbs = [
    ['title' => 'Dashboard', 'url' => '/admin'],
    ['title' => 'Thống kê']
];

ob_start();
?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Thống kê hệ thống</h1>
            <p class="mt-2 text-gray-600">Phân tích và báo cáo tổng quan về hệ thống</p>
        </div>
        <div class="flex space-x-3">
            <select class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="7">7 ngày qua</option>
                <option value="30" selected>30 ngày qua</option>
                <option value="90">90 ngày qua</option>
                <option value="365">1 năm qua</option>
            </select>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
                <i class="fas fa-download mr-2"></i>
                Xuất báo cáo
            </button>
        </div>
    </div>
</div>

<!-- Key Metrics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
                        <dt class="text-sm font-medium text-gray-500 truncate">Người dùng mới</dt>
                        <dd class="text-lg font-medium text-gray-900">+245</dd>
                        <dd class="text-sm text-green-600">+12% so với tháng trước</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

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
                        <dt class="text-sm font-medium text-gray-500 truncate">Bài đăng mới</dt>
                        <dd class="text-lg font-medium text-gray-900">+89</dd>
                        <dd class="text-sm text-green-600">+8% so với tháng trước</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

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
                        <dt class="text-sm font-medium text-gray-500 truncate">Doanh thu</dt>
                        <dd class="text-lg font-medium text-gray-900">12.5M VNĐ</dd>
                        <dd class="text-sm text-green-600">+15% so với tháng trước</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-eye text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Lượt xem</dt>
                        <dd class="text-lg font-medium text-gray-900">45.2K</dd>
                        <dd class="text-sm text-green-600">+22% so với tháng trước</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Revenue Chart -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Doanh thu theo tháng</h3>
        <canvas id="revenueChart" width="400" height="300"></canvas>
    </div>

    <!-- User Growth Chart -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Tăng trưởng người dùng</h3>
        <canvas id="userGrowthChart" width="400" height="300"></canvas>
    </div>
</div>

<!-- Additional Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Posts by Category -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Bài đăng theo loại nhà</h3>
        <canvas id="postsByCategoryChart" width="400" height="300"></canvas>
    </div>

    <!-- Posts by District -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Bài đăng theo quận</h3>
        <canvas id="postsByDistrictChart" width="400" height="300"></canvas>
    </div>
</div>

<!-- Detailed Statistics -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- User Statistics -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Thống kê người dùng</h3>
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Tổng người dùng</span>
                <span class="text-sm font-medium">1,234</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Chủ nhà</span>
                <span class="text-sm font-medium">456</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Người thuê</span>
                <span class="text-sm font-medium">778</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Tỷ lệ hoạt động</span>
                <span class="text-sm font-medium text-green-600">85%</span>
            </div>
        </div>
    </div>

    <!-- Post Statistics -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Thống kê bài đăng</h3>
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Tổng bài đăng</span>
                <span class="text-sm font-medium">567</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Đã duyệt</span>
                <span class="text-sm font-medium text-green-600">520</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Chờ duyệt</span>
                <span class="text-sm font-medium text-yellow-600">23</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Từ chối</span>
                <span class="text-sm font-medium text-red-600">24</span>
            </div>
        </div>
    </div>

    <!-- System Statistics -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Thống kê hệ thống</h3>
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Lượt truy cập hôm nay</span>
                <span class="text-sm font-medium">2,456</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Thời gian phản hồi</span>
                <span class="text-sm font-medium text-green-600">120ms</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Uptime</span>
                <span class="text-sm font-medium text-green-600">99.9%</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Báo cáo vi phạm</span>
                <span class="text-sm font-medium text-yellow-600">23</span>
            </div>
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
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Posts by Category Chart
    const postsByCategoryCtx = document.getElementById('postsByCategoryChart').getContext('2d');
    new Chart(postsByCategoryCtx, {
        type: 'doughnut',
        data: {
            labels: ['Căn hộ', 'Nhà riêng', 'Phòng trọ', 'Chung cư'],
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Posts by District Chart
    const postsByDistrictCtx = document.getElementById('postsByDistrictChart').getContext('2d');
    new Chart(postsByDistrictCtx, {
        type: 'bar',
        data: {
            labels: ['Q1', 'Q2', 'Q3', 'Q7', 'Q10', 'Q12'],
            datasets: [{
                label: 'Số bài đăng',
                data: [65, 45, 35, 55, 40, 30],
                backgroundColor: 'rgba(168, 85, 247, 0.8)',
                borderColor: 'rgb(168, 85, 247)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php
$content = ob_get_clean();
include 'layouts/app.php';
?>
