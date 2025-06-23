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
        if(empty($_POST['id_pinjaman'])){
            echo '<span class="text-danger">ID Transaksi Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['id_perkiraan'])){
                echo '<span class="text-danger">ID Perkiraan Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['d_k'])){
                    echo '<span class="text-danger">Debet Kredit Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['nominal_pinjaman'])){
                        echo '<span class="text-danger">Nilai Saldo Jurnal Tidak Boleh Kosong!</span>';
                    }else{
                        $id_pinjaman=$_POST['id_pinjaman'];
                        $id_perkiraan=$_POST['id_perkiraan'];
                        $d_k=$_POST['d_k'];
                        $nominal_pinjaman=$_POST['nominal_pinjaman'];
                        $nominal_pinjaman= str_replace(",", "", $nominal_pinjaman);
                        if(!preg_match("/^[0-9]*$/", $nominal_pinjaman)){
                            echo '<span class="text-danger">Nilai Jurnal Hanya Boleh Angka!</span>';
                        }else{
                            //Bersihkan Variabel
                            $id_pinjaman=validateAndSanitizeInput($id_pinjaman);
                            $id_perkiraan=validateAndSanitizeInput($id_perkiraan);
                            $d_k=validateAndSanitizeInput($d_k);
                            $nominal_pinjaman=validateAndSanitizeInput($nominal_pinjaman);
                            //Membuka Detail Pinjaman
                            $uuid_pinjaman=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'uuid_pinjaman');
                            $tanggal=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'tanggal');
                            //Buka Akun Perkiraan
                            $kode=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kode');
                            $nama=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'nama');
                            //Validasi Duplikat
                            $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE uuid='$uuid_pinjaman' AND kategori='Pinjaman' AND kode_perkiraan='$kode'"));
                            if(!empty($ValidasiDuplikat)){
                                echo '<span class="text-danger">Akun perkiraan untuk pinjaman tersebut sudah terdaftar</span>';
                            }else{
                                //Simpan data
                                $EntryData="INSERT INTO jurnal (
                                    kategori,
                                    uuid,
                                    id_pinjaman,
                                    tanggal,
                                    kode_perkiraan,
                                    nama_perkiraan,
                                    d_k,
                                    nilai
                                ) VALUES (
                                    'Pinjaman',
                                    '$uuid_pinjaman',
                                    '$id_pinjaman',
                                    '$tanggal',
                                    '$kode',
                                    '$nama',
                                    '$d_k',
                                    '$nominal_pinjaman'
                                )";
                                $InputData=mysqli_query($Conn, $EntryData);
                                if($InputData){
                                    $KategoriLog="Pinjaman";
                                    $KeteranganLog="Tambah Jurnal Pinjaman Berhasil";
                                    include "../../_Config/InputLog.php";
                                    echo '<small class="text-success" id="NotifikasiTambahJurnalPinjamanBerhasil">Success</small>';
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