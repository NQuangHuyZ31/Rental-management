<!-- 
Author: Nguyen Xuan Duong
Date: 2025-08-29
Purpose: Libraries and Dependencies for Landlord Layout
-->

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="<?= BASE_URL ?>/Public/css/app.css">
<link rel="icon" href="<?= BASE_URL ?>/Public/images/favicon.ico">

<?php \Core\Session::set('current_url', $_SERVER['REQUEST_URI']); ?>
<?= \Core\CSRF::getTokenMeta() ?>
<!-- Custom Tailwind Config -->
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'lozido-green': '#15A05C',
                    'lozido-orange': '#ff6b35'
                }
            }
        }
    }
</script>

<style>
    /* Custom styles for better appearance */
    .nav-item {
        transition: all 0.3s ease;
    }

    .nav-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: #ff6b35;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }

    /* SweetAlert2 Layout Fix */
    .swal2-container {
        z-index: 9999 !important;
    }

    .swal2-html-container {
        overflow: visible !important;
    }

    /* Modal Layout Fix - Chỉ sửa để không vỡ layout */
    .modal-container {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        background-color: rgba(0, 0, 0, 0.5) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 1rem !important;
        z-index: 9999 !important;
    }

    .modal-container.hidden {
        display: none !important;
    }

    .modal-content {
        background: white !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        max-height: 90vh !important;
        overflow-y: auto !important;
        width: 100% !important;
        max-width: 32rem !important;
    }

    .modal-content.large {
        max-width: 48rem !important;
    }

    .modal-content.extra-large {
        max-width: 80vw !important;
        width: 80vw !important;
    }

    /* Đảm bảo modal content không làm vỡ layout */
    .modal-content * {
        box-sizing: border-box !important;
    }
</style>

<script>
    // Forward flash messages to window.showSuccessMessage and window.showErrorMessage (defined in Public/js/app.js)
    document.addEventListener('DOMContentLoaded', function() {
        // Wait a bit longer to ensure app.js functions are loaded
        setTimeout(function() {
            <?php
            $request = new \Core\Request();
            $flashData = $request->getFlashData();
            $successMessage = $flashData['success'] ?? null;
            $errorMessage = $flashData['error'] ?? null;
            ?>

            <?php if ($successMessage): ?>
                if (typeof window.showSuccessMessage === 'function') {
                    window.showSuccessMessage('<?= addslashes($successMessage) ?>');
                } else {
                    // Fallback if function not available
                    console.log('showSuccessMessage not available, using alert');
                    alert('<?= addslashes($successMessage) ?>');
                }
            <?php endif; ?>

            <?php if ($errorMessage): ?>
                if (typeof window.showErrorMessage === 'function') {
                    window.showErrorMessage('<?= addslashes($errorMessage) ?>');
                } else {
                    // Fallback if function not available
                    console.log('showErrorMessage not available, using alert');
                    alert('<?= addslashes($errorMessage) ?>');
                }
            <?php endif; ?>
        }, 100); // Wait 100ms for app.js to fully load
    });
</script>