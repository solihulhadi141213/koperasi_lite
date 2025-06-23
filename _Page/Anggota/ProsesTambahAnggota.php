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
                    //Validasi status tidak boleh kosong
                    if(empty($_POST['status'])){
                        echo '<code class="text-danger">Status anggota tidak boleh kosong</code>';
                    }else{
                        //Buat Variabel
                        $nip=$_POST['nip'];
                        $nama=$_POST['nama'];
                        $tanggal_masuk=$_POST['tanggal_masuk'];
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
                        $status=validateAndSanitizeInput($status);
                        $kontak=validateAndSanitizeInput($kontak);
                        $email=validateAndSanitizeInput($email);
                        $tanggal_keluar=validateAndSanitizeInput($tanggal_keluar);
                        $alasan_keluar=validateAndSanitizeInput($alasan_keluar);
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
                                            $EntryAnggota="INSERT INTO anggota (
                                                tanggal_masuk,
                                                tanggal_keluar,
                                                nip,
                                                nama,
                                                email,
                                                kontak,
                                                status,
                                                alasan_keluar
                                            ) VALUES (
                                                '$tanggal_masuk',
                                                '$tanggal_keluar',
                                                '$nip',
                                                '$nama',
                                                '$email',
                                                '$kontak',
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
?>