<div id="rejectPostModal" role="dialog" aria-modal="true" aria-labelledby="rejectPostTitle"
	class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
	<div class="w-full max-w-xl transform rounded-lg bg-white shadow-xl ring-1 ring-black/5 transition-all duration-200 scale-95">
		<form id="rejectPostForm" method="post" action="<?= htmlspecialchars(BASE_URL ?? '', ENT_QUOTES, 'UTF-8') ?>/admin/posts/reject" class="overflow-hidden">
			<input type="hidden" name="post_id" id="reject_post_id" value="<?= htmlspecialchars($postId, ENT_QUOTES, 'UTF-8') ?>">

			<!-- Header -->
			<div class="flex items-center justify-between gap-3 px-6 py-4 border-b">
				<div class="flex items-center gap-3">
					<div>
						<h3 id="rejectPostTitle" class="text-lg font-semibold text-gray-900">Từ chối bài đăng</h3>
						<p class="text-sm text-gray-500">Gửi lý do cho người đăng và thay đổi trạng thái bài viết.</p>
					</div>
				</div>

				<button type="button" data-modal-hide="rejectPostModal" aria-label="Đóng"
					class="rounded-md p-2 text-gray-500 hover:bg-gray-100">
					✕
				</button>
			</div>

			<!-- Body -->
			<div class="px-6 py-5 space-y-4">
				<div>
					<label for="violation_type" class="block text-lg font-medium text-gray-700">Nguyên nhân từ chối</label>
					<select id="violation_type" name="violation_type" required
						class="mt-1 block w-full rounded-md border-gray-200 bg-white p-2 text-sm shadow-sm focus:ring-2 focus:ring-red-100">
						<option value="">-- Chọn --</option>
						<option value="Giả mạo">Giả mạo</option>
						<option value="Thông tin sai">Thông tin sai</option>
						<option value="Nội dung không phù hợp">Nội dung không phù hợp</option>
						<option value="Vi phạm quy tắc">Vi phạm quy tắc</option>
						<option value="Spam">Spam</option>
						<option value="Khác">Khác...</option>
					</select>
				</div>

				<div>
					<label for="violation_content" class="block text-lg font-medium text-gray-700">Nội dung</label>
					<textarea id="violation_content" name="violation_content" rows="5" required
						class="mt-1 block w-full rounded-md border-gray-500 bg-white p-3 text-sm shadow-sm focus:ring-2 focus:ring-red-100"
						placeholder="Mô tả chi tiết lý do (bắt buộc)"><?= htmlspecialchars($violation_content, ENT_QUOTES, 'UTF-8') ?></textarea>
					<div class="mt-2 flex items-center justify-between text-xs text-gray-500">
					</div>
				</div>
			</div>

			<!-- Footer -->
			<div class="flex items-center justify-end gap-3 px-6 py-4 border-t bg-gray-50">
				<button type="button" data-modal-hide="rejectPostModal"
					class="rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">Hủy</button>

				<button id="confirmRejectBtn" type="button"
					class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white opacity-60 cursor-not-allowed hover:opacity-100">Xác nhận từ chối</button>
			</div>
		</form>
	</div>
</div>