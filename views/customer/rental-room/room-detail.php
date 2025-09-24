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
                <div class="flex items-center gap-2">
                    <label class="block text-sm font-medium text-gray-600">Tên phòng:</label>
                    <p class="text-sm font-semibold text-gray-600"><?= htmlspecialchars($roomDetail['room_name']) ?></p>
                </div>
                <div class="flex items-center gap-2">
                    <label class="block text-sm font-medium text-gray-600">Địa chỉ:</label>
                    <p class="text-sm font-semibold text-gray-600"><?= htmlspecialchars($roomDetail['address']) ?> - <?= htmlspecialchars($roomDetail['ward']) ?> - <?= htmlspecialchars($roomDetail['province']) ?></p>
                </div>
            </div>

            <!-- Room Specifications -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <label class="block text-sm font-medium text-gray-600">Diện tích:</label>
                    <p class="text-sm font-semibold text-gray-600"><?= htmlspecialchars($roomDetail['area']) ?>m<sup>2</sup></p>
                </div>
                <div class="flex items-center gap-2">
                    <label class="block text-sm font-medium text-gray-600">Giá thuê:</label>
                    <p class="text-lg font-bold text-green-600"><?= htmlspecialchars(\Helpers\Format::forMatPrice($roomDetail['room_price'])) ?> VNĐ</p>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <label class="block text-sm font-medium text-gray-600">Số người tối đa:</label>
                    <p class="text-sm font-semibold text-gray-600"><?= htmlspecialchars($roomDetail['max_people']) ?></p>
                </div>
                <div class="flex items-center gap-2">
                    <label class="block text-sm font-medium text-gray-600">Số người hiện tại:</label>
                    <p class="text-sm font-bold text-gray-600"><?= htmlspecialchars($currentTenants . '/' . $roomDetail['max_people']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Information Section -->
    <div class="p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Thông tin chi tiết</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Room Features & Amenities -->
            <div class="space-y-6">
                <!-- Amenities -->
                <div class="">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tiện ích</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <?php
                        foreach ($amenities as $amenity):
                        ?>
                            <div class=" p-3 bg-green-50 rounded-lg">
                                <i class="fas fa-check text-green-600"></i>
                                <span class="text-sm text-gray-900"><?= htmlspecialchars($amenity['amenity_name']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="gap-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin thanh toán</h3>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiền thuê hàng tháng:</span>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars(\Helpers\Format::forMatPrice($roomDetail['room_price'])) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiền cọc:</span>
                            <span class="font-medium text-gray-900"><?= htmlspecialchars(\Helpers\Format::forMatPrice($roomDetail['deposit'])) ?></span>
                        </div>
                        <?php if ($services): ?>
                            <?php foreach ($services as $service): ?>
                                <div class="flex justify-between">
                                    <span class="text-gray-600"><?= htmlspecialchars($service['service_name']) ?>:</span>
                                    <span class="font-medium text-gray-900"><?= htmlspecialchars(\Helpers\Format::forMatPrice($service['service_price'])) ?>/<?= htmlspecialchars($service['unit_vi']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="space-y-6">

                <!-- Landlord Information -->
                <div class="gap-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin chủ nhà</h3>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900"><?= htmlspecialchars($landlordInfor['username']) ?></div>
                                <div class="text-sm text-gray-600">Chủ nhà</div>
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-phone text-gray-500"></i>
                                <span class="text-gray-900"><?= htmlspecialchars($landlordInfor['phone']) ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-envelope text-gray-500"></i>
                                <span class="text-gray-900"><?= htmlspecialchars($landlordInfor['email']) ?></span>
                            </div>
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
                    const phoneNumber = '<?= $landlordInfor['phone'] ?>';
                    if (confirm(`Bạn có muốn gọi cho chủ nhà (${phoneNumber}) không?`)) {
                        window.open(`tel:${phoneNumber}`, '_self');
                    }
                });
            }
        });
    });
</script>