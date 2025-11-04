<!-- 
    Author: Huy Nguyen
    Date: 2025-09-09
    Purpose: Posts for admin
-->

<!-- Page Header -->
<div class="p-3">
    <input type="hidden" name="role" value="admin">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Quản lý bài đăng</h1>
                <p class="mt-2 text-gray-600">Duyệt và quản lý tất cả bài đăng cho thuê nhà</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-list text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tổng bài đăng</dt>
                            <dd class="text-lg font-medium text-gray-900"><?= $allPost ?></dd>
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
                            <i class="fas fa-clock text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Chờ duyệt</dt>
                            <dd class="text-lg font-medium text-gray-900"><?= $pendingPost ?></dd>
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
                            <i class="fas fa-check text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Đã duyệt</dt>
                            <dd class="text-lg font-medium text-gray-900"><?= $approvedPost ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-times text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Từ chối</dt>
                            <dd class="text-lg font-medium text-gray-900"><?= $rejectedPost ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form method="GET" action="<?= BASE_URL ?>/admin/posts">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                    <input type="text" name="search" placeholder="Tiêu đề, địa chỉ..."
                        value="<?= htmlspecialchars($currentFilters['search']) ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                    <select name="approval_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tất cả</option>
                        <option value="pending" <?= $currentFilters['approval_status'] === 'pending' ? 'selected' : '' ?>>Chờ duyệt</option>
                        <option value="approved" <?= $currentFilters['approval_status'] === 'approved' ? 'selected' : '' ?>>Đã duyệt</option>
                        <option value="rejected" <?= $currentFilters['approval_status'] === 'rejected' ? 'selected' : '' ?>>Từ chối</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Loại nhà</label>
                    <select name="rental_category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tất cả</option>
                        <?php foreach ($rentalCategories as $category) : ?>
                            <option value="<?= $category['id'] ?>" <?= $currentFilters['rental_category_id'] == $category['id'] ? 'selected' : '' ?>><?= $category['rental_category_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-search mr-2"></i>
                        Lọc
                    </button>
                    <a href="<?= BASE_URL ?>/admin/posts" class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 text-center">
                        <i class="fas fa-times mr-2"></i>
                        Xóa
                    </a>
                </div>
            </div>
        </form>
    </div>

            <?php
            // Highlight support: if highlight_id provided, will try to scroll/highlight that row on load
            $highlightId = isset($_GET['highlight_id']) && $_GET['highlight_id'] !== '' ? (int)$_GET['highlight_id'] : null;
            ?>

    <!-- Posts Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="flex items-center justify-between gap-10 border-b border-gray-200 pr-3">
            <div class="flex items-center gap-10 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Danh sách bài đăng</h3>
                <button data-modal-target="default-modal" id="openModalBtn" data-modal-toggle="default-modal" class="bg-green-500 hover:bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all" type="button">
                    <i class="fas fa-plus text-xl"></i>
                </button>
            </div>
            <div class="flex space-x-3">
                <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 flex items-center">
                    <i class="fas fa-check-double mr-2"></i>
                    Duyệt bài đã chọn
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" name="check-all" class="rounded border-gray-300 check-all-pending">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Bài đăng
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Chủ nhà
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Giá thuê
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Trạng thái
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ngày đăng
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Hành động
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($posts)) : ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-4"></i>
                                <p class="text-lg">Không có bài đăng nào</p>
                                <p class="text-sm">Hãy thử thay đổi bộ lọc để tìm kiếm</p>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($posts as $post) : ?>
                            <tr data-post-id="<?= $post['id'] ?>" id="post-row-<?= $post['id'] ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($post['approval_status'] === 'pending') : ?>
                                        <input type="checkbox" class="rounded border-gray-300 checked:bg-blue-500 check-item-pending" value="<?= $post['id'] ?>">
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            <?php if (!empty($post['images'])) : ?>
                                                <img class="h-16 w-16 rounded-lg object-cover"
                                                    src="<?= json_decode($post['images'])[0] ?>"
                                                    alt="<?= htmlspecialchars($post['rental_post_title']) ?>">
                                            <?php else : ?>
                                                <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-home text-gray-400 text-xl"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($post['rental_post_title']) ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <?= htmlspecialchars($post['address']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($post['landlord_name'] ?? 'N/A') ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= htmlspecialchars($post['contact'] ?? 'N/A') ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= htmlspecialchars($post['phone'] ?? 'N/A') ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?= \Helpers\Format::forMatPrice($post['price']) ?> VNĐ/tháng
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $statusConfig = [
                                        'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Chờ duyệt'],
                                        'approved' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Đã duyệt'],
                                        'rejected' => ['class' => 'bg-red-100 text-red-800', 'text' => 'Từ chối']
                                    ];
                                    $status = $statusConfig[$post['approval_status']] ?? ['class' => 'bg-gray-100 text-gray-800', 'text' => $post['approval_status']];
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $status['class'] ?>">
                                        <?= $status['text'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= date('d/m/Y', strtotime($post['created_at'])) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-900" title="Xem chi tiết" onclick="viewPost('<?= $post['id'] ?>')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <?php if ($post['approval_status'] === 'pending') : ?>
                                            <button class="text-green-600 hover:text-green-900" title="Duyệt">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900" title="Từ chối">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php elseif ($post['approval_status'] === 'rejected') : ?>
                                            <button class="text-green-600 hover:text-green-900" title="Duyệt lại">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (!empty($pagination) && $pagination['total_pages'] > 1) : ?>
            <?= \Helpers\Pagination::render($pagination, BASE_URL . '/admin/posts', $queryParams) ?>
        <?php endif; ?>
    </div>
    <?php include_once VIEW_PATH . 'partials/edit-post.php'; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.querySelector('.check-all-pending');
        const checkboxes = document.querySelectorAll('.check-item-pending');

        // Khi click vào check-all
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // If highlightId is present server-side, scroll to the row and briefly mark it
        try {
            const highlightId = <?= $highlightId ? (int)$highlightId : 'null' ?>;
            if (highlightId) {
                // small delay to ensure DOM is rendered
                setTimeout(() => {
                    const row = document.getElementById(`post-row-${highlightId}`) || document.querySelector(`[data-post-id="${highlightId}"]`);
                    if (row) {
                        row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        row.classList.add('ring-2', 'ring-yellow-400');
                        setTimeout(() => row.classList.remove('ring-2', 'ring-yellow-400'), 8000);
                    }
                }, 200);
            }
        } catch (e) {
            console.error('Highlight handling failed', e);
        }
    });
</script>