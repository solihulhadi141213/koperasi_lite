<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    include '../../vendor/autoload.php';
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    if(empty($_POST['jenis_transaksi'])){
        $jenis_transaksi="";
    }else{
        $jenis_transaksi=$_POST['jenis_transaksi'];
    }
    if(empty($_POST['tahun'])){
        $tahun=date('Y');
    }else{
        $tahun=$_POST['tahun'];
    }
    //Format Judul Grapik
    if(empty($jenis_transaksi)){
        echo '<b>GRAFIK TRANSAKSI PERIODE</b><br>';
        echo '<b> TAHUN '.$tahun.'</b><br>';
    }else{
        $jenis_transaksi=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$jenis_transaksi,'nama');
        $jenis_transaksi = strtoupper($jenis_transaksi);
        echo '<b>GRAFIK TRANSAKSI '.$jenis_transaksi.'</b><br>';
        echo '<b> PERIODE TAHUN '.$tahun.'</b><br>';
    }
?>