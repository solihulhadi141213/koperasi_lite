<?php
    if(!empty($_POST['id_pinjaman'])){
        $jumlah=0;
        foreach ($_POST['id_pinjaman'] as $data){
            //Explode data
            $explode=explode('-',$data);
            $nominal=$explode[1];

            //Kalkulasi
            $jumlah=$jumlah+$nominal;
        }
        $jumlah_format = "Rp " . number_format($jumlah,0,',','.');
        echo "$jumlah_format";
    }
?>