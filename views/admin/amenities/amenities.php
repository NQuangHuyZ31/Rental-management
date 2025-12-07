<!-- Page Header -->
<div class="p-3">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Quản lý tiện ích</h1>
                <p class="mt-2 text-gray-600">Quản lý tiện ích (hệ thống và của người dùng)</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="openCreateAmenityModal()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Thêm tiện ích
                </button>
                <!-- <button class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 flex items-center">
                    <i class="fas fa-download mr-2"></i>
                    Xuất Excel
                </button> -->
            </div>
        </div>
    </div>

    <!-- Filters -->
    <form method="get" class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                <input type="text" name="search" placeholder="Tên tiện ích..."
                    value="<?= htmlspecialchars($filter['search'] ?? '') ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Loại</label>
                <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all" <?= ($filter['type'] ?? '') === 'all' ? 'selected' : '' ?>>Tất cả</option>
                    <option value="system" <?= ($filter['type'] ?? '') === 'system' ? 'selected' : '' ?>>Hệ thống</option>
                    <option value="landlord" <?= ($filter['type'] ?? '') === 'landlord' ? 'selected' : '' ?>>Chủ trọ</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả</option>
                    <option value="active" <?= ($filter['status'] ?? '') === 'active' ? 'selected' : '' ?>>Hoạt động</option>
                    <option value="inactive" <?= ($filter['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Không hoạt động</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-search mr-2"></i>
                    Lọc
                </button>
                <a href="<?= BASE_URL ?>/admin/amenities" class="w-full flex items-center justify-center bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-200 ml-2">
                    <i class="fas fa-times mr-2"></i>
                    Xóa
                </a>
            </div>
        </div>
    </form>

    <!-- Amenities Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Danh sách tiện ích</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiện ích</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loại</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($amenities)): ?>
                        <?php foreach ($amenities as $amenity): ?>
                            <?php $adminUserIds = $adminUserIds ?? [];
                            $ownerId = $amenity['owner_id'] ?? null;
                            $isSystemAmenity = (empty($ownerId) || in_array((int)$ownerId, $adminUserIds)); ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <p><?= htmlspecialchars($amenity['rental_amenity_name']) ?></p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($isSystemAmenity): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Hệ thống</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Chủ trọ</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span id="status-badge-<?= $amenity['id'] ?>" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= ($amenity['rental_amenity_status'] ?? 'inactive') === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= ($amenity['rental_amenity_status'] ?? 'inactive') === 'active' ? 'Hoạt động' : 'Tạm dừng' ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= date('d/m/Y', strtotime($amenity['created_at'] ?? '')) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <?php if (empty($amenity['owner_id']) || $amenity['owner_id'] == \Core\Session::get('user')['id']) { ?>
                                            <button onclick="openEditAmenityModal(<?= htmlspecialchars(json_encode($amenity)) ?>)" class="text-yellow-600 hover:text-yellow-900" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        <?php } ?>
                                        <?php $currentStatus = ($amenity['rental_amenity_status'] ?? 'inactive'); ?>
                                        <?php if ($currentStatus === 'active'): ?>
                                            <button onclick="toggleAmenityStatus(<?= $amenity['id'] ?>, 'inactive')" class="text-green-600 hover:text-green-900" title="Đổi trạng thái sang Tạm dừng">
                                                <i class="fas fa-toggle-on"></i>
                                            </button>
                                        <?php else: ?>
                                            <button onclick="toggleAmenityStatus(<?= $amenity['id'] ?>, 'active')" class="text-gray-600 hover:text-gray-900" title="Đổi trạng thái sang Hoạt động">
                                                <i class="fas fa-toggle-off"></i>
                                            </button>
                                        <?php endif; ?>
                                        <button onclick="deleteAmenity(<?= $amenity['id'] ?>)" class="text-red-600 hover:text-red-900" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Không có dữ liệu tiện ích</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (!empty($pagination) && $pagination['total_pages'] > 1) : ?>
            <div class="mt-8">
                <?= \Helpers\Pagination::render($pagination, BASE_URL . '/admin/amenities', $queryParams) ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Amenity Modal -->
<div id="amenityModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-5 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-concierge-bell text-white text-sm"></i>
                </div>
                <h2 id="amenityModalTitle" class="text-xl font-semibold text-gray-800">Thêm tiện ích mới</h2>
            </div>
            <button onclick="closeAmenityModal()" class="text-gray-400 hover:text-gray-600 transition-colors"><i class="fas fa-times text-xl"></i></button>
        </div>

        <form id="amenityForm" method="POST" action="<?= BASE_URL ?>/admin/amenities/store">
            <?= \Core\CSRF::getTokenField() ?>
            <input type="hidden" id="amenity_id" name="id" value="">

            <div class="mb-4">
                <label for="rental_amenity_name" class="block text-sm font-medium text-gray-700 mb-2">Tên tiện ích <span class="text-red-500">*</span></label>
                <input type="text" id="rental_amenity_name" name="rental_amenity_name" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?php if (isset($validationErrors['rental_amenity_name'])) echo 'border-red-500'; ?>"
                    placeholder="VD: Bãi đỗ xe, Điều hòa"
                    value="<?= htmlspecialchars($oldInput['rental_amenity_name'] ?? '') ?>">
                <?php if (isset($validationErrors['rental_amenity_name'])): ?>
                    <div class="error-message text-red-500 text-sm mt-1" id="rental_amenity_name-error"><?= htmlspecialchars($validationErrors['rental_amenity_name']) ?></div>
                <?php else: ?>
                    <div class="error-message text-red-500 text-sm mt-1 hidden" id="rental_amenity_name-error"></div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" id="rental_amenity_status" name="rental_amenity_status" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Kích hoạt tiện ích</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <button type="button" onclick="closeAmenityModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">Hủy</button>
                <button type="submit" id="amenitySaveBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">Lưu</button>
            </div>
        </form>
    </div>
</div>

<script>
    // JS modal helpers for amenity page
    function openCreateAmenityModal() {
        clearAmenityFormErrors();
        document.getElementById('amenityForm').reset();
        document.getElementById('amenity_id').value = '';
        // ensure form posts to create endpoint
        document.getElementById('amenityForm').action = `${App.appURL}admin/amenities/store`;
        document.getElementById('amenityModalTitle').textContent = 'Thêm tiện ích mới';
        document.getElementById('amenityModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function openEditAmenityModal(amenity) {
        clearAmenityFormErrors();
        document.getElementById('amenity_id').value = amenity.id || '';
        document.getElementById('rental_amenity_name').value = amenity.rental_amenity_name || '';
        document.getElementById('rental_amenity_status').checked = (amenity.rental_amenity_status || 'inactive') === 'active';
        // set form action to update endpoint for this amenity
        document.getElementById('amenityForm').action = `${App.appURL}admin/amenities/update/${amenity.id || ''}`;
        document.getElementById('amenityModalTitle').textContent = 'Chỉnh sửa tiện ích';
        document.getElementById('amenityModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeAmenityModal() {
        document.getElementById('amenityModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function clearAmenityFormErrors() {
        const errs = document.querySelectorAll('#amenityForm .error-message');
        errs.forEach(e => {
            e.classList.add('hidden');
            e.textContent = '';
        });
    }

    function deleteAmenity(id) {
        App.showModalConfirm('Bạn có chắc chắn muốn xoá tiện ích này?').then((result) => {
            if (!result.isConfirmed) return;
            const csrf = document.querySelector('input[name="csrf_token"]')?.value || '';
            fetch(`${App.appURL}admin/amenities/delete/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `csrf_token=${csrf}`
                })
                .then(response => response.text())
                .then(text => {
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        data = {
                            success: false,
                            message: text
                        };
                    }
                    if (data.success) {
                        App.showSuccessMessage(data.message || 'Xoá thành công', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1200);
                    } else {
                        App.showSuccessMessage(data.message || 'Có lỗi', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    App.showSuccessMessage('Lỗi kết nối', 'error');
                });
        });
    }

    // Intercept form submit to show inline errors (basic)
    document.getElementById('amenityForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        clearAmenityFormErrors();
        const form = this;
        const formData = new FormData(form);
        // Ensure status is sent as 'active' or 'inactive'
        const statusCheckbox = document.getElementById('rental_amenity_status');
        formData.set('rental_amenity_status', statusCheckbox && statusCheckbox.checked ? 'active' : 'inactive');
        const action = form.action;
        const btn = document.getElementById('amenitySaveBtn');
        btn.disabled = true;
        btn.textContent = 'Đang xử lý...';

        fetch(action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    data = {
                        success: false,
                        message: text
                    };
                }
                btn.disabled = false;
                btn.textContent = 'Lưu';
                if (data.success) {
                    App.showSuccessMessage(data.message || 'Thành công', 'success');
                    setTimeout(() => {
                        closeAmenityModal();
                        location.reload();
                    }, 1200);
                } else if (data.validationErrors) {
                    for (const [field, msg] of Object.entries(data.validationErrors)) {
                        const el = document.getElementById(field + '-error');
                        const input = document.getElementById(field);
                        if (el) {
                            el.textContent = msg;
                            el.classList.remove('hidden');
                        }
                        if (input) input.classList.add('border-red-500');
                    }
                    if (data.message) {
                        App.showSuccessMessage(data.message, 'error');
                    }
                } else {
                    App.showSuccessMessage(data.message || 'Có lỗi xảy ra', 'error');
                }
            }).catch(err => {
                console.error(err);
                btn.disabled = false;
                btn.textContent = 'Lưu';
                App.showSuccessMessage('Lỗi kết nối', 'error');
            });
    });

    function toggleAmenityStatus(amenityId, newStatus) {
        App.showModalConfirm('Bạn có chắc chắn muốn đổi trạng thái?').then(result => {
            if (!result.isConfirmed) return;
            const csrf = document.querySelector('input[name="csrf_token"]')?.value || '';
            fetch(`${App.appURL}admin/amenities/toggle-status/${amenityId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `status=${newStatus}&csrf_token=${csrf}`
                })
                .then(response => response.text())
                .then(text => {
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        data = {
                            success: false,
                            message: text
                        };
                    }
                    if (data.success) {
                        App.showSuccessMessage(data.message || 'Cập nhật trạng thái thành công', 'success');
                        // update badge
                        const badge = document.getElementById('status-badge-' + amenityId);
                        if (badge) {
                            if (newStatus === 'active') {
                                badge.textContent = 'Hoạt động';
                                badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
                            } else {
                                badge.textContent = 'Tạm dừng';
                                badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800';
                            }
                        }
                        // reload page shortly after showing success so list reflects any server-side changes
                        setTimeout(() => {
                            location.reload();
                        }, 1200);
                    } else {
                        App.showSuccessMessage(data.message || 'Có lỗi', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    App.showSuccessMessage('Lỗi kết nối', 'error');
                });
        });
    }
</script>