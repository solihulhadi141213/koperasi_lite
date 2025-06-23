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

    //Validasi id_stock_opename
    if(empty($_POST['id_stok_opename'])){
        echo "ID Sesi Stock Opename Tidak Boleh Kosong";
        exit;
    }
    $id_stok_opename=$_POST['id_stok_opename'];
    // Cek jumlah data
    $Jumlah = mysqli_num_rows(mysqli_query($Conn, "SELECT id_stok_opename FROM stok_opename WHERE id_stok_opename='$id_stok_opename'"));
    if ($Jumlah == 0) {
        echo "Data Sesi Stock Opename Tidak Valid";
        exit;
    }

    //Buka Data Sesi
    $QryStockOpename = mysqli_query($Conn,"SELECT * FROM stok_opename WHERE id_stok_opename='$id_stok_opename'")or die(mysqli_error($Conn));
    $DataStockOpename = mysqli_fetch_array($QryStockOpename);
    $tanggal= $DataStockOpename['tanggal'];

    // Membuat objek Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Menulis judul
    $headers = ['No', 'Tanggal', 'Kode', 'Nama Barang', 'Stok Awal', 'Stok Akhir', 'Selisih', 'Harga', 'Jumlah'];
    $columnIndex = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($columnIndex . '1', $header);
        $columnIndex++;
    }

    // Mengatur gaya baris judul
    $sheet->getStyle('A1:I1')->getFont()->setBold(true);
    $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Query untuk mendapatkan data dengan JOIN agar lebih efisien
    $query = "SELECT sob.id_stok_opename_barang, sob.id_stok_opename, sob.id_barang, sob.stok_awal, sob.stok_akhir, sob.stok_gap, sob.harga_beli, sob.jumlah,
                    b.kode_barang, b.nama_barang, b.satuan_barang
            FROM stok_opename_barang AS sob
            JOIN barang AS b ON sob.id_barang = b.id_barang WHERE sob.id_stok_opename='$id_stok_opename'
            ORDER BY sob.id_barang ASC";

    $result = mysqli_query($Conn, $query);



    // Mengisi data ke dalam Spreadsheet
    $no = 1;
    $row = 2; // Mulai dari baris ke-2
    while ($data = mysqli_fetch_assoc($result)) {
        $sheet->setCellValueExplicit('A' . $row, $no, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('B' . $row, $tanggal, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('C' . $row, $data['kode_barang'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('D' . $row, $data['nama_barang'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('E' . $row, $data['stok_awal'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('F' . $row, $data['stok_akhir'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('G' . $row, $data['stok_gap'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('H' . $row, $data['harga_beli'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('I' . $row, $data['jumlah'], DataType::TYPE_STRING);

        $row++;
        $no++;
    }

    // Menyesuaikan lebar kolom otomatis
    foreach (range('A', 'I') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Membuat file Excel dan mengirim ke output
    $filename = 'stock_opename.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
?>
