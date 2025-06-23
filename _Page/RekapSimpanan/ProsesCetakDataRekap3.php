<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    include '../../vendor/autoload.php';
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Cek Akses
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-12 text-center">';
        echo '      <code>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['periode'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col col-md-12 text-center">';
            echo '      <code>Mode Periode Data Tidak Boleh Kosong!</code>';
            echo '  </div>';
            echo '</div>';
        }else{
            $periode=$_POST['periode'];
            //Bersihkan Variabel
            $periode = validateAndSanitizeInput($periode);
            //Validasi Kelengkapan Data
            if($periode=="Semua"){
                $VariabelKelengkapanData="Valid";
                $keyword="";
            }else{
                if($periode=="Tahunan"){
                    if(empty($_POST['tahun'])){
                        $VariabelKelengkapanData="Parameter Tahun Tidak Boleh Kosong";
                    }else{
                        $VariabelKelengkapanData="Valid";
                        $tahun=$_POST['tahun'];
                        $tahun = validateAndSanitizeInput($tahun);
                        $keyword="$tahun";
                    }
                }else{
                    if($periode=="Bulanan"){
                        if(empty($_POST['tahun'])){
                            $VariabelKelengkapanData="Parameter Tahun Tidak Boleh Kosong";
                        }else{
                            if(empty($_POST['bulan'])){
                                $VariabelKelengkapanData="Parameter Bulan Tidak Boleh Kosong";
                            }else{
                                $VariabelKelengkapanData="Valid";
                                $tahun=$_POST['tahun'];
                                $bulan=$_POST['bulan'];
                                $bulan = validateAndSanitizeInput($bulan);
                                $tahun = validateAndSanitizeInput($tahun);
                                $keyword="$tahun-$bulan";
                            }
                        }
                    }else{
                        $VariabelKelengkapanData="Periode Data Tidak Valid";
                    }
                }
            }
            if($VariabelKelengkapanData!=="Valid"){
                echo '<div class="row mb-3">';
                echo '  <div class="col col-md-12 text-center">';
                echo '      <code>'.$VariabelKelengkapanData.'</code>';
                echo '  </div>';
                echo '</div>';
            }else{
                //Jumlah Jenis Simpanan
                $JumlahSimpanan = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan_jenis"));
                $mpdf = new \Mpdf\Mpdf();
                $nama_dokumen= "Rekap-Simpanan";
                $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']);
                $mpdf->SetMargins(3, 3, 3, 3);
                $html='<style>@page *{margin-top: 0px;}</style>'; 
                //Beginning Buffer to save PHP variables and HTML tags
                ob_start();
?>
                <html>
                    <head>
                        <title>Rekap Simpanan</title>
                        <style type="text/css">
                            @page {
                                margin-top: 2cm;
                                margin-bottom: 2cm;
                                margin-left: 2cm;
                                margin-right: 2cm;
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
                                    REKAP DATA SIMPANAN  <span style="text-transform: uppercase;"><?php echo $periode; ?></span><br>
                                    <?php
                                        if($periode=="Bulanan"){
                                            $nama_bulan=getNamaBulan($bulan);
                                            echo '<span style="text-transform: uppercase;">PERIODE '.$nama_bulan.' '.$tahun.'</span>';
                                        }else{
                                            if($periode=="Tahunan"){
                                                echo '<span style="text-transform: uppercase;">PERIODE '.$tahun.'</span>';
                                            }
                                        }
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <table class="data" width="100%">
                            <tr>
                                <td align="center" rowspan="2" valign="middle"><b>No</b></td>
                                <td align="center" rowspan="2" valign="middle"><b>Anggota</b></td>
                                <td align="center" colspan="<?php echo $JumlahSimpanan; ?>"><b>Simpanan</b></td>
                                <td align="center" rowspan="2" valign="middle"><b>Jumlah</b></td>
                                <td align="center" rowspan="2" valign="middle"><b>Penarikan</b></td>
                                <td align="center" rowspan="2" valign="middle"><b>saldo</b></td>
                            </tr>
                            <tr>
                                <?php
                                    // Ambil semua jenis simpanan
                                    $queryJenisSimpanan = mysqli_query($Conn, "SELECT * FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");
                                    $JumlahSimpanan = mysqli_num_rows($queryJenisSimpanan);
                                    while ($dataJenis = mysqli_fetch_assoc($queryJenisSimpanan)) {
                                        echo '<td align="center"><small class="credit">' . $dataJenis['nama_simpanan'] . '</small></td>';
                                    }
                                ?>
                            </tr>
                            <?php
                                // Ambil semua data simpanan dalam satu query
                                if(empty($keyword)){
                                    $querySimpanan = mysqli_query($Conn, "
                                    SELECT 
                                        s.id_anggota,
                                        a.nama AS nama_anggota,
                                        s.kategori,
                                        s.jumlah,
                                        s.tanggal
                                    FROM simpanan s
                                    JOIN anggota a ON s.id_anggota = a.id_anggota
                                    ORDER BY a.nama ASC
                                ");
                                }else{
                                    $querySimpanan = mysqli_query($Conn, "
                                    SELECT 
                                        s.id_anggota,
                                        a.nama AS nama_anggota,
                                        s.kategori,
                                        s.jumlah,
                                        s.tanggal
                                    FROM simpanan s
                                    JOIN anggota a ON s.id_anggota = a.id_anggota
                                    WHERE s.tanggal LIKE '%$keyword%'
                                    ORDER BY a.nama ASC
                                ");
                                }

                                // Proses data simpanan ke dalam array
                                $dataSimpanan = [];
                                while ($row = mysqli_fetch_assoc($querySimpanan)) {
                                    $dataSimpanan[$row['id_anggota']]['nama'] = $row['nama_anggota'];
                                    $dataSimpanan[$row['id_anggota']]['kategori'][$row['kategori']][] = $row['jumlah'];
                                }
                                if (empty($dataSimpanan)) {
                                    echo '<tr>';
                                    echo '  <td colspan="' . ($JumlahSimpanan + 5) . '" class="text-center">';
                                    echo '      <code class="text-danger">';
                                    echo '          Tidak Ada Data Simpanan Yang Dapat Ditampilkan';
                                    echo '      </code>';
                                    echo '  </td>';
                                    echo '</tr>';
                                } else {
                                    $no = 1;
                                    $JumlahTotalSimpanan=0;
                                    $JumlahTotalPenarikan=0;
                                    $JumlahTotalSaldo=0;
                                    foreach ($dataSimpanan as $id_anggota => $anggota) {
                                        $nama_anggota = $anggota['nama'];
                                        $simpanan = $anggota['kategori'];

                                        // Hitung jumlah simpanan, penarikan, dan saldo
                                        $jumlah_simpanan = isset($simpanan['Simpanan']) ? array_sum($simpanan['Simpanan']) : 0;
                                        $jumlah_penarikan = isset($simpanan['Penarikan']) ? array_sum($simpanan['Penarikan']) : 0;

                                        $JumlahPenarikanFormat = number_format($jumlah_penarikan, 0, ',', '.');
                            ?>
                                        <tr>
                                            <td align="center"><small class="credit"><?php echo $no; ?></small></td>
                                            <td align="left">
                                                <small class="credit">
                                                    <code class="text-dark">
                                                        <?php echo $nama_anggota; ?>
                                                    </code>
                                                </small>
                                            </td>
                                            <?php
                                                $JumlahSimpanan=0;
                                                mysqli_data_seek($queryJenisSimpanan, 0); // Reset pointer query jenis simpanan
                                                while ($dataJenis = mysqli_fetch_assoc($queryJenisSimpanan)) {
                                                    $nama_simpanan = $dataJenis['nama_simpanan'];
                                                    $jumlah_simpanan_jenis = isset($simpanan[$nama_simpanan]) ? array_sum($simpanan[$nama_simpanan]) : 0;
                                                    $jumlah_simpanan_jenis_format = number_format($jumlah_simpanan_jenis, 0, ',', '.');
                                                    
                                                    //Menghitung jumlah simpanan
                                                    $JumlahSimpanan = $JumlahSimpanan+$jumlah_simpanan_jenis;
                                                    $JumlahSimpananFormat = number_format($JumlahSimpanan, 0, ',', '.');
                                                    
                                                    echo '<td align="right"><small class="credit"><code class="text-dark">' . $jumlah_simpanan_jenis_format . '</code></small></td>';
                                                }
                                            ?>
                                            <td align="right">
                                                <small class="credit">
                                                    <code class="text-dark">
                                                        <?php 
                                                            echo $JumlahSimpananFormat; 
                                                            $JumlahTotalSimpanan=$JumlahTotalSimpanan+$jumlah_simpanan;
                                                        ?>
                                                    </code>
                                                </small>
                                            </td>
                                            <td align="right">
                                                <small class="credit">
                                                    <code class="text-dark">
                                                        <?php 
                                                            echo $JumlahPenarikanFormat; 
                                                            //Hitung Jumlah Total Penarikan
                                                            $JumlahTotalPenarikan=$JumlahTotalPenarikan+$jumlah_penarikan;
                                                        ?>
                                                    </code>
                                                </small>
                                            </td>
                                            <td align="right">
                                                <small class="credit">
                                                    <code class="text-dark">
                                                        <?php 
                                                            $saldo = $JumlahSimpanan - $jumlah_penarikan;
                                                            $SaldoFormat = number_format($saldo, 0, ',', '.');
                                                            echo $SaldoFormat; 

                                                            $JumlahTotalSaldo=$JumlahTotalSaldo+$saldo;
                                                        ?>
                                                    </code>
                                                </small>
                                            </td>
                                        </tr>
                            <?php
                                        $no++; 
                                    }
                                }
                            ?>
                            <tr>
                                <td colspan="2"><b>JUMLAH</b></td>
                                <?php
                                    $JumlahTotalSimpanan=0;
                                    mysqli_data_seek($queryJenisSimpanan, 0); // Reset pointer query jenis simpanan
                                    while ($dataJenis = mysqli_fetch_assoc($queryJenisSimpanan)) {
                                        $nama_simpanan = $dataJenis['nama_simpanan'];
                                        $total_simpanan_jenis = 0;
                                        foreach ($dataSimpanan as $anggota) {
                                            if (isset($anggota['kategori'][$nama_simpanan])) {
                                                $total_simpanan_jenis += array_sum($anggota['kategori'][$nama_simpanan]);
                                            }
                                        }
                                        $total_simpanan_jenis_format = number_format($total_simpanan_jenis, 0, ',', '.');
                                        echo '<td align="right"><b>' . $total_simpanan_jenis_format . '</b></td>';

                                        $JumlahTotalSimpanan=$JumlahTotalSimpanan+$total_simpanan_jenis;
                                    }
                                ?>
                                <td align="right"><b><?php echo number_format($JumlahTotalSimpanan, 0, ',', '.'); ?></b></td>
                                <td align="right"><b><?php echo number_format($JumlahTotalPenarikan, 0, ',', '.'); ?></b></td>
                                <td align="right"><b><?php echo number_format($JumlahTotalSaldo, 0, ',', '.'); ?></b></td>
                            </tr>
                        </table>
                        <br>
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
    }
?>