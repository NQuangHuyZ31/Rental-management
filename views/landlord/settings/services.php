<!-- 
    Author: Huy Nguyen
    Date: 2025-01-15
    Purpose: Services management for landlord
-->

<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Quản lý dịch vụ</h1>
            <p class="text-gray-600 mt-2">Tạo và quản lý các dịch vụ cho phòng thuê</p>
        </div>
        <button onclick="openCreateModal()" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Thêm dịch vụ
        </button>
    </div>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($services as $service) { ?>
            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-concierge-bell text-orange-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($service['service_name']) ?></h3>
                            <p class="text-sm text-gray-600"><?= htmlspecialchars($service['description']) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="openEditModal(<?= htmlspecialchars(json_encode($service)) ?>)" 
                                class="text-blue-600 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50 transition-colors">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteService(<?= $service['id'] ?>)" 
                                class="text-red-600 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Loại dịch vụ:</span>
                        <span class="text-sm font-medium text-gray-900"><?= ucfirst($service['service_type']) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Giá:</span>
                        <span class="text-sm font-medium text-orange-600"><?= number_format($service['service_price']) ?>đ</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Đơn vị:</span>
                        <span class="text-sm font-medium text-gray-900"><?= $service['unit_vi'] ?></span>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $service['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                            <i class="fas <?= $service['is_active'] ? 'fa-check' : 'fa-times' ?> mr-1"></i>
                            <?= $service['is_active'] ? 'Hoạt động' : 'Tạm dừng' ?>
                        </span>
                    </div>
                    <div class="text-sm text-gray-500">
                        <?= date('d/m/Y', strtotime($service['created_at'])) ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Empty State -->
    <?php if (empty($services)) { ?>
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-concierge-bell text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Chưa có dịch vụ nào</h3>
            <p class="text-gray-600 mb-6">Tạo dịch vụ đầu tiên để quản lý các dịch vụ phòng</p>
            <button onclick="openCreateModal()" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Tạo dịch vụ đầu tiên
            </button>
        </div>
    <?php } ?>
</div>

<!-- Create/Edit Modal -->
<div id="serviceModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 id="modalTitle" class="text-xl font-semibold text-gray-900">Thêm dịch vụ mới</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="serviceForm" class="space-y-4">
                <input type="hidden" id="serviceId" name="id">
                
                <!-- Service Name -->
                <div>
                    <label for="service_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Tên dịch vụ <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="service_name" name="service_name" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                           placeholder="VD: Điện, Nước, Internet" required>
                </div>

                <!-- Service Type -->
                <div>
                    <label for="service_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Loại dịch vụ <span class="text-red-500">*</span>
                    </label>
                    <select id="service_type" name="service_type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                        <option value="">Chọn loại dịch vụ</option>
                        <option value="electric">Điện</option>
                        <option value="water">Nước</option>
                        <option value="internet">Internet</option>
                        <option value="parking">Gửi xe</option>
                        <option value="garbage">Rác</option>
                        <option value="other">Khác</option>
                    </select>
                </div>

                <!-- Service Price -->
                <div>
                    <label for="service_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Giá dịch vụ <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="service_price" name="service_price" min="0" step="1000"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                           placeholder="0" required>
                </div>

                <!-- Unit -->
                <div>
                    <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                        Đơn vị <span class="text-red-500">*</span>
                    </label>
                    <select id="unit" name="unit" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                        <option value="">Chọn đơn vị</option>
                        <option value="KWH">KWH (Điện)</option>
                        <option value="m3">m³ (Nước)</option>
                        <option value="month">Tháng</option>
                        <option value="day">Ngày</option>
                        <option value="time">Lần</option>
                    </select>
                </div>

                <!-- Unit Vietnamese -->
                <div>
                    <label for="unit_vi" class="block text-sm font-medium text-gray-700 mb-2">
                        Đơn vị (Tiếng Việt) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="unit_vi" name="unit_vi" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                           placeholder="VD: kWh, m³, tháng" required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Mô tả
                    </label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                              placeholder="Mô tả ngắn về dịch vụ"></textarea>
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" checked class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm text-gray-700">Kích hoạt dịch vụ</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Hủy
                    </button>
                    <button type="submit" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-colors">
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

function openCreateModal() {
    isEditMode = false;
    document.getElementById('modalTitle').textContent = 'Thêm dịch vụ mới';
    document.getElementById('serviceForm').reset();
    document.getElementById('serviceId').value = '';
    document.getElementById('is_active').checked = true;
    document.getElementById('serviceModal').classList.remove('hidden');
}

function openEditModal(service) {
    isEditMode = true;
    document.getElementById('modalTitle').textContent = 'Chỉnh sửa dịch vụ';
    document.getElementById('serviceId').value = service.id;
    document.getElementById('service_name').value = service.service_name;
    document.getElementById('service_type').value = service.service_type;
    document.getElementById('service_price').value = service.service_price;
    document.getElementById('unit').value = service.unit;
    document.getElementById('unit_vi').value = service.unit_vi;
    document.getElementById('description').value = service.description || '';
    document.getElementById('is_active').checked = service.is_active == 1;
    document.getElementById('serviceModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('serviceModal').classList.add('hidden');
}

function deleteService(id) {
    if (confirm('Bạn có chắc chắn muốn xóa dịch vụ này?')) {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('csrf_token', App.getToken());
        
        fetch('<?= BASE_URL ?>/landlord/settings/delete-service', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                toastr.success(data.message);
                window.location.reload();
            } else {
                toastr.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Có lỗi xảy ra khi xóa dịch vụ');
        });
    }
}

// Handle form submission
document.getElementById('serviceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('csrf_token', App.getToken());
    
    const url = isEditMode ? 
        '<?= BASE_URL ?>/landlord/settings/update-service' : 
        '<?= BASE_URL ?>/landlord/settings/create-service';
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang lưu...';
    submitBtn.disabled = true;
    
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            toastr.success(data.message);
            closeModal();
            window.location.reload();
        } else {
            toastr.error(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('Có lỗi xảy ra khi lưu dịch vụ');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});
</script>
