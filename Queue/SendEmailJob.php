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
    protected $sendEmail;
    
    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->sendEmail = new SendMail();
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

            $this->sendEmail->sendOTP($to, 'Huy Nguyen','333333', $message);
            
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
        Log::queue(["Preparing to send email to: " . json_encode($this->data)]);
    }
    
    public function after()
    {
        Log::queue(["Email job completed successfully: " . json_encode($this->data)]);
    }
    
    public function failed($exception)
    {
        Log::queue(["Email job failed: " . $exception->getMessage() . " " . json_encode($this->data)]);
    }
}
