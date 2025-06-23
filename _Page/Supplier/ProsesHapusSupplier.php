<?php
    //Connection
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($_POST['id_supplier'])){
        echo '<span class="text-danger">ID Supplier Tidak Boleh Kosong!</span>';
    }else{
        $id_supplier=$_POST['id_supplier'];
        //Proses hapus data
        $HapusSupplier = mysqli_query($Conn, "DELETE FROM supplier WHERE id_supplier='$id_supplier'") or die(mysqli_error($Conn));
        if($HapusSupplier){
            $KategoriLog="Supplier";
            $KeteranganLog="Hapus Supplier $nama_supplier";
            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
            if($InputLog=="Success"){
                echo '<div class="alert alert-success" id="NotifikasiHapusSupplierBerhasil">Success</div>';
            }else{
                echo '<div class="alert alert-danger">Terjadi kesalahan pada saat menyimpan log</div>';
            }
        }else{
            echo '<span class="text-danger">Hapus Supplier Gagal</span>';
        }
    }
?>