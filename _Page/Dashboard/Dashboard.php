<?php
    //Routing Menampilkan Dashboard Berdasarkan Hak Akses
    if($SessionModeAkses=="Anggota"){
        include "_Page/Dashboard/DashboardAnggota.php";
    }else{
        include "_Page/Dashboard/DashboardAdmin.php";
    }
    
?>