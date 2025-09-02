<?php

/*
	Author: Nguyen Xuan Duong
	Date: 2025-09-3
	Purpose: Base Controller for Landlord Controllers
*/

namespace App\Controllers\Landlord;

use App\Controllers\Controller;
use App\Models\Landlord\House;
use Core\Session;

abstract class LandlordController extends Controller
{
    protected $houseModel;
    
    public function __construct()
    {
        $this->houseModel = new House();
    }
    
    /**
     * Lấy nhà trọ được chọn từ GET request hoặc session
     * Logic chung cho tất cả landlord controller
     */
    protected function getSelectedHouse($ownerId, $requestHouseId = null)
    {
        // Lấy danh sách nhà của landlord
        $houses = $this->houseModel->getHousesByOwnerId($ownerId);
        
        if (empty($houses)) {
            return [null, [], null];
        }
        
        $selectedHouse = null;
        
        // Ưu tiên 1: house_id từ GET request (khi user chuyển nhà)
        if ($requestHouseId) {
            foreach ($houses as $house) {
                if ($house['id'] == $requestHouseId) {
                    $selectedHouse = $house;
                    // Lưu house_id vào session để chia sẻ với các trang khác
                    Session::set('selected_house_id', $house['id']);
                    break;
                }
            }
        }
        
        // Ưu tiên 2: house_id từ session (khi chuyển trang)
        if (!$selectedHouse) {
            $savedHouseId = Session::get('selected_house_id');
            if ($savedHouseId) {
                foreach ($houses as $house) {
                    if ($house['id'] == $savedHouseId) {
                        $selectedHouse = $house;
                        break;
                    }
                }
            }
        }
        
        // Ưu tiên 3: nhà trọ đầu tiên (mặc định)
        if (!$selectedHouse) {
            $selectedHouse = $houses[0];
            // Lưu house_id đầu tiên vào session
            Session::set('selected_house_id', $houses[0]['id']);
        }
        
        return [$selectedHouse, $houses, $selectedHouse['id']];
    }
}
