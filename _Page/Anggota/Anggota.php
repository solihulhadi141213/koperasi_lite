<?php
    if(empty($_GET['Sub'])){
        include "_Page/Anggota/AnggotaHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="DetailAnggota"){
            include "_Page/Anggota/DetailAnggota.php";
        }else{
            if($Sub=="Import"){
                include "_Page/Anggota/ImportAnggota.php";
            }else{
                include "_Page/Anggota/AnggotaHome.php";
            }
        }
    }
?>