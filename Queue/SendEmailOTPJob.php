<?php

/*
	Author: Huy Nguyen
	Date: 2025-09-01
	Purpose: Send OTP email
*/

namespace Queue;

use Core\Job;
use Core\SendMail;
use Helpers\Hash;
use Helpers\Log;

class SendEmailOTPJob extends Job
{
    protected $priority = \Core\Queue::PRIORITY_HIGH;
    protected $queueName = 'emails-otp';
    protected $maxAttempts = 3;
    protected $sendEmail;
    
    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->sendEmail = new SendMail();
    }
    
    public function handle($data)
    {
        $this->before();

        try {
            Log::queue(["START JOB", $data]);

            $to = $data['to'] ?? '';
            $customer = $data['customer'] ?? '';
            $otpCode = $data['otpCode'] ?? '';
            $purpose = $data['purpose'] ?? '';


            $otpCodeDecoded = Hash::decrypt($otpCode) ?? '';


            if (empty($to) || empty($customer) || empty($otpCodeDecoded) || empty($purpose)) {
                throw new \Exception("Missing required email data");
            }


            try {
                $this->sendEmail->sendOTP($to, $customer, $otpCodeDecoded, $purpose);
            } catch (\Exception $e) {
                echo 'failed'. $e->getMessage();
            }


            $this->after();

        } catch (\Exception $e) {
            Log::queue(["ERROR", $e->getMessage()]);
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
