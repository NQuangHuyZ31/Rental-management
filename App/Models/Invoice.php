<?php
/*
    Author: Nguyen Xuan Duong
    Date: 2025-09-12
    Purpose: Build Invoice Model
*/

namespace App\Models;

use App\Models\Model;
use Core\QueryBuilder;

class Invoice extends Model
{
    protected $table = 'invoices';
    private $queryBuilder;
    
    public function __construct()
    {
        $this->queryBuilder = new QueryBuilder();
    }
    
    /**
     * Lấy danh sách hóa đơn theo tháng và năm
     */
    public function getInvoicesByMonth($ownerId, $month, $year, $houseId = null)
    {
        $query = $this->queryBuilder
            ->table($this->table)
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
            ->leftJoin('users', 'invoices.user_id', '=', 'users.id')
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.invoice_month', sprintf('%02d-%d', $month, $year))
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0);
            
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
            ->table($this->table)
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
            ->leftJoin('users', 'invoices.user_id', '=', 'users.id')
            ->where('invoices.room_id', $roomId)
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0)
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
            ->leftJoin('users', 'invoices.user_id', '=', 'users.id')
            ->where('invoices.id', $invoiceId)
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0)
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
     * Cập nhật thông tin hóa đơn
     */
    public function updateInvoice($invoiceId, $data, $ownerId)
    {
        // Kiểm tra quyền sở hữu hóa đơn
        $invoice = $this->queryBuilder
            ->table('invoices')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('invoices.id', $invoiceId)
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.deleted', 0)
            ->first();
            
        if (!$invoice) {
            return false;
        }
        
        // Chuẩn bị dữ liệu cập nhật
        $updateData = [
            'invoice_name' => $data['invoice_name'] ?? $invoice['invoice_name'],
            'invoice_month' => $data['invoice_month'] ?? $invoice['invoice_month'],
            'invoice_day' => $data['invoice_day'] ?? $invoice['invoice_day'],
            'due_date' => $data['due_date'] ?? $invoice['due_date'],
            'note' => $data['note'] ?? $invoice['note'],
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Cập nhật hóa đơn
        $result = $this->queryBuilder
            ->table('invoices')
            ->where('id', $invoiceId)
            ->update($updateData);
            
        // Cập nhật dịch vụ nếu có
        if (isset($data['services']) && is_array($data['services'])) {
            $this->updateInvoiceServices($invoiceId, $data['services'], $ownerId);
        }
        
        // Tính lại tổng tiền
        $this->recalculateInvoiceTotal($invoiceId, $ownerId);
            
        return $result;
    }
    
    /**
     * Cập nhật thông tin dịch vụ của hóa đơn
     */
    public function updateInvoiceServices($invoiceId, $services, $ownerId)
    {
        // Lấy thông tin invoice
        $invoice = $this->queryBuilder
            ->table('invoices')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('invoices.id', $invoiceId)
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.deleted', 0)
            ->first();
            
        if (!$invoice) {
            return false;
        }
        
        foreach ($services as $serviceUsageId => $serviceData) {
            // Lấy thông tin service để biết loại dịch vụ
            $serviceUsage = $this->queryBuilder
                ->table('service_usages')
                ->select(['unit_price', 'service_id'])
                ->join('services', 'service_usages.service_id', '=', 'services.id')
                ->where('service_usages.id', $serviceUsageId)
                ->where('service_usages.room_id', $invoice['room_id'])
                ->where('service_usages.month_year', $invoice['invoice_month'])
                ->first();
                
            if ($serviceUsage) {
                $unitPrice = $serviceUsage['unit_price'] ?? 0;
                $serviceId = $serviceUsage['service_id'];
                
                // Lấy thông tin loại dịch vụ
                $serviceInfo = $this->queryBuilder
                    ->table('services')
                    ->select(['service_type'])
                    ->where('id', $serviceId)
                    ->first();
                
                $serviceType = $serviceInfo['service_type'] ?? '';
                
                // Tính usage_amount dựa trên loại dịch vụ
                $usageAmount = 0;
                if ($serviceType === 'electric' || $serviceType === 'water') {
                    // Điện/nước: usage_amount = new_value - old_value
                    $oldValue = floatval($serviceData['old_value'] ?? 0);
                    $newValue = floatval($serviceData['new_value'] ?? 0);
                    $usageAmount = max(0, $newValue - $oldValue);
                } else {
                    // Dịch vụ khác: dùng usage_amount trực tiếp
                    $usageAmount = floatval($serviceData['usage_amount'] ?? 0);
                }
                
                // Tính total_amount
                $totalAmount = $usageAmount * $unitPrice;
                
                // Cập nhật service_usage
                $this->queryBuilder
                    ->table('service_usages')
                    ->where('id', $serviceUsageId)
                    ->update([
                        'old_value' => $serviceData['old_value'] ?? null,
                        'new_value' => $serviceData['new_value'] ?? null,
                        'usage_amount' => $usageAmount,
                        'total_amount' => $totalAmount,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
            }
        }
        
        return true;
    }
    
    /**
     * Tính lại tổng tiền hóa đơn
     */
    public function recalculateInvoiceTotal($invoiceId, $ownerId)
    {
        // Lấy thông tin invoice
        $invoice = $this->queryBuilder
            ->table('invoices')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('invoices.id', $invoiceId)
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.deleted', 0)
            ->first();
            
        if (!$invoice) {
            return false;
        }
        
        // Tính tổng tiền dịch vụ
        $serviceTotal = $this->queryBuilder
            ->table('service_usages')
            ->select('SUM(total_amount) as total')
            ->where('room_id', $invoice['room_id'])
            ->where('month_year', $invoice['invoice_month'])
            ->first();
            
        $serviceAmount = $serviceTotal['total'] ?? 0;
        
        // Cập nhật tổng tiền
        $totalAmount = $invoice['rental_amount'] + $serviceAmount;
        
        $this->queryBuilder
            ->table('invoices')
            ->where('id', $invoiceId)
            ->update([
                'service_amount' => $serviceAmount,
                'total' => $totalAmount,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
        return true;
    }
    
    /**
     * Lấy danh sách hóa đơn với thông tin chi tiết cho bảng
     */
    public function getInvoicesForTable($ownerId, $month, $year, $houseId = null)
    {
        $query = $this->queryBuilder
            ->table($this->table)
            ->select([
                'invoices.id',
                'invoices.invoice_name',
                'invoices.invoice_month',
                'invoices.pay_at',
                'invoices.rental_amount',
                'invoices.electric_amount',
                'invoices.water_amount',
                'invoices.internet_amount',
                'invoices.parking_amount',
                'invoices.garbage_amount',
                'invoices.service_amount',
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
            ->leftJoin('users', 'invoices.user_id', '=', 'users.id')
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.invoice_month', sprintf('%02d-%d', $month, $year))
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0);
            
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
            ->table($this->table)
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
     * Lấy chi tiết hóa đơn để hiển thị
     */
    public function getInvoiceForDisplay($invoiceId, $ownerId)
    {
        return $this->queryBuilder
            ->table('invoices')
            ->select([
                'invoices.id',
                'invoices.invoice_name',
                'invoices.invoice_month',
                'invoices.invoice_day',
                'invoices.due_date',
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
                'houses.house_name',
                'houses.address as house_address',
                'users.username as tenant_name',
                'users.phone as tenant_phone',
                'users.email as tenant_email'
            ])
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->leftJoin('users', 'invoices.user_id', '=', 'users.id')
            ->where('invoices.id', $invoiceId)
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0)
            ->first();
    }
    
    /**
     * Lấy danh sách dịch vụ chi tiết của hóa đơn
     */
    public function getInvoiceServiceDetails($invoiceId, $ownerId)
    {
        // Lấy thông tin invoice trước để có room_id và invoice_month
        $invoice = $this->queryBuilder
            ->table('invoices')
            ->select(['room_id', 'invoice_month'])
            ->where('id', $invoiceId)
            ->first();
            
        if (!$invoice) {
            return [];
        }
        
        return $this->queryBuilder
            ->table('service_usages')
            ->select([
                'service_usages.id',
                'services.service_name',
                'services.service_type',
                'services.unit_vi',
                'service_usages.old_value',
                'service_usages.new_value',
                'service_usages.usage_amount',
                'service_usages.unit_price',
                'service_usages.total_amount'
            ])
            ->join('services', 'service_usages.service_id', '=', 'services.id')
            ->join('rooms', 'service_usages.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('service_usages.room_id', $invoice['room_id'])
            ->where('service_usages.month_year', $invoice['invoice_month'])
            ->where('houses.owner_id', $ownerId)
            ->where('rooms.deleted', 0)
            ->orderBy('services.service_type', 'ASC')
            ->get();
    }
    
    /**
     * Tạo hóa đơn mới
     */
    public function createInvoice($data, $ownerId)
    {
        try {
            // Bắt đầu transaction
            $this->queryBuilder->beginTransaction();
            
            // Lấy thông tin phòng để kiểm tra quyền
            $room = $this->queryBuilder
                ->table('rooms')
                ->select(['rooms.id', 'rooms.room_price', 'rooms.house_id'])
                ->join('houses', 'rooms.house_id', '=', 'houses.id')
                ->where('rooms.id', $data['room_id'])
                ->where('houses.owner_id', $ownerId)
                ->where('rooms.deleted', 0)
                ->first();
                
            if (!$room) {
                throw new \Exception('Không tìm thấy phòng hoặc bạn không có quyền tạo hóa đơn');
            }
            
            // Tính toán tổng tiền dịch vụ
            $totalServiceAmount = 0;
            $electricAmount = 0;
            $waterAmount = 0;
            $internetAmount = 0;
            $parkingAmount = 0;
            $garbageAmount = 0;
            $otherAmount = 0;
            
            // Xử lý dịch vụ nếu có
            if (!empty($data['services']) && is_array($data['services'])) {
                foreach ($data['services'] as $serviceId => $serviceData) {
                    if (!empty($serviceData['enabled'])) {
                        $service = $this->queryBuilder
                            ->table('services')
                            ->where('id', $serviceId)
                            ->where('house_id', $room['house_id'])
                            ->first();
                            
                        if ($service) {
                            $unitPrice = $service['service_price'];
                            $totalAmount = 0;
                            
                            if ($service['unit'] === 'KWH' || $service['unit'] === 'm3') {
                                // Dịch vụ theo đồng hồ (điện, nước)
                                $oldValue = (float)($serviceData['old_value'] ?? 0);
                                $newValue = (float)($serviceData['new_value'] ?? 0);
                                $usage = $newValue - $oldValue;
                                $totalAmount = $usage * $unitPrice;
                                
                                // Phân loại theo service_type
                                switch ($service['service_type']) {
                                    case 'electric':
                                        $electricAmount += $totalAmount;
                                        break;
                                    case 'water':
                                        $waterAmount += $totalAmount;
                                        break;
                                    case 'internet':
                                        $internetAmount += $totalAmount;
                                        break;
                                    case 'parking':
                                        $parkingAmount += $totalAmount;
                                        break;
                                    case 'garbage':
                                        $garbageAmount += $totalAmount;
                                        break;
                                    case 'other':
                                    default:
                                        $otherAmount += $totalAmount;
                                        break;
                                }
                                
                                // Lưu dữ liệu sử dụng dịch vụ
                                $this->queryBuilder
                                    ->table('service_usages')
                                    ->insert([
                                        'room_id' => $data['room_id'],
                                        'service_id' => $serviceId,
                                        'month_year' => $data['invoice_month'],
                                        'old_value' => $oldValue,
                                        'new_value' => $newValue,
                                        'usage_amount' => $usage,
                                        'unit_price' => $unitPrice,
                                        'total_amount' => $totalAmount,
                                        'created_at' => date('Y-m-d H:i:s')
                                    ]);
                            } else {
                                // Dịch vụ theo số lượng
                                $usageAmount = (float)($serviceData['usage_amount'] ?? 1);
                                $totalAmount = $usageAmount * $unitPrice;
                                
                                // Phân loại theo service_type
                                switch ($service['service_type']) {
                                    case 'electric':
                                        $electricAmount += $totalAmount;
                                        break;
                                    case 'water':
                                        $waterAmount += $totalAmount;
                                        break;
                                    case 'internet':
                                        $internetAmount += $totalAmount;
                                        break;
                                    case 'parking':
                                        $parkingAmount += $totalAmount;
                                        break;
                                    case 'garbage':
                                        $garbageAmount += $totalAmount;
                                        break;
                                    case 'other':
                                    default:
                                        $otherAmount += $totalAmount;
                                        break;
                                }
                                
                                // Lưu dữ liệu sử dụng dịch vụ
                                $this->queryBuilder
                                    ->table('service_usages')
                                    ->insert([
                                        'room_id' => $data['room_id'],
                                        'service_id' => $serviceId,
                                        'month_year' => $data['invoice_month'],
                                        'old_value' => null,
                                        'new_value' => null,
                                        'usage_amount' => $usageAmount,
                                        'unit_price' => $unitPrice,
                                        'total_amount' => $totalAmount,
                                        'created_at' => date('Y-m-d H:i:s')
                                    ]);
                            }
                            
                            $totalServiceAmount += $totalAmount;
                        }
                    }
                }
            }
            
            // Tính tổng tiền hóa đơn
            $rentalAmount = (float)$data['rental_amount'];
            $total = $rentalAmount + $electricAmount + $waterAmount + $internetAmount + $parkingAmount + $garbageAmount + $otherAmount;
            
            // Tạo hóa đơn
            $invoiceData = [
                'room_id' => $data['room_id'],
                'user_id' => null, // Sẽ cập nhật khi có khách thuê
                'invoice_name' => $data['invoice_name'],
                'invoice_month' => $data['invoice_month'],
                'invoice_day' => $data['invoice_day'],
                'due_date' => $data['due_date'],
                'rental_amount' => $rentalAmount,
                'electric_amount' => $electricAmount,
                'water_amount' => $waterAmount,
                'internet_amount' => $internetAmount,
                'parking_amount' => $parkingAmount,
                'garbage_amount' => $garbageAmount,
                'other_amount' => $otherAmount,
                'total' => $total,
                'invoice_status' => 'pending',
                'ref_code' => 'INV' . date('Ymd') . rand(1000, 9999),
                'note' => $data['note'] ?? '',
                'pay_at' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $result = $this->queryBuilder
                ->table($this->table)
                ->insert($invoiceData);
                
            if ($result) {
                $this->queryBuilder->commit();
                return true;
            } else {
                $this->queryBuilder->rollback();
                return false;
            }
            
        } catch (\Exception $e) {
            $this->queryBuilder->rollback();
            throw $e;
        }
    }
    
}

