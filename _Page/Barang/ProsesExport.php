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
    include "../../_Config/GlobalFunction.php";

    // Cek jumlah data
    $Jumlah = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang FROM barang"));
    $JumlahKategoriHarga = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang_kategori_harga FROM barang_kategori_harga"));
    if ($Jumlah == 0) {
        echo "Data Barang Batch Tidak Ada";
        exit;
    }

    // Membuat objek Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Menulis judul
    $headers = ['No', 'Kode Barang', 'Nama Barang', 'Kategori', 'Stock', 'Satuan', 'Harga Beli'];

    // Ambil semua kategori harga
    $queryKategoriHarga = "SELECT * FROM barang_kategori_harga";
    $resultKategoriHarga = mysqli_query($Conn, $queryKategoriHarga);
    $kategoriHarga = [];
    while ($rowKategoriHarga = mysqli_fetch_assoc($resultKategoriHarga)) {
        $headers[] = $rowKategoriHarga['kategori_harga'];
        $kategoriHarga[$rowKategoriHarga['id_barang_kategori_harga']] = $rowKategoriHarga['kategori_harga'];
    }

    $columnIndex = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($columnIndex . '1', $header);
        $columnIndex++;
    }

    // Mengatur gaya baris judul
    $sheet->getStyle('A1:' . $columnIndex . '1')->getFont()->setBold(true);
    $sheet->getStyle('A1:' . $columnIndex . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Query untuk mendapatkan data dengan JOIN agar lebih efisien
    $query = "SELECT * FROM barang ORDER BY id_barang ASC";
    $result = mysqli_query($Conn, $query);

    // Mengisi data ke dalam Spreadsheet
    $no = 1;
    $row = 2; // Mulai dari baris ke-2
    while ($data = mysqli_fetch_assoc($result)) {
        $stok_barang = $data['stok_barang'];
        $harga_beli = $data['harga_beli'];
        $stok_barang = pembulatan_nilai($stok_barang);
        $harga_beli = pembulatan_nilai($harga_beli);

        // Add Excel
        $sheet->setCellValueExplicit('A' . $row, $no, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('B' . $row, $data['kode_barang'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('C' . $row, $data['nama_barang'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('D' . $row, $data['kategori_barang'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('E' . $row, $stok_barang, DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('F' . $row, $data['satuan_barang'], DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('G' . $row, $harga_beli, DataType::TYPE_STRING);

        // Ambil harga barang berdasarkan kategori harga
        $queryHarga = "SELECT * FROM barang_harga WHERE id_barang = '" . $data['id_barang'] . "'";
        $resultHarga = mysqli_query($Conn, $queryHarga);
        $hargaBarang = [];
        while ($rowHarga = mysqli_fetch_assoc($resultHarga)) {
            $hargaBarang[$rowHarga['id_barang_kategori_harga']] = $rowHarga['harga'];
        }

        // Isi data harga barang ke dalam kolom yang sesuai
        $columnIndexHarga = 'H';
        foreach ($kategoriHarga as $id_kategori_harga => $kategori) {
            $harga = isset($hargaBarang[$id_kategori_harga]) ? pembulatan_nilai($hargaBarang[$id_kategori_harga]) : '-';
            $sheet->setCellValueExplicit($columnIndexHarga . $row, $harga, DataType::TYPE_STRING);
            $columnIndexHarga++;
        }

        $row++;
        $no++;
    }

    // Menyesuaikan lebar kolom otomatis
    foreach (range('A', $columnIndex) as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Membuat file Excel dan mengirim ke output
    $filename = 'data_barang.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
?>