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
     * $data should contain keys: user_id, banner_id, reason, banned_at, banned_status, created_at, updated_at
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
     * Revoke active bans for a user (set banned_status = 'revoked', set revoker_id and revoked_at, update timestamps)
     */
    public function revokeActiveBansByUser($userId, $revokerId = null) {
        $data = [
            'banned_status' => 'revoked',
            'revoked_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if ($revokerId) {
            $data['revoker_id'] = $revokerId;
        }

        return $this->queryBuilder->table($this->table)
            ->where('user_id', $userId)
            ->where('banned_status', 'active')
            ->update($data);
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
