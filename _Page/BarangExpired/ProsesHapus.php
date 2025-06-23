<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');

    //Tangkap Data
    if(empty($_POST['id_barang_bacth'])){
        echo '<span class="text-danger">ID Batch Baraang Tidak Boleh Kosong</span>';
    }else{
        $id_barang_bacth=$_POST['id_barang_bacth'];
        //Proses hapus Expired Date
        $HapusExpiredDate= mysqli_query($Conn, "DELETE FROM barang_bacth WHERE id_barang_bacth='$id_barang_bacth'") or die(mysqli_error($Conn));
        if($HapusExpiredDate) {
            //Simpan LOG
            $kategori_log="Barang";
            $deskripsi_log="Hapus Barang Batch & Expired";
            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
            if($InputLog=="Success"){
                echo '<span class="text-success" id="NotifikasiHapusBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan log!</span>';
            }
        }else{
            echo '<span class="text-danger">Hapus Expired Date Gagal</span>';
        }
    }
?>