<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'YyU3kA2xi9HqU1EMuTm');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        if(empty($_GET['Sub'])){
            include "_Page/BarangExpired/BarangExpiredHome.php";
        }else{
            if($_GET['Sub']=="TambahBarangExpired"){
                include "_Page/BarangExpired/TambahBarangExpired.php";
            }else{
                if($_GET['Sub']=="Import"){
                    include "_Page/BarangExpired/ImportBarangExpired.php";
                }else{
                    include "_Page/BarangExpired/BarangExpiredHome.php";
                }
            }
        }
    }
?>