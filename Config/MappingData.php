<?php

/*
	Author: Huy Nguyen
	Date: 2025-12-14
	Purpose: Helper to map data for various
*/

namespace Config;

class MappingData {
	public static function mapStatus($status) {
		$statusMap = [
			'pending' => 'Chờ duyệt',
			'approved' => 'Đã duyệt',
			'rejected' => 'Bị từ chối',
			'expired' => 'Hết hạn',
			'deleted' => 'Đã xóa',
			'active' => 'Đang hoạt động',
			'inactive' => 'Không hoạt động',
			'banned' => 'Bị cấm',
			'reviewed' => 'Đã đánh giá',
			'resolved' => 'Đã giải quyết',
			'paid' => 'Đã thanh toán',
			'unpaid' => 'Chưa thanh toán',
			'overdue' => 'Quá hạn',
		];

		return $statusMap[$status] ?? 'Không xác định';
	}

	public function mappingUnit ($unit) {
		$unitMap = [
			'month' => 'Tháng',
			'year' => 'Năm',
			'day' => 'Ngày',
			'week' => 'Tuần',
			'hour' => 'Giờ',
			'person'=> 'Người',
			'KWH' => 'KW/h',
			'm3' => 'm³',

		];

		return $unitMap[$unit] ?? 'Không xác định';
	}

	public static function mappingUserType($type) {
		$typeMap = [
			'landlord' => 'Chủ nhà',
			'customer' => 'Khách hàng',
			'admin' => 'Quản trị viên',
		];

		return $typeMap[$type] ?? 'Không xác định';
	}
}