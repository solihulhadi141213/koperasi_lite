<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/Session.php";

    //Waktu Sekarang
    $now=date('Y-m-d H:i:s');

    //Menangkap Data
    if(empty($SessionIdAkses)){
        echo '<code class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang</code>';
    }else{
        if(empty($_POST['id_simpanan'])){
            echo '<span class="text-danger">ID Transaksi Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['id_perkiraan'])){
                echo '<span class="text-danger">ID Perkiraan Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['d_k'])){
                    echo '<span class="text-danger">Debet Kredit Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['nominal_jurnal_simpanan'])){
                        echo '<span class="text-danger">Nilai Saldo Jurnal Tidak Boleh Kosong!</span>';
                    }else{
                        $id_simpanan=$_POST['id_simpanan'];
                        $id_perkiraan=$_POST['id_perkiraan'];
                        $d_k=$_POST['d_k'];
                        $nominal_jurnal_simpanan=$_POST['nominal_jurnal_simpanan'];
                        $nominal_jurnal_simpanan= str_replace(",", "", $nominal_jurnal_simpanan);
                        if(!preg_match("/^[0-9]*$/", $nominal_jurnal_simpanan)){
                            echo '<span class="text-danger">Nilai Jurnal Hanya Boleh Angka!</span>';
                        }else{
                            //Bersihkan Variabel
                            $id_simpanan=validateAndSanitizeInput($id_simpanan);
                            $id_perkiraan=validateAndSanitizeInput($id_perkiraan);
                            $d_k=validateAndSanitizeInput($d_k);
                            $nominal_jurnal_simpanan=validateAndSanitizeInput($nominal_jurnal_simpanan);
                            //Membuka Detail Simpanan
                            $uuid_simpanan=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'uuid_simpanan');
                            $tanggal=GetDetailData($Conn,'simpanan','id_simpanan',$id_simpanan,'tanggal');
                            //Buka Akun Perkiraan
                            $kode=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kode');
                            $nama=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'nama');
                            //Validasi Duplikat
                            $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE uuid='$uuid_simpanan' AND kategori='Simpanan' AND kode_perkiraan='$kode'"));
                            if(!empty($ValidasiDuplikat)){
                                echo '<span class="text-danger">Akun perkiraan untuk simpanan tersebut sudah terdaftar</span>';
                            }else{
                                //Simpan data
                                $EntryData="INSERT INTO jurnal (
                                    kategori,
                                    uuid,
                                    id_simpanan,
                                    tanggal,
                                    kode_perkiraan,
                                    nama_perkiraan,
                                    d_k,
                                    nilai
                                ) VALUES (
                                    'Simpanan',
                                    '$uuid_simpanan',
                                    '$id_simpanan',
                                    '$tanggal',
                                    '$kode',
                                    '$nama',
                                    '$d_k',
                                    '$nominal_jurnal_simpanan'
                                )";
                                $InputData=mysqli_query($Conn, $EntryData);
                                if($InputData){
                                    $kategori_log="Simpanan";
                                    $deskripsi_log="Tambah Manual Jurnal Simpanan";
                                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                    if($InputLog=="Success"){
                                        echo '<small class="text-success" id="NotifikasiTambahJurnalSimpananBerhasil">Success</small>';
                                    }else{
                                        echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan log</small>';
                                    }
                                    
                                }else{
                                    echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data transaksi!</span>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>