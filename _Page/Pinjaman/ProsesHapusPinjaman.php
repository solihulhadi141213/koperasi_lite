<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<span class="text-danger">Sesi akses sudah berakhir, silahkan login ulang!</span>';
    }else{
        if(empty($_POST['id_pinjaman'])){
            echo '<span class="text-danger">ID Pinjaman tidak dapat ditangkap oleh sistem</span>';
        }else{
            $id_pinjaman=$_POST['id_pinjaman'];
            //Bersihkan Variabel
            $id_pinjaman=validateAndSanitizeInput($id_pinjaman);
            //Proses hapus data
            $HapusPinjaman = mysqli_query($Conn, "DELETE FROM pinjaman WHERE id_pinjaman='$id_pinjaman'") or die(mysqli_error($Conn));
            if($HapusPinjaman) {
                echo '<span class="text-success" id="NotifikasiHapusPinjamanBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus data pinjaman</span>';
            }
        }
    }
?>