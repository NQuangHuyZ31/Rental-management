<?php

namespace Helpers;

class Pagination
{
    /**
     * Render pagination HTML
     */
    public static function render($pagination, $baseUrl = '', $queryParams = [])
    {
        if ($pagination['total_pages'] <= 1) {
            return '';
        }

        $currentPage = $pagination['current_page'];
        $totalPages = $pagination['total_pages'];
        $totalItems = $pagination['total_items'];
        $itemsPerPage = $pagination['items_per_page'];

        // Tính toán range hiển thị
        $startPage = max(1, $currentPage - 2);
        $endPage = min($totalPages, $currentPage + 2);

        // Điều chỉnh range nếu gần đầu/cuối
        if ($currentPage <= 3) {
            $endPage = min($totalPages, 5);
        }
        if ($currentPage >= $totalPages - 2) {
            $startPage = max(1, $totalPages - 4);
        }

        $html = '<div class="flex items-center justify-between bg-white px-4 py-3 border-t border-gray-200 sm:px-6 rounded-lg shadow-sm">';
        
        // Thông tin hiển thị
        $startItem = ($currentPage - 1) * $itemsPerPage + 1;
        $endItem = min($currentPage * $itemsPerPage, $totalItems);
        
        $html .= '<div class="flex-1 flex justify-between sm:hidden">';
        $html .= '<div class="text-sm text-gray-700">';
        $html .= "Hiển thị <span class=\"font-medium\">{$startItem}</span> đến <span class=\"font-medium\">{$endItem}</span> của <span class=\"font-medium\">{$totalItems}</span> kết quả";
        $html .= '</div>';
        $html .= '</div>';

        // Desktop pagination
        $html .= '<div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">';
        $html .= '<div class="text-sm text-gray-700">';
        $html .= "Hiển thị <span class=\"font-medium\">{$startItem}</span> đến <span class=\"font-medium\">{$endItem}</span> của <span class=\"font-medium\">{$totalItems}</span> kết quả";
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">';

        // Previous button
        if ($pagination['has_prev']) {
            $prevUrl = self::buildUrl($baseUrl, $queryParams, $pagination['prev_page']);
            $html .= '<a href="' . $prevUrl . '" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">';
            $html .= '<span class="sr-only">Trang trước</span>';
            $html .= '<i class="fas fa-chevron-left h-5 w-5"></i>';
            $html .= '</a>';
        } else {
            $html .= '<span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">';
            $html .= '<span class="sr-only">Trang trước</span>';
            $html .= '<i class="fas fa-chevron-left h-5 w-5"></i>';
            $html .= '</span>';
        }

        // First page
        if ($startPage > 1) {
            $firstUrl = self::buildUrl($baseUrl, $queryParams, 1);
            $html .= '<a href="' . $firstUrl . '" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>';
            
            if ($startPage > 2) {
                $html .= '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
            }
        }

        // Page numbers
        for ($i = $startPage; $i <= $endPage; $i++) {
            if ($i == $currentPage) {
                $html .= '<span class="relative inline-flex items-center px-4 py-2 border border-green-500 bg-green-50 text-sm font-medium text-green-600">' . $i . '</span>';
            } else {
                $pageUrl = self::buildUrl($baseUrl, $queryParams, $i);
                $html .= '<a href="' . $pageUrl . '" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">' . $i . '</a>';
            }
        }

        // Last page
        if ($endPage < $totalPages) {
            if ($endPage < $totalPages - 1) {
                $html .= '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
            }
            
            $lastUrl = self::buildUrl($baseUrl, $queryParams, $totalPages);
            $html .= '<a href="' . $lastUrl . '" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">' . $totalPages . '</a>';
        }

        // Next button
        if ($pagination['has_next']) {
            $nextUrl = self::buildUrl($baseUrl, $queryParams, $pagination['next_page']);
            $html .= '<a href="' . $nextUrl . '" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">';
            $html .= '<span class="sr-only">Trang sau</span>';
            $html .= '<i class="fas fa-chevron-right h-5 w-5"></i>';
            $html .= '</a>';
        } else {
            $html .= '<span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">';
            $html .= '<span class="sr-only">Trang sau</span>';
            $html .= '<i class="fas fa-chevron-right h-5 w-5"></i>';
            $html .= '</span>';
        }

        $html .= '</nav>';
        $html .= '</div>';
        $html .= '</div>';

        // Mobile pagination
        $html .= '<div class="sm:hidden">';
        $html .= '<div class="flex justify-between">';
        
        if ($pagination['has_prev']) {
            $prevUrl = self::buildUrl($baseUrl, $queryParams, $pagination['prev_page']);
            $html .= '<a href="' . $prevUrl . '" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Trang trước</a>';
        } else {
            $html .= '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">Trang trước</span>';
        }
        
        if ($pagination['has_next']) {
            $nextUrl = self::buildUrl($baseUrl, $queryParams, $pagination['next_page']);
            $html .= '<a href="' . $nextUrl . '" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Trang sau</a>';
        } else {
            $html .= '<span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">Trang sau</span>';
        }
        
        $html .= '</div>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    /**
     * Build URL with query parameters
     */
    private static function buildUrl($baseUrl, $queryParams, $page)
    {
        $params = array_merge($queryParams, ['page' => $page]);
        $queryString = http_build_query($params);
        
        if ($baseUrl) {
            return $baseUrl . '?' . $queryString;
        }
        
        return '?' . $queryString;
    }

    /**
     * Simple pagination for small datasets
     */
    public static function renderSimple($pagination, $baseUrl = '', $queryParams = [])
    {
        if ($pagination['total_pages'] <= 1) {
            return '';
        }

        $currentPage = $pagination['current_page'];
        $totalPages = $pagination['total_pages'];

        $html = '<div class="flex items-center justify-center space-x-2 mt-6">';

        // Previous
        if ($pagination['has_prev']) {
            $prevUrl = self::buildUrl($baseUrl, $queryParams, $pagination['prev_page']);
            $html .= '<a href="' . $prevUrl . '" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50">';
            $html .= '<i class="fas fa-chevron-left mr-1"></i>Trước';
            $html .= '</a>';
        }

        // Page info
        $html .= '<span class="px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md">';
        $html .= "Trang {$currentPage} / {$totalPages}";
        $html .= '</span>';

        // Next
        if ($pagination['has_next']) {
            $nextUrl = self::buildUrl($baseUrl, $queryParams, $pagination['next_page']);
            $html .= '<a href="' . $nextUrl . '" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50">';
            $html .= 'Sau<i class="fas fa-chevron-right ml-1"></i>';
            $html .= '</a>';
        }

        $html .= '</div>';

        return $html;
    }
}
