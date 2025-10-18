<?php

/*
 * Author: Nguyen Xuan Duong
 * Date: 2025-10-18
 * Purpose: Banned Model - handles banneds table operations
 */

namespace App\Models;
use Core\QueryBuilder;

class Banned extends Model {
    // Database table name (singular 'banned' as currently present in DB)
    protected $table = 'banned';
    private $queryBuilder;

    public function __construct() {
        parent::__construct();
        $this->queryBuilder = new QueryBuilder();
    }

    /**
     * Insert a new banned record
     * $data: [user_id, reason, banned_at, banned_status, created_at, updated_at]
     */
    public function insertBan(array $data) {
        return $this->queryBuilder->table($this->table)->insert($data);
    }

    /**
     * Get active ban record for a user (if any)
     */
    public function getActiveBanByUser($userId) {
        return $this->queryBuilder->table($this->table)
            ->where('user_id', $userId)
            ->where('banned_status', 'active')
            ->first();
    }

    /**
     * Revoke active bans for a user (set banned_status = 'revoked' and update timestamps)
     */
    public function revokeActiveBansByUser($userId) {
        return $this->queryBuilder->table($this->table)
            ->where('user_id', $userId)
            ->where('banned_status', 'active')
            ->update([
                'banned_status' => 'revoked',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }

    /**
     * Get ban history for a user
     */
    public function getBanHistoryByUser($userId) {
        return $this->queryBuilder->table($this->table)
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}
