<?php
// Koneksi dan session
include "../../_Config/Connection.php";
include "../../_Config/GlobalFunction.php";
include "../../_Config/Session.php";

// Load library PhpSpreadsheet
require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Font;

// Validasi ID SHU Session
if (empty($_POST['id_shu_session'])) {
    die('ID SHU Tidak Boleh Kosong!');
}

$id_shu_session = validateAndSanitizeInput($_POST['id_shu_session']);

// Ambil data dari database
$Qry = $Conn->prepare("SELECT * FROM shu_session WHERE id_shu_session = ?");
$Qry->bind_param("i", $id_shu_session);
$Qry->execute();
$Result = $Qry->get_result();
$Data = $Result->fetch_assoc();

if (!$Data) {
    die('Data Sesi SHU tidak ditemukan!');
}

// Inisialisasi Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Laporan SHU");

// Header
$headers = ["No", "Anggota", "NIP", "Penjualan", "Simpanan", "Pinjaman", "SHU Penjualan", "SHU Simpanan", "SHU Pinjaman", "SHU Total"];
$sheet->fromArray($headers, NULL, 'A1');

// Ambil rincian data SHU
$query = mysqli_query($Conn, "SELECT * FROM shu_rincian WHERE id_shu_session='$id_shu_session' ORDER BY id_shu_rincian ASC");

$row = 2;
$no = 1;
$JumlahSimpanan = $JumlahPinjaman = $JumlahPenjualan = 0;
$JumlahJasaPenjualan = $JumlahJasaSimpanan = $JumlahJasaPinjaman = $JumlahShu = 0;

while ($data = mysqli_fetch_array($query)) {
    $sheet->setCellValue('A' . $row, $no);
    $sheet->setCellValueExplicit('B' . $row, $data['nama_anggota'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $sheet->setCellValueExplicit('C' . $row, $data['nip'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    
    // Menetapkan nilai untuk kolom keuangan
    $sheet->setCellValue('D' . $row, $data['penjualan']);
    $sheet->setCellValue('E' . $row, $data['simpanan']);
    $sheet->setCellValue('F' . $row, $data['pinjaman']);
    $sheet->setCellValue('G' . $row, $data['jasa_penjualan']);
    $sheet->setCellValue('H' . $row, $data['jasa_simpanan']);
    $sheet->setCellValue('I' . $row, $data['jasa_pinjaman']);
    $sheet->setCellValue('J' . $row, $data['shu']);

    // Hitung total untuk masing-masing kategori
    $JumlahSimpanan += $data['simpanan'];
    $JumlahPinjaman += $data['pinjaman'];
    $JumlahPenjualan += $data['penjualan'];
    $JumlahJasaPenjualan += $data['jasa_penjualan'];
    $JumlahJasaSimpanan += $data['jasa_simpanan'];
    $JumlahJasaPinjaman += $data['jasa_pinjaman'];
    $JumlahShu += $data['shu'];

    $row++;
    $no++;
}

// Tambahkan baris total
$sheet->setCellValue('A' . $row, 'TOTAL');
$sheet->mergeCells('A' . $row . ':C' . $row);
$sheet->setCellValue('D' . $row, $JumlahPenjualan);
$sheet->setCellValue('E' . $row, $JumlahSimpanan);
$sheet->setCellValue('F' . $row, $JumlahPinjaman);
$sheet->setCellValue('G' . $row, $JumlahJasaPenjualan);
$sheet->setCellValue('H' . $row, $JumlahJasaSimpanan);
$sheet->setCellValue('I' . $row, $JumlahJasaPinjaman);
$sheet->setCellValue('J' . $row, $JumlahShu);

// Atur format currency
$currencyFormat = '#,##0.00';
foreach (range('D', 'J') as $col) {
    $sheet->getStyle($col . '2:' . $col . $row)->getNumberFormat()->setFormatCode($currencyFormat);
}

// Atur alignment
$sheet->getStyle("A1:J1")->getFont()->setBold(true);
$sheet->getStyle("A1:J" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle("D2:J" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

// **Atur alignment untuk Anggota, NIP, dan TOTAL ke LEFT**
$sheet->getStyle("B2:B" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle("C2:C" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle("A" . $row . ":C" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

// **Sesuaikan lebar kolom secara otomatis**
foreach (range('A', 'J') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Simpan ke file Excel
$filename = "Laporan_SHU_" . date("Ymd_His") . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
