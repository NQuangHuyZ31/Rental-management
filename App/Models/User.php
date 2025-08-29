<?php

namespace App\Models;
use App\Models\Model;

class User extends Model {
	protected $table = 'users';

	public function getAllUsers() {

		$users = $this->table($this->table)
					->where('id', 1)
					->get();

		return $users;
	}
 }