<!-- 
    Author: Huy Nguyen
    Date: 2025-09-01
    Purpose: Build Password Reset email
-->

<?php
$title = 'Đặt lại mật khẩu';
$headerTitle = '🔑 Đặt lại mật khẩu';
$headerSubtitle = 'Hệ thống quản lý cho thuê nhà';
$greeting = 'Xin chào <strong>' . htmlspecialchars($customer) . '</strong>! 👋';

$content = '
<div class="info">
    <p>📧 <strong>Bạn đã yêu cầu đặt lại mật khẩu cho tài khoản của mình.</strong></p>
</div>

<div class="main-content">
    <h3>🔄 Hướng dẫn đặt lại mật khẩu</h3>
    <p>Để đặt lại mật khẩu, vui lòng nhấp vào nút bên dưới. Liên kết này sẽ có hiệu lực trong 30 phút.</p>
    
    <h3>⚠️ Lưu ý quan trọng</h3>
    <p>• Liên kết chỉ có hiệu lực trong 30 phút</p>
    <p>• Nếu bạn không yêu cầu đặt lại mật khẩu, hãy bỏ qua email này</p>
    <p>• Mật khẩu mới phải có ít nhất 8 ký tự</p>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="' . $resetUrl . '" class="button">Đặt lại mật khẩu</a>
</div>

<div class="warning">
    <p>🔒 <strong>Bảo mật:</strong> Không chia sẻ liên kết này với bất kỳ ai. Nếu bạn nghi ngờ có hoạt động bất thường, hãy liên hệ với chúng tôi ngay lập tức.</p>
</div>

<div class="info">
    <p>⏰ <strong>Thời gian hiệu lực:</strong> <span class="timer">30 phút</span></p>
</div>';

include 'views/emails/layout.php';
?>
