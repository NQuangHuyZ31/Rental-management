<?php

/*
	Author: Huy Nguyen
	Date: 2024-10-22
	Purpose: customer support model
*/

namespace App\Models;

class CustomerSupport extends Model {
	protected $table = 'customer_supports';
	protected $primary_key = 'id';

	public function __construct() {
		parent::__construct();
	}
}