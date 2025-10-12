<?php

/*
Author: Huy Nguyen
Date: 2025-09-11
Purpose: Bill Customer Controller
 */

namespace App\Controllers\Customer;

use Core\ViewRender;
use Helpers\Format;

class BillCustomerController extends CustomerController {
    protected $sidebar = true;
    protected $noFooter = true;
    protected $title = 'Hóa đơn';

    public function __construct() {
        parent::__construct();
    }

    public function bills() {
        $data = $this->request->get();

        // Phân trang
        $page = isset($data['page']) ? (int) $data['page'] : 1;
        $limit = isset($data['per_page']) ? (int) $data['per_page'] : 10; // Số hóa đơn mỗi trang
        $offset = ($page - 1) * $limit;

        // Xây dựng điều kiện filter
        $filterData = [];
        if (!empty($data['status']) || !empty($data['month']) || !empty($data['year'])) {
            $data['month'] = !empty($data['month']) ? str_pad($data['month'], 2, '0', STR_PAD_LEFT) : date('m');
            $data['year'] = !empty($data['year']) ? $data['year'] : date('Y');

            $filterData = [
                'invoice_status' => $data['status'],
                'invoice_month' => $data['month'] . '-' . $data['year'],
            ];
        }

        // Lấy dữ liệu với phân trang
        $allInvoices = $this->invoiceModel->getAllInvoicesWithPagination($filterData, $limit, $offset);
        $totalInvoices = $this->invoiceModel->getTotalInvoicesCount($filterData);

        // Tính toán phân trang
        $totalPages = ceil($totalInvoices / $limit);
        $pagination = [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_items' => $totalInvoices,
            'items_per_page' => $limit,
            'has_prev' => $page > 1,
            'has_next' => $page < $totalPages,
            'prev_page' => $page > 1 ? $page - 1 : null,
            'next_page' => $page < $totalPages ? $page + 1 : null,
        ];

        // Lấy thống kê (không phân trang)
        $countAllInvoices = $this->invoiceModel->getAllInvoices();
        $countInvoicesPending = $this->invoiceModel->getAllInvoicesByStatus('pending');
        $countInvoicesPaid = $this->invoiceModel->getAllInvoicesByStatus('paid');
        $totalAmount = $this->invoiceModel->getTotalAmount();

        ViewRender::renderWithLayout(
            'customer/payment/bills',
            [
                'sidebar' => $this->sidebar,
                'noFooter' => $this->noFooter,
                'title' => $this->title,
                'allInvoices' => $allInvoices,
                'countAllInvoices' => count($countAllInvoices),
                'countInvoicesPending' => count($countInvoicesPending),
                'countInvoicesPaid' => count($countInvoicesPaid),
                'totalAmount' => Format::formatUnit($totalAmount['total'] ?? 0),
                'sidebarData' => $this->sidebarData(),
                'request' => $this->request,
                'pagination' => $pagination,
                'sidebarData' => $this->sidebarData(),
            ],
            'customer/layouts/app'
        );
    }

    public function paymentHistory() {
        $data = $this->request->get();
        $page = isset($data['page']) ? (int) $data['page'] : 1;
        $limit = isset($data['per_page']) ? (int) $data['per_page'] : 5;
        $offset = ($page - 1) * $limit;
        $paymentHistory = $this->paymentHistoryModel->getPaymentHistoryByUserIdWithPagination($this->userID, $limit, $offset);
        $totalPaymentHistory = $this->paymentHistoryModel->getPaymentHistoryCountByUserId($this->userID);
        $totalPages = ceil($totalPaymentHistory / $limit);

        $pagination = [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_items' => $totalPaymentHistory,
            'items_per_page' => $limit,
            'has_prev' => $page > 1,
            'has_next' => $page < $totalPages,
            'prev_page' => $page > 1 ? $page - 1 : null,
            'next_page' => $page < $totalPages ? $page + 1 : null,
        ];
        ViewRender::renderWithLayout(
            'customer/payment/payment-history',
            [
                'sidebar' => $this->sidebar,
                'noFooter' => $this->noFooter,
                'title' => $this->title,
                'paymentHistory' => $paymentHistory,
                'pagination' => $pagination,
                'request' => $this->request,
                'sidebarData' => $this->sidebarData(),
            ],
            'customer/layouts/app'
        );
    }
}
