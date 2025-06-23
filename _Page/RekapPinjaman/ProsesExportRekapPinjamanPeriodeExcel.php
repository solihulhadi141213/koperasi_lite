<?php
require '../../vendor/autoload.php'; // Pastikan composer sudah menginstal PhpSpreadsheet
include "../../_Config/Connection.php";
include "../../_Config/GlobalFunction.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;

if (empty($_GET['tahun'])) {
    die("<script>alert('Pilih Tahun Terlebih Dahulu'); window.close();</script>");
}

$tahun = $_GET['tahun'];
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set judul
$sheet->setCellValue('A1', 'REKAPITULASI JUMLAH PINJAMAN DAN ANGSURAN');
$sheet->setCellValue('A2', "PERIODE TAHUN $tahun");
$sheet->mergeCells('A1:E1');
$sheet->mergeCells('A2:E2');
$sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A1:A2')->getFont()->setBold(true);

// Header tabel
$headers = ['No', 'Bulan', 'Jumlah Anggota', 'Pinjaman (Rp)', 'Angsuran Masuk (Rp)'];
$sheet->fromArray($headers, null, 'A4');
$sheet->getStyle('A4:E4')->getFont()->setBold(true);
$sheet->getStyle('A4:E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

$row = 5;
$totalAnggota = $totalPinjaman = $totalAngsuran = 0;
for ($i = 1; $i <= 12; $i++) {
    $angkaBulan = str_pad($i, 2, '0', STR_PAD_LEFT);
    $keyword = "$tahun-$angkaBulan";

    $JumlahAnggota = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT id_anggota FROM pinjaman WHERE tanggal LIKE '%$keyword%'"));
    $SumPinjaman = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah_pinjaman) AS jumlah FROM pinjaman WHERE tanggal LIKE '%$keyword%'"));
    $JumlahPinjaman = $SumPinjaman['jumlah'] ?? 0;
    $SumAngsuran = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM pinjaman_angsuran WHERE tanggal_bayar LIKE '%$keyword%'"));
    $JumlahAngsuran = $SumAngsuran['total'] ?? 0;
    
    $totalAnggota += $JumlahAnggota;
    $totalPinjaman += $JumlahPinjaman;
    $totalAngsuran += $JumlahAngsuran;
    
    $sheet->setCellValue("A$row", $i);
    $sheet->setCellValue("B$row", $namaBulan[$i - 1]);
    $sheet->setCellValue("C$row", "$JumlahAnggota Anggota");
    $sheet->setCellValue("D$row", $JumlahPinjaman);
    $sheet->setCellValue("E$row", $JumlahAngsuran);
    
    // Format currency menggunakan format custom
    $sheet->getStyle("D$row:E$row")->getNumberFormat()->setFormatCode('#,##0');
    
    $row++;
}

// Baris total
$sheet->setCellValue("A$row", "JUMLAH");
$sheet->mergeCells("A$row:B$row");
$sheet->setCellValue("C$row", "$totalAnggota Anggota");
$sheet->setCellValue("D$row", $totalPinjaman);
$sheet->setCellValue("E$row", $totalAngsuran);
$sheet->getStyle("A$row:E$row")->getFont()->setBold(true);
$sheet->getStyle("D$row:E$row")->getNumberFormat()->setFormatCode('#,##0');

// Auto size column
foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Border styling
$sheet->getStyle("A4:E$row")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Export ke file Excel
$filename = "Rekap_Pinjaman_$tahun.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=$filename");
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
?>
