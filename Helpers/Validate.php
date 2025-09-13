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
        
        if (empty($data['phone'])) {
            $errors['phone'] = 'Số điện thoại không được để trống';
        } elseif (!self::phone($data['phone'])) {
            $errors['phone'] = 'Số điện thoại không hợp lệ';
        } else {
            // Check if phone is duplicate (exclude current user)
            if ($excludeUserId) {
                if ($tenantModel->checkPhoneExistsForOtherUser($data['phone'], $excludeUserId)) {
                    $errors['phone'] = 'Số điện thoại đã được sử dụng';
                }
            } else {
                if ($tenantModel->checkPhoneExists($data['phone'])) {
                    $errors['phone'] = 'Số điện thoại đã được sử dụng';
                }
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
            // Check if citizen_id is duplicate (exclude current user)
            if ($excludeUserId) {
                if ($tenantModel->checkCitizenIdExistsForOtherUser($data['citizen_id'], $excludeUserId)) {
                    $errors['citizen_id'] = 'Số CCCD đã được sử dụng';
                }
            } else {
                if ($tenantModel->checkCitizenIdExists($data['citizen_id'])) {
                    $errors['citizen_id'] = 'Số CCCD đã được sử dụng';
                }
            }
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
}
