<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";
    //Menangkap Data
    if(empty($SessionIdAkses)){
        echo '<code class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</code>';
    }else{
        if(empty($_POST['id_jurnal'])){
            echo '<span class="text-danger">ID Transaksi Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['id_perkiraan'])){
                echo '<span class="text-danger">ID Perkiraan Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['d_k'])){
                    echo '<span class="text-danger">Debet Kredit Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['nominal_angsuran_edit'])){
                        echo '<span class="text-danger">Nilai Saldo Jurnal Tidak Boleh Kosong!</span>';
                    }else{
                        $id_jurnal=$_POST['id_jurnal'];
                        $id_perkiraan=$_POST['id_perkiraan'];
                        $d_k=$_POST['d_k'];
                        $nominal_angsuran_edit=$_POST['nominal_angsuran_edit'];
                        $nominal_angsuran_edit= str_replace(",", "", $nominal_angsuran_edit);
                        if(!preg_match("/^[0-9]*$/", $nominal_angsuran_edit)){
                            echo '<span class="text-danger">Nilai Jurnal Hanya Boleh Angka!</span>';
                        }else{
                            //Bersihkan Variabel
                            $id_jurnal=validateAndSanitizeInput($id_jurnal);
                            $id_perkiraan=validateAndSanitizeInput($id_perkiraan);
                            $d_k=validateAndSanitizeInput($d_k);
                            $nominal_angsuran_edit=validateAndSanitizeInput($nominal_angsuran_edit);
                            //Buka Akun Perkiraan
                            $kode=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kode');
                            $nama=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'nama');
                            $UpdateJurnal = mysqli_query($Conn,"UPDATE jurnal SET 
                                kode_perkiraan='$kode',
                                nama_perkiraan='$nama',
                                d_k='$d_k',
                                nilai='$nominal_angsuran_edit'
                            WHERE id_jurnal='$id_jurnal'") or die(mysqli_error($Conn)); 
                            if($UpdateJurnal){
                                $KategoriLog="Angsuran";
                                $KeteranganLog="Edit Jurnal Angsuran Berhasil";
                                include "../../_Config/InputLog.php";
                                echo '<small class="text-success" id="NotifikasiEditJurnalAngsuranBerhasil">Success</small>';
                            }else{
                                echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data jurnal!</span>';
                            }
                        }
                    }
                }
            }
        }   
    }   
?>