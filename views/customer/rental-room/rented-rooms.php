<!--
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Customer rented rooms list page
-->

<!-- Rented Rooms Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Phòng đang thuê</h1>
    <p class="text-gray-600">Danh sách các phòng bạn đang thuê</p>
</div>

<!-- Rented Rooms List -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <?php if (!empty($rentedRooms)): ?>
        <!-- Table Header -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <div class="grid grid-cols-12 gap-4 text-sm font-medium text-gray-700">
                <div class="col-span-2">Phòng</div>
                <div class="col-span-2">Địa chỉ</div>
                <div class="col-span-2">Giá</div>
                <div class="col-span-1">Diện tích</div>
                <div class="col-span-2">Ngày vào ở</div>
                <div class="col-span-2">Trạng thái</div>
                <div class="col-span-1">Thao tác</div>
            </div>
        </div>
        
        <!-- Table Body -->
        <div class="divide-y divide-gray-200">
            <?php foreach ($rentedRooms as $room): ?>
                <?php 
                $statusConfig = [
                    'active' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'fa-check', 'text' => 'Đang thuê'],
                    'expiring' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-clock', 'text' => 'Sắp hết hạn'],
                    'expired' => ['class' => 'bg-red-100 text-red-800', 'icon' => 'fa-times', 'text' => 'Đã hết hạn']
                ];
                $status = $statusConfig[$room['room_status']] ?? $statusConfig['active'];
                
                $progressColor = $room['room_status'] === 'expiring' ? 'bg-yellow-600' : ($room['room_status'] === 'expired' ? 'bg-red-600' : 'bg-green-600');
                ?>
                
                <div class="px-6 py-4 hover:bg-gray-50 transition-colors room-item" 
                     data-room-name="<?= strtolower(htmlspecialchars($room['room_name'])) ?>"
                     data-room-address="<?= strtolower(htmlspecialchars($room['address'])) ?>"
                     data-room-status="<?= $room['room_status'] ?>"
                     data-room-price="<?= $room['price'] ?>"
                     data-room-expiry="<?= $room['expected_leave_date'] ?>">
                    
                    <div class="grid grid-cols-12 gap-4 items-center">
                        <!-- Room Info -->
                        <div class="col-span-2">
                            <div class="flex items-center space-x-2">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-home text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900"><?= htmlspecialchars($room['room_name']) ?></h3>
                                    <p class="text-sm text-gray-500"><?= htmlspecialchars($room['house_name']) ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Address -->
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600 truncate" title="<?= htmlspecialchars($room['address']) ?>">
                                <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                                <?= htmlspecialchars($room['address']) ?>
                            </p>
                        </div>
                        
                        <!-- Price -->
                        <div class="col-span-2">
                            <p class="font-semibold text-gray-900"><?= \Helpers\Format::forMatPrice($room['room_price']) ?> VNĐ</p>
                            <p class="text-xs text-gray-500">/tháng</p>
                        </div>
                        
                        <!-- Area -->
                        <div class="col-span-1">
                            <p class="text-sm text-gray-600"><?= $room['area'] ?> m<sup>2</sup></p>
                        </div>
                        
                        <!-- Date start  -->
                        <div class="col-span-2">
                            <div class="flex items-center space-x-2 text-sm text-gray-600">
                                <span><i class="fas fa-calendar mr-1"></i><?= date('d/m/Y', strtotime($room['join_date'])) ?></span>
                            </div>
                        </div>
                        
                        <!-- Status -->
                        <div class="col-span-2">
                            <span class="<?= $status['class'] ?> text-xs px-2 py-1 rounded-full">
                                <i class="fas <?= $status['icon'] ?> mr-1"></i><?= $status['text'] ?>
                            </span>
                        </div>
                        
                        <!-- Actions -->
                        <div class="col-span-1">
                            <div class="flex items-center space-x-2">
                                <a href="<?= BASE_URL ?>/customer/room-detail/<?= $room['id'] ?>" 
                                   class="text-green-600 hover:text-green-700 text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i>Xem
                                </a>
                                <button class="text-blue-600 hover:text-blue-700 text-sm font-medium contact-landlord" 
                                        data-phone="<?= $room['phone'] ?>"
                                        title="Liên hệ chủ nhà">
                                    <i class="fas fa-phone"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-home text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Chưa có phòng nào</h3>
            <p class="text-gray-600 mb-6">Bạn chưa thuê phòng nào. Hãy tìm kiếm và thuê phòng phù hợp với bạn.</p>
            <a href="<?= BASE_URL ?>/" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-search mr-2"></i>Tìm phòng ngay
            </a>
        </div>
    <?php endif; ?>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    // Contact landlord functionality
    document.querySelectorAll('.contact-landlord').forEach(button => {
        button.addEventListener('click', function() {
            const phoneNumber = this.getAttribute('data-phone');
            if (confirm(`Bạn có muốn gọi cho chủ nhà (${phoneNumber}) không?`)) {
                window.open(`tel:${phoneNumber}`, '_self');
            }
        });
    });
});
</script>