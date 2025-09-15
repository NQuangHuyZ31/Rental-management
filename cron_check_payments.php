<?php
/**
 * Cron job để kiểm tra thanh toán tự động
 * Chạy mỗi 5 phút để kiểm tra tất cả thanh toán đang chờ
 */

// Load autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Load config
require_once __DIR__ . '/Config/config.php';

// Load classes
require_once __DIR__ . '/App/Controllers/Api/PaymentVerificationService.php';

use App\Controllers\Api\PaymentVerificationService;

try {
    echo "[" . date('Y-m-d H:i:s') . "] Bắt đầu kiểm tra thanh toán tự động...\n";
    
    $verificationService = new PaymentVerificationService();
    
    // Kiểm tra tất cả thanh toán đang chờ
    $results = $verificationService->checkAllPendingPayments();
    
    $completedCount = 0;
    $totalCount = count($results);
    
    foreach ($results as $result) {
        if ($result['result']['success']) {
            $completedCount++;
            echo "[" . date('Y-m-d H:i:s') . "] Thanh toán ID {$result['payment_id']} đã được xác nhận\n";
        }
    }
    
    echo "[" . date('Y-m-d H:i:s') . "] Hoàn thành kiểm tra: {$completedCount}/{$totalCount} thanh toán được xác nhận\n";
    
    // Lấy thống kê
    $stats = $verificationService->getPaymentStats();
    echo "[" . date('Y-m-d H:i:s') . "] Thống kê: {$stats['total_pending']} đang chờ, {$stats['total_completed_today']} hoàn thành hôm nay\n";
    
} catch (Exception $e) {
    echo "[" . date('Y-m-d H:i:s') . "] Lỗi: " . $e->getMessage() . "\n";
    error_log("Cron job error: " . $e->getMessage());
}
