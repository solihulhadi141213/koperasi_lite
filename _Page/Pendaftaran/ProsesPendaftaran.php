<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
   
    session_start();
    
    //Time Zone
    date_default_timezone_set("Asia/Jakarta");
    $Datetime_generate=date('Y-m-d H:i:s');
    
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    
    //Validasi nama tidak boleh kosong
    if(empty($_POST['nama'])){
        echo '<small class="text-danger">Nama tidak boleh kosong. Silahkan Isi dengan lengkap!</small>';
    }else{

        //Validasi NIK tidak boleh kosong
        if(empty($_POST['nik'])){
            echo '<small class="text-danger">Kontak tidak boleh kosong. Silahkan Isi dengan lengkap!</small>';
        }else{

            //Validasi kontak tidak boleh kosong
            if(empty($_POST['kontak'])){
                echo '<small class="text-danger">Kontak tidak boleh kosong. Silahkan Isi dengan lengkap!</small>';
            }else{

                //Validasi email tidak boleh kosong
                if(empty($_POST['email'])){
                    echo '<small class="text-danger">Email tidak boleh kosong. Silahkan Isi dengan lengkap!</small>';
                }else{
                    
                    //Validasi password1 tidak boleh kosong
                    if(empty($_POST['password1'])){
                        echo '<small class="text-danger">Password tidak boleh kosong. Silahkan Isi dengan lengkap!</small>';
                    }else{
                        
                        //Buat Variabel
                        $nama=$_POST['nama'];
                        $nik=$_POST['nik'];
                        $kontak=$_POST['kontak'];
                        $email=$_POST['email'];
                        $password1=$_POST['password1'];
                        $password=MD5($password1);
                        

                        //Validasi kontak tidak boleh lebih dari 20 karakter
                        $JumlahKarakterKontak=strlen($_POST['kontak']);
                        if($JumlahKarakterKontak>20||$JumlahKarakterKontak<6||!preg_match("/^[0-9]*$/", $_POST['kontak'])){
                            echo '<small class="text-danger">Kontak terdiri dari 6-20 karakter numerik</small>';
                        }else{

                            //Validasi kontak tidak boleh duplikat
                            $kontak=$_POST['kontak'];
                            $ValidasiKontakDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE kontak='$kontak'"));
                            if(!empty($ValidasiKontakDuplikat)){
                                echo '<small class="text-danger">Nomor kontak tersebut sudah terdaftar</small>';
                            }else{
                    
                                //Validasi email tidak boleh kosong
                                if(empty($_POST['email'])){
                                    echo '<small class="text-danger">Email tidak boleh kosong</small>';
                                }else{
                                    
                                    //Validasi email duplikat
                                    $email=$_POST['email'];
                                    $ValidasiEmailDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE email='$email'"));
                                    if(!empty($ValidasiEmailDuplikat)){
                                        echo '<small class="text-danger">Email sudah digunakan</small>';
                                    }else{
                                        
                                        //Validasi Password Harus Sama
                                        if($_POST['password1']!==$_POST['password2']){
                                            echo '<small class="text-danger">Password Tidak sama</small>';
                                        }else{
                                    
                                            //Validasi jumlah dan jenis karakter password
                                            $JumlahKarakterPassword=strlen($_POST['password1']);
                                            if($JumlahKarakterPassword>20||$JumlahKarakterPassword<6||!preg_match("/^[a-zA-Z0-9]*$/", $_POST['password1'])){
                                                echo '<small class="text-danger">Password terdiri dari 6-20 karakter</small>';
                                            }else{
                                                
                                                //Simpan Data Ke Database
                                                $tanggal_masuk=date('Y-m-d');
                                                $tanggal_keluar=date('Y-m-d');
                                                $entry="INSERT INTO anggota (
                                                    tanggal_masuk ,
                                                    tanggal_keluar,
                                                    nip,
                                                    nama,
                                                    email,
                                                    kontak,
                                                    password,
                                                    status,
                                                    alasan_keluar
                                                ) VALUES (
                                                    '$tanggal_masuk',
                                                    '$tanggal_keluar',
                                                    '$nik',
                                                    '$nama',
                                                    '$email',
                                                    '$kontak',
                                                    '$password',
                                                    'Pending',
                                                    ''
                                                )";
                                                $Input=mysqli_query($Conn, $entry);
                                                if($Input){
                                                    $_SESSION ["NotifikasiSwal"]="Pendaftaran Berhasil";
                                                    echo '<small class="text-success" id="NotifikasiPendaftaranBerhasil">Success</small>';
                                                }else{
                                                    echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data</small>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>