<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Border;
use stdClass;

class C_Excel extends Controller
{
    public function createExcel($sheets, $folder, $name, $alignment_width)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0);

        foreach ($sheets as $i => $item) {
            $spreadsheet->createSheet($i)->setTitle($item->name);
            $sheet = $spreadsheet->getSheetByName($item->name);
            $bold_rows = $item->bold_rows;
            $bold_italic_rows = $item->bold_italic_rows;
            $italic_rows = $item->italic_rows;
            $sheet->fromArray($item->header, NULL, "A" . 1);
            foreach ($item->data as $index => $dt) {
                $sheet->fromArray($dt, NULL, "A" . ($index + 2));
            }

            $sheet = $this->autoWidthExcel($sheet, $alignment_width, $bold_rows, $bold_italic_rows, $italic_rows);
        }

        $fileName = $name . ".xlsx";
        $writer = new Xlsx($spreadsheet);
        $public_folder = public_path($folder);
        if (!is_dir($public_folder))
            mkdir($public_folder, 0777, true);
        $path = $folder . "/" . $fileName;
        $writer->save($path);
        header("Content-Type: application/vnd.ms-excel");

        return $path;
    }

    public function autoWidthExcel($sheet, $alignment_width, $bold_rows, $bold_italic_rows, $italic_rows)
    {
        $nb_sheet = $sheet->getHighestRow();
        $lastColumnIndex_sheet = $sheet->getHighestDataColumn();
        $last_col_sheet = Coordinate::columnIndexFromString($lastColumnIndex_sheet);
        $rangeLastCol = $lastColumnIndex_sheet . $nb_sheet;

        // Thiết lập kiểu font và căn giữa
        $sheet->getStyle("A1:$rangeLastCol")->getFont()->setSize(13)->setName("Times New Roman");
        $sheet->getStyle("A1:$rangeLastCol")->getAlignment()->setVertical("center");

        // filter và đóng băng
        $sheet->setAutoFilter("A1:$rangeLastCol");

        for ($col = 1; $col <= $last_col_sheet; $col++) {
            $colLetter = Coordinate::stringFromColumnIndex($col);
            for ($row = 1; $row <= $nb_sheet; $row++) {
                $cell = $sheet->getCellByColumnAndRow($col, $row);
                $cellValue = $cell->getValue();
                $cell->getStyle()
                    ->getAlignment()
                    ->setWrapText(true);

                // Kiểm tra và định dạng giá trị số
                if (is_numeric($cellValue)) {
                    $cellCoordinate = $colLetter . $row; // Địa chỉ ô, ví dụ: A1, B2

                    // Format căn phải nếu là số
                    $sheet->getStyle($cellCoordinate)->getAlignment()->setHorizontal("right");
                    if (strpos((string) $cellValue, ".") !== false) {
                        // Tách phần nguyên và phần thập phân
                        $parts = explode('.', (string) $cellValue);
                        $decimalCount = isset($parts[1]) ? strlen($parts[1]) : 0; // Đếm số chữ số sau dấu thập phân

                        if ($decimalCount > 3)
                            $decimalCount = 2;
                        // Tạo định dạng số thực với số lượng chữ số thập phân tương ứng
                        $formatCode = "#,##0." . str_repeat('0', $decimalCount);
                        $sheet->getStyle($cellCoordinate)
                            ->getNumberFormat()
                            ->setFormatCode($formatCode);
                    } else {
                        // Format số nguyên
                        $sheet->getStyle($cellCoordinate)
                            ->getNumberFormat()
                            ->setFormatCode("#,##0");
                    }
                }
            }
        }

        // Căn lề
        $rowStart = 1;
        foreach ($alignment_width as $index => $align) {
            $columnLetter = chr(65 + $index);
            $range = $columnLetter . $rowStart . ':' . $columnLetter . $nb_sheet;
            $sheet->getStyle($range)->getAlignment()->setHorizontal($align[0]);
            $sheet->getColumnDimension($columnLetter)->setWidth($align[1]);
        }

        if (count($bold_rows) > 0) {
            foreach ($bold_rows as $row) {
                $sheet->getStyle("A{$row}:$lastColumnIndex_sheet{$row}")->getFont()->setBold(true);
                $sheet->getStyle("A{$row}:$lastColumnIndex_sheet{$row}")->getAlignment()->setHorizontal('center');
            }
        }

        if (count($bold_italic_rows) > 0) {
            foreach ($bold_italic_rows as $row) {
                $sheet->getStyle("A{$row}:$lastColumnIndex_sheet{$row}")->getFont()->setBold(true);
                $sheet->getStyle("A{$row}:$lastColumnIndex_sheet{$row}")->getFont()->setItalic(true);
            }
        }

        if (count($italic_rows) > 0) {
            foreach ($italic_rows as $row) {
                $sheet->getStyle("A{$row}:$lastColumnIndex_sheet{$row}")->getFont()->setItalic(true);
            }
        }

        $sheet->getStyle("A1:$rangeLastCol")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        return $sheet;
    }

    public function export($header, $data, $fol, $name, $row_bold = [1], $row_bold_italic = [], $row_italic = [], $alignment_width = [])
    {
        $sheet = new stdClass();
        $sheet->header = $header;
        $sheet->data = $data;
        $sheet->name = $name;
        $sheet->bold_rows = $row_bold;
        $sheet->bold_italic_rows = $row_bold_italic;
        $sheet->italic_rows = $row_italic;
        return asset($this->createExcel([$sheet], $fol, $sheet->name, $alignment_width));
    }
}
