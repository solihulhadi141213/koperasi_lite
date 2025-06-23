<?php
    if(empty($_GET['Sub'])){
        include "_Page/Akses/AksesHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="DetailAkses"){
            include "_Page/Akses/DetailAkses.php";
        }else{
            include "_Page/Akses/AksesHome.php";
        }
    }
?>