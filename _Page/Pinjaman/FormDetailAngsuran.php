<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_pinjaman_angsuran'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_pinjaman_angsuran=$_POST['id_pinjaman_angsuran'];
            //Buka Detail Pinjaman Angsuran
            $uuid_angsuran=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'uuid_angsuran');
            $id_pinjaman=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'id_pinjaman');
            $id_anggota=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'id_anggota');
            $tanggal_angsuran=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'tanggal_angsuran');
            $tanggal_bayar=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'tanggal_bayar');
            $keterlambatan=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'keterlambatan');
            $pokok=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'pokok');
            $jasa=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'jasa');
            $denda=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'denda');
            $jumlah=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'jumlah');
            //Buka Data Pinjaman
            $jumlah_pinjaman=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'jumlah_pinjaman');
            //Format Rupiah
            if(empty($jumlah_pinjaman)){
                $jumlah_pinjaman=0;
            }
            if(empty($pokok)){
                $pokok=0;
            }
            if(empty($jasa)){
                $jasa=0;
            }
            if(empty($denda)){
                $denda=0;
            }
            if(empty($jumlah)){
                $jumlah=0;
            }
            if(empty($keterlambatan)){
                $keterlambatan=0;
            }
            $jumlah_pinjaman_rp = "Rp " . number_format($jumlah_pinjaman,0,',','.');
            $pokok_rp = "Rp " . number_format($pokok,0,',','.');
            $jasa_rp = "Rp " . number_format($jasa,0,',','.');
            $denda_rp = "Rp " . number_format($denda,0,',','.');
            $jumlah_rp = "Rp " . number_format($jumlah,0,',','.');
            //Format tanggal
            $strtotime1=strtotime($tanggal_angsuran);
            $strtotime2=strtotime($tanggal_bayar);
            $tanggal_angsuran_format=date('d/m/Y',$strtotime1);
            $tanggal_bayar_format=date('d/m/Y',$strtotime2);
            //Buka Sistem Denda
            $sistem_denda=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'sistem_denda');
            if($sistem_denda=="Harian"){
                $SatuanTerlambat="Hari";
            }else{
                $SatuanTerlambat="Bulan";
            }
?>
            <div class="row mb-3">
                <div class="col col-md-4">Tanggal Angsuran</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $tanggal_angsuran_format; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Tanggal Bayar</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $tanggal_bayar_format; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Keterlambatan</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo "$keterlambatan $SatuanTerlambat"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Jumlah Pinjaman</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $jumlah_pinjaman_rp; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Pokok</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $pokok_rp; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Jasa</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $jasa_rp; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Denda</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $denda_rp; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Jumlah Angsuran</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $jumlah_rp; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" colspan="4"><b>JURNAL ANGSURAN</b></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><b>Kode</b></td>
                                    <td class="text-center"><b>Akun Perkiraan</b></td>
                                    <td class="text-center"><b>Debet</b></td>
                                    <td class="text-center"><b>Kredit</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $AdaJurnal=GetDetailData($Conn,'jurnal','uuid',$uuid_angsuran,'uuid');
                                    if(empty($AdaJurnal)){
                                        echo '<tr>';
                                        echo '  <td colspan="4" align="center" class="text-danger">Tidak Ada Jurnal Untuk Transaksi pinjaman Ini</td>';
                                        echo '</tr>';
                                    }else{
                                        $JumlahSaldoDebet=0;
                                        $JumlahSaldoKredit=0;
                                        $query = mysqli_query($Conn, "SELECT*FROM jurnal WHERE uuid='$uuid_angsuran' ORDER BY d_k ASC");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $kode_perkiraan= $data['kode_perkiraan'];
                                            $nama_perkiraan= $data['nama_perkiraan'];
                                            $d_k= $data['d_k'];
                                            $nilai= $data['nilai'];
                                            //Format Rupiah
                                            $NilaiFormat = "Rp " . number_format($nilai,0,',','.');
                                            if($d_k=="D"){
                                                $JumlahSaldoDebet=$JumlahSaldoDebet+$nilai;
                                                $JumlahSaldoKredit=$JumlahSaldoKredit+0;
                                                echo '<tr>';
                                                echo '  <td align="left"><code class="text text-grayish">'.$kode_perkiraan.'</code></td>';
                                                echo '  <td align="left"><code class="text text-grayish">'.$nama_perkiraan.'</code></td>';
                                                echo '  <td align="right"><code class="text text-grayish">'.$NilaiFormat.'</code></td>';
                                                echo '  <td align="right"><code class="text text-grayish">-</code></td>';
                                                echo '</tr>';
                                            }else{
                                                $JumlahSaldoDebet=$JumlahSaldoDebet+0;
                                                $JumlahSaldoKredit=$JumlahSaldoKredit+$nilai;
                                                echo '<tr>';
                                                echo '  <td align="left"><code class="text text-grayish">'.$kode_perkiraan.'</code></td>';
                                                echo '  <td align="left"><code class="text text-grayish">'.$nama_perkiraan.'</code></td>';
                                                echo '  <td align="right"><code class="text text-grayish">-</code></td>';
                                                echo '  <td align="right"><code class="text text-grayish">'.$NilaiFormat.'</code></td>';
                                                echo '</tr>';
                                            }
                                        }
                                        $JumlahSaldoDebet = "Rp " . number_format($JumlahSaldoDebet,0,',','.');
                                        $JumlahSaldoKredit = "Rp " . number_format($JumlahSaldoKredit,0,',','.');
                                        echo '<tr>';
                                        echo '  <td align="center" colspan="2"><b>JUMLAH/SALDO</b></td>';
                                        echo '  <td align="right"><b>'.$JumlahSaldoDebet.'</b></td>';
                                        echo '  <td align="right"><b>'.$JumlahSaldoDebet.'</b></td>';
                                        echo '</tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12 mb-3 text-center">
                    <a href="index.php?Page=Pinjaman&Sub=DetailAngsuran&id=<?php echo $id_pinjaman_angsuran; ?>" class="btn btn-md btn-outline-primary btn-rounded">
                        <i class="bi bi-three-dots"></i> Atur Jurnal Angsuran
                    </a>
                </div>
            </div>
<?php
        }
    }
?>