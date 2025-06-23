<?php
    if(empty($_GET['Sub'])){
        include "_Page/Laporan/LaporanAnggota.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="Anggota"){
            include "_Page/Laporan/LaporanAnggota.php";
        }else{
            if($Sub=="Simpanan"){
                include "_Page/Laporan/LaporanSimpanan.php";
            }else{
                if($Sub=="Pinjaman"){
                    include "_Page/Laporan/LaporanPinjaman.php";
                }else{
                    if($Sub=="Angsuran"){
                        include "_Page/Laporan/LaporanAngsuran.php";
                    }else{
                        include "_Page/Laporan/LaporanAnggota.php";
                    }
                }
            }
        }
    }
?>