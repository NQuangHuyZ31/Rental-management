<!--
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Customer notifications page
-->

<!-- Notifications Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Thông báo</h1>
    <p class="text-gray-600">Theo dõi các thông báo và cập nhật mới nhất</p>
</div>

<!-- Notification Actions -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex gap-2">
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-check mr-2"></i>Đánh dấu tất cả đã đọc
                </button>
                <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-trash mr-2"></i>Xóa tất cả
                </button>
            </div>
            <div class="flex gap-2">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Tất cả loại</option>
                    <option value="bill">Hóa đơn</option>
                    <option value="room">Phòng trọ</option>
                    <option value="system">Hệ thống</option>
                    <option value="promotion">Khuyến mãi</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Tất cả trạng thái</option>
                    <option value="unread">Chưa đọc</option>
                    <option value="read">Đã đọc</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Notifications List -->
<div class="space-y-4">
    <!-- Unread Notification 1 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Hóa đơn sắp đến hạn thanh toán</h3>
                            <p class="text-gray-600 mb-2">Hóa đơn tiền phòng tháng 1/2025 cần thanh toán trước ngày 05/01/2025. Vui lòng thanh toán để tránh phí trễ hạn.</p>
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-clock mr-1"></i>2 giờ trước</span>
                                <span><i class="fas fa-tag mr-1"></i>Hóa đơn</span>
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Chưa đọc</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-credit-card mr-2"></i>Thanh toán ngay
                        </button>
                        <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-eye mr-2"></i>Xem chi tiết
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Unread Notification 2 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-home text-blue-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Có phòng mới phù hợp với tiêu chí của bạn</h3>
                            <p class="text-gray-600 mb-2">Chúng tôi đã tìm thấy 3 phòng trọ mới phù hợp với tiêu chí tìm kiếm của bạn. Hãy xem ngay để không bỏ lỡ cơ hội!</p>
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-clock mr-1"></i>1 ngày trước</span>
                                <span><i class="fas fa-tag mr-1"></i>Phòng trọ</span>
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Chưa đọc</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-search mr-2"></i>Xem phòng mới
                        </button>
                        <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-cog mr-2"></i>Cập nhật tiêu chí
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Unread Notification 3 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Thanh toán thành công</h3>
                            <p class="text-gray-600 mb-2">Hóa đơn tiền phòng tháng 12/2024 đã được thanh toán thành công. Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-clock mr-1"></i>2 ngày trước</span>
                                <span><i class="fas fa-tag mr-1"></i>Hóa đơn</span>
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Chưa đọc</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-download mr-2"></i>Tải hóa đơn
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Read Notification 1 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden opacity-75">
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-gift text-yellow-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Khuyến mãi đặc biệt tháng 1</h3>
                            <p class="text-gray-600 mb-2">Giảm 10% phí dịch vụ cho tất cả khách hàng trong tháng 1/2025. Áp dụng cho tất cả các dịch vụ của HOSTY.</p>
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-clock mr-1"></i>3 ngày trước</span>
                                <span><i class="fas fa-tag mr-1"></i>Khuyến mãi</span>
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">Đã đọc</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <button class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-tag mr-2"></i>Sử dụng mã giảm giá
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Read Notification 2 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden opacity-75">
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-bell text-purple-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Cập nhật hệ thống</h3>
                            <p class="text-gray-600 mb-2">Hệ thống HOSTY đã được cập nhật với nhiều tính năng mới. Hãy trải nghiệm và cho chúng tôi biết ý kiến của bạn!</p>
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-clock mr-1"></i>1 tuần trước</span>
                                <span><i class="fas fa-tag mr-1"></i>Hệ thống</span>
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">Đã đọc</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-info-circle mr-2"></i>Xem chi tiết
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Read Notification 3 -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden opacity-75">
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-home text-blue-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Phòng yêu thích có giá mới</h3>
                            <p class="text-gray-600 mb-2">Phòng "Căn hộ mini - Quận 3" trong danh sách yêu thích của bạn đã có giá mới. Giá giảm từ 2.5M xuống 2.2M VNĐ/tháng.</p>
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span><i class="fas fa-clock mr-1"></i>1 tuần trước</span>
                                <span><i class="fas fa-tag mr-1"></i>Phòng trọ</span>
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">Đã đọc</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-eye mr-2"></i>Xem phòng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load More Button -->
<div class="text-center mt-8">
    <button class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">
        <i class="fas fa-plus mr-2"></i>Tải thêm thông báo
    </button>
</div>

<!-- Empty State (when no notifications) -->
<div id="emptyState" class="hidden text-center py-12">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-bell text-gray-400 text-3xl"></i>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có thông báo</h3>
    <p class="text-gray-600 mb-6">Bạn chưa có thông báo nào. Chúng tôi sẽ thông báo cho bạn khi có cập nhật mới.</p>
</div>

<!-- Notification Settings Modal -->
<div id="notificationSettingsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Cài đặt thông báo</h2>
                    <button id="closeNotificationSettingsModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-gray-900">Email thông báo</h3>
                            <p class="text-sm text-gray-600">Nhận thông báo qua email</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-gray-900">SMS thông báo</h3>
                            <p class="text-sm text-gray-600">Nhận thông báo qua tin nhắn</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-gray-900">Thông báo hóa đơn</h3>
                            <p class="text-sm text-gray-600">Nhận thông báo về hóa đơn</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-gray-900">Thông báo phòng mới</h3>
                            <p class="text-sm text-gray-600">Nhận thông báo phòng mới phù hợp</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-gray-900">Thông báo khuyến mãi</h3>
                            <p class="text-sm text-gray-600">Nhận thông báo về ưu đãi</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
                <button id="closeNotificationSettingsModalBtn" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Hủy
                </button>
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Lưu cài đặt
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Mark all as read functionality
    document.querySelector("[data-action=\'mark-all-read\']").addEventListener("click", function() {
        if (confirm("Bạn có chắc chắn muốn đánh dấu tất cả thông báo là đã đọc?")) {
            // Update all unread notifications to read
            document.querySelectorAll(".bg-red-100").forEach(badge => {
                badge.classList.remove("bg-red-100", "text-red-800");
                badge.classList.add("bg-gray-100", "text-gray-800");
                badge.textContent = "Đã đọc";
            });
            
            // Add opacity to all notifications
            document.querySelectorAll(".bg-white").forEach(notification => {
                notification.classList.add("opacity-75");
            });
            
            toastr.success("Đã đánh dấu tất cả thông báo là đã đọc!");
        }
    });

    // Delete all notifications functionality
    document.querySelector("[data-action=\'delete-all\']").addEventListener("click", function() {
        if (confirm("Bạn có chắc chắn muốn xóa tất cả thông báo? Hành động này không thể hoàn tác.")) {
            document.querySelectorAll(".bg-white").forEach(notification => {
                notification.style.transition = "all 0.3s ease";
                notification.style.transform = "scale(0.95)";
                notification.style.opacity = "0";
                
                setTimeout(() => {
                    notification.remove();
                }, 300);
            });
            
            toastr.success("Đã xóa tất cả thông báo!");
        }
    });

    // Notification settings modal functionality
    const notificationSettingsModal = document.getElementById("notificationSettingsModal");
    const closeNotificationSettingsModal = document.getElementById("closeNotificationSettingsModal");
    const closeNotificationSettingsModalBtn = document.getElementById("closeNotificationSettingsModalBtn");

    // Open notification settings modal
    document.querySelector("[data-action=\'notification-settings\']").addEventListener("click", function() {
        notificationSettingsModal.classList.remove("hidden");
    });

    // Close notification settings modal
    [closeNotificationSettingsModal, closeNotificationSettingsModalBtn].forEach(button => {
        button.addEventListener("click", function() {
            notificationSettingsModal.classList.add("hidden");
        });
    });

    // Close modal when clicking outside
    notificationSettingsModal.addEventListener("click", function(e) {
        if (e.target === notificationSettingsModal) {
            notificationSettingsModal.classList.add("hidden");
        }
    });

    // Individual notification actions
    document.querySelectorAll("[data-action=\'mark-read\']").forEach(button => {
        button.addEventListener("click", function() {
            const notification = this.closest(".bg-white");
            const badge = notification.querySelector(".bg-red-100");
            
            if (badge) {
                badge.classList.remove("bg-red-100", "text-red-800");
                badge.classList.add("bg-gray-100", "text-gray-800");
                badge.textContent = "Đã đọc";
            }
            
            notification.classList.add("opacity-75");
            toastr.success("Đã đánh dấu thông báo là đã đọc!");
        });
    });

    document.querySelectorAll("[data-action=\'delete-notification\']").forEach(button => {
        button.addEventListener("click", function() {
            if (confirm("Bạn có chắc chắn muốn xóa thông báo này?")) {
                const notification = this.closest(".bg-white");
                notification.style.transition = "all 0.3s ease";
                notification.style.transform = "scale(0.95)";
                notification.style.opacity = "0";
                
                setTimeout(() => {
                    notification.remove();
                    toastr.success("Đã xóa thông báo!");
                }, 300);
            }
        });
    });
});
</script>