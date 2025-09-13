<!-- 
    Author: Nguyen Xuan Duong
    Date: 2025-09-12
    Purpose: Build Invoice Index
-->

<?php
use Core\CSRF;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOSTY - Quản lý hóa đơn</title>
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
                <!-- Calendar Widget -->
                <div class="bg-gray-100 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <!-- Previous Year Button -->
                        <button id="prevYearBtn" class="flex items-center space-x-2 px-2 py-1 hover:bg-gray-200 rounded transition-colors">
                            <i class="fas fa-chevron-left text-gray-600"></i>
                            <span class="text-sm font-medium text-gray-700">Năm trước</span>
                        </button>
                        
                        <!-- Month Selection -->
                        <div class="flex items-center justify-between flex-1 mx-4">
                            <?php
                            $months = [
                                1 => 'T1', 2 => 'T2', 3 => 'T3', 4 => 'T4',
                                5 => 'T5', 6 => 'T6', 7 => 'T7', 8 => 'T8',
                                9 => 'T9', 10 => 'T10', 11 => 'T11', 12 => 'T12'
                            ];
                            foreach ($months as $monthNum => $monthName):
                            ?>
                            <button class="month-btn flex flex-col items-center px-2 py-1 hover:bg-gray-200 rounded transition-colors border-2 <?= $monthNum == $selectedMonth ? 'text-green-600 font-bold border-green-500' : 'text-gray-700 border-transparent' ?>" 
                                    data-month="<?= $monthNum ?>">
                                <span class="text-sm font-bold"><?= $monthName ?></span>
                                <span class="text-xs text-gray-500"><?= $selectedYear ?></span>
                            </button>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Next Year Button -->
                        <button id="nextYearBtn" class="flex items-center space-x-2 px-2 py-1 hover:bg-gray-200 rounded transition-colors">
                            <span class="text-sm font-medium text-gray-700">Năm tới</span>
                            <i class="fas fa-chevron-right text-gray-600"></i>
                        </button>
                    </div>
                </div>

                <!-- Header Section -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-1 h-8 bg-green-600 mr-3"></div>
                        <div>
                            <h3 id="invoice-title" class="text-base font-medium text-gray-800">Tất cả hóa đơn <?= str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) ?>/<?= $selectedYear ?></h3>
                            <p class="text-gray-600 italic mt-1 text-sm">Tất cả hóa đơn thu tiền nhà xuất hiện ở đây</p>
                        </div>
                    </div>
                    <button id="addInvoiceBtn" class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </button>
                </div>

                <!-- Invoice Table -->
                <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border border-gray-200">Tên phòng</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border border-gray-200">Tiền phòng</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border border-gray-200">Tiền điện</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border border-gray-200">Tiền nước</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border border-gray-200">Tiền rác</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border border-gray-200">Trạng thái</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border border-gray-200">Tổng cộng</th>
                                </tr>
                            </thead>
                            <tbody id="invoiceTableBody" class="bg-white">
                                <?php if (!empty($invoices)): ?>
                                    <?php foreach ($invoices as $invoice): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border border-gray-200">
                                            <?= htmlspecialchars($invoice['room_name']) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200">
                                            <?= number_format($invoice['rental_amount']) ?> ₫
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200">
                                            <?= number_format($invoice['electric_amount']) ?> ₫
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200">
                                            <?= number_format($invoice['water_amount']) ?> ₫
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200">
                                            <?= number_format($invoice['service_amount']) ?> ₫
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                            <?php
                                            $statusText = '';
                                            $statusColor = '';
                                            switch($invoice['invoice_status']) {
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border border-gray-200">
                                            <?= number_format($invoice['total']) ?> ₫
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-gray-500 border border-gray-200">
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

    <!-- Footer -->
    <?php include VIEW_PATH . '/landlord/layouts/footer.php'; ?>

    <!-- JavaScript for Calendar and Invoice Filtering -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentYear = <?= $selectedYear ?>;
            let currentMonth = <?= $selectedMonth ?>;
            
            // Update month/year display
            function updateMonthYearDisplay() {
                // Update year in all month buttons
                document.querySelectorAll('.month-btn span:last-child').forEach(span => {
                    span.textContent = currentYear;
                });
            }
            
            // Update title with current month and year
            function updateTitle() {
                const titleElement = document.getElementById('invoice-title');
                if (titleElement) {
                    const monthStr = currentMonth.toString().padStart(2, '0');
                    titleElement.textContent = `Tất cả hóa đơn ${monthStr}/${currentYear}`;
                }
            }
            
            // Load invoices for selected month/year
            function loadInvoices(month, year) {
                const data = {
                    month: month,
                    year: year,
                    house_id: <?= $selectedHouseId ?? 'null' ?>,
                    csrf_token: '<?= CSRF::generateToken() ?>'
                };
                
                // Debug: Log the data being sent
                console.log('Sending data:', data);
                
                fetch('/Rental-management/landlord/invoice/getInvoicesByMonth', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateInvoiceTable(data.invoices);
                    } else {
                        console.error('Error loading invoices:', data.message);
                        showError('Không thể tải dữ liệu hóa đơn');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Có lỗi xảy ra khi tải dữ liệu');
                });
            }
            
            // Update invoice table
            function updateInvoiceTable(invoices) {
                const tbody = document.getElementById('invoiceTableBody');
                
                if (invoices.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 border border-gray-200">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-receipt text-gray-400 text-3xl mb-2"></i>
                                    <p>Không có hóa đơn nào trong tháng này</p>
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }
                
                let html = '';
                invoices.forEach(invoice => {
                    const statusColor = getStatusColor(invoice.invoice_status);
                    const statusText = getStatusText(invoice.invoice_status);
                    
                    html += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border border-gray-200">
                                ${invoice.room_name}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200">
                                ${formatNumber(invoice.rental_amount)} ₫
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200">
                                ${formatNumber(invoice.electric_amount)} ₫
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200">
                                ${formatNumber(invoice.water_amount)} ₫
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-200">
                                ${formatNumber(invoice.service_amount)} ₫
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap border border-gray-200">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white" style="background-color: ${statusColor};">
                                    ${statusText}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border border-gray-200">
                                ${formatNumber(invoice.total)} ₫
                            </td>
                        </tr>
                    `;
                });
                
                tbody.innerHTML = html;
            }
            
            // Helper functions
            function getStatusColor(status) {
                switch(status) {
                    case 'paid': return '#7DC242';
                    case 'pending': return '#ED6004';
                    case 'overdue': return '#DC2626';
                    default: return '#6B7280';
                }
            }
            
            function getStatusText(status) {
                switch(status) {
                    case 'paid': return 'Đã thanh toán';
                    case 'pending': return 'Chờ thanh toán';
                    case 'overdue': return 'Quá hạn';
                    default: return 'Không xác định';
                }
            }
            
            function formatNumber(num) {
                return new Intl.NumberFormat('vi-VN').format(num);
            }
            
            function showError(message) {
                // You can implement a toast notification here
                console.error(message);
            }
            
            // Event listeners
            document.getElementById('prevYearBtn').addEventListener('click', function() {
                currentYear--;
                updateMonthYearDisplay();
                updateTitle();
                loadInvoices(currentMonth, currentYear);
            });
            
            document.getElementById('nextYearBtn').addEventListener('click', function() {
                currentYear++;
                updateMonthYearDisplay();
                updateTitle();
                loadInvoices(currentMonth, currentYear);
            });
            
            // Month button clicks
            document.querySelectorAll('.month-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    document.querySelectorAll('.month-btn').forEach(b => {
                        b.classList.remove('text-green-600', 'font-bold', 'border-green-500');
                        b.classList.add('text-gray-700', 'border-transparent');
                    });
                    
                    // Add active class to clicked button
                    this.classList.remove('text-gray-700', 'border-transparent');
                    this.classList.add('text-green-600', 'font-bold', 'border-green-500');
                    
                    currentMonth = parseInt(this.dataset.month);
                    updateMonthYearDisplay();
                    updateTitle();
                    loadInvoices(currentMonth, currentYear);
                });
            });
        });
    </script>

    <!-- Add Invoice Modal -->
    <div id="addInvoiceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-6xl shadow-lg rounded-md bg-white">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Thêm hóa đơn mới</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="flex h-96 mt-4">
                <!-- Left Panel - Room List -->
                <div class="w-1/2 pr-4 border-r border-gray-200">
                    <h4 class="text-md font-medium text-gray-800 mb-4">Danh sách phòng đang cho thuê</h4>
                    <div id="roomList" class="space-y-2 max-h-80 overflow-y-auto">
                        <!-- Room items will be loaded here -->
                    </div>
                </div>

                <!-- Right Panel - Service List -->
                <div class="w-1/2 pl-4">
                    <h4 class="text-md font-medium text-gray-800 mb-4">Dịch vụ áp dụng</h4>
                    <div id="serviceList" class="space-y-3 max-h-80 overflow-y-auto">
                        <div class="text-center text-gray-500 py-8">
                            <i class="fas fa-home text-4xl mb-2"></i>
                            <p>Chọn phòng để xem dịch vụ</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 mt-4">
                <button id="cancelBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                    Hủy
                </button>
                <button id="createInvoiceBtn" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors disabled:bg-gray-300 disabled:cursor-not-allowed" disabled>
                    Tạo hóa đơn
                </button>
            </div>
        </div>
    </div>

    <script>
        // Modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('addInvoiceModal');
            const addBtn = document.getElementById('addInvoiceBtn');
            const closeBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const roomList = document.getElementById('roomList');
            const serviceList = document.getElementById('serviceList');
            const createInvoiceBtn = document.getElementById('createInvoiceBtn');
            
            let selectedRoomId = null;
            let selectedServices = {};

            // Open modal
            addBtn.addEventListener('click', function() {
                modal.classList.remove('hidden');
                loadRentedRooms();
            });

            // Close modal
            function closeModal() {
                modal.classList.add('hidden');
                selectedRoomId = null;
                selectedServices = {};
                serviceList.innerHTML = `
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-home text-4xl mb-2"></i>
                        <p>Chọn phòng để xem dịch vụ</p>
                    </div>
                `;
                createInvoiceBtn.disabled = true;
            }

            closeBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            // Load rented rooms
            function loadRentedRooms() {
                fetch(`/Rental-management/landlord/invoice/getRentedRooms?house_id=<?= $selectedHouseId ?? '' ?>`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displayRooms(data.rooms);
                        } else {
                            console.error('Error loading rooms:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            // Display rooms
            function displayRooms(rooms) {
                roomList.innerHTML = '';
                if (rooms.length === 0) {
                    roomList.innerHTML = '<p class="text-gray-500 text-center py-4">Không có phòng nào đang cho thuê</p>';
                    return;
                }

                rooms.forEach(room => {
                    const roomItem = document.createElement('div');
                    roomItem.className = 'p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors';
                    roomItem.dataset.roomId = room.id;
                    roomItem.innerHTML = `
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-home text-green-600"></i>
                                </div>
                                <div>
                                    <h5 class="font-medium text-gray-900">${room.room_name}</h5>
                                    <p class="text-sm text-gray-500">${room.tenant_name || 'Chưa có người thuê'}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-gray-900">${new Intl.NumberFormat('vi-VN').format(room.room_price)} ₫</p>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Đang ở
                                </span>
                            </div>
                        </div>
                    `;
                    
                    roomItem.addEventListener('click', function() {
                        // Remove active class from all rooms
                        document.querySelectorAll('[data-room-id]').forEach(item => {
                            item.classList.remove('border-green-500', 'bg-green-50');
                            item.classList.add('border-gray-200');
                        });
                        
                        // Add active class to selected room
                        this.classList.remove('border-gray-200');
                        this.classList.add('border-green-500', 'bg-green-50');
                        
                        selectedRoomId = room.id;
                        loadRoomServices(room.id);
                        createInvoiceBtn.disabled = false;
                    });
                    
                    roomList.appendChild(roomItem);
                });
            }

            // Load room services
            function loadRoomServices(roomId) {
                fetch(`/Rental-management/landlord/invoice/getRoomServices?room_id=${roomId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displayServices(data.services);
                        } else {
                            console.error('Error loading services:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            // Display services
            function displayServices(services) {
                serviceList.innerHTML = '';
                if (services.length === 0) {
                    serviceList.innerHTML = '<p class="text-gray-500 text-center py-4">Phòng này chưa có dịch vụ nào</p>';
                    return;
                }

                services.forEach(service => {
                    const serviceItem = document.createElement('div');
                    serviceItem.className = 'p-4 border border-blue-200 rounded-lg bg-blue-50';
                    serviceItem.innerHTML = `
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" class="mt-1 h-4 w-4 text-blue-600 rounded border-gray-300" 
                                   data-service-id="${service.id}" checked>
                            <div class="flex-1">
                                <h6 class="font-medium text-gray-900">${service.service_name}</h6>
                                <p class="text-sm text-gray-600">Giá: ${new Intl.NumberFormat('vi-VN').format(service.service_price)} ₫ / ${service.unit_vi}</p>
                                <div class="mt-2">
                                    ${getServiceInputFields(service)}
                                </div>
                            </div>
                        </div>
                    `;
                    
                    serviceList.appendChild(serviceItem);
                });
            }

            // Get service input fields based on service type
            function getServiceInputFields(service) {
                const serviceType = service.service_type;
                const unit = service.unit;
                
                if (serviceType === 'electric') {
                    return `
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Số cũ</label>
                                <input type="number" class="w-full px-2 py-1 text-sm border border-gray-300 rounded" 
                                       placeholder="0" data-field="old_value">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Số mới</label>
                                <input type="number" class="w-full px-2 py-1 text-sm border border-gray-300 rounded" 
                                       placeholder="0" data-field="new_value">
                            </div>
                        </div>
                    `;
                } else if (unit === 'person') {
                    return `
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Số người</label>
                            <input type="number" class="w-full px-2 py-1 text-sm border border-gray-300 rounded" 
                                   placeholder="1" data-field="person_count" min="1">
                        </div>
                    `;
                } else if (unit === 'month') {
                    return `
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Số tháng</label>
                            <input type="number" class="w-full px-2 py-1 text-sm border border-gray-300 rounded" 
                                   placeholder="1" data-field="month_count" min="1" value="1">
                        </div>
                    `;
                } else {
                    return `
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Số lượng</label>
                            <input type="number" class="w-full px-2 py-1 text-sm border border-gray-300 rounded" 
                                   placeholder="1" data-field="quantity" min="1">
                        </div>
                    `;
                }
            }

            // Create invoice
            createInvoiceBtn.addEventListener('click', function() {
                if (!selectedRoomId) {
                    alert('Vui lòng chọn phòng');
                    return;
                }

                // Collect service data
                const services = [];
                document.querySelectorAll('[data-service-id]').forEach(checkbox => {
                    if (checkbox.checked) {
                        const serviceId = checkbox.dataset.serviceId;
                        const serviceItem = checkbox.closest('.p-4');
                        const inputs = serviceItem.querySelectorAll('input[data-field]');
                        
                        const serviceData = {
                            service_id: serviceId,
                            old_value: null,
                            new_value: null,
                            person_count: null,
                            month_count: null,
                            quantity: null
                        };
                        
                        inputs.forEach(input => {
                            const field = input.dataset.field;
                            const value = parseFloat(input.value) || 0;
                            serviceData[field] = value;
                        });
                        
                        services.push(serviceData);
                    }
                });

                if (services.length === 0) {
                    alert('Vui lòng chọn ít nhất một dịch vụ');
                    return;
                }

                // Here you would send the data to create invoice
                console.log('Creating invoice for room:', selectedRoomId);
                console.log('Services:', services);
                
                // For now, just close the modal
                closeModal();
                alert('Tính năng tạo hóa đơn sẽ được phát triển tiếp');
            });
        });
    </script>
</body>

</html>