<?php

/*
 * Author: Huy Nguyen
 * Date: 2025-10-21
 * Purpose: upload images report violation
 */

namespace Queue;

use App\Models\CustomerSupport;
use App\Models\ReportViolation;
use Core\Job;
use Exception;
use Helpers\UploadClound;

class UploadImageForReportViolation extends Job {
    protected $priority = \Core\Queue::PRIORITY_HIGH;
    protected $queueName = 'upload-image-on-cloud';
    protected $maxAttempts = 5;
    protected $reportViolationModel;
    protected $customerSupportModel;

    public function __construct() {
        parent::__construct();
        $this->reportViolationModel = new ReportViolation();
        $this->customerSupportModel = new CustomerSupport();
    }

    /**
     * Handle the job - upload images to cloud and update post
     */
    public function handle($data) {
        try {
            $id = $data['id'];
            $images = $data['images'];
            $type = $data['type'] ?? 'report';
            $uploadedUrls = [];

            // Upload each image to cloud
            $fileCount = count($images['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                // Kiểm tra file có tồn tại không
                if (empty($images['name'][$i])) {
                    continue;
                }

                // Tạo mảng ảnh từ $_FILES structure
                $image = [
                    'name' => $images['name'][$i],
                    'type' => $images['type'][$i],
                    'tmp_name' => $images['tmp_name'][$i],
                    'error' => $images['error'][$i],
                    'size' => $images['size'][$i],
                ];

                // Kiểm tra lỗi upload
                if ($image['error'] !== UPLOAD_ERR_OK) {
                    continue;
                }

                // Kiểm tra file tạm thời có tồn tại không
                if (!file_exists($image['tmp_name'])) {
                    continue;
                }

                // Kiểm tra file có kích thước > 0
                if (filesize($image['tmp_name']) === 0) {
                    continue;
                }

                // Tạo tên file unique
                $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                $filePath = 'post_' . $id . '_' . time() . '_' . $i . '_' . hash('sha1', $image['name']);

                try {
                    // Upload lên Cloudinary
                    $url_path = UploadClound::upload($image['tmp_name'], 'report_violation', $filePath);

                    if ($url_path) {
                        $uploadedUrls[] = $url_path;
                    } else {
                    }
                } catch (Exception $e) {
                    error_log("UploadImageOnCloud: Error: " . $e->getMessage());
                }
            }

            // Update post with uploaded image URLs
            if ($type == 'support') {
                $this->customerSupportModel->updateColumn($id, 'images', $uploadedUrls);
            } else {
                $this->reportViolationModel->updateColumn($id, 'note', $uploadedUrls);
            }

            // Clean up temporary files
            $this->cleanupTempFiles($id);

        } catch (\Exception $e) {
            error_log("UploadImageOnCloud: Error: " . $e->getMessage());
        }
    }

    /**
     * Clean up temporary files after upload
     */
    private function cleanupTempFiles($reportId) {
        // Use __DIR__ to get the correct path in CLI mode
        $rootPath = ROOT_PATH;
        $tempDir = $rootPath . 'temp_uploads/' . $reportId;

        if (is_dir($tempDir)) {
            $files = glob($tempDir . '/*');

            foreach ($files as $file) {
                if (is_file($file)) {
                    if (unlink($file)) {
                    }
                }
            }
        }
    }
}
