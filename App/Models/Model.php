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
	
	public function __construct() {
		parent::__construct();
		$this->userID = Session::get('user')['id'] ?? '';
	}
}
