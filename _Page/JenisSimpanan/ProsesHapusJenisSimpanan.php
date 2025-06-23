<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sessi Akses Sudah Berakhir, Silahkan Login Ulang!</small>';
    }else{
        //Validasi id_simpanan_jenis tidak boleh kosong
        if(empty($_POST['id_simpanan_jenis'])){
            echo '<small class="text-danger">ID Jenis Simpanan Tidak Boleh Kosong!</small>';
        }else{
            $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
            //Bersihkan Variabel
            $id_simpanan_jenis=validateAndSanitizeInput($id_simpanan_jenis);
            $HapusJenisSimpanan = mysqli_query($Conn, "DELETE FROM simpanan_jenis WHERE id_simpanan_jenis='$id_simpanan_jenis'") or die(mysqli_error($Conn));
            if($HapusJenisSimpanan){
                $KategoriLog="Jenis Simpanan";
                $KeteranganLog="Hapus Jenis Simpanan";
                include "../../_Config/InputLog.php";
                echo '<small class="text-success" id="NotifikasiHapusJenisSimpananBerhasil">Success</small>';
            }else{
                echo '<small class="text-danger">Terjadi kesalahan pada saat menghapus data.</small>';
            }
        }
    }
?>