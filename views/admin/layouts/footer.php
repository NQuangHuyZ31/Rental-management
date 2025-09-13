<!-- 
    Author: Huy Nguyen
    Date: 2025-09-09
    Purpose: Footer for admin
-->

<footer class="bg-white border-t border-gray-200 px-6 py-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <p class="text-sm text-gray-500">
                © <?= date('Y') ?> Rental Management System. All rights reserved.
            </p>
            <div class="hidden md:flex items-center space-x-4 text-sm text-gray-500">
                <a href="/admin/help" class="hover:text-gray-700">Trợ giúp</a>
                <a href="/admin/terms" class="hover:text-gray-700">Điều khoản</a>
                <a href="/admin/privacy" class="hover:text-gray-700">Bảo mật</a>
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="hidden md:flex items-center space-x-2 text-sm text-gray-500">
                <i class="fas fa-server"></i>
                <span>Server: Online</span>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <i class="fas fa-clock"></i>
                <span id="current-time"></span>
            </div>
        </div>
    </div>
</footer>

<script>
    // Update current time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleString('vi-VN', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('current-time').textContent = timeString;
    }
    
    // Update time every second
    updateTime();
    setInterval(updateTime, 1000);
</script>
