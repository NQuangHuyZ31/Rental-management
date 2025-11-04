<?php

/*

Author: Huy Nguyen
Date: 2025-09-14
Purpose: Payment Controller
 */
namespace App\Controllers\Customer;

use App\Models\House;
use App\Models\Room;
use App\Models\ServiceUsage;
use App\Models\UserBanking;
use Core\CSRF;
use Core\Response;
use Helpers\Log;
use Helpers\PDF;

class PaymentController extends CustomerController {
    private $userBankingModel;
    protected $houseModel;
    protected $roomModel;
    protected $serviceUsageModel;

    public function __construct() {
        parent::__construct();
        $this->userBankingModel = new UserBanking();
        $this->houseModel = new House();
        $this->roomModel = new Room();
        $this->serviceUsageModel = new ServiceUsage();
    }

    public function payment() {
        $data = $this->request->post();

        if (!CSRF::validatePostRequest()) {
            Response::json(['message' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
            exit;
        }

        // Lấy thông tin hóa đơn
        $invoice = $this->invoiceModel->getInvoiceByInvoiceId($data['invoice_id']);

        if (!$invoice) {
            Response::json(['message' => 'Hóa đơn không tồn tại', 'token' => CSRF::getTokenRefresh()], 404);
            exit;
        }

        // Lấy thông tin phòng và nhà
        $roomInfo = $this->invoiceModel->getInvoiceWithRoomInfo($data['invoice_id']);

        // Lấy thông tin tài khoản
        $userBanking = $this->userBankingModel->getUserBankingByUserId($roomInfo['owner_id']);

        $qrCode = $this->generateQRCode($invoice, $userBanking);
        $bankingInfo = [
            'bank_name' => $userBanking['bank_account_name'],
            'bank_number' => $userBanking['bank_account_number'],
            'user_name' => $userBanking['user_bank_name'],
        ];

        Response::json(['status' => 'success', 'data' => $invoice, 'roomInfo' => $roomInfo, 'qrCode' => $qrCode, 'bankingInfo' => $bankingInfo, 'token' => CSRF::getTokenRefresh()], 200);
    }

    public function callback() {
        // get data from webhook
        $data = json_decode(file_get_contents('php://input'));

        if (!is_object($data)) {
            Response::json(['status' => 'error', 'message' => 'No data'], 400);
            exit;
        }

        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? null;
        $userID = $this->userID;

        // Tách ra API Key (bỏ chữ "Apikey ")
        if (stripos($authHeader, 'Apikey ') === 0) {
            $apiKey = substr($authHeader, 7); // cắt phần "Apikey "
        } else {
            $apiKey = $authHeader; // fallback
        }

        $userBanking = $this->userBankingModel->getUserBankingByBankAccountNumber($data->accountNumber);

        if (!$userBanking || $apiKey != $userBanking['api_key'] || $data->accountNumber != $userBanking['bank_account_number']) {
            Log::payment('API Key không hợp lệ: ' . $apiKey . ' - ' . $data->accountNumber, Log::LEVEL_ERROR);
            Response::json(['status' => 'error', 'message' => 'API Key không hợp lệ'], 400);
            exit;
        }

        try {
            $this->db->beginTransaction();

            if (preg_match('/HD(\d+)/', $data->description, $matches)) {
                $invoiceID = $matches[1];
            } else {
                $invoiceID = null;
            }

            $dataPayment = [
                'invoice_id' => $invoiceID,
                'payer_id' => $userID,
                'receiver_id' => $userBanking['user_id'],
                'order_id' => $data->id,
                'transaction_id' => $data->referenceCode,
                'amount' => $data->transferAmount,
                'payment_date' => date('Y-m-d', strtotime($data->transactionDate)),
                'description' => $data->description,
                'gateway' => $data->gateway,
                'account_number' => $data->accountNumber,
                'transferType' => $data->transferType,
                'referenceCode' => $data->referenceCode,
                'type' => 'invoice',
                'status' => 'success-paid',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // create payment history
            $this->paymentHistoryModel->create($dataPayment);
            // update invoice status
            $invoice = $this->invoiceModel->getInvoiceByInvoiceId($invoiceID);

            if (!$invoice) {
                Log::payment('Hóa đơn không tồn tại: ' . $invoiceID, Log::LEVEL_ERROR);
                Response::json(['status' => 'error', 'message' => 'Hóa đơn không tồn tại'], 404);
                exit;
            }

            $this->invoiceModel->updateInvoiceOnlyStatus($invoice['id'], 'paid');
            $this->db->commit();

            Response::json(['status' => 'success', 'payment_status' => 'paid', 'message' => 'Thanh toán thành công'], 200);
        } catch (\Throwable $th) {
            $this->db->rollback();
            Log::payment('Lỗi thanh toán: ' . $th->getMessage(), Log::LEVEL_ERROR);
            Response::json(['status' => 'error', 'payment_status' => 'failed', 'message' => $th->getMessage()], 400);
            exit;
        }

    }

    public function checkPaymentStatus() {
        $data = $this->request->post();

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'message' => 'Có lỗi xảy ra. Vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
            exit;
        }

        $invoice = $this->invoiceModel->getInvoiceByInvoiceId($data['invoice_id']);
        $paymentHistory = $this->paymentHistoryModel->getPaymentHistoryByInvoiceId($data['invoice_id']);

        if ($invoice && $invoice['invoice_status'] != 'paid') {
            Response::json(['status' => 'error', 'payment_status' => 'failed', 'message' => 'Hóa đơn không tồn tại hoặc đã thanh toán', 'token' => CSRF::getTokenRefresh()], 400);
            exit;
        }

        $this->invoiceModel->updateColumn($invoice['id'], 'user_id', $this->userID);
        $this->invoiceModel->updateColumn($invoice['id'], 'pay_at', date('Y-m-d'));
        $this->paymentHistoryModel->updatePaymentHistory($paymentHistory['id'], ['payer_id' => $this->userID]);
        Response::json(['status' => 'success', 'payment_status' => 'paid', 'message' => 'Thanh toán thành công', 'token' => CSRF::getTokenRefresh()], 200);
    }

    public function generateQRCode($invoice, $userBanking) {
        $bankNumber = $userBanking['bank_account_number'];
        $bankCode = $userBanking['bank_code'];

        $totalAmount = intval($invoice['total']);
        $des = 'Thanh toán hóa đơn phòng tháng ' . $invoice['invoice_month'] . ' : HD' . $invoice['id'];
        $template = 'compact';

        $qrCode = 'https://qr.sepay.vn/img?acc=' . $bankNumber . '&bank=' . $bankCode . '&amount=' . $totalAmount . '&des=' . $des . '&template=' . $template;

        return $qrCode;
    }

    public function dowloadInvoice($id) {
        $invoiceID = $id;

        $invoice = $this->invoiceModel->getInvoiceById($invoiceID);

        if (!$invoice) {
            $this->request->redirectWithErrors('customer/bills', 'Hóa đơn không tồn tại hoặc chưa thanh toán');
        }

        $house = $this->houseModel->getHouseById($invoice['house_id']);
        $owner = $this->userModel->getUserById($house['owner_id']);
        $room = $this->roomModel->getRoomById($invoice['room_id']);
        $tenants = $this->tenantModel->getAllUserByRoomId($room['id']);
        $banking = $this->userBankingModel->getUserBankingByUserId($owner['id']);
        $tenantData = [];

        foreach ($tenants as $tenant) {
            $result = $this->userModel->getUserById($tenant['user_id']);
            $tenantData[] = $result;
        }

        $services = $this->serviceModel->getServicesByRoomId($room['id']);

        $serviceData = [];

        foreach ($services as $service) {
            $serviceUsage = $this->serviceUsageModel->getServiceUsageByRoomAndServiceId($room['id'], $service['id']);
            $item = [
                'service_name' => $service['service_name'],
                'unit' => $service['unit_vi'],
                'unit_price' => $service['service_price'],
                'old_value' => !empty($serviceUsage['old_value']) ? $serviceUsage['old_value'] : '',
                'new_value' => !empty($serviceUsage['new_value']) ? $serviceUsage['new_value'] : '',
                'usage_amount' => $serviceUsage['usage_amount'],
                'total_service' => $serviceUsage['total_amount'],
            ];
            $serviceData[] = $item;
        }

        PDF::createPDF('invoice-template', $invoice['ref_code'] ,[
            'invoice' => $invoice,
            'house' => $house,
            'owner' => $owner,
            'room' => $room,
            'tenants' => $tenantData,
            'services' => $serviceData,
            'banking' => $banking,
        ]);

        // ViewRender::renderWithLayout('template/pdf/invoice-template', [
        //     'invoice' => $invoice,
        //     'house' => $house,
        //     'owner' => $owner,
        //     'room' => $room,
        //     'tenants' => $tenantData,
        //     'services' => $serviceData,
        //     'banking' => $banking,
        // ], 'template/pdf/base-pdf-template');
    }
}