<?php
    // Koneksi dan Konfigurasi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    include '../../vendor/autoload.php';

    // Cek Akses
    if (empty($SessionIdAkses)) {
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-12 text-center">';
        echo '      <code>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
        exit;
    }

    // Validasi Periode
    if (empty($_POST['periode'])) {
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-12 text-center">';
        echo '      <code>Mode Periode Data Tidak Boleh Kosong!</code>';
        echo '  </div>';
        echo '</div>';
        exit;
    }

    $periode = validateAndSanitizeInput($_POST['periode']);
    $keyword = "";

    if ($periode === "Tahunan" && !empty($_POST['tahun'])) {
        $tahun = validateAndSanitizeInput($_POST['tahun']);
        $keyword = "$tahun";
    } elseif ($periode === "Bulanan" && !empty($_POST['tahun']) && !empty($_POST['bulan'])) {
        $tahun = validateAndSanitizeInput($_POST['tahun']);
        $bulan = validateAndSanitizeInput($_POST['bulan']);
        $keyword = "$tahun-$bulan";
    } elseif ($periode !== "Semua") {
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-12 text-center">';
        echo '      <code>Parameter Periode Tidak Lengkap atau Tidak Valid!</code>';
        echo '  </div>';
        echo '</div>';
        exit;
    }

    // Inisialisasi PDF
    $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
    $mpdf->SetMargins(3, 3, 3, 3);
    $nama_dokumen = "Rekap-Simpanan";

    ob_start();
?>
    <html>
        <head>
            <title>Rekap Simpanan</title>
            <style>
                @page { margin: 2cm; }
                body { font-family: arial; }
                table { border-collapse: collapse; margin-top: 10px; }
                table.data tr td { border: 1px solid #666; padding: 6px; font-size: 10pt; }
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
                    <td align="center"><b>No</b></td>
                    <td align="center"><b>Anggota</b></td>
                    <?php
                    // Fetch semua jenis simpanan
                    $jenisSimpanan = [];
                    $queryJenis = mysqli_query($Conn, "SELECT * FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");
                    while ($jenis = mysqli_fetch_assoc($queryJenis)) {
                        $jenisSimpanan[] = $jenis;
                        echo '<td align="center"><b>' . htmlspecialchars($jenis['nama_simpanan']) . '</b></td>';
                    }
                    ?>
                    <td align="center"><b>Saldo Netto</b></td>
                </tr>
                <?php
                    // Ambil Data Jenis Simpanan Sekali Saja
                    $queryJenisSimpanan = mysqli_query($Conn, "SELECT * FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");
                    $JenisSimpanan = mysqli_fetch_all($queryJenisSimpanan, MYSQLI_ASSOC);
                    $JumlahSimpanan = count($JenisSimpanan);
                    $jumlah_colpsn = $JumlahSimpanan + 3;

                    $queryAnggota = mysqli_query($Conn, "SELECT id_anggota, nama FROM anggota ORDER BY nama ASC");
                    if (!mysqli_num_rows($queryAnggota)) {
                        echo '<tr><td class="text-center" colspan="'.$jumlah_colpsn.'"><small class="text-danger">Tidak Ada Data Anggota Yang Ditampilkan</small></td></tr>';
                        exit;
                    }

                    $totalSaldo = array_fill_keys(array_column($JenisSimpanan, 'id_simpanan_jenis'), 0);
                    $grandTotalSaldo = 0;

                    $no = 1;
                    while ($DataAnggota = mysqli_fetch_assoc($queryAnggota)) {
                        $id_anggota = $DataAnggota['id_anggota'];
                        $nama_anggota = $DataAnggota['nama'];
                        $saldo = 0;

                        echo '<tr>';
                        echo '  <td align="center"><small>'.$no.'</small></td>';
                        echo '  <td><small>'.$nama_anggota.'</small></td>';

                        foreach ($JenisSimpanan as $DataSimpanan) {
                            $id_simpanan_jenis = $DataSimpanan['id_simpanan_jenis'];
                            $filter = $keyword ? "AND tanggal LIKE '%$keyword%'" : "";
                            
                            $query = "SELECT
                                        SUM(CASE WHEN kategori != 'Penarikan' THEN jumlah ELSE 0 END) -
                                        SUM(CASE WHEN kategori = 'Penarikan' THEN jumlah ELSE 0 END) AS netto
                                    FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$id_anggota' $filter";
                            
                            $result = mysqli_fetch_assoc(mysqli_query($Conn, $query));
                            $simpanan_netto = $result['netto'] ?? 0;
                            $totalSaldo[$id_simpanan_jenis] += $simpanan_netto;
                            $saldo += $simpanan_netto;

                            echo '  <td align="right"><small>'.number_format($simpanan_netto, 0, ',', '.').'</small></td>';
                        }

                        $grandTotalSaldo += $saldo;
                        echo '  <td align="right"><small>'.number_format($saldo, 0, ',', '.').'</small></td>';
                        echo '</tr>';
                        $no++;
                    }

                    echo '<tr>';
                    echo '  <td></td>';
                    echo '  <td><small><b>JUMLAH TOTAL</b></small></td>';
                    foreach ($totalSaldo as $total) {
                        echo '  <td align="right"><small><b>'.number_format($total, 0, ',', '.').'</b></small></td>';
                    }
                    echo '  <td align="right"><small><b>'.number_format($grandTotalSaldo, 0, ',', '.').'</b></small></td>';
                    echo '</tr>';
                ?>
            </table>
        </body>
    </html>
<?php
    $html = ob_get_clean();
    $mpdf->WriteHTML($html);
    $mpdf->Output($nama_dokumen . ".pdf", 'I');
    exit;
?>
