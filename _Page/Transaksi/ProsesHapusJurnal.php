<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
    }else{
        if(empty($_POST['id_jurnal'])){
            echo '<small class="text-danger">ID Jurnal Tidak Boleh Kosong!</small>';
        }else{
            $id_jurnal=$_POST['id_jurnal'];
            $id_jurnal=validateAndSanitizeInput($id_jurnal);
            $id_jurnal=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'id_jurnal');
            //Proses Hapus Jurnal
            $HapusJurnal = mysqli_query($Conn, "DELETE FROM jurnal WHERE id_jurnal='$id_jurnal'") or die(mysqli_error($Conn));
            if($HapusJurnal){
                $KategoriLog="Transaksi";
                $KeteranganLog="Hapus Jurnal";
                include "../../_Config/InputLog.php";
                echo '<span class="text-success" id="NotifikasiHapusJurnalBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Hapus Jurnal Transaksi Gagal</span>';
            }
        }
    }
?>