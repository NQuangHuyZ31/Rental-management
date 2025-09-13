<!--
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Customer room detail page
-->

<!-- Room Detail Header -->
<div class="mb-8">
    <div class="flex items-center gap-4 mb-4">
        <a href="<?= BASE_URL ?>/customer/rented-rooms" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Chi tiết phòng thuê</h1>
    </div>
    <p class="text-gray-600">Thông tin chi tiết về phòng bạn đang thuê</p>
</div>

<!-- Room Detail Information -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- General Information Section -->
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Thông tin chung</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Room Basic Info -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên phòng</label>
                    <p class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($roomDetails['name']) ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                    <p class="text-gray-900"><?= htmlspecialchars($roomDetails['address']) ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Loại phòng</label>
                    <p class="text-gray-900"><?= htmlspecialchars($roomDetails['type']) ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <span class="inline-block bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">
                        <i class="fas fa-check mr-1"></i><?= htmlspecialchars($roomDetails['status']) ?>
                    </span>
                </div>
            </div>

            <!-- Room Specifications -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Diện tích</label>
                    <p class="text-gray-900"><?= htmlspecialchars($roomDetails['area']) ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Số giường</label>
                    <p class="text-gray-900"><?= htmlspecialchars($roomDetails['beds']) ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Số WC</label>
                    <p class="text-gray-900"><?= htmlspecialchars($roomDetails['baths']) ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Giá thuê</label>
                    <p class="text-2xl font-bold text-green-600"><?= htmlspecialchars($roomDetails['price']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Information Section -->
    <div class="p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Thông tin chi tiết</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Contract Information -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin hợp đồng</h3>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Số hợp đồng:</span>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($roomDetails['contract']['number']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ngày ký:</span>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($roomDetails['contract']['sign_date']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ngày bắt đầu:</span>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($roomDetails['contract']['start_date']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ngày kết thúc:</span>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($roomDetails['contract']['end_date']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Thời hạn:</span>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($roomDetails['contract']['duration']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Còn lại:</span>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($roomDetails['contract']['remaining']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Landlord Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin chủ nhà</h3>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900"><?= htmlspecialchars($roomDetails['landlord']['name']) ?></div>
                                <div class="text-sm text-gray-600">Chủ nhà</div>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-phone text-gray-500"></i>
                                <span class="text-gray-900"><?= htmlspecialchars($roomDetails['landlord']['phone']) ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-envelope text-gray-500"></i>
                                <span class="text-gray-900"><?= htmlspecialchars($roomDetails['landlord']['email']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Features & Amenities -->
            <div class="space-y-6">
                <!-- Amenities -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tiện ích</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <?php 
                        $amenityIcons = [
                            'WiFi miễn phí' => 'fa-wifi',
                            'Chỗ để xe' => 'fa-car',
                            'An ninh 24/7' => 'fa-shield-alt',
                            'Điều hòa' => 'fa-snowflake',
                            'TV' => 'fa-tv',
                            'Bếp nấu' => 'fa-utensils',
                            'Máy giặt' => 'fa-tshirt',
                            'Tủ lạnh' => 'fa-snowflake',
                            'Nước nóng' => 'fa-fire',
                            'Thang máy' => 'fa-elevator'
                        ];
                        foreach ($roomDetails['amenities'] as $amenity): 
                            $icon = $amenityIcons[$amenity] ?? 'fa-check';
                        ?>
                        <div class="flex items-center gap-2 p-3 bg-green-50 rounded-lg">
                            <i class="fas <?= $icon ?> text-green-600"></i>
                            <span class="text-sm text-gray-900"><?= htmlspecialchars($amenity) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Payment Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin thanh toán</h3>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiền thuê hàng tháng:</span>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($roomDetails['payment']['rent']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiền cọc:</span>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($roomDetails['payment']['deposit']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phí dịch vụ:</span>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($roomDetails['payment']['service_fee']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiền điện:</span>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($roomDetails['payment']['electricity']) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiền nước:</span>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars($roomDetails['payment']['water']) ?></span>
                        </div>
                        <div class="flex justify-between border-t pt-3">
                            <span class="text-gray-600 font-semibold">Tổng cộng:</span>
                            <span class="font-bold text-green-600"><?= htmlspecialchars($roomDetails['payment']['total']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex flex-wrap gap-3">
                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-phone mr-2"></i>Liên hệ chủ nhà
                </button>
                <button class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-calendar-plus mr-2"></i>Gia hạn hợp đồng
                </button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-file-invoice mr-2"></i>Xem hóa đơn
                </button>
                <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-sign-out-alt mr-2"></i>Trả phòng
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Contact landlord functionality
    document.querySelectorAll('button').forEach(button => {
        if (button.textContent.includes('Liên hệ chủ nhà')) {
            button.addEventListener('click', function() {
                const phoneNumber = '<?= $roomDetails['landlord']['phone'] ?>';
                if (confirm(`Bạn có muốn gọi cho chủ nhà (${phoneNumber}) không?`)) {
                    window.open(`tel:${phoneNumber}`, '_self');
                }
            });
        }
    });

    // Extend contract functionality
    document.querySelectorAll('button').forEach(button => {
        if (button.textContent.includes('Gia hạn hợp đồng')) {
            button.addEventListener('click', function() {
                if (confirm('Bạn có muốn gia hạn hợp đồng không?')) {
                    // Show loading
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang xử lý...';
                    this.disabled = true;

                    // Simulate API call
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                        toastr.success('Yêu cầu gia hạn đã được gửi thành công!');
                    }, 2000);
                }
            });
        }
    });

    // View bills functionality
    document.querySelectorAll('button').forEach(button => {
        if (button.textContent.includes('Xem hóa đơn')) {
            button.addEventListener('click', function() {
                window.location.href = '<?= BASE_URL ?>/customer/bills';
            });
        }
    });

    // Return room functionality
    document.querySelectorAll('button').forEach(button => {
        if (button.textContent.includes('Trả phòng')) {
            button.addEventListener('click', function() {
                if (confirm('Bạn có chắc chắn muốn trả phòng không? Hành động này không thể hoàn tác.')) {
                    // Show loading
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang xử lý...';
                    this.disabled = true;

                    // Simulate API call
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                        toastr.success('Yêu cầu trả phòng đã được gửi thành công!');
                    }, 2000);
                }
            });
        }
    });
});
</script>
