<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
<!-- Main modal -->
<button id="invoiceDetailModalBtn" data-modal-target="invoiceDetailModal" data-modal-toggle="invoiceDetailModal" class="w-1 h-1 hidden"></button>
<div id="invoiceDetailModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="flex items-center justify-center min-h-screen p-4">
		<div class="bg-white rounded-lg w-[600px] max-h-[90vh] overflow-y-auto">
			<div class="p-6 border-b border-gray-200">
				<div class="flex items-center justify-between">
					<h2 class="text-xl font-bold text-gray-900">Chi tiết hóa đơn</h2>
					<button id="closeBillDetailModal" data-modal-hide="invoiceDetailModal" class="text-gray-400 hover:text-gray-600 cursor-pointer">
						<i class="fas fa-times text-xl"></i>
					</button>
				</div>
			</div>
			<div class="p-6">
				<div class="space-y-6">
					<div class="text-center">
						<h3 class="text-2xl font-bold text-gray-900 mb-2 invoice-title"></h3>
						<p class="text-gray-600 invoice-room-house-name">Phòng 101 - Chung cư ABC</p>
						<p class="text-3xl font-bold text-red-600 mt-4 invoice-total-fee">2.5M VNĐ</p>
					</div>

					<div class="grid grid-cols-2 gap-6">
						<div>
							<h4 class="font-medium text-gray-900 mb-3">Thông tin hóa đơn</h4>
							<div class="bg-gray-50 p-4 rounded-lg">
								<div class="space-y-2 text-sm">
									<div class="flex justify-between">
										<span class="text-gray-600">Số hóa đơn:</span>
										<span class="font-medium invoice-no">HD-2024-001</span>
									</div>
									<div class="flex justify-between">
										<span class="text-gray-600">Ngày tạo:</span>
										<span class="font-medium invoice-created">01/01/2025</span>
									</div>
									<div class="flex justify-between">
										<span class="text-gray-600">Hạn thanh toán:</span>
										<span class="font-medium text-red-600 invoice-overdue">05/01/2025</span>
									</div>
									<div class="flex justify-between">
										<span class="text-gray-600">Trạng thái:</span>
										<span class="text-red-600 font-medium invoice-status">Chưa thanh toán</span>
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
										<span class="font-medium invoice-room-name">Phòng 101</span>
									</div>
									<div class="flex justify-between">
										<span class="text-gray-600">Địa chỉ:</span>
										<span class="font-medium invoice-house-name">Chung cư ABC</span>
									</div>
									<div class="flex justify-between">
										<span class="text-gray-600">Tháng:</span>
										<span class="font-medium invoice-month">01/2025</span>
									</div>
									<div class="flex justify-between">
										<span class="text-gray-600">Diện tích:</span>
										<span class="font-medium invoice-area">25m²</span>
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
									<span class="text-gray-600 invoice-detail-title">Tiền phòng tháng 01/2025:</span>
									<span class="font-medium invoice-room-price">2.5M VNĐ</span>
								</div>
								<div class="flex justify-between">
									<span class="text-gray-600">Tiền điện:</span>
									<span class="font-medium invoice-electronic-fee">0 VNĐ</span>
								</div>
								<div class="flex justify-between">
									<span class="text-gray-600">Tiền nước:</span>
									<span class="font-medium invoice-warter-fee">0 VNĐ</span>
								</div>
								<div class="flex justify-between">
									<span class="text-gray-600">Tiền rác:</span>
									<span class="font-medium invoice-garbage-fee">0 VNĐ</span>
								</div>
								<div class="flex justify-between">
									<span class="text-gray-600">Tiền mạng:</span>
									<span class="font-medium invoice-internet-fee">0 VNĐ</span>
								</div>
								<div class="flex justify-between">
									<span class="text-gray-600">Tiền xe:</span>
									<span class="font-medium invoice-parking-fee">0 VNĐ</span>
								</div>
								<div class="flex justify-between">
									<span class="text-gray-600">Phí dịch vụ:</span>
									<span class="font-medium invoice-service-fee">0 VNĐ</span>
								</div>
								<div class="flex justify-between">
									<span class="text-gray-600">Phí khác:</span>
									<span class="font-medium invoice-orther-fee">0 VNĐ</span>
								</div>
								<hr class="border-gray-300">
								<div class="flex justify-between text-lg font-bold">
									<span>Tổng cộng:</span>
									<span class="text-red-600 invoice-total-fee">2.5M VNĐ</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="p-6 border-t border-gray-200 flex justify-end gap-3">
				<button data-modal-hide="invoiceDetailModal" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
					Đóng
				</button>
				<button onclick="downloadInvoice(this)" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors invoice-download" data-invoice-id="">
					<i class="fas fa-download mr-2"></i>Tải xuống
				</button>
			</div>
		</div>
	</div>
</div>