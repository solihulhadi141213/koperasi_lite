<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Get Data
    if(empty($_POST['id_supplier'])){
        echo '<div class="alert alert-danger">ID Supplier Tidak Boleh Kosong!</div>';
    }else{
        if(empty($_POST['nama_supplier'])){
            echo '<div class="alert alert-danger">Nama Supplier Tidak Boleh Kosong!</div>';
        }else{
            $nama_supplier=$_POST['nama_supplier'];
            if(empty($_POST['email_supplier'])){
                $email_supplier="";
            }else{
                $email_supplier=$_POST['email_supplier'];
            }
            if(empty($_POST['kontak_supplier'])){
                $kontak_supplier="";
            }else{
                $kontak_supplier=$_POST['kontak_supplier'];
                $JumlahKarakterKontak=strlen($_POST['kontak_supplier']);
                if($JumlahKarakterKontak>20||$JumlahKarakterKontak<6||!preg_match("/^[0-9]*$/", $_POST['kontak_supplier'])){
                    $ValidasiarakterKontak="Kontak hanya boleh terdiri dari 6-20 karakter numerik";
                }else{
                    $ValidasiarakterKontak="";
                }
            }
            if(empty($_POST['alamat_supplier'])){
                $alamat_supplier=$_POST['alamat_supplier'];
            }else{
                $alamat_supplier=$_POST['alamat_supplier'];
            }
            if(!empty($ValidasiarakterKontak)){
                echo '<div class="alert alert-danger">'.$ValidasiarakterKontak.'</div>';
            }else{
                //Buat Variabel
                $id_supplier=$_POST['id_supplier'];
                //Update Data
                $UpdateSupplier = mysqli_query($Conn,"UPDATE supplier SET 
                    nama_supplier='$nama_supplier',
                    email_supplier='$email_supplier',
                    kontak_supplier='$kontak_supplier',
                    alamat_supplier='$alamat_supplier'
                WHERE id_supplier='$id_supplier'") or die(mysqli_error($Conn)); 
                if($UpdateSupplier){
                    $KategoriLog="Supplier";
                    $KeteranganLog="Edit Supplier $nama_supplier";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        echo '<div class="alert alert-success" id="NotifikasiEditSupplierBerhasil">Success</div>';
                    }else{
                        echo '<div class="alert alert-danger">Terjadi kesalahan pada saat menyimpan log</div>';
                    }
                    
                }else{
                    echo '<div class="alert alert-danger">Terjadi kesalahan pada saat menyimpan data</div>';
                }
            }
        }
    }
?>