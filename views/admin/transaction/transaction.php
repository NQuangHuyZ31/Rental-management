<!-- 
    Author: Huy Nguyen
    Date: 2025-09-09
    Purpose: Posts for admin
-->

<!-- Page Header -->
<div class="p-3">
	<input type="hidden" name="role" value="admin">
	<div class="mb-8">
		<div class="flex items-center justify-between">
			<div>
				<h1 class="text-3xl font-bold text-gray-900">Giao dịch</h1>
				<p class="mt-2 text-gray-600">Quản lý tất cả giao dịch</p>
			</div>
		</div>
	</div>

	<!-- Stats Cards -->
	<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
		<div class="bg-white overflow-hidden shadow rounded-lg">
			<div class="p-5">
				<div class="flex items-center">
					<div class="flex-shrink-0">
						<div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
							<!-- Transactions list icon -->
							<svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h12M8 12h12M8 18h12M4 6h.01M4 12h.01M4 18h.01" />
							</svg>
						</div>
					</div>
					<div class="ml-5 w-0 flex-1">
						<dl>
							<dt class="text-sm font-medium text-gray-500 truncate">Tổng giao dịch</dt>
							<dd class="text-lg font-medium text-gray-900"><?= htmlspecialchars($allTransaction ?? 0, ENT_QUOTES, 'UTF-8') ?></dd>
						</dl>
					</div>
				</div>
			</div>
		</div>

		<div class="bg-white overflow-hidden shadow rounded-lg">
			<div class="p-5">
				<div class="flex items-center">
					<div class="flex-shrink-0">
						<div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
							<!-- Calendar icon -->
							<svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2z" />
							</svg>
						</div>
					</div>
					<div class="ml-5 w-0 flex-1">
						<dl>
							<dt class="text-sm font-medium text-gray-500 truncate">Tổng giao dịch trong tháng</dt>
							<dd class="text-lg font-medium text-gray-900"><?= htmlspecialchars($transactionsThisMonth ?? 0, ENT_QUOTES, 'UTF-8') ?></dd>
						</dl>
					</div>
				</div>
			</div>
		</div>

		<div class="bg-white overflow-hidden shadow rounded-lg">
			<div class="p-5">
				<div class="flex items-center">
					<div class="flex-shrink-0">
						<div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
							<!-- Currency / wallet icon -->
							<svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-2M15 3v4M21 12h-6" />
							</svg>
						</div>
					</div>
					<div class="ml-5 w-0 flex-1">
						<dl>
							<dt class="text-sm font-medium text-gray-500 truncate">Tổng tiền giao dịch</dt>
							<dd class="text-lg font-medium text-gray-900"><?= htmlspecialchars($totalTransactionAmount ?? 0, ENT_QUOTES, 'UTF-8') ?></dd>
						</dl>
					</div>
				</div>
			</div>
		</div>

		<div class="bg-white overflow-hidden shadow rounded-lg">
			<div class="p-5">
				<div class="flex items-center">
					<div class="flex-shrink-0">
						<div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
							<!-- Chart icon -->
							<svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 11V3m0 8v8M5 21V11M17 21V7m0 14h4" />
							</svg>
						</div>
					</div>
					<div class="ml-5 w-0 flex-1">
						<dl>
							<dt class="text-sm font-medium text-gray-500 truncate">Tổng tiền giao dịch trong tháng</dt>
							<dd class="text-lg font-medium text-gray-900"><?= htmlspecialchars($totalTransactionAmountThisMonth ?? 0, ENT_QUOTES, 'UTF-8') ?></dd>
						</dl>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Posts Table -->
	<div class="bg-white shadow rounded-lg overflow-hidden">
		<div class="flex items-center justify-between gap-10 border-b border-gray-200 pr-3">
			<div class="flex items-center gap-10 px-6 py-4 border-b border-gray-200">
				<h3 class="text-lg font-medium text-gray-900">Danh sách giao dịch</h3>
			</div>
		</div>

		<div class="overflow-x-auto">
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
					<tr>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Ngày giao dịch
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Người chuyển khoản
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Người nhận
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							STK thụ hưởng
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Tổng tiền
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Mã giao dịch
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Mô tả
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Hành động
						</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
					<?php

					use Helpers\Format;

					if (empty($transactionData)) : ?>
						<tr>
							<td colspan="7" class="px-6 py-12 text-center text-gray-500">
								<i class="fas fa-inbox text-4xl mb-4"></i>
								<p class="text-lg">Không có giao dịch nào</p>
							</td>
						</tr>
					<?php else : ?>
						<?php foreach ($transactionData as $trans) : ?>
							<tr data-trans-id="<?= $trans['id'] ?>" id="trans-row-<?= $trans['id'] ?>">
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars(date('d-m-Y', strtotime($trans['payment_date']))) ?>
									</div>
								</td>
								<td class="px-6 py-4">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars($trans['payer_name']['username'] ?? 'N/A') ?>
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars($trans['receiver_name']['username'] ?? 'N/A') ?>
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars($trans['account_number'] ?? 'N/A') ?>
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars(Format::formatNumber($trans['amount']) ?? 'N/A') ?>
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars($trans['transaction_id'] ?? 'N/A') ?>
									</div>
								</td>
								<td width="15%" class="px-6 py-4 text-sm font-medium">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars($trans['description'] ?? 'N/A') ?>
									</div>
								</td>
								<td class="px-6 py-4 text-sm font-medium">
									<div class="flex items-center gap-4 px-6 py-4 whitespace-nowrap">
										<button class="text-blue-600 hover:text-blue-700 text-sm font-medium view-details"
											data-payment='<?= json_encode($trans) ?>'
											title="Xem chi tiết">
											<i class="fas fa-eye"></i>		
										</button>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>

		<!-- Pagination -->
		<?php if (!empty($pagination) && $pagination['total_pages'] > 1) : ?>
			<?= \Helpers\Pagination::render($pagination, BASE_URL . '/admin/transactions', $queryParams) ?>
		<?php endif; ?>
	</div>
	<?php include_once VIEW_PATH . 'partials/edit-post.php'; ?>
</div>
<!--  -->
<!-- Payment Details Modal -->
<div id="paymentModal" class="hidden fixed inset-0 z-50 justify-center items-center w-full h-full overflow-y-auto bg-black/40">
	<div class="flex items-center justify-center min-h-screen p-4">
		<div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
			<div class="px-6 py-4 border-b border-gray-200">
				<div class="flex items-center justify-between">
					<h3 class="text-lg font-semibold text-gray-900">Chi tiết giao dịch</h3>
					<button id="closeModal" class="text-gray-400 hover:text-gray-600">
						<i class="fas fa-times text-xl"></i>
					</button>
				</div>
			</div>

			<div id="modalContent" class="px-6 py-4">
				<!-- Content will be populated by JavaScript -->
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		const modal = document.getElementById('paymentModal');
		const modalContent = document.getElementById('modalContent');
		const closeModal = document.getElementById('closeModal');

		// View payment details
		document.querySelectorAll('.view-details').forEach(button => {
			button.addEventListener('click', function() {
				const payment = JSON.parse(this.getAttribute('data-payment'));
				showPaymentDetails(payment);
			});
		});

		// Close modal
		closeModal.addEventListener('click', function() {
			modal.classList.add('hidden');
		});

		// Close modal when clicking outside
		modal.addEventListener('click', function(e) {
			if (e.target === modal) {
				modal.classList.add('hidden');
			}
		});

		function showPaymentDetails(payment) {
			const statusConfig = {
				'success-paid': {
					class: 'bg-green-100 text-green-800',
					icon: 'fa-check',
					text: 'Thành công'
				},
				'failed': {
					class: 'bg-red-100 text-red-800',
					icon: 'fa-times',
					text: 'Thất bại'
				},
			};

			const status = statusConfig[payment.status] || statusConfig.failed;

			modalContent.innerHTML = `
            <div class="space-y-6">
                <!-- Transaction Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mã giao dịch</label>
                        <p class="text-sm text-gray-900 font-mono">${payment.transaction_id || payment.order_id || 'N/A'}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mã tham chiếu</label>
                        <p class="text-sm text-gray-900">${payment.referenceCode || 'N/A'}</p>
                    </div>
                </div>
                
                <!-- Invoice Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hóa đơn</label>
                        <p class="text-sm text-gray-900">${payment.invoice.invoice_name || 'N/A'}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tháng</label>
                        <p class="text-sm text-gray-900">${payment.invoice.invoice_month || 'N/A'}</p>
                    </div>
                </div>
                
                <!-- Room Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phòng</label>
                        <p class="text-sm text-gray-900">${payment.room.room_name || 'N/A'}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nhà trọ</label>
                        <p class="text-sm text-gray-900">${payment.house.house_name || 'N/A'}</p>
                    </div>
                </div>
                
                <!-- Payment Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Số tiền</label>
                        <p class="text-lg font-semibold text-gray-900">${new Intl.NumberFormat('vi-VN').format(payment.amount)} VNĐ</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cổng thanh toán</label>
                        <p class="text-sm text-gray-900">${payment.gateway || 'N/A'}</p>
                    </div>
                </div>
                
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <span class="${status.class} text-xs px-2 py-1 rounded-full">
                        <i class="fas ${status.icon} mr-1"></i>${status.text}
                    </span>
                </div>
                
                <!-- Dates -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ngày thanh toán</label>
                        <p class="text-sm text-gray-900">${new Date(payment.payment_date).toLocaleDateString('vi-VN')}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Thời gian tạo</label>
                        <p class="text-sm text-gray-900">${new Date(payment.created_at).toLocaleString('vi-VN')}</p>
                    </div>
                </div>
                
                <!-- Description -->
                ${payment.description ? `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                    <p class="text-sm text-gray-900">${payment.description}</p>
                </div>
                ` : ''}
                
                <!-- Account Number -->
                ${payment.account_number ? `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Số tài khoản</label>
                    <p class="text-sm text-gray-900 font-mono">${payment.account_number}</p>
                </div>
                ` : ''}
            </div>
        `;

			modal.classList.remove('hidden');
		}
	});
</script>