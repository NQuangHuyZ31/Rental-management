<?php

use Helpers\Format;
?>
<a href="<?= BASE_URL ?>/rental-post/<?= \Helpers\CreateSlug::createSlug($post['rental_post_title']) . '-' . $post['id'] ?>" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-200 cursor-pointer">
    <div class="flex flex-col sm:flex-row">
        <!-- Image Section -->
        <div class="sm:w-80 flex-shrink-0 relative">
            <div class="aspect-[4/3] bg-gray-100">
                <img src="<?= json_decode($post['images'])[0] ?>" alt="Post Image" class="w-full h-full object-cover">
            </div>

            <!-- Photo count badge -->
            <div class="absolute top-3 right-3 bg-black/70 text-white text-xs px-2 py-1 rounded-full flex items-center gap-1">
                <i class="fas fa-camera text-xs"></i>
                <span><?= count(json_decode($post['images'])) ?? 0 ?></span>
            </div>

            <!-- Verified badge -->
            <div class="absolute bottom-3 left-3 bg-green-500 text-white text-xs px-2 py-1 rounded-full flex items-center gap-1">
                <i class="fas fa-check text-xs"></i>
                <span>Đã xác minh</span>
            </div>
        </div>

        <!-- Content Section -->
        <div class="flex-1 p-6">
            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-green-600 transition-colors">
                <?= htmlspecialchars($post['rental_post_title'], ENT_QUOTES, 'UTF-8') ?>
            </h3>

            <!-- Location -->
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                <i class="fas fa-map-marker-alt text-gray-400"></i>
                <span class="line-clamp-1"><?= htmlspecialchars($post['address'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($post['ward'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($post['province'], ENT_QUOTES, 'UTF-8') ?></span>
            </div>

            <!-- Price and Area -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex flex-col">
                    <?php if ($post['price_discount'] > 0) { ?>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-gray-400 line-through text-sm"><?= Format::forMatPrice($post['price']) ?>₫</span>
                            <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full"><?= round(($post['price'] - $post['price_discount']) / $post['price'] * 100) ?>% OFF</span>
                        </div>
                    <?php } ?>
                    <div class="text-2xl font-bold text-red-600">
                        <?= $post['price_discount'] > 0 ? Format::forMatPrice($post['price_discount']) : Format::forMatPrice($post['price']) ?> đ/tháng
                    </div>
                </div>
                <div class="text-sm text-gray-500 font-medium"><?= htmlspecialchars($post['area'], ENT_QUOTES, 'UTF-8') ?> m²</div>
            </div>

            <!-- Utilities -->
            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                <div class="flex items-center gap-1">
                    <i class="fas fa-bolt text-yellow-500"></i>
                    <span><?= $post['electric_fee'] ? Format::forMatPrice($post['electric_fee']) . 'đ/Kw' : 'Liên hệ' ?></span>
                </div>
                <div class="flex items-center gap-1">
                    <i class="fas fa-tint text-blue-500"></i>
                    <span><?= $post['water_fee'] ? Format::forMatPrice($post['water_fee']) . 'đ/Khối' : 'Liên hệ' ?></span>
                </div>
            </div>

            <!-- Author and Time -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-user text-gray-500 text-xs"></i>
                    </div>
                    <span><?= htmlspecialchars($post['contact'], ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="text-gray-400">•</span>
                    <span><?= date('d/m/Y', strtotime($post['created_at'])) ?></span>
                </div>

                <!-- Action buttons -->
                <div class="flex items-center gap-2">
                    <button class="p-2 text-gray-400 hover:text-green-500 transition-colors" title="Gọi điện">
                        <i class="fas fa-phone"></i>
                    </button>
                    <button class="p-2 text-gray-400 hover:text-blue-600 transition-colors" title="Zalo">
                        <i class="fas fa-comments"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</a>