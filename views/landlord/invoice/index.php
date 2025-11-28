<?php

use Core\CSRF;
use Helpers\Format;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOSTY - Quản lý hóa đơn</title>
    <?php include VIEW_PATH . '/landlord/layouts/app.php'; ?>
</head>

<body class="bg-gray-100">
    <?php include VIEW_PATH . '/landlord/layouts/header.php'; ?>
    <?php include VIEW_PATH . '/landlord/layouts/nav.php'; ?>

    <main class="min-h-screen bg-gray-100 w-full">
        <div class="bg-white min-h-screen p-6">
            <div class="max-w-full mx-auto">

                <!-- Calendar Widget (No JS, chỉ GET) -->
                <div class="bg-gray-100 rounded-lg p-4 mb-6">
                    <form method="get" action="<?php echo BASE_URL; ?>/landlord/invoice" class="flex items-center justify-between">
                        <!-- Previous Year -->
                        <button type="submit" name="year" value="<?= $selectedYear - 1 ?>" class="flex items-center space-x-2 px-2 py-1 hover:bg-gray-200 rounded transition-colors">
                            <i class="fas fa-chevron-left text-gray-600"></i>
                            <span class="text-sm font-medium text-gray-700">Năm trước</span>
                            <input type="hidden" name="month" value="<?= $selectedMonth ?>">
                            <?php if ($selectedHouseId): ?>
                                <input type="hidden" name="house_id" value="<?= $selectedHouseId ?>">
                            <?php endif; ?>
                        </button>

                        <!-- Month Buttons -->
                        <div class="flex items-center justify-between flex-1 mx-4">
                            <?php
                            $months = [
                                1 => 'T1',
                                2 => 'T2',
                                3 => 'T3',
                                4 => 'T4',
                                5 => 'T5',
                                6 => 'T6',
                                7 => 'T7',
                                8 => 'T8',
                                9 => 'T9',
                                10 => 'T10',
                                11 => 'T11',
                                12 => 'T12'
                            ];
                            foreach ($months as $monthNum => $monthName):
                                $monthUrl = BASE_URL . '/landlord/invoice?month=' . $monthNum . '&year=' . $selectedYear;
                                if ($selectedHouseId) $monthUrl .= '&house_id=' . $selectedHouseId;
                            ?>
                                <a href="<?= $monthUrl ?>"
                                    class="month-btn flex flex-col items-center px-2 py-1 hover:bg-gray-200 rounded transition-colors border-2 <?= $monthNum == $selectedMonth ? 'text-green-600 font-bold border-green-500' : 'text-gray-700 border-transparent' ?>">
                                    <span class="text-sm font-bold"><?= $monthName ?></span>
                                    <span class="text-xs text-gray-500"><?= $selectedYear ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>

                        <!-- Next Year -->
                        <button type="submit" name="year" value="<?= $selectedYear + 1 ?>" class="flex items-center space-x-2 px-2 py-1 hover:bg-gray-200 rounded transition-colors">
                            <span class="text-sm font-medium text-gray-700">Năm tới</span>
                            <i class="fas fa-chevron-right text-gray-600"></i>
                            <input type="hidden" name="month" value="<?= $selectedMonth ?>">
                            <?php if ($selectedHouseId): ?>
                                <input type="hidden" name="house_id" value="<?= $selectedHouseId ?>">
                            <?php endif; ?>
                        </button>
                    </form>
                </div>

                <!-- Header Section -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-1 h-8 bg-green-600 mr-3"></div>
                        <div>
                            <h3 id="invoice-title" class="text-base font-medium text-gray-800">
                                Tất cả hóa đơn <?= str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) ?>/<?= $selectedYear ?>
                            </h3>
                            <p class="text-gray-600 italic mt-1 text-sm">Tất cả hóa đơn thu tiền nhà xuất hiện ở đây</p>
                        </div>
                    </div>
                </div>

                <!-- Invoice Table -->
                <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-200">Tên phòng</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-200">Tiền phòng</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-200">Tiền điện</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-200">Tiền nước</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-200">Tiền mạng</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-200">Tiền xe</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-200">Tiền rác</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-200">Tổng cộng</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-200">Trạng thái</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-200 w-20"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <?php if (!empty($invoices)): ?>
                                    <?php foreach ($invoices as $invoice): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 border border-gray-200">
                                                <?= htmlspecialchars($invoice['room_name']) ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 border border-gray-200">
                                                <?= Format::formatPriceVND($invoice['rental_amount']) ?> ₫
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 border border-gray-200">
                                                <?= Format::formatPriceVND($invoice['electric_amount']) ?> ₫
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 border border-gray-200">
                                                <?= Format::formatPriceVND($invoice['water_amount']) ?> ₫
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 border border-gray-200">
                                                <?= Format::formatPriceVND($invoice['internet_amount']) ?> ₫
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 border border-gray-200">
                                                <?= Format::formatPriceVND($invoice['parking_amount']) ?> ₫
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 border border-gray-200">
                                                <?= Format::formatPriceVND($invoice['garbage_amount']) ?> ₫
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 border border-gray-200">
                                                <?= Format::formatPriceVND($invoice['total']) ?> ₫
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center border border-gray-200">
                                                <?php
                                                $statusText = '';
                                                $statusColor = '';
                                                switch ($invoice['invoice_status']) {
                                                    case 'paid':
                                                        $statusText = 'Đã thanh toán';
                                                        $statusColor = '#7DC242';
                                                        break;
                                                    case 'pending':
                                                        $statusText = 'Chờ thanh toán';
                                                        $statusColor = '#ED6004';
                                                        break;
                                                    case 'overdue':
                                                        $statusText = 'Quá hạn';
                                                        $statusColor = '#DC2626';
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
                                            <td class="px-6 py-4 whitespace-nowrap text-center border border-gray-200">
                                                <div class="flex items-center justify-center space-x-4">
                                                    <!-- View/Edit Icon -->
                                                    <button onclick="viewInvoice(<?= $invoice['id'] ?>)" class="hover:scale-110 transition-transform" title="Xem/cập nhật">
                                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </button>

                                                    <!-- Mark as Paid Icon -->
                                                    <?php if ($invoice['invoice_status'] !== 'paid'): ?>
                                                        <button onclick="markAsPaid(<?= $invoice['id'] ?>)" class="hover:scale-110 transition-transform" title="Đánh dấu đã thanh toán">
                                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </button>
                                                    <?php else: ?>
                                                        <button class="cursor-not-allowed" disabled title="Đã thanh toán">
                                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </button>
                                                    <?php endif; ?>

                                                    <!-- Delete Icon -->
                                                    <button onclick="deleteInvoice(<?= $invoice['id'] ?>)" class="hover:scale-110 transition-transform" title="Xóa hóa đơn">
                                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="px-6 py-8 text-center text-gray-500 border border-gray-200">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-receipt text-gray-400 text-3xl mb-2"></i>
                                                <p>Không có hóa đơn nào trong tháng này</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal xem hóa đơn -->
    <div id="invoiceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white flex flex-col max-h-[90vh]">
            <!-- Modal Header - Fixed -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-white rounded-t-md flex-shrink-0">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Chi tiết hóa đơn - <span id="roomName"></span></h3>
                <button onclick="closeInvoiceModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body - Scrollable -->
            <div id="modalBody" class="flex-1 overflow-y-auto p-4">
                <!-- Nội dung sẽ được load bằng JavaScript -->
            </div>

            <!-- Modal Footer - Fixed -->
            <div class="flex justify-end space-x-3 p-4 border-t border-gray-200 bg-white rounded-b-md flex-shrink-0">
                <button onclick="closeInvoiceModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                    Đóng
                </button>
                <button type="button"
                    onclick="updateInvoice()"
                    id="updateInvoiceBtn"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span id="updateBtnText">Cập nhật</span>
                    <span id="updateBtnLoading" class="hidden">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Đang cập nhật...
                    </span>
                </button>
            </div>
        </div>
    </div>

    <?php include VIEW_PATH . '/landlord/layouts/footer.php'; ?>

    <script>
        // Hàm mở modal xem hóa đơn
        function viewInvoice(invoiceId) {
            // Hiển thị loading
            document.getElementById('modalBody').innerHTML = `
                <div class="flex justify-center items-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
                    <span class="ml-2 text-gray-600">Đang tải...</span>
                </div>
            `;

            // Hiển thị modal
            document.getElementById('invoiceModal').classList.remove('hidden');

            // Gọi API lấy chi tiết hóa đơn
            fetch(`${App.appURL}landlord/invoice/view/${invoiceId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayInvoiceDetails(data.invoice, data.serviceDetails, data.csrf_token);
                    } else {
                        document.getElementById('modalBody').innerHTML = `
                            <div class="text-center py-8">
                                <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-2"></i>
                                <p class="text-red-600">${data.message}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('modalBody').innerHTML = `
                        <div class="text-center py-8">
                            <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-2"></i>
                            <p class="text-red-600">Có lỗi xảy ra khi tải dữ liệu</p>
                        </div>
                    `;
                });
        }

        // Hàm hiển thị chi tiết hóa đơn
        function displayInvoiceDetails(invoice, serviceDetails, csrfToken) {
            // Reset flag để ngăn submit tự động
            window.allowFormSubmit = false;

            const modalBody = document.getElementById('modalBody');

            // Xóa tất cả lỗi validation cũ
            clearValidationErrors();

            // Set tên phòng vào tiêu đề modal
            document.getElementById('roomName').textContent = invoice.room_name;

            // Format ngày tháng
            const formatDate = (dateString) => {
                if (!dateString) return 'N/A';
                const date = new Date(dateString);
                return date.toLocaleDateString('vi-VN');
            };

            // Format tiền tệ
            const formatMoney = (amount) => {
                if (!amount || amount === 0) return '0 ₫';
                return new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(amount);
            };

            // Lấy trạng thái
            const getStatusInfo = (status) => {
                switch (status) {
                    case 'paid':
                        return {
                            text: 'Đã thanh toán', color: '#7DC242'
                        };
                    case 'pending':
                        return {
                            text: 'Chờ thanh toán', color: '#ED6004'
                        };
                    case 'overdue':
                        return {
                            text: 'Quá hạn', color: '#DC2626'
                        };
                    default:
                        return {
                            text: 'Không xác định', color: '#6B7280'
                        };
                }
            };

            const statusInfo = getStatusInfo(invoice.invoice_status);

            // Disable linter for template literals
            /* eslint-disable */
            modalBody.innerHTML = `
                <form id="updateInvoiceForm" action="<?= BASE_URL ?>/landlord/invoice/update" method="POST" class="space-y-4">
                    <input type="hidden" id="invoiceId" name="invoice_id" value="${invoice.id}">
                    <input type="hidden" id="csrfToken" name="csrf_token" value="${csrfToken}">
                    
                    <!-- Thông tin hóa đơn -->
                    <div>
                        <div class="flex mb-4 px-4">
                            <div class="w-1 bg-green-600 mr-3"></div>
                            <div>
                                <h5 class="text-base font-medium text-gray-800">Thông tin hóa đơn:</h5>
                                <p class="text-gray-600 italic mt-1 text-sm">Thông tin cơ bản của hóa đơn</p>
                            </div>
                        </div>
                        <div class="space-y-4 px-4">
                    <!-- Tên hóa đơn -->
                    <div class="relative">
                        <input type="text" 
                               name="invoice_name"
                               id="invoiceName"
                               value="${invoice.invoice_name || ''}" 
                               class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                        <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tên hóa đơn <span class="text-red-500">*</span></label>
                                </div>
                    
                    <!-- Tháng lập phiếu -->
                                <div class="relative">
                        <input type="text" 
                               name="invoice_month"
                               id="modalMonthYearInput" 
                               value="${invoice.invoice_month || ''}" 
                               readonly 
                               class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:outline-none cursor-pointer bg-white"
                               placeholder=" ">
                        <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tháng lập phiếu <span class="text-red-500">*</span></label>
                        <svg class="w-5 h-5 text-gray-400 absolute right-3 top-2.5 cursor-pointer" id="modalCalendarIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>

                        <!-- Month/Year Picker Overlay -->
                        <div id="modalMonthYearPicker" class="hidden absolute top-full left-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-lg z-50 w-64">
                            <!-- Year Navigation -->
                            <div class="flex items-center justify-between p-3 border-b border-gray-200">
                                <button id="modalPrevYear" class="text-gray-600 hover:text-gray-800 p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <span id="modalCurrentYear" class="font-medium text-gray-900">2025</span>
                                <button id="modalNextYear" class="text-gray-600 hover:text-gray-800 p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                            </div>

                            <!-- Months Grid -->
                            <div class="p-3">
                                <div class="grid grid-cols-4 gap-2">
                                    <button class="modal-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="01">Th1</button>
                                    <button class="modal-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="02">Th2</button>
                                    <button class="modal-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="03">Th3</button>
                                    <button class="modal-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="04">Th4</button>
                                    <button class="modal-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="05">Th5</button>
                                    <button class="modal-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="06">Th6</button>
                                    <button class="modal-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="07">Th7</button>
                                    <button class="modal-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="08">Th8</button>
                                    <button class="modal-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="09">Th9</button>
                                    <button class="modal-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="10">Th10</button>
                                    <button class="modal-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="11">Th11</button>
                                    <button class="modal-month-btn p-2 text-sm rounded hover:bg-gray-100" data-month="12">Th12</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ngày lập và hạn đóng tiền -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="relative">
                            <input type="date" 
                                   name="invoice_day"
                                   id="invoiceDay"
                                   value="${invoice.invoice_day ? new Date(invoice.invoice_day).toISOString().split('T')[0] : ''}" 
                                   class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                            <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Ngày lập hóa đơn <span class="text-red-500">*</span></label>
                        </div>
                                <div class="relative">
                            <input type="date" 
                                   name="due_date"
                                   id="dueDate"
                                   value="${invoice.due_date ? new Date(invoice.due_date).toISOString().split('T')[0] : ''}" 
                                   class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                            <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Hạn đóng tiền <span class="text-red-500">*</span></label>
                        </div>
                    </div>
                    
                    <!-- Tiền phòng trọ -->
                    <div class="relative">
                        <!-- Display input with formatted value -->
                        <input type="text" 
                               id="roomPrice"
                               value="${formatMoney(invoice.rental_amount || 0)}" 
                               readonly
                               class="peer w-full px-4 py-3 border border-blue-300 rounded-lg bg-white outline-none cursor-default">
                        <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tiền phòng trọ</label>
                    </div>
                        </div>
                    </div>
                    
                    <!-- Chi tiết dịch vụ -->
                    ${serviceDetails && serviceDetails.length > 0 ? `
                    <div class="p-4">
                        <div class="flex mb-4">
                            <div class="w-1 bg-green-600 mr-3"></div>
                            <div>
                                <h5 class="text-base font-medium text-gray-800">Chi tiết dịch vụ:</h5>
                                <p class="text-gray-600 italic mt-1 text-sm">Danh sách các dịch vụ sử dụng trong tháng</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            ${serviceDetails.map(service => `
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <div class="flex items-start justify-between">
                                        <!-- Bên trái: Checkbox, tên dịch vụ và đơn giá -->
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <div class="w-4 h-4 bg-blue-500 rounded flex items-center justify-center mr-2">
                                                    <i class="fas fa-check text-white text-xs"></i>
                                                </div>
                                                <span class="font-bold text-gray-800">${service.service_name} (${service.service_type})</span>
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                Giá: <span class="font-medium">${formatMoney(service.unit_price)} / ${service.unit_vi}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Bên phải: Số cũ, số mới hoặc số lượng -->
                                        <div class="ml-4">
                                            ${service.old_value && service.new_value ? `
                                                <div class="flex items-center space-x-2">
                                                    <div class="flex items-center">
                                                        <span class="text-sm text-gray-600 mr-1">Số cũ:</span>
                                                        <input type="number" 
                                                               name="services[${service.id}][old_value]"
                                                               value="${service.old_value}" 
                                                               oninput="validateUpdateMeterInput(this)"
                                                               class="w-16 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-sm">
                                                    </div>
                                                    <div class="flex items-center">
                                                        <span class="text-sm text-gray-600 mr-1">Số mới:</span>
                                                        <input type="number" 
                                                               name="services[${service.id}][new_value]"
                                                               value="${service.new_value}" 
                                                               oninput="validateUpdateMeterInput(this)"
                                                               class="w-16 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-sm">
                                                    </div>
                                                </div>
                                            ` : `
                                                <div class="flex items-center">
                                                    <span class="text-sm text-gray-600 mr-1">Số lượng:</span>
                                                    <input type="number" 
                                                           name="services[${service.id}][usage_amount]"
                                                           value="${service.usage_amount}" 
                                                           min="1"
                                                           step="1"
                                                           oninput="validateUpdateQuantityInput(this)"
                                                           class="w-16 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-sm">
                                                </div>
                                            `}
                                        </div>
                                </div>
                                    
                                    <!-- Thành tiền -->
                                    <div class="mt-3 text-right">
                                        <div class="text-sm text-gray-600">
                                            Tổng: <span class="font-medium">${formatMoney(service.total_amount)}</span>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    ` : ''}
                    
                    <!-- Tổng tiền -->
                    <div class="mt-6 px-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-800">Tổng tiền:</span>
                            <span class="text-gray-800">${formatMoney(invoice.total || 0)}</span>
                        </div>
                    </div>
                    
                    <!-- Ghi chú -->
                    <div class="mt-6 px-4">
                                <div class="relative">
                            <input type="text" 
                                   name="note"
                                   id="invoiceNote" 
                                   value="${invoice.note || ''}" 
                                   class="peer w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder=" ">
                            <label class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Ghi chú</label>
                                        </div>
                                    </div>
                                    
                    ${invoice.invoice_status === 'paid' ? `
                    <!-- Thông báo hóa đơn đã thanh toán -->
                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-yellow-800 font-medium">Hóa đơn đã thanh toán - Không thể chỉnh sửa</span>
                        </div>
                    </div>
                    ` : ''}
                                </div>
                    </form>
            `;
            /* eslint-enable */

            // Kiểm tra trạng thái hóa đơn để ẩn/hiện nút cập nhật
            const updateBtn = document.getElementById('updateInvoiceBtn');
            if (updateBtn) {
                if (invoice.invoice_status === 'paid') {
                    updateBtn.style.display = 'none';
                } else {
                    updateBtn.style.display = 'inline-flex';
                }
            }

            // Disable tất cả input khi hóa đơn đã thanh toán
            if (invoice.invoice_status === 'paid') {
                const form = document.getElementById('updateInvoiceForm');
                if (form) {
                    // Disable tất cả input, textarea, select trong form (trừ hidden và readonly)
                    const inputs = form.querySelectorAll('input:not([type="hidden"]):not([readonly]), textarea:not([readonly]), select:not([readonly])');
                    inputs.forEach(input => {
                        input.disabled = true;
                        input.classList.add('bg-gray-100', 'cursor-not-allowed');
                        input.classList.remove('hover:border-blue-400', 'focus:border-blue-500', 'focus:ring-2', 'focus:ring-blue-500');
                    });

                    // Disable month picker riêng
                    const monthInput = document.getElementById('modalMonthYearInput');
                    if (monthInput) {
                        monthInput.disabled = true;
                        monthInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                        monthInput.classList.remove('cursor-pointer', 'hover:border-blue-400', 'focus:border-blue-500', 'focus:ring-2', 'focus:ring-blue-500');

                        // Disable month picker icon
                        const monthIcon = document.getElementById('modalCalendarIcon');
                        if (monthIcon) {
                            monthIcon.style.pointerEvents = 'none';
                            monthIcon.style.opacity = '0.5';
                            monthIcon.classList.remove('cursor-pointer');
                            monthIcon.classList.add('cursor-not-allowed');
                        }
                    }
                }
            }

            // Khởi tạo Month/Year Picker cho modal
            setTimeout(() => {
                initModalMonthYearPicker();
                // Thêm event listeners để xóa lỗi khi user nhập liệu
                addInputEventListeners();

                // Ngăn form submit tự động khi có thay đổi
                const form = document.getElementById('updateInvoiceForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        // Chỉ cho phép submit khi user click nút cập nhật
                        if (!window.allowFormSubmit) {
                            e.preventDefault();
                            return false;
                        }
                    });
                }
            }, 100);
        }

        // Hàm đóng modal
        function closeInvoiceModal() {
            document.getElementById('invoiceModal').classList.add('hidden');
        }

        // Hàm hiển thị lỗi validation dưới các input
        function displayValidationErrors(errors) {
            // Xóa tất cả lỗi cũ
            clearValidationErrors();

            // Nếu errors là object (key-value pairs)
            if (typeof errors === 'object' && !Array.isArray(errors)) {
                Object.keys(errors).forEach(fieldName => {
                    showFieldError(fieldName, errors[fieldName]);
                });
            }
            // Nếu errors là string, parse nó
            else if (typeof errors === 'string') {
                const errorArray = errors.split('. ').filter(error => error.trim() !== '');
                errorArray.forEach(error => {
                    const [field, message] = error.split(': ');
                    if (field && message) {
                        showFieldError(field.trim(), message.trim());
                    }
                });
            }
            // Nếu errors là array, xử lý trực tiếp
            else if (Array.isArray(errors)) {
                errors.forEach(error => {
                    if (typeof error === 'string') {
                        const [field, message] = error.split(': ');
                        if (field && message) {
                            showFieldError(field.trim(), message.trim());
                        }
                    }
                });
            }
        }

        // Hàm hiển thị lỗi cho một field cụ thể
        function showFieldError(fieldName, message) {
            let inputElement;
            let errorContainer;

            // Tìm input element dựa trên field name
            switch (fieldName) {
                case 'invoice_name':
                    inputElement = document.getElementById('invoiceName');
                    break;
                case 'invoice_month':
                    inputElement = document.getElementById('modalMonthYearInput');
                    break;
                case 'invoice_day':
                    inputElement = document.getElementById('invoiceDay');
                    break;
                case 'due_date':
                    inputElement = document.getElementById('dueDate');
                    break;
                case 'note':
                    inputElement = document.getElementById('invoiceNote');
                    break;
                default:
                    return;
            }

            if (!inputElement) return;

            // Tìm container của input (div cha)
            const inputContainer = inputElement.closest('.relative');
            if (!inputContainer) return;

            // Tạo error message element
            errorContainer = document.createElement('div');
            errorContainer.className = 'text-red-500 text-sm mt-1';
            errorContainer.textContent = message;
            errorContainer.id = `error-${fieldName}`;

            // Thêm error message vào sau input container
            inputContainer.parentNode.insertBefore(errorContainer, inputContainer.nextSibling);

            // Thêm border đỏ cho input
            inputElement.classList.add('border-red-500');
            inputElement.classList.remove('border-blue-300', 'border-gray-300');
        }

        // Hàm xóa tất cả lỗi validation
        function clearValidationErrors() {
            // Xóa tất cả error messages
            const errorElements = document.querySelectorAll('[id^="error-"]');
            errorElements.forEach(element => element.remove());

            // Reset border của tất cả inputs
            const inputs = ['invoiceName', 'modalMonthYearInput', 'invoiceDay', 'dueDate', 'invoiceNote'];
            inputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.classList.remove('border-red-500');
                    input.classList.add('border-blue-300');
                }
            });
        }

        // Hàm thêm event listeners để xóa lỗi khi user nhập liệu
        function addInputEventListeners() {
            const inputs = [{
                    id: 'invoiceName',
                    field: 'invoice_name'
                },
                {
                    id: 'modalMonthYearInput',
                    field: 'invoice_month'
                },
                {
                    id: 'invoiceDay',
                    field: 'invoice_day'
                },
                {
                    id: 'dueDate',
                    field: 'due_date'
                },
                {
                    id: 'invoiceNote',
                    field: 'note'
                }
            ];

            inputs.forEach(({
                id,
                field
            }) => {
                const input = document.getElementById(id);
                if (input) {
                    // Xóa lỗi khi user bắt đầu nhập
                    input.addEventListener('input', () => {
                        clearFieldError(field);
                    });

                    // Xóa lỗi khi user focus vào input
                    input.addEventListener('focus', () => {
                        clearFieldError(field);
                    });
                }
            });
        }

        // Hàm xóa lỗi cho một field cụ thể
        function clearFieldError(fieldName) {
            const errorElement = document.getElementById(`error-${fieldName}`);
            if (errorElement) {
                errorElement.remove();
            }

            // Reset border cho input tương ứng
            let inputElement;
            switch (fieldName) {
                case 'invoice_name':
                    inputElement = document.getElementById('invoiceName');
                    break;
                case 'invoice_month':
                    inputElement = document.getElementById('modalMonthYearInput');
                    break;
                case 'invoice_day':
                    inputElement = document.getElementById('invoiceDay');
                    break;
                case 'due_date':
                    inputElement = document.getElementById('dueDate');
                    break;
                case 'note':
                    inputElement = document.getElementById('invoiceNote');
                    break;
            }

            if (inputElement) {
                inputElement.classList.remove('border-red-500');
                inputElement.classList.add('border-blue-300');
            }
        }

        // Hàm cập nhật hóa đơn
        function updateInvoice() {
            const form = document.getElementById('updateInvoiceForm');
            if (!form) {
                Swal.fire({
                    title: 'Lỗi',
                    text: 'Không tìm thấy form cập nhật',
                    icon: 'error',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Validate form trước khi submit
            if (!validateUpdateInvoiceForm()) {
                return;
            }

            // Capture form data trước khi đóng modal
            const formData = new FormData(form);

            // Đóng modal trước
            closeInvoiceModal();

            // Set flag để cho phép submit và submit form ngay lập tức
            window.allowFormSubmit = true;
            form.submit();
        }

        // Modal Month/Year Picker functionality
        function initModalMonthYearPicker() {
            const input = document.getElementById('modalMonthYearInput');
            const icon = document.getElementById('modalCalendarIcon');
            const picker = document.getElementById('modalMonthYearPicker');
            const currentYearSpan = document.getElementById('modalCurrentYear');
            const prevYearBtn = document.getElementById('modalPrevYear');
            const nextYearBtn = document.getElementById('modalNextYear');
            const monthBtns = document.querySelectorAll('.modal-month-btn');

            if (!input || !picker) return;

            // Không khởi tạo picker nếu input bị disabled (hóa đơn đã thanh toán)
            if (input.disabled) {
                return;
            }

            // Get current date
            const now = new Date();
            let currentYear = now.getFullYear();
            let selectedMonth = '01';

            // Parse existing value if available
            if (input.value && input.value.trim() !== '') {
                const parts = input.value.split('-');
                if (parts.length === 2) {
                    selectedMonth = parts[0];
                    currentYear = parseInt(parts[1]);
                }
            } else {
                // Nếu không có giá trị, sử dụng tháng hiện tại
                const now = new Date();
                selectedMonth = (now.getMonth() + 1).toString().padStart(2, '0');
                currentYear = now.getFullYear();
            }

            // Toggle picker visibility
            function togglePicker() {
                picker.classList.toggle('hidden');
            }

            // Update input value
            function updateInput() {
                const newValue = `${selectedMonth}-${currentYear}`;
                input.value = newValue;

                // Clear any inline styles from label to let CSS handle it naturally
                const label = input.nextElementSibling;
                if (label && label.tagName === 'LABEL') {
                    // Clear all inline styles
                    label.style.transform = '';
                    label.style.top = '';
                    label.style.fontSize = '';
                    label.style.color = '';
                    label.style.fontWeight = '';
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
                btn.addEventListener('click', () => {
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

            // Force update input value after a short delay
            setTimeout(() => {
                updateInput();
            }, 50);
        }

        // Đóng modal khi click outside
        document.getElementById('invoiceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeInvoiceModal();
            }
        });

        // Đóng modal khi nhấn ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeInvoiceModal();
            }
        });

        // Hàm đánh dấu hóa đơn đã thanh toán với SweetAlert xác nhận
        function markAsPaid(invoiceId) {
            Swal.fire({
                title: 'Xác nhận đánh dấu đã thanh toán',
                html: 'Bạn có chắc chắn muốn đánh dấu hóa đơn này là đã thanh toán?<br>Hành động này sẽ cập nhật trạng thái hóa đơn thành "Đã thanh toán".',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Đánh dấu đã thanh toán',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tạo form để submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `${App.appURL}landlord/invoice/mark-as-paid`;

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    const invoiceInput = document.createElement('input');
                    invoiceInput.type = 'hidden';
                    invoiceInput.name = 'invoice_id';
                    invoiceInput.value = invoiceId;

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = 'csrf_token';
                    csrfInput.value = csrfToken;

                    form.appendChild(invoiceInput);
                    form.appendChild(csrfInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Hàm xóa hóa đơn với SweetAlert xác nhận
        function deleteInvoice(invoiceId) {
            Swal.fire({
                title: 'Xác nhận xóa hóa đơn',
                html: 'Bạn có chắc chắn muốn xóa hóa đơn này?<br>Hành động này không thể hoàn tác!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tạo form để submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `${App.appURL}landlord/invoice/delete`;

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    const invoiceInput = document.createElement('input');
                    invoiceInput.type = 'hidden';
                    invoiceInput.name = 'invoice_id';
                    invoiceInput.value = invoiceId;

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = 'csrf_token';
                    csrfInput.value = csrfToken;

                    form.appendChild(invoiceInput);
                    form.appendChild(csrfInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Validation functions for update invoice modal
        function validateUpdateMeterInput(input) {
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
            const match = input.name.match(/services\[(\d+)\]\[(\w+)\]/);
            if (match) {
                const serviceId = match[1];
                clearUpdateServiceError(serviceId);
                
                // Remove red border from this input
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-300');
                
                // Validate old_value vs new_value
                if (match[2] === 'old_value' || match[2] === 'new_value') {
                    const oldInput = document.querySelector('input[name="services[' + serviceId + '][old_value]"');
                    const newInput = document.querySelector('input[name="services[' + serviceId + '][new_value]"');
                    
                    if (oldInput && newInput && oldInput.value && newInput.value) {
                        const oldValue = parseInt(oldInput.value);
                        const newValue = parseInt(newInput.value);
                        
                        if (newValue <= oldValue) {
                            // Show error
                            showUpdateServiceError(serviceId, 'Số mới phải lớn hơn số cũ');
                            newInput.classList.remove('border-gray-300');
                            newInput.classList.add('border-red-500');
                            oldInput.classList.remove('border-gray-300');
                            oldInput.classList.add('border-red-500');
                        } else {
                            // Clear error
                            oldInput.classList.remove('border-red-500');
                            oldInput.classList.add('border-gray-300');
                            newInput.classList.remove('border-red-500');
                            newInput.classList.add('border-gray-300');
                        }
                    }
                }
            }
        }

        function showUpdateServiceError(serviceId, message) {
            const form = document.getElementById('updateInvoiceForm');
            if (!form) return;
            
            // Find the service container
            const oldInput = form.querySelector('input[name="services[' + serviceId + '][old_value]"');
            if (!oldInput) return;
            
            const serviceContainer = oldInput.closest('.bg-white');
            if (!serviceContainer) return;
            
            // Remove existing error for this service
            const existingError = serviceContainer.querySelector('.service-error');
            if (existingError) {
                existingError.remove();
            }
            
            // Create error message element
            const errorElement = document.createElement('div');
            errorElement.className = 'service-error text-red-500 text-xs mt-2';
            errorElement.textContent = message;
            
            // Find .ml-4 container and add error below inputs
            const mlContainer = serviceContainer.querySelector('.ml-4');
            if (mlContainer) {
                mlContainer.appendChild(errorElement);
            } else {
                serviceContainer.appendChild(errorElement);
            }
        }

        function clearUpdateServiceError(serviceId) {
            const form = document.getElementById('updateInvoiceForm');
            if (!form) return;
            
            const oldInput = form.querySelector('input[name="services[' + serviceId + '][old_value]"');
            if (oldInput) {
                const serviceContainer = oldInput.closest('.bg-white');
                if (serviceContainer) {
                    const existingError = serviceContainer.querySelector('.service-error');
                    if (existingError) {
                        existingError.remove();
                    }
                }
            }
        }

        function validateUpdateQuantityInput(input) {
            let value = parseFloat(input.value);
            
            // Convert to integer (round down)
            value = Math.floor(value);
            
            // Prevent negative numbers and ensure minimum value of 1
            if (value < 1) {
                input.value = 1;
            } else {
                input.value = value;
            }
        }

        function validateUpdateInvoiceForm() {
            const form = document.getElementById('updateInvoiceForm');
            if (!form) return false;
            
            let isValid = true;
            
            // Clear all previous errors
            const allErrors = form.querySelectorAll('.service-error');
            allErrors.forEach(err => err.remove());
            const allInputs = form.querySelectorAll('input');
            allInputs.forEach(inp => {
                inp.classList.remove('border-red-500');
                if (inp.classList.contains('border-gray-300')) {
                    // Keep border-gray-300 if it has it
                } else {
                    inp.classList.add('border-gray-300');
                }
            });
            
            // Validate old_value vs new_value for all meter services
            const oldInputs = form.querySelectorAll('input[name*="[old_value]"]');
            oldInputs.forEach(oldInput => {
                const match = oldInput.name.match(/services\[(\d+)\]/);
                if (match) {
                    const serviceId = match[1];
                    const newInput = form.querySelector('input[name="services[' + serviceId + '][new_value]"');
                    
                    if (oldInput.value && newInput && newInput.value) {
                        const oldValue = parseInt(oldInput.value);
                        const newValue = parseInt(newInput.value);
                        
                        if (newValue <= oldValue) {
                            showUpdateServiceError(serviceId, 'Số mới phải lớn hơn số cũ');
                            oldInput.classList.remove('border-gray-300');
                            oldInput.classList.add('border-red-500');
                            newInput.classList.remove('border-gray-300');
                            newInput.classList.add('border-red-500');
                            isValid = false;
                        }
                    } else if (!oldInput.value || !newInput || !newInput.value) {
                        // Check if inputs are empty
                        if (!oldInput.value) {
                            oldInput.classList.remove('border-gray-300');
                            oldInput.classList.add('border-red-500');
                        }
                        if (newInput && !newInput.value) {
                            newInput.classList.remove('border-gray-300');
                            newInput.classList.add('border-red-500');
                        }
                        if (!oldInput.value || (newInput && !newInput.value)) {
                            showUpdateServiceError(serviceId, 'Vui lòng nhập đầy đủ số cũ và số mới');
                            isValid = false;
                        }
                    }
                }
            });
            
            return isValid;
        }
    </script>
</body>

</html>