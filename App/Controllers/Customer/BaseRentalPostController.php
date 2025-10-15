<?php

/*
 *    Author: Huy Nguyen
 *    Date: 2025-10-06
 *    Purpose: base page rental post when search
 */

namespace App\Controllers\Customer;

use App\Controllers\BaseCustomerController;
use Core\ViewRender;

class BaseRentalPostController extends BaseCustomerController {
	protected $titlePage = '';
    protected $subNav = true;
    protected $returnPage = '';
    protected $primaryFilter = '';

    public function __construct() {
        parent::__construct();
    }

    public function searchByFilter() {
        $page = (int) ($this->request->get('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Build filters array
        $requests = $this->request->get();
        $sortFilters = $requests['sort'] ?? '';
        $orderBy = '';
        $sort = '';

        if (!empty($sortFilters)) {
            if ($sortFilters == 'price_asc') {
                $orderBy .= 'price';
                $sort .= 'ASC';
            } else if ($sortFilters == 'price_desc') {
                $orderBy .= 'price';
                $sort .= 'DESC';
            } else if ($sortFilters == 'newest') {
                $orderBy .= 'created_at';
                $sort .= 'DESC';
            } else {
                $orderBy .= 'area';
                $sort .= 'DESC';
            }
        }

        $filters = [];

        foreach ($requests as $key => $filter) {
            if (!isset($filter[$key]) && $filter != '') {
                $filters [$key] = $filter;
            }
         }

        // Get posts and categories
        if (!empty($sortFilters)) {
            $rentalPosts = $this->rentalPostModel->searchRentalPosts($filters, $limit, $offset, false, true, $orderBy, $sort);
        } else {
            $rentalPosts = $this->rentalPostModel->searchRentalPosts($filters, $limit, $offset, false, true);
        }

        $totalPosts = $this->rentalPostModel->getTotalRentalPostsCount($filters, true);
        $queryParams = array_filter($this->request->get());
        $pagination = $this->getPagination($page, $totalPosts, $limit, $offset);

        ViewRender::renderWithLayout('customer/rental-post/' . $this->returnPage, [
			'titlePage' => $this->titlePage,
            'posts' => $rentalPosts,
            'pagination' => $pagination,
            'queryParams' => $queryParams,
            'currentFilters' => [
                'province' => $this->request->get('province'),
                'keyword' => $this->request->get('keyword'),
                'price' => $this->request->get('price'),
                'area' => $this->request->get('area'),
                'sort' => $this->request->get('sort')
            ],
            'subNav' => $this->subNav,
		], 'customer/layouts/app');
    }
}