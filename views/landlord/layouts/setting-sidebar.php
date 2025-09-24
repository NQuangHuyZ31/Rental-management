<!-- 
    Author: Huy Nguyen
    Date: 2025-01-15
    Purpose: Setting sidebar for landlord
-->

<div class="w-64 bg-white shadow-lg rounded-lg p-4" style="height: 100vh;">
    <div class="mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-2">Cài đặt</h2>
        <p class="text-sm text-gray-600">Quản lý cấu hình hệ thống</p>
    </div>

    <nav class="space-y-2">
        <!-- Payment Settings -->
        <div class="mb-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                <i class="fas fa-credit-card text-green-600 mr-2"></i>
                Thanh toán
            </h3>
            <ul class="space-y-1 ml-4">
                <li>
                    <a href="<?= BASE_URL ?>/landlord/setting/payment" 
                       class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors <?= $currentPage === 'payment' ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-100' ?>">
                        <i class="fas fa-university mr-2"></i>
                        Thông tin ngân hàng
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/landlord/setting/payment/guide" 
                       class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors <?= $currentPage === 'payment-guide' ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-100' ?>">
                        <i class="fas fa-book mr-2"></i>
                        Hướng dẫn tích hợp
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/landlord/setting/payment-api" 
                       class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors <?= $currentPage === 'payment-api' ? 'bg-green-100 text-green-700' : 'text-gray-600 hover:bg-gray-100' ?>">
                        <i class="fas fa-key mr-2"></i>
                        Thay đổi API Key
                    </a>
                </li>
            </ul>
        </div>

        <!-- Post Configuration -->
        <div class="mb-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                <i class="fas fa-cog text-blue-600 mr-2"></i>
                Cấu hình bài đăng
            </h3>
            <ul class="space-y-1 ml-4">
                <li>
                    <a href="<?= BASE_URL ?>/landlord/setting/categories" 
                       class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors <?= $currentPage === 'categories' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' ?>">
                        <i class="fas fa-tags mr-2"></i>
                        Danh mục thuê
                    </a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>/landlord/setting/amenities" 
                       class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors <?= $currentPage === 'amenities' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' ?>">
                        <i class="fas fa-star mr-2"></i>
                        Tiện ích phòng
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
