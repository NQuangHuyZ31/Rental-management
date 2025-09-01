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
</body>
</html>
