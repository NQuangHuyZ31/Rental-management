<div id="customerSupportResolvedModal" role="dialog" aria-modal="true" aria-labelledby="customerSupportResolvedTitle"
	class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
	<div class="w-full max-w-xl transform rounded-lg bg-white shadow-xl ring-1 ring-black/5 transition-all duration-200 scale-95">
		<form id="customerSupportResolvedForm" class="overflow-hidden">
			<input type="hidden" name="customer_support_id" id="customer_support_id" value="">

			<!-- Header -->
			<div class="flex items-center justify-between gap-3 px-6 py-4 border-b">
				<div class="flex items-center gap-3">
					<div>
						<h3 id="rejectPostTitle" class="text-lg font-semibold text-gray-900">Hỗ trợ khách hàng</h3>
						<p class="text-sm text-gray-500">Yêu cầu xử lý hỗ trợ khách hàng.</p>
					</div>
				</div>

				<button type="button" data-modal-hide="customerSupportResolvedModal" aria-label="Đóng"
					class="rounded-md p-2 text-gray-500 hover:bg-gray-100">
					✕
				</button>
			</div>

			<!-- Body -->
			<div class="px-6 py-5 space-y-4">
				<div>
					<label for="problem_support" class="block text-lg font-medium text-gray-700">Vấn đề cần hỗ trợ</label>
					<textarea id="problem_support" name="problem_support" rows="3" class="mt-1 block w-full rounded-md border border-gray-500 bg-white p-2 text-sm shadow-sm focus:ring-2 focus:ring-red-100" readonly></textarea>
				</div>
				<div>
					<label for="resolved_type" class="block text-lg font-medium text-gray-700">Cách hỗ trợ</label>
					<select id="resolved_type" name="resolved_type" required
						class="mt-1 block w-full rounded-md border border-gray-400 bg-white p-2 text-sm shadow-sm focus:ring-2 focus:ring-red-100">
						<option value="">-- Chọn --</option>
						<option value="Gọi điện thoại">Gọi điện thoại</option>
						<option value="Gửi email">Gửi email</option>
						<option value="Xử lý trực tiếp">Xử lý trực tiếp</option>
						<option value="Khác">Khác...</option>
					</select>
				</div>

				<div>
					<label for="resolved_content" id="resolved_content_label" class="block text-lg font-medium text-gray-700">Nội dung hỗ trợ</label>
					<textarea id="resolved_content" name="resolved_content" rows="5" required
						class="mt-1 block w-full rounded-md border border-gray-400 bg-white p-3 text-sm shadow-sm focus:ring-2 focus:ring-red-100"
						placeholder="Mô tả chi tiết hỗ trợ (bắt buộc)"><?= htmlspecialchars($resolved_content, ENT_QUOTES, 'UTF-8') ?></textarea>
					<div class="mt-2 flex items-center justify-between text-xs text-gray-500">
					</div>
				</div>
			</div>

			<!-- Footer -->
			<div class="flex items-center justify-end gap-3 px-6 py-4 border-t bg-gray-50">
				<button type="button" data-modal-hide="customerSupportResolvedModal"
					class="rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">Hủy</button>

				<button id="confirmResolveBtn" type="button"
					class="rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white opacity-60 cursor-not-allowed hover:opacity-100">Xác nhận</button>
			</div>
		</form>
	</div>
</div>