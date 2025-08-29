<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOZIDO - Quản lý nhà cho thuê</title>
    
    <!-- Include Libraries -->
    <?php include 'layouts/app.php'; ?>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <?php include 'layouts/header.php'; ?>
    
    <!-- Navigation Menu -->
    <?php include 'layouts/nav.php'; ?>
    
    <!-- Main Content -->
    <main class="min-h-screen flex items-center bg-white pt-20">
        <div class="max-w-4xl mx-auto text-center px-4 -mt-80">
            <!-- Empty Houses Image -->
            <div class="mb-12">
                <img src="../../Public/images/admin/empty-houses.jpg" 
                     alt="Empty Houses" 
                     class="w-64 h-64 mx-auto object-cover">
            </div>
            
            <!-- Main Message -->
            <div class="mb-4 text-center -mt-4">
                <h1 class="text-2xl font-bold text-gray-800 leading-tight whitespace-nowrap">
                    Bạn chưa có tòa nhà cho thuê nào! Vui lòng thêm nhà trọ trước khi tiếp tục.
                </h1>
            </div>
            
            <!-- Secondary Message -->
            <div class="mb-6 text-center -mt-2">
                <p class="text-gray-600 text-lg leading-relaxed whitespace-nowrap">
                    Với thiết kết đơn giản - thân thiện - dễ sử dụng. Quản lý nhà trọ của bạn dễ hơn bao giờ hết.
                </p>
            </div>
            
            <!-- Action Button -->
            <div class="mt-6 text-center -mt-2">
                <button class="bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-102 flex items-center mx-auto">
                    <i class="fas fa-plus mr-3 text-lg"></i>
                    Tạo nhà trọ đầu tiên
                </button>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <?php include 'layouts/footer.php'; ?>
</body>
</html>
