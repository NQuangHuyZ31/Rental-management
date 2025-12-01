<!-- 
    Author: Huy Nguyen
    Date: 2025-01-01
    Purpose: Build Password Reset email template
-->

<?php
$title = 'Thông báo xử lý báo cáo vi phạm – Hosty';
$headerTitle = 'Thông báo từ Hosty';
$greeting = 'Xin chào <strong>' . htmlspecialchars($customer) . '</strong>! 👋';

$content = '
<div class="info">
    <p>Cảm ơn Anh/Chị đã liên hệ với Hosty. Chúng tôi đã nhận được vấn đề của bạn cần hỗ trợ vào ngày ' . htmlspecialchars($supportAt) . ' về vấn đề <strong>' . htmlspecialchars($description) . '</strong></p><br>
</div>

<div class="main-content">
    <p>
		' . nl2br(htmlspecialchars($message)) . '
     </p>
</div>

<div class="success">
	<h3>🛡️ Cảm ơn bạn đã sử dụng Hosty!</h3>
	<p>• Chúng tôi cam kết duy trì một cộng đồng an toàn và lành mạnh cho tất cả người dùng.</p>
</div>

<div class="info">
    <p>📱 <strong>Hỗ trợ:</strong> Nếu gặp vấn đề, vui lòng liên hệ qua email: support@hosty.com</p>
</div>';

include_once VIEW_PATH . 'emails/layout.php';
?>