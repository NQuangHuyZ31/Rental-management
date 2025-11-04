<?php
/*
Author: Huy Nguyen
Date: 2025-10-20
Purpose: Rental post interesting model
 */

namespace App\Models;

class RentalPostInterest extends Model {
    protected $table = 'rental_post_interestes';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function getByUserId($userId, $postId = null, $limit = '', $offset = '', $first = false) {
        $query = $this->table($this->table)->select(['rental_posts.*', $this->table . '.' . $this->primary_key . ' AS post_interest_id'])
            ->join('rental_posts', 'rental_post_interestes.rental_post_id', '=', 'rental_posts.id')->where('user_id', $userId)->where('rental_post_interestes.deleted', 0);

        if ($postId != null) {
            $query->where('rental_post_interestes.rental_post_id', $postId);
        }

        if (!empty($limit)) {
            $query->limit($limit);
        }

        if (!empty($offset)) {
            $query->offset($offset);
        }
        return $first ? $query->first() : $query->get();
    }
}
