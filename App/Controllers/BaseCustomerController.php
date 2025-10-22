<?php
/*
Author: Huy Nguyen
Date: 2025-08-15
Purpose: base customer controller
 */
namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\CustomerSupport;
use App\Models\RenTalPost;
use App\Requests\FileValidate;
use App\Requests\SupportCustomerValidate;
use Core\CSRF;
use Core\Request;
use Core\Response;
use Core\ViewRender;
use Queue\UploadImageForReportViolation;

class BaseCustomerController extends Controller {

    protected $request;
    protected $rentalPostModel;
    protected $customerSupportModel;
    protected $uploadImageOnCLoud;

    public function __construct() {
        parent::__construct();
        $this->request = new Request();
        $this->rentalPostModel = new RenTalPost();
        $this->customerSupportModel = new CustomerSupport();
        $this->uploadImageOnCLoud = new UploadImageForReportViolation();
    }

    // Added by Huy Nguyen on 2025-10-22 to show job page
    public function showJobPage() {
        ViewRender::renderWithLayout('developer-page', [], 'customer/layouts/app');
    }

    // Added by Huy Nguyen on 2025-10-22 to show Hosty Plus page
    public function showHostyPlusPage() {
        ViewRender::renderWithLayout('developer-page', [], 'customer/layouts/app');
    }

    // Added by Huy Nguyen on 2025-10-22 to show support page
    public function showSupportPage() {
        ViewRender::renderWithLayout('support',
            [
                'noFooter' => true,
            ],
            'customer/layouts/app');
    }

    public function handleSupportProblem() {
        $requests = $this->request->post();
        $files = $this->request->file('image_problem');

        $error = SupportCustomerValidate::validate($requests);

        if (!empty($error)) {
            Response::json(['status' => 'error', 'msg' => $error, 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (!isset($files) || !empty($files['name'][0])) {
            $error = FileValidate::validate($files, false);

            if (!empty($error)) {
                Response::json(['status' => 'error', 'msg' => $error, 'data' => $files, 'token' => CSRF::getTokenRefresh()], 400);
            }
        }

        $data = [
            'customer_name' => $requests['customer_name'],
            'customer_email' => $requests['customer_email'],
            'support_type' => $requests['support_type'],
            'description_problem' => $requests['description_problem'],
            'created_at' => date('Y-m-d H:s:i'),
            'updated_at' => date('Y-m-d H:s:i'),
        ];
        $supportId = $this->customerSupportModel->add($data);

        if (empty($supportId)) {
            Response::json(['status' => 'error', 'msg' => 'Có lỗi xảy ra. vui lòng thử lại', 'token' => CSRF::getTokenRefresh()], 400);
        }

        if (!isset($files) || !empty($files['name'][0])) {
            // Lưu files tạm thời trước khi dispatch job
            $savedFiles = $this->saveTemporaryFiles($files, $supportId);

            // Xử lý upload ảnh
            $this->uploadImageOnCLoud->dispatch(['id' => $supportId, 'type' => 'support', 'images' => $savedFiles]);
        }

        Response::json(['status' => 'success', 'msg' => 'Yêu cầu đã được gửi thành công', 'token' => CSRF::getTokenRefresh()], 200);
    }

    public function getPagination($page, $totalData, $limit, $offset) {
        $totalPages = ceil($totalData / $limit);
        return [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_items' => $totalData,
            'items_per_page' => $limit,
            'has_prev' => $page > 1,
            'has_next' => $page < $totalPages,
            'prev_page' => $page > 1 ? $page - 1 : null,
            'next_page' => $page < $totalPages ? $page + 1 : null,
            'showing_from' => $offset + 1,
            'showing_to' => min($offset + $limit, $totalData),
        ];
    }

    /**
     * Lưu files tạm thời để queue worker có thể xử lý sau
     */
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