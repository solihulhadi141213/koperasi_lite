<?php
    if(empty($_GET['Sub'])){
        include "_Page/SimpananAnggota/SimpananAnggotaHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="DetailSimpananAnggota"){
            include "_Page/SimpananAnggota/DetailSimpananAnggota.php";
        }else{
            include "_Page/SimpananAnggota/SimpananAnggotaHome.php";
        }
    }
?>