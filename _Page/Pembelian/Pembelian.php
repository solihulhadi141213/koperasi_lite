<?php
    if(empty($_GET['Sub'])){
        include "_Page/Pembelian/_PembelianHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahPembelian"){
            include "_Page/Pembelian/_TambahPembelian.php";
        }else{
            if($Sub=="EditPembelian"){
                include "_Page/Pembelian/EditPembelian.php";
            }else{
                if($Sub=="DetailPembelian"){
                    include "_Page/Pembelian/_DetailPembelian.php";
                }else{
                    include "_Page/Pembelian/_PembelianHome.php";
                }
            }
        }
    }
?>