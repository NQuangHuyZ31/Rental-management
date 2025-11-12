<?php
/*
 * Author: Nguyen Xuan Duong
 * Date: 2025-10-26
 * Purpose: Report Management Controller - Admin
 */

namespace App\Controllers\Admin;

use Core\ViewRender;
use Core\Session;
use Core\Response;
use Core\CSRF;

class ReportManagementController extends AdminController
{
    protected $title = 'Quản lý báo cáo';

    public function index()
    {
        // Pagination & filters (follow pattern from UserManagementController)
        $page = $this->request->get('page') != '' ? (int) $this->request->get('page') : 1;
        $limit = $this->limit;
        $offset = ($page - 1) * $limit;
        $filters = [];
        $requests = $this->request->get();

        foreach ($requests as $key => $filter) {
            if (!isset($filter[$key]) && $filter != '') {
                $filters[$key] = $filter;
            }
        }

        // Get total and paginated reports
        $totalReports = $this->reportViolationModel->getReports($filters, $limit, $offset, true);
        $reports = $this->reportViolationModel->getReports($filters, $limit, $offset, false);

        // Global total (do NOT apply current filters) for stats card
        $globalTotalReports = $this->reportViolationModel->getReports([], $limit, 0, true);

        // Pagination data
        $pagination = $this->getPagination($page, $totalReports, $limit, $offset);

        // Stats counts: use global counts (do NOT apply current filters) so stats remain stable
        $countPending = $this->reportViolationModel->getReports(['status' => 'pending'], $limit, 0, true);
        $countProcessing = $this->reportViolationModel->getReports(['status' => 'reviewed'], $limit, 0, true);
        $countResolved = $this->reportViolationModel->getReports(['status' => 'resolved'], $limit, 0, true);

        // Label maps (defined in controller)
        $statusList = $this->getStatusList();
        $typeList = $this->getTypeList();

        // Pass data to view
        ViewRender::renderWithLayout('admin/reports/reports', [
            'reports' => $reports,
            'pagination' => $pagination,
            'queryParams' => $filters,
            'filter' => $filters,
            'totalReports' => $totalReports,
            'globalTotalReports' => $globalTotalReports,
            'countPending' => $countPending,
            'countProcessing' => $countProcessing,
            'countResolved' => $countResolved,
            'statusList' => $statusList,
            'typeList' => $typeList,
            'title' => $this->title
        ], 'admin/layouts/app');
    }

    /**
     * Return report details as JSON for modal view
     */
    public function edit($id)
    {
        try {
            $report = $this->reportViolationModel->getReportById($id);

            if (!$report) {
                return Response::json([
                    'success' => false,
                    'message' => 'Không tìm thấy báo cáo',
                ], 404);
            }

            // Attach human readable labels from controller maps
            $typeList = $this->getTypeList();
            $statusList = $this->getStatusList();

            if (is_array($report)) {
                $report['type_label'] = $typeList[$report['violattion_type']] ?? $report['violattion_type'];
                $report['status_label'] = $statusList[$report['status']] ?? $report['status'];
            } else {
                // object
                $report->type_label = $typeList[$report->violattion_type] ?? $report->violattion_type;
                $report->status_label = $statusList[$report->status] ?? $report->status;
            }

            return Response::json([
                'success' => true,
                'report' => $report,
            ], 200);
        } catch (\Exception $e) {
            error_log('Error in ReportManagementController@edit: ' . $e->getMessage());
            return Response::json([
                'success' => false,
                'message' => 'Có lỗi xảy ra',
            ], 500);
        }
    }

    /**
     * Update report status (AJAX POST)
     * Expected POST body: { status: 'reviewed' | 'resolved' | 'rejected' }
     */
    public function updateStatus($id)
    {
        // Only allow POST
        if (!$this->request->isPost()) {
            return Response::json(['success' => false, 'message' => 'Phương thức không hợp lệ'], 405);
        }

        // Validate CSRF token
        if (!CSRF::validatePostRequest()) {
            return Response::json(['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại'], 403);
        }

        try {
            $status = $this->request->post('status') ?? $this->request->input('status') ?? null;
            // Admin supplied note (optional but handled) - available as POST 'note'
            $noteInput = trim($this->request->post('note', ''));
            $allowed = ['reviewed', 'resolved', 'rejected'];

            if (!$status || !in_array($status, $allowed)) {
                return Response::json(['success' => false, 'message' => 'Trạng thái không hợp lệ'], 400);
            }

            $data = [];
            // set admin id if available
            if (!empty($this->userID)) {
                $data['admin_id'] = $this->userID;
            }

            // if resolved, set resolved_at to today
            if ($status === 'resolved') {
                $data['resolved_at'] = date('Y-m-d');
            }

            // Append action_taken entry with timestamp and admin info
            $now = date('Y-m-d H:i:s');
            $adminName = Session::get('user')['username'] ?? null;
            $adminId = $this->userID ?? null;
            $statusLabels = $this->getStatusList();
            $statusLabel = $statusLabels[$status] ?? $status;

            $report = $this->reportViolationModel->getReportById($id);
            $prevAction = '';
            if ($report) {
                if (is_array($report)) {
                    $prevAction = trim($report['action_taken'] ?? '');
                } else {
                    $prevAction = trim($report->action_taken ?? '');
                }
            }

            // Use admin username only when available; do not append the numeric id in parentheses
            if ($adminName) {
                $actor = $adminName;
            } elseif ($adminId) {
                // fallback to admin id if username not available
                $actor = "admin_id#{$adminId}";
            } else {
                $actor = '';
            }
            $entry = sprintf('[%s] %s cập nhật trạng thái thành: %s', $now, $actor, $statusLabel);
            $newAction = $prevAction !== '' ? ($prevAction . "\n" . $entry) : $entry;
            $data['action_taken'] = $newAction;

            // Handle admin note: append with timestamp and actor similar to action_taken
            if ($noteInput !== '') {
                $prevNote = '';
                if ($report) {
                    if (is_array($report)) {
                        $prevNote = trim($report['note'] ?? '');
                    } else {
                        $prevNote = trim($report->note ?? '');
                    }
                }
                $noteEntry = sprintf('[%s] %s ghi chú: %s', $now, $actor, $noteInput);
                $newNote = $prevNote !== '' ? ($prevNote . "\n" . $noteEntry) : $noteEntry;
                $data['note'] = $newNote;
            }
            $data['updated_at'] = $now;

            $updated = $this->reportViolationModel->updateStatus($id, $status, $data);

            if ($updated === false) {
                return Response::json(['success' => false, 'message' => 'Cập nhật không thành công'], 500);
            }

            // Return updated report for client to display (attach labels)
            $updatedReport = $this->reportViolationModel->getReportById($id);
            $typeList = $this->getTypeList();
            $statusList = $this->getStatusList();
            if (is_array($updatedReport)) {
                $updatedReport['type_label'] = $typeList[$updatedReport['violattion_type']] ?? $updatedReport['violattion_type'];
                $updatedReport['status_label'] = $statusList[$updatedReport['status']] ?? $updatedReport['status'];
            } else if ($updatedReport) {
                $updatedReport->type_label = $typeList[$updatedReport->violattion_type] ?? $updatedReport->violattion_type;
                $updatedReport->status_label = $statusList[$updatedReport->status] ?? $updatedReport->status;
            }

            return Response::json(['success' => true, 'message' => 'Cập nhật trạng thái thành công', 'report' => $updatedReport], 200);
        } catch (\Exception $e) {
            error_log('Error in ReportManagementController@updateStatus: ' . $e->getMessage());
            return Response::json(['success' => false, 'message' => 'Có lỗi xảy ra'], 500);
        }
    }

    /**
     * Status label map (controller source of truth)
     * @return array
     */
    private function getStatusList()
    {
        return [
            'pending' => 'Chờ xử lý',
            'reviewed' => 'Đang xử lý',
            'resolved' => 'Đã xử lý',
            'rejected' => 'Bị từ chối'
        ];
    }

    /**
     * Report type label map
     * @return array
     */
    private function getTypeList()
    {
        return [
            'spam' => 'Spam',
            'fake' => 'Thông tin sai lệch',
            'scam' => 'Lừa đảo',
            'inappropriate' => 'Nội dung không phù hợp',
            'violence' => 'Bạo lực',
            'other' => 'Khác'
        ];
    }
}
