<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    
    //vALIDASI aKSES
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sessi Akses Sudah Berakhir, Silahkan Login Ulang!</small>';
    }else{

        //Validasi id_simpanan_penarikan tidak boleh kosong
        if(empty($_POST['id_simpanan_penarikan'])){
            echo '<small class="text-danger">ID Penarikan Dana Simpanan Tidak Boleh Kosong!</small>';
        }else{

            //Buat Variabel
            $id_simpanan_penarikan=$_POST['id_simpanan_penarikan'];

            //Bersihkan Variabel
            $id_simpanan_penarikan=validateAndSanitizeInput($id_simpanan_penarikan);

            //Proses Hapus
            $HapusPengajuanPenarikanDana = mysqli_query($Conn, "DELETE FROM simpanan_penarikan WHERE id_simpanan_penarikan='$id_simpanan_penarikan'") or die(mysqli_error($Conn));
            if($HapusPengajuanPenarikanDana){
                echo '<small class="text-success" id="NotifikasiHapusPenarikanBerhasil">Success</small>';
            }else{
                echo '<small class="text-danger">Terjadi kesalahan pada saat menghapus data.</small>';
            }
        }
    }
?>