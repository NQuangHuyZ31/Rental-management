<?php
/*
* Author: Huy Nguyen
* Date: 2025-09-17
* Purpose: Payment History Model
*/

namespace App\Models;

use App\Models\Model;

class PaymentHistory extends Model {
    protected $table = 'payment_histories';

    public function __construct() {
        parent::__construct();
    }

    public function create($data) {
        return $this->insert($data);
    }

    public function updatePaymentHistory($id, $data) {
        return $this->table($this->table)->where('id', $id)->update($data);
    }

    public function getPaymentHistoryByInvoiceId($invoiceId) {
        return $this->table($this->table)->where('invoice_id', $invoiceId)->where('deleted', 0)->first();
    }

    public function getPaymentHistoryByUserId($userId) {
        return $this->table($this->table)->where('payer_id', $userId)->where('deleted', 0)->orderBy('created_at', 'desc')->get();
    }

    public function getPaymentHistoryByUserIdWithPagination($userId, $limit, $offset) {
        return $this->table($this->table)->where('payer_id', $userId)
        ->select('payment_histories.*, invoices.invoice_name, invoices.invoice_month, rooms.room_name, houses.house_name')
        ->join('invoices', 'payment_histories.invoice_id', '=', 'invoices.id')
        ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
        ->join('houses', 'rooms.house_id', '=', 'houses.id')
        ->where('payment_histories.deleted', 0)
        ->where('rooms.deleted', 0)
        ->where('invoices.deleted', 0)
        ->where('houses.deleted', 0)
        ->orderBy('payment_histories.created_at', 'desc')->limit($limit)->offset($offset)->get();
    }

    public function getPaymentHistoryCountByUserId($userId) {
        return $this->table($this->table)->where('payer_id', $userId)->where('deleted', 0)->count();
    }

    public function getTotalPaymentHistoryByUserId($userId) {
        return $this->table($this->table)->select('SUM(amount) as total')->where('payer_id', $userId)->where('deleted', 0)->first();
    }

    public function getPaymentHistoryDetail($id) {
        return $this->table($this->table)
            ->select([
                'payment_histories.*',
                'invoices.invoice_name',
                'invoices.invoice_month', 
                'invoices.ref_code',
                'invoices.invoice_status',
                'invoices.due_date',
                'invoices.total as invoice_total',
                'rooms.room_name',
                'houses.house_name',
                'houses.address as house_address',
                'houses.owner_id',
                'users.username as payer_name',
                'users.email as payer_email',
                'users.phone as payer_phone'
            ])
            ->join('invoices', 'payment_histories.invoice_id', '=', 'invoices.id')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->leftJoin('users', 'payment_histories.payer_id', '=', 'users.id')
            ->where('payment_histories.id', $id)
            ->where('payment_histories.deleted', 0)
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0)
            ->where('houses.deleted', 0)
            ->first();
    }
}
