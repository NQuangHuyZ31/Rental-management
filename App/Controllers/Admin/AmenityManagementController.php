<?php
/*

* Author: Automated
* Date: 2025-10-17
* Purpose: Admin Amenity Management Controller (similar to CategoryManagementController)
*/

namespace App\Controllers\Admin;

use Core\CSRF;
use Core\Response;
use Core\Session;
use Core\ViewRender;

class AmenityManagementController extends AdminController
{
    protected $title = 'Quản lí tiện ích';

    public function index()
    {
        $page   = $this->request->get('page') != '' ? (int) $this->request->get('page') : 1;
        $limit  = $this->limit;
        $offset = ($page - 1) * $limit;

        $search = trim($this->request->get('search', ''));
        $type   = $this->request->get('type', 'all');
        $status = $this->request->get('status', null);

        $allRaw = $this->rentalAmenityModel->getAllRentalAmenities(false, false, $status ?: null);

        // get admin ids via model helper
        $adminUserIds = $this->rentalAmenityModel->getAdminUserIds();

        if ($type === 'system') {
            $all = array_values(
                array_filter($allRaw, function ($c) use ($adminUserIds) {
                    $owner = $c['owner_id'] ?? null;
                    return empty($owner) || in_array((int) $owner, $adminUserIds);
                })
            );
        } elseif ($type === 'landlord') {
            $all = array_values(
                array_filter($allRaw, function ($c) use ($adminUserIds) {
                    $owner = $c['owner_id'] ?? null;
                    return !empty($owner) && !in_array((int) $owner, $adminUserIds);
                })
            );
        } else {
            $all = $allRaw;
        }

        if ($search !== '') {
            $filtered = array_filter($all, function ($c) use ($search) {
                return stripos($c['rental_amenity_name'] ?? '', $search) !== false;
            });
            $all = array_values($filtered);
        }

        $total      = count($all);
        $paged      = array_slice($all, $offset, $limit);
        $pagination = $this->getPagination($page, $total, $limit, $offset);

        $queryParams = [];
        if ($search !== '') {
            $queryParams['search'] = $search;
        }
        if ($type !== 'all') {
            $queryParams['type'] = $type;
        }
        if ($status) {
            $queryParams['status'] = $status;
        }

        // get validation/old input from session
        $validationErrors = Session::get('validation_errors', []);
        $oldInput         = Session::get('old_input', []);
        Session::delete('validation_errors');
        Session::delete('old_input');

        ViewRender::renderWithLayout(
            'admin/amenities/amenities',
            [
                'amenities'       => $paged,
                'systemAmenities' => array_values(
                    array_filter($allRaw, function ($c) use ($adminUserIds) {
                        $owner = $c['owner_id'] ?? null;
                        return empty($owner) || in_array((int) $owner, $adminUserIds);
                    })
                ),
                'userAmenities' => array_values(
                    array_filter($allRaw, function ($c) use ($adminUserIds) {
                        $owner = $c['owner_id'] ?? null;
                        return !empty($owner) && !in_array((int) $owner, $adminUserIds);
                    })
                ),
                'adminUserIds'     => $adminUserIds,
                'pagination'       => $pagination,
                'queryParams'      => $queryParams,
                'filter'           => [
                    'search' => $search,
                    'type'   => $type,
                    'status' => $status,
                ],
                'validationErrors' => $validationErrors,
                'oldInput'         => $oldInput,
                'title'            => $this->title,
            ],
            'admin/layouts/app'
        );
    }

    public function store()
    {
        $request = $this->request->post();

        if (!CSRF::validatePostRequest()) {
            return Response::json([
                'success' => false,
                'message' => 'Có lỗi xảy ra. Vui lòng thử lại',
            ], 403);
        }

        $name   = trim($request['rental_amenity_name'] ?? '');
        $status = (isset($request['rental_amenity_status']) && $request['rental_amenity_status'] === 'active')
            ? 'active'
            : 'inactive';

        if ($name === '') {
            return Response::json([
                'success'          => false,
                'message'          => 'Tên tiện ích không được để trống',
                'validationErrors' => [
                    'rental_amenity_name' => 'Tên tiện ích không được để trống',
                ],
            ], 400);
        }

        $data = [
            'rental_amenity_name'   => $name,
            'rental_amenity_status' => $status,
            'owner_id'              => $this->userID ?: null,
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
        ];

        $res = $this->rentalAmenityModel->createRentalAmenity($data);

        if ($res) {
            return Response::json([
                'success' => true,
                'message' => 'Tạo tiện ích thành công',
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Không thể tạo tiện ích',
        ], 500);
    }

    public function edit($id)
    {
        try {
            $amenity = $this->rentalAmenityModel
                ->table('rental_amenities')
                ->where('id', $id)
                ->where('deleted', 0)
                ->first();

            if (!$amenity) {
                return Response::json([
                    'success' => false,
                    'message' => 'Tiện ích không tồn tại',
                ], 404);
            }

            return Response::json([
                'success' => true,
                'amenity' => $amenity,
            ], 200);
        } catch (\Exception $e) {
            error_log('Error in AmenityManagementController@edit: ' . $e->getMessage());
            return Response::json([
                'success' => false,
                'message' => 'Có lỗi xảy ra',
            ], 500);
        }
    }

    public function update($id)
    {
        if (!$this->request->isPost()) {
            return Response::json([
                'success' => false,
                'message' => 'Phương thức không hợp lệ',
            ], 405);
        }

        if (!CSRF::validatePostRequest()) {
            return Response::json([
                'success' => false,
                'message' => 'Có lỗi xảy ra. Vui lòng thử lại',
            ], 403);
        }

        $request = $this->request->post();
        $name    = trim($request['rental_amenity_name'] ?? '');
        $status  = (isset($request['rental_amenity_status']) && $request['rental_amenity_status'] === 'active')
            ? 'active'
            : 'inactive';

        if ($name === '') {
            return Response::json([
                'success'          => false,
                'message'          => 'Tên tiện ích không được để trống',
                'validationErrors' => [
                    'rental_amenity_name' => 'Tên tiện ích không được để trống',
                ],
            ], 400);
        }

        $existing = $this->rentalAmenityModel
            ->table('rental_amenities')
            ->where('id', $id)
            ->first();

        if (!$existing) {
            return Response::json([
                'success' => false,
                'message' => 'Tiện ích không tồn tại',
            ], 404);
        }

        $data = [
            'rental_amenity_name'   => $name,
            'rental_amenity_status' => $status,
            'owner_id'              => $existing['owner_id'] ?? ($this->userID ?: null),
            'created_at'            => $existing['created_at'] ?? date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
        ];

        $updated = $this->rentalAmenityModel->updateRentalAmenity($id, $data);

        if ($updated !== false) {
            return Response::json([
                'success' => true,
                'message' => 'Cập nhật tiện ích thành công',
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Không thể cập nhật tiện ích',
        ], 500);
    }

    public function delete($id)
    {
        if (!$this->request->isPost()) {
            return Response::json([
                'success' => false,
                'message' => 'Phương thức không hợp lệ',
            ], 405);
        }

        if (!CSRF::validatePostRequest()) {
            return Response::json([
                'success' => false,
                'message' => 'Có lỗi xảy ra. Vui lòng thử lại',
            ], 403);
        }

        $amenity = $this->rentalAmenityModel
            ->table('rental_amenities')
            ->where('id', $id)
            ->first();

        if (!$amenity) {
            return Response::json([
                'success' => false,
                'message' => 'Tiện ích không tồn tại',
            ], 404);
        }

        $deleted = $this->rentalAmenityModel->deleteRentalAmenity($id);

        if ($deleted) {
            return Response::json([
                'success' => true,
                'message' => 'Xóa tiện ích thành công',
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Không thể xóa tiện ích',
        ], 500);
    }

    public function toggleStatus($id)
    {
        if (!$this->request->isPost()) {
            return Response::json([
                'success' => false,
                'message' => 'Phương thức không hợp lệ',
            ], 405);
        }

        if (!CSRF::validatePostRequest()) {
            return Response::json([
                'success' => false,
                'message' => 'Có lỗi xảy ra. Vui lòng thử lại',
            ], 403);
        }

        $status = $this->request->post('status', null);

        if ($status !== 'active' && $status !== 'inactive') {
            return Response::json([
                'success' => false,
                'message' => 'Trạng thái không hợp lệ',
            ], 400);
        }

        $updated = $this->rentalAmenityModel
            ->table('rental_amenities')
            ->where('id', $id)
            ->update([
                'rental_amenity_status' => $status,
                'updated_at'            => date('Y-m-d H:i:s'),
            ]);

        if ($updated !== false) {
            return Response::json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công',
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Không thể cập nhật trạng thái',
        ], 500);
    }
}
