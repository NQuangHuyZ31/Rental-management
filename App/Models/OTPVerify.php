<?php

/*
 * Author: Huy Nguyen
 * Date: 2025-09-01
 * Purpose: OTPVerify Model
 */

namespace App\Models;

class OTPVerify extends Model {
    protected $table = 'otp_verifies';

    public function __construct() {
        parent::__construct();
    }

    public function insertOTP($data) {
        return $this->table($this->table)->insert($data);
    }

    public function getOTPByUserId($userId) {
        return $this->table($this->table)->where('user_id', $userId)
				->where('is_verified', '0')
				->orderBy('created_at', 'desc')->first();
    }

	public function updateColumn($id, $column, $value) {
		return $this->table($this->table)->where('id', $id)->update([$column => $value]);
	}

	public function getOTPByUserIdAndType($userId, $type) {
		return $this->table($this->table)->where('user_id', $userId)
			->where('type', $type)
			->where('is_verified', '0')
			->orderBy('created_at', 'desc')->first();
	}
}
