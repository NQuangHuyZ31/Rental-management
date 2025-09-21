<!-- 
    Author: Huy Nguyen
    Date: 2025-01-15
    Purpose: Amenities management for landlord
-->

<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Quản lý tiện ích</h1>
            <p class="text-gray-600 mt-2">Tạo và quản lý các tiện ích cho phòng thuê</p>
        </div>
        <button onclick="openCreateModal()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Thêm tiện ích
        </button>
    </div>

    <!-- Amenities Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($amenities as $amenity) { ?>
            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-3" style="background-color: <?= $amenity['color'] ?>20; color: <?= $amenity['color'] ?>">
                            <i class="<?= $amenity['icon'] ?> text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($amenity['amenity_name']) ?></h3>
                            <p class="text-sm text-gray-600"><?= htmlspecialchars($amenity['description']) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="openEditModal(<?= htmlspecialchars(json_encode($amenity)) ?>)" 
                                class="text-blue-600 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50 transition-colors">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteAmenity(<?= $amenity['id'] ?>)" 
                                class="text-red-600 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $amenity['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                            <i class="fas <?= $amenity['is_active'] ? 'fa-check' : 'fa-times' ?> mr-1"></i>
                            <?= $amenity['is_active'] ? 'Hoạt động' : 'Tạm dừng' ?>
                        </span>
                    </div>
                    <div class="text-sm text-gray-500">
                        <?= date('d/m/Y', strtotime($amenity['created_at'])) ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Empty State -->
    <?php if (empty($amenities)) { ?>
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-star text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Chưa có tiện ích nào</h3>
            <p class="text-gray-600 mb-6">Tạo tiện ích đầu tiên để quản lý các tiện ích phòng</p>
            <button onclick="openCreateModal()" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Tạo tiện ích đầu tiên
            </button>
        </div>
    <?php } ?>
</div>

<!-- Create/Edit Modal -->
<div id="amenityModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 id="modalTitle" class="text-xl font-semibold text-gray-900">Thêm tiện ích mới</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="amenityForm" class="space-y-4">
                <input type="hidden" id="amenityId" name="id">
                
                <!-- Amenity Name -->
                <div>
                    <label for="amenity_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Tên tiện ích <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="amenity_name" name="amenity_name" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                           placeholder="VD: Máy lạnh, Wifi, Tủ lạnh" required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Mô tả
                    </label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                              placeholder="Mô tả ngắn về tiện ích"></textarea>
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                        Icon
                    </label>
                    <div class="grid grid-cols-6 gap-2 mb-2">
                        <button type="button" onclick="selectIcon('fas fa-wifi')" class="icon-btn p-2 border border-gray-300 rounded hover:bg-purple-50">
                            <i class="fas fa-wifi"></i>
                        </button>
                        <button type="button" onclick="selectIcon('fas fa-snowflake')" class="icon-btn p-2 border border-gray-300 rounded hover:bg-purple-50">
                            <i class="fas fa-snowflake"></i>
                        </button>
                        <button type="button" onclick="selectIcon('fas fa-tv')" class="icon-btn p-2 border border-gray-300 rounded hover:bg-purple-50">
                            <i class="fas fa-tv"></i>
                        </button>
                        <button type="button" onclick="selectIcon('fas fa-car')" class="icon-btn p-2 border border-gray-300 rounded hover:bg-purple-50">
                            <i class="fas fa-car"></i>
                        </button>
                        <button type="button" onclick="selectIcon('fas fa-swimming-pool')" class="icon-btn p-2 border border-gray-300 rounded hover:bg-purple-50">
                            <i class="fas fa-swimming-pool"></i>
                        </button>
                        <button type="button" onclick="selectIcon('fas fa-dumbbell')" class="icon-btn p-2 border border-gray-300 rounded hover:bg-purple-50">
                            <i class="fas fa-dumbbell"></i>
                        </button>
                    </div>
                    <input type="text" id="icon" name="icon" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                           placeholder="fas fa-wifi" value="fas fa-wifi">
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                        Màu sắc
                    </label>
                    <div class="grid grid-cols-8 gap-2 mb-2">
                        <button type="button" onclick="selectColor('#10B981')" class="color-btn w-8 h-8 rounded border-2 border-gray-300" style="background-color: #10B981"></button>
                        <button type="button" onclick="selectColor('#3B82F6')" class="color-btn w-8 h-8 rounded border-2 border-gray-300" style="background-color: #3B82F6"></button>
                        <button type="button" onclick="selectColor('#8B5CF6')" class="color-btn w-8 h-8 rounded border-2 border-gray-300" style="background-color: #8B5CF6"></button>
                        <button type="button" onclick="selectColor('#F59E0B')" class="color-btn w-8 h-8 rounded border-2 border-gray-300" style="background-color: #F59E0B"></button>
                        <button type="button" onclick="selectColor('#EF4444')" class="color-btn w-8 h-8 rounded border-2 border-gray-300" style="background-color: #EF4444"></button>
                        <button type="button" onclick="selectColor('#EC4899')" class="color-btn w-8 h-8 rounded border-2 border-gray-300" style="background-color: #EC4899"></button>
                        <button type="button" onclick="selectColor('#06B6D4')" class="color-btn w-8 h-8 rounded border-2 border-gray-300" style="background-color: #06B6D4"></button>
                        <button type="button" onclick="selectColor('#84CC16')" class="color-btn w-8 h-8 rounded border-2 border-gray-300" style="background-color: #84CC16"></button>
                    </div>
                    <input type="text" id="color" name="color" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                           placeholder="#10B981" value="#10B981">
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" checked class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-700">Kích hoạt tiện ích</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Hủy
                    </button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors">
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
    document.getElementById('modalTitle').textContent = 'Thêm tiện ích mới';
    document.getElementById('amenityForm').reset();
    document.getElementById('amenityId').value = '';
    document.getElementById('icon').value = 'fas fa-wifi';
    document.getElementById('color').value = '#10B981';
    document.getElementById('is_active').checked = true;
    document.getElementById('amenityModal').classList.remove('hidden');
}

function openEditModal(amenity) {
    isEditMode = true;
    document.getElementById('modalTitle').textContent = 'Chỉnh sửa tiện ích';
    document.getElementById('amenityId').value = amenity.id;
    document.getElementById('amenity_name').value = amenity.amenity_name;
    document.getElementById('description').value = amenity.description || '';
    document.getElementById('icon').value = amenity.icon;
    document.getElementById('color').value = amenity.color;
    document.getElementById('is_active').checked = amenity.is_active == 1;
    document.getElementById('amenityModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('amenityModal').classList.add('hidden');
}

function selectIcon(icon) {
    document.getElementById('icon').value = icon;
    // Update visual selection
    document.querySelectorAll('.icon-btn').forEach(btn => btn.classList.remove('bg-purple-100', 'border-purple-500'));
    event.target.closest('.icon-btn').classList.add('bg-purple-100', 'border-purple-500');
}

function selectColor(color) {
    document.getElementById('color').value = color;
    // Update visual selection
    document.querySelectorAll('.color-btn').forEach(btn => btn.classList.remove('border-purple-500', 'border-4'));
    event.target.classList.add('border-purple-500', 'border-4');
}

function deleteAmenity(id) {
    if (confirm('Bạn có chắc chắn muốn xóa tiện ích này?')) {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('csrf_token', App.getToken());
        
        fetch(`${App.appURL}landlord/settings/delete-amenity`, {
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
            toastr.error('Có lỗi xảy ra khi xóa tiện ích');
        });
    }
}

// Handle form submission
document.getElementById('amenityForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('csrf_token', App.getToken());
    
    const url = isEditMode ? 
        `${App.appURL}landlord/settings/update-amenity` : 
        `${App.appURL}landlord/settings/create-amenity`;
    
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
        toastr.error('Có lỗi xảy ra khi lưu tiện ích');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});
</script>
