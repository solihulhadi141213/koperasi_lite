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
        //Validasi tanggal tidak boleh kosong
        if(empty($_POST['id_simpanan'])){
            echo '<small class="text-danger">ID Simpanan Tidak Boleh Kosong!</small>';
        }else{
            $id_simpanan=$_POST['id_simpanan'];
            $uuid_simpanan=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'uuid_simpanan');
            //Bersihkan Variabel
            $id_simpanan=validateAndSanitizeInput($id_simpanan);
            $HapusSimpanan = mysqli_query($Conn, "DELETE FROM simpanan WHERE id_simpanan='$id_simpanan'") or die(mysqli_error($Conn));
            if($HapusSimpanan) {
                $KategoriLog="Simpanan Wajib";
                $KeteranganLog="Hapus Simpanan Wajib";
                include "../../_Config/InputLog.php";
                echo '<small class="text-success" id="NotifikasiHapusSimpananBerhasil">Success</small>';
            }else{
                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data.</small>';
            }
        }
    }
?>