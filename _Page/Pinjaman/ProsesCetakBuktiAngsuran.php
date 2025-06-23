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
        if(empty($_POST['id_pinjaman_angsuran'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Tidak ada data yang ditangkap oleh sistem</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            if(empty($_POST['format'])){
                echo '<div class="row">';
                echo '  <div class="col-md-12 mb-3 text-center">';
                echo '      <small class="text-danger">Format Cetak Tidak Boleh Kosong!</small>';
                echo '  </div>';
                echo '</div>';
            }else{
                $id_pinjaman_angsuran=$_POST['id_pinjaman_angsuran'];
                $format=$_POST['format'];
                //Bersihkan Variabel 
                $id_pinjaman_angsuran=validateAndSanitizeInput($id_pinjaman_angsuran);
                $format=validateAndSanitizeInput($format);
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
                $nip=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'nip');
                $nama=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'nama');
                $lembaga=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'lembaga');
                $ranking=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'ranking');
                if($format=="PDF"){
                    $mpdf = new \Mpdf\Mpdf();
                    $nama_dokumen= "Bukti-Angsuran-$id_pinjaman_angsuran";
                    $mpdf = new \Mpdf\Mpdf(['format' => [80, 200]]);
                    $mpdf->SetMargins(2, 2, 2, 2);
                    $html='<style>@page *{margin-top: 0px;}</style>'; 
                    //Beginning Buffer to save PHP variables and HTML tags
                    ob_start();
                }
?>
    <html>
        <head>
            <title>Bukti Pembayaran Angsuran</title>
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
                        <b>BUKTI PEMBAYARAN ANGSURAN</b><BR>
                        <small>
                            Nomor.<?php echo "$id_pinjaman/$id_pinjaman_angsuran/$id_anggota/$tanggal_angsuran_format"; ?>
                        </small>
                    </td>
                </tr>
            </table>
            <br>
            <table class="TableForm">
                <tr>
                    <td><small><b>Periode Angsuran</b></small></td>
                    <td><small><b>:</b></small></td>
                    <td><small><?php echo "$tanggal_angsuran_format"; ?></small></td>
                </tr>
                <tr>
                    <td><small><b>Tanggal Pembayaran</b></small></td>
                    <td><small><b>:</b></small></td>
                    <td><small><?php echo "$tanggal_bayar_format"; ?></small></td>
                </tr>
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
                    <td><small><b>Angsuran Pokok</b></small></td>
                    <td><small><b>:</b></small></td>
                    <td><small><?php echo "$pokok_rp"; ?></small></td>
                </tr>
                <tr>
                    <td><small><b>Jasa</b></small></td>
                    <td><small><b>:</b></small></td>
                    <td><small><?php echo "$jasa_rp"; ?></small></td>
                </tr>
                <tr>
                    <td><small><b>Denda</b></small></td>
                    <td><small><b>:</b></small></td>
                    <td><small><?php echo "$denda_rp"; ?></small></td>
                </tr>
                <tr>
                    <td><small><b>Jumlah Angsuran</b></small></td>
                    <td><small><b>:</b></small></td>
                    <td><small><?php echo "$jumlah_rp"; ?></small></td>
                </tr>
            </table>
        </body>
    </html>
<?php
                if($format=="PDF"){
                    $html = ob_get_contents();
                    ob_end_clean();
                    $mpdf->WriteHTML(utf8_encode($html));
                    $mpdf->Output($nama_dokumen.".pdf" ,'I');
                    exit;
                }
            }
        }
    }
?>