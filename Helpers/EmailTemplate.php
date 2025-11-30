<?php

/*
    Author: Huy Nguyen
    Date: 2025-09-01
    Purpose: Email template helper
*/

namespace Helpers;

class EmailTemplate
{
    /**
     * Render email template với các biến được truyền vào
     */
    public static function render($template, $data = [])
    {
        // Extract variables to make them available in template
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include template file
        $templatePath =  __DIR__ . '/../views/emails/' . $template . '.php';
        if (file_exists($templatePath)) {
            include $templatePath;
        } else {
            throw new \Exception("Email template not found: {$template}");
        }
        
        // Get content and clean buffer
        $content = ob_get_clean();
        
        return $content;
    }
    
    /**
     * Render OTP email template
     */
    public static function renderOTP($customer, $otpCode, $purpose = 'Xác minh tài khoản')
    {
        return self::render('otp', [
            'customer' => $customer,
            'otpCode' => $otpCode,
            'purpose' => $purpose
        ]);
    }
    
    /**
     * Render welcome email template
     */
    public static function renderWelcome($customer, $loginUrl)
    {
        return self::render('welcome', [
            'customer' => $customer,
            'loginUrl' => $loginUrl
        ]);
    }
    
    /**
     * Render appointment email template
     */
    public static function renderAppointment($customer, $houseName, $houseAddress, $housePrice, $appointmentDate, $appointmentTime, $appointmentUrl, $notes = null)
    {
        return self::render('appointment', [
            'customer' => $customer,
            'houseName' => $houseName,
            'houseAddress' => $houseAddress,
            'housePrice' => $housePrice,
            'appointmentDate' => $appointmentDate,
            'appointmentTime' => $appointmentTime,
            'appointmentUrl' => $appointmentUrl,
            'notes' => $notes
        ]);
    }
    
    /**
     * Render password reset email template
     */
    public static function renderPasswordReset($customer, $resetUrl)
    {
        return self::render('password-reset', [
            'customer' => $customer,
            'resetUrl' => $resetUrl
        ]);
    }
    
    /**
     * Render notification email template
     */
    public static function renderNotification($data)
    {
        return self::render('notification', $data);
    }
    
    /**
     * Render custom email template
     */
    public static function renderCustom($template, $data = [])
    {
        return self::render($template, $data);
    }

    // Render active account email template
    public static function renderActiveAccount($customer, $resetUrl)
    {
        return self::render('active-account', [
            'customer' => $customer,
            'resetUrl' => $resetUrl
        ]);
    }

    public static function renderResolvedReport($customer, $actionMessage, $resolvedAt, $message = '', $rentalPostDate = '')
    {
        return self::render('resolved-report', [
            'customer' => $customer,
            'actionMessage' => $actionMessage,
            'resolvedAt' => $resolvedAt,
            'message' => $message,
            'rentalPostDate' => $rentalPostDate
        ]);
    }
}
