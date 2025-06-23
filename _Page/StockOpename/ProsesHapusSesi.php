<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger">Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</div>';
    }else{
        //Get Data
        if(empty($_POST['id_stok_opename'])){
            echo '<div class="alert alert-danger">ID Stock Opename Tidak Boleh Kosong!</div>';
        }else{
            $id_stok_opename=validateAndSanitizeInput($_POST['id_stok_opename']);
            
            //Validasi data duplikat
            $HapusStockOpename= mysqli_query($Conn, "DELETE FROM stok_opename WHERE id_stok_opename='$id_stok_opename'") or die(mysqli_error($Conn));
            if($HapusStockOpename) {
                $kategori_log="Barang";
                $deskripsi_log="Hapus Sesi Stock Opename";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    echo '<div class="alert alert-success" id="NotifikasiHapusSesiBerhasil">Success</div>';
                }else{
                    echo '<div class="alert alert-danger">Terjadi kesalahan pada saat menyimpan Log</div>';
                }
            }else{
                echo '<div class="alert alert-danger">Terjadi kesalahan pada saat menyimpan data</div>';
            }
        }
    }
?>