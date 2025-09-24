<?php

/*
* Author: Huy Nguyen
* Date: 2025-09-01
* Purpose: User Model
*/

namespace App\Models;
use App\Models\Model;

class User extends Model {
	protected $table = 'users';

	public function __construct() {
		parent::__construct();
	}

	public function getAllUsers() {
		try {
			return $this->table($this->table)->where('deleted', 0)->get();
		} catch (\Exception $e) {
			error_log("Error getting all users: " . $e->getMessage());
			return [];
		}
	}

	public function getUserById($id) {
		return $this->table($this->table)->where('id', $id)->where('deleted', 0)->first();
	}

	public function insertUser($data) {
		return $this->table($this->table)->insert($data);
	}

	public function getUserByEmail($email, $account_status = 'active') {
		try {
			$user = $this->table($this->table)->where('email', $email)->where('account_status', $account_status)->where('deleted', 0)->first();
			return $user;
		} catch (\Exception $e) {
			error_log("Error checking email: " . $e->getMessage());
			return false;
		}
	}

	public function getUserByPhone($phone, $account_status = 'active') {
		try {
			$user = $this->table($this->table)->where('phone', $phone)->where('account_status', $account_status)->where('deleted', 0)->first();
			return $user;
		} catch (\Exception $e) {
			error_log("Error checking phone: " . $e->getMessage());
			return false;
		}
	}

	public function updateUser($id, $data) {
		$data = [
			'username' => $data['username'],
			'phone' => $data['phone'],
			'birthday' => $data['birthday'],
			'gender' => $data['gender'],
			'job' => $data['job'],
			'province' => $data['province'],
			'ward' => $data['ward'],
			'address' => $data['address'],
			'updated_at' => date('Y-m-d H:i:s'),
		];

		return $this->table($this->table)->where('id', $id)->update($data);
	}

	public function updateColumn($id, $column, $value) {
		try {
			// Build and execute the update query
			$result = $this->table($this->table)->where('id', $id)->update([$column => $value]);
			return $result;
		} catch (\Exception $e) {
			error_log("Error updating user column: " . $e->getMessage());
			return false;
		}
	}

	public function deleteUser($id) {
		try {
			$result = $this->table($this->table)->where('id', $id)->update(['deleted' => 1]);
			return $result;
		} catch (\Exception $e) {
			error_log("Error deleting user: " . $e->getMessage());
			return false;
		}
	}
 }