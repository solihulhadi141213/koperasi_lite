<?php
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
        //Keyword_by
        if(empty($_POST['mode'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 text-center">';
            echo '      <small class="text-danger">Mode Periode Rekapitulasi Tidak Boleh Kosong</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $mode=$_POST['mode'];
            //tahun
            if(empty($_POST['tahun'])){
                echo '<div class="row">';
                echo '  <div class="col-md-12 text-center">';
                echo '      <small class="text-danger">Tahun DataTidak Boleh Kosong</small>';
                echo '  </div>';
                echo '</div>';
            }else{
                $tahun=$_POST['tahun'];
                //Validasi Bulan Tidak Boleh Kosong
                if($mode=="Tahunan"){
                    $ValidasiBulan="Valid";
                }else{
                    if(empty($_POST['bulan'])){
                        $ValidasiBulan="Valid";
                    }else{
                        $bulan=$_POST['bulan'];
                        $ValidasiBulan="Valid";
                    }
                }
                if($ValidasiBulan!=="Valid"){
                    echo '<div class="row">';
                    echo '  <div class="col-md-12 text-center">';
                    echo '      <small class="text-danger">'.$ValidasiBulan.'</small>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    
?>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <a href="_Page/RekapPinjaman/ProsesCetakrekap.php?tahun=<?php echo $tahun; ?>" class="btn btn-sm btn-outline-grayish btn-rounded" target="_blank">
                    <i class="bi bi-printer"></i> Cetak Data Rekap
                </a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td colspan="5" align="center">
                                <b>REKAPITULASI PINJAMAN <span style="text-transform: uppercase;"><?php echo "$mode"; ?></span></b><br>
                                PERIODE THN 
                                <?php
                                    if($mode=="Tahunan"){
                                        echo "$tahun";
                                    }else{
                                        echo "$tahun $bulan";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="center"><b>No</b></td>
                            <td align="center"><b>Periode</b></td>
                            <td align="center"><b>Anggota/Nasabah</b></td>
                            <td align="center"><b>Rp Pinjaman</b></td>
                            <td align="center"><b>Rp Angsuran Masuk</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($mode=="Tahunan"){
                                $JumlahTotalAnggota=0;
                                $JumlahTotalPinjaman=0;
                                $JumlahTotalAngsuran=0;
                                //Looping Bulan
                                $namaBulan = [
                                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                ];
                                // Looping dari 1 hingga 12
                                for ($i = 1; $i <= 12; $i++) {
                                    $angkaBulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                                    $namaBulanIni = $namaBulan[$i - 1];
                                    $keyword="$tahun-$angkaBulan";
                                    //Menghitung Jumlah Anggota Yang Melakukan Pinjaman Secara Distinct Pada Periode Tersebut
                                    $JumlahAnggota = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM pinjaman WHERE tanggal like '%$keyword%'"));
                                    //Sum Jumlah Pinjaman Pada Periode Tersebut
                                    $SumPinjaman = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah_pinjaman) AS jumlah FROM pinjaman WHERE tanggal like '%$keyword%'"));
                                    $JumlahPinjaman = $SumPinjaman['jumlah'];
                                    $JumlahPinjamanFormat = "Rp " . number_format($JumlahPinjaman,0,',','.');
                                    //Menghitung Angsuran Masuk
                                    $SumAngsuran = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM pinjaman_angsuran WHERE tanggal_bayar like '%$keyword%'"));
                                    $JumlahAngsuran = $SumAngsuran['total'];
                                    $JumlahAngsuranFormat = "Rp " . number_format($JumlahAngsuran,0,',','.');
                                    //Akumulasi Jumlah Total
                                    $JumlahTotalAnggota=$JumlahTotalAnggota+$JumlahAnggota;
                                    $JumlahTotalPinjaman=$JumlahTotalPinjaman+$JumlahPinjaman;
                                    $JumlahTotalAngsuran=$JumlahTotalAngsuran+$JumlahAngsuran;
                                    echo '<tr>';
                                    echo '  <td align="center">'.$i.'</td>';
                                    echo '  <td align="left">'.$namaBulanIni.'</td>';
                                    echo '  <td align="left">'.$JumlahAnggota.' Anggota</td>';
                                    echo '  <td align="right">'.$JumlahPinjamanFormat.'</td>';
                                    echo '  <td align="right">'.$JumlahAngsuranFormat.'</td>';
                                    echo '</tr>';
                                }
                                echo '<tr>';
                                echo '  <td colspan="5"></td>';
                                echo '</tr>';
                                echo '<tr>';
                                //Forma RP
                                $JumlahTotalPinjaman = "Rp " . number_format($JumlahTotalPinjaman,0,',','.');
                                $JumlahTotalAngsuran = "Rp " . number_format($JumlahTotalAngsuran,0,',','.');
                                echo '  <td align="center" colspan="2"><b>JUMLAH</b></td>';
                                echo '  <td align="left"><b>'.$JumlahTotalAnggota.' Anggota</b></td>';
                                echo '  <td align="right"><b>'.$JumlahTotalPinjaman.'</b></td>';
                                echo '  <td align="right"><b>'.$JumlahTotalAngsuran.'</b></td>';
                                echo '</tr>';
                            }else{
                                
                            }
                            
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mb-3">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td colspan="5" align="center">
                                <b>REKAPITULASI PINJAMAN BERDASARKAN LEMBAGA</b><br>
                                PERIODE THN 
                                <?php
                                    if($mode=="Tahunan"){
                                        echo "$tahun";
                                    }else{
                                        echo "$tahun $bulan";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="center"><b>No</b></td>
                            <td align="center"><b>Divisi/Unit</b></td>
                            <td align="center"><b>Anggota/Nasabah</b></td>
                            <td align="center"><b>Rp Pinjaman</b></td>
                            <td align="center"><b>Rp Angsuran Masuk</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($mode=="Tahunan"){
                                $JumlahTotalAnggota=0;
                                $JumlahTotalPinjaman=0;
                                $JumlahTotalAngsuran=0;
                                //Looping Bulan
                                $namaBulan = [
                                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                ];
                                //Looping Pinjaman Berdasarkan Lembaga
                                $no=1;
                                $query = mysqli_query($Conn, "SELECT DISTINCT lembaga FROM pinjaman ORDER BY lembaga ASC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $lembaga= $data['lembaga'];
                                    //Menghitung Jumlah Anggota Yang Melakukan Pinjaman Secara Distinct Pada Periode Tersebut
                                    $JumlahAnggota = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM pinjaman WHERE( lembaga='$lembaga') AND (tanggal like '%$tahun%')"));
                                    //Sum Jumlah Pinjaman Pada Periode Tersebut
                                    $SumPinjaman = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah_pinjaman) AS jumlah FROM pinjaman WHERE lembaga='$lembaga' AND tanggal like '%$tahun%'"));
                                    $JumlahPinjaman = $SumPinjaman['jumlah'];
                                    $JumlahPinjamanFormat = "Rp " . number_format($JumlahPinjaman,0,',','.');
                                    //Menghitung Angsuran Masuk
                                    $JumlahAngsuran=0;
                                    $QryPinjaman = mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE lembaga='$lembaga' AND tanggal like '%$tahun%'");
                                    while ($DataPinjaman = mysqli_fetch_array($QryPinjaman)) {
                                        $id_pinjaman=$DataPinjaman['id_pinjaman'];
                                        $SumAngsuran = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND tanggal_bayar like '%$tahun%'"));
                                        $total = $SumAngsuran['total'];
                                        $JumlahAngsuran=$JumlahAngsuran+$total;
                                    }
                                    $JumlahAngsuranFormat = "Rp " . number_format($JumlahAngsuran,0,',','.');
                                    //Akumulasi Jumlah Total
                                    $JumlahTotalAnggota=$JumlahTotalAnggota+$JumlahAnggota;
                                    $JumlahTotalPinjaman=$JumlahTotalPinjaman+$JumlahPinjaman;
                                    $JumlahTotalAngsuran=$JumlahTotalAngsuran+$JumlahAngsuran;
                                    echo '<tr>';
                                    echo '  <td align="center">'.$no.'</td>';
                                    echo '  <td align="left">'.$lembaga.'</td>';
                                    echo '  <td align="left">'.$JumlahAnggota.' Anggota</td>';
                                    echo '  <td align="right">'.$JumlahPinjamanFormat.'</td>';
                                    echo '  <td align="right">'.$JumlahAngsuranFormat.'</td>';
                                    echo '</tr>';
                                    $no++;
                                }
                                echo '<tr>';
                                echo '  <td colspan="5"></td>';
                                echo '</tr>';
                                echo '<tr>';
                                //Forma RP
                                $JumlahTotalPinjaman = "Rp " . number_format($JumlahTotalPinjaman,0,',','.');
                                $JumlahTotalAngsuran = "Rp " . number_format($JumlahTotalAngsuran,0,',','.');
                                echo '  <td align="center" colspan="2"><b>JUMLAH</b></td>';
                                echo '  <td align="left"><b>'.$JumlahTotalAnggota.' Anggota</b></td>';
                                echo '  <td align="right"><b>'.$JumlahTotalPinjaman.'</b></td>';
                                echo '  <td align="right"><b>'.$JumlahTotalAngsuran.'</b></td>';
                                echo '</tr>';
                            }else{
                                
                            }
                            
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php
                }
            }
        }
    }
?>