<?php
$title = 'Quản lý người dùng';
$breadcrumbs = [
    ['title' => 'Dashboard', 'url' => '/admin'],
    ['title' => 'Quản lý người dùng']
];

ob_start();
?>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Quản lý người dùng</h1>
            <p class="mt-2 text-gray-600">Quản lý tất cả người dùng trong hệ thống</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="openUserModal()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Thêm người dùng
            </button>
            <button class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 flex items-center">
                <i class="fas fa-download mr-2"></i>
                Xuất Excel
            </button>
        </div>
    </div>
</div>

<!-- Filters -->
<form method="get" class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
            <input type="text" name="search" placeholder="Tên, email, số điện thoại..."
                value="<?= htmlspecialchars($filter['search'] ?? '') ?>"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Vai trò</label>
            <select name="role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Tất cả</option>
                <?php if (!empty($roles)): ?>
                    <?php foreach ($roles as $roleItem): ?>
                        <option value="<?= htmlspecialchars($roleItem['role_name']) ?>" <?= ($filter['role'] ?? '') === $roleItem['role_name'] ? 'selected' : '' ?>><?= htmlspecialchars($roleItem['vn_name']) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Tất cả</option>
                <option value="active" <?= ($filter['status'] ?? '') === 'active' ? 'selected' : '' ?>>Hoạt động</option>
                <option value="inactive" <?= ($filter['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Không hoạt động</option>
                <option value="banned" <?= ($filter['status'] ?? '') === 'banned' ? 'selected' : '' ?>>Bị cấm</option>
            </select>
        </div>
        <div class="flex items-end">
            <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                <i class="fas fa-search mr-2"></i>
                Lọc
            </button>
        </div>
    </div>
</form>

<!-- Users Table -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Danh sách người dùng</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <input type="checkbox" class="rounded border-gray-300">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Người dùng
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Loại
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Trạng thái
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Ngày đăng ký
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Hành động
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="rounded border-gray-300" value="<?= $user['id'] ?>">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <?php if ($user['avatar']): ?>
                                            <img class="h-10 w-10 rounded-full" src="<?= htmlspecialchars($user['avatar']) ?>" alt="<?= htmlspecialchars($user['username']) ?>">
                                        <?php else: ?>
                                            <div class="h-10 w-10 rounded-full <?= $user['role_code'] === 'admin' ? 'bg-red-500' : ($user['role_code'] === 'landlord' ? 'bg-blue-500' : 'bg-green-500') ?> flex items-center justify-center">
                                                <span class="text-sm font-medium text-white">
                                                    <?= strtoupper(substr($user['username'], 0, 2)) ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($user['username']) ?></div>
                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($user['email']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    <?= $user['role_code'] === 'admin' ? 'bg-red-100 text-red-800' : ($user['role_code'] === 'landlord' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') ?>">
                                    <?= htmlspecialchars($user['role_name']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    <?= $user['account_status'] === 'active' ? 'bg-green-100 text-green-800' : ($user['account_status'] === 'banned' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') ?>">
                                    <?php
                                    switch ($user['account_status']) {
                                        case 'active':
                                            echo 'Hoạt động';
                                            break;
                                        case 'banned':
                                            echo 'Bị cấm';
                                            break;
                                        case 'inactive':
                                            echo 'Không hoạt động';
                                            break;
                                        default:
                                            echo 'Không xác định';
                                    }
                                    ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d/m/Y', strtotime($user['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="openViewUserModal(<?= $user['id'] ?>)" class="text-blue-600 hover:text-blue-900" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="openEditUserModal(<?= $user['id'] ?>)" class="text-yellow-600 hover:text-yellow-900" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <?php if ($user['account_status'] === 'banned'): ?>
                                        <button onclick="toggleUserStatus(<?= $user['id'] ?>, 'active')" class="text-green-600 hover:text-green-900" title="Bỏ cấm">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    <?php else: ?>
                                        <button onclick="toggleUserStatus(<?= $user['id'] ?>, 'banned')" class="text-red-600 hover:text-red-900" title="Cấm tài khoản">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    <?php endif; ?>
                                    <button onclick="deleteUser(<?= $user['id'] ?>)" class="text-gray-400 hover:text-red-700" title="Xoá tài khoản">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Không có dữ liệu người dùng
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php
    // Helper để giữ filter khi chuyển trang
    function buildPageUrl($page, $filter)
    {
        $params = array_merge($filter, ['page' => $page]);
        return BASE_URL . '/admin/users?' . http_build_query($params);
    }
    ?>
    <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <!-- Mobile pagination -->
            <div class="flex-1 flex justify-between sm:hidden">
                <?php if ($pagination['current_page'] > 1): ?>
                    <a href="<?= buildPageUrl($pagination['current_page'] - 1, $filter) ?>"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Trước
                    </a>
                <?php else: ?>
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                        Trước
                    </span>
                <?php endif; ?>

                <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                    <a href="<?= buildPageUrl($pagination['current_page'] + 1, $filter) ?>"
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Sau
                    </a>
                <?php else: ?>
                    <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                        Sau
                    </span>
                <?php endif; ?>
            </div>

            <!-- Desktop pagination -->
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Hiển thị
                        <span class="font-medium"><?= $pagination['start_record'] ?></span>
                        đến
                        <span class="font-medium"><?= $pagination['end_record'] ?></span>
                        của
                        <span class="font-medium"><?= $pagination['total_users'] ?></span>
                        kết quả
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <!-- Previous page button -->
                        <?php if ($pagination['current_page'] > 1): ?>
                            <a href="<?= buildPageUrl($pagination['current_page'] - 1, $filter) ?>"
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php else: ?>
                            <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-300 cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        <?php endif; ?>

                        <!-- Page numbers -->
                        <?php
                        $startPage = max(1, $pagination['current_page'] - 2);
                        $endPage = min($pagination['total_pages'], $pagination['current_page'] + 2);

                        // Hiển thị trang đầu nếu cần
                        if ($startPage > 1): ?>
                            <a href="<?= buildPageUrl(1, $filter) ?>"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                1
                            </a>
                            <?php if ($startPage > 2): ?>
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500">
                                    ...
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>

                        <!-- Các trang xung quanh trang hiện tại -->
                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <?php if ($i == $pagination['current_page']): ?>
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">
                                    <?= $i ?>
                                </span>
                            <?php else: ?>
                                <a href="<?= buildPageUrl($i, $filter) ?>"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <?= $i ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <!-- Hiển thị trang cuối nếu cần -->
                        <?php if ($endPage < $pagination['total_pages']): ?>
                            <?php if ($endPage < $pagination['total_pages'] - 1): ?>
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500">
                                    ...
                                </span>
                            <?php endif; ?>
                            <a href="<?= buildPageUrl($pagination['total_pages'], $filter) ?>"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                <?= $pagination['total_pages'] ?>
                            </a>
                        <?php endif; ?>

                        <!-- Next page button -->
                        <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                            <a href="<?= buildPageUrl($pagination['current_page'] + 1, $filter) ?>"
                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php else: ?>
                            <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-300 cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- User Modal -->
<div id="userModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-5 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <!-- Modal Header -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
                <h2 id="userModalTitle" class="text-xl font-semibold text-gray-800">Thêm người dùng mới</h2>
            </div>
            <button onclick="closeUserModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Form -->
        <form id="userForm" method="POST" action="<?= BASE_URL ?>/admin/users/store">
            <?= \Core\CSRF::getTokenField() ?>
            <input type="hidden" id="user_id" name="user_id" value="">

            <!-- Row 1: Username & Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Tên người dùng <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="username" name="username" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?php if (isset($validationErrors['username'])) echo 'border-red-500'; ?>"
                        placeholder="Nhập tên người dùng"
                        value="<?= htmlspecialchars($oldInput['username'] ?? '') ?>">
                    <?php if (isset($validationErrors['username'])): ?>
                        <div class="error-message text-red-500 text-sm mt-1" id="username-error"><?= htmlspecialchars($validationErrors['username']) ?></div>
                    <?php else: ?>
                        <div class="error-message text-red-500 text-sm mt-1 hidden" id="username-error"></div>
                    <?php endif; ?>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?php if (isset($validationErrors['email'])) echo 'border-red-500'; ?>"
                        placeholder="Nhập địa chỉ email"
                        value="<?= htmlspecialchars($oldInput['email'] ?? '') ?>">
                    <?php if (isset($validationErrors['email'])): ?>
                        <div class="error-message text-red-500 text-sm mt-1" id="email-error"><?= htmlspecialchars($validationErrors['email']) ?></div>
                    <?php else: ?>
                        <div class="error-message text-red-500 text-sm mt-1 hidden" id="email-error"></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Row 2: Phone & Gender -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Số điện thoại <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="phone" name="phone" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?php if (isset($validationErrors['phone'])) echo 'border-red-500'; ?>"
                        placeholder="Nhập số điện thoại"
                        value="<?= htmlspecialchars($oldInput['phone'] ?? '') ?>">
                    <?php if (isset($validationErrors['phone'])): ?>
                        <div class="error-message text-red-500 text-sm mt-1" id="phone-error"><?= htmlspecialchars($validationErrors['phone']) ?></div>
                    <?php else: ?>
                        <div class="error-message text-red-500 text-sm mt-1 hidden" id="phone-error"></div>
                    <?php endif; ?>
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                        Giới tính <span class="text-red-500">*</span>
                    </label>
                    <select id="gender" name="gender"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?php if (isset($validationErrors['gender'])) echo 'border-red-500'; ?>">
                        <option value="">Chọn giới tính</option>
                        <option value="male" <?= (isset($oldInput['gender']) && $oldInput['gender'] === 'male') ? 'selected' : '' ?>>Nam</option>
                        <option value="female" <?= (isset($oldInput['gender']) && $oldInput['gender'] === 'female') ? 'selected' : '' ?>>Nữ</option>
                    </select>
                    <?php if (isset($validationErrors['gender'])): ?>
                        <div class="error-message text-red-500 text-sm mt-1" id="gender-error"><?= htmlspecialchars($validationErrors['gender']) ?></div>
                    <?php else: ?>
                        <div class="error-message text-red-500 text-sm mt-1 hidden" id="gender-error"></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Row 3: Birthday & Job -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Birthday -->
                <div>
                    <label for="birthday" class="block text-sm font-medium text-gray-700 mb-2">
                        Ngày sinh
                    </label>
                    <input type="date" id="birthday" name="birthday"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="error-message text-red-500 text-sm mt-1 hidden" id="birthday-error"></div>
                </div>
                <!-- Job -->
                <div>
                    <label for="job" class="block text-sm font-medium text-gray-700 mb-2">
                        Nghề nghiệp
                    </label>
                    <input type="text" id="job" name="job"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nhập nghề nghiệp">
                    <div class="error-message text-red-500 text-sm mt-1 hidden" id="job-error"></div>
                </div>
            </div>

            <!-- Row 4: Province & Ward -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Province -->
                <div>
                    <label for="province" class="block text-sm font-medium text-gray-700 mb-2">
                        Tỉnh/Thành phố
                    </label>
                    <select id="province" name="province" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                        <option value="">Chọn Tỉnh/Thành phố</option>
                    </select>
                    <div class="error-message text-red-500 text-sm mt-1 hidden" id="province-error"></div>
                </div>

                <!-- Ward -->
                <div>
                    <label for="ward" class="block text-sm font-medium text-gray-700 mb-2">
                        Phường/Xã
                    </label>
                    <select id="ward" name="ward" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                        <option value="">Chọn Phường/Xã</option>
                    </select>
                    <div class="error-message text-red-500 text-sm mt-1 hidden" id="ward-error"></div>
                </div>
            </div>

            <!-- Row 5: Address & Citizen ID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Địa chỉ chi tiết
                    </label>
                    <input type="text" id="address" name="address"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nhập địa chỉ chi tiết"
                        value="<?= htmlspecialchars($oldInput['address'] ?? '') ?>">
                    <div class="error-message text-red-500 text-sm mt-1 hidden" id="address-error"></div>
                </div>

                <!-- Citizen ID -->
                <div>
                    <label for="citizen_id" class="block text-sm font-medium text-gray-700 mb-2">
                        CMND/CCCD
                    </label>
                    <input type="text" id="citizen_id" name="citizen_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2"
                        placeholder="Nhập số CMND/CCCD">
                    <div class="error-message text-red-500 text-sm mt-1 hidden" id="citizen_id-error"></div>
                </div>
            </div>

            <!-- Row 6: Role & Account Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Role -->
                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Vai trò <span class="text-red-500">*</span>
                    </label>
                    <select id="role_id" name="role_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Chọn vai trò</option>
                        <?php if (!empty($roles)): ?>
                            <?php foreach ($roles as $roleItem): ?>
                                <option value="<?= htmlspecialchars($roleItem['id']) ?>" <?= (isset($oldInput['role_id']) && $oldInput['role_id'] == $roleItem['id']) ? 'selected' : '' ?>><?= htmlspecialchars($roleItem['vn_name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <div class="error-message text-red-500 text-sm mt-1 hidden" id="role_id-error"></div>
                </div>

                <!-- Account Status -->
                <div>
                    <label for="account_status" class="block text-sm font-medium text-gray-700 mb-2">
                        Trạng thái tài khoản
                    </label>
                    <select id="account_status" name="account_status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active" selected>Hoạt động</option>
                        <option value="inactive">Không hoạt động</option>
                        <option value="banned">Bị cấm</option>
                    </select>
                    <div class="error-message text-red-500 text-sm mt-1 hidden" id="account_status-error"></div>
                </div>
            </div>

            <!-- Row 7: Password & Confirm Password -->
            <div id="passwordSection" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mật khẩu <span id="passwordRequired" class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?php if (isset(
                                $validationErrors['password'])) echo 'border-red-500'; ?>"
                            placeholder="Nhập mật khẩu"
                            value="<?= htmlspecialchars($oldInput['password'] ?? '') ?>">
                    </div>
                    <?php if (isset($validationErrors['password'])): ?>
                        <div class="error-message text-red-500 text-sm mt-1" id="password-error"><?= htmlspecialchars($validationErrors['password']) ?></div>
                    <?php else: ?>
                        <div class="error-message text-red-500 text-sm mt-1 hidden" id="password-error"></div>
                    <?php endif; ?>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Xác nhận mật khẩu <span id="confirmPasswordRequired" class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?php if (isset($validationErrors['password_confirmation'])) echo 'border-red-500'; ?>"
                            placeholder="Nhập lại mật khẩu"
                            value="<?= htmlspecialchars($oldInput['password_confirmation'] ?? '') ?>">
                    </div>
                    <?php if (isset($validationErrors['password_confirmation'])): ?>
                        <div class="error-message text-red-500 text-sm mt-1" id="password_confirmation-error"><?= htmlspecialchars($validationErrors['password_confirmation']) ?></div>
                    <?php else: ?>
                        <div class="error-message text-red-500 text-sm mt-1 hidden" id="password_confirmation-error"></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t">
                <button type="button" onclick="closeUserModal()"
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                    Hủy
                </button>
                <button type="submit" id="userSubmitBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                    Thêm người dùng
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // User Modal functions
    function openUserModal(resetForm = true) {
        document.getElementById('userModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        if (resetForm) {
            resetUserFormToCreate();
        }
    }

    function closeUserModal() {
        document.getElementById('userModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function resetUserFormToCreate() {
        document.getElementById('userModalTitle').textContent = 'Thêm người dùng mới';
        document.getElementById('userSubmitBtn').textContent = 'Thêm người dùng';
        document.getElementById('userForm').reset();
        document.getElementById('user_id').value = '';
        document.getElementById('userForm').action = `${App.appURL}admin/users/store`;

        // Enable all inputs
        const form = document.getElementById('userForm');
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.removeAttribute('readonly');
            input.removeAttribute('disabled');
        });

        // Reset address dropdowns
        $('#province').html('<option value="">Chọn Tỉnh/Thành phố</option>');
        $('#ward').html('<option value="">Chọn Phường/Xã</option>');
        // Reload provinces data
        App.setProvinceData($('#province'));

        // Show password fields and make them required
        const passwordSection = document.getElementById('passwordSection');
        if (passwordSection) {
            passwordSection.style.display = 'grid';
        }
        document.getElementById('password').required = true;
        document.getElementById('password_confirmation').required = true;
        document.getElementById('passwordRequired').style.display = 'inline';
        document.getElementById('confirmPasswordRequired').style.display = 'inline';
        document.getElementById('userSubmitBtn').style.display = 'inline-block';
    }

    function openEditUserModal(userId) {
        console.log('Opening edit modal for user:', userId);
        console.log('App.appURL:', App.appURL);
        console.log('Full URL:', `${App.appURL}admin/users/edit/${userId}`);
        // Fetch user data and populate form
        fetch(`${App.appURL}admin/users/edit/${userId}`)
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.text().then(text => {
                    console.log('Raw response:', text);
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw new Error('Response is not valid JSON: ' + text);
                    }
                });
            })
            .then(data => {
                console.log('Parsed data:', data);
                if (data.success) {
                    const user = data.user;

                    // Update modal title and form
                    document.getElementById('userModalTitle').textContent = 'Chỉnh sửa người dùng';
                    document.getElementById('userSubmitBtn').textContent = 'Cập nhật';
                    document.getElementById('user_id').value = user.id;
                    document.getElementById('userForm').action = `${App.appURL}admin/users/update/${user.id}`;

                    // Enable all inputs first
                    const form = document.getElementById('userForm');
                    const inputs = form.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        input.removeAttribute('readonly');
                        input.removeAttribute('disabled');
                    });

                    // Fill form data
                    fillUserFormData(user);

                    // Show password section but make optional
                    document.getElementById('passwordSection').style.display = 'grid';
                    document.getElementById('password').required = false;
                    document.getElementById('password_confirmation').required = false;
                    document.getElementById('passwordRequired').style.display = 'none';
                    document.getElementById('confirmPasswordRequired').style.display = 'none';

                    // Clear password fields
                    document.getElementById('password').value = '';
                    document.getElementById('password_confirmation').value = '';

                    // Show submit button
                    document.getElementById('userSubmitBtn').style.display = 'inline-block';

                    // Open modal without resetting form
                    openUserModal(false);
                } else {
                    showErrorMessage(data.message || 'Lỗi khi tải thông tin người dùng');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorMessage('Lỗi khi tải thông tin người dùng');
            });
    }

    // Helper function to fill form data
    function fillUserFormData(user) {
        document.getElementById('username').value = user.username || '';
        document.getElementById('email').value = user.email || '';
        document.getElementById('phone').value = user.phone || '';
        document.getElementById('gender').value = user.gender || '';
        document.getElementById('birthday').value = user.birthday || '';
        document.getElementById('job').value = user.job || '';
        document.getElementById('citizen_id').value = user.citizen_id || '';
        document.getElementById('role_id').value = user.role_id || '';
        document.getElementById('account_status').value = user.account_status || '';
        document.getElementById('address').value = user.address || '';

        // Load province data first, then set province and ward
        App.setProvinceData($('#province')).then(function() {
            if (user.province) {
                $('#province').val(user.province);

                // Get province code and load ward data
                const provinceCode = $('#province option:selected').data('code');
                if (provinceCode && user.ward) {
                    App.setWardData(provinceCode, $('#ward')).then(function() {
                        $('#ward').val(user.ward);
                    });
                }
            }
        });
    }

    function openViewUserModal(userId) {
        console.log('Opening view modal for user:', userId);
        console.log('App.appURL:', App.appURL);
        // Fetch user data first
        fetch(`${App.appURL}admin/users/edit/${userId}`)
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    const user = data.user;

                    // Update modal title
                    document.getElementById('userModalTitle').textContent = 'Xem thông tin người dùng';

                    // Fill form data
                    fillUserFormData(user);

                    // Make all inputs readonly
                    const form = document.getElementById('userForm');
                    const inputs = form.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        input.setAttribute('readonly', true);
                        input.setAttribute('disabled', true);
                    });

                    // Hide password section and submit button
                    document.getElementById('passwordSection').style.display = 'none';
                    document.getElementById('userSubmitBtn').style.display = 'none';

                    // Open modal without resetting form
                    openUserModal(false);
                } else {
                    showErrorMessage(data.message || 'Lỗi khi tải thông tin người dùng');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorMessage('Lỗi khi tải thông tin người dùng');
            });
    }

    // Open edit modal with existing validation errors (for when update fails)
    function openEditUserModalWithErrors(userId) {
        // Fetch user data first
        fetch(`${App.appURL}admin/users/edit/${userId}`)
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.text().then(text => {
                    console.log('Raw response:', text);
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw new Error('Response is not valid JSON: ' + text);
                    }
                });
            })
            .then(data => {
                console.log('Parsed data:', data);
                if (data.success) {
                    const user = data.user;

                    // Update modal title and form
                    document.getElementById('userModalTitle').textContent = 'Chỉnh sửa người dùng';
                    document.getElementById('userSubmitBtn').textContent = 'Cập nhật';
                    document.getElementById('user_id').value = user.id;
                    document.getElementById('userForm').action = `${App.appURL}admin/users/update/${user.id}`;

                    // Enable all inputs first
                    const form = document.getElementById('userForm');
                    const inputs = form.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        input.removeAttribute('readonly');
                        input.removeAttribute('disabled');
                    });

                    // Fill form with user data (will be overridden by old input values from validation errors)
                    fillUserFormData(user);

                    // Show password section but make optional
                    document.getElementById('passwordSection').style.display = 'grid';
                    document.getElementById('password').required = false;
                    document.getElementById('password_confirmation').required = false;
                    document.getElementById('passwordRequired').style.display = 'none';
                    document.getElementById('confirmPasswordRequired').style.display = 'none';

                    // Don't clear password fields here - they should remain from old input

                    // Show submit button
                    document.getElementById('userSubmitBtn').style.display = 'inline-block';

                    // Open modal without resetting form (preserves validation errors and old input)
                    openUserModal(false);
                } else {
                    showErrorMessage(data.message || 'Lỗi khi tải thông tin người dùng');
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                showErrorMessage('Lỗi kết nối: ' + error.message);
            });
    }

    // Toggle user status (ban/unban)
    function toggleUserStatus(userId, status) {
        const action = status === 'banned' ? 'cấm' : 'kích hoạt';
        App.showModalConfirm(`Bạn có chắc chắn muốn ${action} tài khoản này?`).then((result) => {
            if (result.isConfirmed) {
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                    document.querySelector('input[name="csrf_token"]')?.value;

                fetch(`${App.appURL}admin/users/toggle-status/${userId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `status=${status}&csrf_token=${csrfToken}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            App.showSuccessMessage(data.message, 'success');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            App.showSuccessMessage(data.message || 'Có lỗi xảy ra', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        App.showSuccessMessage('Có lỗi xảy ra khi cập nhật trạng thái', 'error');
                    });
            }
        });
    }

    // Delete user
    function deleteUser(userId) {
        App.showModalConfirm('Bạn có chắc chắn muốn xoá tài khoản này? Tài khoản sẽ bị vô hiệu hoá và không thể đăng nhập.').then((result) => {
            if (result.isConfirmed) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                    document.querySelector('input[name="csrf_token"]')?.value;
                fetch(`${App.appURL}admin/users/delete/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `csrf_token=${csrfToken}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        App.showSuccessMessage(data.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        App.showSuccessMessage(data.message || 'Có lỗi xảy ra', 'error');
                    }
                })
                .catch(error => {
                    App.showSuccessMessage('Có lỗi xảy ra khi xoá tài khoản', 'error');
                });
            }
        });
    }

    // Initialize address dropdowns when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Load provinces data when page loads
        App.setProvinceData($('#province'));

        // Handle province change to load wards
        $('#province').on('change', function() {
            const selectedOption = $(this).find(':selected');
            const provinceCode = selectedOption.data('code');

            // Clear and reset ward dropdown
            $('#ward').html('<option value="">Chọn Phường/Xã</option>');

            if (provinceCode) {
                // Load wards for selected province
                App.setWardData(provinceCode, $('#ward'));
            }
        });
    });

    // Close modal when clicking outside
    document.getElementById('userModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeUserModal();
        }
    });

    <?php if (isset($validationErrors) && !empty($validationErrors)): ?>
        <?php
        // Get modal type and user ID from session
        $modalType = \Core\Session::get('modal_type');
        $editUserId = \Core\Session::get('edit_user_id');

        // Clear session data after using
        \Core\Session::delete('modal_type');
        \Core\Session::delete('edit_user_id');
        ?>
        // Show modal if there are validation errors
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($modalType === 'edit' && $editUserId): ?>
                // Open edit modal with validation errors
                openEditUserModalWithErrors(<?= $editUserId ?>);
            <?php else: ?>
                // Open create modal with validation errors
                openUserModal();
            <?php endif; ?>
        });
    <?php endif; ?>
</script>

<?php
$content = ob_get_clean();
include VIEW_PATH . 'admin/layouts/app.php';
?>