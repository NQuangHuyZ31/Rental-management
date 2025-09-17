<?php

/*

* Author: Huy Nguyen
* Date: 2025-09-17
* Purpose: Build Setting Payment Controller
*/

namespace App\Controllers\Landlord;

use App\Requests\SettingPaymentValidate;
use Core\CSRF;
use Core\ViewRender;

class SettingPaymentController extends SettingController {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$userBanking = $this->userBanking->getUserBankingByUserId($this->userID);
		return ViewRender::renderWithLayout('landlord/settings/payment',['userBanking' => $userBanking], 'landlord/settings/index');
	}

	public function guide() {
		return ViewRender::renderWithLayout('landlord/settings/payment-guide',[], 'landlord/settings/index');
	}

	public function update() {
		$request = $this->request->post();

		if (!CSRF::validatePostRequest()) {
			$this->request->redirectWithErrors('landlord/setting/payment', 'Lỗi xảy ra. Vui lòng thử lại');
			exit;
		}

		$userBanking = $this->userBanking->getUserBankingByUserId($this->userID);

		$error = SettingPaymentValidate::validate($request);

		if (!empty($error)) {
			$this->request->redirectWithErrors('landlord/setting/payment', $error);
			exit;
		}

		$dataUserBanking = [
			'user_id' => $this->userID ?? $userBanking['user_id'],
			'user_bank_name' => $request['user_bank_name'],
			'bank_code' => $request['bank_code'],
			'bank_account_number' => $request['bank_account_number'],
			'bank_account_name' => $request['bank_account_name'],
			'api_key' => $request['api_key'],
			'created_at' => $userBanking['created_at'] ?? date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		];

		if (!$userBanking) {
			$this->userBanking->insertUserBanking($dataUserBanking);
			$this->request->redirectWithSuccess('landlord/setting/payment', 'Thêm thông tin thanh toán thành công');
			exit;
		}

		$this->userBanking->updateUserBanking($userBanking['id'], $dataUserBanking);
		$this->request->redirectWithSuccess('landlord/setting/payment', 'Cập nhật thông tin thanh toán thành công');
		exit;
	}

	public function paymentApi() {
		$userBanking = $this->userBanking->getUserBankingByUserId($this->userID);
		return ViewRender::renderWithLayout('landlord/settings/payment-api',['userBanking' => $userBanking], 'landlord/settings/index');
	}

	public function updateApiKey() {
		$request = $this->request->post();
		$userBanking = $this->userBanking->getUserBankingByUserId($this->userID);

		if (empty($request['api_key']) || empty($request['confirm_api_key'])) {
			$this->request->redirectWithErrors('landlord/setting/payment-api', 'API Key không được để trống');
			exit;
		}

		if (strlen($request['api_key']) < 10) {
			$this->request->redirectWithErrors('landlord/setting/payment-api', 'API Key quá ngắn. Vui lòng nhập lại');
			exit;
		}

		if ($request['api_key'] != $request['confirm_api_key']) {
			$this->request->redirectWithErrors('landlord/setting/payment-api', 'API Key không khớp');
			exit;
		}

		if (!CSRF::validatePostRequest()) {
			$this->request->redirectWithErrors('landlord/setting/payment-api', 'Lỗi xảy ra. Vui lòng thử lại');
			exit;
		}

		$this->userBanking->updateUserBanking($userBanking['id'], ['api_key' => $request['api_key'], 'updated_at' => date('Y-m-d H:i:s')]);
		$this->request->redirectWithSuccess('landlord/setting/payment-api', 'Cập nhật API Key thành công');
		exit;
	}
}
