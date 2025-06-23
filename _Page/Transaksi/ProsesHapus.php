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
        if(empty($_POST['id_transaksi'])){
            echo '<small class="text-danger">ID Transaksi Tidak Boleh Kosong!</small>';
        }else{
            $id_transaksi=$_POST['id_transaksi'];
            $id_transaksi=validateAndSanitizeInput($id_transaksi);
            $uuid_transaksi=GetDetailData($Conn,'transaksi','id_transaksi',$id_transaksi,'uuid_transaksi');
            //Proses Hapus Transaksi
            $HapusTransaksi = mysqli_query($Conn, "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'") or die(mysqli_error($Conn));
            if($HapusTransaksi){
                $HapusJurnal = mysqli_query($Conn, "DELETE FROM jurnal WHERE kategori='Transaksi' AND uuid='$uuid_transaksi'") or die(mysqli_error($Conn));
                if($HapusJurnal){
                    $KategoriLog="Transaksi";
                    $KeteranganLog="Hapus Transaksi";
                    include "../../_Config/InputLog.php";
                    echo '<span class="text-success" id="NotifikasiHapusBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Hapus Rincian Transaksi Gagal</span>';
                }
            }else{
                echo '<span class="text-danger">Hapus Transaksi Gagal</span>';
            }
        }
    }
?>