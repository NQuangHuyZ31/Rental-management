<!--
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Customer favorites page
-->

<!-- Favorites Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Phòng yêu thích</h1>
    <p class="text-gray-600">Danh sách các phòng bạn đã lưu và quan tâm</p>
</div>

<!-- Filter and Search -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Tìm kiếm theo tên phòng, địa chỉ..." 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="flex gap-2">
                <select class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Tất cả khu vực</option>
                    <option value="quan-1">Quận 1</option>
                    <option value="quan-3">Quận 3</option>
                    <option value="quan-7">Quận 7</option>
                </select>
                <select class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Tất cả giá</option>
                    <option value="0-2">Dưới 2 triệu</option>
                    <option value="2-3">2-3 triệu</option>
                    <option value="3-5">3-5 triệu</option>
                    <option value="5+">Trên 5 triệu</option>
                </select>
                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-search mr-2"></i>Tìm kiếm
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Favorites Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Favorite Room 1 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
        <div class="relative">
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <i class="fas fa-home text-gray-400 text-4xl"></i>
            </div>
            <button class="absolute top-3 right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                <i class="fas fa-heart text-sm"></i>
            </button>
            <div class="absolute bottom-3 left-3 bg-green-500 text-white px-2 py-1 rounded text-xs">
                <i class="fas fa-check mr-1"></i>Đã xác minh
            </div>
        </div>
        
        <div class="p-4">
            <h3 class="font-bold text-gray-900 mb-2">Phòng trọ giá rẻ - Quận 7</h3>
            <p class="text-sm text-gray-600 mb-3">
                <i class="fas fa-map-marker-alt mr-2"></i>
                789 Đường GHI, Phường JKL, Quận 7, TP.HCM
            </p>
            
            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                <span><i class="fas fa-bed mr-1"></i>1 phòng ngủ</span>
                <span><i class="fas fa-bath mr-1"></i>1 phòng tắm</span>
                <span><i class="fas fa-ruler-combined mr-1"></i>18m²</span>
            </div>
            
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-2xl font-bold text-green-600">1.5M VNĐ</p>
                    <p class="text-sm text-gray-600">/tháng</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Đã lưu</p>
                    <p class="text-xs text-gray-500">2 ngày trước</p>
                </div>
            </div>
            
            <div class="flex gap-2">
                <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-phone mr-2"></i>Liên hệ
                </button>
                <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-eye mr-2"></i>Xem chi tiết
                </button>
            </div>
        </div>
    </div>

    <!-- Favorite Room 2 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
        <div class="relative">
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <i class="fas fa-home text-gray-400 text-4xl"></i>
            </div>
            <button class="absolute top-3 right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                <i class="fas fa-heart text-sm"></i>
            </button>
            <div class="absolute bottom-3 left-3 bg-green-500 text-white px-2 py-1 rounded text-xs">
                <i class="fas fa-check mr-1"></i>Đã xác minh
            </div>
        </div>
        
        <div class="p-4">
            <h3 class="font-bold text-gray-900 mb-2">Căn hộ mini - Quận 3</h3>
            <p class="text-sm text-gray-600 mb-3">
                <i class="fas fa-map-marker-alt mr-2"></i>
                456 Đường MNO, Phường PQR, Quận 3, TP.HCM
            </p>
            
            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                <span><i class="fas fa-bed mr-1"></i>1 phòng ngủ</span>
                <span><i class="fas fa-bath mr-1"></i>1 phòng tắm</span>
                <span><i class="fas fa-ruler-combined mr-1"></i>22m²</span>
            </div>
            
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-2xl font-bold text-green-600">2.2M VNĐ</p>
                    <p class="text-sm text-gray-600">/tháng</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Đã lưu</p>
                    <p class="text-xs text-gray-500">1 tuần trước</p>
                </div>
            </div>
            
            <div class="flex gap-2">
                <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-phone mr-2"></i>Liên hệ
                </button>
                <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-eye mr-2"></i>Xem chi tiết
                </button>
            </div>
        </div>
    </div>

    <!-- Favorite Room 3 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
        <div class="relative">
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <i class="fas fa-home text-gray-400 text-4xl"></i>
            </div>
            <button class="absolute top-3 right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                <i class="fas fa-heart text-sm"></i>
            </button>
            <div class="absolute bottom-3 left-3 bg-green-500 text-white px-2 py-1 rounded text-xs">
                <i class="fas fa-check mr-1"></i>Đã xác minh
            </div>
        </div>
        
        <div class="p-4">
            <h3 class="font-bold text-gray-900 mb-2">Phòng trọ có ban công - Quận 1</h3>
            <p class="text-sm text-gray-600 mb-3">
                <i class="fas fa-map-marker-alt mr-2"></i>
                321 Đường STU, Phường VWX, Quận 1, TP.HCM
            </p>
            
            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                <span><i class="fas fa-bed mr-1"></i>1 phòng ngủ</span>
                <span><i class="fas fa-bath mr-1"></i>1 phòng tắm</span>
                <span><i class="fas fa-ruler-combined mr-1"></i>28m²</span>
            </div>
            
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-2xl font-bold text-green-600">3.5M VNĐ</p>
                    <p class="text-sm text-gray-600">/tháng</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Đã lưu</p>
                    <p class="text-xs text-gray-500">3 ngày trước</p>
                </div>
            </div>
            
            <div class="flex gap-2">
                <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-phone mr-2"></i>Liên hệ
                </button>
                <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-eye mr-2"></i>Xem chi tiết
                </button>
            </div>
        </div>
    </div>

    <!-- More rooms... -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
        <div class="relative">
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <i class="fas fa-home text-gray-400 text-4xl"></i>
            </div>
            <button class="absolute top-3 right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                <i class="fas fa-heart text-sm"></i>
            </button>
            <div class="absolute bottom-3 left-3 bg-green-500 text-white px-2 py-1 rounded text-xs">
                <i class="fas fa-check mr-1"></i>Đã xác minh
            </div>
        </div>
        
        <div class="p-4">
            <h3 class="font-bold text-gray-900 mb-2">Nhà trọ gần trường - Quận 10</h3>
            <p class="text-sm text-gray-600 mb-3">
                <i class="fas fa-map-marker-alt mr-2"></i>
                654 Đường YZA, Phường BCD, Quận 10, TP.HCM
            </p>
            
            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                <span><i class="fas fa-bed mr-1"></i>1 phòng ngủ</span>
                <span><i class="fas fa-bath mr-1"></i>1 phòng tắm</span>
                <span><i class="fas fa-ruler-combined mr-1"></i>20m²</span>
            </div>
            
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-2xl font-bold text-green-600">1.8M VNĐ</p>
                    <p class="text-sm text-gray-600">/tháng</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Đã lưu</p>
                    <p class="text-xs text-gray-500">5 ngày trước</p>
                </div>
            </div>
            
            <div class="flex gap-2">
                <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-phone mr-2"></i>Liên hệ
                </button>
                <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-eye mr-2"></i>Xem chi tiết
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
        <div class="relative">
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <i class="fas fa-home text-gray-400 text-4xl"></i>
            </div>
            <button class="absolute top-3 right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                <i class="fas fa-heart text-sm"></i>
            </button>
            <div class="absolute bottom-3 left-3 bg-green-500 text-white px-2 py-1 rounded text-xs">
                <i class="fas fa-check mr-1"></i>Đã xác minh
            </div>
        </div>
        
        <div class="p-4">
            <h3 class="font-bold text-gray-900 mb-2">Căn hộ cao cấp - Quận 2</h3>
            <p class="text-sm text-gray-600 mb-3">
                <i class="fas fa-map-marker-alt mr-2"></i>
                987 Đường EFG, Phường HIJ, Quận 2, TP.HCM
            </p>
            
            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                <span><i class="fas fa-bed mr-1"></i>2 phòng ngủ</span>
                <span><i class="fas fa-bath mr-1"></i>2 phòng tắm</span>
                <span><i class="fas fa-ruler-combined mr-1"></i>45m²</span>
            </div>
            
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-2xl font-bold text-green-600">5.5M VNĐ</p>
                    <p class="text-sm text-gray-600">/tháng</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Đã lưu</p>
                    <p class="text-xs text-gray-500">1 tuần trước</p>
                </div>
            </div>
            
            <div class="flex gap-2">
                <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-phone mr-2"></i>Liên hệ
                </button>
                <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-eye mr-2"></i>Xem chi tiết
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
        <div class="relative">
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <i class="fas fa-home text-gray-400 text-4xl"></i>
            </div>
            <button class="absolute top-3 right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                <i class="fas fa-heart text-sm"></i>
            </button>
            <div class="absolute bottom-3 left-3 bg-green-500 text-white px-2 py-1 rounded text-xs">
                <i class="fas fa-check mr-1"></i>Đã xác minh
            </div>
        </div>
        
        <div class="p-4">
            <h3 class="font-bold text-gray-900 mb-2">Phòng trọ sinh viên - Quận 5</h3>
            <p class="text-sm text-gray-600 mb-3">
                <i class="fas fa-map-marker-alt mr-2"></i>
                147 Đường KLM, Phường NOP, Quận 5, TP.HCM
            </p>
            
            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                <span><i class="fas fa-bed mr-1"></i>1 phòng ngủ</span>
                <span><i class="fas fa-bath mr-1"></i>1 phòng tắm</span>
                <span><i class="fas fa-ruler-combined mr-1"></i>16m²</span>
            </div>
            
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-2xl font-bold text-green-600">1.2M VNĐ</p>
                    <p class="text-sm text-gray-600">/tháng</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Đã lưu</p>
                    <p class="text-xs text-gray-500">2 tuần trước</p>
                </div>
            </div>
            
            <div class="flex gap-2">
                <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-phone mr-2"></i>Liên hệ
                </button>
                <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-eye mr-2"></i>Xem chi tiết
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Load More Button -->
<div class="text-center mt-8">
    <button class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">
        <i class="fas fa-plus mr-2"></i>Tải thêm
    </button>
</div>

<!-- Empty State (when no favorites) -->
<div id="emptyState" class="hidden text-center py-12">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-heart text-gray-400 text-3xl"></i>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có phòng yêu thích</h3>
    <p class="text-gray-600 mb-6">Bạn chưa lưu phòng nào. Hãy tìm kiếm và lưu những phòng bạn quan tâm.</p>
    <a href="' . BASE_URL . '/" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
        <i class="fas fa-search mr-2"></i>
        Tìm phòng ngay
    </a>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Remove from favorites functionality
    document.querySelectorAll(".fa-heart").forEach(heart => {
        heart.addEventListener("click", function() {
            const roomCard = this.closest(".bg-white");
            
            // Show confirmation
            if (confirm("Bạn có chắc chắn muốn xóa phòng này khỏi danh sách yêu thích?")) {
                // Add animation
                roomCard.style.transition = "all 0.3s ease";
                roomCard.style.transform = "scale(0.95)";
                roomCard.style.opacity = "0.5";
                
                setTimeout(() => {
                    roomCard.remove();
                    toastr.success("Đã xóa khỏi danh sách yêu thích!");
                }, 300);
            }
        });
    });

    // Contact landlord functionality
    document.querySelectorAll("[data-action=\'contact\']").forEach(button => {
        button.addEventListener("click", function() {
            const phoneNumber = this.dataset.phone;
            if (confirm(`Bạn có muốn gọi cho chủ nhà: ${phoneNumber}?`)) {
                window.location.href = `tel:${phoneNumber}`;
            }
        });
    });

    // View details functionality
    document.querySelectorAll("[data-action=\'view-details\']").forEach(button => {
        button.addEventListener("click", function() {
            const roomId = this.dataset.roomId;
            window.location.href = `${BASE_URL}/rental-post/${roomId}`;
        });
    });
});
</script>