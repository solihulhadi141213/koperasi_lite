<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    include '../../vendor/autoload.php';
    if(empty($SessionIdAkses)){
        echo '<div class="row">';
        echo '  <div class="col-md-12 mb-3 text-center">';
        echo '      <small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_GET['id'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_pinjaman=$_GET['id'];
            //Bersihkan Variabel
            $id_pinjaman=validateAndSanitizeInput($id_pinjaman);
            //Buka Detail Pinjaman
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
            //Cetak PDF
            $mpdf = new \Mpdf\Mpdf();
            $nama_dokumen= "Lembar-Tagihan-$id_pinjaman";
            $mpdf = new \Mpdf\Mpdf(['format' => 'A5']);
            $mpdf->SetMargins(2, 2, 2, 2);
            $html='<style>@page *{margin-top: 0px;}</style>'; 
            ob_start();
?>
    <html>
        <head>
            <title>Lembar Tagihan Angsuran</title>
            <style type="text/css">
                @page {
                    margin-top: 0.3cm;
                    margin-bottom: 0.3cm;
                    margin-left: 0.3cm;
                    margin-right: 0.3cm;
                }
                body {
                    background-color: #FFF;
                    font-family: arial;
                }
                table{
                    border-collapse: collapse;
                    margin-top:10px;
                }
                table.kostum tr td {
                    border:none;
                    color:#333;
                    border-spacing: 0px;
                    padding: 2px;
                    border-collapse: collapse;
                    font-size:12px;
                }
                table.data tr td {
                    border: 1px solid #666;
                    color:#333;
                    border-spacing: 0px;
                    padding: 6px;
                    border-collapse: collapse;
                    font-size:10pt;
                }
                .tabel_garis_bawah {
                    border-bottom: 1px solid #666;
                }
                table.TableForm tr td{
                    padding: 3px;
                }
            </style>
        </head>
        <body>
            <table class="kostum">
                <tr>
                    <td align="left">
                        <img src="<?php echo "$base_url/assets/img/$logo"; ?>" width="40px">
                    </td>
                    <td align="left">
                        <?php 
                            echo "<b>$title_page</b><br>"; 
                            echo "<small>$alamat_bisnis</small><br>";
                            echo "<small>Telepon ($telepon_bisnis)</small><br>";
                        ?>
                    </td>
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td align="left">
                        <b>LEMBAR TAGIHAN ANGSURAN</b><BR>
                        <small>
                            Nomor.<?php echo "$id_pinjaman/$id_anggota/$TanggalFormat"; ?>
                        </small>
                    </td>
                </tr>
            </table>
            <br>
            <table class="TableForm">
                <tr>
                    <td><small><b>NIP</b></small></td>
                    <td><small><b>:</b></small></td>
                    <td><small><?php echo "$nip"; ?></small></td>
                </tr>
                <tr>
                    <td><small><b>Nama</b></small></td>
                    <td><small><b>:</b></small></td>
                    <td><small><?php echo "$nama"; ?></small></td>
                </tr>
                <tr>
                    <td><small><b>Divisi/Unit</b></small></td>
                    <td><small><b>:</b></small></td>
                    <td><small><?php echo "$lembaga"; ?></small></td>
                </tr>
                <tr>
                    <td><small><b>Ranking</b></small></td>
                    <td><small><b>:</b></small></td>
                    <td><small><?php echo "$ranking"; ?></small></td>
                </tr>
            </table>
            <br>
            <table class="data" width="100%">
                <tr>
                    <td align="center" colspan="5"><b>RINCIAN TUNGGAKAN ANGSURAN</b></td>
                </tr>
                <tr>
                    <td align="center"><b>No</b></td>
                    <td align="center"><b>Tempo</b></td>
                    <td align="center"><b>Pokok</b></td>
                    <td align="center"><b>Jasa</b></td>
                    <td align="center"><b>Jumlah</b></td>
                </tr>
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
        </body>
    </html>
<?php
            $html = ob_get_contents();
            ob_end_clean();
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output($nama_dokumen.".pdf" ,'I');
            exit;
        }
    }
?>