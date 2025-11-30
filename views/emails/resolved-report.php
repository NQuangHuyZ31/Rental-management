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
    <p>📧 <strong>Chúng tôi xin thông báo rằng báo cáo vi phạm liên quan đến bài đăng của bạn đăng ngày ' . htmlspecialchars($rentalPostDate) . ' 
            đã được đội ngũ Hosty xem xét và xử lý theo đúng chính sách cộng đồng.</strong></p>
</div>

<div class="main-content">
     <p>
        <strong>Hành động đã thực hiện:</strong>  
            ' . htmlspecialchars($actionMessage) . ';
          </p>

          <p>
            <strong>Thời gian xử lý:</strong>  
            ' . htmlspecialchars($resolvedAt) . ';
          </p>
</div>
<div class="warning">
	<h3>⚠️ Lưu ý quan trọng</h3>
	<p>• Nếu bạn cần thêm thông tin hoặc muốn khiếu nại quyết định này, vui lòng phản hồi lại email này
		hoặc liên hệ bộ phận hỗ trợ thông qua trang quản trị Hosty <strong style="color: red;font-weight: bold;font-size: 16px;">trước thời gian xử lý</strong>.</p>
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