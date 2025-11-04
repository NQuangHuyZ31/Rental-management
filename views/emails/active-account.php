<!-- 
    Author: Huy Nguyen
    Date: 2025-11-04
    Purpose: Build Active Account from link 		email template
-->

<?php
$title = 'Kích hoạt tài khoản - HOSTY';
$headerTitle = '✅ Kích hoạt tài khoản';
$headerSubtitle = 'Hệ thống quản lý cho thuê nhà HOSTY';
$greeting = 'Xin chào <strong>' . htmlspecialchars($customer) . '</strong>! 👋';

$content = '
<div class="info">
    <p>📧 <strong>Bạn đã yêu cầu kích hoạt tài khoản HOSTY của mình.</strong></p>
    <p>🕐 <strong>Thời gian yêu cầu:</strong> ' . date('d/m/Y H:i:s') . '</p>
</div>

<div class="highlight">
    <h2>🔐 Yêu cầu kích hoạt tài khoản</h2>
    <p>Chúng tôi đã nhận được yêu cầu kích hoạt tài khoản cho tài khoản của bạn</p>
</div>

<div class="main-content">
    <h3>🔄 Hướng dẫn kích hoạt tài khoản</h3>
    <p>Để kích hoạt tài khoản, vui lòng nhấp vào nút bên dưới.</p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="' . $resetUrl . '" class="button" style="color: black !important;">🔑 Kích hoạt tài khoản</a>
    </div>
    
    <p><strong>Hoặc sao chép và dán liên kết này vào trình duyệt:</strong></p>
    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; word-break: break-all; font-family: monospace; font-size: 12px; color: #666; margin: 15px 0;">
        ' . $resetUrl . '
    </div>
</div>

<div class="warning">
    <h3>⚠️ Lưu ý quan trọng</h3>
    <p>• Nếu bạn không yêu cầu kích hoạt tài khoản, hãy bỏ qua email này</p>
    <p>• Mật khẩu mới phải có ít nhất 8 ký tự</p>
    <p>• Không chia sẻ liên kết này với bất kỳ ai</p>
</div>

<div class="success">
    <h3>🛡️ Bảo mật tài khoản</h3>
    <p>• Nếu bạn nghi ngờ có hoạt động bất thường, hãy liên hệ với chúng tôi ngay lập tức</p>
    <p>• Luôn đăng xuất khỏi các thiết bị công cộng</p>
    <p>• Sử dụng mật khẩu mạnh và duy nhất</p>
</div>

<div class="info">
    <p>📱 <strong>Hỗ trợ:</strong> Nếu gặp vấn đề, vui lòng liên hệ qua email: support@hosty.com</p>
</div>';

include_once VIEW_PATH . 'emails/layout.php';
?>
