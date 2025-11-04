<?php

/*
Author: Huy Nguyen
Date: 2025-10-23
Purpose: to support function download pdf file
 */

namespace Helpers;

use Exception;

class PDF {

    public static function createPDF($template, $filename, $data = []) {

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_left' => 8,
            'margin_right' => 8,
            'margin_top' => 8,
            'margin_bottom' => 8,
            'default_font' => 'DejaVuSans',
        ]);

        $view = self::getPDFTemplate($template, $data);
        $mpdf->WriteHTML($view);
        $mpdf->Output('' . $filename . '.pdf', 'D');
    }

    private static function getPDFTemplate($template, $data = []) {
        $templateFile = ROOT_PATH . '/views/template/pdf/' . $template . '.php';
        $baseFile = ROOT_PATH . '/views/template/pdf/base-pdf-template.php';

        if (!file_exists($templateFile) || !file_exists($baseFile)) {
            throw new Exception("Không tìm thấy template PDF");
        }

        // Truyền biến ra view
        extract($data);

        // Lưu nội dung view con vào biến $content
        ob_start();
        require_once $templateFile;
        $content = ob_get_clean();

        // Bây giờ include base và in ra nội dung $content
        ob_start();
        require_once $baseFile;
        return ob_get_clean(); // trả về HTML đầy đủ
    }
}
