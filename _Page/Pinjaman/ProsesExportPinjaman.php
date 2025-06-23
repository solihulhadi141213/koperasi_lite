<?php
require '../../vendor/autoload.php';
if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
    die('Autoloader tidak berfungsi dengan benar. Kelas PhpOffice\PhpSpreadsheet\Spreadsheet tidak ditemukan.');
}
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

// Koneksi
include "../../_Config/Connection.php";
include "../../_Config/GlobalFunction.php";
include "../../_Config/Session.php";

if (empty($SessionIdAkses)) {
    die("Sesi Akses Sudah Berakhir, Silahkan Login Ulang");
}

if (empty($_POST['periode_export_1']) || empty($_POST['periode_export_2'])) {
    die("Periode Awal dan Akhir Tidak Boleh Kosong!");
}

$periode_export_1 = validateAndSanitizeInput($_POST['periode_export_1']);
$periode_export_2 = validateAndSanitizeInput($_POST['periode_export_2']);
$tampilkan_denda = !empty($_POST['tampilkan_denda']) ? $_POST['tampilkan_denda'] : "";

if ($periode_export_1 >= $periode_export_2) {
    die("Periode Awal Tidak Boleh Lebih Besar atau Sama Dengan Periode Akhir!");
}

$query = mysqli_query($Conn, "SELECT * FROM pinjaman WHERE tanggal >= '$periode_export_1' AND tanggal <= '$periode_export_2' ORDER BY tanggal ASC");
$JumlahData = mysqli_num_rows($query);
if ($JumlahData == 0) {
    die("Belum Ada Data Pinjaman Pada Periode Tersebut");
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menentukan Header
$headers = $tampilkan_denda == "Ya" ? [
    'No', 'NIP', 'Nama Anggota', 'Divisi/Unit', 'Ranking', 'Tanggal', 'Jatuh Tempo', '% Denda', 'Sistem Denda', 'Rp Pinjaman', '% Jasa', 'Rp Jasa', 'Rp Pokok', 'Rp Angsuran', 'Periode Angsuran', 'Status'
] : [
    'No', 'NIP', 'Nama Anggota', 'Divisi/Unit', 'Ranking', 'Tanggal', 'Jatuh Tempo', 'Rp Pinjaman', '% Jasa', 'Rp Jasa', 'Rp Pokok', 'Rp Angsuran', 'Periode Angsuran', 'Status'
];

$col = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($col . '1', $header);
    $col++;
}
$sheet->getStyle('A1:' . (--$col) . '1')->getFont()->setBold(true);
$sheet->getStyle('A1:' . $col . '1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Mengisi Data
$row = 2;
$no = 1;
while ($data = mysqli_fetch_assoc($query)) {
    $col = 'A';
    $sheet->setCellValueExplicit($col++ . $row, (string) $no, DataType::TYPE_STRING);
    $sheet->setCellValueExplicit($col++ . $row, (string) $data['nip'], DataType::TYPE_STRING);
    $sheet->setCellValueExplicit($col++ . $row, $data['nama'], DataType::TYPE_STRING);
    $sheet->setCellValueExplicit($col++ . $row, $data['lembaga'], DataType::TYPE_STRING);
    $sheet->setCellValueExplicit($col++ . $row, (string) $data['ranking'], DataType::TYPE_STRING);
    
    $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(new DateTime($data['tanggal']));
    $sheet->setCellValue($col . $row, $tanggal);
    $sheet->getStyle($col++ . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
    
    $sheet->setCellValueExplicit($col++ . $row, $data['jatuh_tempo'], DataType::TYPE_STRING);
    
    if ($tampilkan_denda == "Ya") {
        $sheet->setCellValue($col . $row, $data['denda']);
        $sheet->getStyle($col++ . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $sheet->setCellValueExplicit($col++ . $row, $data['sistem_denda'], DataType::TYPE_STRING);
    }
    
    $sheet->setCellValue($col . $row, $data['jumlah_pinjaman']);
    $sheet->getStyle($col++ . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    
    $sheet->setCellValue($col . $row, $data['persen_jasa']);
    $sheet->getStyle($col++ . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    
    $sheet->setCellValue($col . $row, $data['rp_jasa']);
    $sheet->getStyle($col++ . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    
    $sheet->setCellValue($col . $row, $data['angsuran_pokok']);
    $sheet->getStyle($col++ . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    
    $sheet->setCellValue($col . $row, $data['angsuran_total']);
    $sheet->getStyle($col++ . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    
    $sheet->setCellValueExplicit($col++ . $row, (string) $data['periode_angsuran'], DataType::TYPE_STRING);
    $sheet->setCellValueExplicit($col++ . $row, $data['status'], DataType::TYPE_STRING);
    
    $row++;
    $no++;
}

foreach (range('A', $col) as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Pinjaman.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>