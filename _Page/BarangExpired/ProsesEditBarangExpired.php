<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');

    //Tangkap variabel
    if(empty($_POST['id_barang_bacth'])){
        echo '<span class="text-danger">ID Barang Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['no_batch'])){
            echo '<span class="text-danger">Nomor Batch Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['expired_date'])){
                echo '<span class="text-danger">Tanggal Expired Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['reminder_date'])){
                    echo '<span class="text-danger">Tanggal Pemberitahuan Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['qty_batch'])){
                        echo '<span class="text-danger">Jumlah Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['status'])){
                            echo '<span class="text-danger">Status Tidak Boleh Kosong!</span>';
                        }else{
                            $id_barang_bacth=validateAndSanitizeInput($_POST['id_barang_bacth']);
                            $no_batch=validateAndSanitizeInput($_POST['no_batch']);
                            $expired_date=validateAndSanitizeInput($_POST['expired_date']);
                            $reminder_date=validateAndSanitizeInput($_POST['reminder_date']);
                            $qty_batch=validateAndSanitizeInput($_POST['qty_batch']);
                            $status=validateAndSanitizeInput($_POST['status']);
                            if(strlen($no_batch)>20){
                                echo '<span class="text-danger">Nomor Batch Maksimal 20 Digit!</span>';
                            }else{
                                //Simpan data
                                $UpdateExpiredDate = mysqli_query($Conn,"UPDATE barang_bacth SET 
                                    expired_date='$expired_date',
                                    reminder_date='$reminder_date',
                                    qty_batch='$qty_batch',
                                    no_batch='$no_batch',
                                    status='$status'
                                WHERE id_barang_bacth='$id_barang_bacth'") or die(mysqli_error($Conn)); 
                                if($UpdateExpiredDate){
                                    //Simpan LOG
                                    $kategori_log="Barang";
                                    $deskripsi_log="Edit Barang Batch & Expired";
                                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                    if($InputLog=="Success"){
                                        echo '<small class="text-success" id="NotifikasiEditExpiredDateBerhasil">Success</small>';
                                    }else{
                                        echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan log!</span>';
                                    }
                                    
                                }else{
                                    echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data expired date!</span>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>