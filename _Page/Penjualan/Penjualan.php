<?php
    if(empty($_GET['Sub'])){
        include "_Page/Penjualan/_PenjualanHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahPenjualan"){
            include "_Page/Penjualan/_TambahPenjualan.php";
        }else{
            if($Sub=="EditPenjualan"){
                include "_Page/Penjualan/EditPenjualan.php";
            }else{
                if($Sub=="DetailPenjualan"){
                    include "_Page/Penjualan/_DetailPenjualan.php";
                }else{
                    include "_Page/Penjualan/PenjualanHome.php";
                }
            }
        }
    }
?>