<!-- 
    Author: Huy Nguyen
    Date: 2025-09-09
    Purpose: Layout for admin
-->

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? 'HOSTY Admin - ' . htmlspecialchars($title) : 'HOSTY Admin Dashboard' ?></title>
    <link rel="icon" href="<?= BASE_URL ?>/Public/images/favicon.ico">
    <link rel="stylesheet" href="<?= BASE_URL ?>/Public/css/app.css?v=<?= rand()?>"></link>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?= BASE_URL ?>/Public/css/flowbite.min.css?v=<?= rand()?>" rel="stylesheet" />
    <!-- Custom CSS -->
    <style>
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }

        .sidebar-visible {
            transform: translateX(0);
        }

        /* Desktop: Sidebar always visible */
        @media (min-width: 1024px) {
            #sidebar {
                transform: translateX(0) !important;
                position: static !important;
            }
        }

        /* Mobile: Sidebar hidden by default */
        @media (max-width: 1023px) {
            #sidebar {
                position: fixed;
                z-index: 50;
                transform: translateX(-100%);
            }

            #sidebar.sidebar-visible {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <?php \Core\Session::set('current_url', $_SERVER['REQUEST_URI']); ?>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php require_once 'sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <?php require_once 'header.php'; ?>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <?= $content ?>
            </main>

            <!-- Footer -->
            <?php require_once 'footer.php'; ?>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.toggle('sidebar-hidden');
            sidebar.classList.toggle('sidebar-visible');
            overlay.classList.toggle('hidden');
        }

        // Close sidebar when clicking overlay
        document.getElementById('sidebar-overlay').addEventListener('click', toggleSidebar);

        // Auto-hide alerts (for any legacy .alert-auto-hide elements)
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-auto-hide');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1/dist/cleave.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <script src="<?= BASE_URL ?>/Public/js/app.js"></script>
    <script src="<?= BASE_URL ?>/Public/js/index.js"></script>
    <script src="<?= BASE_URL ?>/Public/js/custom-chart.js"></script>
    <script src="<?= BASE_URL ?>/Public/js/posts.js"></script>

    <script>
        // Use App.showSuccessMessage for notifications (centralized in Public/js/app.js)
        // Check for flash messages on page load and forward to App.showSuccessMessage
        <?php
        $request = new \Core\Request();
        $flashData = $request->getFlashData();
        $successMessage = $flashData['success'] ?? null;
        $errorMessage = $flashData['error'] ?? null;
        ?>

        <?php if ($successMessage): ?>
            if (window.App && typeof window.App.showSuccessMessage === 'function') {
                App.showSuccessMessage('<?= addslashes($successMessage) ?>', 'success');
            } else {
                // fallback to simple alert if App not ready
                console.log('Flash:', '<?= addslashes($successMessage) ?>');
            }
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            if (window.App && typeof window.App.showSuccessMessage === 'function') {
                App.showSuccessMessage('<?= addslashes($errorMessage) ?>', 'error');
            } else {
                console.error('Flash:', '<?= addslashes($errorMessage) ?>');
            }
        <?php endif; ?>
    </script>
</body>

</html>