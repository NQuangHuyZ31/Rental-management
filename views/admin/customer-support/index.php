<?php

use Core\CSRF;
?>
<!-- 
    Author: Huy Nguyen
    Date: 2025-09-09
    Purpose: Posts for admin
-->

<!-- Page Header -->
<div class="p-3">
	<input type="hidden" name="role" value="admin">
	<?= CSRF::getTokenField() ?>
	<div class="mb-8">
		<div class="flex items-center justify-between">
			<div>
				<h1 class="text-3xl font-bold text-gray-900">Hỗ trợ khách hàng</h1>
				<p class="mt-2 text-gray-600">Quản lý tất cả yêu cầu hỗ trợ từ khách hàng</p>
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
							<!-- Customer support icon -->
							<svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h12M8 12h12M8 18h12M4 6h.01M4 12h.01M4 18h.01" />
							</svg>
						</div>
					</div>
					<div class="ml-5 w-0 flex-1">
						<dl>
							<dt class="text-sm font-medium text-gray-500 truncate">Tổng yêu cầu hỗ trợ</dt>
							<dd class="text-lg font-medium text-gray-900"><?= htmlspecialchars($allcs ?? 0, ENT_QUOTES, 'UTF-8') ?></dd>
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
							<dt class="text-sm font-medium text-gray-500 truncate">Yêu cầu hỗ trợ trong tháng</dt>
							<dd class="text-lg font-medium text-gray-900"><?= htmlspecialchars($allcsThisMonth ?? 0, ENT_QUOTES, 'UTF-8') ?></dd>
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
							<dt class="text-sm font-medium text-gray-500 truncate">Xử lý</dt>
							<dd class="text-lg font-medium text-gray-900"><?= htmlspecialchars($totalcsResolved ?? 0, ENT_QUOTES, 'UTF-8') ?></dd>
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
							Ngày gửi
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Tên
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							SĐT
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Loại
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Mô tả vấn đề
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Tình trạng
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Người xử lý
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Ngày xử lý
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Mô tả xử lý
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
							Hành động
						</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
					<?php
					if (empty($csData)) : ?>
						<tr>
							<td colspan="10" class="px-6 py-12 text-center text-gray-500">
								<i class="fas fa-inbox text-4xl mb-4"></i>
								<p class="text-lg">Không có yêu cầu hỗ trợ nào</p>
							</td>
						</tr>
					<?php else : ?>
						<?php foreach ($csData as $cs) : ?>
							<tr data-cs-id="<?= $cs['id'] ?>" id="cs-row-<?= $cs['id'] ?>">
								<td class="px-6 py-4 text-sm font-medium">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars(date('d-m-Y', strtotime($cs['created_at']))) ?>
									</div>
								</td>
								<td class="px-6 py-4">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars($cs['customer_name'] ?? 'N/A') ?>
									</div>
								</td>
								<td class="px-6 py-4">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars($cs['customer_phone'] ?? 'N/A') ?>
									</div>
								</td>
								<td class="px-6 py-4">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars($cs['support_type'] ?? 'N/A') ?>
									</div>
								</td>
								<td class="px-6 py-4 text-sm text-gray-900">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars($cs['description_problem'] ?? 'N/A') ?>
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm font-medium text-gray-900 border px-2 py-1 rounded-full text-center <?= !empty($cs['date_process']) ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
										<?= htmlspecialchars(!empty($cs['date_process']) ? 'Đã xử lý' : 'Chưa xử lý') ?>
									</div>
								</td>
								<td class="px-6 py-4 text-sm text-gray-500">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars($cs['user_process_name']['username'] ?? 'N/A') ?>
									</div>
								</td>
								<td class="px-6 py-4 text-sm font-medium">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars(!empty($cs['date_process']) ? date('d-m-Y', strtotime($cs['date_process'])) : 'N/A') ?>
									</div>
								</td>
								<td class="px-6 py-4 text-sm font-medium">
									<div class="text-sm font-medium text-gray-900">
										<?= htmlspecialchars(!empty($cs['description_process']) ? $cs['description_process'] : 'N/A') ?>
									</div>
								</td>
								<td class="px-6 py-4 text-sm font-medium">
									<div class="flex items-center gap-4 px-6 py-4">
										<?php if (empty($cs['date_process'])) : ?>
											<button class="text-blue-600 hover:text-blue-700 text-sm font-medium resolve-customer-support" data-modal-target="customerSupportResolvedModal" data-modal-toggle="customerSupportResolvedModal"
												title="Xử lý hỗ trợ" onclick="showCSDetail('<?= $cs['description_problem'] ?>')">
												<i class="fas fa-tools"></i>
											</button>
										<?php endif; ?>
										<button class="text-red-600 hover:text-red-700 text-sm font-medium resolve-customer-support"
											title="Xóa hỗ trợ" onclick="deleteCS('<?= $cs['id'] ?>')">
											<i class="fas fa-trash"></i>
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
			<?= \Helpers\Pagination::render($pagination, BASE_URL . '/admin/customer-supports', []) ?>
		<?php endif; ?>
	</div>
</div>

<?php include_once VIEW_PATH . '/partials/customer-support-resolved-modal.php' ?>