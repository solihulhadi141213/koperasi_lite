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
        if(empty($_POST['kode_perkiraan'])){
            echo '<small class="text-danger">Kode Perkiraan Tidak Boleh Kosong</small>';
        }else{
            if(empty($_POST['d_k'])){
                echo '<small class="text-danger">Posisi Debet/Kredit Tidak Boleh Kosong</small>';
            }else{
                if(empty($_POST['nilai'])){
                    echo '<small class="text-danger">Nilai Jurnal Tidak Boleh Kosong</small>';
                }else{
                    if(empty($_POST['id_jurnal'])){
                        echo '<small class="text-danger">ID Jurnal Tidak Boleh Kosong</small>';
                    }else{
                        //Buat Variabel
                        $id_jurnal=$_POST['id_jurnal'];
                        $kode_perkiraan=$_POST['kode_perkiraan'];
                        $d_k=$_POST['d_k'];
                        $nilai=$_POST['nilai'];
                        //Bersihkan Variabel
                        $kode_perkiraan=validateAndSanitizeInput($kode_perkiraan);
                        $d_k=validateAndSanitizeInput($d_k);
                        $nilai=validateAndSanitizeInput($nilai);
                        //Buka Data Lama Jurnal
                        $uuid=GetDetailData($Conn,'jurnal','id_jurnal',$id_jurnal,'uuid');
                        //Buka Transaksi
                        $tanggal=GetDetailData($Conn,'transaksi','uuid_transaksi',$uuid,'tanggal');
                        //Buka Akun Perkiraan
                        $nama_perkiraan=GetDetailData($Conn,'akun_perkiraan','kode',$kode_perkiraan,'nama');
                        $strtotime=strtotime($tanggal);
                        $TanggalFormat=date('Y-m-d', $strtotime);
                        //Simpan data
                        $Update = mysqli_query($Conn,"UPDATE jurnal SET 
                            tanggal='$TanggalFormat',
                            kode_perkiraan='$kode_perkiraan',
                            nama_perkiraan='$nama_perkiraan',
                            d_k='$d_k',
                            nilai='$nilai'
                        WHERE id_jurnal='$id_jurnal'") or die(mysqli_error($Conn)); 
                        if($Update){
                            $KategoriLog="Transaksi";
                            $KeteranganLog="Update Jurnal Transaksi";
                            include "../../_Config/InputLog.php";
                            echo '<small class="text-success" id="NotifikasiEditJurnalBerhasil">Success</small>';
                        }else{
                            echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data!</span>';
                        }
                    }
                }
            }
        }
    }
?>