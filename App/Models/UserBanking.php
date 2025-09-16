<?php 

/*

* Author: Huy Nguyen
* Date: 2025-09-16
* Purpose: User Banking Model
*/

namespace App\Models;

use App\Models\Model;

class UserBanking extends Model {
	protected $table = 'user_bankings';

	public function __construct() {
		parent::__construct();
	}

	public function getUserBankingByUserId($userId) {
		return $this->table($this->table)->select('user_bankings.*, users.username as user_name')->
		join('users', 'user_bankings.user_id', '=', 'users.id')->where('user_bankings.user_id', $userId)->where('user_bankings.deleted', 0)->where('users.deleted', 0)->first();
	}
	
	
}