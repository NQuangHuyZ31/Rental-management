<?php

/*

Author: Huy Nguyen
Date: 2025-09-14
Purpose: Payment Controller
 */
namespace App\Controllers\Customer;

use App\Models\UserBanking;
use Core\CSRF;
use Core\Response;
use Helpers\Log;

class PaymentController extends CustomerController {
    private $userBankingModel;

    public function __construct() {
        parent::__construct();
        $this->userBankingModel = new UserBanking();
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

        // Lấy thông tin phòng và nhà
        $roomInfo = $this->invoiceModel->getInvoiceWithRoomInfo($data['invoice_id'], $this->userID);

        // Lấy thông tin tài khoản
        $userBanking = $this->userBankingModel->getUserBankingByUserId($roomInfo['owner_id']);
        $qrCode = $this->generateQRCode($invoice, $userBanking);

        $bankingInfo = [
            'bank_name' => $userBanking['bank_account_name'] ?? ACCOUNT_BANK_NAME,
            'bank_number' => $userBanking['bank_account_number'] ?? ACCOUNT_BANK_NUMBER,
            'user_name' => $userBanking['user_name'] ?? 'Nguyễn Quang Huy',
        ];

        Response::json(['status' => 'success', 'data' => $invoice, 'roomInfo' => $roomInfo, 'qrCode' => $qrCode, 'bankingInfo' => $bankingInfo, 'token' => CSRF::getTokenRefresh()], 200);
    }

    public function callback() {
        Log::payment('Callback payment', Log::LEVEL_INFO);
        // get data from webhook
        $data = json_decode(file_get_contents('php://input'));
        if (!is_object($data)) {
            Response::json(['success' => 'error', 'message' => 'No data'], 400);
            exit;
        }

        $gateway = $data->gateway;
        $transaction_date = $data->transactionDate;
        $account_number = $data->accountNumber;
        $sub_account = $data->subAccount;

        $transfer_type = $data->transferType;
        $transfer_amount = $data->transferAmount;
        $accumulated = $data->accumulated;

        $code = $data->code;
        $transaction_content = $data->content;
        $reference_number = $data->referenceCode;
        $body = $data->description;

        $amount_in = 0;
        $amount_out = 0;

        // Kiem tra giao dich tien vao hay tien ra
        if ($transfer_type == "in") {
            $amount_in = $transfer_amount;
        } else if ($transfer_type == "out") {
            $amount_out = $transfer_amount;
        }

    }

    public function generateQRCode($invoice, $userBanking) {
        $bankNumber = $userBanking['bank_account_number'] ?? ACCOUNT_BANK_NUMBER;
        $bankCode = $userBanking['bank_account_code'] ?? ACCOUNT_BANK_CODE;

        $totalAmount = intval($invoice['total']);
        $des = 'Thanh toán hóa đơn: HD-' . $invoice['invoice_month'] . '-' . $invoice['id'];
        $template = 'compact';

        $qrCode = 'https://qr.sepay.vn/img?acc=' . $bankNumber . '&bank=' . $bankCode . '&amount=' . $totalAmount . '&des=' . $des . '&template=' . $template;

        return $qrCode;
    }
}