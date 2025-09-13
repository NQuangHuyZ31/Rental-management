<!-- 
    Author: Huy Nguyen
    Date: 2025-09-01
    Purpose: Footer for customer layout
-->

<footer class="py-4 mt-3 <?php echo $noFooter ? 'hidden' : ''; ?>">
    <section class="bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-5">
                <h1 class="text-lg font-bold text-gray-900 mb-4">
                    Các bước đăng tin bài HOSTY
                </h1>
                <p class="text-sm text-gray-600">
                    Tiếp cận khách thuê dễ dàng với tính năng đăng tin
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-screen-lg mx-auto">
                <!-- Step 1 -->
                <div class="relative">
                    <div class="flex items-center justify-center bg-green-500 rounded-lg overflow-hidden shadow-lg">
                        <div class="w-8 h-8 bg-teal-500 rounded-full flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                            1
                        </div>
                        <div class="p-3 text-white">
                            <h3 class="font-bold text-sm mb-2">Đăng nhập/Đăng ký</h3>
                            <p class="text-sm opacity-90">Đăng ký tài khoản, sau đó đăng nhập</p>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative">
                    <div class="flex items-center justify-center bg-blue-500 rounded-lg overflow-hidden shadow-lg">
                        <div class="w-8 h-8 bg-blue-400 border-2 border-blue-300 rounded-full flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                            2
                        </div>
                        <div class="p-3 text-white">
                            <h3 class="font-bold text-sm mb-2">Đăng tin</h3>
                            <p class="text-sm opacity-90">Đăng tin trong tài khoản cá nhân</p>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative">
                    <div class="flex items-center justify-center bg-orange-500 rounded-lg overflow-hidden shadow-lg">
                        <div class="w-8 h-8 bg-orange-400 rounded-full flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                            3
                        </div>
                        <div class="p-3 text-white">
                            <h3 class="font-bold text-sm mb-2">Xét duyệt & tiếp cận khách thuê</h3>
                            <p class="text-sm opacity-90">Chuyên viên sẵn sàng xét duyệt 24/7</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- What HOSTY has Section -->
    <section class="py-8 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-5">
                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    HOSTY có gì?
                </h2>
                <p class="text-sm text-gray-600">
                    Tại sao bạn phải chọn chúng tôi mà không phải một dịch vụ nào khác?
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Stat 1 -->
                <div class="bg-white rounded-lg shadow-md border border-gray-200 p-3 text-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-green-600 text-2xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 mb-2">1.000+</div>
                    <div class="text-gray-600">Chủ nhà</div>
                </div>

                <!-- Stat 2 -->
                <div class="bg-white rounded-lg shadow-md border border-gray-200 p-3 text-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-green-600 text-2xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 mb-2">3.000+</div>
                    <div class="text-gray-600">Khách thuê</div>
                </div>

                <!-- Stat 4 -->
                <div class="bg-white rounded-lg shadow-md border border-gray-200 p-3 text-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bullhorn text-green-600 text-2xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 mb-2">2.000+</div>
                    <div class="text-gray-600">Lượt truy cập/tháng</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Real Footer Section -->
    <section class="bg-white py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Introduction Text -->
            <div class="text-center mb-8">
                <p class="text-gray-700 text-sm leading-relaxed max-w-4xl mx-auto">
                    Chúng tôi tự hào là một trong những dịch vụ tìm kiếm phòng trọ đứng đầu Việt Nam, với phương châm tìm là có chúng tôi luôn cập nhật phòng nhanh nhất, chính xác nhất và ưu tiên sự tiện lợi cho người tìm trọ lên hàng đầu.
                </p>
            </div>

            <!-- Main Footer Content -->
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <!-- Left Column - HOSTY Introduction -->
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-lg">H</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">HOSTY</h3>
                            <p class="text-sm text-green-600 font-medium">Tìm TRỌ - CĂN HỘ</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        HOSTY là kênh cung cấp giải pháp tìm kiếm nhà ở chất lượng và tiện lợi, kết hợp giữa công nghệ và dịch vụ chuyên nghiệp. Với danh sách đa dạng từ căn hộ đến nhà riêng và phòng trọ, cùng đội ngũ nhân viên tận tâm hỗ trợ từ tư vấn đến tham quan nhà và thương lượng giá cả.
                    </p>
                </div>

                <!-- Middle Column - Links -->
                <div>
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Liên kết</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-green-600 text-sm transition-colors">Liên hệ</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-green-600 text-sm transition-colors">Giới thiệu về HOSTY</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-green-600 text-sm transition-colors">Chính sách bảo mật</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-green-600 text-sm transition-colors">Điều khoản sử dụng</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-green-600 text-sm transition-colors">Quy chế hoạt động</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-green-600 text-sm transition-colors">Chính sách giải quyết khiếu nại</a></li>
                    </ul>
                </div>

                <!-- Right Column - Contact Information -->
                <div>
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Thông tin & Liên hệ</h4>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-green-600 mt-1 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">VP đại diện:</p>
                                <p class="text-sm text-gray-600">12 Nguyễn Vãn Bảo - Gò Vấp - Tp. Hồ Chí Minh</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-green-600 mt-1 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">VP làm việc:</p>
                                <p class="text-sm text-gray-600">12 Nguyễn Vãn Bảo - Gò Vấp - Tp. Hồ Chí Minh</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-green-600 mr-3"></i>
                            <span class="text-sm text-gray-600">hostysupport@gmail.com</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock text-green-600 mr-3"></i>
                            <span class="text-sm text-gray-600">Từ 8h - 18h từ Thứ 2 đến Thứ 6 và Sáng Thứ 7</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-green-600 mr-3"></i>
                            <span class="text-sm text-gray-600">Hotline - Zalo: 0909876543</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Text -->
            <div class="text-center border-t border-gray-200 pt-6">
                <p class="text-sm text-gray-500">Liên hệ với chúng tôi nếu bạn cần hỗ trợ</p>
            </div>
        </div>
    </section>

    <!-- Additional Footer Section -->
    <section class="bg-gray-50 py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Social Media & Download Apps -->
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <!-- Social Media -->
            <div class="text-center">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Kết nối với chúng tôi</h4>
                    <div class="flex space-x-4 justify-center">
                        <a href="#" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center text-white hover:bg-blue-500 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center text-white hover:bg-pink-700 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white hover:bg-blue-600 transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white hover:bg-green-600 transition-colors">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- Download Apps -->
                <div class="text-center">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Tải ứng dụng HOSTY</h4>
                    <div class="flex space-x-4 justify-center">
                        <a href="#" class="flex items-center bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                            <i class="fab fa-apple text-xl mr-2"></i>
                            <div class="text-left">
                                <div class="text-xs">Tải về</div>
                                <div class="text-sm font-medium">App Store</div>
                            </div>
                        </a>
                        <a href="#" class="flex items-center bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                            <i class="fab fa-google-play text-xl mr-2"></i>
                            <div class="text-left">
                                <div class="text-xs">Tải về</div>
                                <div class="text-sm font-medium">Google Play</div>
                            </div>
                    </a>
                </div>
            </div>
        </div>

            <!-- Services & Features -->
            <div class="grid md:grid-cols-4 gap-6 mb-8">
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                    </div>
                    <h5 class="font-semibold text-gray-900 mb-2">Bảo mật thông tin</h5>
                    <p class="text-sm text-gray-600">Thông tin cá nhân được bảo vệ an toàn</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-clock text-green-600 text-xl"></i>
                    </div>
                    <h5 class="font-semibold text-gray-900 mb-2">Hỗ trợ 24/7</h5>
                    <p class="text-sm text-gray-600">Đội ngũ chăm sóc khách hàng luôn sẵn sàng</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <h5 class="font-semibold text-gray-900 mb-2">Tin đăng đã xác thực</h5>
                    <p class="text-sm text-gray-600">Tất cả tin đăng đều được kiểm duyệt</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-star text-green-600 text-xl"></i>
                    </div>
                    <h5 class="font-semibold text-gray-900 mb-2">Dịch vụ chất lượng</h5>
                    <p class="text-sm text-gray-600">Cam kết mang đến trải nghiệm tốt nhất</p>
                </div>
            </div>

            <!-- Copyright & Legal -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-500 mb-4 md:mb-0">
                        © 2025 HOSTY. Tất cả quyền được bảo lưu. Bản quyền thuộc về HOSTY.
                    </div>
                    <div class="flex space-x-6 text-sm">
                        <a href="#" class="text-gray-500 hover:text-green-600 transition-colors">Điều khoản sử dụng</a>
                        <a href="#" class="text-gray-500 hover:text-green-600 transition-colors">Chính sách bảo mật</a>
                        <a href="#" class="text-gray-500 hover:text-green-600 transition-colors">Chính sách cookie</a>
                        <a href="#" class="text-gray-500 hover:text-green-600 transition-colors">Bản đồ trang web</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scroll to Top Button -->
    <button id="scrollToTop" class="fixed bottom-4 right-4 bg-blue-500 text-white w-12 h-12 rounded-full shadow-lg hover:bg-blue-600 transition-colors z-50 hidden">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
    // Scroll to top functionality
    document.getElementById('scrollToTop').addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Show/hide scroll to top button
    window.addEventListener('scroll', function() {
        const scrollButton = document.getElementById('scrollToTop');
        if (window.pageYOffset > 300) {
            scrollButton.classList.remove('hidden');
        } else {
            scrollButton.classList.add('hidden');
        }
    });
    </script>
    </footer>