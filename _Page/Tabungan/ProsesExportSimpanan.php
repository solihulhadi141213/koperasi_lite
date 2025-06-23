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
        if(empty($_POST['periode_1'])){
            $periode_1="0000-00-00";
        }else{
            $periode_1=$_POST['periode_1'];
        }
        if(empty($_POST['periode_2'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <small class="text-danger">Periode Akhir Data Tidak Boleh Kosong</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $periode_2=$_POST['periode_2'];
            $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan WHERE tanggal>='$periode_1' AND tanggal<='$periode_2'"));
            if(empty($JumlahData)){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <small class="text-danger">Data Simpanan Tidak Ditemukan</small>';
                echo '  </div>';
                echo '</div>';
            }else{
                // Membuat objek Spreadsheet baru
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                // Menulis judul
                $sheet->setCellValue('A1', 'No');
                $sheet->setCellValue('B1', 'Tanggal');
                $sheet->setCellValue('C1', 'NIP');
                $sheet->setCellValue('D1', 'Nama Anggota');
                $sheet->setCellValue('E1', 'Divisi/Unit');
                $sheet->setCellValue('F1', 'Ranking');
                $sheet->setCellValue('G1', 'Kategori Simpanan');
                $sheet->setCellValue('H1', 'Keterangan');
                $sheet->setCellValue('I1', 'Jumlah');
                // Mengatur gaya baris judul
                $sheet->getStyle('A1:I1')->getFont()->setBold(true);
                $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                // Membuat objek Writer untuk menulis Spreadsheet ke dalam file XLSX
                $writer = new Xlsx($spreadsheet);
                $no = 1;
                $row = 2;
                $query = mysqli_query($Conn, "SELECT*FROM simpanan WHERE tanggal>='$periode_1' AND tanggal<='$periode_2' ORDER BY tanggal ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $id_simpanan= $data['id_simpanan'];
                    $uuid_simpanan= $data['uuid_simpanan'];
                    $id_anggota= $data['id_anggota'];
                    $id_akses= $data['id_akses'];
                    $id_simpanan_jenis= $data['id_simpanan_jenis'];
                    $rutin= $data['rutin'];
                    $nip= $data['nip'];
                    $nama= $data['nama'];
                    $lembaga= $data['lembaga'];
                    $ranking= $data['ranking'];
                    $tanggal= $data['tanggal'];
                    $kategori= $data['kategori'];
                    $jumlah= $data['jumlah'];
                    $keterangan= $data['keterangan'];
                    //Format tanggal
                    $strtotime=strtotime($tanggal);
                    $TanggalFormat=date('d/m/Y',$strtotime);
                    //Format Rupiah
                    $jumlah_format = "Rp " . number_format($jumlah,0,',','.');
                    //Menampilkan Data
                    $sheet->setCellValueExplicit('A'.$row, $no, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit('B'.$row, $TanggalFormat, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit('C'.$row, $nip, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit('D'.$row, $nama, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit('E'.$row, $lembaga, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit('F'.$row, $ranking, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit('G'.$row, $kategori, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit('H'.$row, $keterangan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit('I'.$row, $jumlah, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $row++; // Pindah ke baris berikutnya
                    $no++;
                }
                // Menyesuaikan lebar kolom dengan karakter terpanjang
                foreach(range('A', 'R') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
                $filename="Log-Simpanan";
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'. $filename .'"');
                header('Cache-Control: max-age=0');
                
                // Menulis Spreadsheet ke dalam output PHP
                $writer->save('php://output');
            }
        }
    }
?>