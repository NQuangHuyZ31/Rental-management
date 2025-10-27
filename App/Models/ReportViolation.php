<?php

/*
Author: Huy Nguyen
Date: 2025-10-20
Purpose: Report violation model
 */

namespace App\Models;

class ReportViolation extends Model {
    protected $table = 'report_violations';
    protected $primary_key = 'id';

    public function add($data) {
        return $this->table($this->table)->insert($data);
    }

    /**
     * Get reports with optional filters and pagination
     * $filter: ['search' => '', 'status' => '', 'type' => '']
     * If $total = true, returns count (all matching rows) instead of paginated data
     */
    public function getReports(array $filter = [], $limit = 10, $offset = 0, $total = false) 
    {
        $query = $this->table($this->table)
            ->select(['report_violations.*', 'users.username AS reporter_name', 'users.email AS reporter_email'])
            ->leftJoin('users', 'report_violations.target_id', '=', 'users.id');

        if (isset($filter['search']) && $filter['search'] !== '') {
            // Search in title or description
            $query->whereOrGroup(['report_violations.title', 'report_violations.description'], 'LIKE', "%{$filter['search']}%");
        }

        if (isset($filter['status']) && $filter['status'] !== '') {
            $query->where('report_violations.status', $filter['status']);
        }

        if (isset($filter['type']) && $filter['type'] !== '') {
            $query->where('report_violations.violattion_type', $filter['type']);
        }

        $query->orderBy('report_violations.created_at', 'DESC');

        if ($total) {
            $rows = $query->get();
            return is_array($rows) ? count($rows) : 0;
        }

        return $query->limit($limit)->offset($offset)->get();
    }

    /**
     * Return allowed status list for reports.
     * @return array key => label
     */
    public function getStatusList()
    {
        return [
            'pending' => 'Chờ xử lý',
            'reviewed' => 'Đang xử lý',
            'resolved' => 'Đã xử lý',
            'rejected' => 'Bị từ chối'
        ];
    }

    /**
     * Return allowed report types (violattion_type) list.
     * @return array key => label
     */
    public function getTypeList()
    {
        return [
            'spam' => 'Spam',
            'fake' => 'Thông tin sai lệch',
            'scam' => 'Scam',
            'inappropriate' => 'Nội dung không phù hợp',
            'violence' => 'Bạo lực',
            'other' => 'Khác',
        ];
    }

    /**
     * Get single report by id with reporter info.
     * @param int $id
     * @return array|null
     */
    public function getReportById($id)
    {
        return $this->table($this->table)
            ->select(['report_violations.*', 'users.username AS reporter_name', 'users.email AS reporter_email'])
            ->leftJoin('users', 'report_violations.target_id', '=', 'users.id')
            ->where('report_violations.id', $id)
            ->first();
    }

    /**
     * Update report status and optional fields.
     * $data may contain keys like admin_id, resolved_at, action_taken, note
     * @param int $id
     * @param string $status
     * @param array $data
     * @return bool|int number of affected rows or false
     */
    public function updateStatus($id, $status, array $data = [])
    {
        $payload = array_merge(['status' => $status], $data);
        return $this->table($this->table)->where('id', $id)->update($payload);
    }
}

// Schema::create('report_violations', function (Blueprint $table) {
//             $table->id();
//             $table->integer('target_id');
//             $table->integer('target_owner_id')->nullable();
//             $table->string('title');
//             $table->integer('rental_post_id')->nullable();
//             $table->integer('user_id')->nullable();
//             $table->integer('room_id')->nullable();
//             $table->enum('target_type', ['post', 'user', 'comment', 'review', 'room']);
//             $table->enum('violattion_type', ['spam', 'fake', 'scam', 'inappropriate', 'violence', 'other']);
//             $table->text('description');
//             $table->enum('status', ['pending', 'reviewed', 'resolved', 'rejected'])->default('pending');
//             $table->integer('admin_id')->nullable();
//             $table->text('action_taken')->nullable();
//             $table->text('note')->nullable();
//             $table->text('images')->nullable();
//             $table->date('resolved_at');
//             $table->timestamps();
//         });