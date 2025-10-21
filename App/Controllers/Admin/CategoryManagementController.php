<?php
/*

* Author: Nguyen Xuan Duong
* Date: 2025-10-17
* Purpose: Build Category Management Controller
*/

namespace App\Controllers\Admin;
use Core\CSRF;
use Core\Response;
use Core\Session;
use Core\ViewRender;
use Helpers\Validate;

class CategoryManagementController extends AdminController {
    protected $title = 'Quản lí danh mục';

    public function index() {
        // Lấy thông số phân trang và lọc từ request
        $page = $this->request->get('page') != '' ? (int) $this->request->get('page') : 1;
        $limit = $this->limit;
        $offset = ($page - 1) * $limit;

        // Filters: search, type (system|user|all), status
        $search = trim($this->request->get('search', ''));
        $type = $this->request->get('type', 'all');
        $status = $this->request->get('status', null);

        // Fetch all categories (respecting status if provided)
        $allRawCategories = $this->rentalCategoryModel->getAllRentalCategories(false, false, $status ?: null);

        // Get admin user ids via model helper
        $adminUserIds = $this->rentalCategoryModel->getAdminUserIds();

        // Apply type filter: 'system' => owner_id is null OR owner is admin; 'landlord' => owner exists and not admin; 'all' => all
        if ($type === 'system') {
            $allCategories = array_values(array_filter($allRawCategories, function($c) use ($adminUserIds) {
                $owner = $c['owner_id'] ?? null;
                return empty($owner) || in_array((int)$owner, $adminUserIds);
            }));
        } elseif ($type === 'landlord') {
            $allCategories = array_values(array_filter($allRawCategories, function($c) use ($adminUserIds) {
                $owner = $c['owner_id'] ?? null;
                return !empty($owner) && !in_array((int)$owner, $adminUserIds);
            }));
        } else {
            $allCategories = $allRawCategories;
        }

        // Also prepare system/user lists for tabs if needed
        $systemCategories = array_values(array_filter($allRawCategories, function($c) use ($adminUserIds) {
            $owner = $c['owner_id'] ?? null;
            return empty($owner) || in_array((int)$owner, $adminUserIds);
        }));
        $userCategories = array_values(array_filter($allRawCategories, function($c) use ($adminUserIds) {
            $owner = $c['owner_id'] ?? null;
            return !empty($owner) && !in_array((int)$owner, $adminUserIds);
        }));

        // Apply search filter (case-insensitive) on rental_category_name
        if ($search !== '') {
            $filtered = array_filter($allCategories, function($c) use ($search) {
                return stripos($c['rental_category_name'] ?? '', $search) !== false;
            });
            $allCategories = array_values($filtered);
        }

        $totalCategories = count($allCategories);

        // Paginate (simple array slice)
        $pagedCategories = array_slice($allCategories, $offset, $limit);

        $pagination = $this->getPagination($page, $totalCategories, $limit, $offset);

        // Prepare query params for links
        $queryParams = [];
        if ($search !== '') $queryParams['search'] = $search;
        if ($type !== 'all') $queryParams['type'] = $type;
        if ($status) $queryParams['status'] = $status;

        // Get validation errors and old input from session (if any) and then clear them
        $validationErrors = Session::get('validation_errors', []);
        $oldInput = Session::get('old_input', []);
        Session::delete('validation_errors');
        Session::delete('old_input');

        // Render view
        ViewRender::renderWithLayout('admin/categories/categories', [
            'categories' => $pagedCategories,
            'systemCategories' => $systemCategories,
            'userCategories' => $userCategories,
            'adminUserIds' => $adminUserIds,
            'pagination' => $pagination,
            'queryParams' => $queryParams,
            'filter' => [
                'search' => $search,
                'type' => $type,
                'status' => $status
            ],
            'validationErrors' => $validationErrors,
            'oldInput' => $oldInput,
            'title' => $this->title
        ], 'admin/layouts/app');
    }

    public function store() {
        $request = $this->request->post();

        if (!CSRF::validatePostRequest()) {
            return Response::json(['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại'], 403);
        }

        $name = trim($request['rental_category_name'] ?? '');
        // Normalize status from request value ('active' expected), fallback to 'inactive'
        $status = (isset($request['rental_category_status']) && $request['rental_category_status'] === 'active') ? 'active' : 'inactive';

        if ($name === '') {
            return Response::json(['success' => false, 'message' => 'Tên danh mục không được để trống', 'validationErrors' => ['rental_category_name' => 'Tên danh mục không được để trống']], 400);
        }

        // Create-only endpoint. Updates should call update($id).
        $data = [
            'rental_category_name' => $name,
            'rental_category_status' => $status,
            'owner_id' => $this->userID ?: null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $res = $this->rentalCategoryModel->createRentalCategory($data);
        if ($res) {
            return Response::json(['success' => true, 'message' => 'Tạo danh mục thành công'], 200);
        }
        return Response::json(['success' => false, 'message' => 'Không thể tạo danh mục'], 500);
    }

    /**
     * Return category data for editing (AJAX)
     */
    public function edit($id) {
        try {
            $category = $this->rentalCategoryModel->table('rental_categories')->where('id', $id)->where('deleted', 0)->first();
            if (!$category) {
                return Response::json(['success' => false, 'message' => 'Danh mục không tồn tại'], 404);
            }
            return Response::json(['success' => true, 'category' => $category], 200);
        } catch (\Exception $e) {
            error_log('Error in CategoryManagementController@edit: ' . $e->getMessage());
            return Response::json(['success' => false, 'message' => 'Có lỗi xảy ra'], 500);
        }
    }

    /**
     * Update category
     */
    public function update($id) {
        if (!$this->request->isPost()) {
            return Response::json(['success' => false, 'message' => 'Phương thức không hợp lệ'], 405);
        }
        if (!CSRF::validatePostRequest()) {
            return Response::json(['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại'], 403);
        }

        $request = $this->request->post();
        $name = trim($request['rental_category_name'] ?? '');
        $status = (isset($request['rental_category_status']) && $request['rental_category_status'] === 'active') ? 'active' : 'inactive';

        if ($name === '') {
            return Response::json(['success' => false, 'message' => 'Tên danh mục không được để trống', 'validationErrors' => ['rental_category_name' => 'Tên danh mục không được để trống']], 400);
        }

        $existing = $this->rentalCategoryModel->table('rental_categories')->where('id', $id)->first();
        if (!$existing) {
            return Response::json(['success' => false, 'message' => 'Danh mục không tồn tại'], 404);
        }

        $data = [
            'rental_category_name' => $name,
            'rental_category_status' => $status,
            'owner_id' => $existing['owner_id'] ?? ($this->userID ?: null),
            'created_at' => $existing['created_at'] ?? date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $updated = $this->rentalCategoryModel->updateRentalCategory($id, $data);
        if ($updated !== false) {
            return Response::json(['success' => true, 'message' => 'Cập nhật danh mục thành công'], 200);
        }
        return Response::json(['success' => false, 'message' => 'Không thể cập nhật danh mục'], 500);
    }

    public function delete($id) {
        if (!$this->request->isPost()) {
            return Response::json(['success' => false, 'message' => 'Phương thức không hợp lệ'], 405);
        }
        if (!CSRF::validatePostRequest()) {
            return Response::json(['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại'], 403);
        }

        // Find category
        $category = $this->rentalCategoryModel->table('rental_categories')->where('id', $id)->first();
        if (!$category) {
            return Response::json(['success' => false, 'message' => 'Danh mục không tồn tại'], 404);
        }

        // Allow deleting any category (including system/admin-owned)
        $deleted = $this->rentalCategoryModel->deleteRentalCategory($id);
        if ($deleted) {
            return Response::json(['success' => true, 'message' => 'Xóa danh mục thành công'], 200);
        }
        return Response::json(['success' => false, 'message' => 'Không thể xóa danh mục'], 500);
    }

    public function toggleStatus($id) {
        if (!$this->request->isPost()) {
            return Response::json(['success' => false, 'message' => 'Phương thức không hợp lệ'], 405);
        }
        if (!CSRF::validatePostRequest()) {
            return Response::json(['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại'], 403);
        }

        $status = $this->request->post('status', null);
        if ($status !== 'active' && $status !== 'inactive') {
            return Response::json(['success' => false, 'message' => 'Trạng thái không hợp lệ'], 400);
        }

        $updated = $this->rentalCategoryModel->table('rental_categories')->where('id', $id)->update([
            'rental_category_status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($updated !== false) {
            return Response::json(['success' => true, 'message' => 'Cập nhật trạng thái thành công'], 200);
        }
        return Response::json(['success' => false, 'message' => 'Không thể cập nhật trạng thái'], 500);
    }
}
?>