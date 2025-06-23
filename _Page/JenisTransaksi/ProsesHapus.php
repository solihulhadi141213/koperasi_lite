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
        //Validasi id_transaksi_jenis tidak boleh kosong
        if(empty($_POST['id_transaksi_jenis'])){
            echo '<small class="text-danger">ID Jenis Transaksi Tidak Boleh Kosong!</small>';
        }else{
            $id_transaksi_jenis=$_POST['id_transaksi_jenis'];
            //Bersihkan Variabel
            $id_transaksi_jenis=validateAndSanitizeInput($id_transaksi_jenis);
            $HapusJenisTransaksi = mysqli_query($Conn, "DELETE FROM transaksi_jenis WHERE id_transaksi_jenis='$id_transaksi_jenis'") or die(mysqli_error($Conn));
            if($HapusJenisTransaksi){
                $KategoriLog="Jenis Transaksi";
                $KeteranganLog="Hapus Jenis Transaksi";
                include "../../_Config/InputLog.php";
                echo '<small class="text-success" id="NotifikasiHapusBerhasil">Success</small>';
            }else{
                echo '<small class="text-danger">Terjadi kesalahan pada saat menghapus data.</small>';
            }
        }
    }
?>