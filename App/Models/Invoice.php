<?php
/*
    Author: Nguyen Xuan Duong
    Date: 2025-09-12
    Purpose: Build Invoice Model
*/

namespace App\Models;

use App\Models\Model;
use Core\QueryBuilder;
use Helpers\Log;

class Invoice extends Model
{
    private $queryBuilder;
	protected $table = 'invoices';
    
    public function __construct()
    {
		parent::__construct();
        $this->queryBuilder = new QueryBuilder();
    }
    
    /**
     * Lấy danh sách hóa đơn theo tháng và năm
     */
    public function getInvoicesByMonth($ownerId, $month, $year, $houseId = null)
    {
        $query = $this->queryBuilder
            ->table('invoices')
            ->select([
                'invoices.id',
                'invoices.invoice_name',
                'invoices.invoice_month',
                'invoices.pay_at',
                'invoices.rental_amount',
                'invoices.electric_amount',
                'invoices.water_amount',
                'invoices.service_amount',
                'invoices.parking_amount',
                'invoices.other_amount',
                'invoices.total',
                'invoices.invoice_status',
                'invoices.ref_code',
                'invoices.note',
                'invoices.created_at',
                'rooms.room_name',
                'users.username as tenant_name',
                'users.phone as tenant_phone'
            ])
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->join('users', 'invoices.user_id', '=', 'users.id')
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.invoice_month', sprintf('%02d-%d', $month, $year))
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0)
            ->where('users.deleted', 0);
            
        if ($houseId) {
            $query->where('houses.id', $houseId);
        }
        
        return $query->orderBy('rooms.room_name', 'ASC')->get();
    }
    
    /**
     * Lấy thống kê hóa đơn theo tháng
     */
    public function getInvoiceStatsByMonth($ownerId, $month, $year, $houseId = null)
    {
        $query = $this->queryBuilder
            ->table('invoices')
            ->select([
                'COUNT(*) as total_invoices',
                'SUM(CASE WHEN invoice_status = "paid" THEN 1 ELSE 0 END) as paid_invoices',
                'SUM(CASE WHEN invoice_status = "pending" THEN 1 ELSE 0 END) as pending_invoices',
                'SUM(CASE WHEN invoice_status = "overdue" THEN 1 ELSE 0 END) as overdue_invoices',
                'SUM(total) as total_amount',
                'SUM(CASE WHEN invoice_status = "paid" THEN total ELSE 0 END) as paid_amount',
                'SUM(CASE WHEN invoice_status = "pending" THEN total ELSE 0 END) as pending_amount',
                'SUM(CASE WHEN invoice_status = "overdue" THEN total ELSE 0 END) as overdue_amount'
            ])
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.invoice_month', sprintf('%02d-%d', $month, $year))
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0);
            
        if ($houseId) {
            $query->where('houses.id', $houseId);
        }
        
        return $query->first();
    }
    
    /**
     * Lấy danh sách hóa đơn theo phòng
     */
    public function getInvoicesByRoom($roomId, $ownerId)
    {
        return $this->queryBuilder
            ->table('invoices')
            ->select([
                'invoices.id',
                'invoices.invoice_name',
                'invoices.invoice_month',
                'invoices.pay_at',
                'invoices.rental_amount',
                'invoices.electric_amount',
                'invoices.water_amount',
                'invoices.service_amount',
                'invoices.parking_amount',
                'invoices.other_amount',
                'invoices.total',
                'invoices.invoice_status',
                'invoices.ref_code',
                'invoices.note',
                'invoices.created_at',
                'rooms.room_name',
                'users.username as tenant_name',
                'users.phone as tenant_phone'
            ])
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->join('users', 'invoices.user_id', '=', 'users.id')
            ->where('invoices.room_id', $roomId)
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0)
            ->where('users.deleted', 0)
            ->orderBy('invoices.invoice_month', 'DESC')
            ->get();
    }
    
    /**
     * Lấy chi tiết hóa đơn
     */
    public function getInvoiceById($invoiceId, $ownerId)
    {
        return $this->queryBuilder
            ->table('invoices')
            ->select([
                'invoices.*',
                'rooms.room_name',
                'houses.house_name',
                'users.username as tenant_name',
                'users.phone as tenant_phone',
                'users.email as tenant_email'
            ])
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->join('users', 'invoices.user_id', '=', 'users.id')
            ->where('invoices.id', $invoiceId)
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0)
            ->where('users.deleted', 0)
            ->first();
    }
    
    /**
     * Cập nhật trạng thái hóa đơn
     */
    public function updateInvoiceStatus($invoiceId, $status, $ownerId)
    {
        return $this->queryBuilder
            ->table('invoices')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('invoices.id', $invoiceId)
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.deleted', 0)
            ->update([
                'invoice_status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
    
    /**
     * Lấy danh sách hóa đơn với thông tin chi tiết cho bảng
     */
    public function getInvoicesForTable($ownerId, $month, $year, $houseId = null)
    {
        $query = $this->queryBuilder
            ->table('invoices')
            ->select([
                'invoices.id',
                'invoices.invoice_name',
                'invoices.invoice_month',
                'invoices.pay_at',
                'invoices.rental_amount',
                'invoices.electric_amount',
                'invoices.water_amount',
                'invoices.service_amount',
                'invoices.parking_amount',
                'invoices.other_amount',
                'invoices.total',
                'invoices.invoice_status',
                'invoices.ref_code',
                'invoices.note',
                'invoices.created_at',
                'rooms.room_name',
                'users.username as tenant_name',
                'users.phone as tenant_phone'
            ])
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->join('users', 'invoices.user_id', '=', 'users.id')
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.invoice_month', sprintf('%02d-%d', $month, $year))
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0)
            ->where('users.deleted', 0);
            
        if ($houseId) {
            $query->where('houses.id', $houseId);
        }
        
        return $query->orderBy('rooms.room_name', 'ASC')->get();
    }
    
    /**
     * Lấy tổng hợp thống kê hóa đơn theo tháng
     */
    public function getMonthlyInvoiceSummary($ownerId, $month, $year, $houseId = null)
    {
        $query = $this->queryBuilder
            ->table('invoices')
            ->select([
                'COUNT(*) as total_invoices',
                'SUM(CASE WHEN invoice_status = "paid" THEN 1 ELSE 0 END) as paid_count',
                'SUM(CASE WHEN invoice_status = "pending" THEN 1 ELSE 0 END) as pending_count',
                'SUM(CASE WHEN invoice_status = "overdue" THEN 1 ELSE 0 END) as overdue_count',
                'SUM(total) as total_amount',
                'SUM(CASE WHEN invoice_status = "paid" THEN total ELSE 0 END) as paid_amount',
                'SUM(CASE WHEN invoice_status = "pending" THEN total ELSE 0 END) as pending_amount',
                'SUM(CASE WHEN invoice_status = "overdue" THEN total ELSE 0 END) as overdue_amount',
                'AVG(total) as average_amount'
            ])
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.invoice_month', sprintf('%02d-%d', $month, $year))
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0);
            
        if ($houseId) {
            $query->where('houses.id', $houseId);
        }
        
        return $query->first();
    }
    
    /**
     * Lấy danh sách phòng đang cho thuê
     */
    public function getRentedRooms($ownerId, $houseId = null)
    {
        $query = $this->queryBuilder
            ->table('rooms')
            ->select([
                'rooms.id',
                'rooms.room_name',
                'rooms.room_price',
                'rooms.room_status',
                'houses.house_name',
                'users.username as tenant_name',
                'users.phone as tenant_phone'
            ])
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->leftJoin('room_tenants', 'rooms.id', '=', 'room_tenants.room_id')
            ->leftJoin('users', 'room_tenants.user_id', '=', 'users.id')
            ->where('houses.owner_id', $ownerId)
            ->where('rooms.room_status', 'occupied')
            ->where('rooms.deleted', 0)
            ->where('houses.deleted', 0);
            
        if ($houseId) {
            $query->where('houses.id', $houseId);
        }
        
        return $query->orderBy('rooms.room_name', 'ASC')->get();
    }
    
    /**
     * Lấy danh sách dịch vụ theo phòng
     */
    public function getRoomServices($roomId, $ownerId)
    {
        return $this->queryBuilder
            ->table('room_services')
            ->select([
                'services.id',
                'services.service_name',
                'services.service_type',
                'services.service_price',
                'services.unit',
                'services.unit_vi',
                'room_services.room_id'
            ])
            ->join('services', 'room_services.service_id', '=', 'services.id')
            ->join('rooms', 'room_services.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('room_services.room_id', $roomId)
            ->where('houses.owner_id', $ownerId)
            ->where('rooms.deleted', 0)
            ->orderBy('services.service_type', 'ASC')
            ->get();
    }
	
	// Added by Huy Nguyen get all invoices
	public function getAllInvoices($data = []) {
        $query = $this->table('invoices')->select('invoices.*, rooms.room_name, houses.house_name')
                        ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
                        ->join('houses', 'rooms.house_id', '=', 'houses.id')->where('invoices.deleted', 0)->where('invoices.user_id', $this->userID);

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if ($value != '') {
                    $query->where($key, $value);
                }
            }
        }
		return $query->get();
	}

	// Added by Huy Nguyen get all invoices by status
	public function getAllInvoicesByStatus($status) {
		return $this->table('invoices')->where('invoice_status', $status)->where('deleted', 0)->where('user_id', $this->userID)->get();
	}

	// Added by Huy Nguyen get total amount
	public function getTotalAmount() {
		return $this->table('invoices')->select('SUM(total) as total')->where('deleted', 0)
            ->where('user_id', $this->userID)->where('invoice_status', 'paid')->first();
	}

	// Added by Huy Nguyen - Phân trang hóa đơn
	public function getAllInvoicesWithPagination($data = [], $limit = 10, $offset = 0) {
        $query = $this->queryBuilder
            ->table('invoices')
            ->select('invoices.*, rooms.room_name, houses.house_name')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('invoices.deleted', 0)
            ->where('invoices.user_id', $this->userID);

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if ($value != '') {
                    $query->where($key, $value);
                }
            }
        }

        return $query->orderBy('invoices.invoice_month', 'DESC')
                    ->limit($limit)
                    ->offset($offset)
                    ->get();
	}

	// Added by Huy Nguyen - Đếm tổng số hóa đơn
	public function getTotalInvoicesCount($data = []) {
        $query = $this->queryBuilder
            ->table('invoices')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('invoices.deleted', 0)
            ->where('invoices.user_id', $this->userID);

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if ($value != '') {
                    $query->where($key, $value);
                }
            }
        }

        return $query->count();
	}

    // Added by Huy Nguyen on 2025-09-14 get invoice by user id
    public function getInvoiceByUserId($invoiceId, $userId) {
        return $this->table('invoices')->where('id', $invoiceId)->where('user_id', $userId)->where('deleted', 0)->first();
    }

    // Added by Huy Nguyen on 2025-09-14 get invoice with room and house info
    public function getInvoiceWithRoomInfo($invoiceId, $userId) {
        return $this->table('invoices')
            ->select('invoices.*, rooms.room_name, houses.house_name, houses.owner_id as owner_id')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('invoices.id', $invoiceId)
            ->where('invoices.user_id', $userId)
            ->where('invoices.deleted', 0)
            ->first();
    }

    // Added by Huy Nguyen on 2025-09-17 update invoice status
    public function updateInvoiceOnlyStatus($invoiceId, $status) {
        Log::payment('Cập nhật trạng thái hóa đơn: ' . $invoiceId . ' - ' . $status, Log::LEVEL_INFO);
        return $this->table('invoices')->update(['invoice_status' => $status])->where('id', $invoiceId)->where('deleted', 0);
    }
}

