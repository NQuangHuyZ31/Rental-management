<!-- 
Author: Nguyen Xuan Duong
Date: 2025-08-29
Purpose: Libraries and Dependencies for Landlord Layout
-->

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</style>

<script>
    // Configure Toastr
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    // Configure SweetAlert
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Function to show success message
    function showSuccessMessage(message) {
        Toast.fire({
            icon: 'success',
            title: message
        });
    }

    // Function to show error message
    function showErrorMessage(message) {
        Toast.fire({
            icon: 'error',
            title: message
        });
    }

    // Function to show warning message
    function showWarningMessage(message) {
        Toast.fire({
            icon: 'warning',
            title: message
        });
    }

    // Function to show info message
    function showInfoMessage(message) {
        Toast.fire({
            icon: 'info',
            title: message
        });
    }

    // Check for flash messages on page load
    document.addEventListener('DOMContentLoaded', function() {
        <?php
        $request = new \Core\Request();
        $successMessage = $request->getFlashData('success');
        $errorMessage = $request->getFlashData('error');
        ?>
        
        <?php if ($successMessage): ?>
            showSuccessMessage('<?= addslashes($successMessage) ?>');
        <?php endif; ?>
        
        <?php if ($errorMessage): ?>
            showErrorMessage('<?= addslashes($errorMessage) ?>');
        <?php endif; ?>
    });
</script>
