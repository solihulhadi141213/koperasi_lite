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
        //Validasi nama_simpanan tidak boleh kosong
        if(empty($_POST['nama_simpanan'])){
            echo '<small class="text-danger">Nama Jenis Simpanan Tidak Boleh Kosong!</small>';
        }else{
            //Validasi id_perkiraan_debet tidak boleh kosong
            if(empty($_POST['id_perkiraan_debet'])){
                echo '<small class="text-danger">Akun Perkiraan Debet Tidak Boleh Kosong!</small>';
            }else{
                //Validasi id_perkiraan_kredit tidak boleh kosong
                if(empty($_POST['id_perkiraan_kredit'])){
                    echo '<small class="text-danger">Akun Perkiraan Kredit Tidak Boleh Kosong!</small>';
                }else{
                    //Validasi rutin tidak boleh kosong
                    if(empty($_POST['rutin'])){
                        $rutin=0;
                        $nominal=0;
                    }else{
                        $rutin=$_POST['rutin'];
                        if(empty($_POST['nominal'])){
                            $nominal=0;
                        }else{
                            $nominal = str_replace('.', '', $_POST['nominal']);
                        }
                    }
                    if(empty($_POST['keterangan'])){
                        $keterangan="";
                    }else{
                        $keterangan=$_POST['keterangan'];
                    }
                    $nama_simpanan=$_POST['nama_simpanan'];
                    $id_perkiraan_debet=$_POST['id_perkiraan_debet'];
                    $id_perkiraan_kredit=$_POST['id_perkiraan_kredit'];
                    //Bersihkan Variabel
                    $rutin=validateAndSanitizeInput($rutin);
                    $nama_simpanan=validateAndSanitizeInput($nama_simpanan);
                    $id_perkiraan_debet=validateAndSanitizeInput($id_perkiraan_debet);
                    $id_perkiraan_kredit=validateAndSanitizeInput($id_perkiraan_kredit);
                    $keterangan=validateAndSanitizeInput($keterangan);
                    //Validasi Duplikat
                    $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan_jenis WHERE nama_simpanan='$nama_simpanan'"));
                    if(!empty($ValidasiDuplikat)){
                        echo '<small class="text-danger">Nama/Jenis Simpanan yang digunakan sudah terdaftar!</small>';
                    }else{
                        $JumlahKarakter=strlen($_POST['nama_simpanan']);
                        if($JumlahKarakter>30){
                            echo '<small class="text-danger">Nama/Jenis simpanan maksimal 30 karakter numerik</small>';
                        }else{
                            $EntryAnggota="INSERT INTO simpanan_jenis (
                                nama_simpanan,
                                keterangan,
                                rutin,
                                nominal,
                                id_perkiraan_debet,
                                id_perkiraan_kredit
                            ) VALUES (
                                '$nama_simpanan',
                                '$keterangan',
                                '$rutin',
                                '$nominal',
                                '$id_perkiraan_debet',
                                '$id_perkiraan_kredit'
                            )";
                            $InputAnggota=mysqli_query($Conn, $EntryAnggota);
                            if($InputAnggota){
                                $KategoriLog="Jenis Simpanan";
                                $KeteranganLog="Tambah Jenis Simpanan";
                                include "../../_Config/InputLog.php";
                                echo '<small class="text-success" id="NotifikasiTambahJenisSimpananBerhasil">Success</small>';
                            }else{
                                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data.</small>';
                            }
                        }
                    }
                }
            }
        }
    }
?>