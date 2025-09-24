<!--
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Customer payment history page
-->

<!-- Payment History Header -->
<div class="mb-8">
	<h1 class="text-3xl font-bold text-gray-900 mb-2">Lịch sử thanh toán</h1>
	<p class="text-gray-600">Xem lại tất cả các giao dịch thanh toán của bạn</p>
</div>
<!-- Payment History List -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
	<?php if (!empty($paymentHistory)): ?>
		<!-- Table Header -->
		<div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
			<div class="grid grid-cols-12 gap-4 text-sm font-medium text-gray-700">
				<div class="col-span-2">Mã giao dịch</div>
				<div class="col-span-2">Hóa đơn</div>
				<div class="col-span-1">Phòng</div>
				<div class="col-span-2">Số tiền</div>
				<div class="col-span-1">Cổng thanh toán</div>
				<div class="col-span-2">Trạng thái</div>
				<div class="col-span-1">Ngày thanh toán</div>
				<div class="col-span-1">Thao tác</div>
			</div>
		</div>

		<!-- Table Body -->
		<div class="divide-y divide-gray-200">
			<?php foreach ($paymentHistory as $payment): ?>
				<?php
				$statusConfig = [
					'success-paid' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'fa-check', 'text' => 'Thành công'],
					'failed' => ['class' => 'bg-red-100 text-red-800', 'icon' => 'fa-times', 'text' => 'Thất bại'],
				];
				$status = $statusConfig[$payment['status']] ?? $statusConfig['failed'];
				?>

				<div class="px-6 py-4 hover:bg-gray-50 transition-colors">
					<div class="grid grid-cols-12 gap-4 items-center">
						<!-- Transaction ID -->
						<div class="col-span-2">
							<p class="font-mono text-sm text-gray-900"><?= htmlspecialchars($payment['transaction_id'] ?? $payment['order_id'] ?? 'N/A') ?></p>
							<?php if ($payment['referenceCode']): ?>
								<p class="text-xs text-gray-500">Ref: <?= htmlspecialchars($payment['referenceCode']) ?></p>
							<?php endif; ?>
						</div>

						<!-- Invoice Info -->
						<div class="col-span-2">
							<p class="font-semibold text-gray-900"><?= htmlspecialchars($payment['invoice_name'] ?? 'N/A') ?></p>
							<p class="text-sm text-gray-500"><?= htmlspecialchars($payment['invoice_month'] ?? '') ?></p>
						</div>

						<!-- Room Info -->
						<div class="col-span-1">
							<p class="text-sm text-gray-900"><?= htmlspecialchars($payment['room_name'] ?? 'N/A') ?></p>
							<p class="text-xs text-gray-500"><?= htmlspecialchars($payment['house_name'] ?? '') ?></p>
						</div>

						<!-- Amount -->
						<div class="col-span-2">
							<p class="font-semibold text-gray-900"><?= \Helpers\Format::formatUnit($payment['amount']) ?> VNĐ</p>
						</div>

						<!-- Gateway -->
						<div class="col-span-1">
							<div class="flex items-center text-sm text-gray-600">
								<span><?= $payment['gateway'] ?></span>
							</div>
						</div>

						<!-- Status -->
						<div class="col-span-2">
							<span class="<?= $status['class'] ?> text-xs px-2 py-1 rounded-full">
								<i class="fas <?= $status['icon'] ?> mr-1"></i><?= $status['text'] ?>
							</span>
						</div>

						<!-- Payment Date -->
						<div class="col-span-1">
							<p class="text-sm text-gray-900"><?= date('d/m/Y', strtotime($payment['payment_date'])) ?></p>
						</div>

						<!-- Actions -->
						<div class="col-span-1">
							<button class="text-blue-600 hover:text-blue-700 text-sm font-medium view-details"
								data-payment='<?= json_encode($payment) ?>'
								title="Xem chi tiết">
								<i class="fas fa-eye"></i>
							</button>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Pagination -->
		<?php if ($pagination['total_pages'] > 1): ?>
			<div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
				<div class="flex items-center justify-between">
					<div class="text-sm text-gray-700">
						Hiển thị <?= (($pagination['current_page'] - 1) * $pagination['items_per_page']) + 1 ?> -
						<?= min($pagination['current_page'] * $pagination['items_per_page'], $pagination['total_items']) ?>
						trong tổng số <?= $pagination['total_items'] ?> giao dịch
					</div>

					<div class="flex items-center space-x-2">
						<?php
						// Get current query parameters and remove 'page' to avoid duplication
						$currentParams = $request->get();
						unset($currentParams['page']);
						$queryString = http_build_query($currentParams);
						?>

						<?php if ($pagination['has_prev']): ?>
							<a href="?page=<?= $pagination['prev_page'] ?><?= $queryString ? '&' . $queryString : '' ?>"
								class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
								<i class="fas fa-chevron-left"></i>
							</a>
						<?php endif; ?>

						<?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['total_pages'], $pagination['current_page'] + 2); $i++): ?>
							<a href="?page=<?= $i ?><?= $queryString ? '&' . $queryString : '' ?>"
								class="px-3 py-2 text-sm font-medium <?= $i === $pagination['current_page'] ? 'text-white bg-green-600' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-50' ?> rounded-lg">
								<?= $i ?>
							</a>
						<?php endfor; ?>

						<?php if ($pagination['has_next']): ?>
							<a href="?page=<?= $pagination['next_page'] ?><?= $queryString ? '&' . $queryString : '' ?>"
								class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
								<i class="fas fa-chevron-right"></i>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

	<?php else: ?>
		<!-- Empty State -->
		<div class="text-center py-12">
			<div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
				<i class="fas fa-receipt text-gray-400 text-3xl"></i>
			</div>
			<h3 class="text-xl font-semibold text-gray-900 mb-2">Chưa có giao dịch nào</h3>
			<p class="text-gray-600 mb-6">Bạn chưa có giao dịch thanh toán nào. Hãy thanh toán hóa đơn để xem lịch sử.</p>
			<a href="<?= BASE_URL ?>/customer/bills" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
				<i class="fas fa-file-invoice mr-2"></i>Xem hóa đơn
			</a>
		</div>
	<?php endif; ?>
</div>

<!-- Payment Details Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
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
                        <p class="text-sm text-gray-900">${payment.invoice_name || 'N/A'}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tháng</label>
                        <p class="text-sm text-gray-900">${payment.invoice_month || 'N/A'}</p>
                    </div>
                </div>
                
                <!-- Room Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phòng</label>
                        <p class="text-sm text-gray-900">${payment.room_name || 'N/A'}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nhà trọ</label>
                        <p class="text-sm text-gray-900">${payment.house_name || 'N/A'}</p>
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