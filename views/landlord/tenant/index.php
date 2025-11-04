<!--
	Author: Nguyen Xuan Duong
	Date: 2025-09-07
	Purpose: Build Tenant Index
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOSTY - Quản lý danh sách khách thuê</title>
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
                            <h3 class="text-base font-medium text-gray-800">Quản lý danh sách khách thuê:</h3>
                            <p class="text-gray-600 italic mt-1 text-sm">Tất cả danh sách khách thuê trong Nhà trọ của bạn</p>
                        </div>
                    </div>
                    <button onclick="openAddTenantModal()" class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>
                </div>

                <!-- Tenant Table -->
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <?php if (!empty($tenantsByRoom)): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300 w-28">Tên khách thuê</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300 w-24">Số điện thoại</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300 w-12">Ngày sinh</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300 w-20">Giới tính</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300 w-20">Số CCCD</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300 w-16">Nghề nghiệp</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300 w-24">Loại người thuê</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300 w-56">Địa chỉ</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300 w-12"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <?php foreach ($tenantsByRoom as $roomId => $roomData): ?>
                                        <!-- Room Header -->
                                        <tr style="background-color: #D3DDE6;">
                                            <td colspan="9" class="px-6 py-3">
                                                <div class="flex items-center">
                                                    <button onclick="toggleRoomDropdown('room-<?= $roomId ?>')"
                                                        class="mr-3 p-1 hover:bg-gray-200 rounded transition-colors">
                                                        <svg class="w-4 h-4 transition-transform rotate-180" id="arrow-room-<?= $roomId ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                    </button>
                                                    <span class="text-sm font-medium text-gray-700">
                                                        <?= htmlspecialchars($roomData['room_name']) ?>
                                                        <span style="color: red; margin-left: 8px;">(<?= count($roomData['tenants']) ?>) khách thuê</span>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Tenants in this room -->
                                        <?php foreach ($roomData['tenants'] as $tenant): ?>
                                            <tr class="hover:bg-gray-50 transition-colors tenant-row" id="tenant-row-room-<?= $roomId ?>">
                                                <td class="px-4 py-3 whitespace-nowrap border border-gray-300 w-28">
                                                    <div class="text-sm text-gray-900"><?= htmlspecialchars($tenant['username']) ?></div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-center border border-gray-300 w-24">
                                                    <div class="text-sm text-gray-900"><?= htmlspecialchars($tenant['phone'] ?? 'Chưa cập nhật') ?></div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-center border border-gray-300 w-12">
                                                    <span class="text-sm text-gray-900">
                                                        <?= $tenant['birthday'] ? date('d/m/Y', strtotime($tenant['birthday'])) : 'Chưa cập nhật' ?>
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-center border border-gray-300 w-20">
                                                    <span class="text-sm text-gray-900">
                                                        <?php
                                                        if ($tenant['gender'] === 'male') {
                                                            echo 'Nam';
                                                        } elseif ($tenant['gender'] === 'female') {
                                                            echo 'Nữ';
                                                        } else {
                                                            echo 'Chưa cập nhật';
                                                        }
                                                        ?>
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap border border-gray-300 w-20">
                                                    <div class="text-sm text-gray-900"><?= htmlspecialchars($tenant['citizen_id'] ?? 'Chưa cập nhật') ?></div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap border border-gray-300 w-16">
                                                    <div class="text-sm text-gray-900"><?= htmlspecialchars($tenant['job'] ?? 'Chưa cập nhật') ?></div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-center border border-gray-300 w-24">
                                                    <?php if ($tenant['is_primary']): ?>
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white" style="background-color: #7DC242;">
                                                            Chủ phòng
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white" style="background-color: #ED6004;">
                                                            Thành viên
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="px-4 py-3 border border-gray-300 w-56">
                                                    <div class="text-sm text-gray-900">
                                                        <?php
                                                        $address = [];
                                                        if ($tenant['address']) {
                                                            $address[] = $tenant['address'];
                                                        }

                                                        if ($tenant['ward']) {
                                                            $address[] = $tenant['ward'];
                                                        }

                                                        if ($tenant['province']) {
                                                            $address[] = $tenant['province'];
                                                        }

                                                        echo !empty($address) ? htmlspecialchars(implode(', ', $address)) : 'Chưa cập nhật';
                                                        ?>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium border border-gray-300 w-12">
                                                    <div class="flex items-center justify-center space-x-4">
                                                        <!-- Edit Icon -->
                                                        <button onclick="editTenant(<?= $tenant['user_id'] ?>, <?= $tenant['room_id'] ?>)" class="hover:scale-110 transition-transform" title="Chỉnh sửa">
                                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                        </button>

                                                        <!-- Delete Icon -->
                                                        <button onclick="deleteTenant(<?= $tenant['id'] ?>, <?= $tenant['room_id'] ?>)" class="hover:scale-110 transition-transform" title="Xóa khách thuê">
                                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Chưa có khách thuê nào</h3>
                            <p class="mt-2 text-gray-500">Hiện tại chưa có khách thuê nào trong nhà trọ của bạn.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>


    <!-- Modal thêm khách hàng mới - 2 phần -->
    <div id="addTenantModal" class="modal-container hidden">
        <div class="modal-content large flex flex-col overflow-hidden" style="max-width: 1100px !important; max-height: 90vh;">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0 bg-white">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user-plus text-white text-sm"></i>
                    </div>
                    <h2 id="modalTitle" class="text-xl font-semibold text-gray-800">Thêm khách hàng mới</h2>
                </div>
                <button id="closeAddTenantModal" onclick="closeAddTenantModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Form -->
            <form id="tenantForm" method="POST" class="flex flex-1 min-h-0">
                <?= \Core\CSRF::getTokenField() ?>
                <input type="hidden" name="tenant_id" id="tenant_id">
                <input type="hidden" name="house_id" value="<?= $selectedHouse['id'] ?? '' ?>">
                <input type="hidden" id="selected_room_id" name="room_id" value="">

                <!-- Phần bên trái - Danh sách phòng -->
                <div class="w-2/5 flex flex-col">
                    <div class="p-4 bg-white">
                        <div class="flex items-start">
                            <div class="w-1 h-12 bg-green-500 rounded-full mr-3 mt-1"></div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Danh sách phòng</h3>
                                <p class="text-sm text-gray-500 mt-1 italic">Chọn phòng để thêm khách hàng</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto p-3">
                        <div id="roomList" class="grid grid-cols-2 gap-3">
                            <?php if (!empty($rooms)): ?>
                                <?php foreach ($rooms as $room): ?>
                                    <div class="room-card p-3 bg-white rounded-lg border border-gray-200 cursor-pointer hover:border-green-300 hover:shadow-md transition-all duration-200"
                                        data-room-id="<?= $room['id'] ?>"
                                        data-room-name="<?= $room['room_name'] ?>"
                                        data-room-status="<?= $room['room_status'] ?>"
                                        onclick="selectRoom(<?= $room['id'] ?>, '<?= $room['room_name'] ?>', '<?= $room['room_status'] ?>')">

                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-2">
                                                <i class="fas fa-home text-gray-600 text-sm room-icon"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="font-medium text-gray-900 text-sm truncate"><?= $room['room_name'] ?></h4>
                                                    <span class="px-2 py-1 text-xs rounded text-white" style="background-color: <?= $room['room_status'] === 'occupied' ? '#7DC242' : '#ED6004' ?>;">
                                                        <?= $room['room_status'] === 'occupied' ? 'Đã thuê' : 'Trống' ?>
                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    <i class="fas fa-users mr-1"></i>
                                                    <span class="font-medium <?= ($room['current_tenants'] ?? 0) >= ($room['max_tenants'] ?? 1) ? 'text-red-600' : 'text-blue-600' ?>">
                                                        <?= $room['current_tenants'] ?? 0 ?>/<?= $room['max_tenants'] ?? 1 ?>
                                                    </span>
                                                    người
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-8">
                                    <i class="fas fa-door-closed text-gray-400 text-3xl mb-3"></i>
                                    <p class="text-gray-500">Tất cả phòng đã đầy</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Phần bên phải - Form thông tin khách hàng -->
                <div class="w-3/5 flex flex-col">

                    <!-- Form thông tin -->
                    <div id="tenantForm" class="flex-1 overflow-y-auto p-6 min-h-0">
                        <div class="mb-0">
                            <!-- Email -->
                            <div class="flex items-start mb-4">
                                <div class="w-1 h-12 bg-green-500 rounded-full mr-3 mt-1"></div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Tìm kiếm khách hàng</h3>
                                    <p class="text-sm text-gray-500 mt-1 italic">Nhập email để tìm kiếm khách hàng</p>
                                </div>
                            </div>
                            <div>
                                <div class="relative">
                                    <input type="email" id="email" name="email" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" " required>
                                    <label for="email" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Email <span class="text-red-500">*</span></label>
                                    <div id="searchCustomerBtn" class="px-8 py-4 bg-green-500 rounded-lg flex items-center justify-between absolute top-[1px] right-[1px] cursor-pointer"><i class="fas fa-search text-white text-[15px]"></i></div>
                                </div>
                                <div id="email_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                <div class="hidden items-center gap-2 text-sm text-gray-400 ps-2 create-customer-checkbox">
                                    <input type="checkbox" class="w-5 h-5 cursor-pointer" name="check-create-customer">
                                    <div class="flex flex-col">
                                        <span>Tạo khách hàng mới từ email trên</span>
                                        <span class="text-red-500 text-[10px]">(Lưu ý: email phải được sử dụng để có thể kích hoạt tài khoản)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Thông tin cá nhân -->
                        <div class="mb-6 customer-info-block hidden">
                            <div class="flex items-start mb-4">
                                <div class="w-1 h-12 bg-green-500 rounded-full mr-3 mt-1"></div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Thông tin cá nhân</h3>
                                    <p class="text-sm text-gray-500 mt-1 italic">Nhập thông tin cơ bản của khách hàng</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Tên khách hàng -->
                                <div>
                                    <div class="relative">
                                        <input type="text" id="username" name="username" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" " required>
                                        <label for="username" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tên khách hàng <span class="text-red-500">*</span></label>
                                    </div>
                                    <div id="username_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Số điện thoại -->
                                <div>
                                    <div class="relative">
                                        <input type="tel" id="phone" name="phone" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" " required>
                                        <label for="phone" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Số điện thoại <span class="text-red-500">*</span></label>
                                    </div>
                                    <div id="phone_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Ngày sinh -->
                                <div>
                                    <div class="relative">
                                        <input type="date" id="birthday" name="birthday" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                        <label for="birthday" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Ngày sinh</label>
                                    </div>
                                    <div id="birthday_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Giới tính -->
                                <div>
                                    <div class="relative">
                                        <select id="gender" name="gender" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                            <option value="">Chọn giới tính</option>
                                            <option value="male">Nam</option>
                                            <option value="female">Nữ</option>
                                            <option value="other">Khác</option>
                                        </select>
                                        <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Giới tính</label>
                                    </div>
                                    <div id="gender_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Nghề nghiệp -->
                                <div>
                                    <div class="relative">
                                        <input type="text" id="job" name="job" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                        <label for="job" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Nghề nghiệp</label>
                                    </div>
                                    <div id="job_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin địa chỉ -->
                        <div class="mb-6 customer-info-address hidden">
                            <div class="flex items-start mb-4">
                                <div class="w-1 h-12 bg-green-500 rounded-full mr-3 mt-1"></div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Thông tin địa chỉ</h3>
                                    <p class="text-sm text-gray-500 mt-1 italic">Nhập địa chỉ liên hệ của khách hàng</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Tỉnh/Thành phố -->
                                <div>
                                    <div class="relative">
                                        <select id="province" name="province" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                            <option value="">Chọn tỉnh/thành phố</option>
                                        </select>
                                        <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Tỉnh/Thành phố</label>
                                    </div>
                                    <div id="province_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Phường/Xã -->
                                <div>
                                    <div class="relative">
                                        <select id="ward" name="ward" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                            <option value="">Chọn phường/xã</option>
                                        </select>
                                        <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Phường/Xã</label>
                                    </div>
                                    <div id="ward_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Địa chỉ chi tiết -->
                                <div class="md:col-span-2">
                                    <div class="relative">
                                        <textarea id="address" name="address" rows="3" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent resize-none" placeholder=" "></textarea>
                                        <label for="address" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Địa chỉ chi tiết</label>
                                    </div>
                                    <div id="address_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin thuê -->
                        <div class="mb-6 customer-rental-block hidden">
                            <div class="flex items-start mb-4">
                                <div class="w-1 h-12 bg-green-500 rounded-full mr-3 mt-1"></div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Thông tin thuê</h3>
                                    <p class="text-sm text-gray-500 mt-1 italic">Nhập thông tin về việc thuê phòng</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Ngày vào ở -->
                                <div>
                                    <div class="relative">
                                        <input type="date" id="join_date" name="join_date" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none" required>
                                        <label for="join_date" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Ngày vào ở <span class="text-red-500">*</span></label>
                                    </div>
                                    <div id="join_date_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Số CCCD -->
                                <div>
                                    <div class="relative">
                                        <input type="text" id="citizen_id" name="citizen_id" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                        <label for="citizen_id" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Số CCCD <span class="text-red-500">*</span></label>
                                    </div>
                                    <div id="citizen_id_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <!-- Là chủ phòng -->
                                <div class="flex items-center">
                                    <input type="checkbox" id="is_primary" name="is_primary" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                    <label for="is_primary" class="ml-2 text-sm font-medium text-gray-700">Là chủ phòng</label>
                                </div>
                            </div>

                            <div class="mt-4">
                                <!-- Ghi chú -->
                                <div class="relative">
                                    <textarea id="note" name="note" rows="3" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent resize-none" placeholder=" "></textarea>
                                    <label for="note" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Ghi chú</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end gap-3 p-6 border-t border-gray-200 flex-shrink-0 bg-white">
                        <button type="button" onclick="closeAddTenantModal()" class="px-6 py-2 text-gray-700 hover:text-gray-900 rounded-lg transition-colors">
                            Hủy
                        </button>
                        <button type="submit" id="submitBtn" class="px-6 py-2 bg-gray-400 text-white rounded-lg transition-colors cursor-not-allowed" disabled>
                            <span id="submitBtnText">Thêm khách hàng</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Tenant -->
    <div id="editTenantModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-6xl max-h-[90vh] flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0 bg-white">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user-edit text-white text-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Chỉnh sửa thông tin khách hàng</h2>
                        <p class="text-sm text-gray-500 mt-1">Cập nhật thông tin chi tiết của khách hàng</p>
                    </div>
                </div>
                <button onclick="closeEditTenantModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Form -->
            <form id="editTenantForm" method="POST" class="flex flex-1 min-h-0">
                <?= \Core\CSRF::getTokenField() ?>
                <input type="hidden" name="tenant_id" id="edit_tenant_id">
                <input type="hidden" name="house_id" value="<?= $selectedHouse['id'] ?? '' ?>">
                <input type="hidden" id="edit_selected_room_id" name="room_id" value="">

                <!-- Phần bên trái - Thông tin phòng -->
                <div class="w-2/5 flex flex-col">
                    <div class="p-4 bg-white">
                        <div class="flex items-start">
                            <div class="w-1 h-12 bg-green-500 rounded-full mr-3 mt-1"></div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Thông tin phòng</h3>
                                <p class="text-sm text-gray-500 mt-1 italic">Phòng hiện tại của khách hàng</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto p-3">
                        <div id="edit_current_room_display" class="p-3 bg-gray-50 border border-gray-300 rounded-lg">
                            <span class="text-gray-500">Đang tải...</span>
                        </div>
                    </div>
                </div>

                <!-- Phần bên phải - Thông tin khách hàng -->
                <div class="w-3/5 flex flex-col">
                    <div class="flex-1 overflow-y-auto p-6 min-h-0">
                        <!-- Thông tin cá nhân -->
                        <div class="mb-6 customer-info-block_edit">
                            <div class="flex items-start mb-4">
                                <div class="w-1 h-12 bg-green-500 rounded-full mr-3 mt-1"></div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Thông tin cá nhân</h3>
                                    <p class="text-sm text-gray-500 mt-1 italic">Nhập thông tin cơ bản của khách hàng</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Tên khách hàng -->
                                <div>
                                    <div class="relative">
                                        <input type="text" id="edit_username" name="username" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" " required>
                                        <label for="edit_username" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tên khách hàng <span class="text-red-500">*</span></label>
                                    </div>
                                    <div id="edit_username_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Số điện thoại -->
                                <div>
                                    <div class="relative">
                                        <input type="tel" id="edit_phone" name="phone" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" " required>
                                        <label for="edit_phone" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Số điện thoại <span class="text-red-500">*</span></label>
                                    </div>
                                    <div id="edit_phone_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Email -->
                                <div>
                                    <div class="relative">
                                        <input type="email" id="edit_email" name="email" class="peer w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed outline-none placeholder-transparent" placeholder=" " readonly>
                                        <label for="edit_email" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-gray-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-gray-500 peer-[:not(:placeholder-shown)]:font-medium">Email <span class="text-red-500">*</span></label>
                                    </div>
                                    <div id="edit_email_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Ngày sinh -->
                                <div>
                                    <div class="relative">
                                        <input type="date" id="edit_birthday" name="birthday" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                        <label for="edit_birthday" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Ngày sinh</label>
                                    </div>
                                    <div id="edit_birthday_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Giới tính -->
                                <div>
                                    <div class="relative">
                                        <select id="edit_gender" name="gender" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                            <option value="">Chọn giới tính</option>
                                            <option value="male">Nam</option>
                                            <option value="female">Nữ</option>
                                            <option value="other">Khác</option>
                                        </select>
                                        <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Giới tính</label>
                                    </div>
                                    <div id="edit_gender_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Công việc -->
                                <div>
                                    <div class="relative">
                                        <input type="text" id="edit_job" name="job" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                        <label for="edit_job" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Công việc</label>
                                    </div>
                                    <div id="edit_job_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin địa chỉ -->
                        <div class="mb-6 customer-info-address_edit">
                            <div class="flex items-start mb-4">
                                <div class="w-1 h-12 bg-green-500 rounded-full mr-3 mt-1"></div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Thông tin địa chỉ</h3>
                                    <p class="text-sm text-gray-500 mt-1 italic">Nhập địa chỉ liên hệ của khách hàng</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Tỉnh/Thành phố -->
                                <div>
                                    <div class="relative">
                                        <select id="edit_province" name="province" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                            <option value="">Chọn tỉnh/thành phố</option>
                                        </select>
                                        <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Tỉnh/Thành phố</label>
                                    </div>
                                    <div id="edit_province_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Phường/Xã -->
                                <div>
                                    <div class="relative">
                                        <select id="edit_ward" name="ward" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none" disabled>
                                            <option value="">Chọn phường/xã</option>
                                        </select>
                                        <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Phường/Xã</label>
                                    </div>
                                    <div id="edit_ward_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>
                            </div>

                            <!-- Địa chỉ chi tiết -->
                            <div class="mt-4">
                                <div class="relative">
                                    <textarea id="edit_address" name="address" rows="3" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent resize-none" placeholder=" "></textarea>
                                    <label for="edit_address" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Địa chỉ chi tiết</label>
                                </div>
                                <div id="edit_address_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                            </div>
                        </div>

                        <!-- Thông tin phòng và công việc -->
                        <div class="mb-6">
                            <div class="flex items-start mb-4">
                                <div class="w-1 h-12 bg-green-500 rounded-full mr-3 mt-1"></div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Thông tin thuê</h3>
                                    <p class="text-sm text-gray-500 mt-1 italic">Thông tin về thuê phòng và quản lí khách hàng</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Ngày vào ở -->
                                <div>
                                    <div class="relative">
                                        <input type="date" id="edit_join_date" name="join_date" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none" required>
                                        <label for="edit_join_date" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Ngày vào ở <span class="text-red-500">*</span></label>
                                    </div>
                                    <div id="edit_join_date_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>

                                <!-- Số CCCD -->
                                <div>
                                    <div class="relative">
                                        <input type="text" id="edit_citizen_id" name="citizen_id" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                        <label for="edit_citizen_id" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Số CCCD</label>
                                    </div>
                                    <div id="edit_citizen_id_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                                </div>
                            </div>

                            <!-- Khách hàng chủ phòng -->
                            <div class="mt-4">
                                <div class="flex items-center">
                                    <input type="checkbox" id="edit_is_primary" name="is_primary" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                    <label for="edit_is_primary" class="ml-2 text-sm font-medium text-gray-700">Là chủ phòng</label>
                                </div>
                                <div id="edit_is_primary_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                            </div>

                            <!-- Ghi chú -->
                            <div class="mt-4">
                                <div class="relative">
                                    <textarea id="edit_note" name="note" rows="3" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent resize-none" placeholder=" "></textarea>
                                    <label for="edit_note" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Ghi chú</label>
                                </div>
                                <div id="edit_note_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end gap-3 p-6 border-t border-gray-200 flex-shrink-0 bg-white">
                        <button type="button" onclick="closeEditTenantModal()" class="px-6 py-2 text-gray-700 hover:text-gray-900 rounded-lg transition-colors">
                            Hủy
                        </button>
                        <button type="submit" id="editSubmitBtn" class="px-6 py-2 bg-green-600 text-white rounded-lg transition-colors hover:bg-green-700">
                            <span id="editSubmitBtnText">Cập nhật thông tin</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Khai báo biến cho selectors (tránh conflict với nav.php)
        const TENANT_PROVINCE_SELECTOR = '#addTenantModal #province';
        const TENANT_WARD_SELECTOR = '#addTenantModal #ward';
        const EDIT_TENANT_PROVINCE_SELECTOR = '#editTenantModal #edit_province';
        const EDIT_TENANT_WARD_SELECTOR = '#editTenantModal #edit_ward';

        // Open tenant modal (add mode)
        function openAddTenantModal() {
            currentMode = 'add';
            document.getElementById('modalTitle').textContent = 'Thêm khách hàng mới';
            document.getElementById('submitBtnText').textContent = 'Thêm khách hàng';
            document.getElementById('tenant_id').value = '';
            document.getElementById('addTenantModal').classList.remove('hidden');
            // Load tỉnh thành khi mở modal
            // Modify by Huy Nguyen on 2025-10-31
            loadProvince(TENANT_PROVINCE_SELECTOR, null, TENANT_WARD_SELECTOR, null);
        }

        // Close add tenant modal
        function closeAddTenantModal() {
            document.getElementById('addTenantModal').classList.add('hidden');
            document.getElementById('tenantForm').reset();
            // Added by Huy nguyen to reset modal
            $('.customer-info-block, .customer-info-address, .customer-rental-block, .create-customer-checkbox').addClass('hidden');
            $('input[name="email"]').prop('readonly', false);
            $('input[name="check-create-customer"]').prop('checked', false);
            $('#email_error').text('');
            // Reset form địa chỉ

            // Reset modal state
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').classList.remove('bg-green-600', 'hover:bg-green-700');
            document.getElementById('submitBtn').classList.add('bg-gray-400', 'cursor-not-allowed');

            // Reset room selection và icon
            document.querySelectorAll('.room-card').forEach(card => {
                card.classList.remove('border-green-500', 'bg-green-50');
                card.classList.add('border-gray-200', 'bg-white');
                // Reset icon về home
                const icon = card.querySelector('.room-icon');
                if (icon) {
                    icon.className = 'fas fa-home text-gray-600 text-sm room-icon';
                }
            });
        }

        // Function để chọn phòng
        function selectRoom(roomId, roomName, roomStatus) {
            // Xóa selection cũ và reset icon
            document.querySelectorAll('.room-card').forEach(card => {
                card.classList.remove('border-green-500', 'bg-green-50');
                card.classList.add('border-gray-200', 'bg-white');
                // Reset icon về home
                const icon = card.querySelector('.room-icon');
                if (icon) {
                    icon.className = 'fas fa-home text-gray-600 text-sm room-icon';
                }
            });

            // Highlight phòng được chọn và thay đổi icon
            const selectedCard = document.querySelector(`[data-room-id="${roomId}"]`);
            if (selectedCard) {
                selectedCard.classList.remove('border-gray-200', 'bg-white');
                selectedCard.classList.add('border-green-500', 'bg-green-50');

                // Thay đổi icon thành dấu tích
                const icon = selectedCard.querySelector('.room-icon');
                if (icon) {
                    icon.className = 'fas fa-check text-green-600 text-sm room-icon';
                }
            }

            // Set room ID vào hidden input
            document.getElementById('selected_room_id').value = roomId;

            // Enable submit button
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = false;
            submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            submitBtn.classList.add('bg-green-600', 'hover:bg-green-700');
        }

        // Function để cập nhật CSRF token
        function updateCsrfToken(newToken) {
            const csrfInput = document.querySelector('input[name="csrf_token"]');
            if (csrfInput && newToken) {
                csrfInput.value = newToken;
            }
        }

        // Toggle room dropdown
        function toggleRoomDropdown(roomId) {
            // Tìm tất cả các dòng tenant của phòng này
            const tenantRows = document.querySelectorAll(`[id^="tenant-row-${roomId}"]`);
            const arrow = document.getElementById(`arrow-${roomId}`);

            // Toggle hiển thị/ẩn các dòng tenant
            tenantRows.forEach(row => {
                row.classList.toggle('hidden');
            });

            // Xoay mũi tên (mặc định là mở nên xoay 180deg)
            if (arrow) {
                const isHidden = tenantRows[0] && tenantRows[0].classList.contains('hidden');
                arrow.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        }

        // Hàm xóa khách thuê khỏi phòng với SweetAlert xác nhận
        function deleteTenant(tenantId, roomId) {
            // Kiểm tra xem khách thuê có phải là người cuối cùng trong phòng không
            fetch(`${App.appURL}landlord/tenant/check-before-remove?tenant_id=${tenantId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cập nhật CSRF token từ response
                        if (data.csrf_token) {
                            updateCsrfToken(data.csrf_token);
                        }

                        // Hiển thị thông báo xác nhận khác nhau dựa trên việc có phải người cuối cùng không
                        if (data.is_last_tenant) {
                            // Thông báo đặc biệt cho khách thuê cuối cùng
                            Swal.fire({
                                title: 'Xác nhận xóa khách thuê',
                                html: 'Đây là khách cuối cùng của phòng.<br>Hãy đảm bảo bạn đã thu tiền lần cuối cùng!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Xóa',
                                cancelButtonText: 'Hủy',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    performTenantRemoval(tenantId, roomId);
                                }
                            });
                        } else {
                            // Thông báo thông thường
                            Swal.fire({
                                title: 'Xác nhận xóa khách thuê',
                                html: 'Bạn có chắc chắn muốn xóa khách thuê khỏi phòng?<br>Hành động này sẽ đánh dấu khách thuê đã rời phòng!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Xóa',
                                cancelButtonText: 'Hủy',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    performTenantRemoval(tenantId, roomId);
                                }
                            });
                        }
                    } else {
                        App.showSuccessMessage(data.message || 'Có lỗi xảy ra khi kiểm tra thông tin khách thuê', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error checking tenant:', error);
                    App.showSuccessMessage('Có lỗi xảy ra khi kiểm tra thông tin khách thuê', 'error');
                });
        }

        // Hàm thực hiện xóa khách thuê
        function performTenantRemoval(tenantId, roomId) {
            const csrfToken = document.querySelector('input[name="csrf_token"]').value;

            fetch(`${App.appURL}landlord/tenant/remove`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `tenant_id=${tenantId}&csrf_token=${csrfToken}&room_id=${roomId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        App.showSuccessMessage(data.message || 'Xóa khách thuê thành công', 'success');
                        // Reload trang sau 1.2 giây để user thấy thông báo
                        setTimeout(() => {
                            window.location.reload();
                        }, 1200);
                    } else {
                        App.showSuccessMessage(data.message || 'Có lỗi xảy ra khi xóa khách thuê', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    App.showSuccessMessage('Có lỗi xảy ra khi xóa khách thuê', 'error');
                });
        }
    </script>

    <?php include VIEW_PATH . '/landlord/layouts/footer.php'; ?>
</body>

</html>