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

    public function getAllRentalPosts($ownerId = true) {
        $query = $this->table($this->table);

        if ($ownerId) {
            $query->where('owner_id', $this->getCurrentUserId());
        }

        return $query->where('deleted', 0)->get();
    }

    public function getRentalPostsByStatus($column, $status, $limit = 10, $offset = 0) {
        $query = $this->table($this->table)
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
            ->orderBy('rental_posts.created_at', 'DESC');

        if (!empty($limit) || $limit > 0) {
            $query->limit($limit);
        }

        if ($offset >= 0) {
            $query->offset($offset);
        }

        return $query->get();
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

    public function searchRentalPosts($filters = [], $limit = 10, $offset = 0, $ownerId = false, $customerPage = false, $orderBy = 'created_at', $sort = 'DESC') {
        $sql = "
                SELECT rental_posts.*, rental_categories.rental_category_name, users.username AS landlord_name, houses.house_name FROM rental_posts 
                INNER JOIN rental_categories ON rental_posts.rental_category_id = rental_categories.id 
                INNER JOIN users ON rental_posts.owner_id = users.id 
                LEFT JOIN houses ON rental_posts.house_id = houses.id
                WHERE rental_posts.deleted = 0
                ";

        $params = [];

        if (!empty($ownerId)) {
            $sql .= " AND rental_posts.owner_id = :current_user_id";
            $params['current_user_id'] = $this->getCurrentUserId();
        }

        if (!empty($customerPage)) {
            $sql .= " AND rental_posts.approval_status = 'approved'";
            $sql .= " AND rental_posts.status = 'active'";
        }

        if (!empty($filters['approval_status'])) {
            $sql .= " AND rental_posts.approval_status = :approval_status";
            $params['approval_status'] = $filters['approval_status'];
        }

        if (!empty($filters['rental_category_id'])) {
            $sql .= " AND rental_posts.rental_category_id = :rental_category_id";
            $params['rental_category_id'] = $filters['rental_category_id'];
        }

        if (!empty($filters['category_name'])) {

            $raw = $filters['category_name'];
            $nameList = array_filter(array_map('trim', preg_split('/\s*,\s*/', $raw)));

            if (!empty($nameList)) {
                $sql .= " AND (";

                foreach ($nameList as $i => $name) {
                    $key = "cat_name_$i";

                    if ($i > 0) {
                        $sql .= " OR ";
                    }

                    $sql .= " rental_categories.rental_category_name COLLATE utf8mb4_general_ci LIKE :$key";

                    $params[$key] = "%$name%";
                }

                $sql .= ")";
            }
        }

        if (!empty($filters['province'])) {
            $sql .= " AND rental_posts.province LIKE :province";
            $params['province'] = "%{$filters['province']}%";
        }

        if (!empty($filters['price'])) {
            [$fromPrice, $toPrice] = explode("-", $filters['price']);

            $sql .= " AND rental_posts.price >= :from_price";
            $sql .= " AND rental_posts.price <= :to_price";

            $params['from_price'] = $fromPrice * 1000000;
            $params['to_price'] = $toPrice * 1000000;
        }

        if (!empty($filters['area'])) {
            [$fromArea, $toArea] = explode("-", $filters['area']);

            $sql .= " AND rental_posts.area >= :from_area";
            $sql .= " AND rental_posts.area <= :to_area";

            $params['from_area'] = $fromArea;
            $params['to_area'] = $toArea;
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (
                    rental_posts.rental_post_title LIKE :search1
                    OR rental_posts.description LIKE :search2
                    OR rental_posts.address LIKE :search3
                    OR rental_posts.province LIKE :search4
                    OR rental_posts.ward LIKE :search5
                    OR rental_categories.rental_category_name LIKE :search6
                    OR houses.house_name LIKE :search7
                )";

            $params['search1'] = "%" . $filters['search'] . "%";
            $params['search2'] = "%" . $filters['search'] . "%";
            $params['search3'] = "%" . $filters['search'] . "%";
            $params['search4'] = "%" . $filters['search'] . "%";
            $params['search5'] = "%" . $filters['search'] . "%";
            $params['search6'] = "%" . $filters['search'] . "%";
            $params['search7'] = "%" . $filters['search'] . "%";
        }

        $orderBy = !empty($orderBy) ? $orderBy : "created_at";
        $sort = !empty($sort) ? strtoupper($sort) : "DESC";

        $sql .= " ORDER BY rental_posts.`$orderBy` $sort";

        $sql .= " LIMIT {$limit} OFFSET {$offset}";
        // die($sql);
        return $this->queryAll($sql, $params);
    }

    // get total rental posts count
    public function getTotalRentalPostsCount($filters = [], $customerPage = false, $ownerId = false) {
        $sql = "
                SELECT rental_posts.*, rental_categories.rental_category_name, users.username AS landlord_name, houses.house_name FROM rental_posts 
                INNER JOIN rental_categories ON rental_posts.rental_category_id = rental_categories.id 
                INNER JOIN users ON rental_posts.owner_id = users.id 
                LEFT JOIN houses ON rental_posts.house_id = houses.id
                WHERE rental_posts.deleted = 0
                ";

        $params = [];

        if (!empty($ownerId)) {
            $sql .= " AND rental_posts.owner_id = :current_user_id";
            $params['current_user_id'] = $this->getCurrentUserId();
        }

        if (!empty($customerPage)) {
            $sql .= " AND rental_posts.approval_status = 'approved'";
            $sql .= " AND rental_posts.status = 'active'";
        }

        if (!empty($filters['approval_status'])) {
            $sql .= " AND rental_posts.approval_status = :approval_status";
            $params['approval_status'] = $filters['approval_status'];
        }

        if (!empty($filters['rental_category_id'])) {
            $sql .= " AND rental_posts.rental_category_id = :rental_category_id";
            $params['rental_category_id'] = $filters['rental_category_id'];
        }

        if (!empty($filters['category_name'])) {

            $raw = $filters['category_name'];
            $nameList = array_filter(array_map('trim', preg_split('/\s*,\s*/', $raw)));

            if (!empty($nameList)) {
                $sql .= " AND (";

                foreach ($nameList as $i => $name) {
                    $key = "cat_name_$i";

                    if ($i > 0) {
                        $sql .= " OR ";
                    }

                    $sql .= " rental_categories.rental_category_name COLLATE utf8mb4_general_ci LIKE :$key";

                    $params[$key] = "%$name%";
                }

                $sql .= ")";
            }
        }

        if (!empty($filters['province'])) {
            $sql .= " AND rental_posts.province LIKE :province";
            $params['province'] = "%{$filters['province']}%";
        }

        if (!empty($filters['price'])) {
            [$fromPrice, $toPrice] = explode("-", $filters['price']);

            $sql .= " AND rental_posts.price >= :from_price";
            $sql .= " AND rental_posts.price <= :to_price";

            $params['from_price'] = $fromPrice * 1000000;
            $params['to_price'] = $toPrice * 1000000;
        }

        if (!empty($filters['area'])) {
            [$fromArea, $toArea] = explode("-", $filters['area']);

            $sql .= " AND rental_posts.area >= :from_area";
            $sql .= " AND rental_posts.area <= :to_area";

            $params['from_area'] = $fromArea;
            $params['to_area'] = $toArea;
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (
                    rental_posts.rental_post_title LIKE :search1
                    OR rental_posts.description LIKE :search2
                    OR rental_posts.address LIKE :search3
                    OR rental_posts.province LIKE :search4
                    OR rental_posts.ward LIKE :search5
                    OR rental_categories.rental_category_name LIKE :search6
                    OR houses.house_name LIKE :search7
                )";

            $params['search1'] = "%" . $filters['search'] . "%";
            $params['search2'] = "%" . $filters['search'] . "%";
            $params['search3'] = "%" . $filters['search'] . "%";
            $params['search4'] = "%" . $filters['search'] . "%";
            $params['search5'] = "%" . $filters['search'] . "%";
            $params['search6'] = "%" . $filters['search'] . "%";
            $params['search7'] = "%" . $filters['search'] . "%";
        }

        $orderBy = !empty($orderBy) ? $orderBy : "created_at";
        $sort = !empty($sort) ? strtoupper($sort) : "DESC";

        $sql .= " ORDER BY rental_posts.`$orderBy` $sort";
        // die($sql);
        return count($this->queryAll($sql, $params)) ?? 0;
    }

    public function getRentalPostById($id, $role = '') {
        $query = $this->table($this->table)
            ->select([
                'rental_posts.*',
                'rental_categories.rental_category_name',
                'users.username as landlord_name',
                'users.phone as landlord_phone',
                'users.email as landlord_email',
                'houses.house_name',
            ])
            ->leftJoin('houses', 'rental_posts.house_id', '=', 'houses.id')
            ->join('rental_categories', 'rental_posts.rental_category_id', '=', 'rental_categories.id')
            ->join('users', 'rental_posts.owner_id', '=', 'users.id')
            ->where('rental_posts.id', $id)
            ->where('rental_posts.deleted', 0);

        if ($role == 'landlord') {
            $query->where('rental_posts.owner_id', $this->getCurrentUserId());
        }

        return $query->first();
    }

    public function createRentalPost($data) {
        $postData = [
            'owner_id' => $this->getCurrentUserId(),
            'rental_category_id' => $data['category'],
            'house_id' => $data['house'] ?? null,
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

    public function updateRentalPost($id, $data, $ownerId = 1) {
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

        $query = $this->table($this->table)
            ->where('id', $id);

        if ($ownerId == 1) {
            $query->where('owner_id', $this->getCurrentUserId());
        }

        return $query->update($updateData);
    }

    public function updateRentalPostStatus($id, $status, $role = '') {
        $query = $this->table($this->table)
            ->where('id', $id);

        if ($role == 'landlord') {
            $query->where('owner_id', $this->getCurrentUserId());
        }

        return $query->update([
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function deleteRentalPost($id, $role = '') {
        $query = $this->table($this->table)
            ->where('id', $id);

        if ($role == 'landlord') {
            $query->where('owner_id', $this->getCurrentUserId());
        }

        return $query->update([
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

        if (!empty($approvedStatus)) {
            $query->whereIn('approval_status', $approvedStatus);
        }

        if (!empty($status)) {
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
