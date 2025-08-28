<!-- Libraries and Dependencies -->
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
</script>
