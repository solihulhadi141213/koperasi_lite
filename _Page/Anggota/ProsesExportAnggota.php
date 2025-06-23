<?php
    include '../../vendor/autoload.php';
    if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
        die('Autoloader tidak berfungsi dengan benar. Kelas PhpOffice\PhpSpreadsheet\Spreadsheet tidak ditemukan.');
    }
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
    //Koneksi
    include "../../_Config/Connection.php";
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');
    $Sekarang=date('Y-m-d');
    //Cek Jumlah Data
    $Jumlah = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota"));
    if(empty($Jumlah)){
        echo "Data Anggota Tidak Ada";
    }else{
        // Membuat objek Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Menulis judul
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIP');
        $sheet->setCellValue('C1', 'Nama Anggota');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Password');
        $sheet->setCellValue('F1', 'Kontak');
        $sheet->setCellValue('G1', 'Divisi/Unit');
        $sheet->setCellValue('H1', 'Ranking');
        $sheet->setCellValue('I1', 'status');
        $sheet->setCellValue('J1', 'Tanggal Masuk');
        $sheet->setCellValue('K1', 'Tanggal Keluar');
        // Mengatur gaya baris judul
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // Query untuk mendapatkan data
        $query = "SELECT * FROM anggota ORDER BY id_anggota ASC";
        $result = mysqli_query($Conn, $query);
        // Mengisi data ke dalam Spreadsheet
        $no=1;
        $row = 2; // Mulai dari baris ke-2
        while($data = mysqli_fetch_assoc($result)) {
            $id_anggota= $data['id_anggota'];
            $tanggal_masuk= $data['tanggal_masuk'];
            $tanggal_keluar= $data['tanggal_keluar'];
            $nip= $data['nip'];
            $nama= $data['nama'];
            $email= $data['email'];
            $kontak= $data['kontak'];
            $lembaga= $data['lembaga'];
            $ranking= $data['ranking'];
            $akses_anggota= $data['akses_anggota'];
            $password= $data['password'];
            $status= $data['status'];
            // Kolom kode diatur sebagai teks
            $sheet->setCellValueExplicit('A'.$row, $no, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('B'.$row, $nip, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C'.$row, $nama, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D'.$row, $email);
            $sheet->setCellValue('E'.$row, $password);
            $sheet->setCellValueExplicit('F'.$row, $kontak, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('G'.$row, $lembaga);
            $sheet->setCellValue('H'.$row, $ranking);
            $sheet->setCellValue('I'.$row, $status);
            $sheet->setCellValue('J'.$row, $tanggal_masuk);
            $sheet->setCellValue('K'.$row, $tanggal_keluar);
            $row++; // Pindah ke baris berikutnya
            $no++; // Pindah ke baris berikutnya
        }
        // Menyesuaikan lebar kolom dengan karakter terpanjang
        foreach(range('A', 'K') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        // Membuat objek Writer untuk menulis Spreadsheet ke dalam file XLSX
        $writer = new Xlsx($spreadsheet);
        
        // Menyimpan file XLSX
        $filename = 'Data-Anggota.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');
        
        // Menulis Spreadsheet ke dalam output PHP
        $writer->save('php://output');
    } 
?>