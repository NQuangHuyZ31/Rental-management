<!-- 
    Author: Huy Nguyen
    Date: 2025-09-01
    Purpose: Build Appointment email
-->

<?php
$title = 'Thông báo đặt lịch xem nhà';
$headerTitle = '📅 Đặt lịch xem nhà';
$headerSubtitle = 'Hệ thống quản lý cho thuê nhà';
$greeting = 'Xin chào <strong>' . htmlspecialchars($customer) . '</strong>! 👋';

$content = '
<div class="success">
    <p>✅ <strong>Yêu cầu đặt lịch xem nhà của bạn đã được gửi thành công!</strong></p>
</div>

<div class="main-content">
    <h3>🏠 Thông tin nhà</h3>
    <p><strong>Tên nhà:</strong> ' . htmlspecialchars($houseName) . '</p>
    <p><strong>Địa chỉ:</strong> ' . htmlspecialchars($houseAddress) . '</p>
    <p><strong>Giá thuê:</strong> ' . number_format($housePrice) . ' VNĐ/tháng</p>
    
    <h3>📅 Thông tin lịch hẹn</h3>
    <p><strong>Ngày xem:</strong> ' . date('d/m/Y', strtotime($appointmentDate)) . '</p>
    <p><strong>Giờ xem:</strong> ' . date('H:i', strtotime($appointmentTime)) . '</p>
    <p><strong>Ghi chú:</strong> ' . htmlspecialchars($notes ?? 'Không có') . '</p>
</div>

<div class="info">
    <p>📞 <strong>Liên hệ:</strong> Chủ nhà sẽ liên hệ với bạn trong vòng 24 giờ để xác nhận lịch hẹn.</p>
</div>

<div class="warning">
    <p>⚠️ <strong>Lưu ý:</strong> Vui lòng đến đúng giờ hẹn. Nếu có thay đổi, hãy liên hệ với chủ nhà ít nhất 2 giờ trước.</p>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="' . $appointmentUrl . '" class="button">Xem chi tiết lịch hẹn</a>
</div>';

include_once VIEW_PATH . 'emails/layout.php';
?>
