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
            $to = isset($data['to']) ? $data['to'] : '';
			$customer = isset($data['customer']) ? $data['customer'] : '';
			$message = isset($data['message']) ? $data['message'] : '';
            $actionMessage = isset($data['action']) ? $data['action'] : '';
            $resolvedAt = isset($data['resolved_at']) ? $data['resolved_at'] : '';
            $rentalPostDate = isset($data['rental_post_date']) ? $data['rental_post_date'] : '';
            $type = isset($data['type']) ? $data['type'] : '';
            $supportAt = isset($data['support_at']) ? $data['support_at'] : '';
            $description = isset($data['description']) ? $data['description'] : '';

            if (empty($to) || empty($customer) || empty($resolvedAt)) {
                throw new \Exception("Missing required email data");
            }
			
			if ($type === 'support') {
                $this->sendEmail->sendResolvedSupportReport($to, $customer, $supportAt, $message, $description);
            } else {
                $this->sendEmail->sendResolvedReport($to, $customer, $actionMessage, $resolvedAt, $message, $rentalPostDate);
            }
            
        } catch (\Throwable $th) {
            Log::queue("Failed to send resolved report email to {$data['to']}: {$th->getMessage()}");
            $this->failed($th);
            throw $th;
        }
    }
}
