<?php
    include '../../vendor/autoload.php';
    if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
        die('Autoloader tidak berfungsi dengan benar. Kelas PhpOffice\PhpSpreadsheet\Spreadsheet tidak ditemukan.');
    }

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Cell\DataType;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

    // Koneksi ke database
    include "../../_Config/Connection.php";

    // Cek jumlah data
    $Jumlah = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang_bacth FROM barang_bacth"));
    if ($Jumlah == 0) {
        echo "Data Barang Batch Tidak Ada";
        exit;
    }

    // Membuat objek Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Menulis judul
    $headers = ['No', 'Kode Barang', 'Nama Barang', 'No.Batch', 'Expire', 'Reminder', 'QTY', 'Satuan', 'Status'];
    $columnIndex = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($columnIndex . '1', $header);
        $columnIndex++;
    }

    // Mengatur gaya baris judul
    $sheet->getStyle('A1:I1')->getFont()->setBold(true);
    $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Query untuk mendapatkan data dengan JOIN agar lebih efisien
    $query = "SELECT bb.id_barang_bacth, bb.no_batch, bb.expired_date, bb.qty_batch, bb.reminder_date, bb.status,
                    b.kode_barang, b.nama_barang, b.satuan_barang
            FROM barang_bacth AS bb
            JOIN barang AS b ON bb.id_barang = b.id_barang
            ORDER BY bb.id_barang_bacth ASC";

    $result = mysqli_query($Conn, $query);

    // Mengisi data ke dalam Spreadsheet
    $no = 1;
    $row = 2; // Mulai dari baris ke-2
    while ($data = mysqli_fetch_assoc($result)) {
        $sheet->setCellValueExplicit('A' . $row, $no, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('B' . $row, $data['kode_barang'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('C' . $row, $data['nama_barang'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('D' . $row, $data['no_batch'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('E' . $row, $data['expired_date'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('F' . $row, $data['reminder_date'], DataType::TYPE_STRING);
        $sheet->setCellValue('G' . $row, $data['qty_batch']);
        $sheet->setCellValue('H' . $row, $data['satuan_barang']);
        $sheet->setCellValue('I' . $row, $data['status']);

        $row++;
        $no++;
    }

    // Menyesuaikan lebar kolom otomatis
    foreach (range('A', 'I') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Membuat file Excel dan mengirim ke output
    $filename = 'barang_batch_expire.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
?>
