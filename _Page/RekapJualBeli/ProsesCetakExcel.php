<?php
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Pastikan tidak ada output sebelum header
ob_start();

// Koneksi
include "../../_Config/Connection.php";
include "../../_Config/GlobalFunction.php";
include "../../_Config/Session.php";

date_default_timezone_set('Asia/Jakarta');
if (empty($_GET['tahun'])) {
    die("Periode Tahun Tidak Boleh Kosong!");
}

$tahun = $_GET['tahun'];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Judul
$sheet->setCellValue('A1', 'TABEL REKAPITULASI TRANSAKSI PENJUALAN & PEMBELIAN');
$sheet->setCellValue('A2', 'PERIODE TAHUN ' . $tahun);
$sheet->mergeCells('A1:H1');
$sheet->mergeCells('A2:H2');

// Style judul
$styleArray = [
    'font' => ['bold' => true, 'size' => 14],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
];
$sheet->getStyle('A1:A2')->applyFromArray($styleArray);

// Header Kolom
$headers = ['NO', 'PERIODE', 'PENJUALAN', 'RETUR PENJUALAN', 'JUMLAH PENJUALAN', 'PEMBELIAN', 'RETUR PEMBELIAN', 'JUMLAH PEMBELIAN'];
$column = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($column . '4', $header);
    $column++;
}

// Style header
$headerStyle = [
    'font' => ['bold' => true],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FFD3D3D3']
    ],
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    ]
];
$sheet->getStyle('A4:H4')->applyFromArray($headerStyle);

$row = 5;
$namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

for ($i = 1; $i <= 12; $i++) {
    $angkaBulan = str_pad($i, 2, '0', STR_PAD_LEFT);
    $periode = "$tahun-$angkaBulan";
    $namaBulanIni = $namaBulan[$i - 1];

    // Pastikan hasil query tidak NULL
    $penjualan = mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE kategori='Penjualan' AND tanggal LIKE '%$periode%'");
    $penjualan = mysqli_fetch_assoc($penjualan)['total'] ?? 0;

    $returPenjualan = mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE kategori='Retur Penjualan' AND tanggal LIKE '%$periode%'");
    $returPenjualan = mysqli_fetch_assoc($returPenjualan)['total'] ?? 0;

    $pembelian = mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE kategori='Pembelian' AND tanggal LIKE '%$periode%'");
    $pembelian = mysqli_fetch_assoc($pembelian)['total'] ?? 0;

    $returPembelian = mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE kategori='Retur Pembelian' AND tanggal LIKE '%$periode%'");
    $returPembelian = mysqli_fetch_assoc($returPembelian)['total'] ?? 0;

    // Pastikan nilai tidak berupa NULL dan ubah ke string untuk keamanan
    $penjualan = (int) $penjualan;
    $returPenjualan = (int) $returPenjualan;
    $pembelian = (int) $pembelian;
    $returPembelian = (int) $returPembelian;

    $sheet->setCellValue('A' . $row, $i);
    $sheet->setCellValue('B' . $row, $namaBulanIni);
    $sheet->setCellValue('C' . $row, (string) $penjualan);
    $sheet->setCellValue('D' . $row, (string) $returPenjualan);
    $sheet->setCellValue('E' . $row, (string) ($penjualan - $returPenjualan));
    $sheet->setCellValue('F' . $row, (string) $pembelian);
    $sheet->setCellValue('G' . $row, (string) $returPembelian);
    $sheet->setCellValue('H' . $row, (string) ($pembelian - $returPembelian));

    $row++;
}

// Atur format angka menjadi Rupiah
$sheet->getStyle('C5:H' . ($row - 1))->getNumberFormat()->setFormatCode('"Rp" #,##0');

// Atur border untuk seluruh tabel
$borderStyle = [
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    ]
];
$sheet->getStyle('A4:H' . ($row - 1))->applyFromArray($borderStyle);

// Atur lebar kolom otomatis
foreach (range('A', 'H') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Bersihkan output sebelum mengirim header
ob_end_clean();

// Set header untuk download file Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Transaksi_Jual_Beli_' . $tahun . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>