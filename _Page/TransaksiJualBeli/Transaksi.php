<?php
    if(empty($_GET['Sub'])){
        include "_Page/TransaksiJualBeli/TransaksiHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="TambahTransaksi"){
            include "_Page/TransaksiJualBeli/TambahTransaksi.php";
        }else{
            if($Sub=="EditTransaksi"){
                include "_Page/TransaksiJualBeli/EditTransaksi.php";
            }else{
                if($Sub=="DetailTransaksi"){
                    include "_Page/TransaksiJualBeli/DetailTransaksi.php";
                }else{
                    include "_Page/TransaksiJualBeli/TransaksiHome.php";
                }
            }
        }
    }
?>