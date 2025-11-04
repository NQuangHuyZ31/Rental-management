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

    public function updateColumn($id, $column, $value) {
        if ($column == '' || $value == '') {
            return;
        }

        $value = is_array($value) ? json_encode($value) : $value;

        return $this->table($this->table)->where('id', $id)->update([$column => $value, 'updated_at' => date('Y-m-d H:s:i')]);
    }

    // Added by Huy Nguyen on 2025-10-31 to get column
    public function getColumn($column = [], $table = '', $id = '') {
        $query = !empty($table) ? $this->table($table) : $this->table($this->table);
        $query->select($column);

        if (!empty($id)) {
            return $query->where(!empty($table) ? $table .'.id' : $this->table . '.id', $id)
					->where(!empty($table) ? $table . '.deleted' : $this->table . '.deleted', 0)->first();
        }

        return $query->where(!empty($table) ? $table . '.deleted' : $this->table . '.deleted', 0)->get();
    }

    // Added by Huy Nguyen on 2025-11-04 to update record
    public function updateTable($id, $data, $table = '') {
        if ($id == '' || empty($data)) return;

        $query = !empty($table) ? $this->table($table) : $this->table($this->table);
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $query->where('id', $id)->update($data);
    }
}
