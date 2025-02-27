<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Illuminate\Support\Facades\File;

class C_PDF extends Controller
{
    public function exportPdf(array $header, array $data, string $title, string $folder, string $fileName, array $alignment_width, string $orientation = 'P')
    {
        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        $folderPath = public_path($folder);
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        // Tạo đối tượng Mpdf với chế độ xoay trang
        $mpdf = new Mpdf(['orientation' => $orientation]);

        // Thêm tiêu đề
        $html = '<h2 style="text-align: center;">' . $title . '</h2>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse: collapse;">';
        $html .= '<tr>';
        foreach ($header as $col) {
            $html .= "<th style='background-color: #f2f2f2; text-align: center;'>$col</th>";
        }
        $html .= '</tr>';

        // Thêm dữ liệu
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $index => $value) {
                $align = $alignment_width[$index][0] ?? 'left'; // Mặc định căn trái
                $html .= "<td style='text-align: $align;'>$value</td>";
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        // Xuất PDF
        $mpdf->WriteHTML($html);
        $filePath = "$folderPath/$fileName";
        $mpdf->Output($filePath, 'F');

        return asset("$folder/$fileName");
    }
}
