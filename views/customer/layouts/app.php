<!--
    Author: Huy Nguyen
    Date: 2025-08-31
    Purpose: Default layout for customer
-->
<?php

use Core\Request;

$request = new Request();
$flashData = $request->getFlashData();
$success = $flashData['success'] ?? '';
$error = $flashData['errors'] ?? '';
$status = '';
if ($success) {
    $status = 'success';
}

if ($error) {
    $status = 'error';
}

?>
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
    <!-- Empty States CSS -->
    <link rel="stylesheet" href="<?=BASE_URL?>/Public/css/empty-states.css">
    <!-- Pagination CSS -->
    <link rel="stylesheet" href="<?=BASE_URL?>/Public/css/pagination.css">
    <!-- Fix Scrollbar CSS -->
    <link rel="stylesheet" href="<?=BASE_URL?>/Public/css/fix-scrollbar.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Payment Modal CSS -->
    <link rel="stylesheet" href="<?=BASE_URL?>/Public/css/payment-modal.css">
    <!-- Bootstrap Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-50 h-screen">
    <?php \Core\Session::set('current_url', $_SERVER['REQUEST_URI']); ?>

    <!-- Header -->
    <?php require_once 'header.php'; ?>

    <!-- Main Container -->
    <div class="<?php echo isset($sidebar) && $sidebar ? 'main-content-wrapper' : 'main-content-wrapper-full'; ?>">
        <div class="flex h-full overflow-hidden">
            <!-- Sidebar -->
            <?php if (isset($sidebar) && $sidebar) {?>
                <?php require_once 'sidebar.php'; ?>
            <?php }?>

            <!-- Main Content Area -->
            <main class="flex-1">
                <!-- Mobile Sidebar Toggle Button -->
                <?php if (isset($sidebar) && $sidebar) {?>
                    <div class="lg:hidden p-4">
                        <button id="sidebarToggle" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-bars mr-2"></i>
                            Menu
                        </button>
                    </div>
                <?php }?>

                <!-- Content -->
                <div class="h-full <?php echo isset($sidebar) && $sidebar ? 'content-area' : ''; ?>">
                    <?=$content?>
                </div>
            </main>
        </div>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <?php if (isset($sidebar) && $sidebar) {?>
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden"></div>
    <?php }?>

    <!-- Footer -->
    <?php require_once 'footer.php'; ?>

    <!-- Library js -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <script src="<?=BASE_URL?>/Public/js/lazysizes.min.js"></script>
    <script src="<?=BASE_URL?>/Public/js/lity.min.js"></script>
    <script src="<?=BASE_URL?>/Public/js/app.js"></script>
    <script src="<?=BASE_URL?>/Public/js/auth.js"></script>
    <script src="<?=BASE_URL?>/Public/js/index.js"></script>
    <script src="<?=BASE_URL?>/Public/js/customer-layout.js"></script>
    <script src="<?=BASE_URL?>/Public/js/profile.js"></script>
    <script src="<?=BASE_URL?>/Public/js/customer-profile.js"></script>
    <script src="<?=BASE_URL?>/Public/js/payment.js"></script>
    <script src="<?=BASE_URL?>/Public/js/fix-scrollbar.js"></script>
    <script src="<?=BASE_URL?>/Public/js/post-detail.js"></script>
    <script src="<?=BASE_URL?>/Public/js/post-interest.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let error = "<?=$error?>" ?? '';
            let success = "<?=$success?>" ?? '';
            let status = "<?=$status?>" ?? '';
            if (status === 'error') {
                showErrorMessage(error);
                error = '';
            }
            if (status === 'success') {
                showSuccessMessage(success);
                success = '';
            }
        });
    </script>

</body>

</html>