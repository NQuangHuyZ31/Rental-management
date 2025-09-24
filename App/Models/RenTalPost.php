<?php

/*
 * Author: Huy Nguyen
 * Date: 2025-09-05
 * Purpose: Rental Post Model
 */

namespace App\Models;

use Helpers\Log;

class RenTalPost extends Model {
    protected $table = 'rental_posts';

    public function __construct() {
        parent::__construct();
    }

    public function getAllRentalPosts() {
        return $this->table($this->table)->where('deleted', 0)->get();
    }

    public function getRentalPostsByStatus($column, $status, $limit = 10, $offset = 0) {
        return $this->table($this->table)
            ->select([
                'rental_posts.*',
                'rental_categories.rental_category_name',
                'users.username as landlord_name',
            ])
            ->join('rental_categories', 'rental_posts.rental_category_id', '=', 'rental_categories.id')
            ->join('users', 'rental_posts.owner_id', '=', 'users.id')
            ->where('rental_posts.deleted', 0)
            ->where('rental_posts.owner_id', $this->getCurrentUserId())
            ->where('rental_posts.' . $column, $status)
            ->orderBy('rental_posts.created_at', 'DESC')
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    public function getRentalPostsByCategory($categoryId, $limit = 10, $offset = 0) {
        return $this->table($this->table)
            ->select([
                'rental_posts.*',
                'rental_categories.rental_category_name',
                'users.username as landlord_name',
            ])
            ->join('rental_categories', 'rental_posts.rental_category_id', '=', 'rental_categories.id')
            ->join('users', 'rental_posts.owner_id', '=', 'users.id')
            ->where('rental_posts.deleted', 0)
            ->where('rental_posts.owner_id', $this->getCurrentUserId())
            ->where('rental_posts.rental_category_id', $categoryId)
            ->orderBy('rental_posts.created_at', 'DESC')
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    public function searchRentalPosts($filters = [], $limit = 10, $offset = 0, $ownerId = false, $orderBy = 'created_at') {
        $query = $this->table($this->table)
            ->select([
                'rental_posts.*',
                'rental_categories.rental_category_name',
                'users.username as landlord_name',
            ])
            ->join('rental_categories', 'rental_posts.rental_category_id', '=', 'rental_categories.id')
            ->join('users', 'rental_posts.owner_id', '=', 'users.id')
            ->where('rental_posts.deleted', 0);

        if ($ownerId) {
            $query->where('rental_posts.owner_id', $this->getCurrentUserId());
        }

        if (isset($filters['approval_status']) && !empty($filters['approval_status'])) {
            $query->where('rental_posts.approval_status', $filters['approval_status']);
        }

        if (isset($filters['rental_category_id']) && !empty($filters['rental_category_id'])) {
            $query->where('rental_posts.rental_category_id', $filters['rental_category_id']);
        }

        if (isset($filters['search']) && !empty($filters['search'])) {
            $query->whereOr('rental_posts.rental_post_title', 'LIKE', "%{$filters['search']}%")
                ->whereOr('rental_posts.description', 'LIKE', "%{$filters['search']}%")
                ->whereOr('rental_posts.address', 'LIKE', "%{$filters['search']}%")
                ->whereOr('rental_posts.province', 'LIKE', "%{$filters['search']}%")
                ->whereOr('rental_posts.ward', 'LIKE', "%{$filters['search']}%");
        }

        return $query->orderBy('rental_posts.' . $orderBy, 'DESC')
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

	// get total rental posts count
	public function getTotalRentalPostsCount($filters = [], $ownerId = false) {
		$query = $this->table($this->table)
			->where('deleted', 0);

		if ($ownerId) {
			$query->where('owner_id', $this->getCurrentUserId());
		}

		if (isset($filters['approval_status']) && !empty($filters['approval_status'])) {
			$query->where('approval_status', $filters['approval_status']);
		}

		if (isset($filters['rental_category_id']) && !empty($filters['rental_category_id'])) {
			$query->where('rental_category_id', $filters['rental_category_id']);
		}

		if (isset($filters['search']) && !empty($filters['search'])) {
			$query->whereOr('rental_post_title', 'LIKE', "%{$filters['search']}%")
				->whereOr('description', 'LIKE', "%{$filters['search']}%")
				->whereOr('address', 'LIKE', "%{$filters['search']}%")
				->whereOr('province', 'LIKE', "%{$filters['search']}%")
				->whereOr('ward', 'LIKE', "%{$filters['search']}%");
		}

		return $query->count();
	}

    public function getRentalPostById($id) {
        return $this->table($this->table)
            ->select([
                'rental_posts.*',
                'rental_categories.rental_category_name',
                'users.username as landlord_name',
                'users.phone as landlord_phone',
                'users.email as landlord_email',
            ])
            ->join('rental_categories', 'rental_posts.rental_category_id', '=', 'rental_categories.id')
            ->join('users', 'rental_posts.owner_id', '=', 'users.id')
            ->where('rental_posts.id', $id)
            ->where('rental_posts.deleted', 0)
            ->where('rental_posts.owner_id', $this->getCurrentUserId())
            ->first();
    }

    public function createRentalPost($data) {
        $postData = [
            'owner_id' => $this->getCurrentUserId(),
            'rental_category_id' => $data['category'],
            'rental_post_title' => $data['title'],
            'contact' => $data['contact_name'],
            'phone' => $data['contact_phone'],
            'description' => $data['description'] ?? '',
            'price' => $data['price'],
            'price_discount' => isset($data['promotional_price']) ? $data['promotional_price'] : '0',
            'rental_deposit' => isset($data['deposit']) ? $data['deposit'] : '0',
            'area' => $data['area'],
            'electric_fee' => $data['electricity_price'],
            'water_fee' => $data['water_price'],
            'max_number_of_people' => $data['max_occupants'] ?? 1,
            'stay_start_date' => $data['available_date'],
            'rental_amenities' => json_encode($data['amenities']),
            'rental_open_time' => $data['opening_time'] ?? 'all',
            'rental_close_time' => $data['closing_time'] ?? 'all',
            'province' => $data['province'],
            'ward' => $data['ward'],
            'address' => $data['address'],
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        return $this->table($this->table)->insert($postData);
    }

    public function updateRentalPost($id, $data) {
        $updateData = [
            'owner_id' => $this->getCurrentUserId(),
            'rental_category_id' => $data['category'],
            'rental_post_title' => $data['title'],
            'contact' => $data['contact_name'],
            'phone' => $data['contact_phone'],
            'description' => $data['description'] ?? '',
            'price' => $data['price'],
            'price_discount' => isset($data['promotional_price']) ? $data['promotional_price'] : '0',
            'rental_deposit' => isset($data['deposit']) ? $data['deposit'] : '0',
            'area' => $data['area'],
            'electric_fee' => $data['electricity_price'],
            'water_fee' => $data['water_price'],
            'max_number_of_people' => $data['max_occupants'] ?? 1,
            'stay_start_date' => $data['available_date'],
            'rental_amenities' => json_encode($data['amenities']),
            'rental_open_time' => $data['opening_time'] ?? 'all',
            'rental_close_time' => $data['closing_time'] ?? 'all',
            'province' => $data['province'],
            'ward' => $data['ward'],
            'address' => $data['address'],
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        return $this->table($this->table)
            ->where('id', $id)
            ->where('owner_id', $this->getCurrentUserId())
            ->update($updateData);
    }

    public function updateRentalPostStatus($id, $status) {
        return $this->table($this->table)
            ->where('id', $id)
            ->where('owner_id', $this->getCurrentUserId())
            ->update([
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }

    public function deleteRentalPost($id) {
        return $this->table($this->table)
            ->where('id', $id)
            ->where('owner_id', $this->getCurrentUserId())
            ->update([
                'deleted' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }

    public function getRentalPostAmenities($postId) {
        return $this->table('rental_post_amenities')
            ->select([
                'rental_amenities.id',
                'rental_amenities.rental_amenity_name',
            ])
            ->join('rental_amenities', 'rental_post_amenities.amenity_id', '=', 'rental_amenities.id')
            ->where('rental_post_amenities.post_id', $postId)
            ->get();
    }

    public function updatePostImages($postId, $images) {
        try {
            $result = $this->table($this->table)
                ->where('id', $postId)
                ->update([
                    'images' => json_encode($images),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            return $result;
        } catch (\Exception $e) {
            Log::server("Exception in updatePostImages: " . $e->getMessage());
            return false;
        }
    }

    public function getCountRentalPostsByStatus($approvedStatus = ['pending', 'approved'], $status = '') {
        $query = $this->table($this->table)
            ->where('deleted', 0);

        if ($approvedStatus != '') {
            $query->whereIn('approval_status', $approvedStatus);
        }

        if ($status != '') {
            $query->where('status', $status);
        }

        return $query->count();
    }

    public function getRentalPostCurrent($limit = '') {
        $query = $this->table($this->table)
            ->where('deleted', 0)
            ->orderBy('created_at', 'DESC');

        if ($limit != '') {
            $query->limit($limit);
        }
        return $query->get();
    }
}
