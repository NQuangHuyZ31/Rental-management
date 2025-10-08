<!-- 
    Author: Nguyen Xuan Duong
    Date: 2025-10-06
    Purpose: Landlord Banking - Payment History Index
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOSTY - Lịch sử giao dịch</title>
    <?php include VIEW_PATH . '/landlord/layouts/app.php'; ?>
</head>

<body class="bg-gray-100">
    <?php include VIEW_PATH . '/landlord/layouts/header.php'; ?>
    <?php include VIEW_PATH . '/landlord/layouts/nav.php'; ?>

    <main class="min-h-screen bg-gray-100 w-full">
        <div class="bg-white min-h-screen p-6">
            <div class="max-w-full mx-auto">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-1 h-8 bg-green-600 mr-3"></div>
                        <div>
                            <h3 class="text-base font-medium text-gray-800">Lịch sử thanh toán:</h3>
                            <p class="text-gray-600 italic mt-1 text-sm">Thông tin về giao dịch chuyển khoản và hóa đơn tương ứng</p>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <form method="GET" action="<?= BASE_URL ?>/landlord/banking" class="mb-4">
                    <input type="hidden" name="house_id" value="<?= isset($selectedHouse['id']) ? intval($selectedHouse['id']) : '' ?>">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Nhà trọ</label>
                            <select name="house_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <?php foreach (($houses ?? []) as $house): ?>
                                    <option value="<?= $house['id'] ?>" <?= (isset($selectedHouse['id']) && $selectedHouse['id'] == $house['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($house['house_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Tháng (mm-YYYY)</label>
                            <input type="text" name="month" value="<?= htmlspecialchars($_GET['month'] ?? '') ?>" placeholder="09-2025" class="w-full px-3 py-2 border border-gray-300 rounded-lg"/>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Mã tham chiếu</label>
                            <input type="text" name="reference_code" value="<?= htmlspecialchars($_GET['reference_code'] ?? '') ?>" placeholder="901V602..." class="w-full px-3 py-2 border border-gray-300 rounded-lg"/>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Trạng thái</label>
                            <select name="invoice_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <?php $curInvoiceStatus = $_GET['invoice_status'] ?? ''; ?>
                                <option value="" <?= $curInvoiceStatus === '' ? 'selected' : '' ?>>Tất cả</option>
                                <option value="paid" <?= $curInvoiceStatus === 'paid' ? 'selected' : '' ?>>Đã thanh toán</option>
                                <option value="pending" <?= $curInvoiceStatus === 'pending' ? 'selected' : '' ?>>Đang chờ</option>
                                <option value="overdue" <?= $curInvoiceStatus === 'overdue' ? 'selected' : '' ?>>Quá hạn</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors w-full">Lọc</button>
                        </div>
                    </div>
                </form>

                <!-- Table -->
                <div class="bg-white overflow-hidden rounded-none">
                    <?php if (!empty($paymentHistories)): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full rounded-none">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300">Thời gian</th>
                                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300">Hóa đơn</th>
                                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300">Mã hóa đơn</th>
                                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300">Phòng</th>
                                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300">Người thanh toán</th>
                                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300">Số tiền</th>
                                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300">Trạng thái</th>
                                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 border border-gray-300">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <?php foreach ($paymentHistories as $ph): ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap border border-gray-300 text-sm text-gray-700 text-center">
                                                <?= !empty($ph['created_at']) ? date('d/m/Y H:i:s', strtotime($ph['created_at'])) : '' ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border border-gray-300 text-sm text-gray-700">
                                                <div class="text-gray-900"><?= htmlspecialchars($ph['invoice_name'] ?? '') ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border border-gray-300 text-sm text-gray-700 text-center">
                                                <span class="font-mono text-sm"><?= htmlspecialchars($ph['ref_code'] ?? '') ?></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border border-gray-300 text-sm text-gray-700 text-center">
                                                <?= htmlspecialchars($ph['room_name'] ?? '') ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border border-gray-300 text-sm text-gray-700 text-center">
                                                <?= htmlspecialchars($ph['payer_name'] ?? '') ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border border-gray-300 text-sm text-gray-900 text-center">
                                                <?php 
                                                    $amount = $ph['amount'] ?? null; 
                                                    echo $amount !== null ? \Helpers\Format::forMatPrice($amount) . 'đ' : '-';
                                                ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border border-gray-300 text-sm text-center">
                                                <?php 
                                                    $invoiceStatus = strtolower($ph['invoice_status'] ?? 'pending');
                                                    if ($invoiceStatus === 'paid'): ?>
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white" style="background-color: #7DC242;">
                                                            Đã thanh toán
                                                        </span>
                                                    <?php elseif ($invoiceStatus === 'overdue'): ?>
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white" style="background-color: #DC2626;">
                                                            Quá hạn
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white" style="background-color: #ED6004;">
                                                            Đang chờ
                                                        </span>
                                                    <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border border-gray-300 text-sm text-center">
                                                <button onclick="viewPaymentDetail(<?= $ph['id'] ?>)" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                    Xem chi tiết
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php 
                            $total = intval($total ?? 0);
                            $limit = max(1, intval($limit ?? 10));
                            $page = max(1, intval($page ?? 1));
                            $totalPages = max(1, (int)ceil($total / $limit));
                        ?>
                        <div class="flex items-center justify-between px-4 py-3 border-t border-gray-200">
                            <div class="text-sm text-gray-600">
                                Hiển thị <?= count($paymentHistories) ?> / <?= $total ?> giao dịch
                            </div>
                            <div class="flex gap-2">
                                <?php if ($page > 1): ?>
                                    <a class="px-3 py-1 border rounded hover:bg-gray-50" href="<?= BASE_URL ?>/landlord/banking?house_id=<?= isset($selectedHouse['id']) ? intval($selectedHouse['id']) : '' ?>&page=<?= $page - 1 ?>&limit=<?= $limit ?>&month=<?= urlencode($_GET['month'] ?? '') ?>&reference_code=<?= urlencode($_GET['reference_code'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>">Trước</a>
                                <?php endif; ?>
                                <span class="px-3 py-1 text-sm text-gray-700">Trang <?= $page ?>/<?= $totalPages ?></span>
                                <?php if ($page < $totalPages): ?>
                                    <a class="px-3 py-1 border rounded hover:bg-gray-50" href="<?= BASE_URL ?>/landlord/banking?house_id=<?= isset($selectedHouse['id']) ? intval($selectedHouse['id']) : '' ?>&page=<?= $page + 1 ?>&limit=<?= $limit ?>&month=<?= urlencode($_GET['month'] ?? '') ?>&reference_code=<?= urlencode($_GET['reference_code'] ?? '') ?>&status=<?= urlencode($_GET['status'] ?? '') ?>">Sau</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Chưa có giao dịch</h3>
                            <p class="mt-2 text-gray-500">Khi khách thanh toán hóa đơn, giao dịch sẽ xuất hiện tại đây.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Chi tiết Giao dịch -->
    <div id="paymentDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-4/5 lg:w-3/5 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-1 h-8 bg-green-600 mr-3"></div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Chi tiết giao dịch</h3>
                            <p class="text-gray-600 italic mt-1 text-sm">Thông tin về giao dịch chuyển khoản và hóa đơn tương ứng</p>
                        </div>
                    </div>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div id="modalContent" class="space-y-4">
                    <!-- Content will be loaded here -->
                </div>
                
                <div class="flex justify-end mt-6">
                    <button onclick="closeModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include VIEW_PATH . '/landlord/layouts/footer.php'; ?>

<script>
    function viewPaymentDetail(paymentId) {
        document.getElementById('paymentDetailModal').classList.remove('hidden');
        document.getElementById('modalContent').innerHTML = '<div class="text-center">Đang tải...</div>';
        
        fetch(`${App.appURL}landlord/banking/detail?id=${paymentId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayPaymentDetail(data.data);
                } else {
                    document.getElementById('modalContent').innerHTML = 
                        `<div class="text-red-500 text-center">${data.message}</div>`;
                }
            })
            .catch(error => {
                document.getElementById('modalContent').innerHTML = 
                    '<div class="text-red-500 text-center">Có lỗi xảy ra khi tải dữ liệu</div>';
            });
    }

    function displayPaymentDetail(data) {
        const formatPrice = (amount) => {
            return new Intl.NumberFormat('vi-VN').format(amount);
        };

        const formatDate = (dateString) => {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');
            return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
        };

        const formatDescription = (description) => {
            if (!description) return 'Không có';
            // Cắt bỏ "BankAPINotify" ở đầu chuỗi
            return description.replace(/^BankAPINotify\s*/i, '');
        };

        const statusBadge = (status) => {
            const statusMap = {
                'paid': { text: 'Đã thanh toán', color: '#7DC242' },
                'overdue': { text: 'Quá hạn', color: '#DC2626' },
                'pending': { text: 'Đang chờ', color: '#ED6004' }
            };
            const s = statusMap[status] || statusMap['pending'];
            return `<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white" style="background-color: ${s.color};">${s.text}</span>`;
        };

        document.getElementById('modalContent').innerHTML = `
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:divide-x md:divide-gray-200">
                    <div class="md:pr-8">
                        <h4 class="text-base font-semibold text-gray-900 mb-4 border-b pb-2">💰 Thông tin giao dịch</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Thời gian:</span>
                                <span class="text-gray-900">${formatDate(data.created_at)}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Số tiền:</span>
                                <span class="text-green-600">${formatPrice(data.amount)}đ</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ngân hàng:</span>
                                <span class="text-gray-900">${data.gateway || 'Không có'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Số tài khoản:</span>
                                <span class="text-gray-900">${data.account_number || 'Không có'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Mã tham chiếu:</span>
                                <span class="text-gray-900">${data.referenceCode || 'Không có'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nội dung:</span>
                                <span class="text-gray-900">${formatDescription(data.description)}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tên khách hàng:</span>
                                <span class="text-gray-900">${data.payer_name || 'Không có'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:pl-8">
                        <h4 class="text-base font-semibold text-gray-900 mb-4 border-b pb-2">📄 Thông tin hóa đơn</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tên hóa đơn:</span>
                                <span class="text-gray-900">${data.invoice_name}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Mã hóa đơn:</span>
                                <span class="text-gray-900">${data.ref_code}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tháng:</span>
                                <span class="text-gray-900">${data.invoice_month}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nhà trọ:</span>
                                <span class="text-gray-900">${data.house_name}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Phòng:</span>
                                <span class="text-gray-900">${data.room_name}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function closeModal() {
        document.getElementById('paymentDetailModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('paymentDetailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
</body>
</html>

