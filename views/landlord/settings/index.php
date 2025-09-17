<!-- 
	Author: Huy Nguyen
	Date: 2025-09-17
	Purpose: Build Setting Index
-->
<?php 

// use Core\Session;
// $flashData = Session::get('flash_data');
// $message = $flashData['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>HOSTY - Cài đặt</title>
	<!-- Include Libraries -->
	<?php

	include VIEW_PATH . '/landlord/layouts/app.php'; ?>
</head>

<body class="bg-gray-100">
	<!-- Header -->
	<?php include VIEW_PATH . '/landlord/layouts/header.php'; ?>
	
    <!-- Main Content -->
    <main class="min-h-screen bg-gray-100 w-full">
        <div class="bg-white min-h-screen">
            <div class="max-w-full mx-auto">
                <div class="flex gap-8 min-h-screen">
                    <!-- Left Column: Settings Sidebar -->
                    <div class="w-auto">
                        <div class="sticky top-6 h-fit">
                            <?php include VIEW_PATH . '/landlord/layouts/setting-sidebar.php'; ?>
                        </div>
                    </div>
                    
                    <!-- Right Column: Settings Content -->
                    <div class="flex-1 pt-6">
                        <div class="min-h-full">
                            <?= $content ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

	<!-- Footer -->
	<?php include VIEW_PATH . '/landlord/layouts/footer.php'; ?>

	<!-- Include posts.js -->
	<script src="<?= BASE_URL ?>/Public/js/posts.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
	<script src="<?= BASE_URL ?>/Public/js/setting-landlord-ui.js"></script>
</body>
</html>