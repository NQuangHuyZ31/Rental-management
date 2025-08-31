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
                                    <p class="text-gray-600 italic mt-1 text-sm">Các dịch vụ khách thuê xài</p>
                                </div>
                            </div>
                            <button class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
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
                                <p class="text-gray-600 italic mt-1 text-sm">Thống kê mỗi tháng khách thuê xài</p>
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
                            <div class="w-32 h-32 mx-auto mb-4 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
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
    </script>
</body>

</html>