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
        if(empty($_POST['tanggal'])){
            echo '<div class="alert alert-danger">Tanggal Tidak Boleh Kosong!</div>';
        }else{
            if(empty($_POST['status'])){
                $status=0;
            }else{
                $status=validateAndSanitizeInput($_POST['status']);
            }
            $tanggal=validateAndSanitizeInput($_POST['tanggal']);
            
            //Validasi data duplikat
            $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM stok_opename WHERE tanggal='$tanggal'"));
            if(!empty($ValidasiDuplikat)){
                echo '<div class="alert alert-danger">Data Tersebut sudah ada</div>';
            }else{
                //Simpan data
                $entry="INSERT INTO stok_opename (
                    tanggal,
                    status
                ) VALUES (
                    '$tanggal',
                    '$status'
                )";
                $Input=mysqli_query($Conn, $entry);
                if($Input){
                    $kategori_log="Barang";
                    $deskripsi_log="Tambah Sesi Stock Opename";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        echo '<div class="alert alert-success" id="NotifikasiTambahSesiBerhasil">Success</div>';
                    }else{
                        echo '<div class="alert alert-danger">Terjadi kesalahan pada saat menyimpan Log</div>';
                    }
                }else{
                    echo '<div class="alert alert-danger">Terjadi kesalahan pada saat menyimpan data</div>';
                }
            }
        }
    }
?>