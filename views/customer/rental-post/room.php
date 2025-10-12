<!-- 
    Author: Huy Nguyen
    Date: 2025-10-06
    Purpose: base rental post list
 -->

<div class="min-h-screen bg-gray-50 mt-12">
    <!-- Filter Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl">
                <?php require_once ROOT_PATH . '/views/customer/layouts/filters.php' ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900"><?= $titlePage ?> <?= date('m/Y') ?></h1>
                    <p class="text-gray-600 mt-1">Tìm kiếm phòng trọ phù hợp với nhu cầu của bạn</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-700">Có <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-green-100 text-green-700 font-bold text-lg"><?= count($posts) ?></span> bài đăng</span>
                </div>
            </div>
        </div>

        <!-- Sort Controls -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <label class="text-sm font-medium text-gray-700">Sắp xếp theo:</label>
                    <form id="sort" method="GET">
                        <select name="sort" class="text-sm border-gray-300 rounded-lg px-4 py-2 focus:ring-green-500 focus:border-green-500 bg-white shadow-sm" onchange="submitBothForms()">
                            <option value="newest" <?= $currentFilters['sort'] == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                            <option value="price_asc" <?= $currentFilters['sort'] == 'price_asc' ? 'selected' : '' ?>>Giá thấp đến cao</option>
                            <option value="price_desc" <?= $currentFilters['sort'] == 'price_desc' ? 'selected' : '' ?>>Giá cao đến thấp</option>
                            <option value="area_desc" <?= $currentFilters['sort'] == 'area_desc' ? 'selected' : '' ?>>Diện tích lớn nhất</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="space-y-6">
            <?php if (count($posts) > 0) { ?>
                <?php foreach ($posts as $post) { ?>
                    <?php include __DIR__ . '/shared/list-item.php'; ?>
                <?php } ?>

                <!-- Pagination -->
                <?php if (!empty($pagination) && $pagination['total_pages'] > 1) : ?>
                    <div class="mt-8">
                        <?= \Helpers\Pagination::render($pagination, '', $queryParams) ?>
                    </div>
                <?php endif; ?>
            <?php } else { ?>
                <div class="bg-white border border-gray-200 rounded-2xl p-12 text-center shadow-sm">
                    <div class="mx-auto w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-4">
                        <i class="fas fa-search text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Không tìm thấy bài đăng phù hợp</h3>
                    <p class="text-gray-600 mb-6">Hãy thử điều chỉnh tiêu chí lọc hoặc từ khóa tìm kiếm để có kết quả tốt hơn.</p>
                    <button class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-refresh mr-2"></i>Làm mới tìm kiếm
                    </button>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    function submitBothForms() {
        const form1 = document.getElementById('sort');
        const form2 = document.getElementById('filters');
        let baseUrl = form1.action.split('?')[0];
        // Tạo đối tượng FormData để gộp dữ liệu 2 form
        const data = new FormData(); // form2 là form chính (vì có action)

        // Thêm dữ liệu từ form1 vào
        new FormData(form2).forEach((value, key) => data.append(key, value));

        // Lấy dữ liệu từ form 1
        new FormData(form1).forEach((value, key) => data.append(key, value));

        // 3️⃣ Tạo URL query string mới
        const query = new URLSearchParams(data).toString();

        // 4️⃣ Điều hướng (giống như submit form)
        window.location.href = baseUrl + '?' + query;
    }
</script>