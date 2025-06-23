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
        //Validasi tanggal tidak boleh kosong
        if(empty($_POST['id_simpanan'])){
            echo '<small class="text-danger">ID Simpanan Tidak Boleh Kosong!</small>';
        }else{
            //Validasi tanggal tidak boleh kosong
            if(empty($_POST['tanggal'])){
                echo '<small class="text-danger">Tanggal Simpanan Tidak Boleh Kosong!</small>';
            }else{
                //Validasi jumlah tidak boleh kosong
                if(empty($_POST['jumlah'])){
                    echo '<small class="text-danger">Jumlah Simpanan Tidak Boleh Kosong!</small>';
                }else{
                    $id_simpanan=$_POST['id_simpanan'];
                    $tanggal=$_POST['tanggal'];
                    $jumlah=$_POST['jumlah'];
                    //Bersihkan Variabel
                    $id_simpanan=validateAndSanitizeInput($id_simpanan);
                    $tanggal=validateAndSanitizeInput($tanggal);
                    $jumlah=validateAndSanitizeInput($jumlah);
                    //Buka UIID Simpanan
                    $uuid_simpanan=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'uuid_simpanan');
                    //Cek Apakah ID Perkiraan Ada Pada Data Akun Perkiraan
                    $id_perkiraan_debet=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_debet,'id_perkiraan');
                    $id_perkiraan_kredit=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan_kredit,'id_perkiraan');
                    if(empty($id_perkiraan_debet)){
                        echo '<small class="text-danger">Periksa pengaturan akun debet pada jenis simpanan yang anda gunakkkan!</small>';
                    }else{
                        if(empty($id_perkiraan_kredit)){
                            echo '<small class="text-danger">Periksa pengaturan akun kredit pada jenis simpanan yang anda gunakkkan!</small>';
                        }else{
                            $UpdateSimpanan = mysqli_query($Conn,"UPDATE simpanan SET 
                                tanggal='$tanggal',
                                jumlah='$jumlah'
                            WHERE id_simpanan='$id_simpanan'") or die(mysqli_error($Conn)); 
                            if($UpdateSimpanan){
                                $UpdateJurnal = mysqli_query($Conn,"UPDATE jurnal SET 
                                    tanggal='$tanggal',
                                    nilai='$jumlah'
                                WHERE uuid='$uuid_simpanan'") or die(mysqli_error($Conn)); 
                                if($UpdateJurnal){
                                    $KategoriLog="Simpanan Wajib";
                                    $KeteranganLog="Edit Simpanan Wajib";
                                    include "../../_Config/InputLog.php";
                                    echo '<small class="text-success" id="NotifikasiEditSimpananBerhasil">Success</small>';
                                }else{
                                    echo '<small class="text-danger">Terjadi kesalahan pada saat update jurnal.</small>';
                                }
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