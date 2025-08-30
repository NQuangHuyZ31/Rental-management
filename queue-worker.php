<?php
/**
 * Queue Worker - Xử lý các jobs trong queue
 * Chạy file này để xử lý queue: php queue-worker.php
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once 'Config/config.php';

use Core\Queue;
use Helpers\Log;

class QueueWorker
{
    private $queue;
    private $isRunning = false;
    private $processedJobs = 0;
    private $startTime;
    
    public function __construct()
    {
        $this->queue = Queue::getInstance();
        $this->startTime = time();
        
        // Log khởi tạo worker
        Log::server("Queue Worker initialized at " . date('Y-m-d H:i:s'));
    }
    
    /**
     * Khởi động worker
     */
    public function start($queueName = 'default', $maxJobs = null, $maxTime = null)
    {
        $this->isRunning = true;
        $this->processedJobs = 0;
        
        $startMessage = "🚀 Queue Worker started at " . date('Y-m-d H:i:s') . "\n";
        $startMessage .= "📋 Queue: {$queueName}\n";
        $startMessage .= "⏰ Max Jobs: " . ($maxJobs ?: 'Unlimited') . "\n";
        $startMessage .= "⏱️  Max Time: " . ($maxTime ?: 'Unlimited') . " seconds\n";
        $startMessage .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        
        Log::queue($startMessage);
        
        // Xử lý signal để dừng worker gracefully
        $this->setupSignalHandlers();
        
        try {
            while ($this->isRunning) {
                // Kiểm tra thời gian tối đa
                if ($maxTime && (time() - $this->startTime) > $maxTime) {
                    $message = "⏰ Max time reached, stopping worker...\n";
                    Log::queue($message);
                    break;
                }
                
                // Kiểm tra số lượng job tối đa
                if ($maxJobs && $this->processedJobs >= $maxJobs) {
                    $message = "📊 Max jobs reached, stopping worker...\n";
                    Log::queue($message);
                    break;
                }
                
                // Lấy job từ queue
                $job = $this->queue->pop($queueName);
                
                if (!$job) {
                    // Không có job nào, nghỉ một chút nhưng vẫn tiếp tục chạy
                    $message = "😴 No jobs available, sleeping for 5 seconds...\n";
                    Log::queue($message);
                    sleep(5);
                    
                    // Log trạng thái worker
                    $statusMessage = "🔄 Worker running... Total processed: {$this->processedJobs}, Running time: " . (time() - $this->startTime) . "s\n";
                    Log::queue($statusMessage);
                    continue;
                }
                
                // Xử lý job
                $this->processJob($job);
                $this->processedJobs++;
                
                // Hiển thị thống kê
                $this->displayStats($queueName);
                
                // Nghỉ một chút để tránh quá tải
                usleep(100000); // 0.1 giây
            }
        } catch (\Exception $e) {
            $errorMessage = "❌ Worker error: " . $e->getMessage() . "\n";
            Log::queue($errorMessage);
        }
        
        $this->stop();
    }
    
    /**
     * Xử lý một job
     */
    private function processJob($job)
    {
        $startTime = microtime(true);
        
        $processMessage = "🔄 Processing job #{$job['id']} ({$job['job_class']})...\n";
        Log::queue($processMessage);
        
        try {
            $result = $this->queue->processJob($job);
            
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            
            if ($result !== false) {
                $successMessage = "✅ Job #{$job['id']} completed successfully in {$duration}ms\n";
                Log::queue($successMessage);
            } else {
                $failMessage = "❌ Job #{$job['id']} failed after {$duration}ms\n";
                Log::queue($failMessage);
            }
            
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            $crashMessage = "💥 Job #{$job['id']} crashed after {$duration}ms: " . $e->getMessage() . "\n";
            Log::queue($crashMessage);
        }
        
    }
    
    /**
     * Hiển thị thống kê
     */
    private function displayStats($queueName)
    {
        $stats = $this->queue->getQueueStats($queueName);
        
        $statsMessage = "📊 Queue Stats:\n";
        $statsMessage .= "   Pending: {$stats['pending']}\n";
        $statsMessage .= "   Processing: {$stats['processing']}\n";
        $statsMessage .= "   Completed: {$stats['completed']}\n";
        $statsMessage .= "   Failed: {$stats['failed']}\n";
        $statsMessage .= "   Total: {$stats['total']}\n";
        $statsMessage .= "   Processed by worker: {$this->processedJobs}\n";
        $statsMessage .= "   Running time: " . (time() - $this->startTime) . "s\n";
        $statsMessage .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        
        Log::queue($statsMessage);
    }
    
    /**
     * Thiết lập signal handlers
     */
    private function setupSignalHandlers()
    {
        if (function_exists('pcntl_signal')) {
            pcntl_signal(SIGTERM, [$this, 'handleSignal']);
            pcntl_signal(SIGINT, [$this, 'handleSignal']);
        }
    }
    
    /**
     * Xử lý signal
     */
    public function handleSignal($signal)
    {
        $signalMessage = "\n🛑 Received signal {$signal}, stopping worker gracefully...\n";
        Log::queue($signalMessage);
        $this->isRunning = false;
    }
    
    /**
     * Dừng worker
     */
    public function stop()
    {
        $this->isRunning = false;
        
        $totalTime = time() - $this->startTime;
        
        $stopMessage = "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        $stopMessage .= "🛑 Queue Worker stopped at " . date('Y-m-d H:i:s') . "\n";
        $stopMessage .= "📊 Total jobs processed: {$this->processedJobs}\n";
        $stopMessage .= "⏱️  Total running time: {$totalTime} seconds\n";
        $stopMessage .= "📈 Average: " . ($this->processedJobs > 0 ? round($totalTime / $this->processedJobs, 2) : 0) . "s per job\n";
        $stopMessage .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            
        Log::queue($stopMessage);
    }
    
    /**
     * Chạy một lần (không loop)
     */
    public function runOnce($queueName = 'default')
    {
        $message = "🔄 Running queue once for queue: {$queueName}\n";
        echo $message;
        Log::queue($message);
        
        $processed = $this->queue->processQueue($queueName, 1);
        
        $resultMessage = "✅ Processed {$processed} job(s)\n";
        echo $resultMessage;
        Log::queue($resultMessage);
        
        return $processed;
    }
    
    /**
     * Chạy liên tục cho tất cả các queue
     */
    public function startAllQueues($maxJobs = null, $maxTime = null)
    {
        $startMessage = "🚀 Starting queue worker for all queues\n";
        $startMessage .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        
        echo $startMessage;
        Log::queue($startMessage);
        
        $this->startTime = time();
        $this->isRunning = true;
        $this->setupSignalHandlers();
        
        while ($this->isRunning) {
            // Lấy danh sách tất cả các queue
            $queues = $this->getAllQueueNames();
            
            foreach ($queues as $queueName) {
                if (!$this->isRunning) break;
                
                // Xử lý jobs trong queue này
                $processed = $this->queue->processQueue($queueName, 10); // Xử lý tối đa 10 jobs mỗi queue
                $this->processedJobs += $processed;
                
                if ($processed > 0) {
                    $queueProcessedMessage = "📋 Queue '{$queueName}': Processed {$processed} job(s)\n";
                    echo $queueProcessedMessage;
                    Log::queue($queueProcessedMessage);
                } else {
                    // Không có job nào trong queue này, log để biết
                    $noJobMessage = "📋 Queue '{$queueName}': No jobs available\n";
                    echo $noJobMessage;
                    Log::queue($noJobMessage);
                }
                
                // Kiểm tra giới hạn
                if ($maxJobs && $this->processedJobs >= $maxJobs) {
                    $limitMessage = "🎯 Reached max jobs limit ({$maxJobs})\n";
                    Log::queue($limitMessage);
                    break 2;
                }
                
                if ($maxTime && (time() - $this->startTime) >= $maxTime) {
                    $timeLimitMessage = "⏰ Reached max time limit ({$maxTime}s)\n";
                    Log::queue($timeLimitMessage);
                    break 2;
                }
                
                // Nghỉ một chút giữa các queue
                usleep(100000); // 0.1 giây
            }
            
            // Nghỉ giữa các vòng lặp và log trạng thái
            $statusMessage = "🔄 Worker running... Total processed: {$this->processedJobs}, Running time: " . (time() - $this->startTime) . "s\n";
            echo $statusMessage;
            Log::queue($statusMessage);
            sleep(5); // Tăng thời gian sleep để giảm spam log
        }
        
        $this->stop();
    }
    
    /**
     * Lấy danh sách tất cả các queue names từ database
     */
    private function getAllQueueNames()
    {
        try {
            $sql = "SELECT DISTINCT queue_name FROM queue_jobs ORDER BY queue_name";
            $db = \Core\Database::getInstance()->getConnection();
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $queues = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            
            // Nếu không có queue nào, trả về default
            if (empty($queues)) {
                return ['default'];
            }
            
            return $queues;
        } catch (\Exception $e) {
            $errorMessage = "⚠️  Error getting queue names: " . $e->getMessage() . "\n";
            Log::queue($errorMessage);
            return ['default'];
        }
    }
}

// Xử lý command line arguments
$options = getopt('', ['queue:', 'max-jobs:', 'max-time:', 'once', 'help', 'all-queues']);

if (isset($options['help'])) {
    echo "Queue Worker - Xử lý các jobs trong queue\n\n";
    echo "Usage: php queue-worker.php [options]\n\n";
    echo "Options:\n";
    echo "  --queue=NAME     Tên queue cụ thể (default: default)\n";
    echo "  --all-queues     Xử lý tất cả các queue\n";
    echo "  --max-jobs=N     Số lượng job tối đa (default: unlimited)\n";
    echo "  --max-time=N     Thời gian chạy tối đa (giây, default: unlimited)\n";
    echo "  --once           Chạy một lần rồi dừng\n";
    echo "  --help           Hiển thị help này\n\n";
    echo "Examples:\n";
    echo "  php queue-worker.php                    # Chạy queue 'default'\n";
    echo "  php queue-worker.php --all-queues       # Chạy tất cả các queue\n";
    echo "  php queue-worker.php --queue=emails     # Chạy queue 'emails'\n";
    echo "  php queue-worker.php --once             # Chạy một lần\n";
    echo "  php queue-worker.php --all-queues --once # Chạy tất cả queue một lần\n";
    exit;
}

// Khởi tạo worker
$worker = new QueueWorker();

// Lấy options
$queueName = $options['queue'] ?? 'default';
$maxJobs = isset($options['max-jobs']) ? (int)$options['max-jobs'] : null;
$maxTime = isset($options['max-time']) ? (int)$options['max-time'] : null;
$runOnce = isset($options['once']);
$allQueues = isset($options['all-queues']);

if ($runOnce) {
    if ($allQueues) {
        // Chạy một lần cho tất cả các queue
        // $worker->runOnceAllQueues();
    } else {
        // Chạy một lần cho queue cụ thể
        $worker->runOnce($queueName);
    }
} else {
    if ($allQueues) {
        // Chạy liên tục cho tất cả các queue
        $worker->startAllQueues($maxJobs, $maxTime);
    } else {
        // Chạy liên tục cho queue cụ thể
        $worker->start($queueName, $maxJobs, $maxTime);
    }
}
