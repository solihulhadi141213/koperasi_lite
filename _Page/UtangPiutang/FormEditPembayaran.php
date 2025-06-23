<?php
    // Koneksi dan konfigurasi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";

    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>
            </div>
        ';
        exit;
    }

    // Tangkap ID transaksi pembayaran
    if (empty($_POST['id_transaksi_pembayaran'])) {
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Pembayaran Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    $id_transaksi_pembayaran = validateAndSanitizeInput($_POST['id_transaksi_pembayaran']);

    // Ambil data pembayaran
    $Qry = $Conn->prepare("SELECT * FROM transaksi_pembayaran WHERE id_transaksi_pembayaran = ?");
    $Qry->bind_param("s", $id_transaksi_pembayaran);

    if (!$Qry->execute()) {
        $error = $Conn->error;
        echo '
            <div class="alert alert-danger text-center">
                <small>Terjadi kesalahan saat membuka data pembayaran.<br>
                Keterangan: ' . htmlspecialchars($error) . '</small>
            </div>
        ';
        exit;
    }

    $Result = $Qry->get_result();
    $Data = $Result->fetch_assoc();
    $Qry->close();

    if (!$Data) {
        echo '
            <div class="alert alert-warning text-center">
                <small>Data pembayaran tidak ditemukan.</small>
            </div>
        ';
        exit;
    }

    // Ambil data dari hasil query
    $id_transaksi_jual_beli = $Data['id_transaksi_jual_beli'] ?? '';
    $kategori = $Data['kategori'] ?? '';
    $tanggal = $Data['tanggal'] ?? '';
    $jumlah = $Data['jumlah'] ?? 0;

    // Format tanggal dan jam
    $tanggal_format = $tanggal ? date('Y-m-d', strtotime($tanggal)) : '';
    $jam_format = $tanggal ? date('H:i', strtotime($tanggal)) : '';

    // Pastikan jumlah angka, lalu format
    $jumlah = is_numeric($jumlah) ? $jumlah : 0;

    //format uang
    $jumlah_rp = "" . number_format($jumlah,0,',','.');

    echo '
        <input type="hidden" id="id_transaksi_pembayaran" name="id_transaksi_pembayaran" value="'.htmlspecialchars($id_transaksi_pembayaran).'">

        <div class="row mb-3">
            <div class="col-4">
                <label for="tanggal_pembayaran_piutang_penjualan_edit">
                    <small>Tanggal</small>
                </label>
            </div>
            <div class="col-8">
                <input type="date" class="form-control" id="tanggal_pembayaran_piutang_penjualan_edit" name="tanggal" value="'.htmlspecialchars($tanggal_format).'">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-4">
                <label for="jam_pembayaran_piutang_penjualan">
                    <small>Jam</small>
                </label>
            </div>
            <div class="col-8">
                <input type="time" class="form-control" id="jam_pembayaran_piutang_penjualan" name="jam" value="'.htmlspecialchars($jam_format).'">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-4">
                <label for="nominal_pembayaran_piutang_penjualan">
                    <small>Jumlah (Nominal)</small>
                </label>
            </div>
            <div class="col-8">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="jumlah" id="nominal_pembayaran_piutang_penjualan" class="form-control form-uang" oninput="this.value = this.value.replace(/[^0-9]/g, \'\');" value="'.htmlspecialchars($jumlah_rp).'">
                </div>
            </div>
        </div>
    ';
?>
<script>
$(document).ready(function(){
    // Fungsi format angka ribuan
    function formatRupiah(angka) {
        angka = angka.replace(/[^,\d]/g, '');
        var split = angka.split(',');
        var sisa = split[0].length % 3;
        var rupiah = split[0].substr(0, sisa);
        var ribuan = split[0].substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }

    // Saat input diketik
    $(document).on('input', '.form-uang', function(){
        var value = $(this).val();
        var formatted = formatRupiah(value);
        $(this).val(formatted);
    });
});
</script>
