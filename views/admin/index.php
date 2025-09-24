<!-- 
    Author: Huy Nguyen
    Date: 2025-09-09
    Purpose: Index for admin
-->

<!-- Welcome Section -->
<div class="p-3">
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
                            <dd class="text-lg font-medium text-gray-900"><?= $countUsers ?></dd>
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
                            <dd class="text-lg font-medium text-gray-900"><?= $countPost ?></dd>
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
                            <dd class="text-lg font-medium text-gray-900"><?= $countPostPending ?></dd>
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
        <!-- <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Đã từ chối</dt>
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
    </div> -->
    </div>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="<?= BASE_URL ?>/Public/js/custom-chart.js"></script>
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <?php foreach ($chartData['header'] as $chart) : ?>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4"><?= $chart['label'] ?></h3>
                <div id="<?= $chart['name'] ?>" style="height: 300px;">
                    <?php if (empty($chartData['data'][$chart['name']])) : ?>
                        <div class="text-center text-gray-500 py-8">Không có dữ liệu để hiển thị</div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($chartData['data'][$chart['name']])) : ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            CustomChart.renderChart('<?= $chart['name'] ?>', <?php echo json_encode($chartData['data'][$chart['name']]); ?>);
                        });
                    </script>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Posts -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Bài đăng gần đây</h3>
            </div>
            <div class="divide-y divide-gray-200">
                <?php foreach ($allPostCurrent as $post) : ?>
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 gap-2">
                            <p class="text-sm font-medium text-gray-900"><?= $post['rental_post_title'] ?></p>
                            <p class="text-sm text-gray-500">Người liên hệ: <?= $post['contact'] ?></p>
                        </div>
                        <div class="flex flex-col space-x-2">
                            <span class="items-center px-2.5 py-0.5 w-fit rounded-full text-xs font-medium bg-<?= $post['approval_status'] == 'pending' ? 'yellow-100 text-yellow-800' : 'green-100 text-green-800' ?>">
                                <?= $post['approval_status'] ?>
                            </span>
                            <p class="text-[12px] text-gray-500">Ngày đăng: <?= date('d/m/Y', strtotime($post['created_at'])) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                <a href="<?= BASE_URL ?>/admin/posts" class="text-sm font-medium text-blue-600 hover:text-blue-500">Xem tất cả bài đăng</a>
            </div>
        </div>
    </div>
</div>