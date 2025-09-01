<!-- 
    Author: Huy Nguyen
    Date: 2025-09-01
    Purpose: Build OTP email
-->

<?php
$title = 'Mã xác minh OTP';
$headerTitle = '🔐 Xác minh tài khoản';
$headerSubtitle = 'Hệ thống quản lý cho thuê nhà - HOSTY';
$greeting = 'Xin chào <strong>' . htmlspecialchars($customer) . '</strong>! 👋';

$content = '
<div class="highlight" style="color: black !important;">
    <h2>Mã xác minh của bạn</h2>
    <p style="font-size: 48px; font-weight: 700; letter-spacing: 8px; font-family: \'Courier New\', monospace; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);">' . $otpCode . '</p>
</div>

<div class="main-content">
    <h3>📋 Thông tin xác minh</h3>
    <p><strong>Mục đích:</strong> ' . htmlspecialchars($purpose) . '</p>
    <p><strong>Thời gian hiệu lực:</strong> <span class="timer">5 phút</span></p>
    <p><strong>Lưu ý:</strong> Mã này chỉ có hiệu lực một lần và sẽ tự động hết hạn sau 5 phút.</p>
</div>

<div class="warning">
    <p>⚠️ <strong>Bảo mật:</strong> Không chia sẻ mã này với bất kỳ ai, kể cả nhân viên hỗ trợ. Chúng tôi sẽ không bao giờ yêu cầu mã OTP qua điện thoại hoặc email.</p>
</div>';

include 'views/emails/layout.php';
?>
