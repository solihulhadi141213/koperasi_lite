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
    }else{
        //Pengaturan Kolom Denda
        if(empty($_POST['sertakan_denda'])){
            $sertakan_denda="";
        }else{
            $sertakan_denda=$_POST['sertakan_denda'];
        }
        $JumlahData = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM pinjaman WHERE status='Berjalan'"));
        if(empty($JumlahData)){
            echo "Belum Ada Data Pinjaman Pada Periode Tersebut";
            exit;
        } else {
            // Membuat objek Spreadsheet baru
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            // Menulis judul
            if(empty($sertakan_denda)){
                $headers = [
                    'A1' => 'No',
                    'B1' => 'NIP',
                    'C1' => 'Nama Anggota',
                    'D1' => 'Divisi/Unit',
                    'E1' => 'Ranking',
                    'F1' => 'Tanggal',
                    'G1' => 'Jatuh Tempo',
                    'H1' => 'Rp Pinjaman',
                    'I1' => '% Jasa',
                    'J1' => 'Rp Jasa',
                    'K1' => 'Rp Pokok',
                    'L1' => 'Rp Angsuran',
                    'M1' => 'Periode Angsuran',
                    'N1' => 'Periode Tunggakan',
                    'O1' => 'Jumlah Tunggakan',
                ];
            }else{
                $headers = [
                    'A1' => 'No',
                    'B1' => 'NIP',
                    'C1' => 'Nama Anggota',
                    'D1' => 'Divisi/Unit',
                    'E1' => 'Ranking',
                    'F1' => 'Tanggal',
                    'G1' => 'Jatuh Tempo',
                    'H1' => '% Denda',
                    'I1' => 'Sistem Denda',
                    'J1' => 'Rp Pinjaman',
                    'K1' => '% Jasa',
                    'L1' => 'Rp Jasa',
                    'M1' => 'Rp Pokok',
                    'N1' => 'Rp Angsuran',
                    'O1' => 'Periode Angsuran',
                    'P1' => 'Periode Tunggakan',
                    'Q1' => 'Jumlah Tunggakan',
                ];
            }
            

            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }

            // Mengatur gaya baris judul
            if(empty($sertakan_denda)){
                $sheet->getStyle('A1:O1')->getFont()->setBold(true);
                $sheet->getStyle('A1:O1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }else{
                $sheet->getStyle('A1:Q1')->getFont()->setBold(true);
                $sheet->getStyle('A1:Q1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }

            // Membuat objek Writer untuk menulis Spreadsheet ke dalam file XLSX
            $writer = new Xlsx($spreadsheet);

            $no = 1;
            $row = 2;
            $query = mysqli_query($Conn, "SELECT * FROM pinjaman WHERE status='Berjalan' ORDER BY tanggal ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_pinjaman= $data['id_pinjaman'];
                $uuid_pinjaman= $data['uuid_pinjaman'];
                $id_anggota= $data['id_anggota'];
                $nama= $data['nama'];
                $nip= $data['nip'];
                $lembaga= $data['lembaga'];
                $ranking= $data['ranking'];
                $tanggal= $data['tanggal'];
                $jatuh_tempo= $data['jatuh_tempo'];
                $jumlah_pinjaman= $data['jumlah_pinjaman'];
                $denda= $data['denda'];
                $sistem_denda= $data['sistem_denda'];
                $persen_jasa= $data['persen_jasa'];
                $rp_jasa= $data['rp_jasa'];
                $angsuran_pokok= $data['angsuran_pokok'];
                $angsuran_total= $data['angsuran_total'];
                $periode_angsuran= $data['periode_angsuran'];
                $status= $data['status'];
                //Tanggal Sekarang
                $TanggalSekarang=date('Y-m-d');
                //Simulasi Pinjaman
                $JumlahPeriodeTagihan=0;
                $JumlahTunggakan=0;
                for ( $i=1; $i<=$periode_angsuran; $i++ ){
                    $GetPeriodePinjaman=date('d/m/Y', strtotime('+'.$i.' month', strtotime($tanggal))); 
                    //Ubah Format Tangga
                    $GetPeriodePinjaman2=date('Y-m-d', strtotime('+'.$i.' month', strtotime($tanggal))); 
                    if($TanggalSekarang>$GetPeriodePinjaman2){
                        //Cek Apakah Sudah Ada Angsuran
                        $QryAngsuran = mysqli_query($Conn,"SELECT * FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND tanggal_angsuran='$GetPeriodePinjaman2'")or die(mysqli_error($Conn));
                        $DataAngsuran = mysqli_fetch_array($QryAngsuran);
                        if(empty($DataAngsuran['id_pinjaman_angsuran'])){
                            $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+1;
                            $JumlahTunggakan=$JumlahTunggakan+$angsuran_total;
                        }else{
                            $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+0;
                            $JumlahTunggakan=$JumlahTunggakan+0;
                        }
                    }else{
                        $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+0;
                        $JumlahTunggakan=$JumlahTunggakan+0;
                    }
                }
                $JumlahTunggakanFormat = "" . number_format($JumlahTunggakan,0,',','.');
                if(!empty($JumlahTunggakan)){
                    // Format tanggal
                    $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(new DateTime($tanggal));
                    // Menampilkan Data
                    $sheet->setCellValue('A'.$row, $no);
                    $sheet->setCellValue('B'.$row, $nip);
                    $sheet->setCellValue('C'.$row, $nama);
                    $sheet->setCellValue('D'.$row, $lembaga);
                    $sheet->setCellValue('E'.$row, $ranking);
                    // Format tanggal di Excel
                    $sheet->setCellValue('F'.$row, $tanggal);
                    $sheet->getStyle('F'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                    //Lanjutan
                    $sheet->setCellValue('G'.$row, $jatuh_tempo);

                    if(empty($sertakan_denda)){
                        // Format angka di Excel
                        $sheet->setCellValue('H'.$row, $denda);
                        $sheet->getStyle('H'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        $sheet->setCellValue('I'.$row, $persen_jasa);
                        $sheet->getStyle('I'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        
                        $sheet->setCellValue('J'.$row, $rp_jasa);
                        $sheet->getStyle('J'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        $sheet->setCellValue('K'.$row, $angsuran_pokok);
                        $sheet->getStyle('K'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        $sheet->setCellValue('L'.$row, $angsuran_total);
                        $sheet->getStyle('L'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        $sheet->setCellValue('M'.$row, $periode_angsuran);
                        $sheet->getStyle('M'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        
                        $sheet->setCellValue('N'.$row, $JumlahPeriodeTagihan);
                        $sheet->setCellValue('O'.$row, $JumlahTunggakan);
                        $sheet->getStyle('O'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        $row++; // Pindah ke baris berikutnya
                        $no++;
                    }else{
                        // Format angka di Excel
                        $sheet->setCellValue('H'.$row, $denda);
                        $sheet->getStyle('H'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        //Lanjutan
                        $sheet->setCellValue('I'.$row, $sistem_denda);
                        // Format angka jumlah_pinjaman di Excel
                        $sheet->setCellValue('J'.$row, $jumlah_pinjaman);
                        $sheet->getStyle('J'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        $sheet->setCellValue('K'.$row, $persen_jasa);
                        $sheet->getStyle('K'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        
                        $sheet->setCellValue('L'.$row, $rp_jasa);
                        $sheet->getStyle('L'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        $sheet->setCellValue('M'.$row, $angsuran_pokok);
                        $sheet->getStyle('M'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        $sheet->setCellValue('N'.$row, $angsuran_total);
                        $sheet->getStyle('N'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        $sheet->setCellValue('O'.$row, $periode_angsuran);
                        $sheet->getStyle('O'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        
                        $sheet->setCellValue('P'.$row, $JumlahPeriodeTagihan);
                        $sheet->setCellValue('Q'.$row, $JumlahTunggakan);
                        $sheet->getStyle('Q'.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        $row++; // Pindah ke baris berikutnya
                        $no++;
                    }
                }
            }

            // Menyesuaikan lebar kolom dengan karakter terpanjang
            if(empty($sertakan_denda)){
                foreach(range('A', 'O') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            }else{
                foreach(range('A', 'Q') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            }

            $filename = "Tunggakan.xlsx";
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename .'"');
            header('Cache-Control: max-age=0');
            
            // Menulis Spreadsheet ke dalam output PHP
            $writer->save('php://output');
        }
    }
?>
