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
        if(empty($_POST['id_pinjaman'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_pinjaman=$_POST['id_pinjaman'];
            //Buka Detail Pinjaman
            $Qry = $Conn->prepare("SELECT * FROM pinjaman WHERE id_pinjaman = ?");
            $Qry->bind_param("s", $id_pinjaman);
            if (!$Qry->execute()) {
                $error=$Conn->error;
                $response = [
                    "status" => "Error",
                    "message" => $error
                ];
                echo '
                    <div class="alert alert-danger">
                        Terjadi Kesalahan pada saat membuka data pinjaman!<br>
                        Error : '.$error.'
                    </div>
                ';
            }else{
                $Result = $Qry->get_result();
                $Data = $Result->fetch_assoc();
                $Qry->close();
                //Buat Variabel
                $id_anggota=$Data['id_anggota'];
                $uuid_pinjaman=$Data['uuid_pinjaman'];
                $nip=$Data['nip'];
                $nama=$Data['nama'];
                $lembaga=$Data['lembaga'];
                $ranking=$Data['ranking'];
                $tanggal=$Data['tanggal'];
                $jatuh_tempo=$Data['jatuh_tempo'];
                $denda=$Data['denda'];
                $sistem_denda=$Data['sistem_denda'];
                $jumlah_pinjaman=$Data['jumlah_pinjaman'];
                $persen_jasa=$Data['persen_jasa'];
                $rp_jasa=$Data['rp_jasa'];
                $angsuran_pokok=$Data['angsuran_pokok'];
                $angsuran_total=$Data['angsuran_total'];
                $periode_angsuran=$Data['periode_angsuran'];
                $status=$Data['status'];
            
                //Nilai Bulan dan Tahun dari tanggal
                $strtotime_tanggal=strtotime($tanggal);
                $BulanTahun=date('m-Y',$strtotime_tanggal);
                //Bentukk Ulang Tanggal Dari Tanggal Jatuh Tempo
                $tanggal="$jatuh_tempo-$BulanTahun";
?>
                <div class="row mb-3">
                    <div class="col col-md-12">
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <b>Keterangan</b><br>
                            Nilai denda akan muncul apabila terdapat keterlambatan bayar. Nilai tersebut ditentukan sistem denda yang berlaku.<br>
                            Sistem akan melakukan update status pinjaman secara otomatis apabila angsuran terdeteksi sudah lunas.
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 table table-responsive">
                        <table class="table table-responsive table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td align="center"><b>No</b></td>
                                    <td align="center"><b>Tempo</b></td>
                                    <td align="center"><b>Tgl Bayar</b></td>
                                    <td align="center"><b>Pokok</b></td>
                                    <td align="center"><b>Jasa</b></td>
                                    <?php
                                        //Apabila Denda 0 Maka Hilangkan Kolom Denda
                                        if(!empty($denda)){
                                            echo '<td align="center"><b>Denda</b></td>';
                                        }
                                    ?>
                                    
                                    <td align="center"><b>Angsuran</b></td>
                                    <td align="center"><b>Sisa Pokok</b></td>
                                    <td align="center"><b>Opsi</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $TotalAngsuranPokok=0;
                                    $TotalJasa=0;
                                    $TotalAngsuranBruto=0;
                                    $TotalDenda=0;
                                    $SisaPinjaman=$jumlah_pinjaman;
                                    for ( $i=1; $i<=$periode_angsuran; $i++ ){
                                        $AngsuranPokok=$jumlah_pinjaman/$periode_angsuran;
                                        $AngsuranPokokRp = "" . number_format($AngsuranPokok,0,',','.');
                                        $NominalJasa=($persen_jasa/100)*$jumlah_pinjaman;
                                        $NominalJasaRp = "" . number_format($NominalJasa,0,',','.');
                                        $AngsuranTotal=$NominalJasa+$AngsuranPokok;
                                        $AngsuranTotalRp = "" . number_format($AngsuranTotal,0,',','.');
                                        $GetPeriodePinjaman=date('d/m/Y', strtotime('+'.$i.' month', strtotime($tanggal))); 
                                        //Pinjaman RP
                                        $jumlah_pinjaman_rp = "" . number_format($jumlah_pinjaman,0,',','.');
                                        $SisaPinjaman=$SisaPinjaman-$AngsuranPokok;
                                        $SisaPinjamanRp = "" . number_format($SisaPinjaman,0,',','.');
                                        //Ubah Format Tangga
                                        $GetPeriodePinjaman2=date('Y-m-d', strtotime('+'.$i.' month', strtotime($tanggal))); 
                                        
                                        //Cek Apakah Sudah Ada Angsuran
                                        $QryAngsuran = mysqli_query($Conn,"SELECT * FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND tanggal_angsuran='$GetPeriodePinjaman2'")or die(mysqli_error($Conn));
                                        $DataAngsuran = mysqli_fetch_array($QryAngsuran);

                                        //Apabila Belum Ada
                                        if(empty($DataAngsuran['id_pinjaman_angsuran'])){
                                            echo '<tr>';
                                            echo '  <td align="center"><code class="text-grayish">'.$i.'</code></td>';
                                            echo '  <td align="left"><code class="text-grayish">'.$GetPeriodePinjaman.'</code></td>';
                                            echo '  <td align="left"><code class="text-grayish"></code>-</td>';
                                            echo '  <td align="right"><code class="text-grayish">'.$AngsuranPokokRp.'</code></td>';
                                            echo '  <td align="right"><code class="text-grayish">'.$NominalJasaRp.'</code></td>';
                                            if(!empty($denda)){
                                                //Apabila denda 0 maka hilangkan kolom denda
                                                echo '  <td align="right"><code class="text-grayish">-</code></td>';
                                            }
                                            echo '  <td align="right"><code class="text-grayish">'.$AngsuranTotalRp.'</code></td>';
                                            echo '  <td align="right"><code class="text-grayish">'.$SisaPinjamanRp.'</code></td>';
                                            echo '  <td align="center">';
                                            echo '      <button type="button" class="btn btn-sm btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalTambahAngsuran" data-id="'.$id_pinjaman.','.$GetPeriodePinjaman2.'">';
                                            echo '          <i class="bi bi-plus"></i> Bayar';
                                            echo '      </button>';
                                            echo '  </td>';
                                            echo '</tr>';
                                            $RpSisaAngsuranTotal=$jumlah_pinjaman_rp;
                                            $TotalJasa=$TotalJasa+0;
                                            $TotalDenda=$TotalDenda+0;
                                            $TotalAngsuranBruto=$TotalAngsuranBruto+0;
                                        }else{
                                            $id_pinjaman_angsuran=$DataAngsuran['id_pinjaman_angsuran'];
                                            $tanggal_bayar=$DataAngsuran['tanggal_bayar'];
                                            $keterlambatan=$DataAngsuran['keterlambatan'];
                                            $denda_angssuran=$DataAngsuran['denda'];
                                            $jumlah=$DataAngsuran['jumlah'];
                                            $pokok=$DataAngsuran['pokok'];
                                            $jasa=$DataAngsuran['jasa'];
                                            //Format Tanggal
                                            $tanggal_bayar=date('d/m/Y', strtotime($tanggal_bayar)); 
                                            if($sistem_denda=="Harian"){
                                                $SatuanTerlambat="Hari";
                                            }else{
                                                $SatuanTerlambat="Bulan";
                                            }
                                            //Format Jumlah
                                            $jumlah_rp = "" . number_format($jumlah,0,',','.');
                                            $jasa_rp = "" . number_format($jasa,0,',','.');
                                            echo '<tr>';
                                            echo '  <td align="center"><code class="text-dark">'.$i.'</code></td>';
                                            echo '  <td align="left"><code class="text-dark">'.$GetPeriodePinjaman.'</code></td>';
                                            echo '  <td align="left">';
                                            echo '      <code class="text-dark">'.$tanggal_bayar.'</code><br>';
                                            if(!empty($keterlambatan)){
                                                echo '      <code class="text-danger">+ '.$keterlambatan.' '.$SatuanTerlambat.'</code>';
                                            }
                                            echo '  </td>';
                                            echo '  <td align="right"><code class="text-dark">'.$AngsuranPokokRp.'</code></td>';
                                            echo '  <td align="right"><code class="text-dark">'.$jasa_rp.'</code></td>';

                                            //Apabila Denda 0 Maka hilangkan kolom denda
                                            if(!empty($denda)){
                                                if(!empty($denda_angssuran)){
                                                    $denda_rp = "" . number_format($denda_angssuran,0,',','.');
                                                    echo '
                                                        <td align="right">
                                                            <code class="text-danger">+ '.$denda_rp.'</code>
                                                        </td>
                                                    ';
                                                }else{
                                                    echo '
                                                        <td align="right">
                                                            <code class="text-danger">0</code>
                                                        </td>
                                                    ';
                                                }
                                            }
                                            
                                            echo '  <td align="right"><code class="text-dark">'.$jumlah_rp.'</code></td>';
                                            echo '  <td align="right"><code class="text-dark">'.$SisaPinjamanRp.'</code></td>';
                                            echo '  <td align="center">';
                                            echo '      <a class="btn btn-sm btn-outline-dark btn-rounded" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">';
                                            echo '          <i class="bi bi-three-dots"></i> Opsi';
                                            echo '      </a>';
                                            echo '      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">';
                                            echo '          <li>';
                                            echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalCetakBuktiAngsuran" data-id="'.$id_pinjaman_angsuran.'">';
                                            echo '                  <i class="bi bi-file-pdf"></i> Cetak Bukti';
                                            echo '              </a>';
                                            echo '          </li>';
                                            echo '          <li>';
                                            echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailPinjamanAngsuran" data-id="'.$id_pinjaman_angsuran.'">';
                                            echo '                  <i class="bi bi-info-circle"></i> Detail';
                                            echo '              </a>';
                                            echo '          </li>';
                                            echo '          <li>';
                                            echo '              <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusPinjamanAngsuran" data-id="'.$id_pinjaman_angsuran.'">';
                                            echo '                  <i class="bi bi-x"></i> Hapus';
                                            echo '              </a>';
                                            echo '          </li>';
                                            echo '      </ul>';
                                            echo '  </td>';
                                            echo '</tr>';
                                            $RpSisaAngsuranTotal=$jumlah_pinjaman_rp;
                                            $TotalAngsuranPokok=$TotalAngsuranPokok+$pokok;
                                            $TotalJasa=$TotalJasa+$jasa;
                                            $TotalDenda=$TotalDenda+$denda_angssuran;
                                            $TotalAngsuranBruto=$TotalAngsuranBruto+$jumlah;
                                        }
                                    }
                                    //Menghitung Sisa Pokok
                                    $TotalSisaPokokSekarang=$jumlah_pinjaman-$TotalAngsuranPokok;
                                    //Format Rupiah
                                    $TotalAngsuranPokokRp = "" . number_format($TotalAngsuranPokok,0,',','.');
                                    $TotalJasaRp = "" . number_format($TotalJasa,0,',','.');
                                    $TotalAngsuranBrutoRp = "" . number_format($TotalAngsuranBruto,0,',','.');
                                    $TotalDendaRp = "" . number_format($TotalDenda,0,',','.');
                                    $TotalSisaPokokSekarangRp = "" . number_format($TotalSisaPokokSekarang,0,',','.');
                                    echo '<tr>';
                                    echo '  <td align="center" colspan="3"><code class="text-dark"><b>JUMLAH TOTAL</b></code></td>';
                                    echo '  <td align="right"><code class="text-dark"><b>'.$TotalAngsuranPokokRp.'</b></code></td>';
                                    echo '  <td align="right"><code class="text-dark"><b>'.$TotalJasaRp.'</b></code></td>';
                                    //Apabila Denda Bernilai 0 Maka tidak usah tampilkan total denda
                                    if(!empty($denda)){
                                        echo '  <td align="right"><code class="text-dark"><b>'.$TotalDendaRp.'</b></code></td>';
                                    }
                                    echo '  <td align="right"><code class="text-dark"><b>'.$TotalAngsuranBrutoRp.'</b></code></td>';
                                    echo '  <td align="right"><code class="text-dark"><b>'.$TotalSisaPokokSekarangRp.'</b></code></td>';
                                    echo '  <td align="right"></td>';
                                    echo '';
                                    echo '</tr>';
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-md-12 text-center">
                        <button type="button" class="btn btn-md btn-outline-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#ModalExportAngsuran" data-id="<?php echo $id_pinjaman; ?>">
                            <i class="bi bi-file-excel"></i> Export To Excel
                        </button>
                    </div>
                </div>
<?php
            }
        }
    }
?>