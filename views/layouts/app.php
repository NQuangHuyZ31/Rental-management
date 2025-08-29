<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : 'LOZIDO' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'lozido-green': '#10B981',
                        'lozido-orange': '#F59E0B',
                    }
                }
            }
        }
    </script>
    <?php if (isset($styles)): ?>
        <?= $styles ?>
    <?php endif; ?>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-lozido-green rounded-full flex items-center justify-center mr-3">
                        <span class="text-white font-bold text-lg">L</span>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900">LOZIDO</h1>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-600 hover:text-lozido-green transition-colors">Trang chủ</a>
                    <a href="#" class="text-gray-600 hover:text-lozido-green transition-colors">Tìm phòng</a>
                    <a href="#" class="text-gray-600 hover:text-lozido-green transition-colors">Đăng tin</a>
                    <a href="#" class="text-gray-600 hover:text-lozido-green transition-colors">Liên hệ</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400 text-sm">
                    Copyright @ LOZIDO - Tìm trọ, căn hộ, việc làm
                </p>
                <div class="flex justify-center items-center space-x-4 mt-4">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Báo lỗi
                    </a>
                    <span class="text-gray-600">|</span>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Điều khoản
                    </a>
                    <span class="text-gray-600">|</span>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Chính sách
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <?php if (isset($scripts)): ?>
        <?= $scripts ?>
    <?php endif; ?>
</body>
</html>
