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
            //Validasi Foto tidak boleh kosong
            if(empty($_FILES['foto']['name'])){
                echo '<code class="text-danger">Foto tidak boleh kosong</code>';
            }else{
                //Buat Variabel
                $id_anggota=$_POST['id_anggota'];
                //Foto Lama
                $FotoLama=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'foto');
                $LokasiFotoLama = "../../assets/img/Anggota/".$FotoLama;
                //Bersihkan Variabel
                $id_anggota=validateAndSanitizeInput($id_anggota);
                //Menangkap File Dari Form
                $nama_gambar=$_FILES['foto']['name'];
                $ukuran_gambar = $_FILES['foto']['size']; 
                $tipe_gambar = $_FILES['foto']['type']; 
                $tmp_gambar = $_FILES['foto']['tmp_name'];
                //Membuat Nama File Baru
                $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
                $key=implode('', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
                $FileNameRand=$key;
                $Pecah = explode("." , $nama_gambar);
                $BiasanyaNama=$Pecah[0];
                $Ext=$Pecah[1];
                $namabaru = "$FileNameRand.$Ext";
                //Menentukan Lokasi Penyimpanan
                $path = "../../assets/img/Anggota/".$namabaru;
                //Validasi Tipe File
                if($tipe_gambar == "image/jpeg"||$tipe_gambar == "image/jpg"||$tipe_gambar == "image/gif"||$tipe_gambar == "image/png"){
                    //Validasi Ukuran
                    if($ukuran_gambar<2000000){
                        //Melakukan Upload
                        if(move_uploaded_file($tmp_gambar, $path)){
                            if(!empty($FotoLama)){
                                if (file_exists($LokasiFotoLama)) {
                                    if (unlink($LokasiFotoLama)) {
                                        $ValidasiGambar="Valid";
                                    } else {
                                        $ValidasiGambar="Terjadi Kesalahan Pada Saat Menghapus File Foto Sebelumnya";
                                    }
                                }else{
                                    $ValidasiGambar="Valid";
                                }
                            }else{
                                $ValidasiGambar="Valid";
                            }
                        }else{
                            $ValidasiGambar="Upload file gambar gagal";
                        }
                    }else{
                        $ValidasiGambar="File gambar tidak boleh lebih dari 2 mb";
                    }
                }else{
                    $ValidasiGambar="tipe file hanya boleh JPG, JPEG, PNG and GIF";
                }
                //Apabila validasi upload valid maka simpan di database
                if($ValidasiGambar!=="Valid"){
                    echo '<small class="text-danger">'.$ValidasiGambar.'</small>';
                }else{
                    $UpdateAnggota = mysqli_query($Conn,"UPDATE anggota SET 
                        foto='$namabaru'
                    WHERE id_anggota='$id_anggota'") or die(mysqli_error($Conn)); 
                    if($UpdateAnggota){
                        $kategori_log="Anggota";
                        $deskripsi_log="Ubah Foto Anggota";
                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                        if($InputLog=="Success"){
                            echo '<small class="text-success" id="NotifikasiUbahFotoAnggotaBerhasil">Success</small>';
                        }else{
                            echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan log</small>';
                        }
                    }else{
                        echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data anggota</small>';
                    }
                }
            }
        }
    }
?>