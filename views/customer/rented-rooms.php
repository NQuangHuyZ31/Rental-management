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

<!-- Filter and Search Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex flex-col lg:flex-row gap-4">
        <div class="flex-1">
            <input type="text" placeholder="Tìm kiếm phòng..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
        </div>
        <div class="flex gap-3">
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option value="">Tất cả trạng thái</option>
                <option value="active">Đang thuê</option>
                <option value="expiring">Sắp hết hạn</option>
                <option value="expired">Đã hết hạn</option>
            </select>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <option value="">Sắp xếp theo</option>
                <option value="price_asc">Giá tăng dần</option>
                <option value="price_desc">Giá giảm dần</option>
                <option value="expiry_asc">Hết hạn sớm nhất</option>
                <option value="expiry_desc">Hết hạn muộn nhất</option>
            </select>
        </div>
    </div>
</div>

<!-- Rented Rooms Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (!empty($rentedRooms)): ?>
        <?php foreach ($rentedRooms as $index => $room): ?>
            <?php 
            $gradientColors = [
                'from-green-400 to-blue-500',
                'from-yellow-400 to-orange-500', 
                'from-purple-400 to-pink-500',
                'from-blue-400 to-indigo-500',
                'from-red-400 to-pink-500'
            ];
            $gradientClass = $gradientColors[$index % count($gradientColors)];
            
            $statusConfig = [
                'active' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'fa-check', 'text' => 'Đang thuê'],
                'expiring' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-clock', 'text' => 'Sắp hết hạn'],
                'expired' => ['class' => 'bg-red-100 text-red-800', 'icon' => 'fa-times', 'text' => 'Đã hết hạn']
            ];
            $status = $statusConfig[$room['status']] ?? $statusConfig['active'];
            
            $progressColor = $room['status'] === 'expiring' ? 'bg-yellow-600' : 'bg-green-600';
            ?>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="h-48 bg-gradient-to-br <?= $gradientClass ?> relative">
                    <div class="absolute top-4 right-4">
                        <span class="<?= $status['class'] ?> text-xs px-2 py-1 rounded-full">
                            <i class="fas <?= $status['icon'] ?> mr-1"></i><?= $status['text'] ?>
                        </span>
                    </div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <p class="text-2xl font-bold"><?= $room['price'] ?> VNĐ</p>
                        <p class="text-sm opacity-90">/tháng</p>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2"><?= htmlspecialchars($room['name']) ?></h3>
                    <p class="text-gray-600 text-sm mb-3">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        <?= htmlspecialchars($room['address']) ?>
                    </p>
                    
                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                        <span><i class="fas fa-expand-arrows-alt mr-1"></i><?= $room['area'] ?></span>
                        <span><i class="fas fa-bed mr-1"></i><?= $room['beds'] ?> giường</span>
                        <span><i class="fas fa-bath mr-1"></i><?= $room['baths'] ?> WC</span>
                    </div>
                    
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Hợp đồng còn lại:</span>
                            <span class="font-medium text-gray-900"><?= $room['contract_remaining'] ?></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="<?= $progressColor ?> h-2 rounded-full" style="width: <?= $room['contract_progress'] ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="<?= BASE_URL ?>/customer/room-detail/<?= $room['id'] ?>" 
                           class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-eye mr-1"></i>Xem chi tiết
                        </a>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors contact-landlord" 
                                data-phone="<?= $room['landlord_phone'] ?>">
                            <i class="fas fa-phone"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Empty State -->
        <div class="col-span-full text-center py-12">
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
    // Search functionality
    const searchInput = document.querySelector('input[placeholder="Tìm kiếm phòng..."]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const roomCards = document.querySelectorAll('.grid > div');
            
            roomCards.forEach(card => {
                const roomName = card.querySelector('h3').textContent.toLowerCase();
                const roomAddress = card.querySelector('p').textContent.toLowerCase();
                
                if (roomName.includes(searchTerm) || roomAddress.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Filter functionality
    const statusFilter = document.querySelector('select');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;
            const roomCards = document.querySelectorAll('.grid > div');
            
            roomCards.forEach(card => {
                const statusBadge = card.querySelector('span');
                const statusText = statusBadge.textContent.toLowerCase();
                
                if (selectedStatus === '' || 
                    (selectedStatus === 'active' && statusText.includes('đang thuê')) ||
                    (selectedStatus === 'expiring' && statusText.includes('sắp hết hạn')) ||
                    (selectedStatus === 'expired' && statusText.includes('đã hết hạn'))) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Sort functionality
    const sortSelect = document.querySelectorAll('select')[1];
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortBy = this.value;
            const container = document.querySelector('.grid');
            const roomCards = Array.from(container.children);
            
            roomCards.sort((a, b) => {
                switch(sortBy) {
                    case 'price_asc':
                        return parseFloat(a.querySelector('.text-2xl').textContent) - parseFloat(b.querySelector('.text-2xl').textContent);
                    case 'price_desc':
                        return parseFloat(b.querySelector('.text-2xl').textContent) - parseFloat(a.querySelector('.text-2xl').textContent);
                    case 'expiry_asc':
                        // Sort by contract remaining time (simplified)
                        return a.querySelector('.font-medium').textContent.localeCompare(b.querySelector('.font-medium').textContent);
                    case 'expiry_desc':
                        return b.querySelector('.font-medium').textContent.localeCompare(a.querySelector('.font-medium').textContent);
                    default:
                        return 0;
                }
            });
            
            roomCards.forEach(card => container.appendChild(card));
        });
    }

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