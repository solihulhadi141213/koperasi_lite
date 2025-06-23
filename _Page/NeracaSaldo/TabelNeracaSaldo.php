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
                $periode1=$_POST['periode1'];
                $periode2=$_POST['periode2'];
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan"));
                if(empty($jml_data)){
                    echo '<div class="alert alert-danger text-center" role="alert">';
                    echo ' <b>Maaf!!</b><br>';
                    echo '  Tidak ada akun perkiraan yang terdaftar pada database!';
                    echo '</div>';
                }else{
                    $strtotime1=strtotime($periode1);
                    $strtotime2=strtotime($periode2);
                    $tanggal1=date('d/m/y',$strtotime1);
                    $tanggal2=date('d/m/y',$strtotime2);
?>
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <?php
                                echo '<b>LAPORAN NERACA SALDO</b><br>';
                                echo '<span>Periode '.$tanggal1.' s/d '.$tanggal2.'</span><br>';
                            ?>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <a href="_Page/NeracaSaldo/ProsesCetakNeraca.php?periode1=<?php echo $periode1; ?>&periode2=<?php echo $periode2; ?>" target="_blank" class="btn btn-sm btn-outline-grayish btn-rounded">
                                <i class="bi bi-printer"></i> Cetak Neraca Saldo
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 table table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <td align="center"><b>No</b></td>
                                        <td align="center"><b>Kode</b></td>
                                        <td align="center"><b>Nama Akun</b></td>
                                        <td align="center"><b>Saldo Normal</b></td>
                                        <td align="center"><b>Debet</b></td>
                                        <td align="center"><b>Kredit</b></td>
                                        <td align="center"><b>Saldo</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(empty($jml_data)){
                                            echo '<tr>';
                                            echo '  <td colspan="7" class="text-center">';
                                            echo '      <code class="text-danger">';
                                            echo '          Tidak Ada Data Akun Perkiraan Yang Dapat Ditampilkan';
                                            echo '      </code>';
                                            echo '  </td>';
                                            echo '</tr>';
                                        }else{
                                            // Query untuk mengambil akun level 1 (group utama)
                                            $NoUtama=1;
                                            $QryGroupUtama = mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE level='1' ORDER BY nama");
                                            while ($GroupUtama = mysqli_fetch_array($QryGroupUtama)) {
                                                $id_perkiraan_utama = $GroupUtama['id_perkiraan'];
                                                $kode_utama = $GroupUtama['kode'];
                                                $nama_utama = $GroupUtama['nama'];
                                                $saldo_normal_utama = $GroupUtama['saldo_normal'];
                                                // Tampilkan group utama
                                                echo '<tr>';
                                                echo '  <td align="center"><b>'.$NoUtama.'</b></td>';
                                                echo '  <td align="left"><b>'.$kode_utama.'</b></td>';
                                                echo '  <td align="left"><b>'.$nama_utama.'</b></td>';
                                                echo '  <td align="left"></td>';
                                                echo '  <td align="right"></td>';
                                                echo '  <td align="right"></td>';
                                                echo '  <td align="right"></td>';
                                                echo '</tr>';
                                                $NoAnak=1;
                                                // Query untuk mengambil anak group dari group utama berdasarkan kode
                                                $QryAnakGroup = mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE kode LIKE '$kode_utama%' AND level != '1' ORDER BY nama");
                                                while ($AnakGroup = mysqli_fetch_array($QryAnakGroup)) {
                                                    $id_perkiraan_anak = $AnakGroup['id_perkiraan'];
                                                    $nama_anak = $AnakGroup['nama'];
                                                    $saldo_normal_anak = $AnakGroup['saldo_normal'];
                                                    $kode = $AnakGroup['kode'];
                                                    $level = $AnakGroup['level'];
                                                    $LevelTerbawah = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM akun_perkiraan WHERE kd$level='$kode'"));
                                                    // Tampilkan anak group
                                                    if($LevelTerbawah=="1"){
                                                        //Jumlah Debet
                                                        $SumDebet = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(nilai) AS nilai FROM jurnal WHERE kode_perkiraan='$kode' AND d_k='D' AND tanggal>='$periode1' AND tanggal<='$periode2'"));
                                                        $JumlahDebet = $SumDebet['nilai'];
                                                        if(empty($JumlahDebet)){
                                                            $JumlahDebet=0;
                                                        }
                                                        $JumlahDebetFormat = "" . number_format($JumlahDebet,0,',','.');
                                                        //Jumlah Kredit
                                                        $SumKredit = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(nilai) AS nilai FROM jurnal WHERE kode_perkiraan='$kode' AND d_k='K' AND tanggal>='$periode1' AND tanggal<='$periode2'"));
                                                        $JumlahKredit = $SumKredit['nilai'];
                                                        if(empty($JumlahKredit)){
                                                            $JumlahKredit=0;
                                                        }
                                                        $JumlahKreditFormat = "" . number_format($JumlahKredit,0,',','.');
                                                        //Hitung Saldo Berdasarkan Saldo Normal
                                                        if($saldo_normal_anak=="Debet"){
                                                            $JumlahSaldo=$JumlahDebet-$JumlahKredit;
                                                        }else{
                                                            $JumlahSaldo=$JumlahKredit-$JumlahDebet;
                                                        }
                                                        $JumlahSaldoFormat="" . number_format($JumlahSaldo,0,',','.');
                                                        
                                                        echo '<tr class="text text-grayish">';
                                                        echo '  <td align="center">'.$NoAnak.'</td>';
                                                        echo '  <td align="left">'.$kode.'</td>';
                                                        echo '  <td align="left">'.$nama_anak.'</td>';
                                                        echo '  <td align="left">'.$saldo_normal_anak.'</td>';
                                                        echo '  <td align="right">'.$JumlahDebetFormat.'</td>';
                                                        echo '  <td align="right">'.$JumlahKreditFormat.'</td>';
                                                        echo '  <td align="right">'.$JumlahSaldoFormat.'</td>';
                                                        echo '</tr>';
                                                        $NoAnak++;
                                                    }
                                                }
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
?>