<!--
Author: Nguyen Xuan Duong
Date: 2025-08-29
Purpose: Build Nav for Landlord Layout
-->

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

<!-- Modal thêm nhà trọ -->
<div id="addHouseModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] flex flex-col">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0 bg-white">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-home text-white text-sm"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Tạo mới một tòa nhà cho thuê</h2>
            </div>
            <button onclick="closeAddHouseModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto min-h-0">
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
                            <input type="text" id="house_name" name="house_name" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
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
                            <select id="province" name="province" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none">
                                <option value="">Chọn tỉnh/thành phố</option>
                            </select>
                            <label for="province" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Tỉnh/Thành phố <span class="text-red-500">*</span></label>
                        </div>

                        <!-- Quận/Huyện -->
                        <div class="relative">
                            <select id="district" name="district" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none" disabled>
                                <option value="">Chọn quận/huyện</option>
                            </select>
                            <label for="district" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Quận/Huyện <span class="text-red-500">*</span></label>
                        </div>

                        <!-- Phường/Xã -->
                        <div class="relative">
                            <select id="ward" name="ward" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none" disabled>
                                <option value="">Chọn phường/xã</option>
                            </select>
                            <label for="ward" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white px-1 text-gray-500 transition-all duration-200 pointer-events-none text-base peer-focus:top-0 peer-focus:text-xs peer-focus:text-blue-500 peer-focus:font-medium peer-[:not([value=''])]:top-0 peer-[:not([value=''])]:text-xs peer-[:not([value=''])]:text-blue-500 peer-[:not([value=''])]:font-medium">Phường/Xã <span class="text-red-500">*</span></label>
                        </div>

                        <!-- Địa chỉ chi tiết -->
                        <div class="relative md:col-span-2">
                            <input type="text" id="address" name="address" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
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
                                <input type="number" id="payment_date" name="payment_date" min="1" max="28" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
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
                                <input type="number" id="due_date" name="due_date" min="1" max="28" class="peer w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-transparent outline-none placeholder-transparent" placeholder=" ">
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
        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-3 p-6 border-t border-gray-200 flex-shrink-0 bg-white">
            <button onclick="closeAddHouseModal()" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                Đóng
            </button>
            <button onclick="createHouse()" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                Tạo tòa nhà
            </button>
        </div>
    </div>
</div>

<script>
    // Khai báo biến cho selectors
    const PROVINCE = '#province';
    const DISTRICT = '#district';
    const WARD = '#ward';

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
    }

    // Reset form địa chỉ
    function resetAddressForm() {
        $(PROVINCE).html('<option value="">Chọn tỉnh/thành phố</option>');
        $(DISTRICT).html('<option value="">Chọn quận/huyện</option>');
        $(DISTRICT).attr('disabled', true);
        $(WARD).html('<option value="">Chọn phường/xã</option>');
        $(WARD).attr('disabled', true);
        $('#address').val('');
    }

    // Lấy tên tỉnh thành phố
    window.getProvince = function(province_value) {
        fetch('https://esgoo.net/api-tinhthanh/1/0.htm')
            .then(function(response) {
                return response.json();
            })
            .then(function(response) {
                response.data.forEach((province) => {
                    $(PROVINCE).append(
                        `<option value="${province.name}" data-id="${province.id}" ${province_value != '' ? (province.name == province_value ? 'selected' : '') : ''}>${
                             province.name
                         }</option>`
                    );
                });
            })
            .catch(function(err) {
                console.log(err);
            });
    };

    // Lấy danh sách quận huyện
    window.getDistrict = function(district_value) {
        const selectedOption = $(PROVINCE + ' option:selected');
        const dataID = selectedOption.attr('data-id');

        fetch('https://esgoo.net/api-tinhthanh/2/' + dataID + '.htm')
            .then(function(response) {
                return response.json();
            })
            .then(function(response) {
                $(DISTRICT).html('<option value="">Chọn quận/huyện</option>');
                $(WARD).html('<option value="">Chọn phường xã</option>');
                response.data.forEach((district) => {
                    $(DISTRICT).append(`<option value="${district.name}" data-id="${district.id}" ${district.name == district_value ? 'selected' : ''}>${district.name}</option>`);
                });
                $(DISTRICT).removeAttr('disabled');
            });
    };

    // Lấy danh sách phường xã
    window.getWard = function(ward_value) {
        const selectedOption = $(DISTRICT + ' option:selected');
        const dataID = selectedOption.attr('data-id');

        fetch('https://esgoo.net/api-tinhthanh/3/' + dataID + '.htm')
            .then(function(response) {
                return response.json();
            })
            .then(function(response) {
                $(WARD).html('<option value="">Chọn phường xã</option>');
                response.data.forEach((ward) => {
                    $(WARD).append(`<option value="${ward.name}" data-id="${ward.id}" ${ward_value != '' ? (ward.name == ward_value ? 'selected' : '') : ''}>${ward.name}</option>`);
                });
                $(WARD).removeAttr('disabled');
            });
    };

    function createHouse() {
        // Lấy dữ liệu từ form
        const formData = {
            house_name: document.getElementById('house_name').value,
            province: document.getElementById('province').value,
            district: document.getElementById('district').value,
            ward: document.getElementById('ward').value,
            address: document.getElementById('address').value,
            payment_date: document.getElementById('payment_date').value,
            due_date: document.getElementById('due_date').value
        };

        // Kiểm tra dữ liệu bắt buộc
        if (!formData.house_name || !formData.province || !formData.district || !formData.ward || !formData.address || !formData.payment_date || !formData.due_date) {
            alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
            return;
        }

        // Gửi dữ liệu lên server (có thể thay đổi theo API của bạn)
        console.log('Dữ liệu nhà trọ:', formData);

        // TODO: Gọi API tạo nhà trọ
        // fetch('/api/houses', {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/json',
        //     },
        //     body: JSON.stringify(formData)
        // });

        alert('Tạo nhà trọ thành công!');
        closeAddHouseModal();
    }

    // Event listeners cho dropdown
    $(document).ready(function() {
        $(PROVINCE).change(function() {
            getDistrict();
            // Reset ward khi thay đổi province
            $(WARD).html('<option value="">Chọn phường/xã</option>');
            $(WARD).attr('disabled', true);
        });

        $(DISTRICT).change(function() {
            getWard();
        });
    });

    // Đóng modal khi click bên ngoài
    document.getElementById('addHouseModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddHouseModal();
        }
    });

    // Đóng modal khi nhấn ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddHouseModal();
        }
    });
</script>