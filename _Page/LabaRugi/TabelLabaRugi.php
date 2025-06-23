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
        //Tangkap periode1
        if(empty($_POST['periode1'])){
            echo '<div class="card-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center">';
            echo '          <div class="alert alert-danger" role="alert">';
            echo '              Periode Awal Tidak Boleh Kosong';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
        //Tangkap periode2
            if(empty($_POST['periode2'])){
                echo '<div class="card-body">';
                echo '  <div class="row">';
                echo '      <div class="col-md-12 text-center">';
                echo '          <div class="alert alert-danger" role="alert">';
                echo '              Periode Akhir Tidak Boleh Kosong';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                //Tangkap akun_pemasukan
                if(empty($_POST['akun_pemasukan'])){
                    echo '<div class="card-body">';
                    echo '  <div class="row">';
                    echo '      <div class="col-md-12 text-center">';
                    echo '          <div class="alert alert-danger" role="alert">';
                    echo '              Akun Pemasukan Tidak Boleh Kosong';
                    echo '          </div>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }else{
                    //Tangkap akun_pengeluaran
                    if(empty($_POST['akun_pengeluaran'])){
                        echo '<div class="card-body">';
                        echo '  <div class="row">';
                        echo '      <div class="col-md-12 text-center">';
                        echo '          <div class="alert alert-danger" role="alert">';
                        echo '              Akun Pengeluaran Tidak Boleh Kosong';
                        echo '          </div>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        $periode2=$_POST['periode2'];
                        $periode1=$_POST['periode1'];
                        $akun_pemasukan=$_POST['akun_pemasukan'];
                        $akun_pengeluaran=$_POST['akun_pengeluaran'];
?>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="table table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center"><b>No</b></th>
                                                <th class="text-center"><b>Tanggal</b></th>
                                                <th class="text-center"><b>Kategori</b></th>
                                                <th class="text-center"><b>Akun Perkiraan</b></th>
                                                <th class="text-center"><b>Debet/Kredit</b></th>
                                                <th class="text-center"><b>Nominal</b></th>
                                                <th class="text-center"><b>Saldo</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-info">
                                                <td><b>A.</b></td>
                                                <td colspan="6"><b>Transaksi Pemasukan</b></td>
                                            </tr>
                                            <?php
                                                //Data pemasukan
                                                $NoPemasukan = 1;
                                                $SaldoPemasukan=0;
                                                //Menampilkan Akun Perkiraan Pemasukan
                                                $QruAkunPerkiraanPemasukan = mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd1='$akun_pemasukan' ORDER BY kode ASC");
                                                while ($DataAkunPemasukan = mysqli_fetch_array($QruAkunPerkiraanPemasukan)) {
                                                    $KodeAkunPemasukan= $DataAkunPemasukan['kode'];
                                                    $SaldoNormal= $DataAkunPemasukan['saldo_normal'];
                                                    //Menampilkan Jurnal
                                                    $QryJurnalPemasukan = mysqli_query($Conn, "SELECT*FROM jurnal WHERE (kode_perkiraan='$KodeAkunPemasukan') AND (tanggal>='$periode1') AND (tanggal<='$periode2') ORDER BY id_jurnal DESC");
                                                    while ($DataJurnalPemasukan = mysqli_fetch_array($QryJurnalPemasukan)) {
                                                        $KategoriPemasukan= $DataJurnalPemasukan['kategori'];
                                                        $NamaAkunPemasukan= $DataJurnalPemasukan['nama_perkiraan'];
                                                        $TanggalPemasukan= $DataJurnalPemasukan['tanggal'];
                                                        $DebetKreditPemasukan= $DataJurnalPemasukan['d_k'];
                                                        $NilaiPemasukan= $DataJurnalPemasukan['nilai'];
                                                        if($DebetKreditPemasukan=="D"){
                                                            $DebetKreditReal='Debet';
                                                        }else{
                                                            $DebetKreditReal='Kredit';
                                                        }
                                                        if($DebetKreditReal==$SaldoNormal){
                                                            $SaldoPemasukan=$SaldoPemasukan+$NilaiPemasukan;
                                                            $DebetKredit='<span class="text-success">'.$DebetKreditReal.'</span>';
                                                        }else{
                                                            $SaldoPemasukan=$SaldoPemasukan-$NilaiPemasukan;
                                                            $DebetKredit='<span class="text-danger">('.$DebetKreditReal.')</span>';
                                                        }
                                                        $NilaiPemasukanFormat = "Rp " . number_format($NilaiPemasukan,0,',','.');
                                                        $SaldoPemasukanFormat = "Rp " . number_format($SaldoPemasukan,0,',','.');
                                                        echo '<tr>';
                                                        echo '  <td class="text-center">A.'.$NoPemasukan.'</td>';
                                                        echo '  <td class="text-left">'.$TanggalPemasukan.'</td>';
                                                        echo '  <td class="text-left">'.$KategoriPemasukan.'</td>';
                                                        echo '  <td class="text-left">'.$KodeAkunPemasukan.' '.$NamaAkunPemasukan.'</td>';
                                                        echo '  <td class="text-left">'.$DebetKredit.'</td>';
                                                        echo '  <td align="right">'.$NilaiPemasukanFormat.'</td>';
                                                        echo '  <td align="right">'.$SaldoPemasukanFormat.'</td>';
                                                        echo '</tr>';
                                                        $NoPemasukan++;
                                                    }
                                                }
                                                $SaldoPemasukanFormat = "Rp " . number_format($SaldoPemasukan,0,',','.');
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td colspan="5"><b>JUMLAH SALDO PEMASUKAN</b></td>
                                                <td align="right"><b><?php echo $SaldoPemasukanFormat; ?></b></td>
                                            </tr>
                                            <tr class="bg-info">
                                                <td><b>B.</b></td>
                                                <td colspan="6"><b>Transaksi Pengeluaran</b></td>
                                            </tr>
                                            <?php
                                                //Data Pengeluaran
                                                $NoPengeluaran = 1;
                                                $SaldoPengeluaran=0;
                                                //Menampilkan Akun Perkiraan Pengeluaran
                                                $QruAkunPerkiraanPengeluaran = mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd1='$akun_pengeluaran' ORDER BY kode ASC");
                                                while ($DataAkunPengeluaran = mysqli_fetch_array($QruAkunPerkiraanPengeluaran)) {
                                                    $KodeAkunPengeluaran= $DataAkunPengeluaran['kode'];
                                                    $SaldoNormal= $DataAkunPengeluaran['saldo_normal'];
                                                    //Menampilkan Jurnal
                                                    $QryJurnalPengeluaran = mysqli_query($Conn, "SELECT*FROM jurnal WHERE (kode_perkiraan='$KodeAkunPengeluaran') AND (tanggal>='$periode1') AND (tanggal<='$periode2') ORDER BY id_jurnal DESC");
                                                    while ($DataJurnalPengeluaran = mysqli_fetch_array($QryJurnalPengeluaran)) {
                                                        $KategoriPengeluaran= $DataJurnalPengeluaran['kategori'];
                                                        $NamaAkunPengeluaran= $DataJurnalPengeluaran['nama_perkiraan'];
                                                        $TanggalPengeluaran= $DataJurnalPengeluaran['tanggal'];
                                                        $DebetKreditPengeluaran= $DataJurnalPengeluaran['d_k'];
                                                        $NilaiPengeluaran= $DataJurnalPengeluaran['nilai'];
                                                        if($DebetKreditPengeluaran=="D"){
                                                            $DebetKreditReal='Debet';
                                                        }else{
                                                            $DebetKreditReal='Kredit';
                                                        }
                                                        if($DebetKreditReal==$SaldoNormal){
                                                            $SaldoPengeluaran=$SaldoPengeluaran+$NilaiPengeluaran;
                                                            $DebetKredit='<span class="text-success">'.$DebetKreditReal.'</span>';
                                                        }else{
                                                            $SaldoPengeluaran=$SaldoPengeluaran-$NilaiPengeluaran;
                                                            $DebetKredit='<span class="text-danger">('.$DebetKreditReal.')</span>';
                                                        }
                                                        $NilaiPengeluaranFormat = "Rp " . number_format($NilaiPengeluaran,0,',','.');
                                                        $SaldoPengeluaranFormat = "Rp " . number_format($SaldoPengeluaran,0,',','.');
                                                        echo '<tr>';
                                                        echo '  <td class="text-center">A.'.$NoPengeluaran.'</td>';
                                                        echo '  <td class="text-left">'.$TanggalPengeluaran.'</td>';
                                                        echo '  <td class="text-left">'.$KategoriPengeluaran.'</td>';
                                                        echo '  <td class="text-left">'.$KodeAkunPengeluaran.' '.$NamaAkunPengeluaran.'</td>';
                                                        echo '  <td class="text-left">'.$DebetKredit.'</td>';
                                                        echo '  <td align="right">'.$NilaiPengeluaranFormat.'</td>';
                                                        echo '  <td align="right">'.$SaldoPengeluaranFormat.'</td>';
                                                        echo '</tr>';
                                                        $NoPengeluaran++;
                                                    }
                                                }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td colspan="5"><b>JUMLAH SALDO PENGELUARAN</b></td>
                                                <td align="right"><b><?php echo $SaldoPengeluaranFormat; ?></b></td>
                                            </tr>
                                            <?php
                                                //Menghitung Laba Rugi
                                                $LabaRugi=$SaldoPemasukan-$SaldoPengeluaran;
                                                $LabaRugiFormat = "Rp " . number_format($LabaRugi,0,',','.');
                                                if($LabaRugi<0){
                                                    $LabelLabaRugi='<span class="text-danger">'.$LabaRugiFormat.'</span>';
                                                }else{
                                                    $LabelLabaRugi='<span class="text-success">'.$LabaRugiFormat.'</span>';
                                                }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td colspan="5"><b>ESTIMASI LABA/RUGI</b></td>
                                                <td align="right"><b><?php echo $LabelLabaRugi; ?></b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-4 text-center">
                                <a href="_Page/LabaRugi/CetakLabaRugi.php?periode1=<?php echo "$periode1"; ?>&periode2=<?php echo "$periode2"; ?>&akun_pemasukan=<?php echo "$akun_pemasukan"; ?>&akun_pengeluaran=<?php echo "$akun_pengeluaran"; ?>" target="_blank" class="btn btn-md btn-outline-dark btn-rounded">
                                    <i class="bi bi-printer"></i> Export Laporan
                                </a>
                            </div>
                        </div>
                    </div>
<?php
                    }
                }
            }
        }
    }
?>