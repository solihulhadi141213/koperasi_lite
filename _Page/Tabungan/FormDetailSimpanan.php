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
        if(empty($_POST['id_simpanan'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_simpanan=$_POST['id_simpanan'];
            //Buka Detail Simpanan
            $id_anggota=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_anggota');
            $uuid_simpanan=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'uuid_simpanan');
            $id_akses=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_akses');
            $id_simpanan_jenis=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'id_simpanan_jenis');
            $rutin=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'rutin');
            $nip=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'nip');
            $nama=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'nama');
            $lembaga=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'lembaga');
            $ranking=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'ranking');
            $tanggal=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'tanggal');
            $kategori=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'kategori');
            $keterangan=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'keterangan');
            $jumlah=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'jumlah');
            if($kategori=="Penarikan"){
                $LabelKategori='<code class="text text-danger">Penarikan dana simpanan</code>';
            }else{
                $LabelKategori='<code class="text text-success">'.$kategori.'</code>';
            }
            //Format tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y',$strtotime);
            //Format Rupiah
            $jumlah_format = "Rp " . number_format($jumlah,0,',','.');
            if(empty($keterangan)){
                $keterangan="-";
            }
?>
            <div class="row mb-3">
                <div class="col col-md-4">Tanggal</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $TanggalFormat; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">No.Induk</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $nip; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Nama</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $nama; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Divisi/Unit</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $lembaga; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Ranking</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $ranking; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Jenis Simpanan</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $LabelKategori; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Keterangan</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $keterangan; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Nominal</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $jumlah_format; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" colspan="4"><b>JURNAL SIMPANAN</b></td>
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
                                    $AdaJurnal=GetDetailData($Conn,'jurnal','uuid',$uuid_simpanan,'uuid');
                                    if(empty($AdaJurnal)){
                                        echo '<tr>';
                                        echo '  <td colspan="4" align="center" class="text-danger">Tidak Ada Jurnal Untuk Transaksi Simpanan Ini</td>';
                                        echo '</tr>';
                                    }else{
                                        $JumlahSaldoDebet=0;
                                        $JumlahSaldoKredit=0;
                                        $query = mysqli_query($Conn, "SELECT*FROM jurnal WHERE uuid='$uuid_simpanan' ORDER BY d_k ASC");
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
                <div class="col-md-12 text-center">
                    <a href="index.php?Page=Tabungan&Sub=DetailTabungan&id=<?php echo $id_simpanan; ?>" class="btn btn-md btn-primary btn-rounded">
                        Lihat Selengkapnya <i class="bi bi-three-dots"></i>
                    </a>
                </div>
            </div>
<?php
        }
    }
?>