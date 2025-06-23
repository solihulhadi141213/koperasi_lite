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
            $id_pinjaman=validateAndSanitizeInput($id_pinjaman);
            
            //Buka Detail Pinjaman
            $sql = "SELECT * FROM pinjaman WHERE id_pinjaman = ?";
            $stmt = $Conn->prepare($sql);
            $id = 1;
            $stmt->bind_param("i", $id_pinjaman);
            
            // Eksekusi statement
            $stmt->execute();
            
            // Ambil hasil query
            $result = $stmt->get_result();
            $DataPinjaman = $result->fetch_assoc();
            
            // Simpan hasil ke variabel
            $id_anggota = $DataPinjaman['id_setting_general'] ?? 0;
            $uuid_pinjaman = $DataPinjaman['uuid_pinjaman'] ?? null;
            $nip = $DataPinjaman['nip'] ?? null;
            $nama = $DataPinjaman['nama'] ?? null;
            $lembaga = $DataPinjaman['lembaga'] ?? null;
            $ranking = $DataPinjaman['ranking'] ?? 0;
            $tanggal = $DataPinjaman['tanggal'] ?? null;
            $jatuh_tempo = $DataPinjaman['jatuh_tempo'] ?? null;
            $denda = $DataPinjaman['denda'] ?? 0;
            $sistem_denda = $DataPinjaman['sistem_denda'] ?? null;
            $jumlah_pinjaman = $DataPinjaman['jumlah_pinjaman'] ?? 0;
            $persen_jasa = $DataPinjaman['persen_jasa'] ?? 0;
            $persen_jasa = $DataPinjaman['persen_jasa'] ?? 0;
            $rp_jasa = $DataPinjaman['rp_jasa'] ?? 0;
            $angsuran_pokok = $DataPinjaman['angsuran_pokok'] ?? 0;
            $angsuran_total = $DataPinjaman['angsuran_total'] ?? 0;
            $periode_angsuran = $DataPinjaman['periode_angsuran'] ?? 0;
            $status = $DataPinjaman['status'] ?? null;

            // Tutup statement
            $stmt->close();

            //Format tanggal
            $strtotime=strtotime($tanggal);
            $TanggalFormat=date('d/m/Y',$strtotime);
            //Format Rupiah
            $denda_format = "Rp " . number_format($denda,0,',','.');
            $jumlah_pinjaman_format = "Rp " . number_format($jumlah_pinjaman,0,',','.');
            $rp_jasa_format = "Rp " . number_format($rp_jasa,0,',','.');
            $angsuran_pokok_format = "Rp " . number_format($angsuran_pokok,0,',','.');
            $angsuran_total_format = "Rp " . number_format($angsuran_total,0,',','.');
            //Cek Apakah Sudah Sinkron Dengan Jurnal
            $JumlahJurnal = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE kategori='Pinjaman' AND uuid='$uuid_pinjaman'"));
            if(empty($JumlahJurnal)){
                $LabelJurnal='<code class="text text-danger">Jurnal : 0 Rcd</code>';
            }else{
                $LabelJurnal='<code class="text text-grayish">Jurnal : '.$JumlahJurnal.' Rcd</code>';
            }
            if($status=="Berjalan"){
                $LabelStatus='<span class="badge badge-info">Berjalan</span>';
            }else{
                if($status=="Lunas"){
                    $LabelStatus='<span class="badge badge-success">Lunas</span>';
                }else{
                    if($status=="Macet"){
                        $LabelStatus='<span class="badge badge-danger">Macet</span>';
                    }else{
                        $LabelStatus='<span class="badge badge-dark">None</span>';
                    }
                }
            }
?>
            <div class="row mb-3">
                <div class="col col-md-4">Tanggal Pinjaman</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $TanggalFormat; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">NIP</div>
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
                <div class="col col-md-4">Jatuh Tempo</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo "Tanggal $jatuh_tempo"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Denda</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo "$denda_format ($sistem_denda)"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Jumlah Pinjaman</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo $jumlah_pinjaman_format; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Periode Angsuran</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo "$periode_angsuran Kali"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">% Jasa</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo "$persen_jasa %"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Rp Jasa</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo "$rp_jasa_format"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Angsuran Pokok</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo "$angsuran_pokok_format"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Angsuran + Jasa</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo "$angsuran_total_format"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-4">Status</div>
                <div class="col col-md-8">
                    <code class="text text-grayish"><?php echo "$LabelStatus"; ?></code>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center" colspan="5"><b>DATA TUNGGAKAN ANGSURAN</b></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><b>No</b></td>
                                    <td class="text-center"><b>Tempo</b></td>
                                    <td class="text-center"><b>Pokok</b></td>
                                    <td class="text-center"><b>Jasa</b></td>
                                    <td class="text-center"><b>Jumlah</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //Tanggal Sekarang
                                    $TanggalSekarang=date('Y-m-d');
                                    //Simulasi Pinjaman
                                    $JumlahPokok=0;
                                    $JumlahJasa=0;
                                    $JumlahTunggakan=0;
                                    $JumlahPeriodeTagihan=0;
                                    $no=1;
                                    for ( $i=1; $i<=$periode_angsuran; $i++ ){
                                        $GetPeriodePinjaman=date('d/m/Y', strtotime('+'.$i.' month', strtotime($tanggal))); 
                                        //Ubah Format Tangga
                                        $GetPeriodePinjaman2=date('Y-m-d', strtotime('+'.$i.' month', strtotime($tanggal))); 
                                        if($TanggalSekarang>$GetPeriodePinjaman2){
                                            //Cek Apakah Sudah Ada Angsuran
                                            $QryAngsuran = mysqli_query($Conn,"SELECT * FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND tanggal_angsuran='$GetPeriodePinjaman2'")or die(mysqli_error($Conn));
                                            $DataAngsuran = mysqli_fetch_array($QryAngsuran);
                                            if(empty($DataAngsuran['id_pinjaman_angsuran'])){
                                                $JumlahPokok=$JumlahPokok+$angsuran_pokok;
                                                $JumlahJasa=$JumlahJasa+$rp_jasa;
                                                $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+1;
                                                $JumlahTunggakan=$JumlahTunggakan+$angsuran_total;
                                                echo '<tr>';
                                                echo '  <td align="center"><code class="text text-dark">'.$no.'</code></td>';
                                                echo '  <td align="left"><code class="text text-dark">'.$GetPeriodePinjaman.'</code></td>';
                                                echo '  <td align="right"><code class="text text-dark">'.$angsuran_pokok_format.'</code></td>';
                                                echo '  <td align="right"><code class="text text-dark">'.$rp_jasa_format.'</code></td>';
                                                echo '  <td align="right"><code class="text text-dark">'.$angsuran_total_format.'</code></td>';
                                                echo '</tr>';
                                                $no++;
                                            }else{
                                                $JumlahPokok=$JumlahPokok+0;
                                                $JumlahJasa=$JumlahJasa+0;
                                                $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+0;
                                                $JumlahTunggakan=$JumlahTunggakan+0;
                                            }
                                        }else{
                                            $JumlahPokok=$JumlahPokok+0;
                                            $JumlahJasa=$JumlahJasa+0;
                                            $JumlahPeriodeTagihan=$JumlahPeriodeTagihan+0;
                                            $JumlahTunggakan=$JumlahTunggakan+0;
                                        }
                                    }
                                    $JumlahTunggakanFormat = "Rp " . number_format($JumlahTunggakan,0,',','.');
                                    $JumlahPokokFormat = "Rp " . number_format($JumlahPokok,0,',','.');
                                    $JumlahJasaFormat = "Rp " . number_format($JumlahJasa,0,',','.');
                                    echo '<tr>';
                                    echo '  <td align="left" colspan="5"><b></b></td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '  <td align="left" colspan="2"><b>JUMLAH</b></td>';
                                    echo '  <td align="right"><b>'.$JumlahPokokFormat.'</b></td>';
                                    echo '  <td align="right"><b>'.$JumlahJasaFormat.'</b></td>';
                                    echo '  <td align="right"><b>'.$JumlahTunggakanFormat.'</b></td>';
                                    echo '</tr>';
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-md-12 mb-3 text-center">
                    <a href="_Page/Tagihan/ProsesCetakTagihan.php?id=<?php echo $id_pinjaman; ?>" target="_blank" class="btn btn-md btn-primary btn-rounded">
                        <i class="bi bi-printer"></i> Cetak
                    </a>
                </div>
            </div>
<?php
        }
    }
?>