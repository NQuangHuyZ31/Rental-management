<?php

/*

Author: Huy Nguyen
Date: 2025-09-09
Purpose: Controller for dashboard admin
 */

namespace App\Controllers\Admin;

use Core\ViewRender;

class DashboardAdminController extends AdminController {
    public function dashboard() {
        $allUsers = $this->userModel->getAllUsers();
        $allPost = $this->rentalPostModel->getAllRentalPosts(false);
        $allPostPending = $this->rentalPostModel->getCountRentalPostsByStatus(['pending']);
        $allPostCurrent = $this->rentalPostModel->getRentalPostCurrent(5);
        $allTransaction = $this->paymentHostoryModel->getAll('',
            [
                'created_at' => [
                    'condition' => '>=',
                    'value' => date('Y-m-01 00:00:00'),
                ],
                'created_at' => [
                    '<=',
                    'value' => date('Y-m-d H:s:i'),
                ],
            ]
        );
        $allReportCurrent = $this->reportViolationModel->getAll('', [], 5, 'created_at');
        // chart data
        $chartData = $this->getChartData();

        ViewRender::renderWithLayout('admin/index', [
            'countUsers' => count($allUsers),
            'countPost' => count($allPost),
            'countPostPending' => $allPostPending,
            'countTransaction' => count($allTransaction),
            'allPostCurrent' => $allPostCurrent,
            'allReportCurrent' => $allReportCurrent,
            'chartData' => $chartData,
        ], 'admin/layouts/app');
    }

    public function chartHeader() {
        return [
            [
                'name' => 'posts_by_month',
                'label' => 'Bài đăng theo tháng trong năm ' . date('Y'),
            ],
            [
                'name' => 'user_by_month',
                'label' => 'Người dùng theo tháng trong năm ' . date('Y'),
            ],
            [
                'name' => 'post_by_approved_status',
                'label' => 'Bài đăng theo trạng thái duyệt',
            ],

            [
                'name' => 'transaction_by_month',
                'label' => 'Giao dịch theo tháng trong năm ' . date('Y'),
            ],
        ];
    }

    public function getChartData() {
        $data = [];
        $data['posts_by_month'] = $this->postsByMonth();
        $data['user_by_month'] = $this->userByMonth();
        $data['post_by_approved_status'] = $this->postByApprovedStatus();
        $data['transaction_by_month'] = $this->transactionByMonth();

        return [
            'header' => $this->chartHeader(),
            'data' => $data,
        ];
    }

    public function userByMonth() {
        $sql = "SELECT COUNT(*) as total_users, MONTH(created_at) as month FROM users WHERE YEAR(created_at) = YEAR(CURRENT_DATE()) GROUP BY MONTH(created_at) ORDER BY month";
        $userByMonth = $this->queryBuilder->query($sql);

        $categories = [];
        $series = [];

        while ($row = $userByMonth->fetch()) {
            $categories[] = 'Tháng ' . $row['month'];
            $series[] = (int) $row['total_users'];
        }

        // If no data, return empty structure
        if (empty($categories)) {
            return [
                'type' => 'column',
                'title' => 'Người dùng mới trong năm ' . date('Y'),
                'categories' => [],
                'series' => [
                    [
                        'name' => 'Người dùng mới',
                        'data' => [],
                    ],
                ],
                'yAxisTitle' => 'Số lượng người dùng',
            ];
        }

        return [
            'type' => 'column',
            'title' => 'Người dùng mới trong năm ' . date('Y'),
            'categories' => $categories,
            'series' => [
                [
                    'name' => 'Người dùng mới',
                    'data' => $series,
                ],
            ],
            'yAxisTitle' => 'Số lượng người dùng',
        ];
    }

    public function postsByMonth() {
        $sql = "SELECT COUNT(*) as total_posts, MONTH(created_at) as month FROM rental_posts WHERE YEAR(created_at) = YEAR(CURRENT_DATE()) AND deleted = 0 GROUP BY MONTH(created_at) ORDER BY month";
        $postsByMonth = $this->queryBuilder->query($sql);

        $categories = [];
        $series = [];

        while ($row = $postsByMonth->fetch()) {
            $categories[] = 'Tháng ' . $row['month'];
            $series[] = (int) $row['total_posts'];
        }

        return [
            'type' => 'column',
            'title' => 'Bài đăng theo tháng trong năm ' . date('Y'),
            'categories' => $categories,
            'series' => [
                [
                    'name' => 'Bài đăng',
                    'data' => $series,
                ],
            ],
            'yAxisTitle' => 'Số lượng bài đăng',
        ];
    }

    public function postByApprovedStatus() {
        $sql = "SELECT COUNT(*) as total_posts, approval_status FROM rental_posts WHERE deleted = 0 GROUP BY approval_status";
        $postByApprovedStatus = $this->queryBuilder->query($sql);

        $categories = [];
        $series = [];

        while ($row = $postByApprovedStatus->fetch()) {
            $statusText = '';
            switch ($row['approval_status']) {
            case 'pending':
                $statusText = 'Chờ duyệt';
                break;
            case 'approved':
                $statusText = 'Đã duyệt';
                break;
            case 'rejected':
                $statusText = 'Từ chối';
                break;
            default:
                $statusText = $row['approval_status'];
            }
            $categories[] = $statusText;
            $series[] = (int) $row['total_posts'];
        }

        return [
            'type' => 'pie',
            'title' => 'Bài đăng theo trạng thái duyệt',
            'categories' => $categories,
            'series' => [
                [
                    'name' => 'Bài đăng',
                    'data' => array_map(function ($category, $value) {
                        return ['name' => $category, 'y' => $value];
                    }, $categories, $series),
                ],
            ],
        ];
    }

    public function transactionByMonth() {
        $sql = "SELECT COUNT(*) as total_transactions, MONTH(created_at) as month FROM payment_histories WHERE YEAR(created_at) = YEAR(CURRENT_DATE()) AND deleted = 0 GROUP BY MONTH(created_at) ORDER BY month";
        $transactionByMonth = $this->queryBuilder->query($sql);

        $categories = [];
        $series = [];
        if ($transactionByMonth->rowCount() === 0) {
            return [];
        }

        while ($row = $transactionByMonth->fetch()) {
            $categories[] = 'Tháng ' . $row['month'];
            $series[] = (int) $row['total_transactions'];
        }

        return [
            'type' => 'column',
            'title' => 'Giao dịch theo tháng trong năm ' . date('Y'),
            'categories' => $categories,
            'series' => [
                [
                    'name' => 'Giao dịch',
                    'data' => $series,
                ],
            ],
        ];
    }
}