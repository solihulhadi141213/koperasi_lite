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
        //Validasi id_anggota tidak boleh kosong
        if(empty($_POST['id_anggota'])){
            echo '<code class="text-danger">ID Anggota Tidak Boleh Kosong</code>';
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
                                    $id_anggota=$_POST['id_anggota'];
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
                                    if(!empty($_POST['akses_anggota'])){
                                        $akses_anggota=1;
                                    }else{
                                        $akses_anggota=0;
                                    }
                                    if(!empty($_POST['alasan_keluar'])){
                                        $alasan_keluar=$_POST['alasan_keluar'];
                                    }else{
                                        $alasan_keluar="";
                                    }
                                    //Bersihkan Variabel
                                    $id_anggota=validateAndSanitizeInput($id_anggota);
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
                                    $akses_anggota=validateAndSanitizeInput($akses_anggota);
                                    //Hitung Karakter NIP
                                    $JumlahKarakterNip=strlen($_POST['nip']);
                                    //Membuka Data Lama
                                    $EmailLama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'email');
                                    $KontakLama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'kontak');
                                    $NipLama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
                                    if(!empty($_POST['email'])){
                                        if($EmailLama==$email){
                                            $ValidasiEmailDuplikat=0;
                                        }else{
                                            $ValidasiEmailDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE email='$email'"));
                                        }
                                    }else{
                                        $ValidasiEmailDuplikat="";
                                    }
                                    if(!empty($_POST['kontak'])){
                                        if($KontakLama==$kontak){
                                            $ValidasiKontakDuplikat=0;
                                        }else{
                                            $ValidasiKontakDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE kontak='$kontak'"));
                                        }
                                        $JumlahKarakterKontak=strlen($_POST['kontak']);
                                    }else{
                                        $ValidasiKontakDuplikat="";
                                        $JumlahKarakterKontak=0;
                                    }
                                    //Validasi NIP
                                    if($NipLama==$nip){
                                        $ValidasiNip=0;
                                    }else{
                                        $ValidasiNip=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM anggota WHERE nip='$nip'"));
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
                                                        $UpdateAnggota = mysqli_query($Conn,"UPDATE anggota SET 
                                                            tanggal_masuk='$tanggal_masuk',
                                                            tanggal_keluar='$tanggal_keluar',
                                                            nip='$nip',
                                                            nama='$nama',
                                                            email='$email',
                                                            password='$password',
                                                            kontak='$kontak',
                                                            lembaga='$lembaga',
                                                            ranking='$ranking',
                                                            akses_anggota='$akses_anggota',
                                                            status='$status',
                                                            alasan_keluar='$alasan_keluar'
                                                        WHERE id_anggota='$id_anggota'") or die(mysqli_error($Conn)); 
                                                        if($UpdateAnggota){
                                                            //Mengubah data simpanan
                                                            $UpdateSimpanan = mysqli_query($Conn,"UPDATE simpanan SET 
                                                                nip='$nip',
                                                                nama='$nama',
                                                                lembaga='$lembaga',
                                                                ranking='$ranking'
                                                            WHERE id_anggota='$id_anggota'") or die(mysqli_error($Conn)); 
                                                            if($UpdateSimpanan){
                                                                $KategoriLog="Angggota";
                                                                $KeteranganLog="Edit Anggota Berhasil";
                                                                include "../../_Config/InputLog.php";
                                                                echo '<small class="text-success" id="NotifikasiEditAnggotaBerhasil">Success</small>';
                                                            }
                                                        }else{
                                                            echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data akses</small>';
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