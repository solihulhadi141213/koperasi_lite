<?php
    require '../../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(!empty($_POST['id_simpanan_jenis'])){
            $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
            $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
        }else{
            $id_simpanan_jenis="";
            $nama_simpanan="Akumulasi";
        }
        //tahun
        if(!empty($_POST['tahun'])){
            $tahun=$_POST['tahun'];
        }else{
            $tahun=date('Y');
        }
        $JumlahAnggota = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota"));
        if(empty($JumlahAnggota)){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <small class="text-danger">Data tidak bisa ditampilkan karena data anggota tidak ada</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            // Membuat objek Spreadsheet baru
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            // Menulis judul
            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'NIP');
            $sheet->setCellValue('C1', 'Nama Anggota');
            $sheet->setCellValue('D1', 'Lembaga');
            $sheet->setCellValue('E1', 'Ranking');
            $sheet->setCellValue('F1', 'Status');
            $sheet->setCellValue('G1', 'Januari');
            $sheet->setCellValue('H1', 'Februari');
            $sheet->setCellValue('I1', 'Maret');
            $sheet->setCellValue('J1', 'April');
            $sheet->setCellValue('K1', 'Mei');
            $sheet->setCellValue('L1', 'Juni');
            $sheet->setCellValue('M1', 'Juli');
            $sheet->setCellValue('N1', 'Agustus');
            $sheet->setCellValue('O1', 'September');
            $sheet->setCellValue('P1', 'Oktober');
            $sheet->setCellValue('Q1', 'November');
            $sheet->setCellValue('R1', 'Desember');
            // Mengatur gaya baris judul
            $sheet->getStyle('A1:Q1')->getFont()->setBold(true);
            $sheet->getStyle('A1:Q1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            // Membuat objek Writer untuk menulis Spreadsheet ke dalam file XLSX
            $writer = new Xlsx($spreadsheet);
            $no = 1;
            $row = 2;
            $query = mysqli_query($Conn, "SELECT*FROM anggota ORDER BY nama ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_anggota= $data['id_anggota'];
                $tanggal_masuk= $data['tanggal_masuk'];
                $tanggal_keluar= $data['tanggal_keluar'];
                $nip= $data['nip'];
                $nama= $data['nama'];
                $email= $data['email'];
                $kontak= $data['kontak'];
                $lembaga= $data['lembaga'];
                $ranking= $data['ranking'];
                $status= $data['status'];
                if($status=="Keluar"){
                    $strtotime2=strtotime($tanggal_keluar);
                    $TanggalKeluar=date('d/m/Y', $strtotime2);
                    $LabelStatus='Keluar';
                }else{
                    $TanggalKeluar="-";
                    $LabelStatus='Aktif';
                }
                //Menampilkan Data
                $sheet->setCellValueExplicit('A'.$row, $no, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('B'.$row, $nip, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('C'.$row, $nama, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('D'.$row, $lembaga, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('E'.$row, $ranking, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('F'.$row, $LabelStatus, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                //Otomatisasi Kolom
                $startLetter = 'G';
                $endLetter = 'R';
                $no_col=1;
                for ($char = ord($startLetter); $char <= ord($endLetter); $char++) {
                    //Nomor Bulan
                    $NomorBulan = str_pad($no_col, 2, '0', STR_PAD_LEFT);
                    $PeriodeKey="$tahun-$NomorBulan";
                    //Menghitung Jumlah Simpanan
                    if(!empty($_POST['id_simpanan_jenis'])){
                        $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
                        //Menghitung Jumlah Simpanan
                        $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM simpanan WHERE (id_anggota='$id_anggota' AND id_simpanan_jenis='$id_simpanan_jenis') AND (tanggal like '%$PeriodeKey%')"));
                        $jumlah_simpanan = $Sum['total'];
                    }else{
                        //Menghitung Jumlah Simpanan
                        $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM simpanan WHERE (id_anggota='$id_anggota' AND rutin=1) AND (tanggal like '%$PeriodeKey%')"));
                        $jumlah_simpanan = $Sum['total'];
                    }
                    // Mengubah kode ASCII kembali ke karakter
                    $column = chr($char);
                    $sheet->setCellValue($column.$row, $jumlah_simpanan);
                    $no_col++;
                }
                $row++; // Pindah ke baris berikutnya
                $no++;
            }
            // Menyesuaikan lebar kolom dengan karakter terpanjang
            foreach(range('A', 'R') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
            $filename="Simpanan-Wajib-$tahun";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename .'"');
            header('Cache-Control: max-age=0');
            
            // Menulis Spreadsheet ke dalam output PHP
            $writer->save('php://output');
        }
    }
?>