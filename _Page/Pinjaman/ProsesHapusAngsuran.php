<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<span class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang!</span>';
    }else{
        if(empty($_POST['id_pinjaman_angsuran'])){
            echo '<span class="text-danger">ID Angsuran tidak dapat ditangkap oleh sistem</span>';
        }else{
            $id_pinjaman_angsuran=$_POST['id_pinjaman_angsuran'];
            $uuid_angsuran=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'uuid_angsuran');
            if(empty($uuid_angsuran)){
                echo '<span class="text-danger">UUID Angsuran Tidak Ditemukan</span>';
            }else{
                //Proses hapus data Angsuran
                $HapusAngsuran = mysqli_query($Conn, "DELETE FROM pinjaman_angsuran WHERE id_pinjaman_angsuran='$id_pinjaman_angsuran'") or die(mysqli_error($Conn));
                if($HapusAngsuran) {
                    //Hapus Jurnal
                    $HapusJurnal = mysqli_query($Conn, "DELETE FROM jurnal WHERE uuid='$uuid_angsuran'") or die(mysqli_error($Conn));
                    if($HapusJurnal) {
                        echo '<span class="text-success" id="NotifikasiHapusAngsuranBerhasil">Success</span>';
                        $KategoriLog="Angsuran";
                        $KeteranganLog="Hapus Angsuran Berhasil";
                        include "../../_Config/InputLog.php";
                    }else{
                        echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus data jurnal</span>';
                    }
                }else{
                    echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus data angsuran</span>';
                }
            }
        }
    }
?>