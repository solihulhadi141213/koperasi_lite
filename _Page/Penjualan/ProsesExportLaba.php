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
    
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
   

    //Validasi Sesi Akses
    if(empty($SessionIdAkses)){
        echo "Sesi Akses Sudah Berakhir, Silahkan Login Ulang";
    }else{

        //Validasi Periode Awal Tidak Boleh Kosong
        if(empty($_GET['periode_1'])){
            echo "Periode Awal Data Tidak Boleh Kosong!";
        }else{

            //Validasi Periode Akhir Tidak Boleh Kosong
            if(empty($_GET['periode_2'])){
                echo "Periode Akhir Data Tidak Boleh Kosong!";
            }else{

                //Validasi Type Data Tidak Boleh Kosong
                if(empty($_GET['type_data'])){
                    echo "Tipe Data Tidak Boleh Kosong!";
                }else{
                    
                    //Buat Variabel
                    $periode_1=validateAndSanitizeInput($_GET['periode_1']);
                    $periode_2=validateAndSanitizeInput($_GET['periode_2']);
                    $type_data=validateAndSanitizeInput($_GET['type_data']);

                    //Hitung Jumlah Data
                    $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM transaksi_jual_beli WHERE (kategori='Penjualan' OR kategori='Retur Penjualan') AND (tanggal BETWEEN '$periode_1 00:00:00' AND '$periode_2 23:59:59')"));
                    if(empty($JumlahData)){
                        echo "Belum ada data transaksi";
                    }else{
                        if($type_data=="HTML"){
                            echo '<html>';
                            echo '  
                                <head>
                                    <meta charset="utf-8">
                                    <meta content="width=device-width, initial-scale=1.0" name="viewport">
                                    <title>Rincian Laba</title>
                                    <style>
                                        body {
                                            font-family: Arial, sans-serif;
                                            margin: 20px;
                                            padding: 0;
                                            color: #333;
                                        }
                                        .container {
                                            max-width: 100%;
                                            overflow-x: auto;
                                        }
                                        table {
                                            width: 100%;
                                            border-collapse: collapse;
                                            margin: 20px 0;
                                            font-size: 0.9em;
                                            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
                                        }
                                        table thead tr {
                                            background-color: #4CAF50;
                                            color: white;
                                            text-align: center;
                                            font-weight: bold;
                                        }
                                        table th,
                                        table td {
                                            padding: 12px 15px;
                                            border: 1px solid #ddd;
                                        }
                                        table tbody tr {
                                            border-bottom: 1px solid #dddddd;
                                        }
                                        table tbody tr:nth-of-type(even) {
                                            background-color: #f3f3f3;
                                        }
                                        table tbody tr:last-of-type {
                                            border-bottom: 2px solid #4CAF50;
                                        }
                                        table tbody tr:hover {
                                            background-color: #f1f1f1;
                                        }
                                        .text-center {
                                            text-align: center;
                                        }
                                        .text-left {
                                            text-align: left;
                                        }
                                        .text-right {
                                            text-align: right;
                                        }
                                    </style>
                                </head>
                            ';
                            echo '  <body>';
                            echo '      <div class="container">';
                            echo '          <h2>ESTIMASI RINCIAN LABA PENJUALAN</h2>';
                            echo '          <table>';
                            echo '              <thead>';
                            echo '                  <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Kategori</th>
                                                        <th>Uraian</th>
                                                        <th>Harga Beli</th>
                                                        <th>QTY</th>
                                                        <th>PPN</th>
                                                        <th>Diskon</th>
                                                        <th>Subtotal</th>
                                                        <th>HPP</th>
                                                        <th>Margin</th>
                                                    </tr>';
                            echo '              </thead>';
                            echo '              <tbody>';
                            $no = 1;

                            //Inisiasi Jumlah
                            $jumlah_subtotal=0;
                            $jumlah_hpp=0;
                            $jumlah_margin=0;
                            //Buka Data Transaksi Jual Beli
                            $query = mysqli_query($Conn, "SELECT id_transaksi_jual_beli, kategori, tanggal FROM transaksi_jual_beli WHERE (kategori='Penjualan' OR kategori='Retur Penjualan') AND (tanggal BETWEEN '$periode_1 00:00:00' AND '$periode_2 23:59:59') ORDER BY tanggal ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_transaksi_jual_beli = $data['id_transaksi_jual_beli'];
                                $kategori = $data['kategori'];
                                $tanggal = $data['tanggal'];
                                
                                //Buka Rincian Transaksi Jual Beli
                                $query2 = mysqli_query($Conn, "SELECT * FROM transaksi_jual_beli_rincian WHERE id_transaksi_jual_beli='$id_transaksi_jual_beli'");
                                while ($data2 = mysqli_fetch_array($query2)) {
                                    $id_transaksi_jual_beli_rincian = $data2['id_transaksi_jual_beli_rincian'];
                                    $id_barang = $data2['id_barang'];
                                    $nama_barang = $data2['nama_barang'];
                                    $satuan = $data2['satuan'];
                                    $qty = $data2['qty'];
                                    $hpp = $data2['hpp'];
                                    $harga = $data2['harga'];
                                    $ppn = $data2['ppn'];
                                    $diskon = $data2['diskon'];
                                    $subtotal = $data2['subtotal'];
                                    $total_hpp = $hpp * $qty;
                                    $margin = $subtotal - $total_hpp;
                                    
                                    // Format angka untuk tampilan yang lebih baik
                                    $hpp_formatted = number_format($hpp, 0, ',', '.');
                                    $qty_formatted = number_format($qty, 0, ',', '.');
                                    $ppn_formatted = number_format($ppn, 0, ',', '.');
                                    $diskon_formatted = number_format($diskon, 0, ',', '.');
                                    $subtotal_formatted = number_format($subtotal, 0, ',', '.');
                                    $total_hpp_formatted = number_format($total_hpp, 0, ',', '.');
                                    $margin_formatted = number_format($margin, 0, ',', '.');
                                    
                                    //Implementasi jumlah
                                    $jumlah_subtotal=$jumlah_subtotal+$subtotal;
                                    $jumlah_hpp=$jumlah_hpp+$total_hpp;
                                    $jumlah_margin=$jumlah_margin+$margin;
                                    //Tampilkan Data
                                    echo '
                                        <tr>
                                            <td class="text-center">'.$no.'</td>
                                            <td>'.date('d/m/Y', strtotime($tanggal)).'</td>
                                            <td>'.$kategori.'</td>
                                            <td>'.$nama_barang.'</td>
                                            <td class="text-right">'.$hpp_formatted.'</td>
                                            <td class="text-right">'.$qty_formatted.'</td>
                                            <td class="text-right">'.$ppn_formatted.'</td>
                                            <td class="text-right">'.$diskon_formatted.'</td>
                                            <td class="text-right">'.$subtotal_formatted.'</td>
                                            <td class="text-right">'.$total_hpp_formatted.'</td>
                                            <td class="text-right">'.$margin_formatted.'</td>
                                        </tr>
                                    ';
                                    $no++;
                                }
                            }
                            //Format Jumlah
                            $jumlah_subtotal_format = number_format($jumlah_subtotal, 0, ',', '.');
                            $jumlah_hpp_format = number_format($jumlah_hpp, 0, ',', '.');
                            $jumlah_margin_format = number_format($jumlah_margin, 0, ',', '.');
                            echo '
                                <tr>
                                    <td class="text-center"></td>
                                    <td colspan="7"><b>JUMLAH</b></td>
                                    <td class="text-right">'.$jumlah_subtotal_format.'</td>
                                    <td class="text-right">'.$jumlah_hpp_format.'</td>
                                    <td class="text-right">'.$jumlah_margin_format.'</td>
                                </tr>
                            ';
                            echo '              </tbody>';
                            echo '          </table>';
                            echo '      </div>';
                            echo '  </body>';
                            echo '</html>';
                        }else{
                            //Menampilkan Data Excel Disini

                            // Create new Spreadsheet object
                            $spreadsheet = new Spreadsheet();
                            $sheet = $spreadsheet->getActiveSheet();

                            // Set header tabel
                            $sheet->setCellValue('A1', 'No');
                            $sheet->setCellValue('B1', 'Tanggal');
                            $sheet->setCellValue('C1', 'Kategori');
                            $sheet->setCellValue('D1', 'Uraian');
                            $sheet->setCellValue('E1', 'Harga Beli');
                            $sheet->setCellValue('F1', 'Harga Jual');
                            $sheet->setCellValue('G1', 'QTY');
                            $sheet->setCellValue('H1', 'PPN');
                            $sheet->setCellValue('I1', 'Diskon');
                            $sheet->setCellValue('J1', 'Subtotal');
                            $sheet->setCellValue('K1', 'HPP');
                            $sheet->setCellValue('L1', 'Margin');

                            // Bold header kolom
                            $sheet->getStyle('A1:L1')->getFont()->setBold(true);

                            $no = 1;
                            $row_table = 2;

                            //Inisialisasi Jumlah
                            $jumlah_subtotal=0;
                            $jumlah_hpp=0;
                            $jumlah_margin=0;
                            //Buka Data Transaksi Jual Beli
                            $query = mysqli_query($Conn, "SELECT id_transaksi_jual_beli, kategori, tanggal FROM transaksi_jual_beli WHERE (kategori='Penjualan' OR kategori='Retur Penjualan') AND (tanggal BETWEEN '$periode_1 00:00:00' AND '$periode_2 23:59:59') ORDER BY tanggal ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $id_transaksi_jual_beli = $data['id_transaksi_jual_beli'];
                                $tanggal = $data['tanggal'];
                                $kategori = $data['kategori'];
                               
                                //Buka Rincian Transaksi Jual Beli
                                $query2 = mysqli_query($Conn, "SELECT * FROM transaksi_jual_beli_rincian WHERE id_transaksi_jual_beli='$id_transaksi_jual_beli'");
                                while ($data2 = mysqli_fetch_array($query2)) {
                                    $nama_barang=$data2['nama_barang'];
                                    $hpp=$data2['hpp'];
                                    $harga=$data2['harga'];
                                    $qty=$data2['qty'];
                                    $ppn=$data2['ppn'];
                                    $diskon=$data2['diskon'];
                                    $subtotal=$data2['subtotal'];
                                    $subtotal=$data2['subtotal'];
                                    $total_hpp = $hpp * $qty;
                                    $margin = $subtotal - $total_hpp;

                                    //Implementasi jumlah
                                    $jumlah_subtotal=$jumlah_subtotal+$subtotal;
                                    $jumlah_hpp=$jumlah_hpp+$total_hpp;
                                    $jumlah_margin=$jumlah_margin+$margin;

                                    //Tampilkan Data
                                    $sheet->setCellValue('A'.$row_table.'', ''.$no.'');
                                    $sheet->setCellValue('B'.$row_table.'', ''.$tanggal.'');
                                    $sheet->setCellValue('C'.$row_table.'', ''.$kategori.'');
                                    $sheet->setCellValue('D'.$row_table.'', ''.$nama_barang.'');
                                    $sheet->setCellValue('E'.$row_table.'', ''.$qty.'');
                                    $sheet->setCellValue('F'.$row_table.'', ''.$hpp.'');
                                    $sheet->setCellValue('G'.$row_table.'', ''.$harga.'');
                                    $sheet->setCellValue('H'.$row_table.'', ''.$ppn.'');
                                    $sheet->setCellValue('I'.$row_table.'', ''.$diskon.'');
                                    $sheet->setCellValue('J'.$row_table.'', ''.$subtotal.'');
                                    $sheet->setCellValue('K'.$row_table.'', ''.$total_hpp.'');
                                    $sheet->setCellValue('L'.$row_table.'', ''.$margin.'');

                                    //Loop Plus
                                    $no++;
                                    $row_table++;
                                }
                            }
                            //Tampilkan Data
                            $sheet->setCellValue('A'.$row_table.'', '');
                            $sheet->setCellValue('B'.$row_table.'', 'JUMLAH');
                            $sheet->setCellValue('C'.$row_table.'', '');
                            $sheet->setCellValue('D'.$row_table.'', '');
                            $sheet->setCellValue('E'.$row_table.'', '');
                            $sheet->setCellValue('F'.$row_table.'', '');
                            $sheet->setCellValue('G'.$row_table.'', '');
                            $sheet->setCellValue('H'.$row_table.'', '');
                            $sheet->setCellValue('I'.$row_table.'', '');
                            $sheet->setCellValue('J'.$row_table.'', ''.$jumlah_subtotal.'');
                            $sheet->setCellValue('K'.$row_table.'', ''.$jumlah_hpp.'');
                            $sheet->setCellValue('L'.$row_table.'', ''.$jumlah_margin.'');
                            // Set auto size untuk kolom
                            foreach(range('A', 'L') as $columnID) {
                                $sheet->getColumnDimension($columnID)->setAutoSize(true);
                            }

                            // Save Excel file
                            $writer = new Xlsx($spreadsheet);
                            $filename = 'Riwayat_Laba_Penjualan.xlsx';
                            $writer->save($filename);

                            // Download file
                            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                            header('Content-Disposition: attachment;filename="' . $filename . '"');
                            header('Cache-Control: max-age=0');
                            $writer->save('php://output');
                        }
                    }
                }
            }
        }
    }
?>