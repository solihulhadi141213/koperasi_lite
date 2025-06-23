<?php
    include '../../vendor/autoload.php';
    if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
        die('Autoloader tidak berfungsi dengan benar. Kelas PhpOffice\PhpSpreadsheet\Spreadsheet tidak ditemukan.');
    }

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Cell\DataType;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;

    // Koneksi ke database
    include "../../_Config/Connection.php";

    // Ambil parameter dari POST
    $id_supplier = $_POST['id_supplier'] ?? '';
    $periode_awal = $_POST['periode_awal'] ?? '';
    $periode_akhir = $_POST['periode_akhir'] ?? '';

    if (!$id_supplier || !$periode_awal || !$periode_akhir) {
        echo "Parameter tidak lengkap!";
        exit;
    }

    // Ambil nama supplier
    $querySupplier = mysqli_query($Conn, "SELECT nama_supplier FROM supplier WHERE id_supplier = '$id_supplier'");
    $supplier = mysqli_fetch_assoc($querySupplier);
    $nama_supplier = $supplier['nama_supplier'] ?? 'Tidak Diketahui';

    // Ambil data transaksi
    $queryTransaksi = "SELECT tanggal, kategori, subtotal, ppn, diskon, total, status 
                    FROM transaksi_jual_beli 
                    WHERE id_supplier = '$id_supplier' 
                    AND DATE(tanggal) BETWEEN '$periode_awal' AND '$periode_akhir'
                    ORDER BY tanggal ASC";
    $resultTransaksi = mysqli_query($Conn, $queryTransaksi);
    $jumlahData = mysqli_num_rows($resultTransaksi);

    if ($jumlahData == 0) {
        echo "Tidak ada data transaksi untuk periode ini.";
        exit;
    }

    // Membuat Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Judul
    $judul = "RIWAYAT TRANSAKSI SUPPLIER $nama_supplier";
    $sheet->setCellValue('A1', $judul);
    $sheet->mergeCells('A1:H1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Header Kolom
    $headers = ['No', 'Tanggal', 'Kategori', 'Subtotal', 'PPN', 'Diskon', 'Total', 'Status'];
    $columnIndex = 'A';

    foreach ($headers as $header) {
        $sheet->setCellValue($columnIndex . '3', $header);
        $columnIndex++;
    }

    // Mengatur gaya header
    $sheet->getStyle('A3:H3')->getFont()->setBold(true);
    $sheet->getStyle('A3:H3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Isi Data
    $row = 4;
    $no = 1;

    while ($data = mysqli_fetch_assoc($resultTransaksi)) {
        $sheet->setCellValueExplicit('A' . $row, $no, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('B' . $row, date('d-m-Y', strtotime($data['tanggal'])), DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('C' . $row, $data['kategori'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('D' . $row, $data['subtotal'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('E' . $row, $data['ppn'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('F' . $row, $data['diskon'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('G' . $row, $data['total'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('H' . $row, $data['status'], DataType::TYPE_STRING);

        $row++;
        $no++;
    }

    // Auto-width untuk kolom
    foreach (range('A', 'H') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Menyimpan file ke output
    $filename = 'Riwayat_Transaksi.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
?>
