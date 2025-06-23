<?php
    // Autoload PhpSpreadsheet
    include '../../vendor/autoload.php';

    // Cek apakah kelas PhpSpreadsheet ada
    if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
        die('Autoloader tidak berfungsi dengan benar. Kelas PhpOffice\PhpSpreadsheet\Spreadsheet tidak ditemukan.');
    }

    // Validasi input
    if (empty($_POST['periode_1'])) {
        die('Periode Awal Tidak Boleh Kosong!');
    } elseif (empty($_POST['periode_2'])) {
        die('Periode Akhir Tidak Boleh Kosong!');
    }

    // Menggunakan namespace PhpSpreadsheet
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

    $periode_1 = $_POST['periode_1'];
    $periode_2 = $_POST['periode_2'];

    // Koneksi
    include "../../_Config/Connection.php";
    date_default_timezone_set('Asia/Jakarta');

    // Cek jumlah data jurnal dalam periode
    $query_count = "SELECT id_jurnal FROM jurnal WHERE tanggal >= '$periode_1' AND tanggal <= '$periode_2'";
    $Jumlah = mysqli_num_rows(mysqli_query($Conn, $query_count));

    if ($Jumlah == 0) {
        die("Tidak Ada Data Jurnal Yang Dapat Ditampilkan Untuk Periode Tersebut");
    }

    // Membuat objek Spreadsheet baru
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Menulis judul kolom
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Kategori');
    $sheet->setCellValue('C1', 'Referensi');
    $sheet->setCellValue('D1', 'Tanggal');
    $sheet->setCellValue('E1', 'Kode Akun');
    $sheet->setCellValue('F1', 'Nama Akun');
    $sheet->setCellValue('G1', 'Debet/Kredit');
    $sheet->setCellValue('H1', 'Nominal');

    // Mengatur gaya baris judul
    $sheet->getStyle('A1:H1')->getFont()->setBold(true);
    $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Query untuk mendapatkan data jurnal dalam periode
    $query = "SELECT * FROM jurnal WHERE tanggal >= '$periode_1' AND tanggal <= '$periode_2' ORDER BY id_jurnal ASC";
    $result = mysqli_query($Conn, $query);

    // Mengisi data ke dalam spreadsheet
    $no = 1;
    $row = 2; // Mulai dari baris kedua
    while ($data = mysqli_fetch_assoc($result)) {
        $kategori = $data['kategori'];
        $uuid = $data['uuid'];
        $tanggal = $data['tanggal'];
        $kode_perkiraan = $data['kode_perkiraan'];
        $nama_perkiraan = $data['nama_perkiraan'];
        $d_k = $data['d_k'];
        $nilai = $data['nilai'];

        // Menulis data ke dalam sel
        $sheet->setCellValueExplicit('A' . $row, $no, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('B' . $row, $kategori, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('C' . $row, $uuid, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue('D' . $row, $tanggal);
        $sheet->setCellValue('E' . $row, $kode_perkiraan);
        $sheet->setCellValueExplicit('F' . $row, $nama_perkiraan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue('G' . $row, $d_k);
        $sheet->setCellValue('H' . $row, $nilai);

        $row++; // Pindah ke baris berikutnya
        $no++;  // Increment nomor
    }

    // Menyesuaikan lebar kolom otomatis
    foreach (range('A', 'H') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Membuat objek Writer untuk menulis spreadsheet ke dalam file XLSX
    $writer = new Xlsx($spreadsheet);

    // Menyimpan file XLSX
    $filename = 'Data-Jurnal.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'. $filename .'"');
    header('Cache-Control: max-age=0');

    // Menulis spreadsheet ke output
    $writer->save('php://output');
    exit;
?>
