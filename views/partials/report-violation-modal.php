<!--
	Author: Huy Nguyen
	Date: 2025-10-20
	Purpose: modal report violation
-->

<!-- Modal -->
<div id="reportViolationModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full overflow-y-auto bg-black/40">
    <div class="relative w-full max-w-lg bg-white rounded-lg shadow dark:bg-gray-800">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-red-500"></i>
                Báo cáo vi phạm
            </h3>
            <button type="button"
                class="text-gray-400 hover:text-gray-900 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg p-1.5"
                data-modal-hide="reportViolationModal">
                ✕
            </button>
        </div>

        <!-- Body -->
        <form id="reportForm" class="p-5 space-y-4" enctype="multipart/form-data">
            <!-- Target -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Đối tượng báo cáo</label>
                <select name="target_type"
                    class="w-full mt-1 p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">-- Chọn loại --</option>
                    <option value="post">Bài đăng</option>
                    <option value="user">Người dùng</option>
                    <option value="comment">Bình luận</option>
                    <option value="review">Đánh giá</option>
                    <option value="room">Phòng trọ</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tiêu đề / tên đối tượng</label>
                <input type="text" name="target_title"
                    class="w-full mt-1 p-2 border rounded-lg dark:bg-gray-700 dark:text-white"
                    placeholder="Nhập tiêu đề bài đăng hoặc tên người dùng...">
            </div>

            <!-- Violation -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Loại vi phạm</label>
                <select name="violation_type" required
                    class="w-full mt-1 p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">-- Chọn loại vi phạm --</option>
                    <option value="spam">Spam / Quảng cáo</option>
                    <option value="fake">Giả mạo / Sai sự thật</option>
                    <option value="scam">Lừa đảo</option>
                    <option value="inappropriate">Nội dung không phù hợp</option>
                    <option value="violence">Bạo lực / Kích động</option>
                    <option value="other">Khác...</option>
                </select>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mô tả chi tiết</label>
                <textarea name="description" rows="3"
                    class="w-full mt-1 p-2 border rounded-lg dark:bg-gray-700 dark:text-white"
                    placeholder="Nhập chi tiết vi phạm..."></textarea>
            </div>

            <!-- Evidence -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Hình ảnh minh chứng (tùy chọn)
                </label>
                <input type="file" name="evidence_urls[]" multiple accept="image/*"
                    class="w-full mt-1 p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                <p class="text-xs text-gray-500 mt-1">Tối đa 3 hình ảnh (PNG, JPG, JPEG)</p>
            </div>

            <!-- Footer -->
            <div class="flex justify-end pt-4 border-t dark:border-gray-700">
                <button id="cancel" type="button" data-modal-hide="reportViolationModal"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg mr-2">
                    Hủy
                </button>
                <button type="button" id="sendReportViolation"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                    Gửi báo cáo
                </button>
            </div>
        </form>
    </div>
</div>
