<?php
    if(empty($_GET['Sub'])){
        include "_Page/Pinjaman/PinjamanHome.php";
    }else{
        $Sub=$_GET['Sub'];
        if($Sub=="DetailPinjaman"){
            include "_Page/Pinjaman/DetailPinjaman.php";
        }else{
            if($Sub=="Import"){
                include "_Page/Pinjaman/ImportPinjaman.php";
            }else{
                if($Sub=="DetailAngsuran"){
                    include "_Page/Pinjaman/DetailAngsuran.php";
                }else{
                    include "_Page/Pinjaman/PinjamanHome.php";
                }
            }
        }
    }
?>