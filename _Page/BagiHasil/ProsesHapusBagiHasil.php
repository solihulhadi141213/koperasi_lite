<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
    }else{
        if(empty($_POST['id_shu_session'])){
            echo '<span class="text-danger">ID Sesi tidak dapat ditangkap oleh sistem</span>';
        }else{
            $id_shu_session=$_POST['id_shu_session'];
            //Proses hapus Sessi
            $HapusSessi = mysqli_query($Conn, "DELETE FROM shu_session WHERE id_shu_session='$id_shu_session'") or die(mysqli_error($Conn));
            if($HapusSessi) {
                $kategori_log="SHU";
                $deskripsi_log="Hapus SHU";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    echo '<span class="text-success" id="NotifikasiHapusSesiBagiHasilBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan log</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus data Bagi Hasil</span>';
            }
        }
    }
?>