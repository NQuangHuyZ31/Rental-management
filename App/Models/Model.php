<?php

/*
name: Model.php
Author: Huy Nguyen
Date: 2025-08-29
Purpose: Base model class
 */

namespace App\Models;

use Core\QueryBuilder;
use Core\Session;

class Model extends QueryBuilder {

    protected $userID;
    protected $table = '';

    public function __construct() {
        parent::__construct();
        $this->userID = Session::get('user')['id'] ?? '';
    }

    // Added by Huy Nguyen on 2025-11-1 to add function create record
    public function add($data, $table = '') {
        $query = !empty($table) ? $this->table($table) : $this->table($this->table);

        return $query->insert($data);
    }

    public function updateColumn($id, $column, $value, $deleted = true) {
        if ($column == '' || $value == '') {
            return;
        }

        $value = is_array($value) ? json_encode($value) : $value;
        $query = $this->table($this->table);

        if ($deleted) {
            $query->where('deleted', 0);
        }

        if (is_array($id)) {
            $query->whereIn('id', $id);
        } else {
            $query->where('id', $id);
        }
        return $this->update([$column => $value, 'updated_at' => date('Y-m-d H:s:i')]);
    }

    // Added by Huy Nguyen on 2025-11-01 to get by id
    public function getById($id, $table = '', $extWhere = []) {
        if (empty($id)) {
            return;
        }
        
        $query = !empty($table) ? $this->table($table) : $this->table($this->table);

        if (!empty($extWhere) || is_array($extWhere)) {
            foreach ($extWhere as $column => $value) {
                if (!empty($value['condition'])) {
                    $query->where($column, $value['condition'], $value['value']);
                } else {
                    $query->where($column, $value['value']);
                }
            }
        }

        return $query->where('id', $id)
            ->where('deleted', 0)
            ->first();
    }

    // Added by Huy Nguyen on 2025-10-31 to get column
    public function getColumn($column = [], $table = '', $id = '', $extWhere = []) {
        $query = !empty($table) ? $this->table($table) : $this->table($this->table);
        $query->select($column);

        if (!empty($id)) {
            return $query->where(!empty($table) ? $table . '.id' : $this->table . '.id', $id)
                ->where(!empty($table) ? $table . '.deleted' : $this->table . '.deleted', 0)->first();
        }

        if (!empty($extWhere) || is_array($extWhere)) {
            foreach ($extWhere as $column => $value) {
                if (!empty($value['condition'])) {
                    $query->where($column, $value['condition'], $value['value']);
                } else {
                    $query->where($column, $value['value']);
                }
            }
        }

        return $query->where(!empty($table) ? $table . '.deleted' : $this->table . '.deleted', 0)->get();
    }

    // Added by Huy Nguyen on 2025-11-04 to update record
    public function updateTable($id, $data, $table = '') {
        if ($id == '' || empty($data)) {
            return;
        }

        $query = !empty($table) ? $this->table($table) : $this->table($this->table);
        $data['updated_at'] = date('Y-m-d H:i:s');

        if (is_array($id)) {
            $query->whereIn('id', $id);
        } else {
            $query->where('id', $id);
        }
        return $query->where('deleted', 0)->update($data);
    }

    // Added by Huy Nguyen on 2025-11-07 to get all record
    public function getAll($table = '', $extWhere = [], $limit = 0, $orderByField = '', $orderByType = 'DESC', $offset = 0) {
        $query = !empty($table) ? $this->table($table) : $this->table($this->table);

        if (!empty($extWhere) && is_array($extWhere)) {

            foreach ($extWhere as $column => $value) {

                // 1️⃣ Trường hợp value là string → where column = value
                if (!is_array($value)) {
                    $query->where($column, '=', $value);
                    continue;
                }

                // 2️⃣ Trường hợp value là 1 điều kiện duy nhất
                if (isset($value['value'])) {
                    $condition = $value['condition'] ?? '=';
                    $query->where($column, $condition, $value['value']);
                    continue;
                }

                // 3️⃣ Trường hợp là nhiều điều kiện cho 1 cột
                foreach ($value as $cond) {
                    if (!isset($cond['value'])) {
                        continue; // tránh lỗi nếu dữ liệu thiếu
                    }

                    $condition = $cond['condition'] ?? '=';
                    $query->where($column, $condition, $cond['value']);
                }
            }
        }

        if (!empty($limit) || $limit > 0) {
            $query->limit($limit)->offset($offset);
        }

        if (!empty($orderByField)) {
            $query->orderBy($orderByField, $orderByType);
        }

        return $query->where('deleted', 0)->get();
    }
}
