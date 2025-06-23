<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
?>
<div class="row mb-3">
    <div class="col-md-12" style="height: 350px; overflow-y: scroll;">
        <table class="table table-responsive table-bordered table-hover">
            <thead>
                <tr>
                    <th><b>No</b></th>
                    <th><b>Periode</b></th>
                    <th><b>Pinjaman</b></th>
                    <th><b>Pokok</b></th>
                    <th><b>Jasa</b></th>
                    <th><b>Angsuran</b></th>
                    <th><b>Sisa</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(empty($_POST['tanggal'])){
                        echo '<tr><td colspan="7" class="text-center text-danger">Isi Tanggal Pinjaman Terlebih Dulu</td></tr>';
                    }else{
                        if(empty($_POST['jumlah_pinjaman'])){
                            echo '<tr><td colspan="7" class="text-center text-danger">Isi Jumlah Pinjaman Terlebih Dulu</td></tr>';
                        }else{
                            $tanggal_pinjaman=$_POST['tanggal'];
                            $jumlah_pinjaman=$_POST['jumlah_pinjaman'];
                            if(empty($_POST['angsuran_total'])){
                                $nilai_angsuran=0;
                            }else{
                                $nilai_angsuran=$_POST['angsuran_total'];
                            }
                            if(empty($_POST['periode_angsuran'])){
                                $periode_angsuran=0;
                            }else{
                                $periode_angsuran=$_POST['periode_angsuran'];
                            }
                            if(empty($_POST['persen_jasa'])){
                                $persen_jasa="0";
                            }else{
                                $persen_jasa=$_POST['persen_jasa'];
                            }
                            
                            $jumlah_pinjaman= str_replace(",", "", $jumlah_pinjaman);
                            $nilai_angsuran= str_replace(",", "", $nilai_angsuran);
                            $periode_angsuran= str_replace(",", "", $periode_angsuran);
                            $persen_jasa= str_replace(",", "", $persen_jasa);
                            if(!preg_match("/^[0-9]*$/", $jumlah_pinjaman)){
                                echo '<tr><td colspan="7 class="text-center text-danger"">Jumlah Pinjaman Hanya Boleh Angka</td></tr>'; 
                            }else{
                                if(!preg_match("/^[0-9]*$/", $nilai_angsuran)){
                                    echo '<tr><td colspan="7" class="text-center text-danger">Nilai Angsuran Hanya Boleh Angka</td></tr>'; 
                                }else{
                                    if(!preg_match("/^[0-9]*$/", $periode_angsuran)){
                                        echo '<tr><td colspan="7" class="text-center text-danger">Periode Angsuran Hanya Boleh Angka</td></tr>'; 
                                    }else{
                                        if (!preg_match("/^[0-9]*\.?[0-9]+$/", $persen_jasa)) {
                                            echo '<tr><td colspan="7" class="text-center text-danger">Periode Jasa Hanya Boleh Angka</td></tr>'; 
                                        }else{
                                            if(empty($nilai_angsuran)&&empty($periode_angsuran)&&empty($persen_jasa)){
                                                echo '<tr><td colspan="7" class="text-center text-danger">Isi Nilai Angsuran atau Periode Angsuran atau Persen jasa Terlebih Dulu</td></tr>';
                                            }else{
                                                if(empty($nilai_angsuran)&&empty($periode_angsuran)){
                                                    echo '<tr><td colspan="7" class="text-center text-danger">Isi Periode Angsuran atau Persen jasa Terlebih Dulu</td></tr>';
                                                }else{
                                                    $TotalAngsuranPokok=0;
                                                    $TotalJasa=0;
                                                    $TotalAngsuranBruto=0;
                                                    if(empty($nilai_angsuran)){
                                                        //Simulasi berdasarkan periode angsuran
                                                        $SisaPinjaman=$jumlah_pinjaman;
                                                        for ( $i=1; $i<=$periode_angsuran; $i++ ){
                                                            $AngsuranPokok=$jumlah_pinjaman/$periode_angsuran;
                                                            $AngsuranPokokRp = "" . number_format($AngsuranPokok,0,',','.');
                                                            $NominalJasa=($persen_jasa/100)*$jumlah_pinjaman;
                                                            $NominalJasaRp = "" . number_format($NominalJasa,0,',','.');
                                                            $AngsuranTotal=$NominalJasa+$AngsuranPokok;
                                                            $AngsuranTotalRp = "" . number_format($AngsuranTotal,0,',','.');
                                                            $GetPeriodePinjaman=date('d/m/Y', strtotime('+'.$i.' month', strtotime($tanggal_pinjaman))); 
                                                            //Pinjaman RP
                                                            $jumlah_pinjaman_rp = "" . number_format($jumlah_pinjaman,0,',','.');
                                                            $SisaPinjaman=$SisaPinjaman-$AngsuranPokok;
                                                            $SisaPinjamanRp = "" . number_format($SisaPinjaman,0,',','.');
                                                            echo '<tr>';
                                                            echo '  <td align="center"><code class="text-dark">'.$i.'</code></td>';
                                                            echo '  <td align="left"><code class="text-dark">'.$GetPeriodePinjaman.'</code></td>';
                                                            echo '  <td align="right"><code class="text-dark">'.$jumlah_pinjaman_rp.'</code></td>';
                                                            echo '  <td align="right"><code class="text-dark">'.$AngsuranPokokRp.'</code></td>';
                                                            echo '  <td align="right"><code class="text-dark">'.$NominalJasaRp.'</code></td>';
                                                            echo '  <td align="right"><code class="text-dark">'.$AngsuranTotalRp.'</code></td>';
                                                            echo '  <td align="right"><code class="text-dark">'.$SisaPinjamanRp.'</code></td>';
                                                            echo '';
                                                            echo '</tr>';
                                                            $TotalAngsuranPokok=$TotalAngsuranPokok+$AngsuranPokok;
                                                            $TotalJasa=$TotalJasa+$NominalJasa;
                                                            $TotalAngsuranBruto=$TotalAngsuranBruto+$AngsuranTotal;
                                                        }
                                                    }else{
                                                        //Simulasi berdasarkan Nilai angsuran
                                                        //Mencari Periode Angsuran
                                                        $NominalJasa=($persen_jasa/100)*$jumlah_pinjaman;
                                                        if($nilai_angsuran<=$NominalJasa){
                                                            echo '<tr><td colspan="7" class="text-center text-danger">Nilai Angsuran Tidak Boleh Lebih Kecil/sama dengan nominal jasa</td></tr>';
                                                        }else{
                                                            $periode_angsuran=$jumlah_pinjaman/($nilai_angsuran-$NominalJasa);
                                                            $periode_angsuran=ceil($periode_angsuran);
                                                            $SisaPinjaman=$jumlah_pinjaman;
                                                            for ( $i=1; $i<=$periode_angsuran; $i++ ){
                                                                $AngsuranPokok=$nilai_angsuran-$NominalJasa;
                                                                $AngsuranPokokRp = "" . number_format($AngsuranPokok,0,',','.');
                                                                $NominalJasa=($persen_jasa/100)*$jumlah_pinjaman;
                                                                $NominalJasaRp = "" . number_format($NominalJasa,0,',','.');
                                                                $AngsuranTotal=$NominalJasa+$AngsuranPokok;
                                                                if($SisaPinjaman<$AngsuranTotal){
                                                                    $AngsuranTotal=$SisaPinjaman+$NominalJasa;
                                                                    $AngsuranPokok=$SisaPinjaman;
                                                                    $AngsuranPokokRp = "" . number_format($AngsuranPokok,0,',','.');
                                                                    $SisaPinjaman=$SisaPinjaman-$AngsuranPokok;
                                                                    $SisaPinjamanRp = "" . number_format($SisaPinjaman,0,',','.');
                                                                }else{
                                                                    $AngsuranTotal=$NominalJasa+$AngsuranPokok;
                                                                    $SisaPinjaman=$SisaPinjaman-$AngsuranPokok;
                                                                    $SisaPinjamanRp = "" . number_format($SisaPinjaman,0,',','.');
                                                                }
                                                                $AngsuranTotalRp = "" . number_format($AngsuranTotal,0,',','.');
                                                                $GetPeriodePinjaman=date('d/m/Y', strtotime('+'.$i.' month', strtotime($tanggal_pinjaman))); 
                                                                //Pinjaman RP
                                                                $jumlah_pinjaman_rp = "" . number_format($jumlah_pinjaman,0,',','.');
                                                                
                                                                echo '<tr>';
                                                                echo '  <td align="center"><code class="text-dark">'.$i.'</code></td>';
                                                                echo '  <td align="left"><code class="text-dark">'.$GetPeriodePinjaman.'</code></td>';
                                                                echo '  <td align="right"><code class="text-dark">'.$jumlah_pinjaman_rp.'</code></td>';
                                                                echo '  <td align="right"><code class="text-dark">'.$AngsuranPokokRp.'</code></td>';
                                                                echo '  <td align="right"><code class="text-dark">'.$NominalJasaRp.'</code></td>';
                                                                echo '  <td align="right"><code class="text-dark">'.$AngsuranTotalRp.'</code></td>';
                                                                echo '  <td align="right"><code class="text-dark">'.$SisaPinjamanRp.'</code></td>';
                                                                echo '';
                                                                echo '</tr>';
                                                                $TotalAngsuranPokok=$TotalAngsuranPokok+$AngsuranPokok;
                                                                $TotalJasa=$TotalJasa+$NominalJasa;
                                                                $TotalAngsuranBruto=$TotalAngsuranBruto+$AngsuranTotal;
                                                            }
                                                        }
                                                    }
                                                    $TotalAngsuranPokokRp = "" . number_format($TotalAngsuranPokok,0,',','.');
                                                    $TotalJasaRp = "" . number_format($TotalJasa,0,',','.');
                                                    $TotalAngsuranBrutoRp = "" . number_format($TotalAngsuranBruto,0,',','.');
                                                    echo '<tr>';
                                                    echo '  <td align="center" colspan="3"><code class="text-dark">JUMLAH TOTAL</code></td>';
                                                    echo '  <td align="right"><code class="text-dark">'.$TotalAngsuranPokokRp.'</code></td>';
                                                    echo '  <td align="right"><code class="text-dark">'.$TotalJasaRp.'</code></td>';
                                                    echo '  <td align="right"><code class="text-dark">'.$TotalAngsuranBrutoRp.'</code></td>';
                                                    echo '  <td align="right"><code class="text-dark">0</code></td>';
                                                    echo '';
                                                    echo '</tr>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
