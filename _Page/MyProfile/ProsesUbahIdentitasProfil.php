<?php
    // Koneksi dan konfigurasi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Keterangan waktu dan zona waktu
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    if (empty($SessionIdAkses)) {
        echo '<small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang!</small>';
    } else {
        if (empty($_POST['nama'])) {
            echo '<small class="text-danger">Nama tidak boleh kosong</small>';
        } elseif (empty($_POST['kontak'])) {
            echo '<small class="text-danger">Kontak tidak boleh kosong</small>';
        } elseif (empty($_POST['email'])) {
            echo '<small class="text-danger">Email tidak boleh kosong</small>';
        } else {
            $nama = $_POST['nama'];
            $kontak = $_POST['kontak'];
            $email = $_POST['email'];
            $JumlahKarakterKontak = strlen($kontak);

            if ($JumlahKarakterKontak > 20 || $JumlahKarakterKontak < 6 || !preg_match("/^[0-9]*$/", $kontak)) {
                echo '<small class="text-danger">Kontak hanya boleh terdiri dari 6-20 karakter numerik</small>';
            } else {
                $nama = validateAndSanitizeInput($nama);
                $kontak = validateAndSanitizeInput($kontak);
                $email = validateAndSanitizeInput($email);

                // Ambil kontak lama
                if($SessionModeAkses=="Anggota"){
                    $kontak_lama = GetDetailData($Conn, 'anggota', 'id_anggota', $SessionIdAkses, 'kontak');
                }else{
                    $kontak_lama = GetDetailData($Conn, 'akses', 'id_akses', $SessionIdAkses, 'kontak_akses');
                }
                
                // Cek duplikasi kontak
                $ValidasiKontakDuplikat = 0;
                if ($kontak !== $kontak_lama) {
                    if($SessionModeAkses=="Anggota"){
                        $ValidasiKontakDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE kontak='$kontak'"));
                    }else{
                        $ValidasiKontakDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses FROM akses WHERE kontak_akses='$kontak'"));
                    }
                }

                if (!empty($ValidasiKontakDuplikat)) {
                    echo '<small class="text-danger">Nomor kontak sudah terdaftar</small>';
                } else {
                    
                    //Ambil Email Lama
                    if($SessionModeAkses=="Anggota"){
                        $email_lama = GetDetailData($Conn, 'anggota', 'id_anggota', $SessionIdAkses, 'email');
                    }else{
                        $email_lama = GetDetailData($Conn, 'akses', 'id_akses', $SessionIdAkses, 'email_akses');
                    }
                    

                    // Cek duplikasi email
                    $ValidasiEmailDuplikat = 0;
                    if ($email !== $email_lama) {
                        if($SessionModeAkses=="Anggota"){
                            $ValidasiEmailDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE email='$email'"));
                        }else{
                            $ValidasiEmailDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_akses FROM akses WHERE email_akses='$email'"));
                        }
                    }
                   

                    if (!empty($ValidasiEmailDuplikat)) {
                        echo '<small class="text-danger">Email yang anda gunakan sudah terdaftar</small>';
                    } else {

                        //Update Data Ke Database
                        try {
                            if($SessionModeAkses=="Anggota"){
                                $UpdateProfil = mysqli_query($Conn,"UPDATE anggota SET 
                                    nama='$nama',
                                    kontak='$kontak',
                                    email='$email'
                                WHERE id_anggota='$SessionIdAkses'") or die(mysqli_error($Conn)); 
                            }else{
                                $UpdateProfil = mysqli_query($Conn,"UPDATE akses SET 
                                    nama_akses='$nama',
                                    kontak_akses='$kontak',
                                    email_akses='$email'
                                WHERE id_akses='$SessionIdAkses'") or die(mysqli_error($Conn)); 
                            }
                        
                            if ($UpdateProfil) {
                                $_SESSION["NotifikasiSwal"] = "Edit Akses Berhasil";
                                echo '<small class="text-success" id="NotifikasiUbahIdentitasProfilBerhasil">Success</small>';
                            } else {
                                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data</small>';
                            }
                        } catch (PDOException $e) {
                            echo '<small class="text-danger">Error: ' . $e->getMessage() . '</small>';
                        }
                    }
                }
            }
        }
    }
?>
