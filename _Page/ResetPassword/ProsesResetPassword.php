<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/SettingEmail.php";
    
    //Zona Waktu
    date_default_timezone_set("Asia/Jakarta");
    
    //Tanggal Sekarang
    $tanggal_sekarang=date('Y-m-d');
    
    //Menangkap email
    if(empty($_POST['email'])){
        $validasi_data="Email Tidak Boleh Kosong! Silahkan gunakan tautan yang telah kami kirim ke email anda!";
    }else{

        //Menangkap token
        if(empty($_POST['token'])){
            $validasi_data="Token Tidak Boleh Kosong! Silahkan gunakan tautan yang telah kami kirim ke email anda!";
        }else{

            //Menangkap PasswordBaru1
            if(empty($_POST['PasswordBaru1'])){
                $validasi_data="Password Baru Tidak Boleh Kosong!";
            }else{

                //Menangkap PasswordBaru1
                if($_POST['PasswordBaru1']!==$_POST['PasswordBaru2']){
                    $validasi_data="Password Yang Anda Masukan Tidak Sama!";
                }else{
                    
                    //Validasi Jumlah Karakter
                    if(strlen($_POST['PasswordBaru1'])<6){
                        $validasi_data="Password Yang Anda Masukan Tidak Boleh Kurang Dari 6 Karakter!";
                    }else{
                        if(strlen($_POST['PasswordBaru1'])>20){
                            $validasi_data="Password Yang Anda Masukan Tidak Boleh Lebih Dari 20 Karakter!";
                        }else{
                            $validasi_data="Valid";
                        }
                    }
                }
            }
        }
    }
    if($validasi_data!=="Valid"){
        echo '
            <div class="alert alert-danger">
                <small>'.$validasi_data.'</small>
            </div>
        ';
    }else{
        //Buat Variabel Dan Bersihkan
        $email=validateAndSanitizeInput($_POST['email']);
        $token=validateAndSanitizeInput($_POST['token']);
        $password=validateAndSanitizeInput($_POST['PasswordBaru1']);
        $token_md5=md5($token);

        //Buka Data lupa_password
        $QryLupaPassword=mysqli_query($Conn,"SELECT*FROM lupa_password WHERE email='$email' AND code_unik='$token_md5'")or die(mysqli_error($Conn));
        $DataLupaPassword = mysqli_fetch_array($QryLupaPassword);

        //Validasi Keberadaan data lupa_password
        if(empty($DataLupaPassword["id_lupa_password"])){
            $validasi_token="Kombinasi email dan token yang anda gunakan tidak valid! Silahkan gunakan tautan yang telah kami kirim ke email anda!";
        }else{

            //Validasi Status token
            if($DataLupaPassword["status"]==1){
                $validasi_token="Kombinasi email dan token tersebut sudah digunakan!";
            }else{

                //Validasi apakah token masih berlaku
                if($DataLupaPassword["tanggal_expired"]<$tanggal_sekarang){
                    $validasi_token="Kombinasi email dan token tersebut sudah tidak berlaku!";
                }else{
                    $validasi_token="Valid";
                }
            }
        }
        if($validasi_token!=="Valid"){
            echo '
                <div class="alert alert-danger">
                    <small>'.$validasi_token.'</small>
                </div>
            ';
        }else{
            $id_lupa_password=$DataLupaPassword["id_lupa_password"];
            if(empty($DataLupaPassword["id_anggota"])){
                $mode_akses="Pengurus";
                $id_anggota="";
                $id_akses=$DataLupaPassword["id_akses"];
                $password=md5($password);
            }else{
                $mode_akses="Anggota";
                $id_anggota=$DataLupaPassword["id_anggota"];
                $id_akses="";
                $password=$password;
            }
            
            //Apabila Mode Akssses Anggota
            if($mode_akses=="Anggota"){
                $Update = mysqli_query($Conn,"UPDATE anggota SET 
                    password='$password'
                WHERE id_anggota='$id_anggota'") or die(mysqli_error($Conn)); 
                if($Update){
                    $validasi_proses="Berhasil";
                }else{
                    $validasi_proses="Terjadi kesalahan pada saat update data password anggota";
                }
            }else{
                $Update = mysqli_query($Conn,"UPDATE akses SET 
                    password='$password'
                WHERE id_akses='$id_akses'") or die(mysqli_error($Conn)); 
                if($Update){
                    $validasi_proses="Berhasil";
                }else{
                    $validasi_proses="Terjadi kesalahan pada saat update data password pengurus";
                }
            }

            //Apabila Gagal
            if($validasi_proses!=="Berhasil"){
                echo '
                    <div class="alert alert-danger">
                        <small>'.$validasi_proses.'</small>
                    </div>
                ';
            }else{
                //Apabila Berhasil

                //Ubah Status Lupa Password
                $update_lupa_password = mysqli_query($Conn,"UPDATE lupa_password SET 
                    status=1
                WHERE id_lupa_password='$id_lupa_password'") or die(mysqli_error($Conn)); 
                if($update_lupa_password){
                    $validasi_lupa_password="Berhasil";
                }else{
                    $validasi_lupa_password="Terjadi kesalahan pada saat update data lupa password";
                }
                if($validasi_lupa_password!=="Berhasil"){
                    echo '
                        <div class="alert alert-danger">
                            <small>'.$validasi_lupa_password.'</small>
                        </div>
                    ';
                }else{
                    //Tanpa konfirmasi email terkirim atau tidak 
                    echo '
                        <div class="alert alert-success">
                            <small id="NotifikasiResetPasswordBerhasil">Success</small>
                        </div>
                    ';
                }
            }
        }
    }
?>