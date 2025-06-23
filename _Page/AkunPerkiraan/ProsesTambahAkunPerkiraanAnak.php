<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Validasi Variebl yang ditangkap
    //Cek Akses
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col col-md-12 text-center">';
        echo '      <code>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</code>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['kode'])){
            echo '<span class="text-danger">Kode Perkiraan Tidak Boleh Kosong.</span>';
        }else{
            if(empty($_POST['nama'])){
                echo '<span class="text-danger">Nama Perkiraan Tidak Boleh Kosong.</span>';
            }else{
                if(empty($_POST['id_perkiraan'])){
                    echo '<span class="text-danger">ID Akun Perkiraan Diatasnya Tidak Boleh Kosong.</span>';
                }else{
                    $kode=$_POST['kode'];
                    $nama=$_POST['nama'];
                    $id_perkiraan=$_POST['id_perkiraan'];
                    //Bersihkan Variabel
                    $kode=validateAndSanitizeInput($kode);
                    $nama=validateAndSanitizeInput($nama);
                    $id_perkiraan=validateAndSanitizeInput($id_perkiraan);
                    //Buka Kode Di Atasnya
                    $KodeUtama=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kode');
                    $LevelInduk=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'level');
                    $saldo_normal=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'saldo_normal');
                    //Kode Baru
                    $KodeBaru="$KodeUtama.$kode";
                    $LevelSaya=$LevelInduk+1;
                    //Validasi Kode Sama/Duplikat
                    $ValidasiKodeSama=GetDetailData($Conn,'akun_perkiraan','kode',$KodeBaru,'kode');
                    //Apabila akun belum ada, atau duplikat
                    if(!empty($ValidasiKodeSama)){
                        echo '<span class="text-danger">Kode yang anda gunakan sudah ada, silahkan gunakan kode lain.</span>';
                    }else{
                        //Lakukan Input data baru ke akun_perkiraan
                        $InputDataPerkiraan="INSERT INTO akun_perkiraan (
                            kode,
                            nama,
                            level,
                            saldo_normal
                        ) VALUES (
                            '$KodeBaru',
                            '$nama',
                            '$LevelSaya',
                            '$saldo_normal'
                        )";
                        $HasilInputDataPerkiraan=mysqli_query($Conn, $InputDataPerkiraan);
                        if($HasilInputDataPerkiraan){
                            $JumlahBerhasil=0;
                            for ( $i="1"; $i<="$LevelSaya"; $i++ ){
                                //2. susun kolom kd menjadi variabel
                                $string="kd";
                                $string_kode="$string$i";
                                //2.1 Apabila selama perulangan jumlah perulangan sudah mencapai level
                                if($i==$LevelSaya){
                                    //2.2 Maka kode induk sama dengan kode yang ditangkap dari form
                                    $kode_induk="$KodeBaru";
                                }else{
                                    //2.3 Sebaliknya maka kode induk harus dicari dulu berdasarkan database data induk
                                    $qry_kode_induk = mysqli_query($Conn, "SELECT * FROM akun_perkiraan WHERE id_perkiraan='$id_perkiraan'")or die(mysqli_error($Conn));
                                    $data_kode_induk = mysqli_fetch_array($qry_kode_induk);
                                    $kode_induk = $data_kode_induk[$string_kode];
                                }
                                //SEMENTARA LAKUKAN PENGECEKAN KOLOM TERSEBUT ADA ATAU TIDAK
                                //3.Buka keberadaan Kolom Dari MYSQL
                                $nama_kolom="kd$i";
                                $qry_kolom = mysqli_query($Conn, "SHOW COLUMNS FROM akun_perkiraan WHERE Field='$nama_kolom'")or die(mysqli_error($Conn));
                                $dt_kolom = mysqli_fetch_array($qry_kolom);
                                $Field = $dt_kolom['Field'];
                                //APABILA KOLOMNYA SUDAH ADA LANGSUNG INPUT EDIT SAJA
                                if(!empty($Field)){
                                    $UpdateKolom = mysqli_query($Conn, "UPDATE akun_perkiraan SET $nama_kolom='$kode_induk' WHERE kode='$KodeBaru'") or die(mysqli_error($Conn)); 
                                    if($UpdateKolom){
                                        $JumlahBerhasil=$JumlahBerhasil+1;
                                    }else{
                                        $JumlahBerhasil=$JumlahBerhasil+0;
                                    }
                                }else{
                                    //APABILA BELUM ADA BUAT DULU KOLOMNYA
                                    $buat_kolom = mysqli_query($Conn, "ALTER TABLE akun_perkiraan ADD $nama_kolom VARCHAR(50) NULL") or die(mysqli_error($Conn)); 
                                    if(!$buat_kolom){
                                        $JumlahBerhasil=$JumlahBerhasil+0;
                                    }else{
                                        //APABILA SUDAH BUAT KOLOM UPDATE KE KOLOM TERSEBUT
                                        $UpdateKeKolomBaru = mysqli_query($Conn, "UPDATE akun_perkiraan SET $nama_kolom='$kode_induk'WHERE kode='$KodeBaru'") or die(mysqli_error($Conn)); 
                                        if(!$UpdateKeKolomBaru){
                                            $JumlahBerhasil=$JumlahBerhasil+0;
                                        }else{
                                            $JumlahBerhasil=$JumlahBerhasil+1;
                                        }
                                    }
                                }
                            }
                            if($JumlahBerhasil==$LevelSaya){
                                $KategoriLog="Akun Perkiraan";
                                $KeteranganLog="Tambah Akun Perkiraan";
                                include "../../_Config/InputLog.php";
                                echo '<small class="text-success" id="NotifikasiTambahAkunPerkiraanAnakBerhasil">Success</small>';
                            }else{
                                echo '<small class="text-danger">Terjadi kesalahan pada saat melngatur kode lanjutan.</small>';
                            }
                        }else{
                            echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data.</small>';
                        }
                    }
                }
            }
        }
    }
?>

