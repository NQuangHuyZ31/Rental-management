<?php

/*
Author: Nguyen Xuan Duong
Date: 2025-09-3
Purpose: Base Controller for Landlord Controllers
 */

namespace App\Controllers\Landlord;

use App\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Service;
use App\Models\House;
use App\Models\RentalAmenity;
use App\Models\RentalCategory;
use App\Models\RenTalPost;
use App\Models\Room;
use App\Models\ServiceUsage;
use App\Models\Tenant;
use App\Models\User;
use Core\Request;
use Core\Session;

abstract class LandlordController extends Controller {
    protected $user;
    protected $limit = 10;
    protected $houseModel;
    protected $amenityModel;
    protected $roomModel;
    protected $request;
    protected $tenantModel;
    protected $rentalCategoryModel;
    protected $rentalAmenityModel;
    protected $rentalPostModel;
    protected $serviceModel;
    protected $userModel;
    protected $serviceUsageModel;

    public function __construct() {
        parent::__construct();
        $this->user = Session::get('user');
        $this->houseModel = new House();
        $this->request = new Request();
        $this->amenityModel = new Amenity();
        $this->roomModel = new Room();
        $this->tenantModel = new Tenant();
        $this->rentalCategoryModel = new RentalCategory();
        $this->rentalAmenityModel = new RentalAmenity();
        $this->rentalPostModel = new RenTalPost();
        $this->serviceModel = new Service();
        $this->userModel = new User();
        $this->serviceUsageModel = new ServiceUsage();
    }

    /**
     * Lấy nhà trọ được chọn từ GET request hoặc session
     * Logic chung cho tất cả landlord controller
     */
    protected function getSelectedHouse($ownerId, $requestHouseId = null) {
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

    // Added by Huy Nguyen on 2025-10-15 to add function get pagination
    public function getPagination($page, $totalData, $limit, $offset) {
		$totalPages = ceil($totalData / $limit);
		return [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_items' => $totalData,
            'items_per_page' => $limit,
            'has_prev' => $page > 1,
            'has_next' => $page < $totalPages,
            'prev_page' => $page > 1 ? $page - 1 : null,
            'next_page' => $page < $totalPages ? $page + 1 : null,
			'showing_from' => $offset + 1,
            'showing_to' => min($offset + $limit, $totalData)
        ];  
	}
}
