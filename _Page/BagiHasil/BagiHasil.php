<?php
    //Routing Halaman Bagi Hasil
    if(empty($_GET['Sub'])){
        include "_Page/BagiHasil/_BagiHasilHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="DetailBagiHasil"){
            include "_Page/BagiHasil/_DetailBagiHasil.php";
        }else{
            include "_Page/BagiHasil/_BagiHasilHome.php";
        }
    }
?>