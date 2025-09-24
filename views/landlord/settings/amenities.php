<!--
    Author: Huy Nguyen
    Date: 2025-01-15
    Purpose: Amenities management for landlord
-->
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Quản lý tiện ích phòng</h1>
        <p class="text-gray-600 mt-2">Quản lý tiện ích phòng hệ thống và tiện ích cá nhân</p>
    </div>

    <!-- Tabs Navigation -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button onclick="switchTab('system')" class="tab-button py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap border-blue-500 text-blue-600"
                    id="system-tab">
                    <i class="fas fa-globe mr-2"></i>
                    Tiện ích hệ thống
                </button>
                <button onclick="switchTab('user')" class="tab-button py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                    id="user-tab">
                    <i class="fas fa-user mr-2"></i>
                    Tiện ích của tôi
                </button>
            </nav>
        </div>
    </div>

    <!-- System Amenities Tab -->
    <div id="system-amenities" class="tab-item">
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Tiện ích hệ thống</h2>
            <p class="text-gray-600">Các tiện ích phòng được cung cấp bởi hệ thống, chỉ có thể xem</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (count($systemAmenities) > 0) { ?>
                <?php foreach ($systemAmenities as $amenity) { ?>
                    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($amenity['rental_amenity_name']) ?></h3>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-globe mr-1"></i>
                                    Hệ thống
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $amenity['rental_amenity_status'] == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <i class="fas <?= $amenity['rental_amenity_status'] == 'active' ? 'fa-check' : 'fa-times' ?> mr-1"></i>
                                    <?= $amenity['rental_amenity_status'] == 'active' ? 'Hoạt động' : 'Tạm dừng' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <!-- User Amenities Tab -->
    <div id="user-amenities" class="tab-item hidden">
        <div class="flex items-center justify-start gap-10">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Tiện ích của tôi</h2>
                <p class="text-gray-600">Các tiện ích phòng do bạn tạo, có thể chỉnh sửa và xóa</p>
            </div>
            <button onclick="openCreateAmenityModal()" class="ml-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded text-xs transition-colors">
                <i class="fas fa-plus mr-1"></i>
                Thêm
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (count($userAmenities) > 0) { ?>
                <?php foreach ($userAmenities as $amenity) { ?>
                    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($amenity['rental_amenity_name']) ?></h3>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="openEditAmenityModal(<?= htmlspecialchars(json_encode($amenity)) ?>)"
                                    class="text-blue-600 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50 transition-colors"
                                    title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteAmenity(<?= $amenity['id'] ?>)"
                                    class="text-red-600 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors"
                                    title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $amenity['rental_amenity_status'] == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <i class="fas <?= $amenity['rental_amenity_status'] == 'active' ? 'fa-check' : 'fa-times' ?> mr-1"></i>
                                    <?= $amenity['rental_amenity_status'] == 'active' ? 'Hoạt động' : 'Tạm dừng' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="col-span-full">
                    <div class="bg-white border border-dashed border-gray-300 rounded-xl p-10 flex flex-col items-center justify-center text-center hover:shadow-sm transition-shadow">
                        <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                            <i class="fas fa-star text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Chưa có tiện ích nào</h3>
                        <p class="text-gray-600 mb-6 max-w-md">Hãy thêm tiện ích để mô tả rõ ràng các trang bị, dịch vụ đi kèm trong phòng.</p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="amenityModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-40 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 id="modalTitle" class="text-lg font-medium text-gray-900">Thêm tiện ích mới</h3>
                <button onclick="closeAmenityModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="amenityForm" class="space-y-4">
                <input type="hidden" id="amenityId" name="id">
                <?= \Core\CSRF::getTokenField() ?>
                <!-- Amenity Name -->
                <div>
                    <label for="rental_amenity_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Tên tiện ích <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="rental_amenity_name" name="rental_amenity_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="VD: Điều hòa, Tủ lạnh, Máy giặt" required>
                </div>
                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" id="rental_amenity_status" name="rental_amenity_status" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Kích hoạt tiện ích</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeAmenityModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Hủy
                    </button>
                    <button type="button" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors saveAmenityBtn">
                        <i class="fas fa-save mr-2"></i>
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
