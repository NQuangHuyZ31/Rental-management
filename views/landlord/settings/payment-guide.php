<!-- 
    Author: Huy Nguyen
    Date: 2025-01-15
    Purpose: Payment guide for landlord
-->

<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Hướng dẫn tích hợp thanh toán</h1>
        <p class="text-gray-600 mt-2">Hướng dẫn chi tiết để thiết lập hệ thống thanh toán với Sepay</p>
    </div>

    <!-- Progress Steps -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white font-bold">1</div>
                <span class="ml-2 text-sm font-medium text-gray-900">Đăng ký Sepay</span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-300 mx-4"></div>
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white font-bold">2</div>
                <span class="ml-2 text-sm font-medium text-gray-900">Liên kết ngân hàng</span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-300 mx-4"></div>
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">3</div>
                <span class="ml-2 text-sm font-medium text-gray-900">Tích hợp Webhook</span>
            </div>
        </div>
    </div>

    <!-- Step 1: Sepay Registration -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-user-plus text-green-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Bước 1: Đăng ký tài khoản Sepay</h2>
                <p class="text-gray-600">Tạo tài khoản Sepay để sử dụng dịch vụ thanh toán</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="font-semibold text-green-800 mb-2">📋</h3>
                <img src="<?= BASE_URL ?>/Public/images/image.png" alt="Sepay Register" class="w-full h-auto">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-900">🔗 Liên kết đăng ký:</h3>
                    <a href="https://sepay.vn/register" target="_blank" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Đăng ký Sepay
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 2: Bank Linking -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-university text-green-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Bước 2: Liên kết tài khoản ngân hàng</h2>
                <p class="text-gray-600">Kết nối tài khoản ngân hàng với Sepay để nhận thanh toán</p>
            </div>
        </div>

        <div class="space-y-6">
            <div class="gap-6">
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-900">🏦 Đăng nhập vào sepay -> Mục ngân hàng -> chọn kết nối tài khoản</h3>
                    <div class="gap-2">
                        <img src="<?php echo BASE_URL ?>/Public/images/guide-1.png" alt="Sepay Bank">
                    </div>
					<h3>- Chọn ngân hàng và nhập thông tin tài khoản</h3>
                </div>
            </div>
        </div>
    </div>

	<!-- Step 2: Bank Linking -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-university text-green-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Bước 3: Tạo API key</h2>
                <p class="text-gray-600">Tạo API key để xác thực webhook từ Sepay</p>
            </div>
        </div>

        <div class="space-y-6">
            <div class="gap-6">
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-900">🏦 Đăng nhập vào sepay -> Mục Cấu hình công ty -> API access -> Thêm API key</h3>
                    <div class="gap-2">
                        <img src="<?php echo BASE_URL ?>/Public/images/guide-2.png" alt="Sepay Bank">
                    </div>
					<h3>- Copy lại API key</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 3: Webhook Integration -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-plug text-blue-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Bước 4: Tích hợp Webhook</h2>
                <p class="text-gray-600">Cấu hình webhook để thanh toán tự động</p>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-semibold text-blue-800 mb-2">🔗 Webhook URL:</h3>
                <div class="bg-white border border-blue-300 rounded p-3">
                    <code class="text-sm text-blue-900 break-all">
					https://hosty.shoplands.store/customer/payment/callback
                    </code>
                    <button onclick="copyWebhookUrl()" class="ml-2 text-blue-600 hover:text-blue-800">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <div class="gap-6">
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-900">⚙️ Cấu hình trong Sepay:</h3>
                    <ol class="text-sm text-gray-600 space-y-2">
                        <li>1. Chọn tích hợp webhook</li>
                        <li>2. Chọn thêm webhook</li>
						<li>3. Nhập thông tin webhook</li>
						<li>4. Copy url webhook ở trên và nhập vào</li>
                    </ol>
					<img src="<?php echo BASE_URL ?>/Public/images/guide-3.png" alt="Sepay Webhook">

					<ol class="text-sm text-gray-600 space-y-2">
						<li>5. Kiểu chứng thực chọn API Key</li>
						<li>6. Nhập API key vừa tạo</li>
					</ol>
					<img src="<?php echo BASE_URL ?>/Public/images/guide-4.png" alt="Sepay Webhook">
					<h3>- Lưu webhook</h3>
                </div>

                <div class="space-y-4">
                </div>
            </div>
        </div>
    </div>

	<!-- Step 3: Webhook Integration -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-plug text-blue-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Bước 5: Lưu thông tin trên hệ thống hosty</h2>
                <p class="text-gray-600">Lưu thông tin trên hệ thống hosty</p>
            </div>
        </div>

        <div class="space-y-6">
            <h3>Đăng nhập vào hệ thống hosty -> Mục Cài đặt chung -> Thanh toán -> Thêm thông tin ngân hàng</h3>
			<img src="<?php echo BASE_URL ?>/Public/images/guide-5.png" alt="Sepay Webhook">
			<h3>Nhập thông tin ngân hàng và lưu (API key là API key từ Sepay được cấu hình vào webhook)</h3>
			<h3>Lưu thông tin: <a class="text-blue-600" href="<?php echo BASE_URL ?>/landlord/setting/payment" target="_blank">Tại đây</a></h3>
        </div>
    </div>

    <!-- Support Section -->
    <div class="bg-gradient-to-r from-blue-50 to-green-50 rounded-lg p-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Cần hỗ trợ?</h2>
            <p class="text-gray-600 mb-6">Đội ngũ kỹ thuật sẵn sàng hỗ trợ bạn 24/7</p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:support@hosty.com" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-envelope mr-2"></i>
                    Email Support
                </a>
                <a href="tel:19001234" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-phone mr-2"></i>
                    Hotline: 1900 1234
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Copy webhook URL to clipboard
function copyWebhookUrl() {
    const webhookUrl = 'https://hosty.shoplands.store/customer/payment/callback';
    navigator.clipboard.writeText(webhookUrl).then(() => {
        toastr.success('Đã copy webhook URL vào clipboard');
    }).catch(() => {
        toastr.error('Không thể copy URL');
    });
}
</script>