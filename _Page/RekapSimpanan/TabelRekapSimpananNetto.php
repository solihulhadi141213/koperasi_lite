<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Inisiasi data
    $JmlHalaman = 1;
    
    // Ambil Data Jenis Simpanan Sekali Saja
    $queryJenisSimpanan = mysqli_query($Conn, "SELECT * FROM simpanan_jenis ORDER BY id_simpanan_jenis ASC");
    $JenisSimpanan = mysqli_fetch_all($queryJenisSimpanan, MYSQLI_ASSOC);
    $JumlahSimpanan = count($JenisSimpanan);
    $jumlah_colpsn = $JumlahSimpanan + 3;

    // Cek Akses
    if (empty($SessionIdAkses)) {
        echo '<tr><td class="text-center" colspan="'.$jumlah_colpsn.'"><small class="text-danger">Sesi akses sudah berakhir! Silahkan Login Ulang!</small></td></tr>';
        exit;
    }

    // Validasi Periode
    $periode = $_POST['periode'] ?? '';
    $tahun = $_POST['tahun'] ?? '';
    $bulan = $_POST['bulan'] ?? '';

    $periode = validateAndSanitizeInput($periode);
    $tahun = validateAndSanitizeInput($tahun);
    $bulan = validateAndSanitizeInput($bulan);

    if (empty($periode)) {
        echo '<tr><td class="text-center" colspan="'.$jumlah_colpsn.'"><small class="text-danger">Mode Periode Data Tidak Boleh Kosong!</small></td></tr>';
        exit;
    }

    if ($periode === "Tahunan" && empty($tahun)) {
        echo '<tr><td class="text-center" colspan="'.$jumlah_colpsn.'"><small class="text-danger">Parameter Tahun Tidak Boleh Kosong</small></td></tr>';
        exit;
    }

    if ($periode === "Bulanan" && (empty($tahun) || empty($bulan))) {
        echo '<tr><td class="text-center" colspan="'.$jumlah_colpsn.'"><small class="text-danger">Parameter Tahun dan Bulan Tidak Boleh Kosong</small></td></tr>';
        exit;
    }

    $keyword = $periode === "Semua" ? "" : ($periode === "Tahunan" ? "$tahun" : "$tahun-$bulan");

    // Pagination
    $batas = 10;
    $page = $_POST['page'] ?? 1;
    $posisi = ($page - 1) * $batas;

    $jumlah_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota"));
    $JmlHalaman = ceil($jumlah_data / $batas);

    $queryAnggota = mysqli_query($Conn, "SELECT id_anggota, nama FROM anggota ORDER BY nama ASC LIMIT $posisi, $batas");
    if (!mysqli_num_rows($queryAnggota)) {
        echo '<tr><td class="text-center" colspan="'.$jumlah_colpsn.'"><small class="text-danger">Tidak Ada Data Anggota Yang Ditampilkan</small></td></tr>';
        exit;
    }

    $totalSaldo = array_fill_keys(array_column($JenisSimpanan, 'id_simpanan_jenis'), 0);
    $grandTotalSaldo = 0;

    $no = $posisi + 1;
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
    if($JmlHalaman==$page){
        echo '<tr>';
        echo '  <td></td>';
        echo '  <td><small><b>JUMLAH TOTAL</b></small></td>';
        foreach ($totalSaldo as $total) {
            echo '  <td align="right"><small><b>'.number_format($total, 0, ',', '.').'</b></small></td>';
        }
        echo '  <td align="right"><small><b>'.number_format($grandTotalSaldo, 0, ',', '.').'</b></small></td>';
        echo '</tr>';
    }
?>

<script>
    var page_count = <?php echo $JmlHalaman; ?>;
    var curent_page = <?php echo $page; ?>;

    $('#page_info_simpanan_netto').html('Page ' + curent_page + ' Of ' + page_count);
    $('#prev_button_simpanan_netto').prop('disabled', curent_page == 1);
    $('#next_button_simpanan_netto').prop('disabled', page_count <= curent_page);
</script>