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
                                                    <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($tenant['username']) ?></div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap border border-gray-300 w-24">
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
                                                        if ($tenant['address']) $address[] = $tenant['address'];
                                                        if ($tenant['ward']) $address[] = $tenant['ward'];
                                                        if ($tenant['province']) $address[] = $tenant['province'];
                                                        
                                                        echo !empty($address) ? htmlspecialchars(implode(', ', $address)) : 'Chưa cập nhật';
                                                        ?>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium border border-gray-300 w-12">
                                                    <div class="flex items-center justify-center">
                                                        <!-- Dropdown Button -->
                                                        <div class="relative">
                                                            <button onclick="toggleTenantActions(<?= $tenant['id'] ?>)" class="w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors border border-gray-300" title="Thao tác">
                                                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                                </svg>
                                                            </button>
                                                            
                                                            <!-- Dropdown Menu -->
                                                            <div id="tenantActions-<?= $tenant['id'] ?>" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                                                                <div class="py-1">
                                                                    <!-- Edit Option -->
                                                                    <button onclick="editTenant(<?= $tenant['id'] ?>); toggleTenantActions(<?= $tenant['id'] ?>)" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                                                        <svg class="w-4 h-4 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                                        </svg>
                                                                        Chỉnh sửa
                                                                    </button>
                                                                    
                                                                    <!-- Delete Option -->
                                                                    <button onclick="deleteTenant(<?= $tenant['id'] ?>); toggleTenantActions(<?= $tenant['id'] ?>)" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                                        <svg class="w-4 h-4 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                        </svg>
                                                                        Xóa khách thuê
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
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
            <button onclick="closeAddTenantModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
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

                    <!-- Thông tin cá nhân -->
                    <div class="mb-6">
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

                            <!-- Email -->
                            <div>
                                <div class="relative">
                                    <input type="email" id="email" name="email" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" " required>
                                    <label for="email" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Email <span class="text-red-500">*</span></label>
                                </div>
                                <div id="email_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
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

                            <!-- Số CCCD -->
                            <div>
                                <div class="relative">
                                    <input type="text" id="citizen_id" name="citizen_id" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                    <label for="citizen_id" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Số CCCD</label>
                                </div>
                                <div id="citizen_id_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin địa chỉ -->
                    <div class="mb-6">
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
                                    <select id="ward" name="ward" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none" disabled>
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
                    <div class="mb-6">
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

                            <!-- Nghề nghiệp -->
                            <div>
                                <div class="relative">
                                    <input type="text" id="job" name="job" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                    <label for="job" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Nghề nghiệp</label>
                                </div>
                                <div id="job_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
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
                    <div class="mb-6">
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

                            <!-- Số CCCD -->
                            <div>
                                <div class="relative">
                                    <input type="text" id="edit_citizen_id" name="citizen_id" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                    <label for="edit_citizen_id" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Số CCCD</label>
                                </div>
                                <div id="edit_citizen_id_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin địa chỉ -->
                    <div class="mb-6">
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
                                <h3 class="text-lg font-medium text-gray-900">Thông tin phòng và công việc</h3>
                                <p class="text-sm text-gray-500 mt-1 italic">Thông tin về phòng và công việc của khách hàng</p>
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

                            <!-- Công việc -->
                            <div>
                                <div class="relative">
                                    <input type="text" id="edit_job" name="job" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                    <label for="edit_job" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Công việc</label>
                                </div>
                                <div id="edit_job_error" class="text-red-500 text-xs mt-1 min-h-[20px]"></div>
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
    
    // Biến để theo dõi mode (add/edit)
    let currentMode = 'add';

    // Reset form địa chỉ
    function resetTenantAddressForm() {
        $(TENANT_PROVINCE_SELECTOR).html('<option value="">Chọn tỉnh/thành phố</option>');
        $(TENANT_WARD_SELECTOR).html('<option value="">Chọn phường/xã</option>');
        $(TENANT_WARD_SELECTOR).attr('disabled', true);
    }

    // Lấy tên tỉnh thành phố cho modal tenant
    window.getTenantProvinces = function(province_value) {
        fetch('https://provinces.open-api.vn/api/v2/')
            .then(function(response) {
                return response.json();
            })
            .then(function(provinces) {
                // Clear dropdown trước khi thêm options mới
                $(TENANT_PROVINCE_SELECTOR).html('<option value="">Chọn tỉnh/thành phố</option>');
                console.log('Loading tenant provinces:', provinces.length);
                
                provinces.forEach((province) => {
                    $(TENANT_PROVINCE_SELECTOR).append(
                        `<option value="${province.name}" data-code="${province.code}" ${province_value != '' ? (province.name == province_value ? 'selected' : '') : ''}>${
                             province.name
                         }</option>`
                    );
                });
                console.log('Tenant provinces loaded successfully');
            })
            .catch(function(err) {
                console.log(err);
            });
    };

    // Lấy danh sách phường xã cho modal tenant
    window.getTenantWards = function(ward_value) {
        console.log('getTenantWards called with ward_value:', ward_value);
        const selectedOption = $(TENANT_PROVINCE_SELECTOR + ' option:selected');
        const provinceCode = selectedOption.attr('data-code');
        console.log('Tenant selected province code:', provinceCode);

        if (!provinceCode) {
            console.log('No province code found in tenant modal, disabling ward dropdown');
            $(TENANT_WARD_SELECTOR).html('<option value="">Chọn phường/xã</option>');
            $(TENANT_WARD_SELECTOR).attr('disabled', true);
            return;
        }

        fetch(`https://provinces.open-api.vn/api/v2/p/${provinceCode}?depth=2`)
            .then(function(response) {
                return response.json();
            })
            .then(function(provinceData) {
                console.log('Tenant province data:', provinceData);
                $(TENANT_WARD_SELECTOR).html('<option value="">Chọn phường/xã</option>');
                
                // Cấu trúc dữ liệu đúng: provinceData.wards[]
                if (provinceData.wards && provinceData.wards.length > 0) {
                    console.log('Tenant wards found:', provinceData.wards.length);
                    provinceData.wards.forEach((ward) => {
                        $(TENANT_WARD_SELECTOR).append(`<option value="${ward.name}" data-code="${ward.code}" ${ward_value != '' ? (ward.name == ward_value ? 'selected' : '') : ''}>${ward.name}</option>`);
                    });
                    $(TENANT_WARD_SELECTOR).attr('disabled', false);
                    console.log('Tenant ward dropdown enabled');
                } else {
                    $(TENANT_WARD_SELECTOR).attr('disabled', true);
                    console.log('No tenant wards found, dropdown disabled');
                }
            })
            .catch(function(err) {
                console.log(err);
            });
    };

    // Event listeners cho dropdown tenant
    $(document).ready(function() {
        console.log('Setting up tenant province/ward event listeners');
        $(TENANT_PROVINCE_SELECTOR).change(function() {
            console.log('Tenant province changed:', $(this).val());
            // Reset ward khi thay đổi province
            $(TENANT_WARD_SELECTOR).html('<option value="">Chọn phường/xã</option>');
            $(TENANT_WARD_SELECTOR).attr('disabled', true);
            // Sau đó mới gọi getTenantWards để load dữ liệu
            getTenantWards();
        });

        // Event handler cho edit modal
        $(EDIT_TENANT_PROVINCE_SELECTOR).change(function() {
            console.log('Edit tenant province changed:', $(this).val());
            // Reset ward khi thay đổi province
            $(EDIT_TENANT_WARD_SELECTOR).html('<option value="">Chọn phường/xã</option>');
            $(EDIT_TENANT_WARD_SELECTOR).attr('disabled', true);
            // Load wards
            loadEditTenantWards();
        });
    });


    // Open tenant modal (add mode)
    function openAddTenantModal() {
        currentMode = 'add';
        document.getElementById('modalTitle').textContent = 'Thêm khách hàng mới';
        document.getElementById('submitBtnText').textContent = 'Thêm khách hàng';
        document.getElementById('tenant_id').value = '';
        document.getElementById('addTenantModal').classList.remove('hidden');
        // Load tỉnh thành khi mở modal
        getTenantProvinces();
    }

    // Close add tenant modal
    function closeAddTenantModal() {
        document.getElementById('addTenantModal').classList.add('hidden');
        document.getElementById('tenantForm').reset();
        // Reset form địa chỉ
        resetTenantAddressForm();
        
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
        
        // Clear errors
        clearAllErrors();
        // Reset mode
        currentMode = 'add';
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

    // Clear all error messages
    function clearAllErrors() {
        // Clear error messages - tìm tất cả div có id kết thúc bằng _error
        $('[id$="_error"]').each(function() {
            $(this).text('').css('display', 'none');
        });
        
        // Remove error styling from inputs
        $('input, select, textarea').removeClass('border-red-500');
    }

    // Clear all error messages for edit modal
    function clearAllEditErrors() {
        // Clear error messages in edit modal
        $('#editTenantModal [id$="_error"]').each(function() {
            $(this).text('').css('display', 'none');
        });
        
        // Remove error styling from inputs in edit modal
        $('#editTenantModal input, #editTenantModal select, #editTenantModal textarea').removeClass('border-red-500');
    }

    // Close edit tenant modal
    function closeEditTenantModal() {
        document.getElementById('editTenantModal').classList.add('hidden');
        document.getElementById('editTenantForm').reset();
        // Reset form địa chỉ
        resetEditTenantAddressForm();
        // Clear errors
        clearAllEditErrors();
    }

    // Reset form địa chỉ cho edit modal
    function resetEditTenantAddressForm() {
        $(EDIT_TENANT_PROVINCE_SELECTOR).html('<option value="">Chọn tỉnh/thành phố</option>');
        $(EDIT_TENANT_WARD_SELECTOR).html('<option value="">Chọn phường/xã</option>');
        $(EDIT_TENANT_WARD_SELECTOR).prop('disabled', true);
    }

    // Show error message under specific field
    function showError(fieldId, message) {
        const errorElement = document.getElementById(fieldId + '_error');
        const inputElement = document.getElementById(fieldId);
        
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            errorElement.style.minHeight = '20px'; // Đảm bảo có chiều cao
        }
        
        if (inputElement) {
            inputElement.classList.add('border-red-500');
        }
    }

    // Show error message under specific field in edit modal
    function showEditError(fieldId, message) {
        const errorElement = document.getElementById('edit_' + fieldId + '_error');
        const inputElement = document.getElementById('edit_' + fieldId);

        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            errorElement.style.minHeight = '20px';
        }

        if (inputElement) {
            inputElement.classList.add('border-red-500');
        }
    }

    // Function để cập nhật CSRF token
    function updateCsrfToken(newToken) {
        const csrfInput = document.querySelector('input[name="csrf_token"]');
        if (csrfInput && newToken) {
            csrfInput.value = newToken;
        }
    }

    // ==================== EDIT TENANT FUNCTIONS ====================
    
    // Function để edit tenant (được gọi từ nút Edit)
    function editTenant(tenantId) {
        openEditTenantModal(tenantId);
    }
    
    // Mở modal edit tenant
    function openEditTenantModal(tenantId) {
        currentMode = 'edit';
        
        // Clear previous errors
        clearAllEditErrors();
        
        // Show modal
        const modal = document.getElementById('editTenantModal');
        modal.classList.remove('hidden');
        
        // Fetch tenant data
        fetch(`${App.appURL}landlord/tenant/edit/${tenantId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Populate form with tenant data
                    populateEditForm(data.tenant, data.rooms);
                } else {
                    console.error('API Error:', data);
                    showErrorMessage(data.message || 'Không thể tải thông tin khách hàng');
                    closeAddTenantModal();
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                showErrorMessage('Có lỗi xảy ra khi tải thông tin khách hàng: ' + error.message);
                closeAddTenantModal();
            });
    }
    
    // Populate edit form with data
    function populateEditForm(tenant, rooms) {
        // Set tenant ID
        const tenantIdElement = document.getElementById('edit_tenant_id');
        if (tenantIdElement) {
            tenantIdElement.value = tenant.id;
        }
        
        // Display current room info
        const currentRoomDisplay = document.getElementById('edit_current_room_display');
        if (currentRoomDisplay) {
            currentRoomDisplay.innerHTML = `
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-medium text-gray-900">${tenant.room_name || 'N/A'}</div>
                        <div class="text-sm text-gray-500">${tenant.house_name || 'N/A'}</div>
                    </div>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-home mr-1"></i>
                        Phòng hiện tại
                    </div>
                </div>
            `;
        }
        
        // Basic info
        const usernameElement = document.getElementById('edit_username');
        if (usernameElement) {
            usernameElement.value = tenant.username || '';
        }
        
        const emailElement = document.getElementById('edit_email');
        if (emailElement) {
            emailElement.value = tenant.email || '';
        }
        
        const phoneElement = document.getElementById('edit_phone');
        if (phoneElement) {
            phoneElement.value = tenant.phone || '';
        }
        
        const genderElement = document.getElementById('edit_gender');
        if (genderElement) {
            genderElement.value = tenant.gender || '';
        }
        
        const birthdayElement = document.getElementById('edit_birthday');
        if (birthdayElement) {
            birthdayElement.value = tenant.birthday || '';
        }
        
        const jobElement = document.getElementById('edit_job');
        if (jobElement) {
            jobElement.value = tenant.job || '';
        }
        
        const addressElement = document.getElementById('edit_address');
        if (addressElement) {
            addressElement.value = tenant.address || '';
        }
        
        const citizenIdElement = document.getElementById('edit_citizen_id');
        if (citizenIdElement) {
            citizenIdElement.value = tenant.citizen_id || '';
        }
        
        // Room info
        const joinDateElement = document.getElementById('edit_join_date');
        if (joinDateElement) {
            joinDateElement.value = tenant.join_date || '';
        }
        
        const isPrimaryElement = document.getElementById('edit_is_primary');
        if (isPrimaryElement) {
            isPrimaryElement.checked = tenant.is_primary == 1;
        }
        
        const noteElement = document.getElementById('edit_note');
        if (noteElement) {
            noteElement.value = tenant.note || '';
        }
        
        // Set selected room
        const selectedRoomIdElement = document.getElementById('edit_selected_room_id');
        if (selectedRoomIdElement) {
            selectedRoomIdElement.value = tenant.room_id;
        }
        
        // Load provinces and set current values
        loadEditTenantProvinces(tenant.province, tenant.ward);
    }
    
    // Load provinces for edit form
    function loadEditTenantProvinces(selectedProvince = '', selectedWard = '') {
        fetch('https://provinces.open-api.vn/api/v2/')
            .then(response => response.json())
            .then(provinces => {
                const provinceSelect = document.querySelector(EDIT_TENANT_PROVINCE_SELECTOR);
                provinceSelect.innerHTML = '<option value="">Chọn tỉnh/thành phố</option>';
                
                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name;
                    option.textContent = province.name;
                    option.setAttribute('data-code', province.code);
                    if (province.name === selectedProvince) {
                        option.selected = true;
                    }
                    provinceSelect.appendChild(option);
                });
                
                // Load wards if province is selected
                if (selectedProvince) {
                    loadEditTenantWards(selectedWard);
                }
            })
            .catch(error => {
                console.error('Error loading provinces:', error);
            });
    }
    
    // Load wards for edit form
    function loadEditTenantWards(selectedWard = '') {
        const selectedOption = $(EDIT_TENANT_PROVINCE_SELECTOR + ' option:selected');
        const provinceCode = selectedOption.attr('data-code');
        console.log('Edit tenant selected province code:', provinceCode);

        if (!provinceCode) {
            console.log('No province code found in edit modal, disabling ward dropdown');
            $(EDIT_TENANT_WARD_SELECTOR).html('<option value="">Chọn phường/xã</option>');
            $(EDIT_TENANT_WARD_SELECTOR).attr('disabled', true);
            return;
        }

        fetch(`https://provinces.open-api.vn/api/v2/p/${provinceCode}?depth=2`)
            .then(response => response.json())
            .then(provinceData => {
                console.log('Edit tenant province data:', provinceData);
                $(EDIT_TENANT_WARD_SELECTOR).html('<option value="">Chọn phường/xã</option>');
                
                // Cấu trúc dữ liệu đúng: provinceData.wards[]
                if (provinceData.wards && provinceData.wards.length > 0) {
                    console.log('Edit tenant wards found:', provinceData.wards.length);
                    provinceData.wards.forEach((ward) => {
                        const option = document.createElement('option');
                        option.value = ward.name;
                        option.textContent = ward.name;
                        option.setAttribute('data-code', ward.code);
                        if (ward.name === selectedWard) {
                            option.selected = true;
                        }
                        $(EDIT_TENANT_WARD_SELECTOR).append(option);
                    });
                    $(EDIT_TENANT_WARD_SELECTOR).attr('disabled', false);
                    console.log('Edit tenant ward dropdown enabled');
                } else {
                    console.log('No wards found for edit tenant province');
                    $(EDIT_TENANT_WARD_SELECTOR).attr('disabled', true);
                }
            })
            .catch(error => {
                console.error('Error loading wards:', error);
                $(EDIT_TENANT_WARD_SELECTOR).html('<option value="">Chọn phường/xã</option>');
                $(EDIT_TENANT_WARD_SELECTOR).attr('disabled', true);
            });
    }
    

    // Xử lý submit form
    $('#tenantForm').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors trước khi xử lý
        clearAllErrors();
        
        // Kiểm tra đã chọn phòng chưa (chỉ cho add mode)
        if (currentMode === 'add') {
        const selectedRoomId = document.getElementById('selected_room_id').value;
        if (!selectedRoomId) {
            showErrorMessage('Vui lòng chọn phòng trước khi thêm khách hàng');
            return;
            }
        }
        
        // Disable submit button và hiển thị loading
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Đang xử lý...';
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        
        // Submit form via AJAX
        const formData = new FormData(this);
        
        // Xác định URL dựa trên mode
        const url = currentMode === 'add' 
            ? `${App.appURL}landlord/tenant/create`
            : `${App.appURL}landlord/tenant/update`;
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                // Restore submit button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                
                // Cập nhật CSRF token từ response
                if (response.csrf_token) {
                    updateCsrfToken(response.csrf_token);
                }
                
                if (response.success) {
                    showSuccessMessage(response.message);
                    closeAddTenantModal();
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    // Xử lý lỗi từ success response
                    if (response.errors) {
                        // Hiển thị lỗi dưới từng input field
                        Object.keys(response.errors).forEach(field => {
                            showError(field, response.errors[field]);
                        });
                    } else {
                        showErrorMessage(response.message);
                    }
                }
            },
            error: function(xhr) {
                // Restore submit button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                
                try {
                    const response = JSON.parse(xhr.responseText);
                    
                    // Cập nhật CSRF token từ response
                    if (response.csrf_token) {
                        updateCsrfToken(response.csrf_token);
                    }
                    
                    if (response.errors) {
                        // Hiển thị lỗi dưới từng input field
                        Object.keys(response.errors).forEach(field => {
                            showError(field, response.errors[field]);
                        });
                    } else {
                        showErrorMessage(response.message || 'Có lỗi xảy ra');
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    console.error('Response text:', xhr.responseText);
                    showErrorMessage('Có lỗi xảy ra khi xử lý dữ liệu');
                }
            }
        });
    });

    // Xử lý submit form edit
    $('#editTenantForm').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors trước khi xử lý
        clearAllEditErrors();
        
        // Disable submit button và hiển thị loading
        const submitBtn = document.getElementById('editSubmitBtn');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Đang xử lý...';
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        
        // Submit form via AJAX
        const formData = new FormData(this);
        
        $.ajax({
            url: `${App.appURL}landlord/tenant/update`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                // Restore submit button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                
                // Cập nhật CSRF token từ response
                if (response.csrf_token) {
                    updateCsrfToken(response.csrf_token);
                }
                
                if (response.success) {
                    showSuccessMessage(response.message);
                    closeEditTenantModal();
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    // Xử lý lỗi từ success response
                    if (response.errors) {
                        // Hiển thị lỗi dưới từng input field
                        Object.keys(response.errors).forEach(field => {
                            showEditError(field, response.errors[field]);
                        });
                    } else {
                        showErrorMessage(response.message);
                    }
                }
            },
            error: function(xhr) {
                // Restore submit button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                
                try {
                    const response = JSON.parse(xhr.responseText);
                    
                    // Cập nhật CSRF token từ response
                    if (response.csrf_token) {
                        updateCsrfToken(response.csrf_token);
                    }
                    
                    if (response.errors) {
                        // Hiển thị lỗi dưới từng input field
                        Object.keys(response.errors).forEach(field => {
                            showEditError(field, response.errors[field]);
                        });
                    } else {
                        showErrorMessage(response.message || 'Có lỗi xảy ra');
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    console.error('Response text:', xhr.responseText);
                    showErrorMessage('Có lỗi xảy ra khi xử lý dữ liệu');
                }
            }
        });
    });

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
    function deleteTenant(tenantId) {
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
                // Gọi API xóa khách thuê
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch(`${App.appURL}landlord/tenant/remove`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `tenant_id=${tenantId}&csrf_token=${csrfToken}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccessMessage(data.message);
                        // Reload trang sau 1.5 giây để user thấy thông báo
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showErrorMessage(data.message || 'Có lỗi xảy ra khi xóa khách thuê');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorMessage('Có lỗi xảy ra khi xóa khách thuê');
                });
            }
        });
    }

    // Toggle tenant actions dropdown
    function toggleTenantActions(tenantId) {
        // Close all other dropdowns first
        const allDropdowns = document.querySelectorAll('[id^="tenantActions-"]');
        allDropdowns.forEach(dropdown => {
            if (dropdown.id !== `tenantActions-${tenantId}`) {
                dropdown.classList.add('hidden');
            }
        });
        
        // Toggle the current dropdown
        const dropdown = document.getElementById(`tenantActions-${tenantId}`);
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    }

    // Close all dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.relative')) {
            const dropdowns = document.querySelectorAll('[id^="tenantActions-"]');
            dropdowns.forEach(dropdown => {
                dropdown.classList.add('hidden');
            });
        }
    });

</script>

<?php include VIEW_PATH . '/landlord/layouts/footer.php'; ?>
</body>
</html>
