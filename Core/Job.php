<?php

/*
* Author: Huy Nguyen
* Date: 2025-09-01
* Purpose: Job
*/

namespace Core;

use Helpers\Log;

abstract class Job
{
    /**
     * Dữ liệu job
     */
    protected $data;
    
    /**
     * Job ID
     */
    protected $jobId;
    
    /**
     * Số lần retry hiện tại
     */
    protected $attempts;
    
    /**
     * Số lần retry tối đa
     */
    protected $maxAttempts = 3;
    
    /**
     * Độ ưu tiên
     */
    protected $priority = \Core\Queue::PRIORITY_NORMAL;
    
    /**
     * Tên queue
     */
    protected $queueName = 'default';
    
    /**
     * Thời gian delay trước khi thực thi (giây)
     */
    protected $delay = 0;
    
    /**
     * Thời gian timeout cho job (giây)
     */
    protected $timeout = 300; // 5 phút
    
    /**
     * Constructor
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }
    
    /**
     * Thực thi job - method này phải được implement bởi class con
     */
    abstract public function handle($data);
    
    /**
     * Thêm job vào queue
     */
    public function dispatch($data = null, $priority = null, $queueName = null, $delay = null)
    {
        $queue = Queue::getInstance();

        $jobData = $data ?: $this->data;
        $jobPriority = $priority ?: $this->priority;
        $jobQueue = $queueName ?: $this->queueName;
        $jobDelay = $delay ?: $this->delay;
        
        if ($jobDelay > 0) {
            // Nếu có delay, thêm vào queue với thời gian delay
            return $this->dispatchDelayed($jobData, $jobPriority, $jobQueue, $jobDelay);
        }
        
        return $queue->push(static::class, $jobData, $jobPriority, $jobQueue);
    }
    
    /**
     * Thêm job vào queue với delay
     */
    protected function dispatchDelayed($data, $priority, $queueName, $delay)
    {
        // Tạo job class mới để xử lý delay
        $delayedJobClass = DelayedJob::class;
        
        $delayedData = [
            'job_class' => static::class,
            'job_data' => $data,
            'priority' => $priority,
            'queue_name' => $queueName,
            'execute_at' => time() + $delay
        ];
        
        $queue = Queue::getInstance();
        return $queue->push($delayedJobClass, $delayedData, $priority, $queueName);
    }
    
    /**
     * Thêm job vào queue với độ ưu tiên cao
     */
    public function dispatchHigh($data = null, $queueName = null)
    {
        return $this->dispatch($data, \Core\Queue::PRIORITY_HIGH, $queueName);
    }
    
    /**
     * Thêm job vào queue với độ ưu tiên thấp
     */
    public function dispatchLow($data = null, $queueName = null)
    {
        return $this->dispatch($data, \Core\Queue::PRIORITY_LOW, $queueName);
    }
    
    /**
     * Thêm job vào queue với độ ưu tiên khẩn cấp
     */
    public function dispatchUrgent($data = null, $queueName = null)
    {
        return $this->dispatch($data, \Core\Queue::PRIORITY_URGENT, $queueName);
    }
    
    /**
     * Thêm job vào queue cụ thể
     */
    public function onQueue($queueName)
    {
        $this->queueName = $queueName;
        return $this;
    }
    
    /**
     * Thiết lập độ ưu tiên
     */
    public function priority($priority)
    {
        $this->priority = $priority;
        return $this;
    }
    
    /**
     * Thiết lập delay
     */
    public function delay($seconds)
    {
        $this->delay = $seconds;
        return $this;
    }
    
    /**
     * Thiết lập timeout
     */
    public function timeout($seconds)
    {
        $this->timeout = $seconds;
        return $this;
    }
    
    /**
     * Thiết lập số lần retry
     */
    public function retry($maxAttempts)
    {
        $this->maxAttempts = $maxAttempts;
        return $this;
    }
    
    /**
     * Xử lý khi job thất bại
     */
    public function failed($exception)
    {
        // Override method này trong class con để xử lý khi job thất bại
        error_log("Job failed: " . get_class($this) . " - " . $exception->getMessage());
    }
    
    /**
     * Xử lý trước khi job thực thi
     */
    public function before()
    {
        // Override method này trong class con để xử lý trước khi job thực thi
    }
    
    /**
     * Xử lý sau khi job hoàn thành
     */
    public function after()
    {
        // Override method này trong class con để xử lý sau khi job hoàn thành
    }
    
    /**
     * Kiểm tra xem job có nên thực thi không
     */
    public function shouldRun()
    {
        // Override method này trong class con để kiểm tra điều kiện thực thi
        return true;
    }
    
    /**
     * Lấy dữ liệu job
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * Thiết lập dữ liệu job
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
    
    /**
     * Lấy job ID
     */
    public function getJobId()
    {
        return $this->jobId;
    }
    
    /**
     * Thiết lập job ID
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
        return $this;
    }
    
    /**
     * Lấy số lần retry hiện tại
     */
    public function getAttempts()
    {
        return $this->attempts;
    }
    
    /**
     * Thiết lập số lần retry hiện tại
     */
    public function setAttempts($attempts)
    {
        $this->attempts = $attempts;
        return $this;
    }
    
    /**
     * Lấy số lần retry tối đa
     */
    public function getMaxAttempts()
    {
        return $this->maxAttempts;
    }
    
    /**
     * Lấy độ ưu tiên
     */
    public function getPriority()
    {
        return $this->priority;
    }
    
    /**
     * Lấy tên queue
     */
    public function getQueueName()
    {
        return $this->queueName;
    }
    
    /**
     * Lấy delay
     */
    public function getDelay()
    {
        return $this->delay;
    }
    
    /**
     * Lấy timeout
     */
    public function getTimeout()
    {
        return $this->timeout;
    }
}

/**
 * Job class để xử lý delayed jobs
 */
class DelayedJob extends Job
{
    public function handle($data)
    {
        $jobClass = $data['job_class'];
        $jobData = $data['job_data'];
        $priority = $data['priority'];
        $queueName = $data['queue_name'];
        $executeAt = $data['execute_at'];
        
        // Kiểm tra xem đã đến lúc thực thi chưa
        if (time() < $executeAt) {
            // Chưa đến lúc, đưa job về queue
            $queue = Queue::getInstance();
            $queue->push($jobClass, $jobData, $priority, $queueName);
            return false;
        }
        
        // Đã đến lúc, thực thi job
        if (class_exists($jobClass)) {
            $jobInstance = new $jobClass($jobData);
            
            if (method_exists($jobInstance, 'handle')) {
                return $jobInstance->handle($jobData);
            }
        }
        
        return false;
    }
}
