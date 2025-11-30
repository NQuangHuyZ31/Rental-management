<?php
namespace Queue;

use Core\Job;
use Core\SendMail;
use Helpers\Log;

class SendEmailResolvedReport extends Job {
    protected $priority = \Core\Queue::PRIORITY_HIGH;
    protected $queueName = 'emails-resolved-report';
    protected $maxAttempts = 3;
    protected $sendEmail;

    public function __construct($data = []) {
        parent::__construct($data);
        $this->sendEmail = new SendMail();
    }

    public function handle($data) {
        try {
            $to = $data['to'] ?? '';
			$customer = $data['customer'] ?? '';
			$message = $data['message'] ?? '';
            $actionMessage = $data['action'] ?? '';
            $resolvedAt = $data['resolved_at'] ?? '';
            $rentalPostDate = $data['rental_post_date'] ?? '';

            if (empty($to) || empty($customer) || empty($resolvedAt)) {
                throw new \Exception("Missing required email data");
            }
			
			$this->sendEmail->sendResolvedReport($to, $customer, $actionMessage, $resolvedAt, $message, $rentalPostDate);
            
        } catch (\Throwable $th) {
            Log::queue("Failed to send resolved report email to {$data['to']}: {$th->getMessage()}");
            $this->failed($th);
            throw $th;
        }
    }
}
