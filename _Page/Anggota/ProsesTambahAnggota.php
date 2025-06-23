<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
    }else{
        //Validasi nip tidak boleh kosong
        if(empty($_POST['nip'])){
            echo '<code class="text-danger">Nomor Induk Anggota Tidak Boleh Kosong</code>';
        }else{
            //Validasi nama tidak boleh kosong
            if(empty($_POST['nama'])){
                echo '<code class="text-danger">Nama tidak boleh kosong</code>';
            }else{
                //Validasi tanggal_masuk tidak boleh kosong
                if(empty($_POST['tanggal_masuk'])){
                    echo '<code class="text-danger">Tanggal masuk anggota tidak boleh kosong</code>';
                }else{
                    //Validasi lembaga tidak boleh kosong
                    if(empty($_POST['lembaga'])){
                        echo '<code class="text-danger">Nama lembaga anggota tidak boleh kosong</code>';
                    }else{
                        //Validasi ranking tidak boleh kosong
                        if(empty($_POST['ranking'])){
                            echo '<code class="text-danger">Ranking/Group anggota tidak boleh kosong</code>';
                        }else{
                            //Validasi status tidak boleh kosong
                            if(empty($_POST['status'])){
                                echo '<code class="text-danger">Status anggota tidak boleh kosong</code>';
                            }else{
                                //Buat Variabel
                                $nip=$_POST['nip'];
                                $nama=$_POST['nama'];
                                $tanggal_masuk=$_POST['tanggal_masuk'];
                                $lembaga=$_POST['lembaga'];
                                $ranking=$_POST['ranking'];
                                $status=$_POST['status'];
                                //Variabel Lain yang tidak wajib
                                if(!empty($_POST['kontak'])){
                                    $kontak=$_POST['kontak'];
                                }else{
                                    $kontak="";
                                }
                                if(!empty($_POST['email'])){
                                    $email=$_POST['email'];
                                }else{
                                    $email="";
                                }
                                if(!empty($_POST['password'])){
                                    $password=$_POST['password'];
                                }else{
                                    $password="";
                                }
                                if(!empty($_POST['tanggal_keluar'])){
                                    $tanggal_keluar=$_POST['tanggal_keluar'];
                                }else{
                                    $tanggal_keluar=date('Y-m-d');
                                }
                                if(!empty($_POST['alasan_keluar'])){
                                    $alasan_keluar=$_POST['alasan_keluar'];
                                }else{
                                    $alasan_keluar="";
                                }
                                if(!empty($_POST['akses_anggota'])){
                                    $akses_anggota=1;
                                }else{
                                    $akses_anggota=0;
                                }
                                //Bersihkan Variabel
                                $nip=validateAndSanitizeInput($nip);
                                $nama=validateAndSanitizeInput($nama);
                                $tanggal_masuk=validateAndSanitizeInput($tanggal_masuk);
                                $lembaga=validateAndSanitizeInput($lembaga);
                                $ranking=validateAndSanitizeInput($ranking);
                                $status=validateAndSanitizeInput($status);
                                $kontak=validateAndSanitizeInput($kontak);
                                $email=validateAndSanitizeInput($email);
                                $password=validateAndSanitizeInput($password);
                                $tanggal_keluar=validateAndSanitizeInput($tanggal_keluar);
                                $alasan_keluar=validateAndSanitizeInput($alasan_keluar);
                                $akses_anggota=validateAndSanitizeInput($akses_anggota);
                                $ValidasiNip=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE nip='$nip'"));
                                $JumlahKarakterNip=strlen($_POST['nip']);
                                if(!empty($_POST['email'])){
                                    $ValidasiEmailDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE email='$email'"));
                                }else{
                                    $ValidasiEmailDuplikat="";
                                }
                                if(!empty($_POST['kontak'])){
                                    $ValidasiKontakDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE kontak='$kontak'"));
                                    $JumlahKarakterKontak=strlen($_POST['kontak']);
                                }else{
                                    $ValidasiKontakDuplikat="";
                                    $JumlahKarakterKontak=0;
                                }
                                if(!empty($ValidasiNip)){
                                    echo '<code class="text-danger">Nomor induk yang anda masukan sudah ada sebelumnya</code>';
                                }else{
                                    if(!empty($ValidasiEmailDuplikat)){
                                        echo '<code class="text-danger">Email anggota yang anda masukan sudah ada sebelumnya</code>';
                                    }else{
                                        if(!empty($ValidasiKontakDuplikat)){
                                            echo '<code class="text-danger">Kontak anggota yang anda masukan sudah ada sebelumnya</code>';
                                        }else{
                                            //Validasi kontak tidak boleh lebih dari 20 karakter
                                            if($JumlahKarakterKontak>20||!preg_match("/^[^a-zA-Z ]*$/", $_POST['kontak'])){
                                                echo '<small class="text-danger">Kontak maksimal 20 karakter numerik</small>';
                                            }else{
                                                //Validasi NIP tidak boleh lebih dari 32 karakter
                                                if($JumlahKarakterNip>32){
                                                    echo '<small class="text-danger">NIP maksimal 32 karakter</small>';
                                                }else{
                                                    //Validasi Gambar
                                                    if(!empty($_FILES['foto']['name'])){
                                                        $nama_gambar=$_FILES['foto']['name'];
                                                        $ukuran_gambar = $_FILES['foto']['size']; 
                                                        $tipe_gambar = $_FILES['foto']['type']; 
                                                        $tmp_gambar = $_FILES['foto']['tmp_name'];
                                                        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                                                        $key=implode('', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
                                                        $FileNameRand=$key;
                                                        $Pecah = explode("." , $nama_gambar);
                                                        $BiasanyaNama=$Pecah[0];
                                                        $Ext=$Pecah[1];
                                                        $namabaru = "$FileNameRand.$Ext";
                                                        $path = "../../assets/img/Anggota/".$namabaru;
                                                        if($tipe_gambar == "image/jpeg"||$tipe_gambar == "image/jpg"||$tipe_gambar == "image/gif"||$tipe_gambar == "image/png"){
                                                            if($ukuran_gambar<2000000){
                                                                if(move_uploaded_file($tmp_gambar, $path)){
                                                                    $ValidasiGambar="Valid";
                                                                }else{
                                                                    $ValidasiGambar="Upload file gambar gagal";
                                                                }
                                                            }else{
                                                                $ValidasiGambar="File gambar tidak boleh lebih dari 2 mb";
                                                            }
                                                        }else{
                                                            $ValidasiGambar="tipe file hanya boleh JPG, JPEG, PNG and GIF";
                                                        }
                                                    }else{
                                                        $ValidasiGambar="Valid";
                                                        $namabaru="";
                                                    }
                                                    //Apabila validasi upload valid maka simpan di database
                                                    if($ValidasiGambar!=="Valid"){
                                                        echo '<small class="text-danger">'.$ValidasiGambar.'</small>';
                                                    }else{
                                                        $EntryAnggota="INSERT INTO anggota (
                                                            tanggal_masuk,
                                                            tanggal_keluar,
                                                            nip,
                                                            nama,
                                                            email,
                                                            password,
                                                            kontak,
                                                            lembaga,
                                                            ranking,
                                                            foto,
                                                            akses_anggota,
                                                            status,
                                                            alasan_keluar
                                                        ) VALUES (
                                                            '$tanggal_masuk',
                                                            '$tanggal_keluar',
                                                            '$nip',
                                                            '$nama',
                                                            '$email',
                                                            '$password',
                                                            '$kontak',
                                                            '$lembaga',
                                                            '$ranking',
                                                            '$namabaru',
                                                            '$akses_anggota',
                                                            '$status',
                                                            '$alasan_keluar'
                                                        )";
                                                        $InputAnggota=mysqli_query($Conn, $EntryAnggota);
                                                        if($InputAnggota){
                                                            $KategoriLog="Angggota";
                                                            $KeteranganLog="Tambah Anggota baru";
                                                            include "../../_Config/InputLog.php";
                                                            echo '<small class="text-success" id="NotifikasiTambahAnggotaBerhasil">Success</small>';
                                                        }else{
                                                            echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data anggota</small>';
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
        }
    }
?>