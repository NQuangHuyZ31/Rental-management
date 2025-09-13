<?php

/*
Author: Huy Nguyen
Date: 2025-09-13
Purpose: Invoice Model
*/

namespace App\Models;

class Invoice extends Model {
	protected $table = 'invoices';

	public function __construct() {
		parent::__construct();
	}

	public function getAll() {
		return $this->table($this->table)->where('deleted', 0)->where('user_id', $this->userID)->get();
	}

	public function getById($id) {
		return $this->table($this->table)->where('id', $id)->where('deleted', 0)->where('user_id', $this->userID)->first();
	}

	public function getByStatus($status) {
		return $this->table($this->table)->where('invoice_status', $status)->where('deleted', 0)->where('user_id', $this->userID)->get();
	}
}