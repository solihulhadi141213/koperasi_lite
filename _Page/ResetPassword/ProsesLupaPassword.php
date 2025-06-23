<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/SettingEmail.php";
    
    //Zona Waktu
    date_default_timezone_set("Asia/Jakarta");
    
    //Tanggal Sekarang
    $tanggal=date('Y-m-d');
    
    //Menangkap mode_akses
    if(empty($_POST['mode_akses'])){
        echo '<div class="alert alert-danger"><small>Mode akses tidak boleh kosong!</small></div>';
    }else{

        //Menangkap email
        if(empty($_POST['email'])){
            echo '<div class="alert alert-danger"><small>Maaf!! Email Tidak Boleh Kosong, Silahkan Diisi.</small></div>';
        }else{

            //Buat Variabel Dan Bersihkan
            $mode_akses=validateAndSanitizeInput($_POST['mode_akses']);
            $email=validateAndSanitizeInput($_POST['email']);

            //Validasi Email Berdassarkan 'mode_akses'
            if($mode_akses=="Anggota"){
                $id_anggota=GetDetailData($Conn, 'anggota', 'email', $email, 'id_anggota');
                if(empty($id_anggota)){
                    $validasi_email="Email Yang Anda Masukan Tidak Terdaftar Pada Database Anggota Kami!";
                }else{
                    $validasi_email="Valid";
                }
            }else{
                $id_akses=GetDetailData($Conn, 'akses', 'email_akses', $email, 'id_akses');
                if(empty($id_akses)){
                    $validasi_email="Email Yang Anda Masukan Tidak Terdaftar Pada Database Pengurus Kami!";
                }else{
                    $validasi_email="Valid";
                }
            }
            if($validasi_email!=="Valid"){
                echo '<small class="text-danger">Maaf!! Email Tidak Boleh Kosong, Silahkan Diisi.</small>';
            }else{

                //Buak Kode Unik Sebanyak 36 karakter
                $code_unik=generateRandomString(36);

                //Hasing code_unik
                $code_unik_hash=md5($code_unik);

                //Menghiutng waktu expired
                $tanggal_expired = date('Y-m-d', strtotime($tanggal . ' +1 day')); // Tambah 1 hari

                //Atur id_akses dan id_anggota berdasarkan mode_akses
                if($mode_akses=="Anggota"){
                    $id_akses=null;
                    $id_anggota=GetDetailData($Conn, 'anggota', 'email', $email, 'id_anggota');
                    $nama_tujuan=GetDetailData($Conn, 'anggota', 'email', $email, 'nama');
                }else{
                    $id_akses=GetDetailData($Conn, 'akses', 'email_akses', $email, 'id_akses');
                    $id_anggota=null;
                    $nama_tujuan=GetDetailData($Conn, 'akses', 'email_akses', $email, 'nama_akses');
                }

                //Cek apakah ada data lupa_password yang belum digunakan dan masih aktif?
                if($mode_akses=="Anggota"){
                    $QryLupaPassword=mysqli_query($Conn,"SELECT*FROM lupa_password WHERE id_anggota='$id_anggota' AND tanggal_expired>'$tanggal' AND status='0'")or die(mysqli_error($Conn));
                }else{
                    $QryLupaPassword=mysqli_query($Conn,"SELECT*FROM lupa_password WHERE id_akses='$id_akses' AND tanggal_expired>'$tanggal' AND status='0'")or die(mysqli_error($Conn));
                }
                $DataLupaPassword = mysqli_fetch_array($QryLupaPassword);
                if(empty($DataLupaPassword["id_lupa_password"])){

                    //Apabila Belum Ada Maka Lakukan Insert
                    $entry="INSERT INTO lupa_password (
                        id_akses,
                        id_anggota,
                        email,
                        tanggal_dibuat,
                        tanggal_expired,
                        code_unik,
                        status
                    ) VALUES (
                        " . ($id_akses !== null ? "'$id_akses'" : "NULL") . ",
                        " . ($id_anggota !== null ? "'$id_anggota'" : "NULL") . ",
                        '$email',
                        '$tanggal',
                        '$tanggal_expired',
                        '$code_unik_hash',
                        null
                    )";
                    $Input=mysqli_query($Conn, $entry);
                    if($Input){
                        $validasi_proses="Berhasil";
                    }else{
                        $validasi_proses="Terjadi kesalahan pada saat insert data lupa password";
                    }
                }else{
                    $id_lupa_password=$DataLupaPassword["id_lupa_password"];
                    //Apabila sudah ada maka lakukan update
                    $Update = mysqli_query($Conn,"UPDATE lupa_password SET 
                        id_akses=" . ($id_akses !== null ? "'$id_akses'" : "NULL") . ",
                        id_anggota=" . ($id_anggota !== null ? "'$id_anggota'" : "NULL") . ",
                        email='$email',
                        tanggal_dibuat='$tanggal',
                        tanggal_expired='$tanggal_expired',
                        code_unik='$code_unik_hash',
                        code_unik='$code_unik_hash',
                        status=null
                    WHERE id_lupa_password='$id_lupa_password'") or die(mysqli_error($Conn)); 
                    if($Update){
                        $validasi_proses="Berhasil";
                    }else{
                        $validasi_proses="Terjadi kesalahan pada saat update data lupa password";
                    }
                }

                //Apabila Prosses Berhasil Kirim Email
                if($validasi_proses!=="Berhasil"){
                    echo '<small class="text-danger">'.$validasi_proses.'</small>';
                }else{
                        
                    //Persiapkan Data Pengiriman Email
                    $subjek="Tautan Reset Password ($title_page)";
                    $email_tujuan=$email;
                    $nama_tujuan=$nama_tujuan;
                    $link_reset_password="$base_url/Login.php?Page=ResetPassword&email=$email&token=$code_unik";
                    $pesan='
                        Dear <b>'.$nama_tujuan.'</b><br>
                        Anda telah mengajukan tautan lupa password kepada kami pada tanggal '.$tanggal.'. 
                        Klik tautan <b>Reset Password</b> berikut ini, kemudian isi form dengan password baru anda.
                        <a href="'.$link_reset_password.'">Reset Password</a>. 
                        <br>
                        Apabila tautan tidak muncul gunakan URL berikut : <i>'.$link_reset_password.'</i>
                    ';

                    //Kirim Pesan
                    //Kirim email
                    $ch = curl_init();
                    $headers = array(
                        'Content-Type: Application/JSON',          
                        'Accept: Application/JSON'     
                    );
                    $arr = array(
                        "subjek" => "$subjek",
                        "email_asal" => "$email_gateway",
                        "password_email_asal" => "$password_gateway",
                        "url_provider" => "$url_provider",
                        "nama_pengirim" => "$nama_pengirim",
                        "email_tujuan" => "$email_tujuan",
                        "nama_tujuan" => "$nama_tujuan",
                        "pesan" => "$pesan",
                        "port" => "$port_gateway"
                    );
                    $json = json_encode($arr);
                    curl_setopt($ch, CURLOPT_URL, "$url_service");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 1000); 
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $content = curl_exec($ch);
                    $err = curl_error($ch);
                    curl_close($ch);

                    //Tanpa konfirmasi email terkirim atau tidak 
                    echo '
                        <div class="alert alert-success">
                            <small id="NotifikasiLupaPasswordBerhasil">Success</small>
                        </div>
                    ';
                }
            }
        }
    }
?>