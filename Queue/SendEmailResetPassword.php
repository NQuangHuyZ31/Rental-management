<?php

/*

 * Author: Huy Nguyen
 * Date: 2025-09-01
 * Purpose: Send email reset password
 */

namespace Queue;

use Core\Job;
use Core\SendMail;
use Helpers\Log;

class SendEmailResetPassword extends Job {
    protected $priority = \Core\Queue::PRIORITY_HIGH;
    protected $queueName = 'emails-reset-password';
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
			$resetUrl = $data['resetUrl'] ?? '';

			if (empty($to) || empty($customer) || empty($resetUrl)) {
				throw new \Exception("Missing required email data");
			}

			$this->sendEmail->sendPasswordReset($to, $customer, $resetUrl);
		} catch (\Throwable $th) {
			Log::queue("Failed to send reset password email to {$data['email']}: {$th->getMessage()}");
			$this->failed($th);
			throw $th;
		}
	}
}
