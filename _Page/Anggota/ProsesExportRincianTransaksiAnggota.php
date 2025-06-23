<?php 
    require '../../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
    use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    if(empty($SessionIdAkses)){
        echo "Sesi Akses Sudah Berakhir, Silahkan Login Ulang";
        exit;
    }
    if(empty($_GET['periode_awal'])){
        echo "Periode Awal Data Tidak Boleh Kosong!";
        exit;
    }
    if(empty($_GET['periode_akhir'])){
        echo "Periode Akhir Data Tidak Boleh Kosong!";
        exit;
    }
    if(empty($_GET['id_anggota'])){
        echo "ID Anggota Tidak Boleh Kosong!";
        exit;
    }
    $periode_1=$_GET['periode_awal'];
    $periode_2=$_GET['periode_akhir'];
    $id_anggota=$_GET['id_anggota'];

    //Hitung jumlah data
    $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM transaksi_jual_beli WHERE (id_anggota='$id_anggota') AND (kategori='Penjualan' OR kategori='Retur Penjualan') AND (tanggal BETWEEN '$periode_1 00:00:00' AND '$periode_2 23:59:59')"));
    if(empty($JumlahData)){
        echo "Belum ada data transaksi";
        exit;
    } else {
        // Membuat objek Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menulis judul
        $headers = [
            'A1' => 'No',
            'B1' => 'Tanggal',
            'C1' => 'Kategori',
            'D1' => 'Nama Anggota',
            'E1' => 'Nama Barang',
            'F1' => 'QTY',
            'G1' => 'Satuan',
            'H1' => 'Harga',
            'I1' => 'Jumlah',
            'J1' => 'PPN',
            'K1' => 'Diskon',
            'L1' => 'Subtotal',
            'M1' => 'Status',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Mengatur gaya baris judul
        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
        $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Membuat objek Writer untuk menulis Spreadsheet ke dalam file XLSX
        $writer = new Xlsx($spreadsheet);

        $no = 1;
        $row = 2;
        $query = mysqli_query($Conn, "
            SELECT 
                t.id_transaksi_jual_beli, t.id_anggota, t.kategori, t.tanggal, t.status, 
                IFNULL(a.nama, '-') AS nama_anggota, 
                r.nama_barang, r.satuan, r.qty, r.harga, r.ppn, r.diskon, r.subtotal
            FROM transaksi_jual_beli t
            LEFT JOIN transaksi_jual_beli_rincian r ON t.id_transaksi_jual_beli = r.id_transaksi_jual_beli
            LEFT JOIN anggota a ON t.id_anggota = a.id_anggota
            WHERE t.kategori IN ('Penjualan', 'Retur Penjualan')
            AND (t.tanggal BETWEEN '$periode_1 00:00:00' AND '$periode_2 23:59:59')
            AND t.id_anggota = '$id_anggota'  -- Added condition for id_anggota
            ORDER BY t.id_transaksi_jual_beli ASC
        ");

        $no = 1;
        $row = 2;
        while ($data = mysqli_fetch_array($query)) {
            $tanggal_format = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(new DateTime($data['tanggal']));
            $jumlah = $data['harga'] * $data['ppn'];

            $sheet->setCellValue('A'.$row, $no);
            $sheet->setCellValue('B'.$row, $tanggal_format);
            $sheet->getStyle('B'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue('C'.$row, $data['kategori']);
            $sheet->setCellValue('D'.$row, $data['nama_anggota']);
            $sheet->setCellValue('E'.$row, $data['nama_barang']);
            
            $sheet->setCellValue('F'.$row, $data['qty']);
            $sheet->getStyle('F'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

            $sheet->setCellValue('G'.$row, $data['satuan']);

            $sheet->setCellValue('H'.$row, $data['harga']);
            $sheet->getStyle('H'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

            $sheet->setCellValue('I'.$row, $jumlah);
            $sheet->getStyle('I'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

            $sheet->setCellValue('J'.$row, $data['ppn']);
            $sheet->getStyle('J'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

            $sheet->setCellValue('K'.$row, $data['diskon']);
            $sheet->getStyle('K'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

            $sheet->setCellValue('L'.$row, $data['subtotal']);
            $sheet->getStyle('L'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

            $sheet->setCellValue('M'.$row, $data['status']);

            $row++;
            $no++;
        }

        // Menyesuaikan lebar kolom dengan karakter terpanjang
        foreach(range('A', 'M') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = "Rincian-Penjualan_anggota.xlsx";
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');
        
        // Menulis Spreadsheet ke dalam output PHP
        $writer->save('php://output');
    }
?>
