<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sessi Akses Sudah Berakhir, Silahkan Login Ulang!</small>';
    }else{
        //Validasi nama tidak boleh kosong
        if(empty($_POST['nama'])){
            echo '<small class="text-danger">Nama Jenis Transaksi Tidak Boleh Kosong!</small>';
        }else{
            if(empty($_POST['kategori'])){
                echo '<small class="text-danger">Kategori Transaksi Tidak Boleh Kosong!</small>';
            }else{
                if(empty($_POST['deskripsi'])){
                    echo '<small class="text-danger">Setidaknya anda harus menjelaskan mengenai jenis transaksi tersebut untuk mempermudah petugas dalam pencatatan transaksi</small>';
                }else{
                    if(empty($_POST['id_akun_debet'])){
                        echo '<small class="text-danger">Pengaturan Akun Debet Tidak Boleh Kosong!</small>';
                    }else{
                        if(empty($_POST['id_akun_kredit'])){
                            echo '<small class="text-danger">Pengaturan Akun Kredit Tidak Boleh Kosong!</small>';
                        }else{
                            if(empty($_POST['id_transaksi_jenis'])){
                                echo '<small class="text-danger">ID Jenis Transaksi Tidak Boleh Kosong!</small>';
                            }else{
                                $nama=$_POST['nama'];
                                $kategori=$_POST['kategori'];
                                $deskripsi=$_POST['deskripsi'];
                                $id_akun_debet=$_POST['id_akun_debet'];
                                $id_akun_kredit=$_POST['id_akun_kredit'];
                                $id_transaksi_jenis=$_POST['id_transaksi_jenis'];
                                //Membersihhkan Variabel
                                $nama=validateAndSanitizeInput($nama);
                                $kategori=validateAndSanitizeInput($kategori);
                                $deskripsi=validateAndSanitizeInput($deskripsi);
                                $id_akun_debet=validateAndSanitizeInput($id_akun_debet);
                                $id_akun_kredit=validateAndSanitizeInput($id_akun_kredit);
                                $id_transaksi_jenis=validateAndSanitizeInput($id_transaksi_jenis);
                                //Buka Data Lama
                                $NamaLama=GetDetailData($Conn,'transaksi_jenis','id_transaksi_jenis',$id_transaksi_jenis,'nama');
                                //Validasi Duplikat
                                if($NamaLama==$nama){
                                    $ValidasiDuplikat=0;
                                }else{
                                    $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi_jenis WHERE nama='$nama'"));
                                }
                                if(!empty($ValidasiDuplikat)){
                                    echo '<small class="text-danger">Nama/Jenis Transaksi yang digunakan sudah terdaftar!</small>';
                                }else{
                                    //Simpan Ke database
                                    $EntriJenisTransaksi="INSERT INTO transaksi_jenis (
                                        nama,
                                        kategori,
                                        deskripsi,
                                        id_akun_debet,
                                        id_akun_kredit
                                    ) VALUES (
                                        '$nama',
                                        '$kategori',
                                        '$deskripsi',
                                        '$id_akun_debet',
                                        '$id_akun_kredit'
                                    )";
                                    $Update = mysqli_query($Conn,"UPDATE transaksi_jenis SET 
                                        nama='$nama',
                                        kategori='$kategori',
                                        deskripsi='$deskripsi',
                                        id_akun_debet='$id_akun_debet',
                                        id_akun_kredit='$id_akun_kredit'
                                    WHERE id_transaksi_jenis='$id_transaksi_jenis'") or die(mysqli_error($Conn)); 
                                    if($Update){
                                        $KategoriLog="Jenis Transaksi";
                                        $KeteranganLog="Edit Jenis Transaksi";
                                        include "../../_Config/InputLog.php";
                                        echo '<small class="text-success" id="NotifiasiEditBerhasil">Success</small>';
                                    }else{
                                        echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data.</small>';
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