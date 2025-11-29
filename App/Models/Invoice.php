<?php
/*
Author: Nguyen Xuan Duong
Date: 2025-09-12
Purpose: Build Invoice Model
 */

namespace App\Models;

use App\Models\Model;
use Core\QueryBuilder;

class Invoice extends Model {
    protected $table = 'invoices';
    private $queryBuilder;

    public function __construct() {
        parent::__construct();
        $this->queryBuilder = new QueryBuilder();
    }

    /**
     * Lấy danh sách hóa đơn theo tháng và năm
     */
    public function getInvoicesByMonth($ownerId, $month, $year, $houseId = null) {
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
                'users.phone as tenant_phone',
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
    public function getInvoiceStatsByMonth($ownerId, $month, $year, $houseId = null) {
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
                'SUM(CASE WHEN invoice_status = "overdue" THEN total ELSE 0 END) as overdue_amount',
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
    public function getInvoicesByRoom($roomId, $ownerId) {
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
                'users.phone as tenant_phone',
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
    public function getInvoiceById($invoiceId, $ownerId = '') {
        // Modify by Huy Nguyen on 2025-10-24 to support if no ownerId
        $query = $this->queryBuilder
            ->table('invoices')
            ->select([
                'invoices.*',
                'rooms.id as room_id',
                'rooms.room_name',
                'houses.id as house_id',
                'houses.house_name',
                'users.username as tenant_name',
                'users.phone as tenant_phone',
                'users.email as tenant_email',
                'houses.owner_id'
            ])
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->leftJoin('users', 'invoices.user_id', '=', 'users.id')
            ->where('invoices.id', $invoiceId);

        if (!empty($ownerId)) {
            $query->where('houses.owner_id', $ownerId);
        }

        return $query->where('invoices.deleted', 0)
            ->where('rooms.deleted', 0)
            ->first();
    }

    /**
     * Cập nhật trạng thái hóa đơn
     */
    public function updateInvoiceStatus($invoiceId, $status, $ownerId) {
        // First verify ownership by checking if the invoice belongs to the owner
        $invoice = $this->queryBuilder
            ->table('invoices')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('invoices.id', $invoiceId)
            ->where('houses.owner_id', $ownerId)
            ->where('invoices.deleted', 0)
            ->select('invoices.id')
            ->first();

        if (!$invoice) {
            return false;
        }

        // If ownership is verified, update the invoice status
        return $this->queryBuilder
            ->table('invoices')
            ->where('id', $invoiceId)
            ->where('deleted', 0)
            ->update([
                'invoice_status' => $status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
    }

    /**
     * Cập nhật thông tin hóa đơn
     */
    public function updateInvoice($invoiceId, $data, $ownerId) {
        try {
            // Bắt đầu transaction
            $this->queryBuilder->beginTransaction();
            
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
                $this->queryBuilder->rollback();
                return false;
            }

            // Chuẩn bị dữ liệu cập nhật
            $updateData = [
                'invoice_name' => $data['invoice_name'] ?? $invoice['invoice_name'],
                'invoice_month' => $data['invoice_month'] ?? $invoice['invoice_month'],
                'invoice_day' => $data['invoice_day'] ?? $invoice['invoice_day'],
                'due_date' => $data['due_date'] ?? $invoice['due_date'],
                'note' => $data['note'] ?? $invoice['note'],
                'updated_at' => date('Y-m-d H:i:s'),
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

            // Commit transaction
            $this->queryBuilder->commit();
            
            return $result;
            
        } catch (\Exception $e) {
            $this->queryBuilder->rollback();
            throw $e;
        }
    }

    /**
     * Cập nhật thông tin dịch vụ của hóa đơn
     */
    public function updateInvoiceServices($invoiceId, $services, $ownerId) {
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

                // Lấy thông tin loại dịch vụ và đơn vị tính
                $serviceInfo = $this->queryBuilder
                    ->table('services')
                    ->select(['service_type', 'unit'])
                    ->where('id', $serviceId)
                    ->first();

                $serviceType = $serviceInfo['service_type'] ?? '';
                $serviceUnit = $serviceInfo['unit'] ?? '';

                // Tính usage_amount dựa trên đơn vị tính
                $usageAmount = 0;
                if ($serviceUnit === 'KWH' || $serviceUnit === 'm3') {
                    // Điện (KWH) hoặc Nước theo đồng hồ (m3): usage_amount = new_value - old_value
                    $oldValue = floatval($serviceData['old_value'] ?? 0);
                    $newValue = floatval($serviceData['new_value'] ?? 0);
                    $usageAmount = max(0, $newValue - $oldValue);
                } else {
                    // Dịch vụ theo người/tháng: dùng usage_amount trực tiếp
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
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            }
        }

        return true;
    }

    /**
     * Tính lại tổng tiền hóa đơn
     */
    public function recalculateInvoiceTotal($invoiceId, $ownerId) {
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

        // Lấy tất cả service_usages với service_type
        $services = $this->queryBuilder
            ->table('service_usages')
            ->select([
                'service_usages.total_amount',
                'services.service_type'
            ])
            ->join('services', 'service_usages.service_id', '=', 'services.id')
            ->where('service_usages.room_id', $invoice['room_id'])
            ->where('service_usages.month_year', $invoice['invoice_month'])
            ->get();

        // Tính tổng theo từng loại dịch vụ
        $electricAmount = 0;
        $waterAmount = 0;
        $internetAmount = 0;
        $parkingAmount = 0;
        $garbageAmount = 0;
        $otherAmount = 0;

        foreach ($services as $service) {
            $amount = $service['total_amount'] ?? 0;
            switch ($service['service_type']) {
                case 'electric':
                    $electricAmount += $amount;
                    break;
                case 'water':
                    $waterAmount += $amount;
                    break;
                case 'internet':
                    $internetAmount += $amount;
                    break;
                case 'parking':
                    $parkingAmount += $amount;
                    break;
                case 'garbage':
                    $garbageAmount += $amount;
                    break;
                default:
                    $otherAmount += $amount;
                    break;
            }
        }

        $serviceAmount = $electricAmount + $waterAmount + $internetAmount + $parkingAmount + $garbageAmount + $otherAmount;
        $totalAmount = $invoice['rental_amount'] + $serviceAmount;

        // Cập nhật tất cả các cột
        $this->queryBuilder
            ->table('invoices')
            ->where('id', $invoiceId)
            ->update([
                'electric_amount' => $electricAmount,
                'water_amount' => $waterAmount,
                'internet_amount' => $internetAmount,
                'parking_amount' => $parkingAmount,
                'garbage_amount' => $garbageAmount,
                'other_amount' => $otherAmount,
                'service_amount' => $serviceAmount,
                'total' => $totalAmount,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        return true;
    }

    /**
     * Lấy danh sách hóa đơn với thông tin chi tiết cho bảng
     */
    public function getInvoicesForTable($ownerId, $month, $year, $houseId = null) {
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
                'users.phone as tenant_phone',
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
    public function getMonthlyInvoiceSummary($ownerId, $month, $year, $houseId = null) {
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
                'AVG(total) as average_amount',
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
    public function getInvoiceForDisplay($invoiceId, $ownerId) {
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
                'rooms.room_price',
                'houses.house_name',
                'houses.address as house_address',
                'users.username as tenant_name',
                'users.phone as tenant_phone',
                'users.email as tenant_email',
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
    public function getInvoiceServiceDetails($invoiceId, $ownerId) {
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
                'service_usages.total_amount',
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
    public function createInvoice($data, $ownerId) {
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
                                $oldValue = (float) ($serviceData['old_value'] ?? 0);
                                $newValue = (float) ($serviceData['new_value'] ?? 0);
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
                                        'created_at' => date('Y-m-d H:i:s'),
                                    ]);
                            } else {
                                // Dịch vụ theo số lượng
                                $usageAmount = (float) ($serviceData['usage_amount'] ?? 1);
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
                                        'created_at' => date('Y-m-d H:i:s'),
                                    ]);
                            }

                            $totalServiceAmount += $totalAmount;
                        }
                    }
                }
            }

            // Tính tổng tiền hóa đơn
            $rentalAmount = (float) $data['rental_amount'];
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
                'updated_at' => date('Y-m-d H:i:s'),
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

    /**
     * Xóa hóa đơn
     */
    public function deleteInvoice($invoiceId) {
        return $this->queryBuilder
            ->table($this->table)
            ->where('id', $invoiceId)
            ->update(['deleted' => 1]);
    }

    // Added by Huy Nguyen get all invoices
    public function getAllInvoices($data = []) {
        $query = $this->table('invoices')->select('invoices.*, rooms.room_name, houses.house_name, room_tenants.user_id as tenant_id')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->join('room_tenants', 'rooms.id', '=', 'room_tenants.room_id')
            ->where('invoices.deleted', 0)->where('room_tenants.user_id', $this->userID);

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
        return $this->table('invoices')
            ->join('room_tenants', 'invoices.room_id', '=', 'room_tenants.room_id')
            ->where('invoice_status', $status)->where('deleted', 0)->where('room_tenants.user_id', $this->userID)->get();
    }

    // Added by Huy Nguyen get total amount
    public function getTotalAmount() {
        return $this->table('invoices')->select('SUM(total) as total')->where('deleted', 0)
            ->where('user_id', $this->userID)->where('invoice_status', 'paid')->first();
    }

    // Added by Huy Nguyen - Phân trang hóa đơn
    public function getAllInvoicesWithPagination($data = [], $limit = 10, $offset = 0, $orderBy = 'created_at', $sort = 'DESC') {
        $query = $this->queryBuilder
            ->table('invoices')
            ->select('invoices.*, rooms.room_name, rooms.area, houses.house_name, room_tenants.user_id as tenant_id')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->join('room_tenants', 'rooms.id', '=', 'room_tenants.room_id')
            ->where('invoices.deleted', 0)
            ->where('room_tenants.user_id', $this->userID);

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if ($value != '') {
                    $query->where($key, $value);
                }
            }
        }

        return $query->orderBy('invoices.' . $orderBy, $sort)
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    // Added by Huy Nguyen - Đếm tổng số hóa đơn
    public function getTotalInvoicesCount($data = []) {
        $query = $this->queryBuilder
            ->table('invoices')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('room_tenants', 'rooms.id', '=', 'room_tenants.room_id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('invoices.deleted', 0)
            ->where('room_tenants.user_id', $this->userID);

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
    public function getInvoiceByInvoiceId($invoiceId) {
        return $this->table('invoices')->where('id', $invoiceId)->where('deleted', 0)->first();
    }

    // Added by Huy Nguyen on 2025-09-14 get invoice with room and house info
    public function getInvoiceWithRoomInfo($invoiceId) {
        return $this->table('invoices')
            ->select('invoices.*, rooms.room_name, houses.house_name, houses.owner_id as owner_id')
            ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
            ->join('houses', 'rooms.house_id', '=', 'houses.id')
            ->where('invoices.id', $invoiceId)
            ->where('invoices.deleted', 0)
            ->first();
    }

    // Added by Huy Nguyen on 2025-09-17 update invoice status
    public function updateInvoiceOnlyStatus($invoiceId, $status) {
        return $this->table('invoices')->where('id', $invoiceId)->where('deleted', 0)->update(['invoice_status' => $status]);
    }

    // Added by Huy Nguyen on 2025-10-24 to get invoice by roomid and month
    public function getInvoiceByRoomIdAndMonth($roomId = '', $month = '') {
        $query = $this->table('invoices')->where('deleted', 0);

        if (!empty($roomId)) {
            $query->where('room_id', $roomId);
        }

        if (!empty($month)) {
            $query->where('invoice_month', $month);
        }

        return $query->first();
    }

    /**
     * Added by Nguyen Xuan Duong on 2025-11-05 to get latest service readings
     */
    public function getLatestServiceReadings($roomId, $ownerId) {
        try {
            // Lấy hóa đơn mới nhất của phòng
            $latestInvoice = $this->queryBuilder
                ->table('invoices')
                ->select([
                    'invoices.id',
                    'invoices.invoice_month',
                    'invoices.created_at'
                ])
                ->join('rooms', 'invoices.room_id', '=', 'rooms.id')
                ->join('houses', 'rooms.house_id', '=', 'houses.id')
                ->where('invoices.room_id', $roomId)
                ->where('houses.owner_id', $ownerId)
                ->where('invoices.deleted', 0)
                ->orderBy('invoices.created_at', 'DESC')
                ->first();

            if (!$latestInvoice) {
                return [];
            }

            // Lấy các chỉ số dịch vụ từ tháng của hóa đơn đó
            $serviceReadings = $this->queryBuilder
                ->table('service_usages')
                ->select([
                    'service_usages.service_id',
                    'service_usages.new_value',
                    'services.service_name',
                    'services.service_type'
                ])
                ->join('services', 'service_usages.service_id', '=', 'services.id')
                ->where('service_usages.room_id', $roomId)
                ->where('service_usages.month_year', $latestInvoice['invoice_month'])
                ->get();

            return $serviceReadings ?: [];
        } catch (\Exception $e) {
            return [];
        }
    }
}


