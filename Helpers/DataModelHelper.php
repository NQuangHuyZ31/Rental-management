<?php

/*

 * Author: Huy Nguyen
 * Date: 2025-09-19
 * Purpose: Helper for data model
 */

namespace Helpers;

use App\Models\RenTalPost;
use App\Models\RentalPostInterest;
use App\Models\ReportViolation;
use Core\QueryBuilder;
use Core\Session;

class DataModelHelper {
    protected $rentalPostModel;
    protected $rentalPostInterestModel;
    protected $reportModel;
    protected $queryBuilder;

    public function __construct() {
        $this->rentalPostModel = new RenTalPost();
        $this->rentalPostInterestModel = new RentalPostInterest();
        $this->reportModel = new ReportViolation();
        $this->queryBuilder = new QueryBuilder();
    }

    public function getRentalPostStatus($status) {
        return $this->rentalPostModel->getCountRentalPostsByStatus(['pending']);
    }

    // Added by Huy Nguyen on 2025-10-20 to get all post interesting by user id
    public function countPostInterestById() {
        if (!Session::get('user')) {
            return 0;
        }

        return count($this->rentalPostInterestModel->getByUserId(Session::get('user')['id'])) ?? 0;
    }

    // Added by Huy Nguyen on 2025-12-07 to get report count by status
    public function getReportCountByStatus($status) {
        // Assuming there's a Report model to handle reports

        return count($this->reportModel->getColumn(['id'], 'report_violations','', ['status' => ['value' => $status]])) ?? 0;
    }

    // Added by Huy Nguyen on 2025-12-07 to get customer support count not processed
    public function getCustomerSupportCountNotProcessed() {
        return count($this->queryBuilder->table('customer_supports')
            ->whereNull('date_process')
            ->where('deleted', 0)
            ->get()) ?? 0;
    }
}