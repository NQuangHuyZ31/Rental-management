<?php 

/*
* Author: Huy Nguyen
* Date: 2025-09-05
* Purpose: Rental Post Model
*/

namespace App\Models;

class RentalPost extends Model {
	protected $table = 'rental_posts';

	public function getAllRentalPosts($limit = 10, $offset = 0) {
		return $this->table($this->table)
			->select([
				'rental_posts.*',
				'rental_categories.rental_category_name',
				'users.username as landlord_name'
			])
			->join('rental_categories', 'rental_posts.rental_category_id ', '=', 'rental_categories.id')
			->join('users', 'rental_posts.owner_id', '=', 'users.id')
			->where('rental_posts.deleted', 0)
			->where('rental_posts.owner_id', $this->getCurrentUserId())
			->orderBy('rental_posts.created_at', 'DESC')
			->limit($limit)
			->offset($offset)
			->get();
	}

	public function getRentalPostsByStatus($status, $limit = 10, $offset = 0) {
		return $this->table($this->table)
			->select([
				'rental_posts.*',
				'rental_categories.rental_category_name',
				'users.username as landlord_name'
			])
			->join('rental_categories', 'rental_posts.rental_category_id', '=', 'rental_categories.id')
			->join('users', 'rental_posts.owner_id', '=', 'users.id')
			->where('rental_posts.deleted', 0)
			->where('rental_posts.owner_id', $this->getCurrentUserId())
			->where('rental_posts.status', $status)
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
				'users.username as landlord_name'
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

	public function searchRentalPosts($searchTerm, $limit = 10, $offset = 0) {
		return $this->table($this->table)
			->select([
				'rental_posts.*',
				'rental_categories.rental_category_name',
				'users.username as landlord_name'
			])
			->join('rental_categories', 'rental_posts.rental_category_id', '=', 'rental_categories.id')
			->join('users', 'rental_posts.owner_id', '=', 'users.id')
			->where('rental_posts.deleted', 0)
			->where('rental_posts.owner_id', $this->getCurrentUserId())
			->whereOr('rental_posts.title', 'LIKE', "%{$searchTerm}%")
			->whereOr('rental_posts.description', 'LIKE', "%{$searchTerm}%")
			->whereOr('rental_posts.address', 'LIKE', "%{$searchTerm}%")
			->orderBy('rental_posts.created_at', 'DESC')
			->limit($limit)
			->offset($offset)
			->get();
	}

	public function getRentalPostById($id) {
		return $this->table($this->table)
			->select([
				'rental_posts.*',
				'rental_categories.rental_category_name',
				'users.username as landlord_name',
				'users.phone as landlord_phone',
				'users.email as landlord_email'
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
			'title' => $data['title'],
			'description' => $data['description'] ?? '',
			'contact_username' => $data['contact_username'],
			'contact_phone' => $data['contact_phone'],
			'price' => $this->convertCurrencyToNumber($data['price']),
			'promotional_price' => isset($data['promotional_price']) ? $this->convertCurrencyToNumber($data['promotional_price']) : null,
			'deposit' => isset($data['deposit']) ? $this->convertCurrencyToNumber($data['deposit']) : null,
			'area' => $data['area'],
			'electricity_price' => $this->convertCurrencyToNumber($data['electricity_price']),
			'water_price' => $this->convertCurrencyToNumber($data['water_price']),
			'max_occupants' => $data['max_occupants'] ?? 1,
			'available_date' => $data['available_date'],
			'opening_time' => $data['opening_time'] ?? 'all',
			'closing_time' => $data['closing_time'] ?? 'all',
			'province' => $data['province'],
			'ward' => $data['ward'],
			'address' => $data['address'],
			'status' => 'active',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		];

		return $this->table($this->table)->insert($postData);
	}

	public function updateRentalPost($id, $data) {
		$updateData = [
			'rental_category_id' => $data['category'],
			'title' => $data['title'],
			'description' => $data['description'] ?? '',
			'contact_username' => $data['contact_username'],
			'contact_phone' => $data['contact_phone'],
			'price' => $this->convertCurrencyToNumber($data['price']),
			'promotional_price' => isset($data['promotional_price']) ? $this->convertCurrencyToNumber($data['promotional_price']) : null,
			'deposit' => isset($data['deposit']) ? $this->convertCurrencyToNumber($data['deposit']) : null,
			'area' => $data['area'],
			'electricity_price' => $this->convertCurrencyToNumber($data['electricity_price']),
			'water_price' => $this->convertCurrencyToNumber($data['water_price']),
			'max_occupants' => $data['max_occupants'] ?? 1,
			'available_date' => $data['available_date'],
			'opening_time' => $data['opening_time'] ?? 'all',
			'closing_time' => $data['closing_time'] ?? 'all',
			'province' => $data['province'],
			'ward' => $data['ward'],
			'address' => $data['address'],
			'updated_at' => date('Y-m-d H:i:s')
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
				'updated_at' => date('Y-m-d H:i:s')
			]);
	}

	public function deleteRentalPost($id) {
		return $this->table($this->table)
			->where('id', $id)
			->where('owner_id', $this->getCurrentUserId())
			->update([
				'deleted' => 1,
				'updated_at' => date('Y-m-d H:i:s')
			]);
	}

	public function getTotalRentalPostsCount($filters = []) {
		$query = $this->table($this->table)
			->where('deleted', 0)
			->where('owner_id', $this->getCurrentUserId());

		if (isset($filters['status']) && !empty($filters['status'])) {
			$query->where('status', $filters['status']);
		}

		if (isset($filters['category_id']) && !empty($filters['category_id'])) {
			$query->where('rental_category_id', $filters['category_id']);
		}

		if (isset($filters['search']) && !empty($filters['search'])) {
			$query->whereOr('title', 'LIKE', "%{$filters['search']}%")
				  ->whereOr('description', 'LIKE', "%{$filters['search']}%")
				  ->whereOr('address', 'LIKE', "%{$filters['search']}%");
		}

		return $query->count();
	}

	public function getRentalPostAmenities($postId) {
		return $this->table('rental_post_amenities')
			->select([
				'rental_amenities.id',
				'rental_amenities.rental_amenity_name'
			])
			->join('rental_amenities', 'rental_post_amenities.amenity_id', '=', 'rental_amenities.id')
			->where('rental_post_amenities.post_id', $postId)
			->get();
	}

	public function saveRentalPostAmenities($postId, $amenityIds) {
		// Delete existing amenities
		$this->table('rental_post_amenities')
			->where('post_id', $postId)
			->delete();

		// Insert new amenities
		if (!empty($amenityIds)) {
			foreach ($amenityIds as $amenityId) {
				$this->table('rental_post_amenities')->insert([
					'post_id' => $postId,
					'amenity_id' => $amenityId,
					'created_at' => date('Y-m-d H:i:s')
				]);
			}
		}

		return true;
	}

	public function convertCurrencyToNumber($value) {
		if (empty($value)) return null;
		
		// Remove commas and convert to number
		return (int) str_replace(',', '', $value);
	}
}