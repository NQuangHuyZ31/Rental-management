<?php

/*
 * Author: Huy Nguyen
 * Date: 2025-09-01
 * Purpose: User Model
 */

namespace App\Models;
use App\Models\Model;

class User extends Model {
    protected $table = 'users';
    protected $field = [
        'id',
        'username',
        'phone',
        'gender',
        'birthday',
        'job',
        'province',
        'ward',
        'address',
        'account_status',
        'avatar',
        'last_login',
    ];

    public function __construct() {
        parent::__construct();
    }

    public function getAllUsers() {
        try {
            return $this->table($this->table)->where('deleted', 0)->get();
        } catch (\Exception $e) {
            error_log("Error getting all users: " . $e->getMessage());
            return [];
        }
    }

    public function getUserById($id) {
        $this->field[] = 'citizen_id';
        $this->field[] = 'email'; // Added by Huy Nguyen on 2025-10-14 to include email
        return $this->table($this->table)->select($this->field)->where('id', $id)->where('deleted', 0)->first();
    }

    // Added by Huy Nguyen on 2025-10-14 to get user by filter
    public function getUserByFilter($filter, $limit = 10, $offset = 0, $total = false, $tableJoin = '', $fieldJoin = '', $possition = 1, $type = 'INNER') {
        $query = $this->table($this->table)->select([$this->table . '.*', 'roles.role_name AS role_name'])
            ->join('roles', 'users.role_id', '=', 'roles.id');

        if (!empty($tableJoin) && !empty($fieldJoin)) {
            if ($possition == 1) {
                $query->join($tableJoin, $this->table . '.id', '=', $tableJoin . '.' . $fieldJoin, $type);
            } else {
                $query->join($tableJoin, $this->table . '.' . $fieldJoin, '=', $tableJoin . '.id', $type);
            }
        }

        if (isset($filter['search']) && !empty($filter['search'])) {
            $query->whereOrGroup(['users.username', 'users.email', 'users.phone'], 'LIKE', "%{$filter['search']}%");
        }

        if (isset($filter['role']) && !empty($filter['role'])) {
            $query->where('roles.role_name', $filter['role']);
        }

        if (isset($filter['status']) && !empty($filter['status'])) {
            $query->where($this->table . '.account_status', $filter['status']);
        }

        $query->where($this->table . '.deleted', 0)->orderBy('users.created_at', 'DESC');

        if ($total) {
            $users = $query->get();
        } else {
            $users = $query->limit($limit)
                ->offset($offset)
                ->get();
        }

        return $users;
    }

    public function insertUser($data) {
        return $this->table($this->table)->insert($data);
    }

    public function getUserByEmail($email, $account_status = 'active') {
        try {
            $user = $this->table($this->table)->select($this->field)->where('email', $email)->where('account_status', $account_status)->where('deleted', 0)->first();
            return $user;
        } catch (\Exception $e) {
            error_log("Error checking email: " . $e->getMessage());
            return false;
        }
    }

    // Added by Huy Nguyen on 2025-11-03 to get user by citizenid
    public function getUserByCitizenId($citizenId, $notInclueUserId = []) {
        if (empty($citizenId)) {
            return;
        }

        if (!is_array($notInclueUserId)) {
            $notInclueUserId = [$notInclueUserId];
        }

        $query = $this->table($this->table)->where('citizen_id', $citizenId)->where('deleted', 0)->where('account_status', 'active');

        if (!empty($notInclueUserId)) {
            $query->whereNotIn('id', $notInclueUserId);
        }

        return $query->first();
    }

    public function getUserByPhone($phone, $account_status = 'active') {
        try {
            $user = $this->table($this->table)->where('phone', $phone)->where('account_status', $account_status)->where('deleted', 0)->first();
            return $user;
        } catch (\Exception $e) {
            error_log("Error checking phone: " . $e->getMessage());
            return false;
        }
    }

    public function updateUser($id, $data) {
        $data = [
            'username' => $data['username'],
            'phone' => $data['phone'],
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'job' => $data['job'],
            'province' => $data['province'],
            'ward' => $data['ward'],
            'address' => $data['address'],
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        return $this->table($this->table)->where('id', $id)->update($data);
    }
}