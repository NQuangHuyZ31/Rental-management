<?php

/*
* Author: Huy Nguyen
* Date: 2025-01-15
* Purpose: Validation Helper
*/

namespace Helpers;

class Validate
{
    /**
     * Validate email format
     * 
     * @param string $email
     * @return bool
     */
    public static function email($email)
    {
        if (empty($email)) {
            return false;
        }
        
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Validate Vietnamese phone number
     * Supports formats: 09xxxxxxxx, 08xxxxxxxx, 07xxxxxxxx, 03xxxxxxxx, 05xxxxxxxx
     * 
     * @param string $phone
     * @return bool
     */
    public static function phone($phone)
    {
        if (empty($phone)) {
            return false;
        }
        
        // Remove all non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Check if phone number starts with 0 and has 10 digits
        if (strlen($phone) === 10 && $phone[0] === '0') {
        // Check valid prefixes for Vietnamese mobile numbers
        $validPrefixes = ['032', '033', '034', '035', '036', '037', '038', '039', // Viettel
                         '070', '076', '077', '078', '079', // Mobifone
                         '081', '082', '083', '084', '085', // Vinaphone
                         '056', '058', // Vietnamobile
                         '059', // Gmobile
                         '012', '013', '014', '015', '016', '017', '018', '019', // Viettel
                         '020', '021', '022', '023', '024', '025', '026', '027', '028', '029', // Viettel
                         '030', '031', // Viettel
                         '080', '086', '087', '088', '089', // Vinaphone
                         '090', '091', '092', '093', '094', '095', '096', '097', '098', '099']; // Mobifone
            
            $prefix = substr($phone, 0, 3);
            return in_array($prefix, $validPrefixes);
        }
        
        return false;
    }
    
    /**
     * Validate Vietnamese Citizen ID (CCCD only)
     * Only supports 12-digit CCCD
     * 
     * @param string $citizenId
     * @return bool
     */
    public static function citizenId($citizenId)
    {
        if (empty($citizenId)) {
            return false;
        }
        
        // Remove all non-digit characters
        $citizenId = preg_replace('/[^0-9]/', '', $citizenId);
        
        // Check length (only 12 digits for CCCD)
        if (strlen($citizenId) === 12) {
            // CCCD validation (12 digits)
            return self::validateCCCD($citizenId);
        }
        
        return false;
    }
    
    /**
     * Validate CMND (9 digits)
     * 
     * @param string $cmnd
     * @return bool
     */
    private static function validateCMND($cmnd)
    {
        // Check if all characters are digits
        if (!ctype_digit($cmnd)) {
            return false;
        }
        
        // Basic format check for CMND
        // CMND should not be all zeros
        if (intval($cmnd) === 0) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Validate CCCD (12 digits)
     * 
     * @param string $cccd
     * @return bool
     */
    private static function validateCCCD($cccd)
    {
        // Check if all characters are digits
        if (!ctype_digit($cccd)) {
            return false;
        }
        
        // Basic format check for CCCD
        // CCCD should not be all zeros
        if (intval($cccd) === 0) {
            return false;
        }
        
        // Allow some special cases that start with 000 but are valid
        // For example: 000000000019, 000000000001, etc.
        // These might be valid test numbers or special cases
        
        return true;
    }
    
    /**
     * Get validation error message
     * 
     * @param string $field
     * @param string $value
     * @return string
     */
    public static function getErrorMessage($field, $value)
    {
        switch ($field) {
            case 'email':
                if (empty($value)) {
                    return 'Email không được để trống';
                }
                return 'Email không hợp lệ';
                
            case 'phone':
                if (empty($value)) {
                    return 'Số điện thoại không được để trống';
                }
                return 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam (10 chữ số, bắt đầu bằng 0)';
                
            case 'citizen_id':
                if (empty($value)) {
                    return 'Số CCCD không được để trống';
                }
                return 'Số CCCD không hợp lệ. Vui lòng nhập đúng 12 chữ số';
                
            default:
                return 'Dữ liệu không hợp lệ';
        }
    }
    
    /**
     * Validate multiple fields at once
     * 
     * @param array $data
     * @return array
     */
    public static function validateFields($data)
    {
        $errors = [];
        
        foreach ($data as $field => $value) {
            switch ($field) {
                case 'email':
                    if (!self::email($value)) {
                        $errors[$field] = self::getErrorMessage($field, $value);
                    }
                    break;
                    
                case 'phone':
                    if (!self::phone($value)) {
                        $errors[$field] = self::getErrorMessage($field, $value);
                    }
                    break;
                    
                case 'citizen_id':
                    if (!empty($value) && !self::citizenId($value)) {
                        $errors[$field] = self::getErrorMessage($field, $value);
                    }
                    break;
            }
        }
        
        return $errors;
    }
    
    /**
     * Format phone number for display
     * 
     * @param string $phone
     * @return string
     */
    public static function formatPhone($phone)
    {
        if (empty($phone)) {
            return '';
        }
        
        // Remove all non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Format as 0xxx xxx xxx
        if (strlen($phone) === 10) {
            return substr($phone, 0, 4) . ' ' . substr($phone, 4, 3) . ' ' . substr($phone, 7, 3);
        }
        
        return $phone;
    }
    
    /**
     * Format citizen ID for display
     * 
     * @param string $citizenId
     * @return string
     */
    public static function formatCitizenId($citizenId)
    {
        if (empty($citizenId)) {
            return '';
        }
        
        // Remove all non-digit characters
        $citizenId = preg_replace('/[^0-9]/', '', $citizenId);
        
        // Format based on length
        if (strlen($citizenId) === 9) {
            // CMND: xxx xxx xxx
            return substr($citizenId, 0, 3) . ' ' . substr($citizenId, 3, 3) . ' ' . substr($citizenId, 6, 3);
        } elseif (strlen($citizenId) === 12) {
            // CCCD: xxx xxx xxx xxx
            return substr($citizenId, 0, 3) . ' ' . substr($citizenId, 3, 3) . ' ' . substr($citizenId, 6, 3) . ' ' . substr($citizenId, 9, 3);
        }
        
        return $citizenId;
    }
    
    /**
     * Validate tenant data with detailed error messages
     * 
     * @param array $data
     * @param object $tenantModel
     * @return array
     */
    public static function validateTenantData($data, $tenantModel)
    {
        $errors = [];
        
        // Validate required fields
        if (empty($data['username'])) {
            $errors['username'] = 'Tên khách hàng không được để trống';
        }
        
        if (empty($data['email'])) {
            $errors['email'] = 'Email không được để trống';
        } elseif (!self::email($data['email'])) {
            $errors['email'] = 'Email không hợp lệ';
        } else {
            // Check if email exists and is active
            $emailInfo = $tenantModel->checkEmailExistsAndActive($data['email']);
            if (!$emailInfo) {
                $errors['email'] = 'Email không tồn tại hoặc chưa được kích hoạt';
            }
        }
        
        if (empty($data['phone'])) {
            $errors['phone'] = 'Số điện thoại không được để trống';
        } elseif (!self::phone($data['phone'])) {
            $errors['phone'] = 'Số điện thoại không hợp lệ';
        } else {
            // Check if phone is duplicate
            if ($tenantModel->checkPhoneExists($data['phone'])) {
                $errors['phone'] = 'Số điện thoại đã được sử dụng';
            }
        }
        
        if (empty($data['room_id'])) {
            $errors['room_id'] = 'Vui lòng chọn phòng';
        }
        
        if (empty($data['join_date'])) {
            $errors['join_date'] = 'Ngày vào ở không được để trống';
        }
        
        // Validate citizen_id (required)
        if (empty($data['citizen_id'])) {
            $errors['citizen_id'] = 'Số CCCD không được để trống';
        } elseif (!self::citizenId($data['citizen_id'])) {
            $errors['citizen_id'] = 'Số CCCD không hợp lệ. Vui lòng nhập đúng 12 chữ số';
        } else {
            // Check if citizen_id is duplicate
            if ($tenantModel->checkCitizenIdExists($data['citizen_id'])) {
                $errors['citizen_id'] = 'Số CCCD đã được sử dụng';
            }
        }
        
        // Validate address fields (required)
        if (empty($data['province'])) {
            $errors['province'] = 'Tỉnh/Thành phố không được để trống';
        }
        
        if (empty($data['ward'])) {
            $errors['ward'] = 'Phường/Xã không được để trống';
        }
        
        // Check if customer is currently in another room
        if (!empty($data['email'])) {
            $emailRoomInfo = $tenantModel->checkEmailCurrentlyInRoom($data['email']);
            if ($emailRoomInfo) {
                $errors['email'] = 'Khách hàng đang ở phòng khác';
            }
        }
        
        return $errors;
    }
    
    /**
     * Validate tenant data for update (without email validation)
     * 
     * @param array $data
     * @param object $tenantModel
     * @param int $excludeUserId
     * @return array
     */
    public static function validateTenantDataForUpdate($data, $tenantModel, $excludeUserId = null)
    {
        $errors = [];
        
        // Validate required fields
        if (empty($data['username'])) {
            $errors['username'] = 'Tên khách hàng không được để trống';
        }
        
        // Phone validation - chỉ validate format nếu có nhập, không bắt buộc và không check duplicate
        if (!empty($data['phone']) && !self::phone($data['phone'])) {
            $errors['phone'] = 'Số điện thoại không hợp lệ';
        }
        
        if (empty($data['room_id'])) {
            $errors['room_id'] = 'Vui lòng chọn phòng';
        }
        
        if (empty($data['join_date'])) {
            $errors['join_date'] = 'Ngày vào ở không được để trống';
        }
        
        // Citizen ID validation - chỉ validate format nếu có nhập, không bắt buộc và không check duplicate
        if (!empty($data['citizen_id']) && !self::citizenId($data['citizen_id'])) {
            $errors['citizen_id'] = 'Số CCCD không hợp lệ. Vui lòng nhập đúng 12 chữ số';
        }
        
        // Validate address fields (required)
        if (empty($data['province'])) {
            $errors['province'] = 'Tỉnh/Thành phố không được để trống';
        }
        
        if (empty($data['ward'])) {
            $errors['ward'] = 'Phường/Xã không được để trống';
        }
        
        return $errors;
    }
    
    /**
     * Validate invoice data for update
     * 
     * @param array $data
     * @return array
     */
    public static function validateInvoiceData($data)
    {
        $errors = [];
        
        // Validate invoice_name (required)
        if (empty($data['invoice_name'])) {
            $errors['invoice_name'] = 'Tên hóa đơn không được để trống';
        } elseif (strlen($data['invoice_name']) > 255) {
            $errors['invoice_name'] = 'Tên hóa đơn không được vượt quá 255 ký tự';
        }
        
        // Validate invoice_month (required, format: MM-YYYY)
        if (empty($data['invoice_month'])) {
            $errors['invoice_month'] = 'Tháng lập phiếu không được để trống';
        } elseif (!self::validateMonthYear($data['invoice_month'])) {
            $errors['invoice_month'] = 'Tháng lập phiếu không hợp lệ. Vui lòng nhập theo định dạng MM-YYYY';
        }
        
        // Validate invoice_day (required, format: YYYY-MM-DD)
        if (empty($data['invoice_day'])) {
            $errors['invoice_day'] = 'Ngày lập hóa đơn không được để trống';
        } elseif (!self::validateDate($data['invoice_day'])) {
            $errors['invoice_day'] = 'Ngày lập hóa đơn không hợp lệ. Vui lòng nhập theo định dạng YYYY-MM-DD';
        }
        
        // Validate due_date (required, format: YYYY-MM-DD)
        if (empty($data['due_date'])) {
            $errors['due_date'] = 'Hạn đóng tiền không được để trống';
        } elseif (!self::validateDate($data['due_date'])) {
            $errors['due_date'] = 'Hạn đóng tiền không hợp lệ. Vui lòng nhập theo định dạng YYYY-MM-DD';
        }
        
        // Validate note (optional, max 1000 characters)
        if (!empty($data['note']) && strlen($data['note']) > 1000) {
            $errors['note'] = 'Ghi chú không được vượt quá 1000 ký tự';
        }
        
        // Validate date logic: due_date should be after invoice_day
        if (!empty($data['invoice_day']) && !empty($data['due_date']) && 
            self::validateDate($data['invoice_day']) && self::validateDate($data['due_date'])) {
            
            $invoiceDate = new \DateTime($data['invoice_day']);
            $dueDate = new \DateTime($data['due_date']);
            
            if ($dueDate <= $invoiceDate) {
                $errors['due_date'] = 'Hạn đóng tiền phải sau ngày lập hóa đơn';
            }
        }
        
        
        return $errors;
    }
    
    /**
     * Validate create invoice data
     * 
     * @param array $data
     * @return array
     */
    public static function validateCreateInvoiceData($data)
    {
        $errors = [];
        
        // Validate room_id (required)
        if (empty($data['room_id'])) {
            $errors['room_id'] = 'ID phòng không được để trống';
        } elseif (!is_numeric($data['room_id'])) {
            $errors['room_id'] = 'ID phòng không hợp lệ';
        }
        
        // Validate invoice_name (required)
        if (empty($data['invoice_name'])) {
            $errors['invoice_name'] = 'Tên hóa đơn không được để trống';
        } elseif (strlen($data['invoice_name']) > 255) {
            $errors['invoice_name'] = 'Tên hóa đơn không được vượt quá 255 ký tự';
        }
        
        // Validate invoice_month (required, format: MM-YYYY)
        if (empty($data['invoice_month'])) {
            $errors['invoice_month'] = 'Tháng lập phiếu không được để trống';
        } elseif (!self::validateMonthYear($data['invoice_month'])) {
            $errors['invoice_month'] = 'Tháng lập phiếu không hợp lệ. Vui lòng nhập theo định dạng MM-YYYY';
        }
        
        // Validate invoice_day (required, format: YYYY-MM-DD)
        if (empty($data['invoice_day'])) {
            $errors['invoice_day'] = 'Ngày lập hóa đơn không được để trống';
        } elseif (!self::validateDate($data['invoice_day'])) {
            $errors['invoice_day'] = 'Ngày lập hóa đơn không hợp lệ. Vui lòng nhập theo định dạng YYYY-MM-DD';
        }
        
        // Validate due_date (required, format: YYYY-MM-DD)
        if (empty($data['due_date'])) {
            $errors['due_date'] = 'Hạn đóng tiền không được để trống';
        } elseif (!self::validateDate($data['due_date'])) {
            $errors['due_date'] = 'Hạn đóng tiền không hợp lệ. Vui lòng nhập theo định dạng YYYY-MM-DD';
        }
        
        // Validate rental_amount (required, numeric)
        if (empty($data['rental_amount'])) {
            $errors['rental_amount'] = 'Tiền phòng không được để trống';
        } elseif (!is_numeric($data['rental_amount']) || $data['rental_amount'] < 0) {
            $errors['rental_amount'] = 'Tiền phòng phải là số dương';
        }
        
        // Validate note (optional, max 1000 characters)
        if (!empty($data['note']) && strlen($data['note']) > 1000) {
            $errors['note'] = 'Ghi chú không được vượt quá 1000 ký tự';
        }
        
        // Validate date logic: due_date should be after invoice_day
        if (!empty($data['invoice_day']) && !empty($data['due_date']) && 
            self::validateDate($data['invoice_day']) && self::validateDate($data['due_date'])) {
            
            $invoiceDate = new \DateTime($data['invoice_day']);
            $dueDate = new \DateTime($data['due_date']);
            
            if ($dueDate <= $invoiceDate) {
                $errors['due_date'] = 'Hạn đóng tiền phải sau ngày lập hóa đơn';
            }
        }
        
        // Validate services data if provided
        if (!empty($data['services']) && is_array($data['services'])) {
            foreach ($data['services'] as $serviceId => $serviceData) {
                if (!empty($serviceData['enabled'])) {
                    // Validate old_value and new_value for meter-based services (KWH, m3)
                    if (isset($serviceData['old_value']) && isset($serviceData['new_value'])) {
                        // Check for empty values
                        if (empty($serviceData['old_value']) && $serviceData['old_value'] !== '0') {
                            $errors["services.{$serviceId}.old_value"] = 'Số cũ không được để trống';
                        } elseif (!is_numeric($serviceData['old_value']) || $serviceData['old_value'] < 0 || $serviceData['old_value'] != (int)$serviceData['old_value']) {
                            $errors["services.{$serviceId}.old_value"] = 'Số cũ phải là số nguyên không âm';
                        }
                        
                        if (empty($serviceData['new_value']) && $serviceData['new_value'] !== '0') {
                            $errors["services.{$serviceId}.new_value"] = 'Số mới không được để trống';
                        } elseif (!is_numeric($serviceData['new_value']) || $serviceData['new_value'] < 0 || $serviceData['new_value'] != (int)$serviceData['new_value']) {
                            $errors["services.{$serviceId}.new_value"] = 'Số mới phải là số nguyên không âm';
                        }
                        
                        if (is_numeric($serviceData['old_value']) && is_numeric($serviceData['new_value'])) {
                            $oldValue = (int)$serviceData['old_value'];
                            $newValue = (int)$serviceData['new_value'];
                            
                            // Check if both values are 0 or if new <= old
                            if (($oldValue === 0 && $newValue === 0) || $newValue <= $oldValue) {
                                $errors["services.{$serviceId}.new_value"] = 'Số mới phải lớn hơn số cũ';
                            }
                        }
                    }
                    
                    // Validate usage_amount for non-meter services (person, month, etc.)
                    if (isset($serviceData['usage_amount'])) {
                        if (empty($serviceData['usage_amount']) && $serviceData['usage_amount'] !== '0') {
                            $errors["services.{$serviceId}.usage_amount"] = 'Số lượng sử dụng không được để trống';
                        } elseif (!is_numeric($serviceData['usage_amount']) || $serviceData['usage_amount'] <= 0 || $serviceData['usage_amount'] != (int)$serviceData['usage_amount']) {
                            $errors["services.{$serviceId}.usage_amount"] = 'Số lượng sử dụng phải là số nguyên dương';
                        }
                    }
                }
            }
        }
        
        return $errors;
    }
    
    
    /**
     * Validate month-year format (MM-YYYY)
     * 
     * @param string $monthYear
     * @return bool
     */
    private static function validateMonthYear($monthYear)
    {
        if (empty($monthYear)) {
            return false;
        }
        
        // Check format MM-YYYY
        if (!preg_match('/^(\d{2})-(\d{4})$/', $monthYear, $matches)) {
            return false;
        }
        
        $month = (int)$matches[1];
        $year = (int)$matches[2];
        
        // Validate month (1-12)
        if ($month < 1 || $month > 12) {
            return false;
        }
        
        // Validate year (reasonable range)
        $currentYear = (int)date('Y');
        if ($year < 2000 || $year > $currentYear + 10) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Validate date format (YYYY-MM-DD)
     * 
     * @param string $date
     * @return bool
     */
    private static function validateDate($date)
    {
        if (empty($date)) {
            return false;
        }
        
        // Check format YYYY-MM-DD
        if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $matches)) {
            return false;
        }
        
        $year = (int)$matches[1];
        $month = (int)$matches[2];
        $day = (int)$matches[3];
        
        // Validate date using checkdate
        return checkdate($month, $day, $year);
    }

    /**
     * Validate room data
     * 
     * @param array $data
     * @return array
     */
    public static function validateRoomData($data)
    {
        $errors = [];
        
        // Validate required fields
        if (empty($data['room_name'])) {
            $errors['room_name'] = 'Tên phòng không được để trống';
        } elseif (strlen(trim($data['room_name'])) < 2) {
            $errors['room_name'] = 'Tên phòng phải có ít nhất 2 ký tự';
        }
        
        if (empty($data['floor'])) {
            $errors['floor'] = 'Tầng không được để trống';
        } elseif (!is_numeric($data['floor']) || (int)$data['floor'] <= 0) {
            $errors['floor'] = 'Tầng phải là số nguyên dương';
        }
        
        if (empty($data['area'])) {
            $errors['area'] = 'Diện tích không được để trống';
        } elseif (!is_numeric($data['area']) || (float)$data['area'] <= 0) {
            $errors['area'] = 'Diện tích phải là số dương';
        }
        
        if (empty($data['room_price'])) {
            $errors['room_price'] = 'Giá thuê không được để trống';
        } elseif (!is_numeric($data['room_price']) || (float)$data['room_price'] < 0) {
            $errors['room_price'] = 'Giá thuê phải là số không âm';
        }
        
        if (empty($data['deposit'])) {
            $errors['deposit'] = 'Tiền cọc không được để trống';
        } elseif (!is_numeric($data['deposit']) || (float)$data['deposit'] < 0) {
            $errors['deposit'] = 'Tiền cọc phải là số không âm';
        }
        
        if (empty($data['max_people'])) {
            $errors['max_people'] = 'Số người tối đa không được để trống';
        } elseif (!is_numeric($data['max_people']) || (int)$data['max_people'] <= 0) {
            $errors['max_people'] = 'Số người tối đa phải là số nguyên dương';
        }
        
        if (empty($data['room_status'])) {
            $errors['room_status'] = 'Trạng thái phòng không được để trống';
        } elseif (!in_array($data['room_status'], ['available', 'occupied', 'maintenance'])) {
            $errors['room_status'] = 'Trạng thái phòng không hợp lệ';
        }
        
        return $errors;
    }

    /**
     * Validate room data for update
     * 
     * @param array $data
     * @return array
     */
    public static function validateRoomDataForUpdate($data)
    {
        $errors = [];
        
        // Validate required fields (same as create)
        if (empty($data['room_name'])) {
            $errors['room_name'] = 'Tên phòng không được để trống';
        } elseif (strlen(trim($data['room_name'])) < 2) {
            $errors['room_name'] = 'Tên phòng phải có ít nhất 2 ký tự';
        }
        
        if (empty($data['floor'])) {
            $errors['floor'] = 'Tầng không được để trống';
        } elseif (!is_numeric($data['floor']) || (int)$data['floor'] <= 0) {
            $errors['floor'] = 'Tầng phải là số nguyên dương';
        }
        
        if (empty($data['area'])) {
            $errors['area'] = 'Diện tích không được để trống';
        } elseif (!is_numeric($data['area']) || (float)$data['area'] <= 0) {
            $errors['area'] = 'Diện tích phải là số dương';
        }
        
        if (empty($data['room_price'])) {
            $errors['room_price'] = 'Giá thuê không được để trống';
        } elseif (!is_numeric($data['room_price']) || (float)$data['room_price'] < 0) {
            $errors['room_price'] = 'Giá thuê phải là số không âm';
        }
        
        if (empty($data['deposit'])) {
            $errors['deposit'] = 'Tiền cọc không được để trống';
        } elseif (!is_numeric($data['deposit']) || (float)$data['deposit'] < 0) {
            $errors['deposit'] = 'Tiền cọc phải là số không âm';
        }
        
        if (empty($data['max_people'])) {
            $errors['max_people'] = 'Số người tối đa không được để trống';
        } elseif (!is_numeric($data['max_people']) || (int)$data['max_people'] <= 0) {
            $errors['max_people'] = 'Số người tối đa phải là số nguyên dương';
        }
        
        if (empty($data['room_status'])) {
            $errors['room_status'] = 'Trạng thái phòng không được để trống';
        } elseif (!in_array($data['room_status'], ['available', 'occupied', 'maintenance'])) {
            $errors['room_status'] = 'Trạng thái phòng không hợp lệ';
        }
        
        return $errors;
    }

    /**
     * Validate user data for create
     */
    public static function validateUserData($data, $queryBuilder)
    {
        $errors = [];
        // Validate username (no uniqueness check)
        if (empty($data['username'])) {
            $errors['username'] = 'Tên người dùng không được để trống';
        } elseif (strlen($data['username']) < 3) {
            $errors['username'] = 'Tên người dùng phải có ít nhất 3 ký tự';
        } elseif (strlen($data['username']) > 50) {
            $errors['username'] = 'Tên người dùng không được vượt quá 50 ký tự';
        }

        // Validate email
        if (empty($data['email'])) {
            $errors['email'] = 'Email không được để trống';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        } else {
            // Check if email already exists
            $existingUser = $queryBuilder->table('users')
                ->where('email', '=', $data['email'])
                ->where('deleted', '=', 0)
                ->first();
            if ($existingUser) {
                $errors['email'] = 'Email đã được sử dụng';
            }
        }

        // Validate phone
        if (empty($data['phone'])) {
            $errors['phone'] = 'Số điện thoại không được để trống';
        } elseif (!self::phone($data['phone'])) {
            $errors['phone'] = 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam (10 chữ số, bắt đầu bằng 0)';
        } else {
            // Check if phone already exists
            $existingPhone = $queryBuilder->table('users')
                ->where('phone', '=', $data['phone'])
                ->where('deleted', '=', 0)
                ->first();
            if ($existingPhone) {
                $errors['phone'] = 'Số điện thoại đã được sử dụng';
            }
        }

        // Validate password
        if (empty($data['password'])) {
            $errors['password'] = 'Mật khẩu không được để trống';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
        }

        // Check password confirmation
        $passwordConfirmation = $data['password_confirmation'] ?? null;
        if ($data['password'] !== $passwordConfirmation) {
            $errors['password_confirmation'] = 'Mật khẩu xác nhận không khớp';
        }

        // Validate citizen_id (optional field)
        if (!empty($data['citizen_id'])) {
            if (!self::citizenId($data['citizen_id'])) {
                $errors['citizen_id'] = 'Số CCCD không hợp lệ. Vui lòng nhập đúng 12 chữ số';
            } else {
                // Check if citizen_id already exists
                $existingCitizenId = $queryBuilder->table('users')
                    ->where('citizen_id', '=', $data['citizen_id'])
                    ->where('deleted', '=', 0)
                    ->first();
                if ($existingCitizenId) {
                    $errors['citizen_id'] = 'Số CCCD đã được sử dụng';
                }
            }
        }

        // Validate role_id
        if (empty($data['role_id'])) {
            $errors['role_id'] = 'Vui lòng chọn vai trò';
        } else {
            // Check if role exists (allow admin)
            $role = $queryBuilder->table('roles')
                ->where('id', '=', $data['role_id'])
                ->first();
            if (!$role) {
                $errors['role_id'] = 'Vai trò không hợp lệ';
            }
        }

        // Validate account_status
        if (!in_array($data['account_status'], ['active', 'inactive', 'banned'])) {
            $data['account_status'] = 'active';
        }

        // Validate gender
        if (empty($data['gender'])) {
            $errors['gender'] = 'Vui lòng chọn giới tính';
        }

        return $errors;
    }

    /**
     * Validate user data for update
     */
    public static function validateUserDataForUpdate($data, $currentUserId, $queryBuilder)
    {   
        $errors = [];
        // Prevent updating role to admin or changing admin's role
        if (!empty($data['role_id'])) {
            // Get the current user's role
            $currentUser = $queryBuilder->table('users')->where('id', '=', $currentUserId)->first();
            $adminRole = $queryBuilder->table('roles')->where('role_name', '=', 'admin')->first();
            if ($currentUser && $adminRole) {
                $isCurrentAdmin = $currentUser['role_id'] == $adminRole['id'];
                $isNewAdmin = $data['role_id'] == $adminRole['id'];
                // Không cho phép cập nhật role admin (không cho đổi sang admin hoặc đổi từ admin sang role khác)
                if (($isCurrentAdmin && !$isNewAdmin) || (!$isCurrentAdmin && $isNewAdmin)) {
                    $errors['role_id'] = 'Không được phép cập nhật vai trò admin.';
                }
            }
        }

        // Validate username (no uniqueness check)
        if (empty($data['username'])) {
            $errors['username'] = 'Tên người dùng không được để trống';
        } elseif (strlen($data['username']) < 3) {
            $errors['username'] = 'Tên người dùng phải có ít nhất 3 ký tự';
        } elseif (strlen($data['username']) > 50) {
            $errors['username'] = 'Tên người dùng không được vượt quá 50 ký tự';
        }

        // Validate email
        if (empty($data['email'])) {
            $errors['email'] = 'Email không được để trống';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        } else {
            // Check if email already exists (exclude current user)
            $existingUser = $queryBuilder->table('users')
                ->where('email', '=', $data['email'])
                ->where('id', '!=', $currentUserId)
                ->where('deleted', '=', 0)
                ->first();
            if ($existingUser) {
                $errors['email'] = 'Email đã được sử dụng';
            }
        }

        // Validate phone
        if (!empty($data['phone'])) {
            if (!self::phone($data['phone'])) {
                $errors['phone'] = 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam (10 chữ số, bắt đầu bằng 0)';
            } else {
                // Check if phone already exists (exclude current user)
                $existingPhone = $queryBuilder->table('users')
                    ->where('phone', '=', $data['phone'])
                    ->where('id', '!=', $currentUserId)
                    ->where('deleted', '=', 0)
                    ->first();
                if ($existingPhone) {
                    $errors['phone'] = 'Số điện thoại đã được sử dụng';
                }
            }
        }

        // Validate citizen_id (optional field)
        if (!empty($data['citizen_id'])) {
            if (!self::citizenId($data['citizen_id'])) {
                $errors['citizen_id'] = 'Số CCCD không hợp lệ. Vui lòng nhập đúng 12 chữ số';
            } else {
                // Check if citizen_id already exists (exclude current user)
                $existingCitizenId = $queryBuilder->table('users')
                    ->where('citizen_id', '=', $data['citizen_id'])
                    ->where('id', '!=', $currentUserId)
                    ->where('deleted', '=', 0)
                    ->first();
                if ($existingCitizenId) {
                    $errors['citizen_id'] = 'Số CCCD đã được sử dụng';
                }
            }
        }

        // Validate role_id
        if (empty($data['role_id'])) {
            $errors['role_id'] = 'Vui lòng chọn vai trò';
        } else {
            // Check if role exists
            $role = $queryBuilder->table('roles')
                ->where('id', '=', $data['role_id'])
                ->first();
            if (!$role) {
                $errors['role_id'] = 'Vai trò không hợp lệ';
            }
        }

        // Validate account_status
        if (!in_array($data['account_status'], ['active', 'inactive', 'banned'])) {
            $data['account_status'] = 'active';
        }

        return $errors;
    }
}
