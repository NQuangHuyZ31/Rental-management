<!--
Author: Nguyen Xuan Duong
Date: 2025-08-29
Purpose: Build Index house for Landlord 
-->
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
                                    <i class="fas fa-receipt text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm">Tổng số tiền khách nợ</p>
                                    <p class="text-red-500 font-bold text-lg"><?= number_format($totalDebt) ?>₫</p>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Total Deposit Card -->
                    <div class="bg-white rounded-lg shadow-md p-6 border border-[#E5E7EB]">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-home text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm">Tổng số tiền cọc</p>
                                    <p class="text-green-500 font-bold text-lg"><?= number_format($totalDeposit) ?>₫</p>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Room Reservation Deposit Card -->
                    <div class="bg-white rounded-lg shadow-md p-6 border border-[#E5E7EB]">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-arrow-up text-yellow-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm">Tổng số tiền cọc giữ chỗ phòng</p>
                                    <p class="text-green-500 font-bold text-lg"><?= number_format($totalReservationDeposit) ?>₫</p>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Room Issues Card -->
                    <div class="bg-white rounded-lg shadow-md p-6 border border-[#E5E7EB]">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-briefcase text-orange-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm">Sự cố phòng</p>
                                    <p class="text-red-500 font-bold text-lg"><?= $maintenanceIssues ?> Vấn đề</p>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
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
                            <button class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center hover:bg-green-700 transition-colors">
                                <i class="fas fa-plus text-white"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filter Bar -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-[#E5E7EB]">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <div class="relative">
                                <i class="fas fa-filter text-gray-600 text-lg"></i>
                                <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center border border-white">
                                    <span class="text-white text-xs font-bold">1</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 flex-wrap">
                                <div class="relative bg-white rounded-lg px-3 py-2 border border-gray-200">
                                    <input type="checkbox" class="form-checkbox text-green-600 mr-2">
                                    <span class="text-sm text-gray-700">Đang ở</span>
                                    <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center border border-white">
                                        <span class="text-white text-xs font-bold">0</span>
                                    </div>
                                </div>

                                <div class="relative bg-white rounded-lg px-3 py-2 border border-gray-200">
                                    <input type="checkbox" class="form-checkbox text-green-600 mr-2">
                                    <span class="text-sm text-gray-700">Đang trống</span>
                                    <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center border border-white">
                                        <span class="text-white text-xs font-bold">0</span>
                                    </div>
                                </div>

                                <div class="relative bg-white rounded-lg px-3 py-2 border border-gray-200">
                                    <input type="checkbox" class="form-checkbox text-green-600 mr-2">
                                    <span class="text-sm text-gray-700">Đang báo kết thúc</span>
                                    <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center border border-white">
                                        <span class="text-white text-xs font-bold">0</span>
                                    </div>
                                </div>

                                <div class="relative bg-white rounded-lg px-3 py-2 border border-gray-200">
                                    <input type="checkbox" class="form-checkbox text-green-600 mr-2">
                                    <span class="text-sm text-gray-700">Sắp hết hạn hợp đồng</span>
                                    <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center border border-white">
                                        <span class="text-white text-xs font-bold">0</span>
                                    </div>
                                </div>

                                <div class="relative bg-white rounded-lg px-3 py-2 border border-gray-200">
                                    <input type="checkbox" class="form-checkbox text-green-600 mr-2">
                                    <span class="text-sm text-gray-700">Đã quá hạn hợp đồng</span>
                                    <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center border border-white">
                                        <span class="text-white text-xs font-bold">0</span>
                                    </div>
                                </div>

                                <div class="relative bg-white rounded-lg px-3 py-2 border border-gray-200">
                                    <input type="checkbox" class="form-checkbox text-green-600 mr-2">
                                    <span class="text-sm text-gray-700">Đang nợ tiền</span>
                                    <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center border border-white">
                                        <span class="text-white text-xs font-bold">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search Bar -->
                        <div class="relative">
                            <input type="text"
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
                        <table class="w-full">
                            <thead class="bg-[#F9FAFB]">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-black border border-gray-200">Tên phòng</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-black border border-gray-200">Tầng</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-black border border-gray-200">Diện tích</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-black border border-gray-200">Giá thuê</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-black border border-gray-200">Tiền cọc</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-black border border-gray-200">Số người tối đa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-black border border-gray-200">Tình trạng</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-black border border-gray-200"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-[#FFF5F2]">
                                <?php foreach ($rooms as $room): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                        <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($room['room_name']) ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200"><?= htmlspecialchars($room['floor']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($room['area']) ?> m²</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                        <div class="text-sm font-medium text-gray-900"><?= number_format($room['room_price']) ?> ₫</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200"><?= number_format($room['deposit']) ?> ₫</td>
                                    <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                        <div class="flex items-center">
                                            <i class="fas fa-user text-gray-400 mr-1"></i>
                                            <span class="text-sm text-gray-900"><?= htmlspecialchars($room['max_people']) ?> người</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                        <?php
                                        $statusClass = '';
                                        $statusText = '';
                                        switch($room['room_status']) {
                                            case 'available':
                                                $statusClass = 'bg-green-100 text-green-800';
                                                $statusText = 'Đang trống';
                                                break;
                                            case 'occupied':
                                                $statusClass = 'bg-blue-100 text-blue-800';
                                                $statusText = 'Đã thuê';
                                                break;
                                            case 'maintenance':
                                                $statusClass = 'bg-orange-100 text-orange-800';
                                                $statusText = 'Bảo trì';
                                                break;
                                            default:
                                                $statusClass = 'bg-gray-100 text-gray-800';
                                                $statusText = 'Không xác định';
                                        }
                                        ?>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $statusClass ?>">
                                            <?= $statusText ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium border border-gray-200">
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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

    <!-- Footer -->
    <?php include 'layouts/footer.php'; ?>
</body>

</html>
