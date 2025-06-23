<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'gw5VTLLVsrfg63nfEWX');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        if(empty($_GET['Sub'])){
            include "_Page/UtangPiutang/UtangPiutangHome.php";
        }else{
            $Sub=validateAndSanitizeInput($_GET['Sub']);
            if($Sub=="RiwayatPembayaran"){
                include "_Page/UtangPiutang/RiwayatPembayaran.php";
            }else{
                include "_Page/UtangPiutang/UtangPiutangHome.php";
            }
        }
    }
?>