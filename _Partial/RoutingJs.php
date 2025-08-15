<?php 
    $date_version=date('YmdHis');
    if(empty($_GET['Page'])){
        //Dafault Javascript Diarahkan Ke Dashboard
        echo '<script type="text/javascript" src="_Page/Dashboard/Dashboard.js?V='.$date_version.'"></script>';
    }else{
        $Page=$_GET['Page'];
        // Routing Javascript Berdasarkan Halaman
        $scripts = [
            "MyProfile"                 => "_Page/MyProfile/MyProfile.js",
            "Akses"                     => "_Page/Akses/Akses.js",
            "Anggota"                   => "_Page/Anggota/Anggota.js",
            "JenisSimpanan"             => "_Page/JenisSimpanan/JenisSimpanan.js",
            "SimpananWajib"             => "_Page/SimpananWajib/SimpananWajib.js",
            "Tabungan"                  => "_Page/Tabungan/Tabungan.js",
            "PenarikanSimpanan"         => "_Page/PenarikanSimpanan/PenarikanSimpanan.js",
            "JenisPinjaman"             => "_Page/JenisPinjaman/JenisPinjaman.js",
            "Pinjaman"                  => "_Page/Pinjaman/Pinjaman.js",
            "Tagihan"                   => "_Page/Tagihan/Tagihan.js",
            "PotonganAnggota"           => "_Page/PotonganAnggota/PotonganAnggota.js",
            "SettingGeneral"            => "_Page/SettingGeneral/SettingGeneral.js",
            "Help"                      => "_Page/Help/Help.js",
            "SettingEmail"              => "_Page/SettingService/SettingService.js",
            "Pendaftaran"               => "_Page/Pendaftaran/Pendaftaran.js",
            "Pembayaran"                => "_Page/Pembayaran/Pembayaran.js",
            "Aktivitas"                 => "_Page/Aktivitas/Aktivitas.js",
            "SimpanPinjam"              => "_Page/SimpanPinjam/SimpanPinjam.js",
            "RiwayatSimpanPinjam"       => "_Page/RiwayatSimpanPinjam/RiwayatSimpanPinjam.js",
            "RiwayatAnggota"            => "_Page/RiwayatAnggota/RiwayatAnggota.js",
            "SimpananAnggota"           => "_Page/SimpananAnggota/SimpananAnggota.js",
            "PenarikanAnggota"          => "_Page/PenarikanAnggota/PenarikanAnggota.js",
            "PinjamanAnggota"           => "_Page/PinjamanAnggota/PinjamanAnggota.js",
            "AngsuranAnggota"           => "_Page/AngsuranAnggota/AngsuranAnggota.js",
            "Laporan"                   => "_Page/Laporan/Laporan.js"
        ];

        // Cek apakah halaman ada dalam daftar dan sertakan file JS yang sesuai
        if (!empty($_GET['Page']) && isset($scripts[$_GET['Page']])) {
            echo '<script type="text/javascript" src="' . $scripts[$_GET['Page']] . '?V='.$date_version.'"></script>';
        }
    }
    echo '<script type="text/javascript" src="_Partial/Universal.js?V='.$date_version.'"></script>';
?>