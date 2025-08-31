<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ?'HOSTY - ' . htmlspecialchars($title) : 'HOSTY' ?></title>
    <link rel="icon" href="<?= BASE_URL ?>/Public/images/favicon.ico">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/Public/css/output.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <?= require_once 'header.php' ?>
    <!-- Main Content -->
    <main class="flex-1">
        <?= require_once $content ?>
    </main>
    <!-- Footer -->
    <?= require_once 'footer.php' ?>
</body>
</html>
