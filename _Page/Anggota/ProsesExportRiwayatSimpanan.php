<?php
    require '../../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Style\Color;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
    
    // Koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");

    // Validasi Akses
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{

        // Validasi id_anggota
        if(empty($_POST['id_anggota'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <small class="text-danger">ID Anggota Tidak Boleh Kosong!</small>';
            echo '  </div>';
            echo '</div>';
        }else{

            // Validasi periode_1
            if(empty($_POST['periode_1'])){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <small class="text-danger">Periode Awal Data Tidak Boleh Kosong!</small>';
                echo '  </div>';
                echo '</div>';
            }else{

                // Validasi periode_2
                if(empty($_POST['periode_2'])){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center">';
                    echo '      <small class="text-danger">Periode Akhir Data Tidak Boleh Kosong!</small>';
                    echo '  </div>';
                    echo '</div>';
                }else{

                    // Buat Variabel
                    $id_anggota = validateAndSanitizeInput($_POST['id_anggota']);
                    $periode_1 = validateAndSanitizeInput($_POST['periode_1']);
                    $periode_2 = validateAndSanitizeInput($_POST['periode_2']);

                    $jumlah_data_simpanan = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan FROM simpanan WHERE id_anggota='$id_anggota' AND tanggal>='$periode_1' AND tanggal<='$periode_2'"));
                    if(empty($jumlah_data_simpanan)){
                        echo '<div class="row">';
                        echo '  <div class="col-md-12 text-center">';
                        echo '      <small class="text-danger">Data tidak bisa ditampilkan karena data simpanan anggota tidak ada</small>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        // Membuat objek Spreadsheet baru
                        $spreadsheet = new Spreadsheet();
                        $sheet = $spreadsheet->getActiveSheet();
                        // Menulis judul
                        $sheet->setCellValue('A1', 'No');
                        $sheet->setCellValue('B1', 'TANGGAL');
                        $sheet->setCellValue('C1', 'ANGGOTA');
                        $sheet->setCellValue('D1', 'NOMOR INDUK');
                        $sheet->setCellValue('E1', 'KATEGORI SIMPANAN');
                        $sheet->setCellValue('F1', 'NOMINAL');
                        // Mengatur gaya baris judul
                        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
                        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        
                        $no = 1;
                        $row = 2;
                        $jumlah_simpanan = 0;
                        $jumlah_penarikan = 0;
                        $query = mysqli_query($Conn, "SELECT*FROM simpanan WHERE id_anggota='$id_anggota' AND tanggal>='$periode_1' AND tanggal<='$periode_2'");
                        while ($data = mysqli_fetch_array($query)) {
                            $id_simpanan_jenis = $data['id_simpanan_jenis'];
                            $tanggal = $data['tanggal'];
                            $nip = $data['nip'];
                            $nama = $data['nama'];
                            $kategori = $data['kategori'];
                            $jumlah = $data['jumlah'];
                            
                            $nama_jenis_simpanan = GetDetailData($Conn, 'simpanan_jenis', 'id_simpanan_jenis', $id_simpanan_jenis, 'nama_simpanan');
                            if($kategori == "Penarikan"){
                                $label_kategori = 'Penarikan (' . $nama_jenis_simpanan . ')';
                                $jumlah_penarikan += $jumlah;
                                $sheet->getStyle('E'.$row)->getFont()->getColor()->setARGB(Color::COLOR_RED);
                            }else{
                                $label_kategori = $kategori;
                                $jumlah_simpanan += $jumlah;
                            }
                            
                            $sheet->setCellValue('A'.$row, $no);
                            $sheet->setCellValue('B'.$row, $tanggal);
                            $sheet->setCellValue('C'.$row, $nama);
                            $sheet->setCellValue('D'.$row, $nip);
                            $sheet->setCellValue('E'.$row, $label_kategori);
                            $sheet->setCellValue('F'.$row, $jumlah);
                            
                            $row++;
                            $no++;
                        }

                        $sisa_simpanan = $jumlah_simpanan - $jumlah_penarikan;
                        $sheet->setCellValue('E'.$row, 'Total Simpanan');
                        $sheet->setCellValue('F'.$row, $jumlah_simpanan);
                        $row++;
                        $sheet->setCellValue('E'.$row, 'Total Penarikan');
                        $sheet->setCellValue('F'.$row, $jumlah_penarikan);
                        $row++;
                        $sheet->setCellValue('E'.$row, 'Sisa Simpanan');
                        $sheet->setCellValue('F'.$row, $sisa_simpanan);

                        foreach(range('A', 'F') as $columnID) {
                            $sheet->getColumnDimension($columnID)->setAutoSize(true);
                        }

                        $filename = "riwayat_simpanan_anggota-$id_anggota.xlsx";
                        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                        header('Content-Disposition: attachment;filename="' . $filename . '"');
                        header('Cache-Control: max-age=0');

                        $writer = new Xlsx($spreadsheet);
                        $writer->save('php://output');
                    }
                }
            }
        }
    }
?>
