<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');

    // Inisialisasi respons default
    $response = [
        "status" => "Error",
        "message" => "Belum ada proses yang dilakukan pada sistem."
    ];

    // Validasi Akses
    if (empty($SessionIdAkses)) {
        $response = [
            "status" => "Error",
            "message" => "Sesi Akses Sudah Berakhir! Silahkan Login Ulang!"
        ];
        echo json_encode($response);
        exit;
    }

    // Validasi input
    if (empty($_POST['id_transaksi_pembayaran'])) {
        echo json_encode([
            "status" => "Error",
            "message" => "ID Transaksi Pembayaran Tidak Boleh Kosong!"
        ]);
        exit;
    }

    // Ambil ID
    $id_transaksi_pembayaran = validateAndSanitizeInput($_POST['id_transaksi_pembayaran']);

    // Cari id_transaksi_jual_beli terkait
    $id_transaksi_jual_beli = GetDetailData($Conn, 'transaksi_pembayaran', 'id_transaksi_pembayaran', $id_transaksi_pembayaran, 'id_transaksi_jual_beli');

    if (empty($id_transaksi_jual_beli)) {
        echo json_encode([
            "status" => "Error",
            "message" => "ID Transaksi Tidak Ditemukan!"
        ]);
        exit;
    }

    // Hapus pembayaran
    $HapusPembayaran = mysqli_query($Conn, "DELETE FROM transaksi_pembayaran WHERE id_transaksi_pembayaran='$id_transaksi_pembayaran'");
    if (!$HapusPembayaran) {
        echo json_encode([
            "status" => "Error",
            "message" => "Terjadi kesalahan pada saat hapus transaksi pembayaran: " . mysqli_error($Conn)
        ]);
        exit;
    }

    // Hitung ulang status transaksi
    $total_tagihan = floatval(GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'total'));
    $cash = floatval(GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'cash'));
    $kategori = GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'kategori');

    // Hitung total angsuran
    $sql_angsuran = "SELECT SUM(jumlah) as total_jumlah FROM transaksi_pembayaran WHERE id_transaksi_jual_beli='$id_transaksi_jual_beli'";
    $result_angsuran = $Conn->query($sql_angsuran);
    $total_angsuran = 0;
    if ($result_angsuran && $result_angsuran->num_rows > 0) {
        $row = $result_angsuran->fetch_assoc();
        $total_angsuran = floatval($row['total_jumlah'] ?? 0);
    }

    // Hitung sisa tunggakan
    $sisa_tunggakan = $total_tagihan - ($cash + $total_angsuran);

    // Tentukan status transaksi
    if ($sisa_tunggakan != 0) {
        $status = "Kredit";
    } else {
        $status = "Lunas";
    }

    // Update status transaksi
    $stmt_transaksi = mysqli_prepare($Conn, "UPDATE transaksi_jual_beli SET status=? WHERE id_transaksi_jual_beli=?");
    mysqli_stmt_bind_param($stmt_transaksi, "ss", $status, $id_transaksi_jual_beli);
    $update_transaksi = mysqli_stmt_execute($stmt_transaksi);

    if (!$update_transaksi) {
        echo json_encode([
            "status" => "Error",
            "message" => "Terjadi kesalahan pada saat update transaksi jual beli."
        ]);
        exit;
    }

    // Tambahkan log aktivitas
    $kategori_log = "Utang Piutang";
    $deskripsi_log = "Hapus Pembayaran Utang Piutang";
    $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);

    if ($InputLog != "Success") {
        $response = [
            "status" => "Error",
            "message" => "Terjadi Kesalahan Pada Saat Menyimpan Log"
        ];
    } else {
        $response = [
            "status" => "Success",
            "message" => "Hapus Pembayaran Utang Piutang Berhasil"
        ];
    }

    // Output response
    echo json_encode($response);
?>
