<?php

namespace Queue;

use Core\Job;
use Core\SendMail;
use Helpers\Log;

class SendEmailJob extends Job
{
    protected $priority = \Core\Queue::PRIORITY_HIGH;
    protected $queueName = 'emails';
    protected $maxAttempts = 3;
    
    public function __construct($data = [])
    {
        parent::__construct($data);
    }
    
    public function handle($data)
    {
        // Xử lý trước khi thực thi
        $this->before();
        
        try {
            // Giả lập gửi email
            $to = $data['to'] ?? '';
            $subject = $data['subject'] ?? '';
            $message = $data['message'] ?? '';
            
            if (empty($to) || empty($subject) || empty($message)) {
                throw new \Exception("Missing required email data");
            }

            SendMail::sendOTP($to, 'Huy Nguyen','333333', $message);
            
            // Xử lý sau khi hoàn thành
            $this->after();
            
        } catch (\Exception $e) {
            // Xử lý khi job thất bại
            $this->failed($e);
            throw $e;
        }
    }
    
    public function before()
    {
        Log::server(["Preparing to send email to: " . ($this->data['to'] ?? 'unknown')]);
    }
    
    public function after()
    {
        Log::server(["Email job completed successfully"]);
    }
    
    public function failed($exception)
    {
        Log::server(["Email job failed: " . $exception->getMessage()]);
    }
}
