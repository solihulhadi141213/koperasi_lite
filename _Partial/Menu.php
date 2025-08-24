<?php
    if(empty($_GET['Page'])){
        $PageMenu="";
    }else{
        $PageMenu=$_GET['Page'];
    }
    if(empty($_GET['Sub'])){
        $SubMenu="";
    }else{
        $SubMenu=$_GET['Sub'];
    }

    //Rout Berdasarkan Session Akses
    if($SessionModeAkses=="Anggota"){
        include "_Partial/MenuAnggota.php";
    }else{
        if($SessionModeAkses=="Admin"){
            include "_Partial/MenuPengurus.php";
        }else{
            if($SessionModeAkses=="Bendahara"){
                include "_Partial/MenuBendahara.php";
            }else{
                if($SessionModeAkses=="Sekretaris"){
                    include "_Partial/MenuSekretaris.php";
                }else{
                    include "_Partial/MenuKetua.php";
                }
            }
        }
    }
?>