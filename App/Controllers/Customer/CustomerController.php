<?php

/*
Author: Huy Nguyen
Date: 2025-09-13
Purpose: Customer Controller
 */
namespace App\Controllers\Customer;

use App\Controllers\BaseCustomerController;
use App\Models\Amenity;
use App\Models\Invoice;
use App\Models\PaymentHistory;
use App\Models\RentalPostInterest;
use App\Models\ReportViolation;
use App\Models\Service;
use App\Models\Tenant;
use App\Models\User;
use App\Requests\FileValidate;
use Core\CSRF;
use Core\Response;
use Core\Session;
use Queue\UploadImageForReportViolation;

class CustomerController extends BaseCustomerController {

    protected $invoiceModel;
    protected $tenantModel;
    protected $amenityModel;
    protected $serviceModel;
    protected $rentalPostInterestModel;
    protected $reportViolationModel;
    protected $paymentHistoryModel;
    protected $uploadImageReportViolation;
    protected $userModel;
    protected $user;

    public function __construct() {
        parent::__construct();
        $this->invoiceModel = new Invoice();
        $this->tenantModel = new Tenant();
        $this->amenityModel = new Amenity();
        $this->serviceModel = new Service();
        $this->rentalPostInterestModel = new RentalPostInterest();
        $this->reportViolationModel = new ReportViolation();
        $this->paymentHistoryModel = new PaymentHistory();
        $this->uploadImageReportViolation = new UploadImageForReportViolation();
        $this->userModel = new User();
        $this->user = Session::get('user');
    }

    public function sidebarData() {
        $invoicePending = $this->invoiceModel->getAllInvoicesByStatus('pending');
        $room = $this->tenantModel->getAllRoomByUserId();

        return [
            'invoicePending' => count($invoicePending),
            'room' => count($room),
        ];
    }

    public function addPostInterest() {
        $request = $this->request->post();

        if (!isset($request['postId']) || (isset($request['postId']) && empty($request['postId']))) {
            Response::json(['status' => 'error', 'msg' => 'Bài đăng không tồn tại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'msg' => 'Có lỗi xảy ra. Vui lòng thử lại.'], 400);
        }

        $data = [
            'user_id' => $this->user['id'],
            'rental_post_id' => $request['postId'],
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d H:s:i'),
        ];
        $checkisset = $this->rentalPostInterestModel->getByUserId($this->user['id'], $request['postId']);

        if ($checkisset) {
            Response::json(['status' => 'error', 'msg' => 'Bài đăng đã có trong danh mục quan tâm', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (!$this->rentalPostInterestModel->add($data)) {
            Response::json(['status' => 'error', 'msg' => 'Có lỗi xảy ra. Vui lòng thử lại.'], 400);
        }

        $rentalPostInterestAll = $this->rentalPostInterestModel->getByUserId($this->user['id']);

        Response::json(['status' => 'sucess', 'msg' => 'Đã thêm vào danh mục quan tâm', 'total_post_interest' => count($rentalPostInterestAll), 'token' => CSRF::getTokenRefresh()], 200);
    }

    public function sendReportViolation() {
        $request = $this->request->post();
        $files = $this->request->file('evidence_urls');
        $error = '';

        if (!CSRF::validatePostRequest()) {
            Response::json(['status' => 'error', 'msg' => 'Có lỗi xảy ra. vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (!isset($files) || !empty($files['name'][0])) {
            $error = FileValidate::validate($files, false);

            if (!empty($error)) {
                Response::json(['status' => 'error', 'msg' => $error, 'data' => $files, 'token' => CSRF::getTokenRefresh()], 400);
            }
        }

        $data = [
            'target_id' => $this->user['id'],
            'title' => $request['target_title'],
            'rental_post_id' => $request['postId'],
            'target_type' => $request['target_type'],
            'violattion_type' => $request['violation_type'],
            'description' => $request['description'],
            'created_at' => date('Y-m-d H:s:i'),
        ];

        $reportId = $this->reportViolationModel->add($data);

        if (empty($reportId)) {
            Response::json(['status' => 'error', 'msg' => 'Có lỗi xảy ra. vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (!isset($files) || !empty($files['name'][0])) {
            // Lưu files tạm thời trước khi dispatch job
            $savedFiles = $this->saveTemporaryFiles($files, $reportId);

            // Xử lý upload ảnh
            $this->uploadImageReportViolation->dispatch(['id' => $reportId, 'images' => $savedFiles]);
        }

        Response::json(['status' => 'success', 'msg' => 'Cảm ơn bạn đã báo cáo. Hosty sẽ xử lí trong vào 24h tới', 'token' => CSRF::getTokenRefresh()], 200);
    }

    private function saveTemporaryFiles($files, $postId) {
        $savedFiles = [
            'name' => [],
            'type' => [],
            'tmp_name' => [],
            'error' => [],
            'size' => [],
        ];

        $fileCount = count($files['name']);

        for ($i = 0; $i < $fileCount; $i++) {
            if (empty($files['name'][$i])) {
                continue;
            }

            // Tạo thư mục lưu trữ tạm thời
            $tempDir = ROOT_PATH . '/temp_uploads/' . $postId;
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Tạo tên file mới
            $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $newFileName = 'image_' . $i . '_' . time() . '.' . $extension;
            $newFilePath = $tempDir . '/' . $newFileName;

            // Copy file từ temp directory sang thư mục lưu trữ
            if (copy($files['tmp_name'][$i], $newFilePath)) {
                $savedFiles['name'][] = $files['name'][$i];
                $savedFiles['type'][] = $files['type'][$i];
                $savedFiles['tmp_name'][] = $newFilePath;
                $savedFiles['error'][] = $files['error'][$i];
                $savedFiles['size'][] = $files['size'][$i];
            }
        }

        return $savedFiles;
    }
}