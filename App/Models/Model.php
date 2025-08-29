<?php

/*
	name: Model.php
	Author: Huy Nguyen
	Date: 2025-08-29
	Purpose: Base model class
*/

namespace App\Models;
Use Core\QueryBuilder;

class Model extends QueryBuilder{
	
	public function __construct() {
		parent::__construct();
	}
}