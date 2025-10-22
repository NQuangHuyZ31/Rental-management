<?php

/*

 * Author: Huy Nguyen
 * Date: 2025-09-11
 * Purpose: Profile Customer Controller
 */

namespace App\Controllers\Customer;

use App\Controllers\ProfileController;
use Core\ViewRender;

class ProfileCustomerController extends ProfileController {
    protected $sidebar = true;
    protected $noFooter = true;
    protected $title = 'Thông tin cá nhân';

    public function __construct() {
        parent::__construct();
    }

    public function profile() {
        $user = $this->userModel->getUserById($this->userID);
        $totalRentedRooms = $this->tenantModel->getAllRoomByUserId();
        $totalPaymentHistory = $this->paymentHistoryModel->getTotalPaymentHistoryByUserId($this->userID);
        ViewRender::renderWithLayout(
            'customer/profile/profile',
            [
                'sidebar' => $this->sidebar,
                'noFooter' => $this->noFooter,
                'title' => $this->title,
                'sidebarData' => $this->sidebarData(),
                'user' => $user,
                'countRentedRooms' => count($totalRentedRooms),
                'totalPaymentHistory' => $totalPaymentHistory['total'],
            ],
            'customer/layouts/app'
        );
    }

    public function update() {
        parent::update();
    }

    public function changePassword() {
        parent::changePassword();
    }

    public function updateProfilePicture() {
        parent::updateProfilePicture();
    }

    public function support() {
        ViewRender::renderWithLayout(
            'customer/support/support-page',
            [
                'sidebar' => $this->sidebar,
                'noFooter' => $this->noFooter,
                'title' => $this->title,
                'sidebarData' => $this->sidebarData(),
            ],
            'customer/layouts/app'
        );
    }

    public function handleDeleteAccount() {
        parent::handleDeleteAccount();
    }
}
