<?php

/*
 *    Author: Huy Nguyen
 *    Date: 2025-10-06
 *    Purpose: base page rental post when search
 */

namespace App\Controllers\Customer;
use App\Controllers\Controller;
use App\Models\RenTalPost;
use Core\Request;
use Core\ViewRender;

class BaseRentalPostController extends Controller {
	protected $titlePage = '';
    protected $subNav = true;
    protected $returnPage = '';
    protected $primaryFilter = '';
    protected $request;
    protected $rentalPostModel;

    public function __construct() {
        parent::__construct();
        $this->request = new Request();
        $this->rentalPostModel = new RenTalPost();
    }

    public function searchByFilter() {
        $page = (int) ($this->request->get('page') ?? 1);
        $limit = 10; // 3 rows x 3 columns
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

        $totalPosts = $this->rentalPostModel->getTotalRentalPostsCount($filters);

        // Calculate pagination data
        $totalPages = ceil($totalPosts / $limit);

        $queryParams = array_filter($this->request->get());

        $pagination = [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_items' => $totalPosts,
            'per_page' => $limit,
            'showing_from' => $offset + 1,
            'showing_to' => min($offset + $limit, $totalPosts)
        ];

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