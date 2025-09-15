<?php 

/*

Author: Huy Nguyen
Date: 2025-09-14
Purpose: Payment Controller
*/
namespace App\Controllers\Customer;

use App\Controllers\Controller;
use Core\CSRF;
use Core\Response;

class PaymentController extends CustomerController {

	public function __construct() {
		parent::__construct();
	}

	public function payment() {
		$data = $this->request->post();

		if (!CSRF::validatePostRequest()) {
			Response::json(['message' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
			exit;
		}

		$invoice = $this->invoiceModel->getInvoiceByUserId($data['invoice_id'], $this->userID);
		
		if (!$invoice) {
			Response::json(['message' => 'Hóa đơn không tồn tại', 'token' => CSRF::getTokenRefresh()], 404);
			exit;
		}

		$qrCode = $this->generateQRCode($invoice);
		
		// Lấy thông tin phòng và nhà
		$roomInfo = $this->invoiceModel->getInvoiceWithRoomInfo($data['invoice_id'], $this->userID);

		Response::json(['status' => 'success', 'data' => $invoice, 'roomInfo' => $roomInfo, 'qrCode' => $qrCode, 'token' => CSRF::getTokenRefresh()], 200);	
	}

	public function generateQRCode($invoice) {
		$bankNumber = ACCOUNT_BANK_NUMBER;
		$bankCode = ACCOUNT_BANK_CODE;

		$totalAmount = intval($invoice['total']);
		$des = 'HD-' . $invoice['invoice_month'] . '-' . $invoice['id'];
		$template = 'compact';

		$qrCode = 'https://qr.sepay.vn/img?acc=' . $bankNumber . '&bank=' . $bankCode . '&amount=' . $totalAmount . '&des=' . $des . '&template=' . $template;

		return $qrCode;
	}
}