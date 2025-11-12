<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Quản lý báo cáo vi phạm</h1>
            <p class="mt-2 text-gray-600">Xử lý các báo cáo vi phạm từ người dùng</p>
        </div>
        <div class="flex space-x-3">
            <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 flex items-center">
                <i class="fas fa-check-double mr-2"></i>
                Xử lý tất cả
            </button>
            <button class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 flex items-center">
                <i class="fas fa-download mr-2"></i>
                Xuất Excel
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-flag text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Tổng báo cáo</dt>
                        <dd class="text-lg font-medium text-gray-900"><?php echo htmlspecialchars($globalTotalReports ?? ($totalReports ?? 0), ENT_QUOTES, 'UTF-8'); ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Chờ xử lý</dt>
                        <dd class="text-lg font-medium text-gray-900"><?php echo htmlspecialchars($countPending ?? 0, ENT_QUOTES, 'UTF-8'); ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-hourglass-half text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Đang xử lý</dt>
                        <dd class="text-lg font-medium text-gray-900"><?php echo htmlspecialchars($countProcessing ?? 0, ENT_QUOTES, 'UTF-8'); ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-check text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Đã xử lý</dt>
                        <dd class="text-lg font-medium text-gray-900"><?php echo htmlspecialchars($countResolved ?? 0, ENT_QUOTES, 'UTF-8'); ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <form method="GET" action="<?= BASE_URL ?>/admin/reports">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                <input type="text" name="search" value="<?= isset($filter['search']) ? htmlspecialchars($filter['search']) : '' ?>" placeholder="Nội dung báo cáo..." 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả</option>
                    <option value="pending" <?= (isset($filter['status']) && $filter['status'] === 'pending') ? 'selected' : '' ?>>Chờ xử lý</option>
                    <option value="reviewed" <?= (isset($filter['status']) && $filter['status'] === 'reviewed') ? 'selected' : '' ?>>Đang xử lý</option>
                    <option value="resolved" <?= (isset($filter['status']) && $filter['status'] === 'resolved') ? 'selected' : '' ?>>Đã xử lý</option>
                    <option value="rejected" <?= (isset($filter['status']) && $filter['status'] === 'rejected') ? 'selected' : '' ?>>Bị từ chối</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Loại báo cáo</label>
                <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả</option>
                    <option value="spam" <?= (isset($filter['type']) && $filter['type'] === 'spam') ? 'selected' : '' ?>>Spam</option>
                    <option value="fake" <?= (isset($filter['type']) && $filter['type'] === 'fake') ? 'selected' : '' ?>>Thông tin sai lệch</option>
                    <option value="scam" <?= (isset($filter['type']) && $filter['type'] === 'scam') ? 'selected' : '' ?>>Lừa đảo</option>
                    <option value="inappropriate" <?= (isset($filter['type']) && $filter['type'] === 'inappropriate') ? 'selected' : '' ?>>Nội dung không phù hợp</option>
                    <option value="violence" <?= (isset($filter['type']) && $filter['type'] === 'violence') ? 'selected' : '' ?>>Bạo lực</option>
                    <option value="other" <?= (isset($filter['type']) && $filter['type'] === 'other') ? 'selected' : '' ?>>Khác</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i>
                    Lọc
                </button>
                <a href="<?= BASE_URL ?>/admin/reports" class="w-full flex items-center justify-center bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-200 ml-2">
                        <i class="fas fa-times mr-2"></i>
                        Xóa
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Reports Table -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Danh sách báo cáo</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Báo cáo
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Người báo cáo
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Loại
                    </th>
                    <!-- Priority column removed as requested -->
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Trạng thái
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Ngày báo cáo
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Hành động
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($reports) || !is_array($reports)) : ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap" colspan="6">
                            <div class="text-sm text-gray-500">Không có báo cáo nào.</div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($reports as $r) :
                        $id = isset($r['id']) ? (int)$r['id'] : 0;
                        $title = isset($r['title']) ? htmlspecialchars($r['title']) : '-';
                        $description = isset($r['description']) ? htmlspecialchars($r['description']) : '';
                        $reporterName = isset($r['reporter_name']) ? htmlspecialchars($r['reporter_name']) : '-';
                        $reporterEmail = isset($r['reporter_email']) ? htmlspecialchars($r['reporter_email']) : '';
                        $type = isset($r['violattion_type']) ? $r['violattion_type'] : '';
                        $priority = isset($r['priority']) && $r['priority'] !== '' ? htmlspecialchars($r['priority']) : 'Trung bình';
                        $status = isset($r['status']) ? $r['status'] : '';
                        $created = isset($r['created_at']) && $r['created_at'] ? date('d/m/Y', strtotime($r['created_at'])) : '-';

                        // Type label
                        switch ($type) {
                            case 'spam': $typeLabel = 'Spam'; $typeClass = 'bg-red-100 text-red-800'; break;
                            case 'fake': $typeLabel = 'Thông tin sai lệch'; $typeClass = 'bg-orange-100 text-orange-800'; break;
                            case 'inappropriate': $typeLabel = 'Nội dung không phù hợp'; $typeClass = 'bg-purple-100 text-purple-800'; break;
                            case 'scam': $typeLabel = 'Lừa đảo'; $typeClass = 'bg-gray-100 text-gray-800'; break;
                            case 'violence': $typeLabel = 'Bạo lực'; $typeClass = 'bg-indigo-100 text-indigo-800'; break;
                            default: $typeLabel = $type !== '' ? htmlspecialchars($type) : 'Khác'; $typeClass = 'bg-gray-100 text-gray-800';
                        }

                        // Status label
                        switch ($status) {
                            case 'pending': $statusLabel = 'Chờ xử lý'; $statusClass = 'bg-red-100 text-red-800'; break;
                            case 'reviewed': $statusLabel = 'Đang xử lý'; $statusClass = 'bg-yellow-100 text-yellow-800'; break;
                            case 'resolved': $statusLabel = 'Đã xử lý'; $statusClass = 'bg-green-100 text-green-800'; break;
                            case 'rejected': $statusLabel = 'Bị từ chối'; $statusClass = 'bg-gray-100 text-gray-800'; break;
                            default: $statusLabel = $status !== '' ? htmlspecialchars($status) : 'Chưa xác định'; $statusClass = 'bg-gray-100 text-gray-800';
                        }
                    ?>
                        <tr data-report-id="<?= $id ?>">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900"><?php echo $title; ?></div>
                                <?php if (!empty($r['rental_post_id'])) : ?>
                                    <div class="text-sm text-gray-500">Bài đăng: "<?= htmlspecialchars($r['rental_post_id']) ?>"</div>
                                <?php endif; ?>
                                <?php if ($description !== '') : ?>
                                    <div class="text-sm text-gray-500"><?php echo $description; ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo $reporterName; ?></div>
                                <?php if ($reporterEmail !== '') : ?>
                                    <div class="text-sm text-gray-500"><?php echo $reporterEmail; ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $typeClass ?>">
                                    <?php echo $typeLabel; ?>
                                </span>
                            </td>
                            <!-- Priority column removed in frontend -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusClass ?>">
                                    <?php echo $statusLabel; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo $created; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="openReportModal(<?= $id ?>)" class="text-blue-600 hover:text-blue-900" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <!-- Mark as reviewed -->
                                    <?php if ($status !== 'reviewed') : ?>
                                    <button onclick="changeReportStatus(<?= $id ?>, 'reviewed')" class="text-yellow-600 hover:text-yellow-900" title="Đánh dấu Đang xử lý">
                                        <i class="fas fa-hourglass-half"></i>
                                    </button>
                                    <?php endif; ?>
                                    <!-- Mark as resolved -->
                                    <?php if ($status !== 'resolved') : ?>
                                    <button onclick="changeReportStatus(<?= $id ?>, 'resolved')" class="text-green-600 hover:text-green-900" title="Đánh dấu Đã xử lý">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                    <?php endif; ?>
                                    <!-- Mark as rejected -->
                                    <?php if ($status !== 'rejected') : ?>
                                    <button onclick="changeReportStatus(<?= $id ?>, 'rejected')" class="text-red-600 hover:text-red-900" title="Đánh dấu Bị từ chối">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if (!empty($pagination) && $pagination['total_pages'] > 1) : ?>
        <div class="mt-8">
            <?= \Helpers\Pagination::render($pagination, '', $queryParams) ?>
        </div>
    <?php endif; ?>
</div>

<!-- Report Detail Modal -->
<div id="reportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-5 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-flag text-white text-sm"></i>
                </div>
                <h2 id="reportModalTitle" class="text-xl font-semibold text-gray-800">Chi tiết báo cáo</h2>
            </div>
            <button onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div id="reportModalBody">
            <input type="hidden" id="report_id" value="">
            <?= \Core\CSRF::getTokenField() ?>

            <div class="mb-3">
                <label class="text-sm font-medium text-gray-700">Tiêu đề</label>
                <input id="report_title" type="text" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white" value="">
            </div>

            <div class="mb-3">
                <label class="text-sm font-medium text-gray-700">Người báo cáo</label>
                <input id="report_reporter" type="text" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white" value="">
            </div>

            <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">Loại</label>
                    <input id="report_type" type="text" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white" value="">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Trạng thái</label>
                    <input id="report_status" type="text" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white" value="">
                </div>
            </div>

            <div class="mb-3">
                <label class="text-sm font-medium text-gray-700">Bài đăng liên quan</label>
                <div class="flex items-center gap-2">
                    <input id="report_post" type="text" readonly class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-white" value="">
                    <a id="report_post_link" href="#" class="text-blue-600 underline text-sm hidden" target="_self">Mở bài đăng</a>
                </div>
            </div>

            <div class="mb-3">
                <label class="text-sm font-medium text-gray-700">Mô tả</label>
                <textarea id="report_description" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label class="text-sm font-medium text-gray-700">Hành động đã thực hiện</label>
                <textarea id="report_action" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="text-sm font-medium text-gray-700">Ghi chú</label>
                <textarea id="report_note" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="text-sm font-medium text-gray-700">Hình ảnh</label>
                <div id="report_images" class="flex flex-wrap gap-2"></div>
            </div>

            <div class="mb-3">
                <label class="text-sm font-medium text-gray-700">Ngày giải quyết</label>
                <input id="report_resolved_at" type="text" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white" value="">
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <button onclick="closeReportModal()" class="px-4 py-2 bg-gray-200 rounded-md">Đóng</button>
        </div>
    </div>
</div>

<script>
    const TYPE_LABELS = <?= json_encode($typeList ?? []) ?>;
    const STATUS_LABELS = <?= json_encode($statusList ?? []) ?>;
    function openReportModal(id) {
    fetch(`${App.appURL}admin/reports/get/${id}`, { credentials: 'same-origin' })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    showErrorMessage(data.message || 'Không tải được dữ liệu', 'error');
                    return;
                }
                const r = data.report;
                document.getElementById('report_id').value = r.id || '';
                document.getElementById('report_title').value = r.title || '-';
                document.getElementById('report_reporter').value = (r.reporter_name ? r.reporter_name : '-') + (r.reporter_email ? ' (' + r.reporter_email + ')' : '');
                document.getElementById('report_type').value = (r.violattion_type && TYPE_LABELS[r.violattion_type]) ? TYPE_LABELS[r.violattion_type] : (r.violattion_type || '');
                document.getElementById('report_status').value = (r.status && STATUS_LABELS[r.status]) ? STATUS_LABELS[r.status] : (r.status || '');
                document.getElementById('report_post').value = r.rental_post_id ? ('Bài đăng: ' + r.rental_post_id) : '-';
                // Populate link to the admin posts page to highlight the post
                try {
                    const postLink = document.getElementById('report_post_link');
                    if (r.rental_post_id) {
                        postLink.href = `${App.appURL}admin/posts?highlight_id=${encodeURIComponent(r.rental_post_id)}`;
                        postLink.classList.remove('hidden');
                    } else {
                        postLink.href = '#';
                        postLink.classList.add('hidden');
                    }
                } catch (e) {
                    console.error('Failed to set report post link', e);
                }
                document.getElementById('report_description').value = r.description || '-';
                document.getElementById('report_action').value = r.action_taken || '-';
                // Note
                document.getElementById('report_note').value = r.note || '-';

                // Images
                const imagesContainer = document.getElementById('report_images');
                imagesContainer.innerHTML = '';
                if (r.images) {
                    try {
                        let imgs = JSON.parse(r.images);
                        if (!Array.isArray(imgs)) imgs = [imgs];
                        imgs.forEach(src => {
                            if (!src) return;
                            const img = document.createElement('img');
                            img.src = src;
                            img.className = 'h-20 w-20 object-cover rounded-md border';
                            imagesContainer.appendChild(img);
                        });
                    } catch (e) {
                        // not JSON, try comma separated or single
                        const raw = r.images;
                        const list = raw.indexOf(',') !== -1 ? raw.split(',') : [raw];
                        list.forEach(src => {
                            src = src.trim();
                            if (!src) return;
                            const img = document.createElement('img');
                            img.src = src;
                            img.className = 'h-20 w-20 object-cover rounded-md border';
                            imagesContainer.appendChild(img);
                        });
                    }
                }

                // Resolved at
                const resolvedEl = document.getElementById('report_resolved_at');
                if (r.resolved_at && r.resolved_at !== '0000-00-00' && r.resolved_at !== null) {
                    const dt = new Date(r.resolved_at);
                    if (!isNaN(dt.getTime())) {
                        const dd = String(dt.getDate()).padStart(2, '0');
                        const mm = String(dt.getMonth() + 1).padStart(2, '0');
                        const yyyy = dt.getFullYear();
                        resolvedEl.value = dd + '/' + mm + '/' + yyyy;
                    } else {
                        resolvedEl.value = r.resolved_at;
                    }
                } else {
                    resolvedEl.value = '-';
                }

                document.getElementById('reportModal').classList.remove('hidden');
            })
            .catch(err => {
                console.error(err);
                showErrorMessage('Có lỗi khi tải chi tiết', 'error');
            });
    }

    function closeReportModal() {
        document.getElementById('reportModal').classList.add('hidden');
    }

    /**
     * Change report status via POST
     */
    function changeReportStatus(id, status) {
        const LABEL = {
            'reviewed': 'Đang xử lý',
            'resolved': 'Đã xử lý',
            'rejected': 'Bị từ chối'
        };

        // Use Swal.fire with textarea input (like users.php ban flow) to collect a note before updating status
        Swal.fire({
            icon: 'warning',
            title: `Xác nhận cập nhật "${LABEL[status] || status}"?`,
            input: 'textarea',
            inputPlaceholder: 'Nhập ghi chú (bắt buộc)...',
            inputAttributes: {
                'aria-label': 'Ghi chú'
            },
            showCancelButton: true,
            confirmButtonText: 'Cập nhật',
            cancelButtonText: 'Hủy',
            customClass: {
                container: 'swal2-modal-high-z',
            },
            backdrop: false,
            allowOutsideClick: false,
            preConfirm: (note) => {
                if (!note || String(note).trim() === '') {
                    Swal.showValidationMessage('Vui lòng nhập ghi chú');
                    return false;
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                    document.querySelector('input[name="csrf_token"]')?.value || '';

                return fetch(`${App.appURL}admin/reports/update-status/${id}`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `status=${encodeURIComponent(status)}&note=${encodeURIComponent(note)}&csrf_token=${encodeURIComponent(csrfToken)}`
                })
                .then(res => res.json())
                .then(data => {
                    if (!data || !data.success) {
                        throw new Error(data?.message || 'Có lỗi xảy ra');
                    }
                    return data;
                })
                .catch(err => {
                    Swal.showValidationMessage(`Lỗi: ${err.message || err}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (!result.isConfirmed) return;

            // result.value contains the JSON returned from the server in preConfirm
            const data = result.value;
            try {
                if (!data || !data.success) {
                    showErrorMessage(data?.message || 'Cập nhật thất bại', 'error');
                    return;
                }

                App.showSuccessMessage(data.message || 'Cập nhật trạng thái thành công', 'success');
                // update modal and table quickly then reload
                const updated = data.report;
                if (updated) {
                    const modal = document.getElementById('reportModal');
                    if (modal && !modal.classList.contains('hidden')) {
                        document.getElementById('report_status').value = updated.status_label || (updated.status || '-');
                        document.getElementById('report_action').value = updated.action_taken || '-';
                        document.getElementById('report_note').value = updated.note || '-';
                        // update resolved at
                        const resolvedEl = document.getElementById('report_resolved_at');
                        if (updated.resolved_at && updated.resolved_at !== '0000-00-00' && updated.resolved_at !== null) {
                            const dt = new Date(updated.resolved_at);
                            if (!isNaN(dt.getTime())) {
                                const dd = String(dt.getDate()).padStart(2, '0');
                                const mm = String(dt.getMonth() + 1).padStart(2, '0');
                                const yyyy = dt.getFullYear();
                                resolvedEl.value = dd + '/' + mm + '/' + yyyy;
                            } else {
                                resolvedEl.value = updated.resolved_at;
                            }
                        } else {
                            resolvedEl.value = '-';
                        }
                    }

                    // Update status badge and action buttons in table row (row identified by data-report-id)
                    const row = document.querySelector(`tr[data-report-id="${id}"]`);
                    if (row) {
                        const statusSpan = row.querySelector('td:nth-child(4) span');
                        if (statusSpan) {
                            statusSpan.textContent = updated.status_label || (updated.status || '');
                            statusSpan.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' +
                                (updated.status === 'resolved' ? 'bg-green-100 text-green-800' : (updated.status === 'reviewed' ? 'bg-yellow-100 text-yellow-800' : (updated.status === 'rejected' ? 'bg-gray-100 text-gray-800' : 'bg-gray-100 text-gray-800')));
                        }

                        try {
                            const btnReviewed = row.querySelector('button[title="Đánh dấu Đang xử lý"]');
                            const btnResolved = row.querySelector('button[title="Đánh dấu Đã xử lý"]');
                            const btnRejected = row.querySelector('button[title="Đánh dấu Bị từ chối"]');

                            if (btnReviewed) btnReviewed.style.display = (updated.status === 'reviewed') ? 'none' : '';
                            if (btnResolved) btnResolved.style.display = (updated.status === 'resolved') ? 'none' : '';
                            if (btnRejected) btnRejected.style.display = (updated.status === 'rejected') ? 'none' : '';
                        } catch (e) {
                            console.error('Failed to adjust action buttons visibility', e);
                        }
                    }
                }

                // reload after short timeout so UI stays consistent
                setTimeout(() => location.reload(), 1500);

            } catch (e) {
                console.error('Error handling update response', e);
                showErrorMessage('Có lỗi khi xử lý phản hồi', 'error');
            }
        });
    }
</script>

