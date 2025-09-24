<!-- 
	Author: Nguyen Xuan Duong
	Date: 2025-09-05
	Purpose: Build Amenity Index
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOSTY - Quản lý tài sản</title>
    <!-- Include Libraries -->
    <?php include VIEW_PATH . '/landlord/layouts/app.php'; ?>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <?php include VIEW_PATH . '/landlord/layouts/header.php'; ?>

    <!-- Navigation Menu -->
    <?php include VIEW_PATH . '/landlord/layouts/nav.php'; ?>

    <!-- Main Content -->
    <main class="min-h-screen bg-gray-100 w-full">
        <div class="bg-white min-h-screen p-6">
            <div class="max-w-full mx-auto">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-1 h-8 bg-green-600 mr-3"></div>
                        <div>
                            <h3 class="text-base font-medium text-gray-800">Quản lý tài sản:</h3>
                            <p class="text-gray-600 italic mt-1 text-sm">Các tài sản và thiết bị trong nhà trọ</p>
                        </div>
                    </div>
                    <button onclick="openAmenityModal()" class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>
                </div>

                <!-- Amenity Table -->
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <?php if (!empty($amenities)): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300">Tên tài sản</th>
                                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300">Giá trị tài sản</th>
                                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300">Tổng số lượng</th>
                                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300">Phòng đang áp dụng</th>
                                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <?php foreach ($amenities as $amenity): ?>
                                        <?php 
                                        $totalQuantity = $amenity['quantity'];
                                        $totalValue = $amenity['amenity_price'] * $totalQuantity;
                                        ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap border border-gray-300">
                                                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($amenity['amenity_name']) ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border border-gray-300">
                                                <div class="text-sm text-gray-900"><?= \Helpers\Format::forMatPrice($amenity['amenity_price']) ?>đ/<?= htmlspecialchars($amenity['unit']) ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center border border-gray-300">
                                                <span class="text-sm font-medium text-gray-900">
                                                    <?= $totalQuantity ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 border border-gray-300">
                                                <?php if (!empty($amenity['used_rooms'])): ?>
                                                    <div class="flex flex-wrap gap-1">
                                                        <?php foreach ($amenity['used_rooms'] as $room): ?>
                                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white" style="background-color: #7DC242;">
                                                                <?= htmlspecialchars($room['room_name']) ?>
                                                                <?php if ($room['quantity'] > 1): ?>
                                                                    <span class="ml-1">(<?= $room['quantity'] ?>)</span>
                                                                <?php endif; ?>
                                                            </span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-sm text-gray-400 italic">Chưa có phòng nào áp dụng</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium border border-gray-300">
                                                <div class="flex items-center justify-center">
                                                    <!-- Dropdown Button -->
                                                    <div class="relative">
                                                        <button onclick="toggleAmenityActions(<?= $amenity['id'] ?>)" class="w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors border border-gray-300" title="Thao tác">
                                                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                            </svg>
                                                        </button>
                                                        
                                                        <!-- Dropdown Menu -->
                                                        <div id="amenityActions-<?= $amenity['id'] ?>" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                                                            <div class="py-1">
                                                                <!-- Edit Option -->
                                                                <button onclick="editAmenity(<?= $amenity['id'] ?>); toggleAmenityActions(<?= $amenity['id'] ?>)" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                                                    <svg class="w-4 h-4 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                                    </svg>
                                                                    Chỉnh sửa
                                                                </button>
                                                                
                                                                <!-- Delete Option -->
                                                                <button onclick="deleteAmenity(<?= $amenity['id'] ?>, '<?= htmlspecialchars($amenity['amenity_name']) ?>', <?= $amenity['can_delete'] ? 'true' : 'false' ?>, '<?= htmlspecialchars($amenity['delete_reason']) ?>'); toggleAmenityActions(<?= $amenity['id'] ?>)" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                                    <svg class="w-4 h-4 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                    </svg>
                                                                    Xóa
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Chưa có tài sản nào</h3>
                            <p class="mt-2 text-gray-500">Bắt đầu bằng cách thêm tài sản đầu tiên cho nhà trọ.</p>
                            <div class="mt-6">
                                <button onclick="openAmenityModal()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Thêm tài sản
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

<!-- Amenity Modal -->
<div id="amenityModal" class="modal-container hidden">
    <div class="modal-content flex flex-col overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0 bg-white">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-cube text-white text-sm"></i>
                </div>
                <h2 id="amenityModalTitle" class="text-xl font-semibold text-gray-800">Thêm tài sản mới</h2>
            </div>
            <button onclick="closeAmenityModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Form -->
        <form id="amenityForm" method="POST" action="<?= BASE_URL ?>/landlord/amenity/create" onsubmit="return validateAmenityForm()" class="flex flex-col flex-1 min-h-0">
            <input type="hidden" id="amenity_id" name="amenity_id" value="">
            <?= \Core\CSRF::getTokenField() ?>
            <input type="hidden" name="house_id" value="<?= $selectedHouse['id'] ?? '' ?>">

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6 min-h-0" style="max-height: calc(90vh - 200px);">
                <!-- Thông tin cơ bản -->
                <div class="mb-6">
                    <div class="flex mb-4">
                        <div class="w-1 bg-green-600 mr-3"></div>
                        <div>
                            <h3 class="text-base font-medium text-gray-800">Thông tin cơ bản:</h3>
                            <p class="text-gray-600 italic mt-1 text-sm">Thông tin cơ bản về tài sản mới</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Tên tài sản -->
                        <div class="relative">
                            <input type="text" id="amenity_name" name="amenity_name" required class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                            <label for="amenity_name" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tên tài sản <span class="text-red-500">*</span></label>
                        </div>

                        <!-- Giá tài sản -->
                        <div class="relative">
                            <input type="number" id="amenity_price" name="amenity_price" min="0" step="1000" required class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                            <label for="amenity_price" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Giá tài sản (VNĐ) <span class="text-red-500">*</span></label>
                        </div>

                        <!-- Số lượng -->
                        <div class="relative">
                            <input type="number" id="quantity" name="quantity" min="1" required class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                            <label for="quantity" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Số lượng <span class="text-red-500">*</span></label>
                        </div>

                        <!-- Đơn vị -->
                        <div class="relative">
                            <select id="unit" name="unit" required class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                <option value="">Chọn đơn vị</option>
                                <?php
                                // Lấy các giá trị enum từ controller
                                foreach ($unitOptions as $unit): ?>
                                    <option value="<?= $unit ?>"><?= ucfirst($unit) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="unit" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Đơn vị <span class="text-red-500">*</span></label>
                        </div>
                    </div>
                </div>


                    <!-- Chọn phòng muốn áp dụng -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-1 h-8 bg-green-600 mr-3"></div>
                                <div>
                                    <h3 class="text-base font-medium text-gray-800">Chọn phòng muốn áp dụng:</h3>
                                    <p class="text-gray-600 italic mt-1 text-sm">Chọn các phòng sẽ sử dụng tài sản này</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600">
                                <span id="selected-count">0</span>/<span id="max-quantity">0</span> phòng
                            </div>
                        </div>

                        <!-- Danh sách phòng -->
                        <div class="grid grid-cols-2 gap-3" id="rooms-container">
                            <?php if (!empty($rooms)): ?>
                                <?php foreach ($rooms as $room): ?>
                                    <div class="flex items-center p-3 border border-[#DBDBDB] rounded-lg hover:bg-gray-50 room-item" data-room-id="<?= $room['id'] ?>">
                                        <input type="checkbox" id="room_<?= $room['id'] ?>" name="rooms[]" value="<?= $room['id'] ?>" class="mr-3 room-checkbox">
                                        <label for="room_<?= $room['id'] ?>" class="text-sm text-gray-700 room-label"><?= htmlspecialchars($room['room_name']) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-span-2 text-center text-gray-500 py-4">
                                    <div class="text-sm">
                                        <p>Chưa có phòng nào trong nhà này</p>
                                        <p class="text-xs mt-1">Bạn vẫn có thể tạo tài sản và gán phòng sau</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
            </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 p-6 border-t border-gray-200 flex-shrink-0 bg-white">
                    <button type="button" onclick="closeAmenityModal()" class="px-6 py-2 text-gray-600 hover:text-gray-800 transition-colors mr-3">
                        Hủy
                    </button>
                    <button type="submit" id="amenitySubmitBtn" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        Tạo tài sản
                    </button>
                </div>
        </form>
    </div>
</div>

<script>
// Modal functions
function openAmenityModal() {
    document.getElementById('amenityModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    // Reset form to create mode
    resetAmenityFormToCreate();
    // Update room selection
    updateRoomSelection();
}

function closeAmenityModal() {
    document.getElementById('amenityModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    // Reset form when closing modal
    document.getElementById('amenityForm').reset();

    // Uncheck select all checkbox
    document.getElementById('selectAllCheckbox').checked = false;

    // Reset form to create mode
    resetAmenityFormToCreate();
}

function resetAmenityFormToCreate() {
    // Reset form action
    document.getElementById('amenityForm').action = `${App.appURL}landlord/amenity/create`;
    
    // Reset modal title
    document.getElementById('amenityModalTitle').textContent = 'Thêm tài sản mới';
    
    // Reset submit button
    document.getElementById('amenitySubmitBtn').innerHTML = 'Tạo tài sản';
    
    // Clear hidden ID field
    document.getElementById('amenity_id').value = '';
}

function editAmenity(amenityId) {
    // Lấy thông tin tài sản từ danh sách amenities
    const amenities = <?= json_encode($amenities) ?>;
    const amenity = amenities.find(a => a.id == amenityId);

    if (!amenity) {
        Swal.fire({
            title: 'Lỗi',
            text: 'Không tìm thấy thông tin tài sản!',
            icon: 'error',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Đóng'
        });
        return;
    }

    // Mở modal
    document.getElementById('amenityModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Điền dữ liệu vào form
    document.getElementById('amenity_id').value = amenity.id;
    document.getElementById('amenity_name').value = amenity.amenity_name;
    document.getElementById('amenity_price').value = amenity.amenity_price;
    document.getElementById('quantity').value = amenity.quantity;
    document.getElementById('unit').value = amenity.unit;

    // Lấy danh sách phòng đang áp dụng tài sản này
    fetch(`${App.appURL}landlord/amenity/get-rooms/` + amenityId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Uncheck tất cả phòng trước
                const roomCheckboxes = document.querySelectorAll('input[name="rooms[]"]');
                roomCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Check các phòng đang áp dụng
                data.rooms.forEach(room => {
                    const checkbox = document.getElementById('room_' + room.room_id);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });

                // Cập nhật room selection sau khi load dữ liệu
                updateRoomSelection();
            }
        })
        .catch(error => {
            console.error('Error fetching amenity rooms:', error);
        });

    // Thay đổi tiêu đề modal
    document.getElementById('amenityModalTitle').textContent = 'Chỉnh sửa tài sản';

    // Thay đổi nút submit
    document.getElementById('amenitySubmitBtn').innerHTML = 'Cập nhật tài sản';

    // Thay đổi form action
    document.getElementById('amenityForm').action = `${App.appURL}landlord/amenity/update`;
}

function deleteAmenity(amenityId, amenityName, canDelete, deleteReason) {
    if (!canDelete) {
        Swal.fire({
            title: 'Không thể xóa tài sản',
            text: deleteReason,
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Đóng'
        });
        return;
    }
    
    Swal.fire({
        title: 'Xác nhận xóa tài sản',
        html: `Bạn có chắc chắn muốn xóa tài sản "<strong>${amenityName}</strong>"?<br>Tài sản sẽ được gỡ bỏ khỏi tất cả phòng trống.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Xóa tài sản',
        cancelButtonText: 'Hủy bỏ',
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Tạo form ẩn để submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `${App.appURL}landlord/amenity/delete`;
            
            // Thêm CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
            
            // Thêm amenity_id
            const amenityIdInput = document.createElement('input');
            amenityIdInput.type = 'hidden';
            amenityIdInput.name = 'amenity_id';
            amenityIdInput.value = amenityId;
            form.appendChild(amenityIdInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Form validation
function validateAmenityForm() {
    const amenityName = document.getElementById('amenity_name').value.trim();
    const amenityPrice = document.getElementById('amenity_price').value.trim();
    const quantity = document.getElementById('quantity').value.trim();
    const unit = document.getElementById('unit').value;

    // Validate required fields
    if (!amenityName) {
        alert('Vui lòng nhập tên tài sản!');
        document.getElementById('amenity_name').focus();
        return false;
    }

    if (!amenityPrice || amenityPrice <= 0) {
        alert('Vui lòng nhập giá tài sản hợp lệ!');
        document.getElementById('amenity_price').focus();
        return false;
    }

    if (!quantity || quantity <= 0) {
        alert('Vui lòng nhập số lượng hợp lệ!');
        document.getElementById('quantity').focus();
        return false;
    }

    if (!unit) {
        alert('Vui lòng chọn đơn vị!');
        document.getElementById('unit').focus();
        return false;
    }

    return true;
}

// Quantity-based room selection logic
function updateRoomSelection() {
    const quantityInput = document.getElementById('quantity');
    const maxQuantity = parseInt(quantityInput.value) || 0;
    const roomCheckboxes = document.querySelectorAll('.room-checkbox');
    const selectedCountSpan = document.getElementById('selected-count');
    const maxQuantitySpan = document.getElementById('max-quantity');
    
    // Update max quantity display
    maxQuantitySpan.textContent = maxQuantity;
    
    // Count currently selected rooms
    const selectedCount = Array.from(roomCheckboxes).filter(cb => cb.checked).length;
    selectedCountSpan.textContent = selectedCount;
    
    // Enable all checkboxes (all rooms can be selected)
    roomCheckboxes.forEach((checkbox) => {
        const roomItem = checkbox.closest('.room-item');
        const roomLabel = roomItem.querySelector('.room-label');
        
        checkbox.disabled = false;
        roomItem.classList.remove('opacity-50', 'cursor-not-allowed');
        roomItem.classList.add('hover:bg-gray-50');
        roomLabel.classList.remove('text-gray-400');
        roomLabel.classList.add('text-gray-700');
    });
    
    // If current selection exceeds max quantity, uncheck excess rooms
    if (selectedCount > maxQuantity) {
        const checkedBoxes = Array.from(roomCheckboxes).filter(cb => cb.checked);
        for (let i = maxQuantity; i < checkedBoxes.length; i++) {
            checkedBoxes[i].checked = false;
        }
        selectedCountSpan.textContent = maxQuantity;
    }
}

// Listen for quantity changes
document.getElementById('quantity').addEventListener('input', updateRoomSelection);

// Listen for room checkbox changes
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('room-checkbox')) {
        const maxQuantity = parseInt(document.getElementById('quantity').value) || 0;
        const selectedCount = Array.from(document.querySelectorAll('.room-checkbox')).filter(cb => cb.checked).length;
        
        // If trying to select more than allowed, prevent it
        if (selectedCount > maxQuantity) {
            e.target.checked = false;
            return;
        }
        
        // Update counter
        document.getElementById('selected-count').textContent = selectedCount;
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateRoomSelection();
});

// Close modal when clicking outside
document.getElementById('amenityModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAmenityModal();
    }
});

// Toggle amenity actions dropdown
function toggleAmenityActions(amenityId) {
    // Close all other dropdowns first
    const allDropdowns = document.querySelectorAll('[id^="amenityActions-"]');
    allDropdowns.forEach(dropdown => {
        if (dropdown.id !== `amenityActions-${amenityId}`) {
            dropdown.classList.add('hidden');
        }
    });
    
    // Toggle the current dropdown
    const dropdown = document.getElementById(`amenityActions-${amenityId}`);
    if (dropdown) {
        dropdown.classList.toggle('hidden');
    }
}

// Close all dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.relative')) {
        const dropdowns = document.querySelectorAll('[id^="amenityActions-"]');
        dropdowns.forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});
</script>

<?php include VIEW_PATH . '/landlord/layouts/footer.php'; ?>
</body>
</html>
