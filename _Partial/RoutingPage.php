<?php
    if(empty($_GET['Page'])){
        include "_Page/Dashboard/Dashboard.php";
    }else{
        $Page=$_GET['Page'];
        //Index Halaman
        $page_arry=[
            "Akses"             =>  "_Page/Akses/Akses.php",
            "Anggota"           =>  "_Page/Anggota/Anggota.php",
            "JenisSimpanan"     =>  "_Page/JenisSimpanan/JenisSimpanan.php",
            "SimpananWajib"     =>  "_Page/SimpananWajib/SimpananWajib.php",
            "PenarikanSimpanan" =>  "_Page/PenarikanSimpanan/PenarikanSimpanan.php",
            "Tagihan"           =>  "_Page/Tagihan/Tagihan.php",
            "PotonganAnggota"   =>  "_Page/PotonganAnggota/PotonganAnggota.php",
            "JenisTransaksi"    =>  "_Page/JenisTransaksi/JenisTransaksi.php",
            "SettingGeneral"    =>  "_Page/SettingGeneral/SettingGeneral.php",
            "Tabungan"          =>  "_Page/Tabungan/Tabungan.php",
            "Pinjaman"          =>  "_Page/Pinjaman/Pinjaman.php",
            "JenisPinjaman"     =>  "_Page/JenisPinjaman/JenisPinjaman.php",
            "MyProfile"         =>  "_Page/MyProfile/MyProfile.php",
            "Help"              =>  "_Page/Help/Help.php",
            "RiwayatAnggota"    =>  "_Page/RiwayatAnggota/RiwayatAnggota.php",
            "Aktivitas"         =>  "_Page/Aktivitas/Aktivitas.php",
            "SimpanPinjam"      =>  "_Page/SimpanPinjam/SimpanPinjam.php",
            "RiwayatSimpanPinjam"=>  "_Page/RiwayatSimpanPinjam/RiwayatSimpanPinjam.php",
            "Laporan"           =>  "_Page/Laporan/Laporan.php",
            "CetakInvoice"      =>  "_Page/CetakInvoice/CetakInvoice.php",
            "SimpananAnggota"   =>  "_Page/SimpananAnggota/SimpananAnggota.php",
            "PenarikanAnggota"  =>  "_Page/PenarikanAnggota/PenarikanAnggota.php",
            "PinjamanAnggota"   =>  "_Page/PinjamanAnggota/PinjamanAnggota.php",
            "AngsuranAnggota"   =>  "_Page/AngsuranAnggota/AngsuranAnggota.php",
            "Error"             =>  "_Page/Error/Error.php"
        ];

        //Tangkap 'Page'
        $Page = !empty($_GET['Page']) ? $_GET['Page'] : "";

        //Kondisi Pada masing-masing Page
        if (array_key_exists($Page, $page_arry)) { 
            include $page_arry[$Page]; 
        } else { 
            include "_Page/Dashboard/Dashboard.php";
        }
    }
?>