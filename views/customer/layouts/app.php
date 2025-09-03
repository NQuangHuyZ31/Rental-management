<!-- 
    Author: Huy Nguyen
    Date: 2025-08-31
    Purpose: Default layout for customer
-->

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=isset($title) ? 'HOSTY - ' . htmlspecialchars($title) : 'HOSTY'?></title>
    <link rel="icon" href="<?=BASE_URL?>/Public/images/favicon.ico">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Toastr -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
<?php \Core\Session::set('current_url', $_SERVER['REQUEST_URI']); ?>
    <!-- Header -->
    <?php require_once 'header.php'; ?>
    <!-- Main Content -->
    <main class="flex-1">
        <?= $content ?>
    </main>
    <!-- Footer -->
    <?php require_once 'footer.php'; ?>
    
    <!-- Library js -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js" ></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
    <script src="<?=BASE_URL?>/Public/js/lazysizes.min.js"></script>
    <script src="<?=BASE_URL?>/Public/js/lity.min.js"></script>
    <script src="<?=BASE_URL?>/Public/js/app.js"></script>
    <script src="<?=BASE_URL?>/Public/js/auth.js"></script>
    <script src="<?=BASE_URL?>/Public/js/index.js"></script>
</body>
</html>
