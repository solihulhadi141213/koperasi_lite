<?php
    if(empty($_POST['tahun'])){
        $tahun=date('Y');
    }else{
        $tahun=$_POST['tahun'];
    }
    //Format Judul Grapik
    echo '<b>GRAFIK TRANSAKSI PENJUALAN & PEMBELIAN</b><br>';
    echo '<b>PERIODE TAHUN '.$tahun.'</b><br>';
?>