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
                    <!-- Left Column: Service Management (30%) -->
                    <div class="w-1/3">
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
                            <!-- Service 1: Electricity -->
                            <div class="bg-white border border-[#DCDCDC] rounded-lg p-4 flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Tiền điện (người)</h3>
                                        <p class="text-gray-600 text-sm">1.700đ/ Người</p>
                                        <p class="text-green-600 text-sm">Đang áp dụng cho 1 phòng</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Service 2: Water -->
                            <div class="bg-white border border-[#DCDCDC] rounded-lg p-4 flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Tiền nước (người)</h3>
                                        <p class="text-gray-600 text-sm">18.000₫/ Người</p>
                                        <p class="text-green-600 text-sm">Đang áp dụng cho 1 phòng</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Service 3: Garbage -->
                            <div class="bg-white border border-[#DCDCDC] rounded-lg p-4 flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Tiền rác (người)</h3>
                                        <p class="text-gray-600 text-sm">15.000₫/ Người</p>
                                        <p class="text-green-600 text-sm">Đang áp dụng cho 1 phòng</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Service 4: WiFi -->
                            <div class="bg-white border border-[#DCDCDC] rounded-lg p-4 flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Tiền wifi (người)</h3>
                                        <p class="text-gray-600 text-sm">50.000₫/ Người</p>
                                        <p class="text-green-600 text-sm">Đang áp dụng cho 1 phòng</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Tenant Usage Statistics (70%) -->
                    <div class="w-2/3">
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
                            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-900 tracking-wider border border-gray-300" rowspan="2">Tên phòng</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300" colspan="2">Tiền điện (người)</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300" colspan="2">Tiền nước (người)</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300" colspan="2">Tiền rác (người)</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-900 tracking-wider border border-gray-300" colspan="2">Tiền wifi (người)</th>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-center border border-gray-300">0</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-center border border-gray-300">0 đ</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-center border border-gray-300">0</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-center border border-gray-300">0 đ</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-center border border-gray-300">0</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-center border border-gray-300">0 đ</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-center border border-gray-300">0</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 text-center border border-gray-300">0 đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="w-48 h-48 mx-auto mb-4">
                                <img src="<?= BASE_URL . '/Public/images/admin/empty-houses.jpg' ?>" alt="Không có dữ liệu" class="w-full h-full object-cover rounded-lg">
                            </div>
                            <p class="text-gray-500 text-lg">Không tìm thấy dữ liệu!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <?php include VIEW_PATH . '/landlord/layouts/footer.php'; ?>

    <!-- Modal thêm dịch vụ mới -->
    <div id="addServiceModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full max-h-[90vh] flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0 bg-white">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-concierge-bell text-white text-sm"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Thêm dịch vụ mới</h2>
                </div>
                <button onclick="closeAddServiceModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto min-h-0">
                <div class="p-6">
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
                                <input type="text" id="service_name" name="service_name" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
                                <label for="service_name" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tên dịch vụ <span class="text-red-500">*</span></label>
                            </div>

                            <!-- Loại dịch vụ -->
                            <div class="relative">
                                <select id="service_type" name="service_type" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
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
                                <select id="unit" name="unit" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
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
                                <input type="number" id="service_price" name="service_price" min="0" step="100" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
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
                                    <h3 class="text-base font-medium text-gray-800">Chọn phòng muốn áp dụng:</h3>
                                    <p class="text-gray-600 italic mt-1 text-sm">Danh sách phòng chọn áp dụng</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="selectAllCheckbox" class="mr-3 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <label for="selectAllCheckbox" class="text-sm font-medium text-gray-900">Chọn tất cả</label>
                            </div>
                        </div>

                        <!-- Danh sách phòng -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex items-center p-3 border border-[#DBDBDB] rounded-lg hover:bg-gray-50">
                                <input type="checkbox" id="room_101" name="rooms[]" value="101" class="mr-3">
                                <label for="room_101" class="text-sm text-gray-700">Phòng 101</label>
                            </div>
                            <div class="flex items-center p-3 border border-[#DBDBDB] rounded-lg hover:bg-gray-50">
                                <input type="checkbox" id="room_102" name="rooms[]" value="102" class="mr-3">
                                <label for="room_102" class="text-sm text-gray-700">Phòng 102</label>
                            </div>
                            <div class="flex items-center p-3 border border-[#DBDBDB] rounded-lg hover:bg-gray-50">
                                <input type="checkbox" id="room_103" name="rooms[]" value="103" class="mr-3">
                                <label for="room_103" class="text-sm text-gray-700">Phòng 103</label>
                            </div>
                            <div class="flex items-center p-3 border border-[#DBDBDB] rounded-lg hover:bg-gray-50">
                                <input type="checkbox" id="room_201" name="rooms[]" value="201" class="mr-3">
                                <label for="room_201" class="text-sm text-gray-700">Phòng 201</label>
                            </div>
                            <div class="flex items-center p-3 border border-[#DBDBDB] rounded-lg hover:bg-gray-50">
                                <input type="checkbox" id="room_202" name="rooms[]" value="202" class="mr-3">
                                <label for="room_202" class="text-sm text-gray-700">Phòng 202</label>
                            </div>
                            <div class="flex items-center p-3 border border-[#DBDBDB] rounded-lg hover:bg-gray-50">
                                <input type="checkbox" id="room_203" name="rooms[]" value="203" class="mr-3">
                                <label for="room_203" class="text-sm text-gray-700">Phòng 203</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3 p-6 border-t border-gray-200 flex-shrink-0 bg-white">
                <button onclick="closeAddServiceModal()" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    Đóng
                </button>
                <button onclick="createService()" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Tạo dịch vụ
                </button>
            </div>
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
            let selectedMonth = (now.getMonth() + 1).toString().padStart(2, '0');

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
            });

            nextYearBtn.addEventListener('click', function() {
                currentYear++;
                updateYearDisplay();
            });

            monthBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    selectedMonth = btn.dataset.month;
                    updateInput();
                    highlightSelectedMonth();
                    togglePicker();
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
        });

        // Add Service Modal functionality
        function openAddServiceModal() {
            document.getElementById('addServiceModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAddServiceModal() {
            document.getElementById('addServiceModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            // Reset form when closing modal
            resetServiceForm();
        }

        // Reset service form
        function resetServiceForm() {
            document.getElementById('service_name').value = '';
            document.getElementById('service_type').value = '';
            document.getElementById('unit').value = '';
            document.getElementById('service_price').value = '';
            
            // Uncheck all room checkboxes
            const roomCheckboxes = document.querySelectorAll('input[name="rooms[]"]');
            roomCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Uncheck select all checkbox
            document.getElementById('selectAllCheckbox').checked = false;
        }

        // Select all rooms
        function selectAllRooms() {
            const roomCheckboxes = document.querySelectorAll('input[name="rooms[]"]');
            roomCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        }

        // Deselect all rooms
        function deselectAllRooms() {
            const roomCheckboxes = document.querySelectorAll('input[name="rooms[]"]');
            roomCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }

        // Create service
        function createService() {
            // Get form data
            const formData = {
                service_name: document.getElementById('service_name').value,
                service_type: document.getElementById('service_type').value,
                unit: document.getElementById('unit').value,
                service_price: document.getElementById('service_price').value,
                rooms: Array.from(document.querySelectorAll('input[name="rooms[]"]:checked')).map(cb => cb.value)
            };

            // Validate required fields
            if (!formData.service_name || !formData.service_type || !formData.unit || !formData.service_price || formData.rooms.length === 0) {
                alert('Vui lòng điền đầy đủ thông tin bắt buộc và chọn ít nhất một phòng!');
                return;
            }

            // Send data to server (you can modify this according to your API)
            console.log('Service data:', formData);

            // TODO: Call API to create service
            // fetch('/api/services', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //     },
            //     body: JSON.stringify(formData)
            // });

            alert('Tạo dịch vụ thành công!');
            closeAddServiceModal();
        }

        // Event listeners for room selection
        document.addEventListener('DOMContentLoaded', function() {
            // Handle select all checkbox
            document.getElementById('selectAllCheckbox').addEventListener('change', function() {
                if (this.checked) {
                    selectAllRooms();
                } else {
                    deselectAllRooms();
                }
            });
            
            // Update select all checkbox when individual rooms change
            const roomCheckboxes = document.querySelectorAll('input[name="rooms[]"]');
            roomCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(roomCheckboxes).every(cb => cb.checked);
                    
                    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
                    selectAllCheckbox.checked = allChecked;
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
    </script>
</body>

</html>