<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOZIDO - Đăng nhập</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'lozido-green': '#10B981',
                        'lozido-orange': '#F59E0B',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="text-center py-8">
        <!-- Logo -->
        <div class="inline-flex items-center justify-center w-16 h-16 bg-lozido-green rounded-full mb-4">
            <span class="text-white text-2xl font-bold">L</span>
        </div>
        
        <!-- Title -->
        <h1 class="text-4xl font-bold text-lozido-orange mb-2">ĐĂNG NHẬP</h1>
        <p class="text-2xl font-semibold text-lozido-green">Đăng tin cho thuê</p>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-xl p-8 flex flex-col lg:flex-row gap-8">
            
            <!-- Login Form Section -->
            <div class="flex-1">
                <form class="space-y-6">
                    <!-- User Role Selection -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Chọn vai trò:</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="role" value="landlord" class="sr-only">
                                <span class="px-4 py-2 rounded-lg border-2 border-gray-200 text-gray-600 cursor-pointer hover:border-lozido-green transition-colors">
                                    Tôi là Chủ nhà
                                </span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="role" value="broker" class="sr-only">
                                <span class="px-4 py-2 rounded-lg border-2 border-gray-200 text-gray-600 cursor-pointer hover:border-lozido-green transition-colors">
                                    Tôi là Môi giới
                                </span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="role" value="customer" class="sr-only" checked>
                                <span class="px-4 py-2 rounded-lg border-2 border-blue-500 bg-blue-500 text-white cursor-pointer">
                                    Tôi tìm nhà, việc
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Phone Number Input -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Số điện thoại *
                        </label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lozido-green focus:border-lozido-green transition-colors"
                            placeholder="Nhập số điện thoại của bạn"
                        >
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Nhập mật khẩu *
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lozido-green focus:border-lozido-green transition-colors"
                            placeholder="Nhập mật khẩu của bạn"
                        >
                    </div>

                    <!-- Login Button -->
                    <button 
                        type="submit"
                        class="w-full bg-lozido-green text-white py-3 px-6 rounded-lg font-semibold text-lg hover:bg-green-600 transition-colors focus:ring-4 focus:ring-green-200"
                    >
                        Đăng nhập tìm nhà, việc
                    </button>

                    <!-- Links -->
                    <div class="flex justify-between items-center pt-4">
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                            Tạo tài khoản
                        </a>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                            Quên mật khẩu
                        </a>
                    </div>
                </form>
            </div>

            <!-- QR Code Section -->
            <div class="flex-1">
                <div class="bg-lozido-green rounded-2xl p-8 text-center h-full flex flex-col justify-center">
                    <!-- QR Code -->
                    <div class="bg-white p-4 rounded-xl inline-block mb-6">
                        <div class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center relative">
                            <!-- QR Code Placeholder -->
                            <div class="grid grid-cols-8 gap-1 w-24 h-24">
                                <!-- QR Code pattern -->
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                                <div class="bg-white rounded-sm"></div>
                                <div class="bg-black rounded-sm"></div>
                            </div>
                            
                            <!-- LOZIDO Logo in center -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-8 h-8 bg-lozido-green rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">L</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Text Content -->
                    <h2 class="text-2xl font-bold text-white mb-3">
                        Quét mã tải app
                    </h2>
                    <p class="text-white text-sm leading-relaxed">
                        Tải app để đăng tin nhanh chóng và được thông báo khi có khách thuê tiềm năng
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center py-8 mt-12">
        <p class="text-gray-600 text-sm">
            Copyright @ LOZIDO - Tìm trọ, căn hộ, việc làm
        </p>
        <div class="flex justify-center items-center space-x-4 mt-4">
            <div class="flex items-center space-x-2 text-blue-600 text-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>Báo lỗi - Điều khoản</span>
            </div>
        </div>
    </div>

    <!-- Background Decorative Elements -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute top-20 left-10 w-16 h-16 bg-gray-200 rounded-full opacity-20"></div>
        <div class="absolute top-40 right-20 w-12 h-12 bg-lozido-green rounded-full opacity-10"></div>
        <div class="absolute bottom-40 left-20 w-20 h-20 bg-lozido-orange rounded-full opacity-10"></div>
        <div class="absolute top-1/2 left-1/4 w-8 h-8 bg-gray-300 rounded-full opacity-15"></div>
    </div>

    <script>
        // Handle radio button selection
        document.querySelectorAll('input[name="role"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove all active states
                document.querySelectorAll('input[name="role"]').forEach(r => {
                    r.nextElementSibling.classList.remove('border-blue-500', 'bg-blue-500', 'text-white');
                    r.nextElementSibling.classList.add('border-gray-200', 'text-gray-600');
                });
                
                // Add active state to selected
                this.nextElementSibling.classList.remove('border-gray-200', 'text-gray-600');
                this.nextElementSibling.classList.add('border-blue-500', 'bg-blue-500', 'text-white');
            });
        });
    </script>
</body>
</html>
