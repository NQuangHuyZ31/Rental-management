<!--
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Customer bills management page
-->

<!-- Bills Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Quản lý hóa đơn</h1>
    <p class="text-gray-600">Theo dõi và thanh toán các hóa đơn tiền phòng</p>
</div>

<!-- Bills Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Bills -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Tổng hóa đơn</p>
                <p class="text-2xl font-bold text-gray-900">12</p>
            </div>
        </div>
    </div>

    <!-- Pending Bills -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Chưa thanh toán</p>
                <p class="text-2xl font-bold text-red-600">1</p>
            </div>
        </div>
    </div>

    <!-- Paid Bills -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Đã thanh toán</p>
                <p class="text-2xl font-bold text-green-600">11</p>
            </div>
        </div>
    </div>

    <!-- Total Amount -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-wallet text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Tổng chi phí</p>
                <p class="text-2xl font-bold text-gray-900">30M VNĐ</p>
            </div>
        </div>
    </div>
</div>

<!-- Filter and Search -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex gap-2">
                <select class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 w-40">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending">Chờ thanh toán</option>
                    <option value="paid">Đã thanh toán</option>
                    <option value="overdue">Quá hạn</option>
                </select>
                <select class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 w-40">
                    <?php for ($i =1; $i <= 12; $i++) { ?>
                        <option value="<?php echo $i; ?>" <?php echo date('m') == $i ? 'selected' : ''; ?>><?php echo 'Tháng ' . $i; ?></option>
                    <?php } ?>
                </select>

                <select class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 w-40">
                        <?php $year = date('Y'); $previous_year = $year - 10; ?>
                    <?php for ($i = $previous_year; $i <= $year; $i++) { ?>
                        <option value="<?php echo $i; ?>" <?php echo $year == $i ? 'selected' : ''; ?>><?php echo 'Năm ' . $i; ?></option>
                    <?php } ?>
                </select>
                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-search mr-2"></i>Tìm kiếm
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bills List -->
<div class="space-y-4">
    <!-- Bill 1 - Pending -->
    <div class="bg-white rounded-lg shadow-sm border border-red-200 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-invoice-dollar text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Hóa đơn #HD-2024-001</h3>
                        <p class="text-sm text-gray-600">Phòng 101 - Chung cư ABC</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-red-600">2.5M VNĐ</p>
                    <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                        <i class="fas fa-exclamation-triangle mr-1"></i>Chưa thanh toán
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Thông tin hóa đơn</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Số hóa đơn:</span>
                            <span class="font-medium">HD-2024-001</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ngày tạo:</span>
                            <span class="font-medium">01/01/2025</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Hạn thanh toán:</span>
                            <span class="font-medium text-red-600">05/01/2025</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Chi tiết phòng</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tên phòng:</span>
                            <span class="font-medium">Phòng 101</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Địa chỉ:</span>
                            <span class="font-medium">Chung cư ABC</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tháng:</span>
                            <span class="font-medium">01/2025</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Chi phí</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiền phòng:</span>
                            <span class="font-medium">2.5M VNĐ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phí dịch vụ:</span>
                            <span class="font-medium">0 VNĐ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phí trễ hạn:</span>
                            <span class="font-medium">0 VNĐ</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Thanh toán</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phương thức:</span>
                            <span class="font-medium">Chuyển khoản</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Trạng thái:</span>
                            <span class="text-red-600 font-medium">Chưa thanh toán</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Còn lại:</span>
                            <span class="font-medium text-red-600">5 ngày</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-credit-card mr-2"></i>Thanh toán ngay
                </button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-download mr-2"></i>Tải hóa đơn
                </button>
                <button class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-eye mr-2"></i>Xem chi tiết
                </button>
            </div>
        </div>
    </div>

    <!-- Bill 2 - Paid -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-invoice-dollar text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Hóa đơn #HD-2024-002</h3>
                        <p class="text-sm text-gray-600">Phòng 201 - Nhà trọ XYZ</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-900">1.8M VNĐ</p>
                    <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                        <i class="fas fa-check mr-1"></i>Đã thanh toán
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Thông tin hóa đơn</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Số hóa đơn:</span>
                            <span class="font-medium">HD-2024-002</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ngày tạo:</span>
                            <span class="font-medium">01/12/2024</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ngày thanh toán:</span>
                            <span class="font-medium text-green-600">03/12/2024</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Chi tiết phòng</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tên phòng:</span>
                            <span class="font-medium">Phòng 201</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Địa chỉ:</span>
                            <span class="font-medium">Nhà trọ XYZ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tháng:</span>
                            <span class="font-medium">12/2024</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Chi phí</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiền phòng:</span>
                            <span class="font-medium">1.8M VNĐ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phí dịch vụ:</span>
                            <span class="font-medium">0 VNĐ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tổng cộng:</span>
                            <span class="font-medium">1.8M VNĐ</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Thanh toán</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phương thức:</span>
                            <span class="font-medium">Chuyển khoản</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Trạng thái:</span>
                            <span class="text-green-600 font-medium">Đã thanh toán</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Mã giao dịch:</span>
                            <span class="font-medium">TXN-123456</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-download mr-2"></i>Tải hóa đơn
                </button>
                <button class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-eye mr-2"></i>Xem chi tiết
                </button>
                <button class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-redo mr-2"></i>Thanh toán lại
                </button>
            </div>
        </div>
    </div>

    <!-- Bill 3 - Paid -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-invoice-dollar text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Hóa đơn #HD-2024-003</h3>
                        <p class="text-sm text-gray-600">Phòng 101 - Chung cư ABC</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-900">2.5M VNĐ</p>
                    <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                        <i class="fas fa-check mr-1"></i>Đã thanh toán
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Thông tin hóa đơn</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Số hóa đơn:</span>
                            <span class="font-medium">HD-2024-003</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ngày tạo:</span>
                            <span class="font-medium">01/11/2024</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ngày thanh toán:</span>
                            <span class="font-medium text-green-600">02/11/2024</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Chi tiết phòng</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tên phòng:</span>
                            <span class="font-medium">Phòng 101</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Địa chỉ:</span>
                            <span class="font-medium">Chung cư ABC</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tháng:</span>
                            <span class="font-medium">11/2024</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Chi phí</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiền phòng:</span>
                            <span class="font-medium">2.5M VNĐ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phí dịch vụ:</span>
                            <span class="font-medium">0 VNĐ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tổng cộng:</span>
                            <span class="font-medium">2.5M VNĐ</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Thanh toán</h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phương thức:</span>
                            <span class="font-medium">Chuyển khoản</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Trạng thái:</span>
                            <span class="text-green-600 font-medium">Đã thanh toán</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Mã giao dịch:</span>
                            <span class="font-medium">TXN-123455</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-download mr-2"></i>Tải hóa đơn
                </button>
                <button class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-eye mr-2"></i>Xem chi tiết
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Thanh toán hóa đơn</h2>
                    <button id="closePaymentModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-file-invoice-dollar text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Hóa đơn #HD-2024-001</h3>
                        <p class="text-gray-600">Phòng 101 - Chung cư ABC</p>
                        <p class="text-3xl font-bold text-red-600 mt-4">2.5M VNĐ</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phương thức thanh toán</label>
                        <div class="space-y-2">
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="paymentMethod" value="bank_transfer" class="mr-3" checked>
                                <i class="fas fa-university text-blue-600 mr-3"></i>
                                <div>
                                    <p class="font-medium">Chuyển khoản ngân hàng</p>
                                    <p class="text-sm text-gray-600">Thanh toán qua chuyển khoản</p>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="paymentMethod" value="momo" class="mr-3">
                                <i class="fas fa-mobile-alt text-pink-600 mr-3"></i>
                                <div>
                                    <p class="font-medium">Ví MoMo</p>
                                    <p class="text-sm text-gray-600">Thanh toán qua ví điện tử</p>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="paymentMethod" value="zalopay" class="mr-3">
                                <i class="fas fa-credit-card text-blue-600 mr-3"></i>
                                <div>
                                    <p class="font-medium">ZaloPay</p>
                                    <p class="text-sm text-gray-600">Thanh toán qua ZaloPay</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-2">Thông tin chuyển khoản</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ngân hàng:</span>
                                <span class="font-medium">Vietcombank</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Số tài khoản:</span>
                                <span class="font-medium">1234567890</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Chủ tài khoản:</span>
                                <span class="font-medium">Nguyễn Thị B</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nội dung:</span>
                                <span class="font-medium">HD-2024-001</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
                <button id="closePaymentModalBtn" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Hủy
                </button>
                <button id="confirmPayment" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-credit-card mr-2"></i>Xác nhận thanh toán
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bill Detail Modal -->
<div id="billDetailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Chi tiết hóa đơn</h2>
                    <button id="closeBillDetailModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Hóa đơn #HD-2024-001</h3>
                        <p class="text-gray-600">Phòng 101 - Chung cư ABC</p>
                        <p class="text-3xl font-bold text-red-600 mt-4">2.5M VNĐ</p>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3">Thông tin hóa đơn</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Số hóa đơn:</span>
                                        <span class="font-medium">HD-2024-001</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Ngày tạo:</span>
                                        <span class="font-medium">01/01/2025</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Hạn thanh toán:</span>
                                        <span class="font-medium text-red-600">05/01/2025</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Trạng thái:</span>
                                        <span class="text-red-600 font-medium">Chưa thanh toán</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-medium text-gray-900 mb-3">Chi tiết phòng</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tên phòng:</span>
                                        <span class="font-medium">Phòng 101</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Địa chỉ:</span>
                                        <span class="font-medium">Chung cư ABC</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tháng:</span>
                                        <span class="font-medium">01/2025</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Diện tích:</span>
                                        <span class="font-medium">25m²</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Chi tiết chi phí</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tiền phòng tháng 01/2025:</span>
                                    <span class="font-medium">2.5M VNĐ</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Phí dịch vụ:</span>
                                    <span class="font-medium">0 VNĐ</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Phí trễ hạn:</span>
                                    <span class="font-medium">0 VNĐ</span>
                                </div>
                                <hr class="border-gray-300">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Tổng cộng:</span>
                                    <span class="text-red-600">2.5M VNĐ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
                <button id="closeBillDetailModalBtn" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Đóng
                </button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-download mr-2"></i>Tải xuống
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Payment modal functionality
    const paymentModal = document.getElementById("paymentModal");
    const closePaymentModal = document.getElementById("closePaymentModal");
    const closePaymentModalBtn = document.getElementById("closePaymentModalBtn");
    const confirmPayment = document.getElementById("confirmPayment");

    // Open payment modal
    document.querySelectorAll("[data-action=\'pay-bill\']").forEach(button => {
        button.addEventListener("click", function() {
            paymentModal.classList.remove("hidden");
        });
    });

    // Close payment modal
    [closePaymentModal, closePaymentModalBtn].forEach(button => {
        button.addEventListener("click", function() {
            paymentModal.classList.add("hidden");
        });
    });

    // Confirm payment
    confirmPayment.addEventListener("click", function() {
        const selectedMethod = document.querySelector("input[name=\'paymentMethod\']:checked").value;
        
        // Show loading
        this.innerHTML = "<i class=\"fas fa-spinner fa-spin mr-2\"></i>Đang xử lý...";
        this.disabled = true;
        
        // Simulate payment processing
        setTimeout(() => {
            paymentModal.classList.add("hidden");
            this.innerHTML = "<i class=\"fas fa-credit-card mr-2\"></i>Xác nhận thanh toán";
            this.disabled = false;
            
            toastr.success("Thanh toán thành công! Hóa đơn đã được cập nhật.");
        }, 3000);
    });

    // Bill detail modal functionality
    const billDetailModal = document.getElementById("billDetailModal");
    const closeBillDetailModal = document.getElementById("closeBillDetailModal");
    const closeBillDetailModalBtn = document.getElementById("closeBillDetailModalBtn");

    // Open bill detail modal
    document.querySelectorAll("[data-action=\'view-bill\']").forEach(button => {
        button.addEventListener("click", function() {
            billDetailModal.classList.remove("hidden");
        });
    });

    // Close bill detail modal
    [closeBillDetailModal, closeBillDetailModalBtn].forEach(button => {
        button.addEventListener("click", function() {
            billDetailModal.classList.add("hidden");
        });
    });

    // Close modals when clicking outside
    [paymentModal, billDetailModal].forEach(modal => {
        modal.addEventListener("click", function(e) {
            if (e.target === modal) {
                modal.classList.add("hidden");
            }
        });
    });
});
</script>