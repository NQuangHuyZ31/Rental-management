<?php

/*
* Author: Huy Nguyen
* Date: 2025-09-01
* Purpose: Queue
*/

namespace Core;

use Core\Database;
use Helpers\Log;

class Queue
{
    // Trạng thái của job
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';
    
    // Độ ưu tiên
    const PRIORITY_LOW = 1;
    const PRIORITY_NORMAL = 2;
    const PRIORITY_HIGH = 3;
    const PRIORITY_URGENT = 4;
    
    // Số lần retry tối đa
    const MAX_RETRIES = 3;
    
    // Thời gian timeout cho job (giây)
    const JOB_TIMEOUT = 300; // 5 phút
    
    private static $instance = null;
    private $db;
    
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Singleton pattern
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Thêm job vào queue
     */
    public function push($jobClass, $jobData = [], $priority = null, $queueName = 'default')
    {
        // Use default priority if none provided
        if ($priority === null) {
            $priority = self::PRIORITY_NORMAL;
        }
        
        try {
            $sql = "INSERT INTO queue_jobs (job_class, job_data, priority, queue_name, created_at) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$jobClass, json_encode($jobData), $priority, $queueName, date('Y-m-d H:i:s')]);
            
            if ($result) {
                $jobId = $this->db->lastInsertId();
                $logData = [
                    'job_id' => $jobId,
                    'job_class' => $jobClass,
                    'queue' => $queueName,
                    'priority' => $priority
                ];
                Log::queue(json_encode($logData));
                
                return $jobId;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::queue([
                'job_class' => $jobClass,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
    
    /**
     * Lấy job tiếp theo từ queue
     */
    public function pop($queueName = 'default')
    {
        try {
            // Lấy job có độ ưu tiên cao nhất và chưa được xử lý
            $sql = "SELECT * FROM queue_jobs 
                    WHERE status = ? AND queue_name = ? AND attempts < max_attempts
                    ORDER BY priority DESC, created_at ASC 
                    LIMIT 1";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([self::STATUS_PENDING, $queueName]);
            $job = $stmt->fetch();
            
            if ($job) {
                // Cập nhật trạng thái thành processing
                $this->updateJobStatus($job['id'], self::STATUS_PROCESSING, [
                    'started_at' => date('Y-m-d H:i:s')
                ]);
                
                return $job;
            }
            
            return null;
        } catch (\Exception $e) {
            Log::queue([
                'queue' => $queueName,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
    
    /**
     * Xử lý job
     */
    public function processJob($job)
    {
        try {
            $jobClass = $job['job_class'];
            $jobData = json_decode($job['job_data'], true);
            
            // Kiểm tra class có tồn tại không
            if (!class_exists($jobClass)) {
                throw new \Exception("Job class {$jobClass} not found");
            }
            
            // Tạo instance của job class
            $jobInstance = new $jobClass();
            
            // Kiểm tra method handle có tồn tại không
            if (!method_exists($jobInstance, 'handle')) {
                throw new \Exception("Job class {$jobClass} must have handle method");
            }
            
            // Thực thi job
            $result = $jobInstance->handle($jobData);
            
            // Cập nhật trạng thái thành completed
            $this->updateJobStatus($job['id'], self::STATUS_COMPLETED, [
                'completed_at' => date('Y-m-d H:i:s')
            ]);
            
            return $result;
            
        } catch (\Exception $e) {
            // Cập nhật trạng thái thành failed
            $this->updateJobStatus($job['id'], self::STATUS_FAILED, [
                'error_message' => $e->getMessage(),
                'attempts' => $job['attempts'] + 1
            ]);
            
            // Nếu còn retry, đưa job về trạng thái pending
            if ($job['attempts'] + 1 < $job['max_attempts']) {
                $this->updateJobStatus($job['id'], self::STATUS_PENDING);
            }
            
            return false;
        }
    }
    
    /**
     * Xử lý tất cả jobs trong queue
     */
    public function processQueue($queueName = 'default', $maxJobs = 100)
    {
        $processed = 0;
        $startTime = time();
        
        Log::queue([
            'queue' => $queueName,
            'max_jobs' => $maxJobs
        ]);
        
        while ($processed < $maxJobs && (time() - $startTime) < self::JOB_TIMEOUT) {
            $job = $this->pop($queueName);
            
            if (!$job) {
                // Không còn job nào
                break;
            }
            
            $this->processJob($job);
            $processed++;
            
            // Nghỉ một chút để tránh quá tải
            usleep(100000); // 0.1 giây
        }
        
        Log::queue([
            'queue' => $queueName,
            'processed' => $processed,
            'duration' => time() - $startTime
        ]);
        
        return $processed;
    }
    
    /**
     * Cập nhật trạng thái job
     */
    private function updateJobStatus($jobId, $status, $additionalData = [])
    {
        $sql = "UPDATE queue_jobs SET status = ?, updated_at = NOW()";
        $params = [$status];
        
        if (isset($additionalData['started_at'])) {
            $sql .= ", started_at = ?";
            $params[] = $additionalData['started_at'];
        }
        
        if (isset($additionalData['completed_at'])) {
            $sql .= ", completed_at = ?";
            $params[] = $additionalData['completed_at'];
        }
        
        if (isset($additionalData['error_message'])) {
            $sql .= ", error_message = ?";
            $params[] = $additionalData['error_message'];
        }
        
        if (isset($additionalData['attempts'])) {
            $sql .= ", attempts = ?";
            $params[] = $additionalData['attempts'];
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $jobId;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Lấy thống kê queue
     */
    public function getQueueStats($queueName = 'default')
    {
        $sql = "SELECT 
                    status,
                    COUNT(*) as count,
                    AVG(TIMESTAMPDIFF(SECOND, created_at, COALESCE(completed_at, NOW()))) as avg_duration
                FROM queue_jobs 
                WHERE queue_name = ?
                GROUP BY status";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$queueName]);
        $stats = $stmt->fetchAll();
        
        $result = [
            'pending' => 0,
            'processing' => 0,
            'completed' => 0,
            'failed' => 0,
            'cancelled' => 0,
            'total' => 0
        ];
        
        foreach ($stats as $stat) {
            $result[$stat['status']] = $stat['count'];
            $result['total'] += $stat['count'];
        }
        
        return $result;
    }
    
    /**
     * Xóa jobs đã hoàn thành (cũ hơn X ngày)
     */
    public function cleanupCompletedJobs($daysOld = 7)
    {
        $sql = "DELETE FROM queue_jobs 
                WHERE status IN (?, ?) 
                AND completed_at < DATE_SUB(NOW(), INTERVAL ? DAY)";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([self::STATUS_COMPLETED, self::STATUS_FAILED, $daysOld]);
        
        Log::queue([
            'days_old' => $daysOld,
            'affected_rows' => $stmt->rowCount()
        ]);
        
        return $result;
    }
    
    /**
     * Retry failed jobs
     */
    public function retryFailedJobs($queueName = 'default')
    {
        $sql = "UPDATE queue_jobs 
                SET status = ?, attempts = 0, error_message = NULL, updated_at = NOW()
                WHERE status = ? AND queue_name = ? AND attempts >= max_attempts";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([self::STATUS_PENDING, self::STATUS_FAILED, $queueName]);
        
        $affectedRows = $stmt->rowCount();
        
        Log::queue([
            'queue' => $queueName,
            'affected_rows' => $affectedRows
        ]);
        
        return $affectedRows;
    }
    
    /**
     * Hủy job
     */
    public function cancelJob($jobId)
    {
        return $this->updateJobStatus($jobId, self::STATUS_CANCELLED);
    }
    
    /**
     * Lấy thông tin job
     */
    public function getJob($jobId)
    {
        $sql = "SELECT * FROM queue_jobs WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$jobId]);
        return $stmt->fetch();
    }
    
    /**
     * Lấy danh sách jobs theo trạng thái
     */
    public function getJobsByStatus($status, $queueName = 'default', $limit = 100)
    {
        $sql = "SELECT * FROM queue_jobs 
                WHERE status = ? AND queue_name = ?
                ORDER BY created_at DESC 
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$status, $queueName, $limit]);
        return $stmt->fetchAll();
    }
}
