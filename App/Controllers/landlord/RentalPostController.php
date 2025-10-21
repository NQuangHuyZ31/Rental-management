<?php

/*
Author: Huy Nguyen
Date: 2025-09-05
Purpose: Build Rental Post Controller
 */

namespace App\Controllers\Landlord;

use App\Controllers\BaseRentalPostController;
use Core\ViewRender;

class RentalPostController extends BaseRentalPostController {
    protected $role = 'landlord';

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        // Get filter parameters
        $page = (int) ($this->request->get('page') ?? 1);
        $limit = 3; // 3 rows x 3 columns
        $offset = ($page - 1) * $limit;

        // Get posts and categories
        $rentalPosts = $this->rentalPostModel->searchRentalPosts([], $limit, $offset, true);
        $totalPosts = $this->rentalPostModel->getTotalRentalPostsCount([], false, true);
        $pagination = $this->getPagination($page, $totalPosts, $limit, $offset);
        $queryParams = [];

        ViewRender::render('landlord/posts/index', [
            'rentalPosts' => $rentalPosts,
            'rentalCategories' => $this->getAllRentalCategory(),
            'rentalAmenities' => $this->getAllRentalAmenity(),
            'pagination' => $pagination,
            'queryParams' => $queryParams,
        ]);
    }
}
