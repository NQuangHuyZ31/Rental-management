<!-- 
    Author: Huy Nguyen
    Date: 2025-09-01
    Purpose: Build Notification email
-->

<?php
$title = $emailTitle ?? 'Thông báo từ hệ thống';
$headerTitle = $headerTitle ?? '📢 Thông báo';
$headerSubtitle = $headerSubtitle ?? 'Hệ thống quản lý cho thuê nhà';
$greeting = isset($customer) ? 'Xin chào <strong>' . htmlspecialchars($customer) . '</strong>! 👋' : '';

$content = '
<div class="main-content">
    <h3>' . htmlspecialchars($notificationTitle ?? 'Thông báo') . '</h3>
    <p>' . nl2br(htmlspecialchars($notificationMessage ?? '')) . '</p>
</div>';

if (isset($additionalInfo) && !empty($additionalInfo)) {
    $content .= '
    <div class="info">
        <h3>📋 Thông tin bổ sung</h3>';
    foreach ($additionalInfo as $key => $value) {
        $content .= '<p><strong>' . htmlspecialchars($key) . ':</strong> ' . htmlspecialchars($value) . '</p>';
    }
    $content .= '</div>';
}

if (isset($actionUrl) && isset($actionText)) {
    $content .= '
    <div style="text-align: center; margin: 30px 0;">
        <a href="' . $actionUrl . '" class="button">' . htmlspecialchars($actionText) . '</a>
    </div>';
}

if (isset($warningMessage)) {
    $content .= '
    <div class="warning">
        <p>⚠️ ' . htmlspecialchars($warningMessage) . '</p>
    </div>';
}

if (isset($successMessage)) {
    $content .= '
    <div class="success">
        <p>✅ ' . htmlspecialchars($successMessage) . '</p>
    </div>';
}

include 'views/emails/layout.php';
?>
