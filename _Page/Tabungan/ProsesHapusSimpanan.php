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
        if(empty($_POST['id_simpanan'])){
            echo '<span class="text-danger">ID Simpanan tidak dapat ditangkap oleh sistem</span>';
        }else{
            $id_simpanan=$_POST['id_simpanan'];
            //Buka UUID
            $uuid_simpanan=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'uuid_simpanan');
            //Proses Hapus Simpanan
            $HapusSimpanan = mysqli_query($Conn, "DELETE FROM simpanan WHERE id_simpanan='$id_simpanan'") or die(mysqli_error($Conn));
            if ($HapusSimpanan) {
                $HapusJurnal = mysqli_query($Conn, "DELETE FROM jurnal WHERE kategori='Simpanan' AND uuid='$uuid_simpanan'") or die(mysqli_error($Conn));
                if ($HapusJurnal) {
                    $KategoriLog="Log Simpanan";
                    $KeteranganLog="Hapus Simpanan";
                    include "../../_Config/InputLog.php";
                    echo '<span class="text-success" id="NotifikasiHapusSimpananBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menghapus Jurnal</span>';
                }
            }else{
                echo '<span class="text-danger">Hapus Data Gagal</span>';
            }
        }
    }
?>