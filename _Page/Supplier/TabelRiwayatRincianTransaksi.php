<?php
    // Koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '<tr><td colspan="10" class="text-center text-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang</td></tr>';
        exit;
    }

    $id_supplier = $_POST['id_supplier'] ?? '';
    $keyword_by  = $_POST['keyword_by'] ?? '';
    $keyword     = $_POST['keyword'] ?? '';
    $batas       = $_POST['batas'] ?? 10;
    $ShortBy     = $_POST['ShortBy'] ?? 'DESC';
    $OrderBy     = $_POST['OrderBy'] ?? 'tanggal';
    $page        = $_POST['page'] ?? 1;
    $posisi      = ($page - 1) * $batas;

    // Validasi input
    $id_supplier = mysqli_real_escape_string($Conn, $id_supplier);
    $keyword_by  = mysqli_real_escape_string($Conn, $keyword_by);
    $keyword     = mysqli_real_escape_string($Conn, $keyword);
    $OrderBy     = in_array($OrderBy, ['tanggal', 'nama_barang', 'harga']) ? $OrderBy : 'tanggal';
    $ShortBy     = ($ShortBy === 'ASC') ? 'ASC' : 'DESC';

    if (empty($id_supplier)) {
        echo '<tr><td colspan="10" class="text-center text-danger">ID Supplier Tidak Boleh Kosong</td></tr>';
        exit;
    }

    // Hitung total data
    $where_clause = "WHERE tjb.id_supplier='$id_supplier'";
    if (!empty($keyword_by) && !empty($keyword)) {
        $where_clause .= " AND $keyword_by LIKE '%$keyword%'";
    }

    $query_count = "SELECT COUNT(*) as total FROM transaksi_jual_beli tjb 
                    JOIN transaksi_jual_beli_rincian tjbr ON tjb.id_transaksi_jual_beli = tjbr.id_transaksi_jual_beli
                    $where_clause";
    $result_count = mysqli_query($Conn, $query_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $jml_data = $row_count['total'] ?? 0;

    if ($jml_data == 0) {
        echo '<tr><td colspan="10" class="text-center text-danger">Tidak Ada Data Yang Ditampilkan.</td></tr>';
        exit;
    }

    // Ambil data dengan limit & offset
    $query = "SELECT tjb.tanggal, tjbr.nama_barang, tjbr.harga, tjbr.qty, tjbr.satuan, tjbr.subtotal, tjbr.ppn, tjbr.diskon, tjb.total 
            FROM transaksi_jual_beli tjb 
            JOIN transaksi_jual_beli_rincian tjbr ON tjb.id_transaksi_jual_beli = tjbr.id_transaksi_jual_beli
            $where_clause 
            ORDER BY $OrderBy $ShortBy 
            LIMIT $posisi, $batas";

    $result = mysqli_query($Conn, $query);
    if (!$result) {
        echo '<tr><td colspan="10" class="text-center text-danger">Error: ' . mysqli_error($Conn) . '</td></tr>';
        exit;
    }

    $no = $posisi + 1;
    while ($data = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td><small>' . $no . '</small></td>';
        echo '<td><small>' . date('d/m/Y', strtotime($data['tanggal'])) . '</small></td>';
        echo '<td><small>' . htmlspecialchars($data['nama_barang']) . '</small></td>';
        echo '<td><small>' . number_format($data['harga'], 0, ',', '.') . '</small></td>';
        echo '<td><small>' . $data['qty'] . '</small></td>';
        echo '<td><small>' . htmlspecialchars($data['satuan']) . '</small></td>';
        echo '<td><small>' . number_format($data['subtotal'], 0, ',', '.') . '</small></td>';
        echo '<td><small>' . number_format($data['ppn'], 0, ',', '.') . '</small></td>';
        echo '<td><small>' . number_format($data['diskon'], 0, ',', '.') . '</small></td>';
        echo '<td><small>' . number_format($data['total'], 0, ',', '.') . '</small></td>';
        echo '</tr>';
        $no++;
    }

    // Hitung jumlah halaman
    $JmlHalaman = ceil($jml_data / $batas);
?>

<script>
    var page_count = <?php echo $JmlHalaman; ?>;
    var current_page = <?php echo $page; ?>;

    $('#page_info_rincian_transaksi').html('Page ' + current_page + ' of ' + page_count);
    $('#prev_button_rincian_transaksi').prop('disabled', current_page == 1);
    $('#next_button_rincian_transaksi').prop('disabled', current_page >= page_count);
</script>