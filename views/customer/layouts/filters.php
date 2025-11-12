<!-- 
	Author: Huy Nguyen
	Date: 2025-08-15
	Purpose: base filter search rental post
-->

<form id="filters" method='GET' class="w-full">
	<!-- Filter Container with Glass Effect -->
	<div class="backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/20">
		<!-- Filter Grid -->
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
			<!-- Location Input -->
			<div class="lg:col-span-1">
				<label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wide">Tỉnh/Thành phố</label>
				<div class="relative group">
					<div class="flex items-center bg-white border-2 border-gray-200 rounded-xl px-4 py-3 group-hover:border-green-400 focus-within:border-green-500 focus-within:ring-2 focus-within:ring-green-100 transition-all duration-300 shadow-sm hover:shadow-md">
						<select id="province" name="province" class="w-full bg-transparent border-none outline-none text-gray-900 text-sm font-medium cursor-pointer appearance-none"
								data-default = "<?= htmlspecialchars($currentFilters['province'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
							<option value="">Chọn tỉnh/thành phố</option>
						</select>
					</div>
				</div>
			</div>

			<!-- Text Search Input -->
			<div class="lg:col-span-2">
				<label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wide">Từ khóa tìm kiếm</label>
				<div class="relative group">
					<div class="flex items-center bg-white border-2 border-gray-200 rounded-xl px-4 py-3 group-hover:border-green-400 focus-within:border-green-500 focus-within:ring-2 focus-within:ring-green-100 transition-all duration-300 shadow-sm hover:shadow-md">
						<i class="fas fa-search text-gray-400 text-sm mr-3 flex-shrink-0"></i>
						<input type="text" name="search" placeholder="Nhập tiêu chí muốn tìm kiếm..." value="<?= htmlspecialchars($currentFilters['search'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="flex-1 outline-none text-gray-900 placeholder-gray-500 text-sm font-medium bg-transparent">
					</div>
				</div>
			</div>

			<!-- Price Input -->
			<div class="lg:col-span-1">
				<label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wide">Mức giá</label>
				<div class="relative group">
					<div class="flex items-center bg-white border-2 border-gray-200 rounded-xl px-4 py-3 group-hover:border-green-400 focus-within:border-green-500 focus-within:ring-2 focus-within:ring-green-100 transition-all duration-300 shadow-sm hover:shadow-md">
						<i class="fas fa-dollar-sign text-gray-400 text-sm mr-3 flex-shrink-0"></i>
						<select name="price" class="w-full bg-transparent border-none outline-none text-gray-900 text-sm font-medium cursor-pointer appearance-none">
							<option value="" <?php echo $currentFilters['price'] == '' ? 'selected' : '' ?>>Tất cả mức giá</option>
							<option value="0-1" <?php echo $currentFilters['price'] == '0-1' ? 'selected' : '' ?>>Dưới 1 triệu</option>
							<option value="1-2" <?php echo $currentFilters['price'] == '1-2' ? 'selected' : '' ?>>1 - 2 triệu</option>
							<option value="2-3" <?php echo $currentFilters['price'] == '2-3' ? 'selected' : '' ?>>2 - 3 triệu</option>
							<option value="3-4" <?php echo $currentFilters['price'] == '3-4' ? 'selected' : '' ?>>3 - 4 triệu</option>
							<option value="4-5" <?php echo $currentFilters['price'] == '4-5' ? 'selected' : '' ?>>4 - 5 triệu</option>
							<option value="5-100" <?php echo $currentFilters['price'] == '5-100' ? 'selected' : '' ?>>Trên 5 triệu</option>
						</select>
					</div>
				</div>
			</div>

			<!-- Area Input -->
			<div class="lg:col-span-1">
				<label class="block text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wide">Diện tích</label>
				<div class="relative group">
					<div class="flex items-center bg-white border-2 border-gray-200 rounded-xl px-4 py-3 group-hover:border-green-400 focus-within:border-green-500 focus-within:ring-2 focus-within:ring-green-100 transition-all duration-300 shadow-sm hover:shadow-md">
						<i class="fas fa-expand-arrows-alt text-gray-400 text-sm mr-3 flex-shrink-0"></i>
						<select name="area" class="w-full bg-transparent border-none outline-none text-gray-900 text-sm font-medium cursor-pointer appearance-none">
							<option value="" <?php echo $currentFilters['area'] == '' ? 'selected' : '' ?>>Tất cả diện tích</option>
							<option value="0-10" <?php echo $currentFilters['area'] == '0-10' ? 'selected' : '' ?>>Dưới 10m²</option>
							<option value="10-20" <?php echo $currentFilters['area'] == '10-20' ? 'selected' : '' ?>>10 - 20 m²</option>
							<option value="20-30" <?php echo $currentFilters['area'] == '20-30' ? 'selected' : '' ?>>20 - 30 m²</option>
							<option value="30-40" <?php echo $currentFilters['area'] == '30-40' ? 'selected' : '' ?>>30 - 40 m²</option>
							<option value="40-50" <?php echo $currentFilters['area'] == '40-50' ? 'selected' : '' ?>>40 - 50 m²</option>
							<option value="50-100" <?php echo $currentFilters['area'] == '50-100' ? 'selected' : '' ?>>Trên 50 m²</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Search Button -->
		<div class="flex justify-center mt-4">
			<button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-xl font-bold text-base transition-all duration-300 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-1 active:translate-y-0">
				<i class="fas fa-search mr-3 text-lg"></i>
				Tìm kiếm
			</button>
		</div>
	</div>
</form>