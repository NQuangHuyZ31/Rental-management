<!--
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Customer bills management page
-->

<!-- Bills Header -->
<div class="mb-8">
    <?= \Core\CSRF::getTokenField() ?>
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Quản lý hóa đơn</h1>
    <p class="text-gray-600">Theo dõi và thanh toán các hóa đơn tiền phòng</p>

    <!-- Pagination Info -->
    <?php if (isset($pagination) && $pagination['total_items'] > 0) { ?>
        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg pagination-info">
            <div class="flex items-center justify-between">
                <div class="text-sm text-blue-700">
                    <i class="fas fa-info-circle mr-2"></i>
                    Hiển thị <span class="font-semibold"><?= (($pagination['current_page'] - 1) * $pagination['items_per_page']) + 1 ?></span>
                    đến <span class="font-semibold"><?= min($pagination['current_page'] * $pagination['items_per_page'], $pagination['total_items']) ?></span>
                    của <span class="font-semibold"><?= $pagination['total_items'] ?></span> hóa đơn
                </div>
                <div class="text-sm text-blue-600">
                    Trang <?= $pagination['current_page'] ?> / <?= $pagination['total_pages'] ?>
                </div>
            </div>
        </div>
    <?php } ?>
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
                <p class="text-2xl font-bold text-gray-900"><?= $countAllInvoices; ?></p>
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
                <p class="text-2xl font-bold text-red-600"><?= $countInvoicesPending; ?></p>
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
                <p class="text-2xl font-bold text-green-600"><?= $countInvoicesPaid; ?></p>
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
                <p class="text-sm font-medium text-gray-600">Tổng chi tiêu trong năm</p>
                <p class="text-2xl font-bold text-gray-900"><?= $totalAmount; ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Filter and Search -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <form action="<?= BASE_URL ?>/customer/bills" method="get" class="flex-1">
                <div class="flex gap-2 flex-wrap">
                    <select name="status" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 w-40">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending" <?= $request->get('status') == 'pending' ? 'selected' : ''; ?>>Chờ thanh toán</option>
                        <option value="paid" <?= $request->get('status') == 'paid' ? 'selected' : ''; ?>>Đã thanh toán</option>
                        <option value="overdue" <?= $request->get('status') == 'overdue' ? 'selected' : ''; ?>>Quá hạn</option>
                    </select>
                    <select name="month" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 w-40">
                        <option value="">Tất cả tháng</option>
                        <?php

                        use Helpers\Format;

                        for ($i = 1; $i <= 12; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php echo $request->get('month') != '' && ($request->get('month') == $i) ? 'selected' : ''; ?>><?php echo 'Tháng ' . $i; ?></option>
                        <?php } ?>
                    </select>

                    <select name="year" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 w-40">
                        <?php $year = date('Y');
                        $previous_year = $year - 10; ?>
                        <option value="">Tất cả năm</option>
                        <?php for ($i = $previous_year; $i <= $year; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php echo $request->get('year') == $i ? 'selected' : ''; ?>><?php echo 'Năm ' . $i; ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        <i class="fas fa-search mr-2"></i>Tìm kiếm
                    </button>
                </div>
            </form>

            <!-- Quick Actions -->
            <div class="flex gap-2">
                <a href="<?= BASE_URL ?>/customer/bills" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-refresh mr-2"></i>Làm mới
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Bills List -->
<div class="space-y-4">
    <?php if (empty($allInvoices)) { ?>
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 empty-state">
            <div class="text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6 empty-state-icon">
                    <i class="fas fa-file-invoice text-gray-400 text-4xl"></i>
                </div>

                <?php if ($request->get('status') || $request->get('month') || $request->get('year')) { ?>
                    <!-- No results found for filter -->
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Không tìm thấy hóa đơn</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        Không có hóa đơn nào phù hợp với bộ lọc bạn đã chọn. Hãy thử thay đổi điều kiện tìm kiếm.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="<?= BASE_URL ?>/customer/bills"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center justify-center">
                            <i class="fas fa-refresh mr-2"></i>
                            Xem tất cả hóa đơn
                        </a>
                        <button onclick="clearFilters()"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>
                            Xóa bộ lọc
                        </button>
                    </div>
                <?php } else { ?>
                    <!-- No invoices at all -->
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Chưa có hóa đơn nào</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        Hiện tại bạn chưa có hóa đơn nào. Hóa đơn sẽ được tạo tự động khi bạn thuê phòng.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="<?= BASE_URL ?>/customer/rented-rooms"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center justify-center">
                            <i class="fas fa-home mr-2"></i>
                            Xem phòng đã thuê
                        </a>
                        <a href="<?= BASE_URL ?>/"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center justify-center">
                            <i class="fas fa-search mr-2"></i>
                            Tìm phòng mới
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <!-- Check if all invoices are paid -->
        <?php
        $allPaid = true;
        foreach ($allInvoices as $invoice) {
            if (in_array($invoice['invoice_status'], ['pending', 'overdue'])) {
                $allPaid = false;
                break;
            }
        }
        ?>

        <?php
        $hasOverdue = false;
        foreach ($allInvoices as $invoice) {
            if ($invoice['invoice_status'] === 'overdue') {
                $hasOverdue = true;
                break;
            }
        }
        ?>

        <?php
        $hasPending = false;
        foreach ($allInvoices as $invoice) {
            if ($invoice['invoice_status'] === 'pending') {
                $hasPending = true;
                break;
            }
        }
        ?>

        <?php if ($hasOverdue) { ?>
            <!-- Overdue Warning -->
            <div class="bg-white rounded-lg shadow-sm border border-red-200 p-6 mb-6 overdue-warning">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-red-800 mb-1">Có hóa đơn quá hạn thanh toán</h3>
                        <p class="text-red-600 text-sm">
                            Vui lòng thanh toán ngay để tránh phí trễ hạn và đảm bảo dịch vụ không bị gián đoạn.
                        </p>
                    </div>
                </div>
            </div>
        <?php } elseif ($hasPending && !$hasOverdue) { ?>
            <!-- Pending Payment Reminder -->
            <div class="bg-white rounded-lg shadow-sm border border-yellow-200 p-6 mb-6 pending-reminder">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-yellow-800 mb-1">Có hóa đơn đang chờ thanh toán</h3>
                        <p class="text-yellow-600 text-sm">
                            Bạn có hóa đơn chưa thanh toán. Vui lòng thanh toán trước hạn để tránh phí trễ hạn.
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Bills List -->
        <?php foreach ($allInvoices as $invoice) { ?>
            <div class="bg-white rounded-lg shadow-sm border invoice-item <?= in_array($invoice['invoice_status'], ['pending', 'overdue']) ? 'border-red-200' : 'border-green-200'; ?> overflow-hidden" data-invoice-id="<?= $invoice['id'] ?>">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 <?= in_array($invoice['invoice_status'], ['pending', 'overdue']) ? 'bg-red-100' : 'bg-green-100'; ?> rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-invoice-dollar <?= in_array($invoice['invoice_status'], ['pending', 'overdue']) ? 'text-red-600' : 'text-green-600'; ?> text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Hóa đơn #HD-<?= $invoice['invoice_month'] ?></h3>
                                <p class="text-sm text-gray-600"><?= $invoice['room_name'] ?> - <?= $invoice['house_name'] ?></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold <?= in_array($invoice['invoice_status'], ['pending', 'overdue']) ? 'text-red-600' : 'text-green-600'; ?>"><?= Format::formatUnit($invoice['total']) ?></p>
                            <span class="inline-block <?= in_array($invoice['invoice_status'], ['pending', 'overdue']) ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'; ?> text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-exclamation-triangle mr-1"></i><?= in_array($invoice['invoice_status'], ['pending', 'overdue']) ? 'Chưa thanh toán' : 'Đã thanh toán' ?>
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Thông tin hóa đơn</h4>
                            <div class="space-y-1 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Số hóa đơn:</span>
                                    <span class="font-medium">HD-<?= $invoice['invoice_month'] ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ngày tạo:</span>
                                    <span class="font-medium"><?= date('d/m/Y', strtotime($invoice['invoice_day'])) ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Hạn thanh toán:</span>
                                    <span class="font-medium text-red-600"><?= date('d/m/Y', strtotime($invoice['due_date'])) ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Chi tiết phòng</h4>
                            <div class="space-y-1 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tên phòng:</span>
                                    <span class="font-medium"><?= $invoice['room_name'] ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Địa chỉ:</span>
                                    <span class="font-medium"><?= $invoice['house_name'] ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tháng:</span>
                                    <span class="font-medium"><?= $invoice['invoice_month'] ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Chi phí</h4>
                            <div class="space-y-1 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tiền phòng:</span>
                                    <span class="font-medium"><?= Format::formatUnit($invoice['rental_amount']) ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Phí dịch vụ:</span>
                                    <span class="font-medium"><?= Format::formatUnit($invoice['electric_amount'] + $invoice['water_amount'] + $invoice['service_amount'] + $invoice['parking_amount'] + $invoice['other_amount']) ?></span>
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
                                    <span class="invoice-item-status <?= in_array($invoice['invoice_status'], ['pending', 'overdue']) ? 'text-red-600' : 'text-green-600'; ?> font-medium"><?= in_array($invoice['invoice_status'], ['pending', 'overdue']) ? 'Chưa thanh toán' : 'Đã thanh toán' ?></span>
                                </div>
                                <div class="flex justify-between <?= in_array($invoice['invoice_status'], ['pending', 'overdue']) ? 'block' : 'hidden'; ?>">
                                    <span class="text-gray-600">Còn lại:</span>
                                    <span class="font-medium"><?= (strtotime($invoice['due_date']) - strtotime($invoice['invoice_day'])) / (60 * 60 * 24) ?> ngày</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <?php if (in_array($invoice['invoice_status'], ['pending', 'overdue'])) { ?>
                            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors btn-payment"
                                data-action="pay-bill-vietqr"
                                data-invoice-id="<?= $invoice['id'] ?>">
                                <i class="fas fa-qrcode mr-2"></i>Thanh toán hóa đơn
                            </button>
                        <?php } ?>
                        <a href="<?= BASE_URL ?>/customer/payment/download-invoice/<?= $invoice['id'] ?>" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors cursor-pointer">
                            <i class="fas fa-download mr-2"></i>Tải hóa đơn
                        </a>
                        <button type="button" onclick="invoiceDetail(this)" data-invoice='<?= htmlspecialchars(json_encode($invoice), ENT_QUOTES, "UTF-8") ?>' class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors cursor-pointer invoice-detail">
                            <i class="fas fa-eye mr-2"></i>Xem chi tiết
                        </button>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Pagination -->
        <?php if (!empty($pagination) && $pagination['total_pages'] > 1): ?>
            <div class="mt-8">
                <?= \Helpers\Pagination::render($pagination, '', $queryParams) ?>
            </div>
        <?php endif; ?>
    <?php } ?>

    <?php include_once ROOT_PATH . '/views/partials/invoice-detail-modal.php'; ?>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-hidden
md:inset-0 bg-gray-900/50 payment-modal items-center justify-center">>
    <div class="flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-5xl w-full max-h-[90vh] overflow-hidden modal-content">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200 bg-green-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-qrcode text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Thanh toán hóa đơn</h2>
                            <p class="text-sm text-gray-600">Quét mã QR để thanh toán nhanh chóng</p>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle text-yellow-600 text-xs"></i>
                                <p class="text-[10px] text-red-600">Vui lòng không đóng giao diện thanh toán này trước khi thanh toán thành công xuất hiện!</p>
                            </div>
                        </div>
                    </div>
                    <button id="closePaymentModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="flex h-[70vh]">
                <!-- Left Side - Invoice Information -->
                <div class="w-1/2 p-4 border-r border-gray-200 overflow-y-auto left-side">
                    <div class="space-y-3">
                        <!-- Invoice Header -->
                        <div class="text-center">
                            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-file-invoice-dollar text-red-600 text-xl"></i>
                            </div>
                            <h3 id="invoiceNumber" class="text-lg font-bold text-gray-900 mb-1">Hóa đơn #HD-2024-001</h3>
                            <p id="roomInfo" class="text-gray-600 text-xs">Phòng 101 - Chung cư ABC</p>
                        </div>

                        <!-- Payment Breakdown -->
                        <div class="bg-green-50 rounded-lg p-2 invoice-card payment-breakdown">
                            <h4 class="font-semibold text-gray-900 mb-1 flex items-center text-xs">
                                <i class="fas fa-calculator text-green-600 mr-1"></i>
                                Chi tiết thanh toán
                            </h4>
                            <div class="space-y-1 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tiền phòng:</span>
                                    <span id="rentAmount" class="font-medium">2,000,000 VNĐ</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tiền điện:</span>
                                    <span id="electricAmount" class="font-medium">300,000 VNĐ</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tiền nước:</span>
                                    <span id="waterAmount" class="font-medium">200,000 VNĐ</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Phí dịch vụ:</span>
                                    <span id="serviceAmount" class="font-medium">0 VNĐ</span>
                                </div>
                                <hr class="my-1">
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-gray-900">Tổng cộng:</span>
                                    <span id="totalAmountDetail" class="text-red-600">2,500,000 VNĐ</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Instructions -->
                        <div class="bg-yellow-50 rounded-lg p-2 invoice-card instructions">
                            <h4 class="font-semibold text-gray-900 mb-1 flex items-center text-xs">
                                <i class="fas fa-exclamation-triangle text-yellow-600 mr-1"></i>
                                Hướng dẫn thanh toán
                            </h4>
                            <div class="text-xs text-gray-700 space-y-1">
                                <p>1. Mở ứng dụng ngân hàng</p>
                                <p>2. Chọn "Quét mã QR"</p>
                                <p>3. Quét mã QR bên phải</p>
                                <p class="font-semibold text-red-600 text-xs">Lưu ý: Thanh toán đúng số tiền</p>
                            </div>
                        </div>

                        <!-- Payment Status -->
                        <div id="paymentStatus" class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="bg-yellow-100 border-2 border-yellow-300 rounded-lg p-1 shadow-sm">
                                <div class="flex items-center justify-center">
                                    <div class="animate-pulse">
                                        <i class="fas fa-clock text-yellow-600 mr-1 text-xs"></i>
                                    </div>
                                    <span class="text-yellow-800 font-bold text-xs">Chờ thanh toán</span>
                                </div>
                                <p class="text-yellow-700 text-xs text-center mt-1">
                                    Vui lòng quét mã QR để thanh toán
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - QR Code -->
                <div class="w-1/2 p-4 flex flex-col justify-between bg-gradient-to-br from-green-50 to-blue-50 right-side">
                    <div class="w-full flex-1 overflow-y-auto">
                        <!-- QR Code Container -->
                        <div class="text-center mb-4">
                            <div class="bg-white rounded-2xl p-4 shadow-lg">
                                <div id="qrCodeContainer" class="w-48 h-48 flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg qr-code-container bg-gray-50 mx-auto">
                                    <div class="text-center">
                                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto mb-3"></div>
                                        <p class="text-gray-600 font-medium text-sm">Đang tạo mã QR...</p>
                                        <p class="text-gray-500 text-xs mt-1">Vui lòng chờ trong giây lát</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Refresh QR Button -->
                            <button id="refreshQR" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-bold transition-all duration-200 shadow-md hover:shadow-lg action-button text-sm">
                                <i class="fas fa-sync-alt mr-2"></i>
                                Làm mới mã QR
                            </button>
                        </div>
                    </div>

                    <!-- Bank Information - Fixed at bottom -->
                    <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-200 mt-3">
                        <h4 class="font-bold text-gray-900 mb-2 text-center text-xs">Thông tin ngân hàng</h4>
                        <div class="space-y-1 text-xs">
                            <div class="flex justify-between items-center py-1 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Ngân hàng:</span>
                                <span id="bank-name" class="font-bold text-gray-900"></span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-gray-100">
                                <span class="text-gray-600 font-medium">Số tài khoản:</span>
                                <span id="bank-number" class="font-bold text-blue-600 text-sm"></span>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <span class="text-gray-600 font-medium">Chủ tài khoản:</span>
                                <span id="bank-user-name" class="font-bold text-gray-900"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to clear filters
    function clearFilters() {
        // Reset all form inputs
        document.querySelector('select[name="status"]').value = '';
        document.querySelector('select[name="month"]').value = '';
        document.querySelector('select[name="year"]').value = '';

        // Submit the form to reload with no filters
        document.querySelector('form').submit();
    }
</script>