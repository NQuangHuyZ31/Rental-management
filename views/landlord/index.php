<!--
Author: Nguyen Xuan Duong
Date: 2025-08-29
Purpose: Build Index house for Landlord 
-->
<?php
use Helpers\Format;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOSTY - Quản lý nhà cho thuê</title>

    <!-- Include Libraries -->
    <?php include 'layouts/app.php'; ?>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <?php include 'layouts/header.php'; ?>

    <!-- Navigation Menu -->
    <?php include 'layouts/nav.php'; ?>

    <?php if (!empty($houses)): ?>
    <!-- Room Management Dashboard -->
    <main class="min-h-screen bg-gray-100 w-full">
        <div class="w-full px-4 py-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6 mb-8 max-w-none">
                    <!-- Total Debt Card -->
                    <div class="bg-white rounded-lg shadow-md p-6 border border-[#E5E7EB]">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-users text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm">Tổng số khách thuê</p>
                                    <p class="text-blue-500 font-bold text-lg"><?= $totalTenants ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Room Reservation Deposit Card -->
                    <div class="bg-white rounded-lg shadow-md p-6 border border-[#E5E7EB]">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-door-open text-yellow-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm">Tổng số phòng</p>
                                    <p class="text-green-500 font-bold text-lg"><?= $totalRooms ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Amenities Card -->
                    <div class="bg-white rounded-lg shadow-md p-6 border border-[#E5E7EB]">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-couch text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm">Tổng số tiện ích</p>
                                    <p class="text-green-500 font-bold text-lg"><?= $totalAmenities ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Services Card -->
                    <div class="bg-white rounded-lg shadow-md p-6 border border-[#E5E7EB]">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-concierge-bell text-orange-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm">Tổng số dịch vụ</p>
                                    <p class="text-red-500 font-bold text-lg"><?= $totalServices ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Header -->
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-home text-green-600 text-sm"></i>
                                </div>
                                <div class="w-1 h-6 bg-green-600 mx-3"></div>
                                Quản lý danh sách phòng
                            </h1>
                            <p class="text-gray-600 mt-2">
                                <?php if ($selectedHouse): ?>
                                    Tất cả danh sách phòng trong <?= htmlspecialchars($selectedHouse['house_name']) ?>
                                <?php else: ?>
                                    Vui lòng chọn nhà để xem danh sách phòng
                                <?php endif; ?>
                            </p>
                        </div>

                        <div class="flex items-center space-x-3">
                            <button onclick="openRoomModal()" class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center hover:bg-green-700 transition-colors">
                                <i class="fas fa-plus text-white"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filter Bar -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-[#E5E7EB]">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <!-- <div class="relative">
                                <i class="fas fa-filter text-gray-600 text-lg"></i>
                                <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center border border-white">
                                    <span class="text-white text-xs font-bold">1</span>
                                </div>
                            </div> -->

                            <div class="flex items-center space-x-4 flex-wrap">
                                <div id="filter-occupied-wrap" class="relative bg-white rounded-lg px-3 py-2 border border-gray-200 cursor-pointer">
                                    <input type="checkbox" id="filter-occupied" class="form-checkbox text-green-600 mr-2">
                                    <span class="text-sm text-gray-700">Đang ở</span>
                                    <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center border border-white">
                                        <span class="text-white text-xs font-bold"><?= $occupiedRooms ?></span>
                                    </div>
                                </div>

                                <div id="filter-available-wrap" class="relative bg-white rounded-lg px-3 py-2 border border-gray-200 cursor-pointer">
                                    <input type="checkbox" id="filter-available" class="form-checkbox text-green-600 mr-2">
                                    <span class="text-sm text-gray-700">Đang trống</span>
                                    <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center border border-white">
                                        <span class="text-white text-xs font-bold"><?= $availableRooms ?></span>
                                    </div>
                                </div>
                                
                                <div id="filter-maintenance-wrap" class="relative bg-white rounded-lg px-3 py-2 border border-gray-200 cursor-pointer">
                                    <input type="checkbox" id="filter-maintenance" class="form-checkbox text-green-600 mr-2">
                                    <span class="text-sm text-gray-700">Đang bảo trì</span>
                                    <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center border border-white">
                                        <span class="text-white text-xs font-bold"><?= $maintenanceIssues ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search Bar -->
                        <div class="relative">
                            <input type="text"
                                id="roomSearchInput"
                                placeholder="Tìm tên phòng..."
                                class="w-80 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Room List Table -->
                <?php if ($selectedHouse && !empty($rooms)): ?>
                <div class="bg-gray-50 rounded-lg overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                        <table id="roomsTable" class="w-full">
                            <thead class="bg-[#F9FAFB]">
                                <tr>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-black border border-gray-200">Tên phòng</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-black border border-gray-200">Tầng</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-black border border-gray-200">Diện tích</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-black border border-gray-200">Giá thuê</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-black border border-gray-200">Tiền cọc</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-black border border-gray-200">Số người tối đa</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-black border border-gray-200">Tình trạng</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-black border border-gray-200"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $stt = 0; foreach ($rooms as $room): ?>
                                <tr data-room-status="<?= $room['room_status'] ?>" class="bg-white">
                                    <td class="px-6 py-4 whitespace-nowrap border border-gray-200 text-center text-sm text-gray-900">
                                        <span><?= htmlspecialchars($room['room_name']) ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 border border-gray-200 text-center text-sm text-gray-900">
                                        <?= htmlspecialchars($room['floor']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border border-gray-200 text-center text-sm text-gray-900">
                                        <?= htmlspecialchars($room['area']) ?> m²
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border border-gray-200 text-center text-sm text-gray-900">
                                        <?= Format::formatPriceVND($room['room_price']) ?> ₫
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 border border-gray-200 text-center text-sm text-gray-900">
                                        <?= Format::formatPriceVND($room['deposit']) ?> ₫
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border border-gray-200 text-center text-sm text-gray-900">
                                        <div class="flex items-center justify-center">
                                            <i class="fas fa-user text-gray-400 mr-1"></i>
                                            <span><?= htmlspecialchars($room['max_people']) ?> người</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border border-gray-200 text-center">
                                        <?php
                                        $statusText = '';
                                        $statusColor = '';
                                        switch($room['room_status']) {
                                            case 'available':
                                                $statusText = 'Đang trống';
                                                $statusColor = '#7DC242';
                                                break;
                                            case 'occupied':
                                                $statusText = 'Đã thuê';
                                                $statusColor = '#3B82F6';
                                                break;
                                            case 'maintenance':
                                                $statusText = 'Bảo trì';
                                                $statusColor = '#ED6004';
                                                break;
                                            default:
                                                $statusText = 'Không xác định';
                                                $statusColor = '#6B7280';
                                        }
                                        ?>
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white" style="background-color: <?= $statusColor ?>;">
                                            <?= $statusText ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium border border-gray-200">
                                        <div class="flex items-center justify-center space-x-4">
                                            <!-- Edit Icon -->
                                            <button onclick="editRoom(<?= $room['id'] ?>)" class="hover:scale-110 transition-transform" title="Chỉnh sửa phòng">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>

                                            <!-- Invoice Icon -->
                                            <?php if ($room['room_status'] === 'occupied'): ?>
                                                <button onclick="openCreateInvoiceModal(<?= $room['id'] ?>, '<?= htmlspecialchars($room['room_name']) ?>')" class="hover:scale-110 transition-transform" title="Tạo hóa đơn">
                                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </button>
                                            <?php else: ?>
                                                <button class="cursor-not-allowed" disabled title="Phòng chưa có người thuê">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </button>
                                            <?php endif; ?>

                                            <!-- Delete Icon -->
                                            <button onclick="deleteRoom(<?= $room['id'] ?>, '<?= htmlspecialchars($room['room_name']) ?>')" class="hover:scale-110 transition-transform" title="Xóa phòng">
                                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $stt++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Pagination -->
                <?php if (!empty($pagination) && is_array($pagination) && ($pagination['total_pages'] ?? 0) > 1): ?>
                    <div class="mt-8 px-6">
                        <?= \Helpers\Pagination::render($pagination, '', $queryParams ?? []) ?>
                    </div>
                <?php endif; ?>
                <?php elseif ($selectedHouse && empty($rooms)): ?>
                <div class="text-center py-12">
                    <div class="mb-4">
                        <i class="fas fa-door-open text-gray-400 text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Chưa có phòng nào</h3>
                    <p class="text-gray-500">Nhà này chưa có phòng nào được tạo.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php else: ?>
    <!-- Non house content -->
    <main class="min-h-screen flex items-center bg-white pt-20">
        <div class="max-w-4xl mx-auto text-center px-4 -mt-80">
            <div class="mb-12">
                <img src="<?= BASE_URL ?>/Public/images/admin/empty-houses.jpg" 
                     alt="Empty Houses" 
                     class="w-64 h-64 mx-auto object-cover">
            </div>
            
            <div class="mb-4 text-center -mt-4">
                <h1 class="text-2xl font-bold text-gray-800 leading-tight whitespace-nowrap">
                    Bạn chưa có tòa nhà cho thuê nào! Vui lòng thêm nhà trọ trước khi tiếp tục.
                </h1>
            </div>
            
            <div class="mb-6 text-center -mt-2">
                <p class="text-gray-600 text-lg leading-relaxed whitespace-nowrap">
                    Với thiết kết đơn giản - thân thiện - dễ sử dụng. Quản lý nhà trọ của bạn dễ hơn bao giờ hết.
                </p>
            </div>
            
            <div class="mt-6 text-center -mt-2">
                <button class="bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-102 flex items-center mx-auto">
                    <i class="fas fa-plus mr-3 text-lg"></i>
                    Tạo nhà trọ đầu tiên
                </button>
            </div>
        </div>
    </main>
    <?php endif; ?>

    <!-- Create Invoice Modal -->
    <div id="createInvoiceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white flex flex-col max-h-[90vh]">
            <!-- Modal Header - Fixed -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-white rounded-t-md flex-shrink-0">
                <h3 class="text-lg font-semibold text-gray-900">Tạo hóa đơn mới - <span id="createInvoiceRoomName"></span></h3>
                <button onclick="closeCreateInvoiceModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body - Scrollable -->
            <div id="createInvoiceModalBody" class="flex-1 overflow-y-auto p-4">
                <!-- Nội dung sẽ được load bằng JavaScript -->
            </div>

            <!-- Modal Footer - Fixed -->
            <div class="flex justify-end space-x-3 p-4 border-t border-gray-200 bg-white rounded-b-md flex-shrink-0">
                <button onclick="closeCreateInvoiceModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                    Đóng
                </button>
                <button type="button"
                    onclick="createInvoice()"
                    id="createInvoiceBtn"
                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <span id="createBtnText">Tạo hóa đơn</span>
                    <span id="createBtnLoading" class="hidden">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Đang tạo...
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Room Modal -->
    <div id="roomModal" class="modal-container hidden">
        <div class="modal-content flex flex-col overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0 bg-white">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-door-open text-white text-sm"></i>
                    </div>
                    <h2 id="roomModalTitle" class="text-xl font-semibold text-gray-800">Thêm phòng mới</h2>
                </div>
                <button onclick="closeRoomModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Form -->
            <form id="roomForm" method="POST" action="${App.appURL}landlord/room/create" class="flex flex-col flex-1 min-h-0">
                <input type="hidden" id="room_id" name="room_id" value="">
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
                                <p class="text-gray-600 italic mt-1 text-sm">Thông tin cơ bản về phòng mới</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Tên phòng -->
                            <div class="relative">
                                <input type="text" id="room_name" name="room_name" value="<?= htmlspecialchars($oldInput['room_name'] ?? '') ?>" required class="peer w-full px-4 py-3 border <?= isset($validationErrors['room_name']) ? 'border-red-500' : 'border-blue-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                <label for="room_name" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tên phòng <span class="text-red-500">*</span></label>
                                <?php if (isset($validationErrors['room_name'])): ?>
                                    <div class="text-red-500 text-xs mt-1"><?= htmlspecialchars($validationErrors['room_name']) ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Tầng -->
                            <div class="relative">
                                <input type="number" id="floor" name="floor" value="<?= htmlspecialchars($oldInput['floor'] ?? '') ?>" min="1" required class="peer w-full px-4 py-3 border <?= isset($validationErrors['floor']) ? 'border-red-500' : 'border-blue-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                <label for="floor" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tầng <span class="text-red-500">*</span></label>
                                <?php if (isset($validationErrors['floor'])): ?>
                                    <div class="text-red-500 text-xs mt-1"><?= htmlspecialchars($validationErrors['floor']) ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Diện tích và Số người tối đa trên cùng một dòng -->
                            <div class="relative">
                                <input type="number" id="area" name="area" value="<?= htmlspecialchars($oldInput['area'] ?? '') ?>" min="1" step="0.1" required class="peer w-full px-4 py-3 border <?= isset($validationErrors['area']) ? 'border-red-500' : 'border-blue-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                <label for="area" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Diện tích (m²) <span class="text-red-500">*</span></label>
                                <?php if (isset($validationErrors['area'])): ?>
                                    <div class="text-red-500 text-xs mt-1"><?= htmlspecialchars($validationErrors['area']) ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Số người tối đa -->
                            <div class="relative">
                                <input type="number" id="max_people" name="max_people" value="<?= htmlspecialchars($oldInput['max_people'] ?? '') ?>" min="1" required class="peer w-full px-4 py-3 border <?= isset($validationErrors['max_people']) ? 'border-red-500' : 'border-blue-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                <label for="max_people" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Số người tối đa <span class="text-red-500">*</span></label>
                                <?php if (isset($validationErrors['max_people'])): ?>
                                    <div class="text-red-500 text-xs mt-1"><?= htmlspecialchars($validationErrors['max_people']) ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Tiền cọc và Giá thuê trên cùng một dòng -->
                            <div class="relative">
                                <input type="number" id="deposit" name="deposit" value="<?= htmlspecialchars($oldInput['deposit'] ?? '') ?>" min="0" step="1000" required class="peer w-full px-4 py-3 border <?= isset($validationErrors['deposit']) ? 'border-red-500' : 'border-blue-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                <label for="deposit" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tiền cọc (VNĐ) <span class="text-red-500">*</span></label>
                                <?php if (isset($validationErrors['deposit'])): ?>
                                    <div class="text-red-500 text-xs mt-1"><?= htmlspecialchars($validationErrors['deposit']) ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Giá thuê -->
                            <div class="relative">
                                <input type="number" id="room_price" name="room_price" value="<?= htmlspecialchars($oldInput['room_price'] ?? '') ?>" min="0" step="1" required class="peer w-full px-4 py-3 border <?= isset($validationErrors['room_price']) ? 'border-red-500' : 'border-blue-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                <label for="room_price" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Giá thuê (VNĐ) <span class="text-red-500">*</span></label>
                                <?php if (isset($validationErrors['room_price'])): ?>
                                    <div class="text-red-500 text-xs mt-1"><?= htmlspecialchars($validationErrors['room_price']) ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Trạng thái phòng -->
                            <div class="relative">
                                <select id="room_status" name="room_status" required class="peer w-full px-4 py-3 border <?= isset($validationErrors['room_status']) ? 'border-red-500' : 'border-blue-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                    <option value="">Chọn trạng thái</option>
                                    <option value="available" <?= (!isset($oldInput['room_status']) || $oldInput['room_status'] === 'available') ? 'selected' : '' ?>>Đang trống</option>
                                    <option value="maintenance" <?= (isset($oldInput['room_status']) && $oldInput['room_status'] === 'maintenance') ? 'selected' : '' ?>>Bảo trì</option>
                                </select>
                                <label for="room_status" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Trạng thái <span class="text-red-500">*</span></label>
                                <?php if (isset($validationErrors['room_status'])): ?>
                                    <div class="text-red-500 text-xs mt-1"><?= htmlspecialchars($validationErrors['room_status']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 p-6 border-t border-gray-200 flex-shrink-0 bg-white">
                    <button type="button" onclick="closeRoomModal()" class="px-6 py-2 text-gray-600 hover:text-gray-800 transition-colors mr-3">
                        Hủy
                    </button>
                    <button type="submit" id="roomSubmitBtn" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        Tạo phòng
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'layouts/footer.php'; ?>
    
    <!-- Room Modal Script -->
    <script>
        // Room Modal functions
        function openRoomModal() {
            document.getElementById('roomModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            // Reset form to create mode
            resetRoomFormToCreate();
            // Reset dropdown trạng thái về 2 option khi thêm mới
            const statusSelect = document.getElementById('room_status');
            statusSelect.innerHTML = '';
            statusSelect.appendChild(new Option('Đang trống', 'available'));
            statusSelect.appendChild(new Option('Bảo trì', 'maintenance'));
            statusSelect.value = 'available';
            statusSelect.disabled = false;
        }

        function closeRoomModal() {
            document.getElementById('roomModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            // Reset form when closing modal
            document.getElementById('roomForm').reset();
            // Reset form to create mode
            resetRoomFormToCreate();
        }

        function resetRoomFormToCreate() {
            // Reset form action
            document.getElementById('roomForm').action = `${App.appURL}landlord/room/create`;
            
            // Reset modal title
            document.getElementById('roomModalTitle').textContent = 'Thêm phòng mới';
            
            // Reset submit button
            document.getElementById('roomSubmitBtn').innerHTML = 'Tạo phòng';
            
            // Clear hidden ID field
            document.getElementById('room_id').value = '';
        }

        function editRoom(roomId) {
            // Lấy thông tin phòng từ danh sách rooms
            const rooms = <?= json_encode($rooms) ?>;
            const room = rooms.find(r => r.id == roomId);

            if (!room) {
                Swal.fire({
                    title: 'Lỗi',
                    text: 'Không tìm thấy thông tin phòng!',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Đóng'
                });
                return;
            }

            // Mở modal
            document.getElementById('roomModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Điền dữ liệu vào form
            document.getElementById('room_id').value = room.id;
            document.getElementById('room_name').value = room.room_name;
            document.getElementById('floor').value = room.floor;
            document.getElementById('area').value = room.area;
            document.getElementById('room_price').value = Math.floor(Number(room.room_price) || 0);
            document.getElementById('deposit').value = room.deposit;
            document.getElementById('max_people').value = room.max_people;

            // Xử lý dropdown trạng thái
            const statusSelect = document.getElementById('room_status');
            // Xóa hết option cũ
            statusSelect.innerHTML = '';
            // Luôn thêm 2 trạng thái cơ bản
            statusSelect.appendChild(new Option('Đang trống', 'available'));
            statusSelect.appendChild(new Option('Bảo trì', 'maintenance'));
            // Nếu phòng đang thuê thì thêm option 'Đã thuê' và disable dropdown
            if (room.room_status === 'occupied') {
                statusSelect.appendChild(new Option('Đã thuê', 'occupied'));
                statusSelect.value = 'occupied';
                statusSelect.disabled = true;
            } else {
                statusSelect.value = room.room_status;
                statusSelect.disabled = false;
            }

            // Thay đổi tiêu đề modal
            document.getElementById('roomModalTitle').textContent = 'Chỉnh sửa phòng';

            // Thay đổi nút submit
            document.getElementById('roomSubmitBtn').innerHTML = 'Cập nhật phòng';

            // Thay đổi form action
            document.getElementById('roomForm').action = `${App.appURL}landlord/room/update`;
        }

        function deleteRoom(roomId, roomName) {
            Swal.fire({
                title: 'Xác nhận xóa phòng',
                html: `Bạn có chắc chắn muốn xóa phòng "<strong>${roomName}</strong>"?<br>Hành động này không thể hoàn tác.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa phòng',
                cancelButtonText: 'Hủy bỏ',
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tạo form ẩn để submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `${App.appURL}landlord/room/delete`;
                    
                    // Thêm CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = 'csrf_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);
                    
                    // Thêm room_id
                    const roomIdInput = document.createElement('input');
                    roomIdInput.type = 'hidden';
                    roomIdInput.name = 'room_id';
                    roomIdInput.value = roomId;
                    form.appendChild(roomIdInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }


        // Close modal when clicking outside
        document.getElementById('roomModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRoomModal();
            }
        });
    </script>

    <!-- Search Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('roomSearchInput');
            const roomsTable = document.getElementById('roomsTable');
            
            if (searchInput && roomsTable) {
                // Debounced input: call server-side filtering to avoid navigating every keystroke
                searchInput.addEventListener('input', function() {
                    if (typeof applyFilters === 'function') {
                        clearTimeout(window._roomsFilterDebounce);
                        window._roomsFilterDebounce = setTimeout(() => {
                            applyFilters();
                        }, 450);
                    } else {
                        // existing fallback (client-side) - should not be used when server-side is active
                    }
                });
                
                // Xóa kết quả tìm kiếm khi xóa hết text
                searchInput.addEventListener('keyup', function() {
                    if (this.value === '') {
                        // Call the unified filter function if it exists
                        if (typeof applyFilters === 'function') {
                            applyFilters();
                        } else {
                            const noResultsMessage = document.getElementById('noSearchResults');
                            if (noResultsMessage) {
                                noResultsMessage.remove();
                            }
                            
                            // Hiển thị lại tất cả các dòng
                            const tableRows = roomsTable.querySelectorAll('tbody tr');
                            tableRows.forEach(function(row) {
                                row.style.display = '';
                                row.classList.remove('hidden');
                            });
                        }
                    }
                });
            }

            // Room status filtering functionality
            const filterOccupied = document.getElementById('filter-occupied');
            const filterAvailable = document.getElementById('filter-available');
            const filterMaintenance = document.getElementById('filter-maintenance');
            
            if (filterOccupied && filterAvailable && filterMaintenance && roomsTable) {
                // Function to apply filters via AJAX (no full page reload)
                function applyFilters() {
                    const isOccupiedChecked = filterOccupied.checked;
                    const isAvailableChecked = filterAvailable.checked;
                    const searchTerm = searchInput ? searchInput.value.trim() : '';

                    const currentParams = new URLSearchParams(window.location.search);
                    const houseId = currentParams.get('house_id');
                    const newParams = new URLSearchParams();
                    if (houseId) newParams.set('house_id', houseId);
                    if (searchTerm !== '') newParams.set('search', searchTerm);
                    if (isOccupiedChecked) newParams.set('occupied', 1);
                    if (isAvailableChecked) newParams.set('available', 1);
                    if (filterMaintenance && filterMaintenance.checked) newParams.set('maintenance', 1);
                    newParams.set('page', 1);

                    const url = window.location.pathname + '?' + newParams.toString();
                    fetchAndReplace(url, true);
                }

                // Add event listeners to checkboxes
                filterOccupied.addEventListener('change', applyFilters);
                filterAvailable.addEventListener('change', applyFilters);
                filterMaintenance.addEventListener('change', applyFilters);

                // Make whole wrappers clickable but trigger native click to avoid double-toggle
                const occupiedWrap = document.getElementById('filter-occupied-wrap');
                const availableWrap = document.getElementById('filter-available-wrap');
                const maintenanceWrap = document.getElementById('filter-maintenance-wrap');

                if (occupiedWrap) {
                    occupiedWrap.addEventListener('click', function(e) {
                        if (e.target && e.target.id === 'filter-occupied') return; // ignore direct checkbox click
                        // trigger native click so only one change event fires and checkbox state is preserved
                        filterOccupied.click();
                    });
                }

                if (availableWrap) {
                    availableWrap.addEventListener('click', function(e) {
                        if (e.target && e.target.id === 'filter-available') return; // ignore direct checkbox click
                        filterAvailable.click();
                    });
                }

                if (maintenanceWrap) {
                    maintenanceWrap.addEventListener('click', function(e) {
                        if (e.target && e.target.id === 'filter-maintenance') return;
                        filterMaintenance.click();
                    });
                }

                // Intercept pagination link clicks (delegated) to use AJAX
                document.addEventListener('click', function(e) {
                    const a = e.target.closest('.mt-8 a');
                    if (!a) return;
                    e.preventDefault();
                    const href = a.getAttribute('href');
                    if (href) fetchAndReplace(href, true);
                });

                // Fetch a full page and replace the rooms container + pagination only
                function fetchAndReplace(url, pushHistory = true) {
                    fetch(url, {credentials: 'same-origin'})
                        .then(res => res.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            const newContainer = doc.querySelector('div.bg-gray-50.rounded-lg.overflow-hidden.border.border-gray-200');
                            const currentContainer = document.querySelector('div.bg-gray-50.rounded-lg.overflow-hidden.border.border-gray-200');
                            if (newContainer && currentContainer) {
                                currentContainer.innerHTML = newContainer.innerHTML;
                            }

                            // Replace pagination block
                            const currentParent = currentContainer ? currentContainer.parentElement : null;
                            if (currentParent) {
                                const currentPagination = currentParent.querySelector('.mt-8');
                                const newPagination = doc.querySelector('.mt-8');
                                if (currentPagination && newPagination) {
                                    currentPagination.innerHTML = newPagination.innerHTML;
                                } else if (!newPagination && currentPagination) {
                                    currentPagination.remove();
                                } else if (newPagination && !currentPagination) {
                                    currentParent.appendChild(newPagination.cloneNode(true));
                                }
                            }

                            // Update URL without reloading
                            if (pushHistory) {
                                try {
                                    const newUrl = new URL(url, window.location.origin);
                                    history.pushState({}, '', newUrl);
                                } catch (e) {
                                    // ignore
                                }
                            }

                            // After replacing content, nothing else to rebind because filter bar remains intact.
                        })
                        .catch(err => {
                            console.error('Error fetching filtered rooms:', err);
                            // fallback: full navigation
                            window.location.href = url;
                        });
                }
            }
        });

        // Create Invoice Modal functions
        function openCreateInvoiceModal(roomId, roomName) {
            // Set room name in modal title
            document.getElementById('createInvoiceRoomName').textContent = roomName;
            
            // Show loading
            document.getElementById('createInvoiceModalBody').innerHTML = `
                <div class="flex justify-center items-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
                    <span class="ml-2 text-gray-600">Đang tải...</span>
                </div>
            `;

            // Show modal
            document.getElementById('createInvoiceModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Fetch room services and display form
            fetch(`${App.appURL}landlord/invoice/create-form/${roomId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayCreateInvoiceForm(data.room, data.services, data.csrf_token);
                    } else {
                        document.getElementById('createInvoiceModalBody').innerHTML = `
                            <div class="text-center py-8">
                                <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-2"></i>
                                <p class="text-red-600">${data.message}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('createInvoiceModalBody').innerHTML = `
                        <div class="text-center py-8">
                            <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-2"></i>
                            <p class="text-red-600">Có lỗi xảy ra khi tải dữ liệu</p>
                        </div>
                    `;
                });
        }

        function closeCreateInvoiceModal() {
            document.getElementById('createInvoiceModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function displayCreateInvoiceForm(room, services, csrfToken) {
            const modalBody = document.getElementById('createInvoiceModalBody');

            // Format money
            const formatMoney = (amount) => {
                if (!amount || amount === 0) return '0₫';
                return new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(amount);
            };

            // Get current month/year
            const now = new Date();
            const currentMonth = (now.getMonth() + 1).toString().padStart(2, '0');
            const currentYear = now.getFullYear();

            modalBody.innerHTML = `
                <form id="createInvoiceForm" class="space-y-4">
                    <input type="hidden" id="roomId" name="room_id" value="${room.id}">
                    <input type="hidden" id="csrfToken" name="csrf_token" value="${csrfToken}">
                    
                    <!-- Thông tin cơ bản -->
                    <div class="space-y-4">
                        <!-- Tên hóa đơn -->
                        <div class="relative">
                            <input type="text" 
                                   name="invoice_name"
                                   id="invoiceName"
                                   value="Hóa đơn ${room.room_name} - ${currentMonth}/${currentYear}" 
                                   class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                            <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tên hóa đơn *</label>
                        </div>
                        
                        <!-- Tháng lập phiếu -->
                        <div class="relative">
                            <input type="text" 
                                   name="invoice_month"
                                   id="createInvoiceMonthYearInput" 
                                   value="${currentMonth}-${currentYear}" 
                                   readonly 
                                   class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:outline-none cursor-pointer bg-white"
                                   placeholder=" ">
                            <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tháng lập phiếu *</label>
                            <svg class="w-5 h-5 text-gray-400 absolute right-3 top-2.5 cursor-pointer" id="createInvoiceCalendarIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 012 2z"></path>
                            </svg>

                            <!-- Month/Year Picker Overlay -->
                            <div id="createInvoiceMonthYearPicker" class="hidden absolute top-full left-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 w-64">
                                <!-- Year Navigation -->
                                <div class="flex items-center justify-between p-3 border-b border-gray-200">
                                    <button id="createInvoicePrevYear" class="text-gray-600 hover:text-gray-800 p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                    <span id="createInvoiceCurrentYear" class="font-medium text-gray-900">${currentYear}</span>
                                    <button id="createInvoiceNextYear" class="text-gray-600 hover:text-gray-800 p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Months Grid -->
                                <div class="p-3">
                                    <div class="grid grid-cols-4 gap-2">
                                        <button type="button" class="create-invoice-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="01">Th1</button>
                                        <button type="button" class="create-invoice-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="02">Th2</button>
                                        <button type="button" class="create-invoice-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="03">Th3</button>
                                        <button type="button" class="create-invoice-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="04">Th4</button>
                                        <button type="button" class="create-invoice-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="05">Th5</button>
                                        <button type="button" class="create-invoice-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="06">Th6</button>
                                        <button type="button" class="create-invoice-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="07">Th7</button>
                                        <button type="button" class="create-invoice-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="08">Th8</button>
                                        <button type="button" class="create-invoice-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="09">Th9</button>
                                        <button type="button" class="create-invoice-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="10">Th10</button>
                                        <button type="button" class="create-invoice-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="11">Th11</button>
                                        <button type="button" class="create-invoice-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="12">Th12</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Ngày lập và hạn đóng tiền -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="date" 
                                       name="invoice_day"
                                       id="createInvoiceDay"
                                       value="${now.toISOString().split('T')[0]}" 
                                       class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Ngày lập hóa đơn *</label>
                            </div>
                            <div class="relative">
                                <input type="date" 
                                       name="due_date"
                                       id="createInvoiceDueDate"
                                       value="${new Date(now.getTime() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0]}" 
                                       class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Hạn đóng tiền *</label>
                            </div>
                        </div>
                        
                        <!-- Tiền phòng -->
                        <div class="relative">
                            <input type="number" 
                                   name="rental_amount"
                                   id="rentalAmount"
                                   value="${Math.floor(Number(room.room_price) || 0)}" 
                                   class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                            <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tiền phòng (₫)</label>
                        </div>
                    </div>
                    
                    <!-- Chi tiết dịch vụ -->
                    ${services && services.length > 0 ? `
                    <div class="p-4">
                        <div class="flex mb-4">
                            <div class="w-1 bg-green-600 mr-3"></div>
                            <div>
                                <h5 class="text-base font-medium text-gray-800">Chi tiết dịch vụ:</h5>
                                <p class="text-gray-600 italic mt-1 text-sm">Danh sách các dịch vụ sử dụng trong tháng</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            ${services.map(service => `
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <div class="flex items-start justify-between">
                                        <!-- Bên trái: Checkbox, tên dịch vụ và đơn giá -->
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <!-- fixed tick icon (service always enabled in create invoice) -->
                                                <input type="hidden" name="services[${service.id}][enabled]" value="1">
                                                <div class="w-4 h-4 bg-blue-500 rounded flex items-center justify-center mr-2">
                                                    <i class="fas fa-check text-white text-xs"></i>
                                                </div>
                                                <span class="font-bold text-gray-800">${service.service_name} (${service.service_type})</span>
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                Giá: <span class="font-medium">${formatMoney(service.service_price)} / ${service.unit_vi}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Bên phải: Số cũ, số mới hoặc số lượng -->
                                        <div class="ml-4">
                                            ${service.unit === 'KWH' || service.unit === 'm3' ? `
                                                <div class="flex items-center space-x-2">
                                                    <div class="flex items-center">
                                                        <span class="text-sm text-gray-600 mr-1">Số cũ:</span>
                                                        <input type="number" 
                                                               name="services[${service.id}][old_value]"
                                                               value="0" 
                                                               min="0"
                                                               step="1"
                                                               required
                                                               oninput="validateMeterInput(this)"
                                                               class="w-16 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-sm">
                                                    </div>
                                                    <div class="flex items-center">
                                                        <span class="text-sm text-gray-600 mr-1">Số mới:</span>
                                                        <input type="number" 
                                                               name="services[${service.id}][new_value]"
                                                               value="0" 
                                                               min="0"
                                                               step="1"
                                                               required
                                                               oninput="validateMeterInput(this)"
                                                               class="w-16 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-sm">
                                                    </div>
                                                </div>
                                            ` : `
                                                <div class="flex items-center">
                                                    <span class="text-sm text-gray-600 mr-1">Số lượng:</span>
                                                    <input type="number" 
                                                           name="services[${service.id}][usage_amount]"
                                                           value="1" 
                                                           min="0"
                                                           step="1"
                                                           required
                                                           oninput="validateQuantityInput(this)"
                                                           class="w-16 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-sm">
                                                </div>
                                            `}
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    ` : ''}
                    
                    <!-- Ghi chú -->
                    <div class="mt-6">
                        <div class="relative">
                            <input type="text" 
                                   name="note"
                                   id="createInvoiceNote" 
                                   value="" 
                                   class="peer w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder=" ">
                            <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Ghi chú</label>
                        </div>
                    </div>
                </form>
            `;

            // Initialize month/year picker
            setTimeout(() => {
                initCreateInvoiceMonthYearPicker();
            }, 100);
        }

        // Validation functions
        function validateMeterInput(input) {
            let value = parseFloat(input.value);
            
            // Convert to integer (round down)
            value = Math.floor(value);
            
            // Prevent negative numbers
            if (value < 0) {
                input.value = 0;
                value = 0;
            }
            
            // Ensure integer value
            input.value = value;
            
            // Clear any existing error for this service
            const serviceId = input.name.match(/services\[(\d+)\]/)[1];
            clearServiceError(serviceId);
        }
        
        function validateQuantityInput(input) {
            let value = parseFloat(input.value);
            
            // Convert to integer (round down)
            value = Math.floor(value);
            
            // Prevent negative numbers
            if (value < 0) {
                input.value = 0;
                value = 0;
            }
            
            // Ensure minimum value of 1 for quantity
            if (value < 1) {
                input.value = 1;
            } else {
                // Ensure integer value
                input.value = value;
            }
        }
        
        function showServiceError(serviceId, message) {
            // Find the service container by looking for the checkbox input and then its parent container
            const checkboxInput = document.querySelector('input[name="services[' + serviceId + '][enabled]"]');
            if (!checkboxInput) {
                console.warn('Could not find service checkbox for service ID:', serviceId);
                return;
            }
            
            // Find the service container (the div with bg-white class)
            const serviceContainer = checkboxInput.closest('.bg-white');
            if (!serviceContainer) {
                console.warn('Could not find service container for service ID:', serviceId);
                return;
            }
            
            // Remove existing error for this service
            const existingError = serviceContainer.querySelector('.service-error');
            if (existingError) {
                existingError.remove();
            }
            
            // Create error message element
            const errorElement = document.createElement('div');
            errorElement.className = 'service-error text-red-500 text-xs mt-2';
            errorElement.textContent = message;
            
            // Add error to the service container
            serviceContainer.appendChild(errorElement);
        }
        
        function clearServiceError(serviceId) {
            const checkboxInput = document.querySelector('input[name="services[' + serviceId + '][enabled]"]');
            if (checkboxInput) {
                const serviceContainer = checkboxInput.closest('.bg-white');
                if (serviceContainer) {
                    const existingError = serviceContainer.querySelector('.service-error');
                    if (existingError) {
                        existingError.remove();
                    }
                }
            }
        }
        
        function validateInvoiceForm() {
            const form = document.getElementById('createInvoiceForm');
            
            // Basic validation - let backend handle detailed validation
            // Just check if required fields are filled
            const requiredFields = form.querySelectorAll('input[required]');
            for (let i = 0; i < requiredFields.length; i++) {
                const field = requiredFields[i];
                if (!field.value.trim()) {
                    field.focus();
                    return false;
                }
            }
            
            return true;
        }
        
        function clearFieldErrors() {
            // Remove existing error messages
            const existingErrors = document.querySelectorAll('.field-error');
            for (let i = 0; i < existingErrors.length; i++) {
                existingErrors[i].remove();
            }
            
            // Remove service errors
            const serviceErrors = document.querySelectorAll('.service-error');
            for (let i = 0; i < serviceErrors.length; i++) {
                serviceErrors[i].remove();
            }
            
            // Remove error styling from inputs
            const errorInputs = document.querySelectorAll('.border-red-500');
            for (let i = 0; i < errorInputs.length; i++) {
                errorInputs[i].classList.remove('border-red-500');
                errorInputs[i].classList.add('border-gray-300');
            }
        }
        
        function displayFieldErrors(errors) {
            console.log('Field errors:', errors); // Debug logging
            
            for (const fieldName in errors) {
                const errorMessage = errors[fieldName];
                console.log('Error for field', fieldName, ':', errorMessage);
                
                // Find the input field
                let input = null;
                if (fieldName.startsWith('services.')) {
                    // Handle service field errors (e.g., services.1.old_value)
                    const parts = fieldName.split('.');
                    const serviceId = parts[1];
                    const fieldType = parts[2];
                    input = document.querySelector('input[name="services[' + serviceId + '][' + fieldType + ']"]');
                    
                    // For service errors, show error below the service container
                    if (input) {
                        // Add error styling to input
                        input.classList.remove('border-gray-300');
                        input.classList.add('border-red-500');
                        
                        // Show service error instead of field error
                        showServiceError(serviceId, errorMessage);
                    }
                } else {
                    // Handle regular field errors
                    input = document.querySelector('input[name="' + fieldName + '"], select[name="' + fieldName + '"], textarea[name="' + fieldName + '"]');
                    
                    if (input) {
                        // Add error styling to input
                        input.classList.remove('border-gray-300');
                        input.classList.add('border-red-500');
                        
                        // Create error message element
                        const errorElement = document.createElement('div');
                        errorElement.className = 'field-error text-red-500 text-xs mt-1';
                        errorElement.textContent = errorMessage;
                        
                        // Insert error message after the input
                        input.parentNode.insertBefore(errorElement, input.nextSibling);
                    }
                }
                
                if (!input) {
                    console.warn('Could not find input for field:', fieldName);
                }
            }
        }

        function createInvoice() {
            const form = document.getElementById('createInvoiceForm');
            if (!form) {
                showErrorMessage('Không tìm thấy form tạo hóa đơn');
                return;
            }

            // Validate form before submission
            if (!validateInvoiceForm()) {
                return;
            }

            const formData = new FormData(form);
            const createBtn = document.getElementById('createInvoiceBtn');
            const createBtnText = document.getElementById('createBtnText');
            const createBtnLoading = document.getElementById('createBtnLoading');

            // Show loading
            createBtn.disabled = true;
            createBtnText.classList.add('hidden');
            createBtnLoading.classList.remove('hidden');

            // Send request
            fetch(`${App.appURL}landlord/invoice/create`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Response data:', data); // Debug logging
                    
                    if (data.success) {
                        App.showSuccessMessage(data.message || 'Tạo hóa đơn thành công!', 'success');
                        closeCreateInvoiceModal();
                        // Delay 1.5 seconds before reloading page
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        // Clear previous errors
                        clearFieldErrors();
                        
                        if (data.errors && typeof data.errors === 'object') {
                            // Display field-specific errors
                            displayFieldErrors(data.errors);
                            } else {
                            App.showSuccessMessage(data.message || 'Có lỗi xảy ra khi tạo hóa đơn', 'error');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    App.showSuccessMessage('Có lỗi xảy ra khi tạo hóa đơn', 'error');
                })
                .finally(() => {
                    // Hide loading
                    createBtn.disabled = false;
                    createBtnText.classList.remove('hidden');
                    createBtnLoading.classList.add('hidden');
                });
        }

        // Create Invoice Month/Year Picker functionality
        function initCreateInvoiceMonthYearPicker() {
            const input = document.getElementById('createInvoiceMonthYearInput');
            const icon = document.getElementById('createInvoiceCalendarIcon');
            const picker = document.getElementById('createInvoiceMonthYearPicker');
            const currentYearSpan = document.getElementById('createInvoiceCurrentYear');
            const prevYearBtn = document.getElementById('createInvoicePrevYear');
            const nextYearBtn = document.getElementById('createInvoiceNextYear');
            const monthBtns = document.querySelectorAll('.create-invoice-month-btn');

            if (!input || !picker) return;

            // Get current date
            const now = new Date();
            let currentYear = now.getFullYear();
            let selectedMonth = (now.getMonth() + 1).toString().padStart(2, '0');

            // Toggle picker visibility
            function togglePicker() {
                picker.classList.toggle('hidden');
            }

            // Update input value
            function updateInput() {
                const newValue = `${selectedMonth}-${currentYear}`;
                input.value = newValue;

                // Trigger input event to activate floating label
                if (newValue && newValue.trim() !== '') {
                    input.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                }
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

            prevYearBtn.addEventListener('click', () => {
                currentYear--;
                updateYearDisplay();
                highlightSelectedMonth();
            });

            nextYearBtn.addEventListener('click', () => {
                currentYear++;
                updateYearDisplay();
                highlightSelectedMonth();
            });

            monthBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    if (e && typeof e.preventDefault === 'function') e.preventDefault();
                    selectedMonth = btn.dataset.month;
                    updateInput();
                    highlightSelectedMonth();
                    picker.classList.add('hidden');
                });
            });

            // Close picker when clicking outside
            document.addEventListener('click', (e) => {
                if (!picker.contains(e.target) && !input.contains(e.target) && !icon.contains(e.target)) {
                    picker.classList.add('hidden');
                }
            });

            // Initialize
            updateYearDisplay();
            highlightSelectedMonth();
            updateInput();
        }

        // Close modal when clicking outside
        document.getElementById('createInvoiceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateInvoiceModal();
            }
        });

        // Close modal when pressing ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCreateInvoiceModal();
            }
        });
    </script>
</body>

</html>
