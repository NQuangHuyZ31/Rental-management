<?php

namespace App\Controllers;

// Include ViewHelper
require_once __DIR__ . '/../../Helpers/view.php';

class DemoController extends Controller
{
    /**
     * Demo cách sử dụng ViewHelper
     */
    public function index()
    {
        // Dữ liệu mẫu
        $data = [
            'title' => 'Demo ViewHelper - LOZIDO',
            'user' => [
                'name' => 'Nguyễn Văn A',
                'email' => 'nguyenvana@example.com',
                'phone' => '0123456789',
                'role' => 'Khách hàng'
            ],
            'products' => [
                [
                    'name' => 'Phòng trọ 1',
                    'description' => 'Phòng trọ đẹp, gần trường học',
                    'price' => 2500000
                ],
                [
                    'name' => 'Phòng trọ 2',
                    'description' => 'Phòng trọ cao cấp, đầy đủ tiện nghi',
                    'price' => 3500000
                ],
                [
                    'name' => 'Phòng trọ 3',
                    'description' => 'Phòng trọ giá rẻ, phù hợp sinh viên',
                    'price' => 1800000
                ]
            ],
            'message' => 'Chào mừng bạn đến với hệ thống quản lý cho thuê LOZIDO!'
        ];
        
        // Render view với dữ liệu và layout
        return view('demo-view', $data, 'layouts/app');
    }
    
    /**
     * Demo render view đơn giản
     */
    public function simple()
    {
        $data = [
            'title' => 'View Đơn Giản',
            'message' => 'Đây là một view đơn giản không có layout'
        ];
        
        return view('demo-view', $data);
    }
    
    /**
     * Demo render partial
     */
    public function partial()
    {
        $data = [
            'title' => 'Demo Partial Views',
            'sections' => [
                'header' => ['title' => 'Header Section'],
                'sidebar' => ['menu' => ['Trang chủ', 'Giới thiệu', 'Liên hệ']],
                'footer' => ['copyright' => '© 2024 LOZIDO']
            ]
        ];
        
        $html = '';
        
        // Render từng partial
        foreach ($data['sections'] as $section => $sectionData) {
            $html .= partial($section, $sectionData);
        }
        
        return $html;
    }
    
    /**
     * Demo render component
     */
    public function component()
    {
        $data = [
            'title' => 'Demo Components',
            'users' => [
                ['name' => 'User 1', 'email' => 'user1@example.com'],
                ['name' => 'User 2', 'email' => 'user2@example.com'],
                ['name' => 'User 3', 'email' => 'user3@example.com']
            ]
        ];
        
        $html = '';
        
        // Render user list component
        $html .= component('user-list', $data);
        
        return $html;
    }
    
    /**
     * Demo với dữ liệu từ database
     */
    public function withDatabase()
    {
        // Giả lập dữ liệu từ database
        $users = $this->getUsersFromDatabase();
        $products = $this->getProductsFromDatabase();
        
        $data = [
            'title' => 'Dữ liệu từ Database',
            'users' => $users,
            'products' => $products,
            'totalUsers' => count($users),
            'totalProducts' => count($products)
        ];
        
        return view('demo-view', $data, 'layouts/app');
    }
    
    /**
     * Demo error handling
     */
    public function error()
    {
        try {
            // Cố tình gây lỗi để demo error handling
            $data = [
                'title' => 'Demo Error Handling',
                'message' => 'View này sẽ gây lỗi để demo cách xử lý'
            ];
            
            return view('non-existent-view', $data);
            
        } catch (\Exception $e) {
            return $this->handleError($e);
        }
    }
    
    /**
     * Xử lý lỗi
     */
    private function handleError(\Exception $e)
    {
        $errorData = [
            'title' => 'Lỗi',
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ];
        
        return view('error', $errorData);
    }
    
    /**
     * Giả lập lấy dữ liệu users từ database
     */
    private function getUsersFromDatabase()
    {
        return [
            [
                'id' => 1,
                'name' => 'Nguyễn Văn A',
                'email' => 'nguyenvana@example.com',
                'phone' => '0123456789',
                'role' => 'Khách hàng',
                'created_at' => '2024-01-15'
            ],
            [
                'id' => 2,
                'name' => 'Trần Thị B',
                'email' => 'tranthib@example.com',
                'phone' => '0987654321',
                'role' => 'Chủ nhà',
                'created_at' => '2024-01-10'
            ],
            [
                'id' => 3,
                'name' => 'Lê Văn C',
                'email' => 'levanc@example.com',
                'phone' => '0555666777',
                'role' => 'Môi giới',
                'created_at' => '2024-01-05'
            ]
        ];
    }
    
    /**
     * Giả lập lấy dữ liệu products từ database
     */
    private function getProductsFromDatabase()
    {
        return [
            [
                'id' => 1,
                'name' => 'Phòng trọ cao cấp',
                'description' => 'Phòng trọ đầy đủ tiện nghi, gần trung tâm',
                'price' => 4500000,
                'location' => 'Quận 1, TP.HCM',
                'area' => '25m²',
                'status' => 'Còn trống'
            ],
            [
                'id' => 2,
                'name' => 'Phòng trọ sinh viên',
                'description' => 'Phòng trọ giá rẻ, phù hợp sinh viên',
                'price' => 2000000,
                'location' => 'Quận 3, TP.HCM',
                'area' => '20m²',
                'status' => 'Đã cho thuê'
            ],
            [
                'id' => 3,
                'name' => 'Căn hộ mini',
                'description' => 'Căn hộ mini view đẹp, tiện nghi hiện đại',
                'price' => 6000000,
                'location' => 'Quận 7, TP.HCM',
                'area' => '35m²',
                'status' => 'Còn trống'
            ]
        ];
    }
}
