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
    <style>
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        .sidebar-hidden {
            display: none;
        }
        .sidebar-visible {
            display: block;
        }
        @media (min-width: 1024px) {
            .lg\:sidebar-visible {
                display: block;
            }
            .lg\:sidebar-hidden {
                display: block;
            }
        }
        .w-70 {
            width: 18rem;
        }
        @media (max-width: 1023px) {
            #sidebar {
                position: fixed;
                top: 4rem;
                left: 0;
                height: calc(100vh - 4rem);
                z-index: 30;
                overflow-y: auto;
            }
            .sidebar-hidden {
                transform: translateX(-100%);
                display: block;
            }
            .sidebar-visible {
                transform: translateX(0);
                display: block;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
<?php \Core\Session::set('current_url', $_SERVER['REQUEST_URI']); ?>
    <!-- Header -->
    <?php require_once 'header.php'; ?>

    <!-- Main Container -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php if (isset($sidebar) && $sidebar) { ?>
            <?php require_once 'sidebar.php'; ?>
        <?php } ?>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto">
            <!-- Mobile Sidebar Toggle Button -->
            <?php if (isset($sidebar) && $sidebar) { ?>
                <div class="lg:hidden p-4">
                    <button id="sidebarToggle" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-bars mr-2"></i>
                        Menu
                    </button>
                </div>
            <?php } ?>

            <!-- Content -->
            <div class="">
                <?= $content ?>
            </div>
        </main>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <?php if (isset($sidebar) && $sidebar) { ?>
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden"></div>
    <?php } ?>

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
    <script src="<?=BASE_URL?>/Public/js/customer-layout.js"></script>

</body>
</html>