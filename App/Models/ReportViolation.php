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

    public function updateColumn($reportId, $column, $value) {
        if (empty($column) || empty($value)) return;

        $value = is_array($value) ? json_encode($value) : $value;

        return $this->table($this->table)->where('id', $reportId)->update([$column => $value]);
    }
}