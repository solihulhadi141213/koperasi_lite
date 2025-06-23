<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'PLj70Mfj5dhUUvjZqnd');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
        if(empty($_GET['Sub'])){
            include "_Page/StockOpename/StockOpenameHome.php";
        }else{
            $Sub=$_GET['Sub'];
            if($Sub=="DetailStockOpename"){
                include "_Page/StockOpename/DetailStockOpename.php";
            }else{
                include "_Page/StockOpename/StockOpenameHome.php";
            }
        }
    }
?>