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
    $Jumlah = mysqli_num_rows(mysqli_query($Conn, "SELECT id_supplier FROM supplier"));
    if(empty($Jumlah)){
        echo "Data supplier Tidak Ada";
    }else{
        // Membuat objek Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Menulis judul
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Supplier');
        $sheet->setCellValue('C1', 'Alamat');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Kontak');

        // Mengatur gaya baris judul
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // Query untuk mendapatkan data
        $query = "SELECT * FROM supplier ORDER BY id_supplier ASC";
        $result = mysqli_query($Conn, $query);
        // Mengisi data ke dalam Spreadsheet
        $no=1;
        $row = 2; // Mulai dari baris ke-2
        while($data = mysqli_fetch_assoc($result)) {
            $id_supplier= $data['id_supplier'];
            $nama_supplier= $data['nama_supplier'];
            if(empty($data['alamat_supplier'])){
                $alamat_supplier="-";
            }else{
                $alamat_supplier=$data['alamat_supplier'];
            }
            if(empty($data['email_supplier'])){
                $email_supplier="-";
            }else{
                $email_supplier=$data['email_supplier'];
            }
            if(empty($data['kontak_supplier'])){
                $kontak_supplier="-";
            }else{
                $kontak_supplier=$data['kontak_supplier'];
            }
            // Kolom kode diatur sebagai teks
            $sheet->setCellValueExplicit('A'.$row, $no, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('B'.$row, $nama_supplier, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C'.$row, $alamat_supplier, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D'.$row, $email_supplier);
            $sheet->setCellValueExplicit('E'.$row, $kontak_supplier, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $row++; // Pindah ke baris berikutnya
            $no++; // Pindah ke baris berikutnya
        }
        // Menyesuaikan lebar kolom dengan karakter terpanjang
        foreach(range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        // Membuat objek Writer untuk menulis Spreadsheet ke dalam file XLSX
        $writer = new Xlsx($spreadsheet);
        
        // Menyimpan file XLSX
        $filename = 'Data-Supplier.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');
        
        // Menulis Spreadsheet ke dalam output PHP
        $writer->save('php://output');
    } 
?>