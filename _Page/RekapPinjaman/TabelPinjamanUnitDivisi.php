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
        //tahun
        if(empty($_POST['tahun'])){
            $tahun="";
        }else{
            $tahun=$_POST['tahun'];
        }
?>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <b>REKAPITULASI PINJAMAN UNIT/DIVISI</b><br>
                <?php
                    if(empty($tahun)){
                        echo ' SEMUA PERIODE';
                    }else{
                        echo 'PERIODE TAHUN '.$tahun.'';
                    }
                ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalCetakRekapPinjamanUnitDivisi">
                    <i class="bi bi-printer"></i> Cetak/Export
                </a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="table table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td align="center"><b>No</b></td>
                            <td align="center"><b>Unit/Divisi</b></td>
                            <td align="center"><b>Anggota</b></td>
                            <td align="center"><b>Rp Pinjaman</b></td>
                            <td align="center"><b>Rp Angsuran Masuk</b></td>
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
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php
    }
?>