<?php

/*
 * Author: Huy Nguyen
 * Date: 2025-01-15
 * Purpose: Upload images to cloud using queue
 */

namespace Queue;

use App\Models\RenTalPost;
use Core\Job;
use Exception;
use Helpers\Log;
use Helpers\UploadClound;

class UploadImageOnCloud extends Job {
    protected $priority = \Core\Queue::PRIORITY_HIGH;
    protected $queueName = 'upload-image-on-cloud';
    protected $maxAttempts = 5;
    protected $rentalPostModel;

    public function __construct() {
        parent::__construct();
        $this->rentalPostModel = new RenTalPost();
    }

    /**
     * Handle the job - upload images to cloud and update post
     */
    public function handle($data) {
        try {
            $postId = $data['post_id'];
            $images = $data['images'];
            $prevImages = $data['prev_images'] ?? [];
            $uploadedUrls = [];
            
            if (!empty($prevImages)) {
                foreach ($prevImages as $prevImage) {
                    UploadClound::delete(UploadClound::getPublicIdFromUrl($prevImage));
                }
            }

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
                $filePath = 'post_' . $postId . '_' . time() . '_' . $i . '_' . hash('sha1', $image['name']);

                try {
                    // Upload lên Cloudinary
                    $url_path = UploadClound::upload($image['tmp_name'], 'rental_post_images', $filePath);

                    if ($url_path) {
                        $uploadedUrls[] = $url_path;
                    } else {
                    }
                } catch (Exception $e) {
                }
            }

            // Update post with uploaded image URLs
            $this->rentalPostModel->updatePostImages($postId, $uploadedUrls);

            // Clean up temporary files
            $this->cleanupTempFiles($postId);

        } catch (\Exception $e) {
            Log::server("UploadImageOnCloud: Error: " . $e->getMessage());
        }
    }

    /**
     * Clean up temporary files after upload
     */
    private function cleanupTempFiles($postId) {
        // Use __DIR__ to get the correct path in CLI mode
        $rootPath = dirname(__DIR__);
        $tempDir = $rootPath . '/temp_uploads/' . $postId;

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
