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
            $uuid_pinjaman=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'uuid_pinjaman');
            //Proses hapus data
            $HapusPinjaman = mysqli_query($Conn, "DELETE FROM pinjaman WHERE id_pinjaman='$id_pinjaman'") or die(mysqli_error($Conn));
            if($HapusPinjaman) {
                //Proses hapus jurnal
                $HapusJurnal = mysqli_query($Conn, "DELETE FROM jurnal WHERE kategori='Pinjaman' AND uuid='$uuid_pinjaman'") or die(mysqli_error($Conn));
                if($HapusJurnal) {
                    //Proses hapus angsuran
                    $HapusAngsuran = mysqli_query($Conn, "DELETE FROM pinjaman_angsuran WHERE id_pinjaman='$id_pinjaman'") or die(mysqli_error($Conn));
                    if($HapusAngsuran) {
                        echo '<span class="text-success" id="NotifikasiHapusPinjamanBerhasil">Success</span>';
                        $KategoriLog="Pinjaman";
                        $KeteranganLog="Hapus Data Pinjaman";
                        include "../../_Config/InputLog.php";
                    }else{
                        echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus data angsuran</span>';
                    }
                }else{
                    echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus data jurnal</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus data pinjaman</span>';
            }
        }
    }
?>