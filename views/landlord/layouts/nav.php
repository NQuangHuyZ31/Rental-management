<!--
Author: Nguyen Xuan Duong
Date: 2025-08-29
Purpose: Build Nav for Landlord Layout
-->

<nav class="bg-gray-100 p-4">
    <div class="max-w-screen-xl container mx-auto">
        <div class="flex gap-6 justify-start overflow-x-auto">
            <!-- Quản lý nhà trọ -->
            <div class="bg-white rounded-lg border border-green-200 p-3 flex items-center min-w-[200px] relative flex-shrink-0">
                <button onclick="openHouseListModal()" class="flex items-center flex-1 hover:bg-gray-50 transition-colors rounded p-2 -m-2">
                    <div class="relative mr-3">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-home text-white text-lg"></i>
                        </div>
                        <!-- Badge số nhà trọ -->
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center border border-white">
                            <span class="text-white text-xs font-bold">
                                <?= count($houses) ?>
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="text-gray-600 text-xs">Đang quản lý</div>
                        <?php if (!empty($houses) && $selectedHouse): ?>
                            <div class="text-green-600 font-semibold text-sm"><?= htmlspecialchars($selectedHouse['house_name']) ?></div>
                        <?php else: ?>
                            <div class="text-green-600 font-semibold text-sm">Chưa có nhà</div>
                        <?php endif; ?>
                    </div>
                </button>
                <div class="absolute -right-3 top-1/2 transform -translate-y-1/2 group">
                    <button onclick="openAddHouseModal()" class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center shadow-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus text-white text-xs"></i>
                    </button>
                    <div class="absolute bottom-full right-0 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                        Thêm mới nhà cho thuê
                    </div>
                </div>
            </div>

            <!-- Phòng -->
            <a href="<?= BASE_URL ?>/landlord" class="bg-white rounded-lg border border-green-200 p-3 flex flex-col items-center min-w-[140px] flex-shrink-0 hover:bg-gray-50 transition-colors">
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
            <a href="<?= BASE_URL ?>/landlord/service" class="bg-white rounded-lg border border-green-200 p-3 flex flex-col items-center min-w-[140px] flex-shrink-0 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mb-2">
                    <i class="fas fa-concierge-bell text-white text-lg"></i>
                </div>
                <div class="text-gray-700 font-semibold text-sm text-center">Quản lý dịch vụ</div>
            </a>

            <!-- Tài sản -->
            <a href="<?= BASE_URL ?>/landlord/amenity" class="bg-white rounded-lg border border-green-200 p-3 flex flex-col items-center min-w-[140px] flex-shrink-0 hover:bg-gray-50 transition-colors">
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

<!-- Modal danh sách nhà trọ -->
<div id="houseListModal" class="modal-container hidden">
    <div class="modal-content flex flex-col">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0 bg-white">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-home text-white text-sm"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Danh sách nhà trọ của bạn</h2>
                    <p class="text-gray-600 text-sm mt-1">Tới <?= count($houses) ?> nhà trọ và quản lý</p>
                </div>
            </div>
            <button onclick="closeHouseListModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto min-h-0">
            <div class="p-6">
                <?php if (!empty($houses)): ?>
                    <div class="space-y-4">
                        <?php foreach ($houses as $house): ?>
                        <div class="bg-green-600 rounded-lg p-4 text-white relative">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg mb-2"><?= htmlspecialchars($house['house_name']) ?></h3>
                                    <p class="text-green-100 text-sm"><?= htmlspecialchars($house['address']) ?>, <?= htmlspecialchars($house['ward']) ?>, <?= htmlspecialchars($house['province']) ?></p>
                                </div>
                                <div class="flex items-center space-x-3 ml-4">
                                    <!-- Nút xóa -->
                                    <button onclick="deleteHouse(<?= $house['id'] ?>)" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-800 transition-colors" title="Xóa nhà trọ">
                                        <i class="fas fa-trash text-white text-sm"></i>
                                    </button>
                                    <!-- Nút chỉnh sửa -->
                                    <button onclick="editHouse(<?= $house['id'] ?>)" class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors" title="Chỉnh sửa">
                                        <i class="fas fa-pencil-alt text-gray-700 text-sm"></i>
                                    </button>
                                    <!-- Nút chuyển tới nhà trọ -->
                                    <button onclick="goToHouse(<?= $house['id'] ?>)" class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors" title="Chuyển tới nhà trọ">
                                        <i class="fas fa-arrow-right text-gray-700 text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <div class="mb-4">
                            <i class="fas fa-home text-gray-400 text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Chưa có nhà trọ nào</h3>
                        <p class="text-gray-500 mb-4">Bạn chưa có nhà trọ nào được tạo.</p>
                        <button onclick="closeHouseListModal(); openAddHouseModal();" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Tạo nhà trọ đầu tiên
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal thêm nhà trọ -->
<div id="addHouseModal" class="modal-container hidden">
    <div class="modal-content large flex flex-col">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0 bg-white">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-home text-white text-sm"></i>
                </div>
                <h2 id="modalTitle" class="text-xl font-semibold text-gray-800">Tạo mới một tòa nhà cho thuê</h2>
            </div>
            <button onclick="closeAddHouseModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto min-h-0">
            <form id="houseForm" method="POST" action="<?= BASE_URL ?>/landlord/house/create" onsubmit="return validateForm()">
                <?= \Core\CSRF::getTokenField() ?>
            <div class="p-6">
                <!-- Thông tin cơ bản -->
                <div class="mb-6">
                    <div class="flex mb-4">
                        <div class="w-1 bg-green-600 mr-3"></div>
                        <div>
                            <h3 class="text-base font-medium text-gray-800">Thông tin cơ bản:</h3>
                            <p class="text-gray-600 italic mt-1 text-sm">Thông tin cơ bản về nhà trọ của bạn</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Tên nhà trọ -->
                        <div class="relative">
                                <input type="text" id="house_name" name="house_name" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" " required>
                            <label for="house_name" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Tên nhà trọ <span class="text-red-500">*</span></label>
                        </div>
                    </div>
                </div>

                <!-- Địa chỉ -->
                <div class="mb-6">
                    <div class="flex mb-4">
                        <div class="w-1 bg-green-600 mr-3"></div>
                        <div>
                            <h3 class="text-base font-medium text-gray-800">Địa chỉ:</h3>
                            <p class="text-gray-600 italic mt-1 text-sm">Giúp cho khách thuê của bạn có thể tìm thấy nhà trọ của bạn dễ dàng hơn</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Tỉnh/Thành phố -->
                        <div class="relative">
                                <select id="province" name="province" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none" required>
                                <option value="">Chọn tỉnh/thành phố</option>
                            </select>
                            <label for="province" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Tỉnh/Thành phố <span class="text-red-500">*</span></label>
                        </div>



                        <!-- Phường/Xã -->
                        <div class="relative">
                                <select id="ward" name="ward" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none" disabled required>
                                <option value="">Chọn phường/xã</option>
                            </select>
                            <label for="ward" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Phường/Xã <span class="text-red-500">*</span></label>
                        </div>

                        <!-- Địa chỉ chi tiết -->
                        <div class="relative md:col-span-2">
                                <input type="text" id="address" name="address" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" " required>
                            <label for="address" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Địa chỉ chi tiết <span class="text-red-500">*</span></label>
                        </div>
                    </div>
                </div>

                <!-- Cài đặt cho phiếu thu (hóa đơn) -->
                <div class="mb-6">
                    <div class="flex mb-4">
                        <div class="w-1 bg-green-600 mr-3"></div>
                        <div>
                            <h3 class="text-base font-medium text-gray-800">Cài đặt cho phiếu thu (hóa đơn):</h3>
                            <p class="text-gray-600 italic mt-1 text-sm">Thiết lập cho hóa đơn khi bạn lập hóa đơn tiền thuê cho khách thuê</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Ngày lập hóa đơn -->
                        <div>
                            <div class="relative">
                                    <input type="number" id="payment_date" name="payment_date" min="1" max="28" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" " required>
                                <label for="payment_date" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Ngày lập hóa đơn <span class="text-red-500">*</span></label>
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                - Là ngày lập hóa đơn tiền điện, nước...<br>
                                - Nhập 1 ngày từ 1 đến 28
                            </div>
                        </div>

                        <!-- Hạn đóng tiền -->
                        <div>
                            <div class="relative">
                                    <input type="number" id="due_date" name="due_date" min="1" max="28" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" " required>
                                <label for="due_date" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-blue-500 peer-[:not(:placeholder-shown)]:font-medium">Hạn đóng tiền <span class="text-red-500">*</span></label>
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                Ví dụ: Bạn lập phiếu ngày 01 và hạn đóng tiền thuê trọ ở đây là 5 ngày thì ngày 05 sẽ là ngày hết hạn
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ghi chú trong form -->
                <div class="mt-4 text-xs text-gray-500">
                    <span class="font-medium text-blue-600">💡 Lưu ý:</span> Bạn có thể cài đặt các dịch vụ, tài sản của các phòng sau khi thêm nhà trọ
                </div>
            </div>
            </form>
        </div>

        <!-- Footer - Luôn hiển thị cố định -->
        <div class="flex items-center justify-end p-6 border-t border-gray-200 flex-shrink-0 bg-white">
            <button type="button" onclick="closeAddHouseModal()" class="px-6 py-2 text-gray-600 hover:text-gray-800 transition-colors mr-3">
                Hủy bỏ
            </button>
            <button type="submit" form="houseForm" id="submitButton" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                Tạo nhà trọ
            </button>
        </div>
    </div>
</div>

<script>
    // Khai báo biến cho selectors
    const PROVINCE = '#province';
    const WARD = '#ward';

    // Modal danh sách nhà trọ
    function openHouseListModal() {
        document.getElementById('houseListModal').classList.remove('hidden');
    }

    function closeHouseListModal() {
        document.getElementById('houseListModal').classList.add('hidden');
    }

    // Modal thêm nhà trọ
    function openAddHouseModal() {
        document.getElementById('addHouseModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Load tỉnh thành khi mở modal
        getProvince();
    }

    function closeAddHouseModal() {
        document.getElementById('addHouseModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        // Reset form khi đóng modal
        resetAddressForm();
        
        // Reset tiêu đề và nút submit về trạng thái ban đầu
        document.getElementById('modalTitle').textContent = 'Tạo mới một tòa nhà cho thuê';
        document.getElementById('submitButton').textContent = 'Tạo nhà trọ';
        
        // Reset form action
        document.getElementById('houseForm').action = '<?= BASE_URL ?>/landlord/house/create';
        
        // Xóa input hidden nếu có
        const hiddenInput = document.getElementById('house_id');
        if (hiddenInput) {
            hiddenInput.remove();
        }
        
        // Reset các trường input
        document.getElementById('house_name').value = '';
        document.getElementById('address').value = '';
        document.getElementById('payment_date').value = '';
        document.getElementById('due_date').value = '';
    }

    // Reset form địa chỉ
    function resetAddressForm() {
        $(PROVINCE).html('<option value="">Chọn tỉnh/thành phố</option>');
        $(WARD).html('<option value="">Chọn phường/xã</option>');
        $(WARD).attr('disabled', true);
        $('#address').val('');
    }

    // Lấy tên tỉnh thành phố
    window.getProvince = function(province_value) {
        fetch('https://provinces.open-api.vn/api/v2/')
            .then(function(response) {
                return response.json();
            })
            .then(function(provinces) {
                provinces.forEach((province) => {
                    $(PROVINCE).append(
                        `<option value="${province.name}" data-code="${province.code}" ${province_value != '' ? (province.name == province_value ? 'selected' : '') : ''}>${
                             province.name
                         }</option>`
                    );
                });
            })
            .catch(function(err) {
                console.log(err);
            });
    };



    // Lấy danh sách phường xã
    window.getWard = function(ward_value) {
        const selectedOption = $(PROVINCE + ' option:selected');
        const provinceCode = selectedOption.attr('data-code');

        if (!provinceCode) {
            $(WARD).html('<option value="">Chọn phường/xã</option>');
            $(WARD).attr('disabled', true);
            return;
        }

        fetch(`https://provinces.open-api.vn/api/v2/p/${provinceCode}?depth=2`)
            .then(function(response) {
                return response.json();
            })
            .then(function(provinceData) {
                $(WARD).html('<option value="">Chọn phường/xã</option>');
                if (provinceData.wards && provinceData.wards.length > 0) {
                    provinceData.wards.forEach((ward) => {
                        $(WARD).append(`<option value="${ward.name}" data-code="${ward.code}" ${ward_value != '' ? (ward.name == ward_value ? 'selected' : '') : ''}>${ward.name}</option>`);
                    });
                    $(WARD).attr('disabled', false);
                } else {
                    $(WARD).attr('disabled', true);
                }
            })
    };

    // Các hàm xử lý nhà trọ
    function goToHouse(houseId) {
        // Lấy URL hiện tại
        const currentUrl = window.location.pathname;
        
        // Chuyển đến nhà được chọn bằng GET request
        const url = new URL(currentUrl, window.location.origin);
        url.searchParams.set('house_id', houseId);
        
        // Redirect đến URL mới
        window.location.href = url.toString();
    }

    function validateForm() {
        // Kiểm tra dữ liệu bắt buộc
        const houseName = document.getElementById('house_name').value;
        const province = document.getElementById('province').value;
        const ward = document.getElementById('ward').value;
        const address = document.getElementById('address').value;
        const paymentDate = document.getElementById('payment_date').value;
        const dueDate = document.getElementById('due_date').value;
        
        if (!houseName || !province || !ward || !address || !paymentDate || !dueDate) {
            alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
            return false;
        }
        
        return true;
    }

    function editHouse(houseId) {
        // Tìm thông tin nhà trọ từ danh sách houses
        const houses = <?= json_encode($houses) ?>;
        const house = houses.find(h => h.id == houseId);
        
        if (!house) {
            Swal.fire({
                title: 'Lỗi',
                text: 'Không tìm thấy thông tin nhà trọ!',
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Đóng'
            });
            return;
        }

        // Mở modal thêm nhà trọ (không gọi getProvince vì sẽ gọi riêng)
        document.getElementById('addHouseModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Điền dữ liệu vào form
        document.getElementById('house_name').value = house.house_name;
        document.getElementById('address').value = house.address;
        document.getElementById('payment_date').value = house.payment_date;
        document.getElementById('due_date').value = house.due_date;
        
        // Điền địa chỉ từ database - gọi API một lần duy nhất
        const provinceSelect = document.getElementById('province');
        provinceSelect.innerHTML = '<option value="">Chọn tỉnh/thành phố</option>';
        
        // Gọi API để lấy danh sách tỉnh và tìm data-code
        fetch('https://provinces.open-api.vn/api/v2/')
            .then(function(response) {
                return response.json();
            })
            .then(function(provinces) {
                let selectedProvinceCode = null;
                
                provinces.forEach((province) => {
                    const option = document.createElement('option');
                    option.value = province.name;
                    option.textContent = province.name;
                    option.setAttribute('data-code', province.code);
                    
                    // Nếu là tỉnh của nhà trọ, đánh dấu selected và lưu code
                    if (province.name === house.province) {
                        option.selected = true;
                        selectedProvinceCode = province.code;
                    }
                    
                    provinceSelect.appendChild(option);
                });
                
                // Sau khi tạo xong tất cả option tỉnh, gọi API để lấy phường/xã
                if (selectedProvinceCode) {
                    fetch(`https://provinces.open-api.vn/api/v2/p/${selectedProvinceCode}?depth=2`)
                        .then(function(response) {
                            return response.json();
                        })
                        .then(function(provinceData) {
                            const wardSelect = document.getElementById('ward');
                            wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                            
                            if (provinceData.wards && provinceData.wards.length > 0) {
                                provinceData.wards.forEach((ward) => {
                                    const wardOption = document.createElement('option');
                                    wardOption.value = ward.name;
                                    wardOption.textContent = ward.name;
                                    wardOption.setAttribute('data-code', ward.code);
                                    
                                    // Nếu là phường/xã của nhà trọ, đánh dấu selected
                                    if (ward.name === house.ward) {
                                        wardOption.selected = true;
                                    }
                                    
                                    wardSelect.appendChild(wardOption);
                                });
                                wardSelect.disabled = false;
                            } else {
                                wardSelect.disabled = true;
                            }
                        })
                        .catch(function(err) {
                            console.log(err);
                        });
                }
            })
            .catch(function(err) {
                console.log(err);
            });
        
        // Thay đổi tiêu đề modal
        document.getElementById('modalTitle').textContent = 'Chỉnh sửa nhà trọ';
        
        // Thay đổi nút submit
        document.getElementById('submitButton').textContent = 'Cập nhật nhà trọ';
        
        // Thay đổi form action
        document.getElementById('houseForm').action = '<?= BASE_URL ?>/landlord/house/update';
        
        // Thêm input hidden để lưu house_id
        let hiddenInput = document.getElementById('house_id');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.id = 'house_id';
            hiddenInput.name = 'house_id';
            document.getElementById('houseForm').appendChild(hiddenInput);
        }
        hiddenInput.value = houseId;
    }

    function deleteHouse(houseId) {
        Swal.fire({
            title: 'Xác nhận xóa nhà trọ',
            text: 'Bạn có chắc chắn muốn xóa nhà trọ này? Hệ thống sẽ kiểm tra xem nhà trọ có phòng nào không trước khi xóa.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tạo form ẩn và submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= BASE_URL ?>/landlord/house/delete';
                form.style.display = 'none';

                // Thêm house_id vào form
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'house_id';
                input.value = houseId;
                form.appendChild(input);

                // Thêm CSRF token vào form
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = 'csrf_token';
                csrfInput.value = '<?= \Core\CSRF::getToken() ?>';
                form.appendChild(csrfInput);

                // Thêm form vào body và submit
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Event listeners cho dropdown
    $(document).ready(function() {
        $(PROVINCE).change(function() {
            getWard();
            // Reset ward khi thay đổi province
            $(WARD).html('<option value="">Chọn phường/xã</option>');
            $(WARD).attr('disabled', true);
        });
    });

    // Đóng modal khi click bên ngoài
    document.addEventListener('click', function(event) {
        const houseListModal = document.getElementById('houseListModal');
        const addHouseModal = document.getElementById('addHouseModal');
        
        if (event.target === houseListModal) {
            closeHouseListModal();
        }
        
        if (event.target === addHouseModal) {
            closeAddHouseModal();
        }
    });

    // Đóng modal khi nhấn ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeHouseListModal();
            closeAddHouseModal();
        }
    });
</script>