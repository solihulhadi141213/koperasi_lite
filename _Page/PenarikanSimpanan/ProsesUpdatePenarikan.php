<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');

    //Validasi Sessi Akses
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sessi Akses Sudah Berakhir, Silahkan Login Ulang!</small>';
    }else{

        //Validasi id_simpanan_penarikan
        if(empty($_POST['id_simpanan_penarikan'])){
            echo '<span class="text-danger">ID Pengajuan Penarikan tidak dapat ditangkap oleh sistem</span>';
        }else{
            
            //Validasi Status
            if(empty($_POST['status'])){
                echo '<span class="text-danger">Status Penarikan tidak dapat ditangkap oleh sistem</span>';
            }else{
                $id_simpanan_penarikan=$_POST['id_simpanan_penarikan'];
                $status=$_POST['status'];
                //Update Database
                $UpdatePenarikan = mysqli_query($Conn,"UPDATE simpanan_penarikan SET 
                    status='$status'
                WHERE id_simpanan_penarikan='$id_simpanan_penarikan'") or die(mysqli_error($Conn)); 
                if($UpdatePenarikan){
                    echo '<small class="text-success" id="NotifikasiUpdatePenarikanBerhasil">Success</small>';
                }else{
                    echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data.</small>';
                }
            }
        }
    }
?>