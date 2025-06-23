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
                if(empty($_POST['saldo_normal'])){
                    echo '<span class="text-danger">Saldo Normal Akun Perkiraan Tidak Boleh Kosong.</span>';
                }else{
                    $kode=$_POST['kode'];
                    $nama=$_POST['nama'];
                    $saldo_normal=$_POST['saldo_normal'];
                    //Bersihkan Variabel
                    $kode=validateAndSanitizeInput($kode);
                    $nama=validateAndSanitizeInput($nama);
                    $saldo_normal=validateAndSanitizeInput($saldo_normal);
                    //Validasi Kode Sama/Duplikat
                    $ValidasiKodeSama=GetDetailData($Conn,'akun_perkiraan','kode',$kode,'kode');
                    //Apabila akun belum ada, atau duplikat
                    if(!empty($ValidasiKodeSama)){
                        echo '<span class="text-danger">Kode yang anda gunakan sudah ada, silahkan gunakan kode lain.</span>';
                    }else{
                        //Lakukan Input data baru ke akun_perkiraan
                        $InputDataPerkiraan="INSERT INTO akun_perkiraan (
                            kode,
                            nama,
                            level,
                            saldo_normal,
                            kd1
                        ) VALUES (
                            '$kode',
                            '$nama',
                            '1',
                            '$saldo_normal',
                            '$kode'
                        )";
                        $HasilInputDataPerkiraan=mysqli_query($Conn, $InputDataPerkiraan);
                        if($HasilInputDataPerkiraan){
                            $kategori_log="Akun Perkiraan";
                            $deskripsi_log="Tambah Akun Perkiraan";
                            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                            if($InputLog=="Success"){
                                echo '<small class="text-success" id="NotifikasiTambahAkunPerkiraanUtamaBerhasil">Success</small>';
                            }else{
                                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan log.</small>';
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

