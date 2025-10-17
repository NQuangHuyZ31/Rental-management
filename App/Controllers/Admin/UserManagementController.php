<?php

/*
 * Author: Dương Nguyen
 * Date: 2025-10-14
 * Purpose: User Management Controller - Admin
 */

namespace App\Controllers\Admin;

use Core\CSRF;
use Core\Session;
use Core\ViewRender;
use Helpers\Validate;

class UserManagementController extends AdminController {
    protected $title = 'Quản lí người dùng';

    public function index() {
        // Lấy thông số phân trang và lọc từ request
        $page = $this->request->get('page') != '' ? (int) $this->request->get('page') : 1;
        $limit = $this->limit;
        $offset = ($page - 1) * $limit;
        $filters = [];
        $requests = $this->request->get();

        foreach ($requests as $key => $filter) {
            if (!isset($filter[$key]) && $filter != '') {
                $filters [$key] = $filter;
            }
        }
        
        $totalUsers = count($this->userModel->getUserByFilter($filters, $limit, $offset, true, 'roles', 'role_id', 2));
        $users = $this->userModel->getUserByFilter($filters, $limit, $offset, false, 'roles', 'role_id', 2);

        // Pagination
        $pagination = $this->getPagination($page, $totalUsers, $limit, $offset);
        $queryParmas = $filters;

        // Lấy danh sách role từ database qua thuộc tính của AdminController
        $roles = $this->roleModel->getAllRolesAnyType();

        // Get validation errors and old input from session
        $validationErrors = Session::get('validation_errors', []);
        $oldInput = Session::get('old_input', []);
        // Clear validation data from session after retrieving
        Session::delete('validation_errors');
        Session::delete('old_input');

        // Truyền dữ liệu vào view
        ViewRender::renderWithLayout('admin/users/users', [
            'users' => $users,
            'roles' => $roles,
            'pagination' => $pagination,
            'queryParams' => $queryParmas,
            'filter' => $filters,
            'validationErrors' => $validationErrors,
            'oldInput' => $oldInput,
            'title' => $this->title
        ], 'admin/layouts/app');
    }

    /**
     * Tạo người dùng mới
     */
    public function store() {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/admin/users', 'Phương thức không hợp lệ');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/admin/users', 'Có lỗi xảy ra. Vui lòng thử lại');
            return;
        }

        // Lấy dữ liệu từ request
        $userData = [
            'username' => $this->request->post('username'),
            'email' => $this->request->post('email'),
            'phone' => $this->request->post('phone'),
            'password' => $this->request->post('password'),
            'gender' => $this->request->post('gender'),
            'birthday' => $this->request->post('birthday'),
            'job' => $this->request->post('job'),
            'province' => $this->request->post('province'),
            'ward' => $this->request->post('ward'),
            'address' => $this->request->post('address'),
            'citizen_id' => $this->request->post('citizen_id'),
            'role_id' => $this->request->post('role_id'),
            'account_status' => $this->request->post('account_status', 'active'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Validate dữ liệu
        $validationErrors = $this->validateUserData($userData);
        if (!empty($validationErrors)) {
            // Store validation errors in session to display under fields
            Session::set('validation_errors', $validationErrors);
            Session::set('old_input', $userData);
            Session::set('modal_type', 'create');
            Session::delete('edit_user_id'); // Clear edit user ID for create mode
            $this->request->redirectWithError('/admin/users', 'Vui lòng kiểm tra lại thông tin đã nhập');
            return;
        }

        try {
            // Hash password
            $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
            $userData['deleted'] = 0;

            // Gọi model để tạo user
            $result = $this->userModel->insertUser($userData);

            if ($result) {
                // Clear session data on success
                Session::delete('modal_type');
                Session::delete('edit_user_id');
                $this->request->redirectWithSuccess('/admin/users', 'Tạo người dùng thành công!');
            } else {
                $this->request->redirectWithError('/admin/users', 'Có lỗi xảy ra khi tạo người dùng');
            }
        } catch (\Exception $e) {
            $this->request->redirectWithError('/admin/users', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Validate user data
     */
    private function validateUserData($data) {
        $errors = [];

        // Validate username
        if (empty($data['username'])) {
            $errors['username'] = 'Tên người dùng không được để trống';
        } elseif (strlen($data['username']) < 3) {
            $errors['username'] = 'Tên người dùng phải có ít nhất 3 ký tự';
        } elseif (strlen($data['username']) > 50) {
            $errors['username'] = 'Tên người dùng không được vượt quá 50 ký tự';
        }

        // Validate email
        if (empty($data['email'])) {
            $errors['email'] = 'Email không được để trống';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        } else {
            // Check if email already exists
            $existingUser = $this->queryBuilder->table('users')
                ->where('email', '=', $data['email'])
                ->where('deleted', '=', 0)
                ->first();
            if ($existingUser) {
                $errors['email'] = 'Email đã được sử dụng';
            }
        }

        // Validate phone
        if (empty($data['phone'])) {
            $errors['phone'] = 'Số điện thoại không được để trống';
        } elseif (!Validate::phone($data['phone'])) {
            $errors['phone'] = 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam (10 chữ số, bắt đầu bằng 0)';
        } else {
            // Check if phone already exists
            $existingPhone = $this->queryBuilder->table('users')
                ->where('phone', '=', $data['phone'])
                ->where('deleted', '=', 0)
                ->first();
            if ($existingPhone) {
                $errors['phone'] = 'Số điện thoại đã được sử dụng';
            }
        }

        // Validate password
        if (empty($data['password'])) {
            $errors['password'] = 'Mật khẩu không được để trống';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
        }

        // Check password confirmation
        $passwordConfirmation = $this->request->post('password_confirmation');
        if ($data['password'] !== $passwordConfirmation) {
            $errors['password_confirmation'] = 'Mật khẩu xác nhận không khớp';
        }

        // Validate province (optional)
        // Province không bắt buộc

        // Validate ward (optional)
        // Ward không bắt buộc

        // Validate citizen_id (optional field)
        if (!empty($data['citizen_id'])) {
            if (!Validate::citizenId($data['citizen_id'])) {
                $errors['citizen_id'] = 'Số CCCD không hợp lệ. Vui lòng nhập đúng 12 chữ số';
            } else {
                // Check if citizen_id already exists
                $existingCitizenId = $this->queryBuilder->table('users')
                    ->where('citizen_id', '=', $data['citizen_id'])
                    ->where('deleted', '=', 0)
                    ->first();
                if ($existingCitizenId) {
                    $errors['citizen_id'] = 'Số CCCD đã được sử dụng';
                }
            }
        }

        // Validate role_id
        if (empty($data['role_id'])) {
            $errors['role_id'] = 'Vui lòng chọn vai trò';
        } else {
            // Check if role exists and is not admin
            $role = $this->queryBuilder->table('roles')
                ->where('id', '=', $data['role_id'])
                ->where('role_name', '<>', 'admin')
                ->first();
            if (!$role) {
                $errors['role_id'] = 'Vai trò không hợp lệ';
            }
        }

        // Validate account_status
        if (!in_array($data['account_status'], ['active', 'inactive', 'banned'])) {
            $data['account_status'] = 'active';
        }

        // Validate gender
        if (empty($data['gender'])) {
            $errors['gender'] = 'Vui lòng chọn giới tính';
        }

        return $errors;
    }

    /**
     * Lấy thông tin người dùng để edit
     */
    public function edit($id) {
        try {
            $user = $this->queryBuilder->table('users')
                ->where('id', '=', $id)
                ->where('deleted', '=', 0)
                ->first();

            if (!$user) {
                return \Core\Response::json([
                    'success' => false,
                    'message' => 'Không tìm thấy người dùng',
                ], 404);
            }

            return \Core\Response::json([
                'success' => true,
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            error_log('Error in UserManagementController@edit: ' . $e->getMessage());
            return \Core\Response::json([
                'success' => false,
                'message' => 'Có lỗi xảy ra',
            ], 500);
        }
    }

    /**
     * Cập nhật thông tin người dùng
     */
    public function update($id) {
        // Kiểm tra request method
        if (!$this->request->isPost()) {
            $this->request->redirectWithError('/admin/users', 'Phương thức không hợp lệ');
            return;
        }

        // Kiểm tra CSRF token
        if (!CSRF::validatePostRequest()) {
            $this->request->redirectWithError('/admin/users', 'Có lỗi xảy ra. Vui lòng thử lại');
            return;
        }

        try {
            // Check if user exists
            $user = $this->queryBuilder->table('users')
                ->where('id', '=', $id)
                ->where('deleted', '=', 0)
                ->first();

            if (!$user) {
                $this->request->redirectWithError('/admin/users', 'Không tìm thấy người dùng');
                return;
            }

            // Lấy dữ liệu từ request
            $userData = [
                'username' => $this->request->post('username'),
                'email' => $this->request->post('email'),
                'phone' => $this->request->post('phone'),
                'gender' => $this->request->post('gender'),
                'birthday' => $this->request->post('birthday'),
                'job' => $this->request->post('job'),
                'province' => $this->request->post('province'),
                'ward' => $this->request->post('ward'),
                'address' => $this->request->post('address'),
                'citizen_id' => $this->request->post('citizen_id'),
                'role_id' => $this->request->post('role_id'),
                'account_status' => $this->request->post('account_status', 'active'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // Validate dữ liệu (exclude password validation for update)
            $validationErrors = $this->validateUserDataForUpdate($userData, $id);

            // Validate password if provided
            $password = $this->request->post('password');
            $passwordConfirmation = $this->request->post('password_confirmation');

            if (!empty($password)) {
                if (strlen($password) < 6) {
                    $validationErrors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
                }
                if ($password !== $passwordConfirmation) {
                    $validationErrors['password_confirmation'] = 'Mật khẩu xác nhận không khớp';
                }
                if (empty($validationErrors['password']) && empty($validationErrors['password_confirmation'])) {
                    $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
                }
            }

            if (!empty($validationErrors)) {
                Session::set('validation_errors', $validationErrors);
                Session::set('old_input', $userData);
                Session::set('modal_type', 'edit');
                Session::set('edit_user_id', $id);
                $this->request->redirectWithError('/admin/users', 'Vui lòng kiểm tra lại thông tin đã nhập');
                return;
            }

            // Update user
            $result = $this->queryBuilder->table('users')
                ->where('id', '=', $id)
                ->update($userData);

            if ($result !== false) {
                // Clear session data on success
                Session::delete('modal_type');
                Session::delete('edit_user_id');
                $this->request->redirectWithSuccess('/admin/users', 'Cập nhật người dùng thành công');
            } else {
                $this->request->redirectWithError('/admin/users', 'Có lỗi xảy ra khi cập nhật người dùng');
            }
        } catch (\Exception $e) {
            error_log('Error in UserManagementController@update: ' . $e->getMessage());
            $this->request->redirectWithError('/admin/users', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user status (active/banned)
     */
    public function toggleStatus($id) {
        try {
            $status = $this->request->post('status', 'active');

            $user = $this->queryBuilder->table('users')
                ->where('id', '=', $id)
                ->where('deleted', '=', 0)
                ->first();

            if (!$user) {
                return \Core\Response::json([
                    'success' => false,
                    'message' => 'Không tìm thấy người dùng',
                ], 404);
            }

            $updated = $this->queryBuilder->table('users')
                ->where('id', '=', $id)
                ->update([
                    'account_status' => $status,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            if ($updated !== false) {
                return \Core\Response::json([
                    'success' => true,
                    'message' => 'Cập nhật trạng thái thành công',
                ], 200);
            } else {
                return \Core\Response::json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi cập nhật trạng thái',
                ], 500);
            }
        } catch (\Exception $e) {
            error_log('Error in UserManagementController@toggleStatus: ' . $e->getMessage());
            return \Core\Response::json([
                'success' => false,
                'message' => 'Có lỗi xảy ra',
            ], 500);
        }
    }

    /**
     * Validate user data for update (exclude current user from uniqueness check)
     */
    private function validateUserDataForUpdate($data, $currentUserId) {
        $errors = [];

        // Validate username
        if (empty($data['username'])) {
            $errors['username'] = 'Tên người dùng không được để trống';
        } elseif (strlen($data['username']) < 3) {
            $errors['username'] = 'Tên người dùng phải có ít nhất 3 ký tự';
        } elseif (strlen($data['username']) > 50) {
            $errors['username'] = 'Tên người dùng không được vượt quá 50 ký tự';
        } else {
            // Check if username already exists (exclude current user)
            $existingUser = $this->queryBuilder->table('users')
                ->where('username', '=', $data['username'])
                ->where('id', '!=', $currentUserId)
                ->where('deleted', '=', 0)
                ->first();
            if ($existingUser) {
                $errors['username'] = 'Tên người dùng đã được sử dụng';
            }
        }

        // Validate email
        if (empty($data['email'])) {
            $errors['email'] = 'Email không được để trống';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        } else {
            // Check if email already exists (exclude current user)
            $existingUser = $this->queryBuilder->table('users')
                ->where('email', '=', $data['email'])
                ->where('id', '!=', $currentUserId)
                ->where('deleted', '=', 0)
                ->first();
            if ($existingUser) {
                $errors['email'] = 'Email đã được sử dụng';
            }
        }

        // Validate phone
        if (!empty($data['phone'])) {
            if (!Validate::phone($data['phone'])) {
                $errors['phone'] = 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam (10 chữ số, bắt đầu bằng 0)';
            } else {
                // Check if phone already exists (exclude current user)
                $existingPhone = $this->queryBuilder->table('users')
                    ->where('phone', '=', $data['phone'])
                    ->where('id', '!=', $currentUserId)
                    ->where('deleted', '=', 0)
                    ->first();
                if ($existingPhone) {
                    $errors['phone'] = 'Số điện thoại đã được sử dụng';
                }
            }
        }

        // Validate province (optional)
        // Province không bắt buộc khi update

        // Validate ward (optional)
        // Ward không bắt buộc khi update

        // Validate citizen_id (optional field)
        if (!empty($data['citizen_id'])) {
            if (!Validate::citizenId($data['citizen_id'])) {
                $errors['citizen_id'] = 'Số CCCD không hợp lệ. Vui lòng nhập đúng 12 chữ số';
            } else {
                // Check if citizen_id already exists (exclude current user)
                $existingCitizenId = $this->queryBuilder->table('users')
                    ->where('citizen_id', '=', $data['citizen_id'])
                    ->where('id', '!=', $currentUserId)
                    ->where('deleted', '=', 0)
                    ->first();
                if ($existingCitizenId) {
                    $errors['citizen_id'] = 'Số CCCD đã được sử dụng';
                }
            }
        }

        // Validate role_id
        if (empty($data['role_id'])) {
            $errors['role_id'] = 'Vui lòng chọn vai trò';
        } else {
            // Check if role exists
            $role = $this->queryBuilder->table('roles')
                ->where('id', '=', $data['role_id'])
                ->first();
            if (!$role) {
                $errors['role_id'] = 'Vai trò không hợp lệ';
            }
        }

        // Validate account_status
        if (!in_array($data['account_status'], ['active', 'inactive', 'banned'])) {
            $data['account_status'] = 'active';
        }

        return $errors;
    }

    /**
     * Xoá mềm tài khoản (deleted = 1)
     */
    public function delete($id) {
        if (!$this->request->isPost()) {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
            return;
        }
        if (!CSRF::validatePostRequest()) {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại']);
            return;
        }
        $user = $this->userModel->getUserById($id);
        if (!$user || $user['deleted'] == 1) {
            echo json_encode(['success' => false, 'message' => 'Tài khoản không tồn tại hoặc đã bị xoá']);
            return;
        }
        $result1 = $this->userModel->updateColumn($id, 'deleted', 1);
        $result2 = $this->userModel->updateColumn($id, 'updated_at', date('Y-m-d H:i:s'));
        if ($result1 && $result2) {
            echo json_encode(['success' => true, 'message' => 'Đã xoá tài khoản thành công!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể xoá tài khoản. Vui lòng thử lại']);
        }
    }
}
