<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    //Menangkap Data
    if(empty($SessionIdAkses)){
        echo '<small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</small>';
    }else{
        if(empty($_POST['kategori'])){
            echo '<small class="text-danger">Kategori Tidak Boleh Kosong!</small>';
        }else{
            if(empty($_POST['id_perkiraan'])){
                echo '<small class="text-danger">ID Perkiraan Tidak Boleh Kosong!</small>';
            }else{
                if(empty($_POST['d_k'])){
                    echo '<small class="text-danger">Debet Kredit Tidak Boleh Kosong!</small>';
                }else{
                    if(empty($_POST['nominal'])){
                        echo '<small class="text-danger">Nilai Saldo Jurnal Tidak Boleh Kosong!</small>';
                    }else{
                        if(empty($_POST['tanggal'])){
                            echo '<small class="text-danger">Tanggal Tidak Boleh Kosong!</small>';
                        }else{
                            if(empty($_POST['uuid'])){
                                echo '<small class="text-danger">Kode UUID Transaksi Tidak Boleh Kosong!</small>';
                            }else{
                                if(empty($_POST['id_jurnal'])){
                                    echo '<small class="text-danger">ID Jurnal Tidak Boleh Kosong!</small>';
                                }else{
                                    $id_jurnal=$_POST['id_jurnal'];
                                    $kategori=$_POST['kategori'];
                                    $uuid=$_POST['uuid'];
                                    $tanggal=$_POST['tanggal'];
                                    $id_perkiraan=$_POST['id_perkiraan'];
                                    $d_k=$_POST['d_k'];
                                    $nominal=$_POST['nominal'];
                                    $nominal= str_replace(".", "", $nominal);
                                    if(!preg_match("/^[0-9]*$/", $nominal)){
                                        echo '<small class="text-danger">Nilai Jurnal Hanya Boleh Angka!</small>';
                                    }else{
                                        // Validasi panjang maksimal 36 karakter
                                        if (strlen($uuid) > 36) {
                                            echo '<small class="text-danger">Referensi transaksi tidak boleh lebih dari 36 karakter</small>';
                                        }else{
                                            //Bersihkan Variabel
                                            $id_jurnal=validateAndSanitizeInput($id_jurnal);
                                            $kategori=validateAndSanitizeInput($kategori);
                                            $uuid=validateAndSanitizeInput($uuid);
                                            $tanggal=validateAndSanitizeInput($tanggal);
                                            $id_perkiraan=validateAndSanitizeInput($id_perkiraan);
                                            $d_k=validateAndSanitizeInput($d_k);
                                            $nominal=validateAndSanitizeInput($nominal);
                                            //Buka Akun Perkiraan
                                            $kode=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kode');
                                            $nama=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'nama');
                                            //Simpan data
                                            $UpdateJurnal = mysqli_query($Conn,"UPDATE jurnal SET 
                                                kategori='$kategori',
                                                uuid='$uuid',
                                                tanggal='$tanggal',
                                                kode_perkiraan='$kode',
                                                nama_perkiraan='$nama',
                                                d_k='$d_k',
                                                nilai='$nominal'
                                            WHERE id_jurnal='$id_jurnal'") or die(mysqli_error($Conn)); 
                                            if($UpdateJurnal){
                                                $KategoriLog="Jurnal";
                                                $KeteranganLog="Edit Jurnal Berhasil";
                                                include "../../_Config/InputLog.php";
                                                echo '<small class="text-success" id="NotifikasiEditJurnalBerhasil">Success</small>';
                                            }else{
                                                echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data transaksi!</small>';
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