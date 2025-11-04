<!-- 
	Author: Huy Nguyen
	Date: 2025-10-21
	Purpose: delete account modal
-->

<div id="deleteAccountModal" tabindex="-1" aria-hidden="true"
	class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto 
  md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900/50 items-center justify-center">

	<div class="relative w-full max-w-md max-h-full">
		<div class="relative bg-white rounded-lg shadow dark:bg-gray-800">

			<!-- Header -->
			<div class="flex items-center justify-between p-4 border-b dark:border-gray-600">
				<h3 class="text-lg font-semibold text-gray-900 dark:text-white">
					Xác nhận xóa tài khoản
				</h3>
				<button type="button"
					class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 
          rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
					data-modal-hide="deleteAccountModal">
					✕
				</button>
			</div>

			<!-- Body -->
			<div class="p-6 space-y-4">
				<p class="text-sm text-gray-500 dark:text-gray-400">
					Hành động này <strong>không thể hoàn tác</strong>.
					Vui lòng nhập <span class="font-semibold text-red-500">DELETE</span> để xác nhận.
				</p>

				<input type="text" id="confirmDeleteInput"
					placeholder="Nhập DELETE để xác nhận"
					class="w-full p-2 border rounded-lg focus:ring-red-500 focus:border-red-500 text-gray-700 dark:text-gray-300 dark:bg-gray-700">
			</div>

			<!-- Footer -->
			<div class="flex justify-end p-4 space-x-3 border-t dark:border-gray-600">
				<button id="cancelDeleteAccount" data-modal-hide="deleteAccountModal"
					class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-600 dark:text-white">
					Hủy
				</button>

				<button id="confirmDeleteBtn" disabled
					class="px-4 py-2 text-white bg-red-500 rounded-lg opacity-50 cursor-not-allowed transition 
          hover:opacity-100 hover:cursor-pointer">
					Xác nhận xóa
				</button>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		const input = document.getElementById('confirmDeleteInput');
		const confirmBtn = document.getElementById('confirmDeleteBtn');

		input.addEventListener('input', () => {
			if (input.value.trim().toUpperCase() === 'DELETE') {
				confirmBtn.disabled = false;
				confirmBtn.classList.remove('opacity-50', 'cursor-not-allowed');
			} else {
				confirmBtn.disabled = true;
				confirmBtn.classList.add('opacity-50', 'cursor-not-allowed');
			}
		});
	});
</script>