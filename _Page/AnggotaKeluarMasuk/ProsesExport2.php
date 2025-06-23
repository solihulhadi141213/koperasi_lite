<?php
    require '../../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
    // Membuat objek Spreadsheet baru
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    // Menulis judul
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'NIP');
    $sheet->setCellValue('C1', 'Nomor Identitas');
    $sheet->setCellValue('D1', 'Jenis Identitas');
    // Mengatur gaya baris judul
    $sheet->getStyle('A1:D1')->getFont()->setBold(true);
    $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    // Membuat objek Writer untuk menulis Spreadsheet ke dalam file XLSX
    $writer = new Xlsx($spreadsheet);
    
    // Menyimpan file XLSX
    $filename = 'Data-Karyawan.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'. $filename .'"');
    header('Cache-Control: max-age=0');
    
    // Menulis Spreadsheet ke dalam output PHP
    $writer->save('php://output');
?>