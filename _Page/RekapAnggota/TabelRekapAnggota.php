<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Cek Akses
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-12 text-center">';
        echo '      <code>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['periode'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col col-md-12 text-center">';
            echo '      <code>Mode Periode Data Tidak Boleh Kosong!</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $periode=$_POST['periode'];
            //Bersihkan Variabel
            $periode = validateAndSanitizeInput($periode);
            //Validasi Kelengkapan Data
            if($periode=="Semua"){
                $VariabelKelengkapanData="Valid";
                $keyword="";
            }else{
                if($periode=="Tahunan"){
                    if(empty($_POST['tahun'])){
                        $VariabelKelengkapanData="Parameter Tahun Tidak Boleh Kosong";
                    }else{
                        $VariabelKelengkapanData="Valid";
                        $tahun=$_POST['tahun'];
                        $tahun = validateAndSanitizeInput($tahun);
                        $keyword="$tahun";
                    }
                }else{
                    if($periode=="Bulanan"){
                        if(empty($_POST['tahun'])){
                            $VariabelKelengkapanData="Parameter Tahun Tidak Boleh Kosong";
                        }else{
                            if(empty($_POST['bulan'])){
                                $VariabelKelengkapanData="Parameter Bulan Tidak Boleh Kosong";
                            }else{
                                $VariabelKelengkapanData="Valid";
                                $tahun=$_POST['tahun'];
                                $bulan=$_POST['bulan'];
                                $bulan = validateAndSanitizeInput($bulan);
                                $tahun = validateAndSanitizeInput($tahun);
                                $keyword="$tahun-$bulan";
                            }
                        }
                    }else{
                        $VariabelKelengkapanData="Periode Data Tidak Valid";
                    }
                }
            }
            if($VariabelKelengkapanData!=="Valid"){
                echo '<div class="row mb-3">';
                echo '  <div class="col col-md-12 text-center">';
                echo '      <code>'.$VariabelKelengkapanData.'</code>';
                echo '  </div>';
                echo '</div>';
            }else{
?>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                REKAP DATA ANGGOTA  <span style="text-transform: uppercase;"><?php echo $periode; ?></span><br>
                <?php
                    if($periode=="Bulanan"){
                        $nama_bulan=getNamaBulan($bulan);
                        echo '<span style="text-transform: uppercase;">PERIODE '.$nama_bulan.' '.$tahun.'</span>';
                    }else{
                        if($periode=="Tahunan"){
                            echo '<span style="text-transform: uppercase;">PERIODE '.$tahun.'</span>';
                        }else{
    
                        }
                    }
                ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <button type="button"class="btn btn-sm btn-outline-grayish btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalCetak">
                    <i class="bi bi-printer"></i> Cetak Data Rekap
                </button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td align="center" valign="middle"><b>No</b></td>
                            <td align="center" valign="middle"><b>Divisi/Unit</b></td>
                            <td align="center" valign="middle"><b>Anggota Masuk</b></td>
                            <td align="center" valign="middle"><b>Anggota Keluar</b></td>
                            <td align="center" valign="middle"><b>Anggota Aktif</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //Hitung Jumlah Lembaga
                            $JumlahLembaga = mysqli_num_rows(mysqli_query($Conn, "SELECT DISTINCT lembaga FROM anggota"));
                            if(empty($JumlahLembaga)){
                                echo '<tr>';
                                echo '  <td colspan="555" class="text-center">';
                                echo '      <code class="text-danger">';
                                echo '          Tidak Ada Data Anggota Yang Dapat Ditampilkan';
                                echo '      </code>';
                                echo '  </td>';
                                echo '</tr>';
                            }else{
                                $no = 1;
                                //KONDISI PENGATURAN MASING FILTER
                                $JumlahTotalMasuk=0;
                                $JumlahTotalKeluar=0;
                                $JumlahTotalAktif=0;
                                $query = mysqli_query($Conn, "SELECT DISTINCT lembaga FROM anggota ORDER BY lembaga ASC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $lembaga= $data['lembaga'];
                                    //Jumlah Anggota Masuk-Keluar-Aktif
                                    $JumlahAnggotaMasuk = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota, tanggal_masuk FROM anggota WHERE lembaga='$lembaga' AND tanggal_masuk like '%$keyword%'"));
                                    $JumlahAnggotaKeluar = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota, tanggal_keluar FROM anggota WHERE lembaga='$lembaga' AND status='Keluar' AND tanggal_keluar like '%$keyword%'"));
                                    $JumlahAnggotaAktif = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE lembaga='$lembaga' AND status='Aktif'"));
                                    //Menghitung Jumlah Total
                                    $JumlahTotalMasuk=$JumlahTotalMasuk+$JumlahAnggotaMasuk;
                                    $JumlahTotalKeluar=$JumlahTotalKeluar+$JumlahAnggotaKeluar;
                                    $JumlahTotalAktif=$JumlahTotalAktif+$JumlahAnggotaAktif;
                        ?>
                                    <tr>
                                        <td align="center"><small class="credit"><?php echo $no; ?></small></td>
                                        <td align="left">
                                            <small class="credit">
                                                <?php echo $lembaga; ?>
                                            </small>
                                        </td>
                                        <td align="right">
                                            <small class="credit">
                                                <?php echo $JumlahAnggotaMasuk; ?>
                                            </small>
                                        </td>
                                        <td align="right">
                                            <small class="credit">
                                                <?php echo $JumlahAnggotaKeluar; ?>
                                            </small>
                                        </td>
                                        <td align="right">
                                            <small class="credit">
                                                <?php echo $JumlahAnggotaAktif; ?>
                                            </small>
                                        </td>
                                    </tr>
                        <?php
                                    $no++; 
                                }
                            }
                        ?>
                        <tr>
                            <td colspan="2" align="center"><b>JUMLAH</b></td>
                            <td align="right"><b><?php echo "$JumlahTotalMasuk"; ?></b></td>
                            <td align="right"><b><?php echo "$JumlahTotalKeluar"; ?></b></td>
                            <td align="right"><b><?php echo "$JumlahTotalAktif"; ?></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

<?php
            }
        }
    }
?>