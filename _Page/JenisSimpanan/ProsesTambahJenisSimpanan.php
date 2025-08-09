<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');

    //Validasi Sesi akses
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sessi Akses Sudah Berakhir, Silahkan Login Ulang!</small>';
    }else{
        
        //Validasi nama_simpanan tidak boleh kosong
        if(empty($_POST['nama_simpanan'])){
            echo '<small class="text-danger">Nama Jenis Simpanan Tidak Boleh Kosong!</small>';
        }else{
            
            //Validasi kategori simpanan tidak boleh kosong
            if(empty($_POST['kategori'])){
                echo '<small class="text-danger">Kategori Simpanan Tidak Boleh Kosong!</small>';
            }else{
                //Buat Variabel
                $nama_simpanan=$_POST['nama_simpanan'];
                $kategori=$_POST['kategori'];

                //Buat Variabel nominal
                if(empty($_POST['nominal'])){
                    $nominal=0;
                }else{
                    $nominal = str_replace('.', '', $_POST['nominal']);
                }

                //Buat Variabel Keterangan
                if(empty($_POST['keterangan'])){
                    $keterangan="";
                }else{
                    $keterangan=$_POST['keterangan'];
                }
            
                //Bersihkan Variabel
                $nama_simpanan=validateAndSanitizeInput($nama_simpanan);
                $kategori=validateAndSanitizeInput($kategori);
                $nominal=validateAndSanitizeInput($nominal);
                $keterangan=validateAndSanitizeInput($keterangan);
                
                //Validasi Duplikat
                $ValidasiDuplikat=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM simpanan_jenis WHERE nama_simpanan='$nama_simpanan'"));
                if(!empty($ValidasiDuplikat)){
                    echo '<small class="text-danger">Nama/Jenis Simpanan yang digunakan sudah terdaftar!</small>';
                }else{

                    //Validasi Jumlah Karakter
                    $JumlahKarakter=strlen($_POST['nama_simpanan']);
                    if($JumlahKarakter>255){
                        echo '<small class="text-danger">Nama/Jenis simpanan maksimal 255 karakter</small>';
                    }else{

                        //Simpan Data
                        $EntryAnggota="INSERT INTO simpanan_jenis (
                            nama_simpanan,
                            keterangan,
                            kategori,
                            nominal
                        ) VALUES (
                            '$nama_simpanan',
                            '$keterangan',
                            '$kategori',
                            '$nominal'
                        )";
                        $InputAnggota=mysqli_query($Conn, $EntryAnggota);
                        if($InputAnggota){
                            echo '<small class="text-success" id="NotifikasiTambahJenisSimpananBerhasil">Success</small>';
                        }else{
                            echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data.</small>';
                        }
                    }
                }
            }
        }
    }
?>