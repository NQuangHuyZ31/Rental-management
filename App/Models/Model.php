<?php

/*
	name: Model.php
	Author: Huy Nguyen
	Date: 2025-08-29
	Purpose: Base model class
*/

namespace App\Models;
Use Core\QueryBuilder;
use Core\Session;

class Model extends QueryBuilder {
	
	protected $userID;
	protected $table = '';
	
	public function __construct() {
		parent::__construct();
		$this->userID = Session::get('user')['id'] ?? '';
	}

	public function updateColumn($id, $column, $value) {
		return $this->table($this->table)->where('id', $id)->update([$column => $value]);
	}
}
