<?php
    include "_Page/Logout/ModalLogout.php";
    if(!empty($_GET['Page'])){
        $Page=$_GET['Page'];
        
        // Daftar halaman dan modal yang terkait
        $modals = [
            "MyProfile"             => "_Page/MyProfile/ModalMyProfile.php",
            "Akses"                 => "_Page/Akses/ModalAkses.php",
            "Anggota"               => "_Page/Anggota/ModalAnggota.php",
            "RekapAnggota"          => "_Page/RekapAnggota/ModalRekapAnggota.php",
            "JenisSimpanan"         => "_Page/JenisSimpanan/ModalJenisSimpanan.php",
            "SimpananWajib"         => "_Page/SimpananWajib/ModalSimpananWajib.php",
            "PenarikanSimpanan"     => "_Page/PenarikanSimpanan/ModalPenarikanSimpanan.php",
            "Tagihan"               => "_Page/Tagihan/ModalTagihan.php",
            "RekapSimpanan"         => "_Page/RekapSimpanan/ModalRekapSimpanan.php",
            "RekapPinjaman"         => "_Page/RekapPinjaman/ModalRekapPinjaman.php",
            "PotonganAnggota"       => "_Page/PotonganAnggota/ModalPotonganAnggota.php",
            "SettingGeneral"        => "_Page/SettingGeneral/ModalSettingGeneral.php",
            "Tabungan"              => "_Page/Tabungan/ModalTabungan.php",
            "JenisPinjaman"         => "_Page/JenisPinjaman/ModalJenisPinjaman.php",
            "Pinjaman"              => "_Page/Pinjaman/ModalPinjaman.php",
            "Help"                  => "_Page/Help/ModalHelp.php",
            "Pembayaran"            => "_Page/Pembayaran/ModalPembayaran.php",
            "Aktivitas"             => "_Page/Aktivitas/ModalAktivitas.php",
            "RiwayatSimpanPinjam"   => "_Page/RiwayatSimpanPinjam/ModalRiwayatSimpanPinjam.php",
            "SimpananAnggota"       => "_Page/SimpananAnggota/ModalSimpananAnggota.php",
            "PenarikanAnggota"      => "_Page/PenarikanAnggota/ModalPenarikanAnggota.php",
            "PinjamanAnggota"       => "_Page/PinjamanAnggota/ModalPinjamanAnggota.php",
            "AngsuranAnggota"       => "_Page/AngsuranAnggota/ModalAngsuranAnggota.php",
            "RekapitulasiTransaksi" => "_Page/RekapitulasiTransaksi/ModalRekapitulasiTransaksi.php",
            "BagiHasil"             => "_Page/BagiHasil/ModalBagiHasil.php",
            "Laporan"               => "_Page/Laporan/ModalLaporan.php"
        ];

        // Cek apakah halaman memiliki modal terkait dan sertakan file modalnya
        if (!empty($_GET['Page']) && isset($modals[$_GET['Page']])) {
            include $modals[$_GET['Page']];
        }
    }
?>