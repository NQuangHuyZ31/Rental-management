<!-- 
	Author: Nguyen Xuan Duong
	Date: 2025-08-31
	Purpose: Build Service Index
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOSTY - Quản lý dịch vụ</title>
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
                <div class="flex gap-8">
                    <!-- Left Column: Service Management (25%) -->
                    <div class="w-1/4">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-1 h-8 bg-green-600 mr-3"></div>
                                <div>
                                    <h3 class="text-base font-medium text-gray-800">Quản lý dịch vụ:</h3>
                                    <p class="text-gray-600 italic mt-1 text-sm">Các dịch vụ khách thuê sử dụng</p>
                                </div>
                            </div>
                            <button onclick="openAddServiceModal()" class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Service List -->
                        <div class="space-y-4">
                            <?php if (!empty($services)): ?>
                                <?php foreach ($services as $service): ?>
                                    <div class="bg-white border border-[#DCDCDC] rounded-lg p-4 flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($service['service_name']) ?> (<?= htmlspecialchars($service['unit_vi']) ?>)</h3>
                                                <p class="text-gray-600 text-sm"><?= \Helpers\Format::forMatPrice($service['service_price']) ?>đ/ <?= htmlspecialchars($service['unit_vi']) ?></p>
                                                <p class="text-green-600 text-sm">Đang áp dụng cho <?= $service['room_count'] ?? 0 ?> phòng</p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button onclick="editService(<?= $service['id'] ?>)" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors" title="Chỉnh sửa dịch vụ">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="deleteService(<?= $service['id'] ?>, '<?= htmlspecialchars($service['service_name']) ?>', <?= $service['can_delete'] ? 'true' : 'false' ?>, '<?= htmlspecialchars($service['delete_reason']) ?>')" class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors" title="Xóa dịch vụ">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="bg-white border border-[#DCDCDC] rounded-lg p-8 text-center">
                                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có dịch vụ nào</h3>
                                    <p class="text-gray-500 mb-4">Bạn chưa tạo dịch vụ nào cho nhà trọ này</p>
                                    <button onclick="openAddServiceModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                        <i class="fas fa-plus mr-2"></i>Tạo dịch vụ đầu tiên
                                    </button>
                                </div>
                            <?php endif; ?>


                        </div>
                    </div>

                    <!-- Right Column: Tenant Usage Statistics (75%) -->
                    <div class="w-3/4">
                        <div class="flex items-center mb-6">
                            <div class="w-1 h-8 bg-green-600 mr-3"></div>
                            <div>
                                <h3 class="text-base font-medium text-gray-800">Khách thuê sử dụng trong tháng:</h3>
                                <p class="text-gray-600 italic mt-1 text-sm">Thống kê mỗi tháng khách thuê sử dụng</p>
                            </div>
                        </div>

                        <!-- Date Selector -->
                        <div class="flex items-center mb-6">
                            <div class="flex items-center space-x-4">
                                <label class="text-sm font-medium text-gray-700">Tháng lập phiếu:</label>
                                <div class="relative">
                                    <input type="text" id="monthYearInput" readonly class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none cursor-pointer bg-white" placeholder="Chọn tháng/năm">
                                    <svg class="w-5 h-5 text-gray-400 absolute right-3 top-2.5 cursor-pointer" id="calendarIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>

                                    <!-- Month/Year Picker Overlay -->
                                    <div id="monthYearPicker" class="hidden absolute top-full left-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 w-64">
                                        <!-- Year Navigation -->
                                        <div class="flex items-center justify-between p-3 border-b border-gray-200">
                                            <button id="prevYear" class="text-gray-600 hover:text-gray-800 p-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                </svg>
                                            </button>
                                            <span id="currentYear" class="font-medium text-gray-900">2025</span>
                                            <button id="nextYear" class="text-gray-600 hover:text-gray-800 p-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Months Grid -->
                                        <div class="p-3">
                                            <div class="grid grid-cols-4 gap-2">
                                                <button class="month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="01">Th1</button>
                                                <button class="month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="02">Th2</button>
                                                <button class="month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="03">Th3</button>
                                                <button class="month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="04">Th4</button>
                                                <button class="month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="05">Th5</button>
                                                <button class="month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="06">Th6</button>
                                                <button class="month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="07">Th7</button>
                                                <button class="month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="08">Th8</button>
                                                <button class="month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="09">Th9</button>
                                                <button class="month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="10">Th10</button>
                                                <button class="month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="11">Th11</button>
                                                <button class="month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="12">Th12</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Table -->
                        <div class="overflow-x-auto">
                            <table id="usageTable" class="min-w-full bg-white border border-gray-300 rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-900 tracking-wider border border-gray-300" rowspan="2">Tên phòng</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300" colspan="2">Tiền điện</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300" colspan="2">Tiền nước</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300" colspan="2">Tiền rác</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300" colspan="2">Tiền wifi</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300" colspan="2">Tiền xe</th>
                                    </tr>
                                    <tr>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300">Sử dụng</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300">Thành tiền</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300">Sử dụng</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300">Thành tiền</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300">Sử dụng</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300">Thành tiền</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300">Sử dụng</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300">Thành tiền</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300">Sử dụng</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody id="usageTableBody">
                                    <!-- Dữ liệu sẽ được load động -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Loading State -->
                        <div id="loadingState" class="hidden text-center py-8">
                            <div class="inline-flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-gray-600">Đang tải dữ liệu...</span>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div class="text-center py-12 hidden" id="emptyState">
                            <div class="w-48 h-48 mx-auto mb-4">
                                <img src="<?= BASE_URL . '/Public/images/admin/empty-houses.jpg' ?>" alt="Không có dữ liệu" class="w-full h-full object-cover rounded-lg">
                            </div>
                            <p class="text-gray-500 text-lg" id="emptyStateMessage">Không có dữ liệu sử dụng dịch vụ nào!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <?php include VIEW_PATH . '/landlord/layouts/footer.php'; ?>

    <!-- Modal thêm dịch vụ mới -->
    <div id="addServiceModal" class="modal-container hidden">
        <div class="modal-content flex flex-col overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0 bg-white">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-concierge-bell text-white text-sm"></i>
                    </div>
                    <h2 id="serviceModalTitle" class="text-xl font-semibold text-gray-800">Thêm dịch vụ mới</h2>
                </div>
                <button onclick="closeAddServiceModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Form -->
            <form id="serviceForm" method="POST" action="<?= BASE_URL ?>/landlord/service/create" onsubmit="return validateServiceForm()" class="flex flex-col flex-1 min-h-0">
                <input type="hidden" id="service_id" name="service_id" value="">
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
                                <p class="text-gray-600 italic mt-1 text-sm">Thông tin cơ bản về dịch vụ mới</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Tên dịch vụ -->
                            <div class="relative">
                                <input type="text" id="service_name" name="service_name" required class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                <label for="service_name" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tên dịch vụ <span class="text-red-500">*</span></label>
                            </div>

                            <!-- Loại dịch vụ -->
                            <div class="relative">
                                <select id="service_type" name="service_type" required class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                    <option value="">Chọn loại dịch vụ</option>
                                    <option value="electric">Điện</option>
                                    <option value="water">Nước</option>
                                    <option value="internet">Internet</option>
                                    <option value="garbage">Rác</option>
                                    <option value="parking">Gửi xe</option>
                                    <option value="other">Khác</option>
                                </select>
                                <label for="service_type" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Loại dịch vụ <span class="text-red-500">*</span></label>
                            </div>
                        </div>
                    </div>

                    <!-- Đơn vị và giá -->
                    <div class="mb-6">
                        <div class="flex mb-4">
                            <div class="w-1 bg-green-600 mr-3"></div>
                            <div>
                                <h3 class="text-base font-medium text-gray-800">Đơn vị và giá:</h3>
                                <p class="text-gray-600 italic mt-1 text-sm">Nhập thông tin đơn vị tính và giá</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Đơn vị -->
                            <div class="relative">
                                <select id="unit" name="unit" required class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                    <option value="">Chọn đơn vị</option>
                                    <option value="KWH">KWH</option>
                                    <option value="m3">m³</option>
                                    <option value="month">Tháng</option>
                                    <option value="person">Người</option>
                                </select>
                                <label for="unit" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Đơn vị <span class="text-red-500">*</span></label>
                            </div>

                            <!-- Giá dịch vụ -->
                            <div class="relative">
                                <input type="number" id="service_price" name="service_price" min="0" step="100" required class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                <label for="service_price" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Giá dịch vụ (VNĐ) <span class="text-red-500">*</span></label>
                            </div>
                        </div>
                    </div>

                    <!-- Chọn phòng muốn áp dụng -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-1 h-8 bg-green-600 mr-3"></div>
                                <div>
                                    <h3 class="text-base font-medium text-gray-800">Chọn phòng muốn áp dụng: <span class="text-gray-500 text-sm font-normal">(Tùy chọn)</span></h3>
                                    <p class="text-gray-600 italic mt-1 text-sm">Danh sách phòng chọn áp dụng - có thể để trống</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="selectAllCheckbox" class="mr-3 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <label for="selectAllCheckbox" class="text-sm font-medium text-gray-900">Chọn tất cả</label>
                            </div>
                        </div>

                        <!-- Danh sách phòng -->
                        <div class="grid grid-cols-2 gap-3">
                            <?php if (!empty($rooms)): ?>
                                <?php foreach ($rooms as $room): ?>
                                    <div class="flex items-center p-3 border border-[#DBDBDB] rounded-lg hover:bg-gray-50">
                                        <input type="checkbox" id="room_<?= $room['id'] ?>" name="rooms[]" value="<?= $room['id'] ?>" class="mr-3">
                                        <label for="room_<?= $room['id'] ?>" class="text-sm text-gray-700">Phòng <?= htmlspecialchars($room['room_number'] ?? $room['id']) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-span-2 text-center text-gray-500 py-4">
                                    <div class="text-sm">
                                        <p>Chưa có phòng nào trong nhà này</p>
                                        <p class="text-xs mt-1">Bạn vẫn có thể tạo dịch vụ và gán phòng sau</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 p-6 border-t border-gray-200 flex-shrink-0 bg-white">
                    <button type="button" onclick="closeAddServiceModal()" class="px-6 py-2 text-gray-600 hover:text-gray-800 transition-colors mr-3">
                        Hủy
                    </button>
                    <button type="submit" id="serviceSubmitBtn" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Tạo dịch vụ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Month/Year Picker functionality
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('monthYearInput');
            const icon = document.getElementById('calendarIcon');
            const picker = document.getElementById('monthYearPicker');
            const currentYearSpan = document.getElementById('currentYear');
            const prevYearBtn = document.getElementById('prevYear');
            const nextYearBtn = document.getElementById('nextYear');
            const monthBtns = document.querySelectorAll('.month-btn');

            // Get current date
            const now = new Date();
            let currentYear = now.getFullYear();

            // Set mặc định là tháng trước (tháng đã kết thúc)
            let selectedMonth = now.getMonth(); // getMonth() trả về 0-11, tháng trước sẽ là tháng hiện tại - 1
            if (selectedMonth === 0) {
                // Nếu tháng hiện tại là tháng 1 (0), thì tháng trước là tháng 12 của năm trước
                selectedMonth = 12;
                currentYear = now.getFullYear() - 1;
            }
            selectedMonth = selectedMonth.toString().padStart(2, '0');

            // Toggle picker visibility
            function togglePicker() {
                picker.classList.toggle('hidden');
            }

            // Update input value
            function updateInput() {
                input.value = `${selectedMonth}/${currentYear}`;
            }

            // Update year display
            function updateYearDisplay() {
                currentYearSpan.textContent = currentYear;
            }

            // Highlight selected month
            function highlightSelectedMonth() {
                monthBtns.forEach(btn => {
                    btn.classList.remove('bg-blue-500', 'text-white');
                    btn.classList.add('hover:bg-gray-100');

                    if (btn.dataset.month === selectedMonth) {
                        btn.classList.remove('hover:bg-gray-100');
                        btn.classList.add('bg-blue-500', 'text-white');
                    }
                });
            }

            // Event listeners
            input.addEventListener('click', togglePicker);
            icon.addEventListener('click', togglePicker);

            prevYearBtn.addEventListener('click', function() {
                currentYear--;
                updateYearDisplay();
                // Load lại dữ liệu cho tháng hiện tại với năm mới
                loadUsageData(selectedMonth, currentYear);
            });

            nextYearBtn.addEventListener('click', function() {
                currentYear++;
                updateYearDisplay();
                // Load lại dữ liệu cho tháng hiện tại với năm mới
                loadUsageData(selectedMonth, currentYear);
            });

            monthBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    selectedMonth = btn.dataset.month;
                    updateInput();
                    highlightSelectedMonth();
                    togglePicker();

                    // Load dữ liệu sử dụng cho tháng được chọn
                    loadUsageData(selectedMonth, currentYear);
                });
            });

            // Close picker when clicking outside
            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !picker.contains(e.target)) {
                    picker.classList.add('hidden');
                }
            });

            // Initialize
            updateInput(); // Set initial value in input
            updateYearDisplay();
            highlightSelectedMonth();

            // Load dữ liệu ban đầu cho tháng trước (tháng đã kết thúc)
            loadUsageData(selectedMonth, currentYear);
        });

        // Add Service Modal functionality
        function openAddServiceModal() {
            document.getElementById('addServiceModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            // Reset form to create mode
            resetServiceFormToCreate();
        }

        function closeAddServiceModal() {
            document.getElementById('addServiceModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            // Reset form when closing modal
            document.getElementById('serviceForm').reset();

            // Uncheck select all checkbox
            document.getElementById('selectAllCheckbox').checked = false;

            // Reset form to create mode
            resetServiceFormToCreate();
        }

        function resetServiceFormToCreate() {
            // Reset form action và title
            document.getElementById('serviceForm').action = '<?= BASE_URL ?>/landlord/service/create';
            document.getElementById('serviceModalTitle').textContent = 'Thêm dịch vụ mới';
            document.getElementById('serviceSubmitBtn').innerHTML = '<i class="fas fa-plus mr-2"></i>Tạo dịch vụ';

            // Clear service_id
            document.getElementById('service_id').value = '';

            // Reset form fields
            document.getElementById('serviceForm').reset();

            // Uncheck all room checkboxes
            const roomCheckboxes = document.querySelectorAll('input[name="rooms[]"]');
            roomCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            // Uncheck select all checkbox
            document.getElementById('selectAllCheckbox').checked = false;
        }

        function editService(serviceId) {
            // Lấy thông tin dịch vụ từ danh sách services
            const services = <?= json_encode($services) ?>;
            const service = services.find(s => s.id == serviceId);

            if (!service) {
                Swal.fire({
                    title: 'Lỗi',
                    text: 'Không tìm thấy thông tin dịch vụ!',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Đóng'
                });
                return;
            }

            // Mở modal
            document.getElementById('addServiceModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Điền dữ liệu vào form
            document.getElementById('service_id').value = service.id;
            document.getElementById('service_name').value = service.service_name;
            document.getElementById('service_type').value = service.service_type;
            document.getElementById('unit').value = service.unit; // Giữ nguyên unit để lưu vào DB
            document.getElementById('service_price').value = service.service_price;

            // Lấy danh sách phòng đang áp dụng dịch vụ này
            fetch('<?= BASE_URL ?>/landlord/service/get-rooms/' + serviceId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Uncheck tất cả phòng trước
                        const roomCheckboxes = document.querySelectorAll('input[name="rooms[]"]');
                        roomCheckboxes.forEach(checkbox => {
                            checkbox.checked = false;
                        });

                        // Check các phòng đang áp dụng
                        data.rooms.forEach(roomId => {
                            const checkbox = document.getElementById('room_' + roomId);
                            if (checkbox) {
                                checkbox.checked = true;
                            }
                        });

                        // Cập nhật select all checkbox
                        updateSelectAllCheckbox();
                    }
                })
                .catch(error => {
                    console.error('Error fetching service rooms:', error);
                });

            // Thay đổi tiêu đề modal
            document.getElementById('serviceModalTitle').textContent = 'Chỉnh sửa dịch vụ';

            // Thay đổi nút submit
            document.getElementById('serviceSubmitBtn').innerHTML = '<i class="fas fa-save mr-2"></i>Cập nhật dịch vụ';

            // Thay đổi form action
            document.getElementById('serviceForm').action = '<?= BASE_URL ?>/landlord/service/update';
        }

        function deleteService(serviceId, serviceName, canDelete, deleteReason) {
            if (!canDelete) {
                // Không thể xóa - hiển thị thông báo lý do
                Swal.fire({
                    title: 'Không thể xóa dịch vụ',
                    text: deleteReason,
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Đóng'
                });
                return;
            }

            // Có thể xóa - hiển thị xác nhận
            Swal.fire({
                title: 'Xác nhận xóa dịch vụ',
                html: `Bạn có chắc chắn muốn xóa dịch vụ "<strong>${serviceName}</strong>"?<br>Dịch vụ sẽ được gỡ bỏ khỏi tất cả phòng trống.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa dịch vụ',
                cancelButtonText: 'Hủy bỏ',
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tạo form để gửi request xóa
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '<?= BASE_URL ?>/landlord/service/delete';

                    // Thêm CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = 'csrf_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);

                    // Thêm service_id
                    const serviceIdInput = document.createElement('input');
                    serviceIdInput.type = 'hidden';
                    serviceIdInput.name = 'service_id';
                    serviceIdInput.value = serviceId;
                    form.appendChild(serviceIdInput);

                    // Thêm form vào body và submit
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }


        // Select all rooms
        function selectAllRooms() {
            const roomCheckboxes = document.querySelectorAll('input[name="rooms[]"]');
            roomCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            updateSelectAllCheckbox();
        }

        // Deselect all rooms
        function deselectAllRooms() {
            const roomCheckboxes = document.querySelectorAll('input[name="rooms[]"]');
            roomCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            updateSelectAllCheckbox();
        }

        // Validate service form
        function validateServiceForm() {
            const serviceName = document.getElementById('service_name').value.trim();
            const serviceType = document.getElementById('service_type').value;
            const unit = document.getElementById('unit').value;
            const servicePrice = document.getElementById('service_price').value.trim();
            const selectedRooms = Array.from(document.querySelectorAll('input[name="rooms[]"]:checked')).map(cb => cb.value);

            // Validate required fields
            if (!serviceName) {
                alert('Vui lòng nhập tên dịch vụ!');
                document.getElementById('service_name').focus();
                return false;
            }

            if (!serviceType) {
                alert('Vui lòng chọn loại dịch vụ!');
                document.getElementById('service_type').focus();
                return false;
            }

            if (!unit) {
                alert('Vui lòng chọn đơn vị!');
                document.getElementById('unit').focus();
                return false;
            }

            if (!servicePrice || servicePrice <= 0) {
                alert('Vui lòng nhập giá dịch vụ hợp lệ!');
                document.getElementById('service_price').focus();
                return false;
            }

            // Không bắt buộc chọn phòng - có thể để trống

            return true;
        }

        function updateSelectAllCheckbox() {
            const roomCheckboxes = document.querySelectorAll('input[name="rooms[]"]');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');

            if (roomCheckboxes.length > 0) {
                const allChecked = Array.from(roomCheckboxes).every(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
            }
        }

        // Event listeners for room selection
        document.addEventListener('DOMContentLoaded', function() {
            // Handle select all checkbox
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        selectAllRooms();
                    } else {
                        deselectAllRooms();
                    }
                });
            }

            // Update select all checkbox when individual rooms change
            const roomCheckboxes = document.querySelectorAll('input[name="rooms[]"]');
            roomCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectAllCheckbox();
                });
            });
        });

        // Close modal when clicking outside
        document.getElementById('addServiceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddServiceModal();
            }
        });

        // Close modal when pressing ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddServiceModal();
            }
        });

        // ==================== USAGE DATA LOADING ====================

        /**
         * Load dữ liệu sử dụng dịch vụ theo tháng
         */
        function loadUsageData(month, year) {
            const houseId = '<?= $selectedHouse['id'] ?? '' ?>';
            console.log('loadUsageData called with:', {
                month,
                year,
                houseId
            });

            if (!houseId) {
                console.log('No house selected');
                showEmptyState('Chưa chọn nhà trọ');
                return;
            }

            // Hiển thị loading
            showLoadingState();

            const apiUrl = `<?= BASE_URL ?>/landlord/service/usage?house_id=${houseId}&month=${month}&year=${year}`;
            console.log('Calling API:', apiUrl);

            // Gọi API để lấy dữ liệu
            fetch(apiUrl)
                .then(response => {
                    console.log('API Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('API Response data:', data);
                    if (data.success) {
                        console.log('Calling renderUsageTable with data:', data.data);
                        if (data.data && data.data.length > 0) {
                            renderUsageTable(data.data);
                        } else {
                            // Không có dữ liệu sử dụng
                            showEmptyState(data.message || 'Không có dữ liệu sử dụng cho tháng này');
                        }
                    } else {
                        console.log('API returned error:', data.message);
                        showEmptyState(data.message || 'Không thể tải dữ liệu');
                    }
                })
                .catch(error => {
                    console.error('Error loading usage data:', error);
                    showEmptyState('Có lỗi xảy ra khi tải dữ liệu');
                });
        }

        /**
         * Render bảng dữ liệu sử dụng
         */
        function renderUsageTable(roomsData) {
            const tbody = document.getElementById('usageTableBody');
            console.log('renderUsageTable called with:', roomsData);

            if (!roomsData || roomsData.length === 0) {
                console.log('No data to render');
                showEmptyState('Không có dữ liệu sử dụng cho tháng này');
                return;
            }

            // Ẩn loading và empty state
            hideLoadingState();
            hideEmptyState();

            // Tạo HTML cho bảng
            let html = '';

            // Dữ liệu đã được xử lý từ backend, chỉ cần render trực tiếp
            roomsData.forEach(room => {
                console.log('Rendering room:', room);
                html += `
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 border border-gray-300">
                            ${room.room_number}
                        </td>
                        ${renderServiceColumns(room.services, 'electric')}
                        ${renderServiceColumns(room.services, 'water')}
                        ${renderServiceColumns(room.services, 'garbage')}
                        ${renderServiceColumns(room.services, 'internet')}
                        ${renderServiceColumns(room.services, 'parking')}
                    </tr>
                `;
            });

            console.log('Generated HTML:', html);
            tbody.innerHTML = html;
        }

        /**
         * Render cột dịch vụ
         */
        function renderServiceColumns(services, serviceType) {
            console.log('renderServiceColumns called with:', {
                services,
                serviceType
            });

            const service = services[serviceType];

            if (!service) {
                console.log(`No service found for type: ${serviceType}`);
                return `
                    <td class="px-4 py-3 text-sm text-gray-500 text-center border border-gray-300">-</td>
                    <td class="px-4 py-3 text-sm text-gray-500 text-center border border-gray-300">-</td>
                `;
            }

            console.log(`Service found for ${serviceType}:`, service);

            const usageText = service.usage_amount > 0 ? service.usage_amount + ' ' + service.unit_vi : '-';
            const amountText = service.total_amount > 0 ? formatCurrency(service.total_amount) : '-';

            return `
                <td class="px-4 py-3 text-sm text-gray-900 text-center border border-gray-300">${usageText}</td>
                <td class="px-4 py-3 text-sm text-gray-900 text-center border border-gray-300">${amountText}</td>
            `;
        }

        /**
         * Format tiền tệ (giống Helper/Format::forMatPrice)
         */
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
        }

        /**
         * Hiển thị loading state
         */
        function showLoadingState() {
            document.getElementById('loadingState').classList.remove('hidden');
            document.getElementById('usageTable').classList.add('hidden');
            hideEmptyState();
        }

        /**
         * Ẩn loading state
         */
        function hideLoadingState() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('usageTable').classList.remove('hidden');
        }

        /**
         * Hiển thị empty state
         */
        function showEmptyState(message) {
            hideLoadingState();
            const emptyState = document.getElementById('emptyState');
            const emptyStateMessage = document.getElementById('emptyStateMessage');
            if (emptyState && emptyStateMessage) {
                emptyStateMessage.textContent = message;
                emptyState.classList.remove('hidden');
            }
        }

        /**
         * Ẩn empty state
         */
        function hideEmptyState() {
            const emptyState = document.getElementById('emptyState');
            if (emptyState) {
                emptyState.classList.add('hidden');
            }
        }
    </script>
</body>

</html>
