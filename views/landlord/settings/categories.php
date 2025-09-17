<!--
    Author: Huy Nguyen
    Date: 2025-01-15
    Purpose: Categories management for landlord
-->
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Quản lý danh mục phòng</h1>
        <p class="text-gray-600 mt-2">Quản lý danh mục phòng hệ thống và danh mục cá nhân</p>
    </div>

    <!-- Tabs Navigation -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button onclick="switchTab('system')" class="tab-button py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap border-blue-500 text-blue-600"
                    id="system-tab">
                    <i class="fas fa-globe mr-2"></i>
                    Danh mục hệ thống
                </button>
                <button onclick="switchTab('user')" class="tab-button py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                    id="user-tab">
                    <i class="fas fa-user mr-2"></i>
                    Danh mục của tôi
                </button>
            </nav>
        </div>
    </div>

    <!-- System Categories Tab -->
    <div id="system-categories" class="tab-item">
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Danh mục hệ thống</h2>
            <p class="text-gray-600">Các danh mục phòng được cung cấp bởi hệ thống, chỉ có thể xem</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (count($systemCategories) > 0) { ?>
                <?php foreach ($systemCategories as $category) { ?>
                    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($category['rental_category_name']) ?></h3>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-globe mr-1"></i>
                                    Hệ thống
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $category['rental_category_status'] == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <i class="fas <?= $category['rental_category_status'] == 'active' ? 'fa-check' : 'fa-times' ?> mr-1"></i>
                                    <?= $category['rental_category_status'] == 'active' ? 'Hoạt động' : 'Tạm dừng' ?>
                                </span>
                            </div>
                            <div class="text-sm text-gray-500">
                                <?= date('d/m/Y', strtotime($category['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <!-- User Categories Tab -->
    <div id="user-categories" class="tab-item hidden">
        <div class="flex items-center justify-start gap-10">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Danh mục của tôi</h2>
                <p class="text-gray-600">Các danh mục phòng do bạn tạo, có thể chỉnh sửa và xóa</p>
            </div>
            <button onclick="openCreateModal()" class="ml-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded text-xs transition-colors">
                <i class="fas fa-plus mr-1"></i>
                Thêm
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (count($userCategories) > 0) { ?>
                <?php foreach ($userCategories as $category) { ?>
                    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($category['rental_category_name']) ?></h3>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="openEditModal(<?= htmlspecialchars(json_encode($category)) ?>)"
                                    class="text-blue-600 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50 transition-colors"
                                    title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteCategory(<?= $category['id'] ?>)"
                                    class="text-red-600 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors"
                                    title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $category['rental_category_status'] == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <i class="fas <?= $category['rental_category_status'] == 'active' ? 'fa-check' : 'fa-times' ?> mr-1"></i>
                                    <?= $category['rental_category_status'] == 'active' ? 'Hoạt động' : 'Tạm dừng' ?>
                                </span>
                            </div>
                            <div class="text-sm text-gray-500">
                                <?= date('d/m/Y', strtotime($category['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="text-center py-12">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Chưa có danh mục nào</h3>
                    <p class="text-gray-600 mb-6">Tạo danh mục đầu tiên để quản lý các loại phòng</p>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Empty State -->
    <?php if (empty($systemCategories) && empty($userCategories)) { ?>
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-tags text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Chưa có danh mục nào</h3>
            <p class="text-gray-600 mb-6">Tạo danh mục đầu tiên để quản lý các loại phòng</p>
            <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Tạo danh mục đầu tiên
            </button>
        </div>
    <?php } ?>
</div>

<!-- Create/Edit Modal -->
<div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 id="modalTitle" class="text-xl font-semibold text-gray-900">Thêm danh mục mới</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="categoryForm" class="space-y-4">
                <input type="hidden" id="categoryId" name="id">
                <?= \Core\CSRF::getTokenField() ?>
                <!-- Category Name -->
                <div>
                    <label for="category_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Tên danh mục <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="rental_category_name" name="rental_category_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="VD: Phòng trọ, Căn hộ, Nhà nguyên căn" required>
                </div>
                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" id="rental_category_status" name="rental_category_status" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Kích hoạt danh mục</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Hủy
                    </button>
                    <button type="button" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors saveCategoryBtn">
                        <i class="fas fa-save mr-2"></i>
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let isEditMode = false;

    // Tab switching functionality
    function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-item').forEach(content => {
            content.classList.add('hidden');
        });

        // Remove active class from all tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('border-blue-500', 'text-blue-600');
            button.classList.add('border-transparent', 'text-gray-500');
        });

        // Show selected tab content
        document.getElementById(tabName + '-categories').classList.remove('hidden');

        // Add active class to selected tab
        const activeTab = document.getElementById(tabName + '-tab');
        activeTab.classList.remove('border-transparent', 'text-gray-500');
        activeTab.classList.add('border-blue-500', 'text-blue-600');

        // Save current tab to localStorage
        localStorage.setItem('categories_active_tab', tabName);
    }

    // Load saved tab on page load
    function loadSavedTab() {
        const savedTab = localStorage.getItem('categories_active_tab');
        if (savedTab && (savedTab === 'system' || savedTab === 'user')) {
            switchTab(savedTab);
        } else {
            // Default to system tab
            switchTab('system');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadSavedTab();
    });
</script>