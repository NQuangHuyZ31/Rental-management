<?php
/*
    Author: Huy Nguyen
    Date: 2025-09-01
    Purpose: Queue Worker for Cron Job
*/

/**
 * Queue Worker cho Cron Job - Xử lý các jobs trong queue
 * 
 * ⚠️  ĐƯỢC THIẾT KẾ ĐẶC BIỆT CHO CRON JOB:
 *   - Cron chạy mỗi phút (60 giây)
 *   - Worker sẽ chạy liên tục trong 50 giây với interval 5 giây
 *   - Sau 50 giây tự động dừng để cron có thể chạy lại
 *   - Điều này cho phép queue chạy mỗi 5 giây thay vì mỗi phút
 * 
 * Cách sử dụng:
 *   - php queue-worker-cron.php                    # chạy tất cả queues với cron mode
 *   - php queue-worker-cron.php --queue=emails     # chỉ chạy queue "emails"
 *   - php queue-worker-cron.php --max-jobs=100     # giới hạn số jobs xử lý
 * 
 * Ví dụ cron job:
 *   * * * * * php /path/to/queue-worker-cron.php
 *   (Chạy mỗi phút, nhưng queue sẽ xử lý jobs mỗi 5 giây trong 50 giây)
 */

 require_once __DIR__ . '/vendor/autoload.php';

 // Load file .env trước
 $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
 $dotenv->load();
 
 // Sau khi $_ENV có dữ liệu rồi mới require config.php
 require_once 'Config/config.php';

use Core\Queue;

class CronQueueWorker
{
    private $queue;
    private $processedJobs = 0;
    private $startTime;
    
    // Cấu hình cron mode
    private $cronTimeLimit = 50;        // Chạy trong 50 giây
    private $jobInterval = 5;           // Xử lý jobs mỗi 5 giây
    
    public function __construct()
    {
        $this->queue = Queue::getInstance();
        $this->startTime = time();
    }
    
    /**
     * Chạy worker với cron mode
     */
    public function run($queueName = null, $maxJobs = null)
    {
        echo "🚀 Cron Queue Worker started at " . date('Y-m-d H:i:s') . "\n";
        echo "⏰ Cron Mode: Running for {$this->cronTimeLimit}s with {$this->jobInterval}s intervals\n";
        echo "📋 Target: " . ($queueName ? "Queue '{$queueName}'" : "All queues") . "\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        
        $lastJobTime = time();
        
        while ((time() - $this->startTime) < $this->cronTimeLimit) {
            $currentTime = time();
            
            // Xử lý jobs mỗi $jobInterval giây
            if (($currentTime - $lastJobTime) >= $this->jobInterval) {
                $this->processJobs($queueName, $maxJobs);
                $lastJobTime = $currentTime;
                
                // Hiển thị thời gian còn lại
                $remainingTime = $this->cronTimeLimit - ($currentTime - $this->startTime);
                echo "⏰ Time remaining: {$remainingTime}s, Jobs processed: {$this->processedJobs}\n";
                
                // Kiểm tra giới hạn jobs
                if ($maxJobs && $this->processedJobs >= $maxJobs) {
                    echo "🎯 Reached max jobs limit ({$maxJobs})\n";
                    break;
                }
            }
            
            // Nghỉ 1 giây để tránh quá tải CPU
            usleep(100000); // 0.1 giây
        }
        
        $this->stop();
    }
    
    /**
     * Xử lý jobs
     */
    private function processJobs($queueName = null, $maxJobs = null)
    {
        if ($queueName) {
            // Xử lý queue cụ thể
            $this->processSingleQueue($queueName, $maxJobs);
        } else {
            // Xử lý tất cả các queue
            $this->processAllQueues($maxJobs);
        }
    }
    
    /**
     * Xử lý một queue cụ thể
     */
    private function processSingleQueue($queueName, $maxJobs = null)
    {
        $job = $this->queue->pop($queueName);
        
        if ($job) {
            $this->processJob($job);
            $this->processedJobs++;
            echo "📋 Queue '{$queueName}': Processed job #{$job['id']}\n";
        } else {
            echo "😴 Queue '{$queueName}': No jobs available\n";
        }
    }
    
    /**
     * Xử lý tất cả các queue
     */
    private function processAllQueues($maxJobs = null)
    {
        $queues = $this->getAllQueueNames();
        $processedSomething = false;
        
        foreach ($queues as $queueName) {
            // Kiểm tra giới hạn jobs
            if ($maxJobs && $this->processedJobs >= $maxJobs) {
                break;
            }
            
            $job = $this->queue->pop($queueName);
            
            if ($job) {
                $this->processJob($job);
                $this->processedJobs++;
                $processedSomething = true;
                echo "📋 Queue '{$queueName}': Processed job #{$job['id']}\n";
            }
        }
        
        if (!$processedSomething) {
            echo "😴 All queues: No jobs available\n";
        }
    }
    
    /**
     * Xử lý một job
     */
    private function processJob($job)
    {
        try {
            $result = $this->queue->processJob($job);
            
            if ($result !== false) {
                echo "✅ Job #{$job['id']} ({$job['job_class']}) completed successfully\n";
            } else {
                echo "❌ Job #{$job['id']} ({$job['job_class']}) failed\n";
            }
            
        } catch (\Exception $e) {
            echo "💥 Job #{$job['id']} ({$job['job_class']}) crashed: " . $e->getMessage() . "\n";
        }
    }
    
    /**
     * Lấy danh sách tất cả các queue names
     */
    private function getAllQueueNames()
    {
        try {
            $sql = "SELECT DISTINCT queue_name FROM queue_jobs ORDER BY queue_name";
            $db = \Core\Database::getInstance()->getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $queues = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            
            return !empty($queues) ? $queues : ['default'];
        } catch (\Exception $e) {
            echo "⚠️ Error getting queue names: " . $e->getMessage() . "\n";
            return ['default'];
        }
    }
    
    /**
     * Dừng worker
     */
    private function stop()
    {
        $totalTime = time() - $this->startTime;
        
        echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "🛑 Cron Queue Worker stopped at " . date('Y-m-d H:i:s') . "\n";
        echo "📊 Total jobs processed: {$this->processedJobs}\n";
        echo "⏱️  Total running time: {$totalTime} seconds\n";
        echo "📈 Average: " . ($this->processedJobs > 0 ? round($totalTime / $this->processedJobs, 2) : 0) . "s per job\n";
        echo "⏰ Stopped for cron to run again in " . (60 - $totalTime) . " seconds\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    }
}

// --- CLI Options ---
$options = getopt('', ['queue:', 'max-jobs:', 'help']);

if (isset($options['help'])) {
    echo "Cron Queue Worker - Xử lý các jobs trong queue cho cron job\n\n";
    echo "Usage: php queue-worker-cron.php [options]\n\n";
    echo "Options:\n";
    echo "  --queue=NAME     Tên queue cụ thể (default: tất cả queues)\n";
    echo "  --max-jobs=N     Số lượng job tối đa (default: unlimited)\n";
    echo "  --help           Hiển thị help này\n\n";
    echo "Cron Mode:\n";
    echo "  - Chạy liên tục trong 50 giây với interval 5 giây\n";
    echo "  - Tự động dừng để cron có thể chạy lại\n";
    echo "  - Cho phép queue chạy mỗi 5 giây thay vì mỗi phút\n\n";
    echo "Examples:\n";
    echo "  php queue-worker.php                    # Chạy tất cả queues\n";
    echo "  php queue-worker.php --queue=emails     # Chỉ chạy queue emails\n";
    echo "  php queue-worker.php --max-jobs=100     # Giới hạn 100 jobs\n\n";
    echo "Cron job example:\n";
    echo "  * * * * * php /path/to/queue-worker.php\n";
    exit;
}

// Khởi tạo worker
$worker = new CronQueueWorker();

// Lấy options
$queueName = $options['queue'] ?? null;
$maxJobs = isset($options['max-jobs']) ? (int)$options['max-jobs'] : null;

// Chạy worker
$worker->run($queueName, $maxJobs);
