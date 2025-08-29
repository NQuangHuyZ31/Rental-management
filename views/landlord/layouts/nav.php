<nav class="bg-gray-100 p-4">
    <div class="container mx-auto">
        <div class="flex gap-6 justify-start overflow-x-auto">
            <!-- Quản lý nhà trọ -->
            <div class="bg-white rounded-lg border border-green-200 p-3 flex items-center min-w-[200px] relative flex-shrink-0">
                <a href="#" class="flex items-center flex-1 hover:bg-gray-50 transition-colors rounded p-2 -m-2">
                    <div class="relative mr-3">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-home text-white text-lg"></i>
                        </div>
                        <!-- Badge số thông báo được đặt ở góc trên phải của icon -->
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center border border-white">
                            <span class="text-white text-xs font-bold">1</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-gray-600 text-xs">Đang quản lý</div>
                        <div class="text-green-600 font-semibold text-sm">Nhà trọ Vô hạn thành</div>
                    </div>
                </a>
                <div class="absolute -right-3 top-1/2 transform -translate-y-1/2 group">
                    <a href="#" class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center shadow-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus text-white text-xs"></i>
                    </a>
                    <div class="absolute bottom-full right-0 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                        Thêm mới nhà cho thuê
                    </div>
                </div>
            </div>

            <!-- Phòng -->
            <a href="#" class="bg-white rounded-lg border border-green-200 p-3 flex flex-col items-center min-w-[140px] flex-shrink-0 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-door-open text-white text-lg"></i>
                </div>
                <div class="text-gray-700 font-semibold text-sm text-center">Quản lý phòng</div>
            </a>

            <!-- Hóa đơn -->
            <a href="#" class="bg-white rounded-lg border border-green-200 p-3 flex flex-col items-center min-w-[140px] flex-shrink-0 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-file-invoice-dollar text-white text-lg"></i>
                </div>
                <div class="text-gray-700 font-semibold text-sm text-center">Quản lý hóa đơn</div>
            </a>

            <!-- Dịch vụ -->
            <a href="#" class="bg-white rounded-lg border border-green-200 p-3 flex flex-col items-center min-w-[140px] flex-shrink-0 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-concierge-bell text-white text-lg"></i>
                </div>
                <div class="text-gray-700 font-semibold text-sm text-center">Quản lý dịch vụ</div>
            </a>

            <!-- Tài sản -->
            <a href="#" class="bg-white rounded-lg border border-green-200 p-3 flex flex-col items-center min-w-[140px] flex-shrink-0 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-couch text-white text-lg"></i>
                </div>
                <div class="text-gray-700 font-semibold text-sm text-center">Quản lý tài sản</div>
            </a>

            <!-- Khách thuê -->
            <a href="#" class="bg-white rounded-lg border border-green-200 p-3 flex flex-col items-center min-w-[140px] flex-shrink-0 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-users text-white text-lg"></i>
                </div>
                <div class="text-gray-700 font-semibold text-sm text-center">Quản lý khách thuê</div>
            </a>
        </div>
    </div>
</nav>