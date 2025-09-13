<?php

/*

* Author: Huy Nguyen
* Date: 2025-09-09
* Purpose: Post Management Controller
*/

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\RenTalPost;
use Core\Request;
use Core\ViewRender;

class PostManagementController extends Controller {

	protected $rentalPostModel;
	protected $request;

	public function __construct() {
		parent::__construct();
		$this->rentalPostModel = new RenTalPost();
		$this->request = new Request();
	}

    public function index() {
		$allPost = $this->rentalPostModel->getCountRentalPostsByStatus();
		$pendingPost = $this->rentalPostModel->getCountRentalPostsByStatus('pending');
		$approvedPost = $this->rentalPostModel->getCountRentalPostsByStatus('approved');
		$rejectedPost = $this->rentalPostModel->getCountRentalPostsByStatus('rejected');	
		
        ViewRender::renderWithLayout('admin/posts/posts',[
			'allPost' => $allPost,
			'pendingPost' => $pendingPost,
			'approvedPost' => $approvedPost,
			'rejectedPost' => $rejectedPost,
		],'admin/layouts/app');
    }

	public function pendingPostPage() {
		$pendingPost = $this->rentalPostModel->getCountRentalPostsByStatus('pending');
		ViewRender::renderWithLayout('admin/posts/pending',[
			'pendingPost' => $pendingPost,
		],'admin/layouts/app');
	}
	
	public function approvedPostPage() {
		$approvedPost = $this->rentalPostModel->getCountRentalPostsByStatus('approved');
		ViewRender::renderWithLayout('admin/posts/approved',[
			'approvedPost' => $approvedPost,
		],'admin/layouts/app');
	}
	
	public function rejectedPostPage() {
		$rejectedPost = $this->rentalPostModel->getCountRentalPostsByStatus('rejected');
		ViewRender::renderWithLayout('admin/posts/rejected',[
			'rejectedPost' => $rejectedPost,
		],'admin/layouts/app');
	}
	
}

