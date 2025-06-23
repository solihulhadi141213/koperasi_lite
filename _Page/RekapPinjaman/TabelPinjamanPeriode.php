<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger text-center">';
        echo '  Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
        echo '</div>';
    }else{
        if(empty($_POST['tahun'])){
            echo '<div class="alert alert-danger text-center">';
            echo '  Pilih Tahun Data Yang Ingin Ditampilkan Terlebih Dulu';
            echo '</div>';
        }else{
            $tahun=$_POST['tahun'];
?>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <b>REKAPITULASI JUMLAH PINJAMAN DAN ANGSURAN</b><br>
                <?php
                    echo 'PERIODE TAHUN '.$tahun.'';
                ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalCetakPinjamanPeriode">
                    <i class="bi bi-printer"></i> Cetak / Export
                </a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td align="center"><b>No</b></td>
                            <td align="center"><b>Bulan</b></td>
                            <td align="center"><b>Jumlah Anggota</b></td>
                            <td align="center"><b>Pinjaman (Rp)</b></td>
                            <td align="center"><b>Angsuran Masuk (Rp)</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
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
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php
        }
    }
?>