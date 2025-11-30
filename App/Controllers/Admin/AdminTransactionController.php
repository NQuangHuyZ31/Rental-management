<?php
/*
Author: Huy Nguyen
Date: 2025-11-30
Purpose: Admin Transaction Controller
 */

namespace App\Controllers\Admin;

use App\Models\House;
use App\Models\Invoice;
use App\Models\Room;
use Core\ViewRender;
use Helpers\Format;

class AdminTransactionController extends AdminController {
    protected $title = 'Giao dịch';
    protected $limit = 5;
    protected $invoiceModel;
    protected $roomModel;
    protected $houseModel;

    public function __construct() {
        parent::__construct();
        $this->invoiceModel = new Invoice();
        $this->roomModel = new Room();
        $this->houseModel = new House();
    }

    // Added by Huy Nguyen on 2025-11-30 to show transaction page
    public function showTransactionPage() {
        $page = $this->request->get('page') != '' ? (int) $this->request->get('page') : 1;
        $limit = $this->limit; // Items per page
        $offset = ($page - 1) * $limit;

        $allTransaction = $this->paymentHostoryModel->getAll();
        $transactionsThisMonth = $this->paymentHostoryModel->getAll('payment_histories', [
            'created_at' => [
                [
                    'condition' => '>=',
                    'value' => date('Y-m-01 00:00:00'),
                ],
                [
                    'condition' => '<=',
                    'value' => date('Y-m-d H:i:s'),
                ],
            ],
        ], 0, 'created_at', 'DESC');

        $totalTransactionAmount = 0;
        foreach ($allTransaction as $transaction) {
            $totalTransactionAmount += $transaction['amount'];
        }

        $totalTransactionAmountThisMonth = 0;
        foreach ($transactionsThisMonth as $transaction) {
            $totalTransactionAmountThisMonth += $transaction['amount'];
        }

        $allTransactionData = $this->paymentHostoryModel->getAll('payment_histories', [], $limit, 'created_at', 'DESC', $offset);
        $transactionData = [];

        foreach ($allTransactionData as $transaction) {
            $item = $transaction;
            $item['payer_name'] = $this->userModel->getColumn('username', 'users', $transaction['payer_id']);
            $item['receiver_name'] = $this->userModel->getColumn('username', 'users', $transaction['receiver_id']);
            $item['invoice'] = $this->invoiceModel->getInvoiceById($transaction['invoice_id']);
            $item['room'] = $this->roomModel->getRoomById($item['invoice']['room_id']);
            $item['house'] = $this->houseModel->getHouseById($item['room']['house_id']);
            $transactionData[] = $item;
        }

        $pagination = $this->getPagination($page, count($allTransaction), $limit, $offset);

        ViewRender::renderWithLayout('admin/transaction/transaction', [
            'title' => $this->title,
            'allTransaction' => count($allTransaction),
            'transactionsThisMonth' => count($transactionsThisMonth),
            'totalTransactionAmount' => Format::forMatPrice($totalTransactionAmount),
            'totalTransactionAmountThisMonth' => Format::forMatPrice($totalTransactionAmountThisMonth),
            'transactionData' => $transactionData,
            'pagination' => $pagination,
            'queryParams' => [],
        ], 'admin/layouts/app');
    }
}