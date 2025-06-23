<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    //Menangkap Data
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger text-center" role="alert">';
        echo ' <b>Maaf!!</b><br>';
        echo '  Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
        echo '</div>';
    }else{
        if(empty($_POST['id_perkiraan'])){
            echo '<div class="alert alert-danger text-center" role="alert">';
            echo ' <b>Maaf!!</b><br>';
            echo '  ID Akun Perkiraan Tidak Boleh Kosong!';
            echo '</div>';
        }else{
            if(empty($_POST['periode1'])){
                echo '<div class="alert alert-danger text-center" role="alert">';
                echo ' <b>Maaf!!</b><br>';
                echo '  Periode Awal Laporan Tidak Boleh Kosong!';
                echo '</div>';
            }else{
                if(empty($_POST['periode2'])){
                    echo '<div class="alert alert-danger text-center" role="alert">';
                    echo ' <b>Maaf!!</b><br>';
                    echo '  Periode Akhir Laporan Tidak Boleh Kosong!';
                    echo '</div>';
                }else{
                    $id_perkiraan=$_POST['id_perkiraan'];
                    $periode1=$_POST['periode1'];
                    $periode2=$_POST['periode2'];
                    //Cari Kode Perkiraan
                    $kode=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kode');
                    $nama=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'nama');
                    $saldo_normal=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'saldo_normal');
                    if(empty($kode)){
                        echo '<div class="alert alert-danger text-center" role="alert">';
                        echo ' <b>Maaf!!</b><br>';
                        echo '  Kode Akun Perkiraan Yang Anda Pilih Tidak Ada pada Database!';
                        echo '</div>';
                    }else{
                        $strtotime1=strtotime($periode1);
                        $strtotime2=strtotime($periode2);
                        $tanggal1=date('d/m/y',$strtotime1);
                        $tanggal2=date('d/m/y',$strtotime2);
                        if($saldo_normal=="Debet"){
                            $SaldoNormal="D";
                        }else{
                            $SaldoNormal="K";
                        }
?>
                        <div class="row mb-4">
                            <div class="col-md-12 text-center">
                                <?php
                                    echo '<b>LAPORAN BUKU BESAR</b><br>';
                                    echo '<b>'.$nama.'</b><br>';
                                    echo '<span>Periode '.$tanggal1.' s/d '.$tanggal2.'</span><br>';
                                    echo '<small>Saldo Normal : <code class="text text-grayish">'.$saldo_normal.'</code></small><br>';
                                ?>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12 text-center">
                                <a href="_Page/BukuBesar/ProsesCetakBukuBesar.php?id_perkiraan=<?php echo $id_perkiraan; ?>&periode1=<?php echo $periode1; ?>&periode2=<?php echo $periode2; ?>" target="_blank" class="btn btn-sm btn-outline-grayish btn-rounded">
                                    <i class="bi bi-printer"></i> Cetak Buku Besar
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 table table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <td align="center"><b>No</b></td>
                                            <td align="center"><b>Tanggal</b></td>
                                            <td align="center"><b>Referensi</b></td>
                                            <td align="center"><b>Kategori</b></td>
                                            <td align="center"><b>Debet</b></td>
                                            <td align="center"><b>Kredit</b></td>
                                            <td align="center"><b>Saldo</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM jurnal WHERE kode_perkiraan='$kode' AND tanggal>='$periode1' AND tanggal<='$periode2'"));
                                            if(empty($jml_data)){
                                                echo '<tr>';
                                                echo '  <td colspan="7" class="text-center">';
                                                echo '      <code class="text-danger">';
                                                echo '          Tidak Ada Data Buku Besar Yang Dapat Ditampilkan';
                                                echo '      </code>';
                                                echo '  </td>';
                                                echo '</tr>';
                                            }else{
                                                $no = 1;
                                                $JumlahSaldo = 0;
                                                $query = mysqli_query($Conn, "SELECT*FROM jurnal WHERE kode_perkiraan='$kode' AND tanggal>='$periode1' AND tanggal<='$periode2' ORDER BY id_jurnal ASC");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $uuid= $data['uuid'];
                                                    $tanggal= $data['tanggal'];
                                                    $kategori= $data['kategori'];
                                                    $d_k= $data['d_k'];
                                                    $nilai= $data['nilai'];
                                                    if($d_k=="D"){
                                                        $NilaiDebet="Rp" . number_format($nilai,0,',','.');
                                                        $NilaiKredit="-";
                                                    }else{
                                                        $NilaiDebet="-";
                                                        $NilaiKredit="Rp" . number_format($nilai,0,',','.');
                                                    }
                                                    if($d_k==$SaldoNormal){
                                                        $JumlahSaldo = $JumlahSaldo+$nilai;
                                                    }else{
                                                        $JumlahSaldo = $JumlahSaldo-$nilai;
                                                    }
                                                    $strtotime=strtotime($tanggal);
                                                    $tanggal=date('d/m/y',$strtotime);
                                                    $RpSaldo="Rp" . number_format($JumlahSaldo,0,',','.');
                                                    echo '<tr>';
                                                    echo '  <td align="center">'.$no.'</td>';
                                                    echo '  <td align="left">'.$tanggal.'</td>';
                                                    echo '  <td align="left"><small><code class="text text-grayish">'.$uuid.'</code></small></td>';
                                                    echo '  <td align="left">'.$kategori.'</td>';
                                                    echo '  <td align="right">'.$NilaiDebet.'</td>';
                                                    echo '  <td align="right">'.$NilaiKredit.'</td>';
                                                    echo '  <td align="right">'.$RpSaldo.'</td>';
                                                    echo '</tr>';
                                                    $no++;
                                                }
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
    } 
?>