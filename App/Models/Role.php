<?php

/*
	name: Role Model
	Author: Huy Nguyen
	Date: 2025-08-30
*/

namespace App\Models;

use App\Models\Model;

class Role extends Model {
	protected $table = 'roles';

	public function getAllRoles() {
		return $this->table($this->table)->get();
	}
 }