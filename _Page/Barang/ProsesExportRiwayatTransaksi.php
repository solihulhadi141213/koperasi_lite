<?php
    // Koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Load library PhpSpreadsheet
    require '../../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Font;

    if(empty($SessionIdAkses)){
        echo '
            <small class="text-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang</small>
        ';
    } else {
        if(empty($_POST['id_barang'])){
            echo '
                <small class="text-danger">ID Barang Tidak Boleh Kosong</small>
            ';
        } else {
            if(empty($_POST['periode_awal_transaksi'])){
                echo '
                    <small class="text-danger">Periode Awal Tidak Boleh Kosong</small>
                ';
            } else {
                if(empty($_POST['periode_akhir_transaksi'])){
                    echo '
                        <small class="text-danger">Periode Akhir Tidak Boleh Kosong</small>
                    ';
                } else {
                    $id_barang = validateAndSanitizeInput($_POST['id_barang']);
                    $periode_awal = validateAndSanitizeInput($_POST['periode_awal_transaksi']);
                    $periode_akhir = validateAndSanitizeInput($_POST['periode_akhir_transaksi']);

                    // Validasi Periode Awal Tidak Boleh Lebih Besar Dari Periode Akhir
                    if($periode_awal >= $periode_akhir){
                        echo '
                            <small class="text-danger">Periode Awal Tidak Boleh Lebih Besar Dari Periode Akhir</small>
                        ';
                    } else {
                        // Buka Nama Barang
                        $nama_barang = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'nama_barang');
                        $kode_barang = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'kode_barang');

                        // Buat Query
                        $query = "SELECT r.*, t.kategori, t.tanggal, t.status 
                                  FROM transaksi_jual_beli_rincian r
                                  JOIN transaksi_jual_beli t ON r.id_transaksi_jual_beli = t.id_transaksi_jual_beli
                                  WHERE r.id_barang = '$id_barang' AND t.tanggal >= '$periode_awal' AND t.tanggal <= '$periode_akhir'";

                        // Hitung jumlah data
                        $jml_data = mysqli_num_rows(mysqli_query($Conn, $query));

                        // Apabila Data Tidak Ada
                        if(empty($jml_data)){
                            echo '
                                <small class="text-danger">Tidak Ada Data Yang Ditemukan Pada Periode '.$periode_awal.' S/D '.$periode_akhir.'</small>
                            ';
                        } else {
                            // Create new Spreadsheet object
                            $spreadsheet = new Spreadsheet();
                            $sheet = $spreadsheet->getActiveSheet();

                            // Set judul tabel (merge cells dari A1 sampai K1)
                            $sheet->mergeCells('A1:K1');
                            $sheet->setCellValue('A1', 'RIWAYAT TRANSAKSI BARANG');
                            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle('A1')->getFont()->setBold(true); // Bold judul tabel

                            // Set nama barang (merge cells dari A2 sampai K2)
                            $sheet->mergeCells('A2:K2');
                            $sheet->setCellValue('A2', $nama_barang);
                            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle('A2')->getFont()->setBold(true); // Bold nama barang

                            // Set periode (merge cells dari A3 sampai K3)
                            $sheet->mergeCells('A3:K3');
                            $sheet->setCellValue('A3', 'PERIODE ' . date('d/m/Y', strtotime($periode_awal)) . ' - ' . date('d/m/Y', strtotime($periode_akhir)));
                            $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle('A3')->getFont()->setBold(true); // Bold periode

                            // Set header tabel
                            $sheet->setCellValue('A5', 'No');
                            $sheet->setCellValue('B5', 'Tanggal');
                            $sheet->setCellValue('C5', 'Kategori');
                            $sheet->setCellValue('D5', 'Harga');
                            $sheet->setCellValue('E5', 'QTY');
                            $sheet->setCellValue('F5', 'Satuan');
                            $sheet->setCellValue('G5', 'Jumlah');
                            $sheet->setCellValue('H5', 'PPN');
                            $sheet->setCellValue('I5', 'Diskon');
                            $sheet->setCellValue('J5', 'Subtotal');
                            $sheet->setCellValue('K5', 'Status');

                            // Bold header kolom
                            $sheet->getStyle('A5:K5')->getFont()->setBold(true);

                            // Fetch data and write to Excel
                            $result = mysqli_query($Conn, $query);
                            $row = 6;
                            $total_subtotal = 0;

                            while ($data = mysqli_fetch_assoc($result)) {
                                $tanggal = date('d/m/Y H:i:s', strtotime($data['tanggal']));
                                $jumlah = $data['qty'] * $data['harga'];
                                $total_subtotal += $data['subtotal']; // Akumulasi subtotal

                                $sheet->setCellValue('A' . $row, $row - 5);
                                $sheet->setCellValue('B' . $row, $tanggal);
                                $sheet->setCellValue('C' . $row, $data['kategori']);
                                $sheet->setCellValue('D' . $row, $data['harga']);
                                $sheet->setCellValue('E' . $row, $data['qty']);
                                $sheet->setCellValue('F' . $row, $data['satuan']);
                                $sheet->setCellValue('G' . $row, $jumlah);
                                $sheet->setCellValue('H' . $row, $data['ppn']);
                                $sheet->setCellValue('I' . $row, $data['diskon']);
                                $sheet->setCellValue('J' . $row, $data['subtotal']);
                                $sheet->setCellValue('K' . $row, $data['status']);
                                $row++;
                            }

                            // Set total subtotal (merge cells dari A sampai F dan tulis di kolom J)
                            $sheet->mergeCells('A' . $row . ':I' . $row);
                            $sheet->setCellValue('A' . $row, 'Total Subtotal');
                            $sheet->setCellValue('J' . $row, $total_subtotal);

                            // Set alignment untuk total subtotal
                            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                            $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                            // Set auto size untuk kolom
                            foreach(range('A', 'K') as $columnID) {
                                $sheet->getColumnDimension($columnID)->setAutoSize(true);
                            }

                            // Save Excel file
                            $writer = new Xlsx($spreadsheet);
                            $filename = 'Riwayat_Transaksi_Barang_' . $kode_barang . '_' . date('YmdHis') . '.xlsx';
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