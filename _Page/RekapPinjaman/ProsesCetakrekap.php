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
        if(empty($_GET['tahun'])){
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-3 text-center">';
            echo '      <small class="text-danger">Periode Tahun Rekapitulasi Tidak Boleh Kosong</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $tahun=$_GET['tahun'];
            //Bersihkan Variabel 
            $tahun=validateAndSanitizeInput($tahun);
            $mpdf = new \Mpdf\Mpdf();
            $nama_dokumen= "Rekap-Pinjaman-$tahun";
            $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
            $mpdf->SetMargins(2, 2, 2, 2);
            $html='<style>@page *{margin-top: 0px;}</style>'; 
            //Beginning Buffer to save PHP variables and HTML tags
            ob_start();
?>
    <html>
        <head>
            <title>Rekap Pinjaman</title>
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
            <table class="data" width="100%">
                <tr>
                    <td colspan="5" align="center">
                        <b>REKAPITULASI PINJAMAN</b><br>
                        PERIODE THN 
                        <?php
                            echo "$tahun";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="center"><b>No</b></td>
                    <td align="center"><b>Periode</b></td>
                    <td align="center"><b>Anggota/Nasabah</b></td>
                    <td align="center"><b>Rp Pinjaman</b></td>
                    <td align="center"><b>Rp Angsuran Masuk</b></td>
                </tr>
                <?php
                    $JumlahTotalAnggota=0;
                    $JumlahTotalPinjaman=0;
                    $JumlahTotalAngsuran=0;
                    //Looping Bulan
                    $namaBulan = [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];
                    // Looping dari 1 hingga 12
                    for ($i = 1; $i <= 12; $i++) {
                        $angkaBulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                        $namaBulanIni = $namaBulan[$i - 1];
                        $keyword="$tahun-$angkaBulan";
                        //Menghitung Jumlah Anggota Yang Melakukan Pinjaman Secara Distinct Pada Periode Tersebut
                        $JumlahAnggota = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM pinjaman WHERE tanggal like '%$keyword%'"));
                        //Sum Jumlah Pinjaman Pada Periode Tersebut
                        $SumPinjaman = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah_pinjaman) AS jumlah FROM pinjaman WHERE tanggal like '%$keyword%'"));
                        $JumlahPinjaman = $SumPinjaman['jumlah'];
                        $JumlahPinjamanFormat = "Rp " . number_format($JumlahPinjaman,0,',','.');
                        //Menghitung Angsuran Masuk
                        $SumAngsuran = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM pinjaman_angsuran WHERE tanggal_bayar like '%$keyword%'"));
                        $JumlahAngsuran = $SumAngsuran['total'];
                        $JumlahAngsuranFormat = "Rp " . number_format($JumlahAngsuran,0,',','.');
                        //Akumulasi Jumlah Total
                        $JumlahTotalAnggota=$JumlahTotalAnggota+$JumlahAnggota;
                        $JumlahTotalPinjaman=$JumlahTotalPinjaman+$JumlahPinjaman;
                        $JumlahTotalAngsuran=$JumlahTotalAngsuran+$JumlahAngsuran;
                        echo '<tr>';
                        echo '  <td align="center">'.$i.'</td>';
                        echo '  <td align="left">'.$namaBulanIni.'</td>';
                        echo '  <td align="left">'.$JumlahAnggota.' Anggota</td>';
                        echo '  <td align="right">'.$JumlahPinjamanFormat.'</td>';
                        echo '  <td align="right">'.$JumlahAngsuranFormat.'</td>';
                        echo '</tr>';
                    }
                    echo '<tr>';
                    echo '  <td colspan="5"></td>';
                    echo '</tr>';
                    echo '<tr>';
                    //Forma RP
                    $JumlahTotalPinjaman = "Rp " . number_format($JumlahTotalPinjaman,0,',','.');
                    $JumlahTotalAngsuran = "Rp " . number_format($JumlahTotalAngsuran,0,',','.');
                    echo '  <td align="center" colspan="2"><b>JUMLAH</b></td>';
                    echo '  <td align="left"><b>'.$JumlahTotalAnggota.' Anggota</b></td>';
                    echo '  <td align="right"><b>'.$JumlahTotalPinjaman.'</b></td>';
                    echo '  <td align="right"><b>'.$JumlahTotalAngsuran.'</b></td>';
                    echo '</tr>';
                ?>
            </table><br>
            <table class="data" width="100%">
                <tr>
                    <td colspan="5" align="center">
                        <b>REKAPITULASI PINJAMAN BERDASARKAN LEMBAGA</b><br>
                        PERIODE THN 
                        <?php
                            echo "$tahun";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="center"><b>No</b></td>
                    <td align="center"><b>Divisi/Unit</b></td>
                    <td align="center"><b>Anggota/Nasabah</b></td>
                    <td align="center"><b>Rp Pinjaman</b></td>
                    <td align="center"><b>Rp Angsuran Masuk</b></td>
                </tr>
                <?php
                    $JumlahTotalAnggota=0;
                    $JumlahTotalPinjaman=0;
                    $JumlahTotalAngsuran=0;
                    //Looping Bulan
                    $namaBulan = [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];
                    //Looping Pinjaman Berdasarkan Lembaga
                    $no=1;
                    $query = mysqli_query($Conn, "SELECT DISTINCT lembaga FROM pinjaman ORDER BY lembaga ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $lembaga= $data['lembaga'];
                        //Menghitung Jumlah Anggota Yang Melakukan Pinjaman Secara Distinct Pada Periode Tersebut
                        $JumlahAnggota = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM pinjaman WHERE( lembaga='$lembaga') AND (tanggal like '%$tahun%')"));
                        //Sum Jumlah Pinjaman Pada Periode Tersebut
                        $SumPinjaman = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah_pinjaman) AS jumlah FROM pinjaman WHERE lembaga='$lembaga' AND tanggal like '%$tahun%'"));
                        $JumlahPinjaman = $SumPinjaman['jumlah'];
                        $JumlahPinjamanFormat = "Rp " . number_format($JumlahPinjaman,0,',','.');
                        //Menghitung Angsuran Masuk
                        $JumlahAngsuran=0;
                        $QryPinjaman = mysqli_query($Conn, "SELECT id_pinjaman FROM pinjaman WHERE lembaga='$lembaga' AND tanggal like '%$tahun%'");
                        while ($DataPinjaman = mysqli_fetch_array($QryPinjaman)) {
                            $id_pinjaman=$DataPinjaman['id_pinjaman'];
                            $SumAngsuran = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(jumlah) AS total FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman' AND tanggal_bayar like '%$tahun%'"));
                            $total = $SumAngsuran['total'];
                            $JumlahAngsuran=$JumlahAngsuran+$total;
                        }
                        $JumlahAngsuranFormat = "Rp " . number_format($JumlahAngsuran,0,',','.');
                        //Akumulasi Jumlah Total
                        $JumlahTotalAnggota=$JumlahTotalAnggota+$JumlahAnggota;
                        $JumlahTotalPinjaman=$JumlahTotalPinjaman+$JumlahPinjaman;
                        $JumlahTotalAngsuran=$JumlahTotalAngsuran+$JumlahAngsuran;
                        echo '<tr>';
                        echo '  <td align="center">'.$no.'</td>';
                        echo '  <td align="left">'.$lembaga.'</td>';
                        echo '  <td align="left">'.$JumlahAnggota.' Anggota</td>';
                        echo '  <td align="right">'.$JumlahPinjamanFormat.'</td>';
                        echo '  <td align="right">'.$JumlahAngsuranFormat.'</td>';
                        echo '</tr>';
                        $no++;
                    }
                    echo '<tr>';
                    echo '  <td colspan="5"></td>';
                    echo '</tr>';
                    echo '<tr>';
                    //Forma RP
                    $JumlahTotalPinjaman = "Rp " . number_format($JumlahTotalPinjaman,0,',','.');
                    $JumlahTotalAngsuran = "Rp " . number_format($JumlahTotalAngsuran,0,',','.');
                    echo '  <td align="center" colspan="2"><b>JUMLAH</b></td>';
                    echo '  <td align="left"><b>'.$JumlahTotalAnggota.' Anggota</b></td>';
                    echo '  <td align="right"><b>'.$JumlahTotalPinjaman.'</b></td>';
                    echo '  <td align="right"><b>'.$JumlahTotalAngsuran.'</b></td>';
                    echo '</tr>';
                ?>
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