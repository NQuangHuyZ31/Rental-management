<?php

/*
 * Author: Huy Nguyen
 * Date: 2025-09-01
 * Purpose: Role Model
 */

namespace App\Models;

class Role extends Model {
    protected $table = 'roles';

    public function __construct() {
        parent::__construct();
    }

    public function getAllRoles() {
        return $this->table($this->table)->where('role_name', '<>', 'admin')->get();
    }
}
