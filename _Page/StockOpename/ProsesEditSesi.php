<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');
    
    //Validasi Akses
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger">Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</div>';
    }else{
        //Get Data
        if(empty($_POST['tanggal'])){
            echo '<span class="text-danger">Tanggal Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['id_stok_opename'])){
                echo '<span class="text-danger">ID Stock Opename Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['status'])){
                    $status=0;
                }else{
                    $status=validateAndSanitizeInput($_POST['status']);
                }
                $tanggal=validateAndSanitizeInput($_POST['tanggal']);
                $id_stok_opename=validateAndSanitizeInput($_POST['id_stok_opename']);
                $UpdateStockOpename = mysqli_query($Conn,"UPDATE stok_opename SET 
                    tanggal='$tanggal',
                    status='$status'
                WHERE id_stok_opename='$id_stok_opename'") or die(mysqli_error($Conn)); 
                if($UpdateStockOpename){
                    $kategori_log="Barang";
                    $deskripsi_log="Edit Sesi Stock Opename";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        echo '<div class="alert alert-success" id="NotifikasiEditSesiBerhasil">Success</div>';
                    }else{
                        echo '<div class="alert alert-danger">Terjadi kesalahan pada saat menyimpan Log</div>';
                    }
                }else{
                    echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data</small>';
                }
            }
        }
    }
?>