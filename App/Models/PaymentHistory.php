<?php

namespace App\Models;

use App\Models\Model;
use Core\QueryBuilder;

class PaymentHistory extends Model
{
    private $queryBuilder;
    protected $table = 'payment_history';
    
    public function __construct()
    {
        parent::__construct();
        $this->queryBuilder = new QueryBuilder();
    }

    /**
     * Tạo bản ghi thanh toán mới
     */
    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->queryBuilder
            ->table($this->table)
            ->insert($data);
    }

    /**
     * Cập nhật thông tin thanh toán
     */
    public function updatePayment($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->queryBuilder
            ->table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    /**
     * Lấy thông tin thanh toán theo ID
     */
    public function getById($id)
    {
        return $this->queryBuilder
            ->table($this->table)
            ->where('id', $id)
            ->where('deleted', 0)
            ->first();
    }

    /**
     * Lấy lịch sử thanh toán của người dùng
     */
    public function getUserPayments($userId, $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        
        $payments = $this->queryBuilder
            ->table($this->table)
            ->select([
                'payment_history.id',
                'payment_history.invoice_id',
                'payment_history.amount',
                'payment_history.order_id',
                'payment_history.payment_method',
                'payment_history.status',
                'payment_history.payment_time',
                'payment_history.created_at',
                'invoices.invoice_name',
                'invoices.invoice_month',
                'invoices.total as invoice_total'
            ])
            ->join('invoices', 'payment_history.invoice_id', '=', 'invoices.id')
            ->where('payment_history.user_id', $userId)
            ->where('payment_history.deleted', 0)
            ->where('invoices.deleted', 0)
            ->orderBy('payment_history.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get();

        // Đếm tổng số bản ghi
        $total = $this->queryBuilder
            ->table($this->table)
            ->join('invoices', 'payment_history.invoice_id', '=', 'invoices.id')
            ->where('payment_history.user_id', $userId)
            ->where('payment_history.deleted', 0)
            ->where('invoices.deleted', 0)
            ->count();

        return [
            'payments' => $payments,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $total,
                'total_pages' => ceil($total / $limit)
            ]
        ];
    }

    /**
     * Lấy thông tin chi tiết thanh toán
     */
    public function getPaymentDetail($paymentId, $userId)
    {
        return $this->queryBuilder
            ->table($this->table)
            ->select([
                'payment_history.*',
                'invoices.invoice_name',
                'invoices.invoice_month',
                'invoices.rental_amount',
                'invoices.electric_amount',
                'invoices.water_amount',
                'invoices.service_amount',
                'invoices.parking_amount',
                'invoices.other_amount',
                'invoices.total as invoice_total',
                'invoices.invoice_status',
                'invoices.ref_code',
                'invoices.note',
                'rooms.room_name',
                'houses.house_name',
                'users.username as tenant_name',
                'users.phone as tenant_phone',
                'users.email as tenant_email'
            ])
            ->join('invoices', 'payment_history.invoice_id', '=', 'invoices.id')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->join('users', 'invoices.user_id', '=', 'users.id')
            ->where('payment_history.id', $paymentId)
            ->where('payment_history.user_id', $userId)
            ->where('payment_history.deleted', 0)
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0)
            ->where('users.deleted', 0)
            ->first();
    }

    /**
     * Lấy thanh toán theo order_id
     */
    public function getByOrderId($orderId)
    {
        return $this->queryBuilder
            ->table($this->table)
            ->where('order_id', $orderId)
            ->where('deleted', 0)
            ->first();
    }

    /**
     * Lấy thanh toán theo trạng thái
     */
    public function getPaymentsByStatus($userId, $status, $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        
        $payments = $this->queryBuilder
            ->table($this->table)
            ->select([
                'payment_history.id',
                'payment_history.invoice_id',
                'payment_history.amount',
                'payment_history.order_id',
                'payment_history.payment_method',
                'payment_history.status',
                'payment_history.payment_time',
                'payment_history.created_at',
                'invoices.invoice_name',
                'invoices.invoice_month',
                'invoices.total as invoice_total'
            ])
            ->join('invoices', 'payment_history.invoice_id', '=', 'invoices.id')
            ->where('payment_history.user_id', $userId)
            ->where('payment_history.status', $status)
            ->where('payment_history.deleted', 0)
            ->where('invoices.deleted', 0)
            ->orderBy('payment_history.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get();

        // Đếm tổng số bản ghi
        $total = $this->queryBuilder
            ->table($this->table)
            ->join('invoices', 'payment_history.invoice_id', '=', 'invoices.id')
            ->where('payment_history.user_id', $userId)
            ->where('payment_history.status', $status)
            ->where('payment_history.deleted', 0)
            ->where('invoices.deleted', 0)
            ->count();

        return [
            'payments' => $payments,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $total,
                'total_pages' => ceil($total / $limit)
            ]
        ];
    }

    /**
     * Lấy thống kê thanh toán của người dùng
     */
    public function getPaymentStats($userId)
    {
        return $this->queryBuilder
            ->table($this->table)
            ->select([
                'COUNT(*) as total_payments',
                'SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_payments',
                'SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_payments',
                'SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed_payments',
                'SUM(CASE WHEN status = "completed" THEN amount ELSE 0 END) as total_paid_amount',
                'SUM(CASE WHEN status = "pending" THEN amount ELSE 0 END) as pending_amount',
                'AVG(CASE WHEN status = "completed" THEN amount ELSE NULL END) as average_payment'
            ])
            ->where('user_id', $userId)
            ->where('deleted', 0)
            ->first();
    }

    /**
     * Xóa thanh toán (soft delete)
     */
    public function deletePayment($id)
    {
        return $this->queryBuilder
            ->table($this->table)
            ->where('id', $id)
            ->update([
                'deleted' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    /**
     * Lấy tất cả thanh toán đang chờ
     */
    public function getPendingPayments()
    {
        return $this->queryBuilder
            ->table($this->table)
            ->where('status', 'pending')
            ->where('deleted', 0)
            ->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-24 hours')))
            ->get();
    }

    /**
     * Đếm số thanh toán đang chờ
     */
    public function countPendingPayments()
    {
        return $this->queryBuilder
            ->table($this->table)
            ->where('status', 'pending')
            ->where('deleted', 0)
            ->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-24 hours')))
            ->count();
    }

    /**
     * Đếm số thanh toán hoàn thành hôm nay
     */
    public function countCompletedToday()
    {
        return $this->queryBuilder
            ->table($this->table)
            ->where('status', 'completed')
            ->where('deleted', 0)
            ->where('DATE(payment_time)', date('Y-m-d'))
            ->count();
    }

    /**
     * Lấy tổng số tiền thanh toán hôm nay
     */
    public function getTotalAmountToday()
    {
        $result = $this->queryBuilder
            ->table($this->table)
            ->select(['SUM(amount) as total'])
            ->where('status', 'completed')
            ->where('deleted', 0)
            ->where('DATE(payment_time)', date('Y-m-d'))
            ->first();

        return $result['total'] ?? 0;
    }
}
