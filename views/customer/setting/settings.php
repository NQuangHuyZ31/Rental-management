<!--
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Customer settings page
-->

<!-- Settings Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Cài đặt</h1>
    <p class="text-gray-600">Quản lý cài đặt tài khoản và tùy chọn cá nhân</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column - Settings Menu -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <nav class="space-y-2">
                    <a href="#account" class="settings-nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors bg-green-50 text-green-600">
                        <i class="fas fa-user text-lg"></i>
                        <span class="font-medium">Tài khoản</span>
                    </a>
                    <a href="#privacy" class="settings-nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                        <i class="fas fa-shield-alt text-lg"></i>
                        <span class="font-medium">Bảo mật</span>
                    </a>
                    <a href="#notifications" class="settings-nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="font-medium">Thông báo</span>
                    </a>
                    <a href="#preferences" class="settings-nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                        <i class="fas fa-cog text-lg"></i>
                        <span class="font-medium">Tùy chọn</span>
                    </a>
                    <a href="#search" class="settings-nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                        <i class="fas fa-search text-lg"></i>
                        <span class="font-medium">Tìm kiếm</span>
                    </a>
                    <a href="#language" class="settings-nav-link flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                        <i class="fas fa-language text-lg"></i>
                        <span class="font-medium">Ngôn ngữ</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Right Column - Settings Content -->
    <div class="lg:col-span-2">
        <!-- Account Settings -->
        <div id="account-settings" class="settings-content">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Cài đặt tài khoản</h2>
                    <p class="text-gray-600 text-sm mt-1">Quản lý thông tin cơ bản của tài khoản</p>
                </div>
                <div class="p-6">
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tên hiển thị</label>
                                <input type="text" value="Nguyễn Văn A" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" value="nguyenvana@email.com" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                            <input type="tel" value="0901234567" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                <i class="fas fa-save mr-2"></i>Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Privacy Settings -->
        <div id="privacy-settings" class="settings-content hidden">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Cài đặt bảo mật</h2>
                    <p class="text-gray-600 text-sm mt-1">Quản lý bảo mật và quyền riêng tư</p>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">Hiển thị thông tin công khai</h3>
                                <p class="text-sm text-gray-600">Cho phép người khác xem thông tin cơ bản của bạn</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">Hiển thị số điện thoại</h3>
                                <p class="text-sm text-gray-600">Cho phép chủ nhà xem số điện thoại của bạn</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">Hiển thị email</h3>
                                <p class="text-sm text-gray-600">Cho phép chủ nhà xem email của bạn</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">Hiển thị đánh giá</h3>
                                <p class="text-sm text-gray-600">Cho phép hiển thị đánh giá từ chủ nhà</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Settings -->
        <div id="notifications-settings" class="settings-content hidden">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Cài đặt thông báo</h2>
                    <p class="text-gray-600 text-sm mt-1">Quản lý cách bạn nhận thông báo</p>
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
                                <p class="text-sm text-gray-600">Nhận thông báo về hóa đơn và thanh toán</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">Thông báo phòng mới</h3>
                                <p class="text-sm text-gray-600">Nhận thông báo khi có phòng mới phù hợp</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">Thông báo khuyến mãi</h3>
                                <p class="text-sm text-gray-600">Nhận thông báo về ưu đãi và khuyến mãi</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preferences Settings -->
        <div id="preferences-settings" class="settings-content hidden">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Tùy chọn cá nhân</h2>
                    <p class="text-gray-600 text-sm mt-1">Cài đặt giao diện và trải nghiệm</p>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Chủ đề giao diện</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="light" selected>Sáng</option>
                                <option value="dark">Tối</option>
                                <option value="auto">Tự động</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mật độ hiển thị</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="compact" selected>Gọn</option>
                                <option value="comfortable">Thoải mái</option>
                                <option value="spacious">Rộng rãi</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">Hiển thị ảnh động</h3>
                                <p class="text-sm text-gray-600">Bật/tắt hiệu ứng chuyển động</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">Tự động lưu</h3>
                                <p class="text-sm text-gray-600">Tự động lưu thay đổi khi chỉnh sửa</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Settings -->
        <div id="search-settings" class="settings-content hidden">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Cài đặt tìm kiếm</h2>
                    <p class="text-gray-600 text-sm mt-1">Tùy chỉnh cách tìm kiếm phòng trọ</p>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Khu vực mặc định</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="quan-1" selected>Quận 1</option>
                                <option value="quan-3">Quận 3</option>
                                <option value="quan-7">Quận 7</option>
                                <option value="all">Tất cả</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Khoảng giá mặc định</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="1-3" selected>1-3 triệu</option>
                                <option value="2-4">2-4 triệu</option>
                                <option value="3-5">3-5 triệu</option>
                                <option value="all">Tất cả</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Loại phòng ưa thích</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2" checked>
                                    <span class="text-sm">Phòng trọ</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2">
                                    <span class="text-sm">Căn hộ</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2">
                                    <span class="text-sm">Nhà trọ</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2">
                                    <span class="text-sm">Ký túc xá</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">Lưu lịch sử tìm kiếm</h3>
                                <p class="text-sm text-gray-600">Lưu lại các từ khóa tìm kiếm</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Language Settings -->
        <div id="language-settings" class="settings-content hidden">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Cài đặt ngôn ngữ</h2>
                    <p class="text-gray-600 text-sm mt-1">Chọn ngôn ngữ hiển thị</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="language" value="vi" class="mr-3" checked>
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">🇻🇳</span>
                                <div>
                                    <p class="font-medium">Tiếng Việt</p>
                                    <p class="text-sm text-gray-600">Ngôn ngữ mặc định</p>
                                </div>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="language" value="en" class="mr-3">
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">🇺🇸</span>
                                <div>
                                    <p class="font-medium">English</p>
                                    <p class="text-sm text-gray-600">English language</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Settings navigation
    const navLinks = document.querySelectorAll(".settings-nav-link");
    const contentSections = document.querySelectorAll(".settings-content");

    navLinks.forEach(link => {
        link.addEventListener("click", function(e) {
            e.preventDefault();
            
            // Remove active class from all nav links
            navLinks.forEach(nav => {
                nav.classList.remove("bg-green-50", "text-green-600");
                nav.classList.add("text-gray-700");
            });
            
            // Add active class to clicked nav link
            this.classList.remove("text-gray-700");
            this.classList.add("bg-green-50", "text-green-600");
            
            // Hide all content sections
            contentSections.forEach(section => {
                section.classList.add("hidden");
            });
            
            // Show corresponding content section
            const targetId = this.getAttribute("href").substring(1) + "-settings";
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.classList.remove("hidden");
            }
        });
    });

    // Form submissions
    document.querySelectorAll("form").forEach(form => {
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector("button[type=submit]");
            const originalText = submitBtn.innerHTML;
            
            // Show loading
            submitBtn.innerHTML = "<i class=\"fas fa-spinner fa-spin mr-2\"></i>Đang lưu...";
            submitBtn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                toastr.success("Cài đặt đã được lưu thành công!");
            }, 2000);
        });
    });

    // Toggle switches
    document.querySelectorAll("input[type=checkbox]").forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            const settingName = this.closest(".flex").querySelector("h3").textContent;
            const isEnabled = this.checked;
            
            toastr.info(`${settingName} đã được ${isEnabled ? "bật" : "tắt"}`);
        });
    });

    // Language selection
    document.querySelectorAll("input[name=language]").forEach(radio => {
        radio.addEventListener("change", function() {
            const language = this.value;
            const languageName = this.closest("label").querySelector(".font-medium").textContent;
            
            toastr.info(`Ngôn ngữ đã được thay đổi thành ${languageName}`);
        });
    });
});
</script>