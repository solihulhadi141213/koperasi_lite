<?php
    require '../../vendor/autoload.php';
    require '../../_Config/Connection.php';
    require '../../_Config/GlobalFunction.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    date_default_timezone_set("Asia/Jakarta");

    $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $sheet->setCellValue('A1', 'REKAPITULASI PINJAMAN UNIT/DIVISI');
    $sheet->setCellValue('A2', $tahun ? 'PERIODE TAHUN ' . $tahun : 'SEMUA PERIODE');
    $sheet->mergeCells('A1:E1');
    $sheet->mergeCells('A2:E2');
    $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal('center');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

    // Table Header
    $sheet->setCellValue('A4', 'No')
        ->setCellValue('B4', 'Unit/Divisi')
        ->setCellValue('C4', 'Anggota')
        ->setCellValue('D4', 'Rp Pinjaman')
        ->setCellValue('E4', 'Rp Angsuran Masuk');
    $sheet->getStyle('A4:E4')->getFont()->setBold(true);

    $no = 1;
    $row = 5;
    $JumlahTotalAnggota = 0;
    $JumlahTotalPinjaman = 0;
    $JumlahTotalAngsuran = 0;
    $query = mysqli_query($Conn, "SELECT DISTINCT lembaga FROM pinjaman ORDER BY lembaga ASC");
    while ($data = mysqli_fetch_array($query)) {
        $lembaga = $data['lembaga'];
        $JumlahAnggota = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT id_anggota FROM pinjaman WHERE lembaga='$lembaga' AND tanggal LIKE '%$tahun%'"));
        $SumPinjaman = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah_pinjaman) AS jumlah FROM pinjaman WHERE lembaga='$lembaga' AND tanggal LIKE '%$tahun%'"));
        $JumlahPinjaman = $SumPinjaman['jumlah'] ?? 0;
        
        $JumlahAngsuran = 0;
        $QryPinjaman = mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE lembaga='$lembaga' AND tanggal LIKE '%$tahun%'");
        while ($DataPinjaman = mysqli_fetch_array($QryPinjaman)) {
            $id_pinjaman = $DataPinjaman['id_pinjaman'];
            $SumAngsuran = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND tanggal_bayar LIKE '%$tahun%'"));
            $JumlahAngsuran += $SumAngsuran['total'] ?? 0;
        }
        
        $JumlahTotalAnggota += $JumlahAnggota;
        $JumlahTotalPinjaman += $JumlahPinjaman;
        $JumlahTotalAngsuran += $JumlahAngsuran;
        
        $sheet->setCellValue('A' . $row, $no++)
            ->setCellValue('B' . $row, $lembaga)
            ->setCellValue('C' . $row, $JumlahAnggota . ' Anggota')
            ->setCellValue('D' . $row, $JumlahPinjaman)
            ->setCellValue('E' . $row, $JumlahAngsuran);
        $row++;
    }

    // Total Row
    $sheet->setCellValue('A' . $row, 'JUMLAH')
        ->mergeCells('A' . $row . ':B' . $row)
        ->setCellValue('C' . $row, $JumlahTotalAnggota . ' Anggota')
        ->setCellValue('D' . $row, $JumlahTotalPinjaman)
        ->setCellValue('E' . $row, $JumlahTotalAngsuran);
    $sheet->getStyle('A' . $row . ':E' . $row)->getFont()->setBold(true);

    // Set Auto Width
    foreach (range('A', 'E') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Export to Excel
    $filename = 'Rekap_Pinjaman_' . ($tahun ? $tahun : 'Semua') . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

?>