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
                            <dd class="text-lg font-medium text-gray-900"><?= htmlspecialchars($countUsers, ENT_QUOTES, 'UTF-8') ?></dd>
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
                            <dd class="text-lg font-medium text-gray-900"><?= htmlspecialchars($countPost, ENT_QUOTES, 'UTF-8') ?></dd>
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
                            <dd class="text-lg font-medium text-gray-900"><?= htmlspecialchars($countPostPending, ENT_QUOTES, 'UTF-8') ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="<?= BASE_URL ?>/admin/posts?approval_status=pending" class="font-medium text-yellow-600 hover:text-yellow-500">Xem chi tiết</a>
                </div>
            </div>
        </div>

        <!-- Total transaction in month -->
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Tổng giao dịch trong tháng</dt>
                            <dd class="text-lg font-medium text-gray-900"><?= htmlspecialchars($countTransaction, ENT_QUOTES, 'UTF-8') ?></dd>
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
                <?php if (!empty($allPostCurrent)) : ?>
                    <?php foreach ($allPostCurrent as $post) : ?>
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 gap-2">
                                    <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars($post['rental_post_title'], ENT_QUOTES, 'UTF-8') ?></p>
                                    <p class="text-sm text-gray-500">Người liên hệ: <?= htmlspecialchars($post['contact'], ENT_QUOTES, 'UTF-8') ?></p>
                                </div>
                                <?php
                                $colorbg = '';
                                if ($post['approval_status'] == 'pending') {
                                    $colorbg = 'yellow-100 text-yellow-800';
                                } else if ($post['approval_status'] == 'approved') {
                                    $colorbg = 'green-100 text-green-800';
                                } else {
                                    $colorbg = 'red-100 text-red-800';
                                }

                                ?>
                                <div class="flex flex-col space-x-2">
                                    <span class="items-center px-2.5 py-0.5 w-fit rounded-full text-xs font-medium bg-<?= $colorbg ?>">
                                        <?= htmlspecialchars(\Config\MappingData::mapStatus($post['approval_status']), ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                    <p class="text-[12px] text-gray-500">Ngày đăng: <?= date('d/m/Y', strtotime($post['created_at'])) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="px-6 py-6 text-center text-gray-500">Không có báo cáo mới</div>
                <?php endif; ?>
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                    <a href="<?= BASE_URL ?>/admin/posts" class="text-sm font-medium text-blue-600 hover:text-blue-500">Xem tất cả bài đăng</a>
                </div>
            </div>
        </div>
        <!-- Recent Reports -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Báo cáo gần đây</h3>
            </div>
            <div class="divide-y divide-gray-200">
                <?php if (!empty($allReportCurrent)) : ?>
                    <?php foreach ($allReportCurrent as $report) : ?>
                        <?php
                        $textColor = '';

                        if ($report['status'] == 'pending') {
                            $textColor = 'yellow-100 text-yellow-800';
                        } else if ($report['status'] == 'reviewed') {
                            $textColor = 'blue-100 text-blue-800';
                        } else if ($report['status'] == 'resolved') {
                            $textColor = 'green-100 text-green-800';
                        } else {
                            $textColor = 'red-100 text-red-800';
                        }
                        ?>
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 gap-2">
                                    <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars($report['title'], ENT_QUOTES, 'UTF-8') ?></p>
                                    <p class="text-sm text-gray-500"><?= htmlspecialchars($report['description'], ENT_QUOTES, 'UTF-8') ?></p>
                                </div>
                                <div class="flex flex-col space-x-2">
                                    <span class="items-center px-2.5 py-0.5 w-fit rounded-full text-xs font-medium bg-<?= $textColor ?>">
                                        <?= htmlspecialchars(\Config\MappingData::mapStatus($report['status']), ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                    <p class="text-[12px] text-gray-500">Ngày báo cáo: <?= date('d/m/Y', strtotime($report['created_at'])) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="px-6 py-6 text-center text-gray-500">Không có báo cáo mới</div>
                <?php endif; ?>
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                <a href="<?= BASE_URL ?>/admin/reports" class="text-sm font-medium text-blue-600 hover:text-blue-500">Xem tất cả báo cáo</a>
            </div>
        </div>
    </div>