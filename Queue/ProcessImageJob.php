<?php

namespace Queue;

use Core\Job;
use Core\Queue;

class ProcessImageJob extends Job
{
    protected $priority = Queue::PRIORITY_NORMAL;
    protected $queueName = 'images';
    protected $maxAttempts = 2;
    
    public function handle($data)
    {
        $this->before();
        
        try {
            $imagePath = $data['image_path'] ?? '';
            $operations = $data['operations'] ?? [];
            
            if (empty($imagePath)) {
                throw new \Exception("Image path is required");
            }
            
            // Giả lập xử lý hình ảnh
            sleep(3);
            
            // Giả lập các operations
            $processedImagePath = $this->processImage($imagePath, $operations);
            
            error_log("Image processed successfully: " . json_encode([
                'original_path' => $imagePath,
                'processed_path' => $processedImagePath,
                'operations' => $operations,
                'timestamp' => date('Y-m-d H:i:s')
            ]));
            
            $this->after();
            
            return [
                'success' => true,
                'original_path' => $imagePath,
                'processed_path' => $processedImagePath,
                'operations' => $operations,
                'processed_at' => date('Y-m-d H:i:s')
            ];
            
        } catch (\Exception $e) {
            $this->failed($e);
            throw $e;
        }
    }
    
    private function processImage($imagePath, $operations)
    {
        // Giả lập xử lý hình ảnh
        $filename = basename($imagePath);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $name = pathinfo($filename, PATHINFO_FILENAME);
        
        $processedPath = "processed_{$name}_" . time() . ".{$extension}";
        
        // Giả lập các operations
        foreach ($operations as $operation) {
            switch ($operation['type']) {
                case 'resize':
                    // Giả lập resize
                    break;
                case 'crop':
                    // Giả lập crop
                    break;
                case 'filter':
                    // Giả lập filter
                    break;
            }
        }
        
        return $processedPath;
    }
    
    public function before()
    {
        error_log("Starting image processing: " . ($this->data['image_path'] ?? 'unknown'));
    }
    
    public function after()
    {
        error_log("Image processing completed successfully");
    }
    
    public function failed($exception)
    {
        error_log("Image processing failed: " . $exception->getMessage());
    }
}
