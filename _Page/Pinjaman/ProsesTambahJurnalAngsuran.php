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
        if(empty($_POST['id_pinjaman_angsuran'])){
            echo '<span class="text-danger">ID Transaksi Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['id_perkiraan'])){
                echo '<span class="text-danger">ID Perkiraan Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['d_k'])){
                    echo '<span class="text-danger">Debet Kredit Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['nominal_angsuran'])){
                        echo '<span class="text-danger">Nilai Saldo Jurnal Tidak Boleh Kosong!</span>';
                    }else{
                        $id_pinjaman_angsuran=$_POST['id_pinjaman_angsuran'];
                        $id_perkiraan=$_POST['id_perkiraan'];
                        $d_k=$_POST['d_k'];
                        $nominal_angsuran=$_POST['nominal_angsuran'];
                        $nominal_angsuran= str_replace(",", "", $nominal_angsuran);
                        if(!preg_match("/^[0-9]*$/", $nominal_angsuran)){
                            echo '<span class="text-danger">Nilai Jurnal Hanya Boleh Angka!</span>';
                        }else{
                            //Bersihkan Variabel
                            $id_pinjaman_angsuran=validateAndSanitizeInput($id_pinjaman_angsuran);
                            $id_perkiraan=validateAndSanitizeInput($id_perkiraan);
                            $d_k=validateAndSanitizeInput($d_k);
                            $nominal_angsuran=validateAndSanitizeInput($nominal_angsuran);
                            //Membuka Detail angsuran
                            $uuid_angsuran=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'uuid_angsuran');
                            $tanggal=GetDetailData($Conn,'pinjaman_angsuran','id_pinjaman_angsuran',$id_pinjaman_angsuran,'tanggal_bayar');
                            //Buka Akun Perkiraan
                            $kode=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'kode');
                            $nama=GetDetailData($Conn,'akun_perkiraan','id_perkiraan',$id_perkiraan,'nama');
                            //Validasi Duplikat
                            $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM jurnal WHERE uuid='$uuid_angsuran' AND kategori='Angsuran' AND kode_perkiraan='$kode'"));
                            if(!empty($ValidasiDuplikat)){
                                echo '<span class="text-danger">Akun perkiraan untuk pinjaman tersebut sudah terdaftar</span>';
                            }else{
                                //Simpan data
                                $EntryData="INSERT INTO jurnal (
                                    kategori,
                                    uuid,
                                    id_pinjaman_angsuran,
                                    tanggal,
                                    kode_perkiraan,
                                    nama_perkiraan,
                                    d_k,
                                    nilai
                                ) VALUES (
                                    'Angsuran',
                                    '$uuid_angsuran',
                                    '$id_pinjaman_angsuran',
                                    '$tanggal',
                                    '$kode',
                                    '$nama',
                                    '$d_k',
                                    '$nominal_angsuran'
                                )";
                                $InputData=mysqli_query($Conn, $EntryData);
                                if($InputData){
                                    $KategoriLog="Angsuran";
                                    $KeteranganLog="Tambah Jurnal Angsuran Berhasil";
                                    include "../../_Config/InputLog.php";
                                    echo '<small class="text-success" id="NotifikasiTambahJurnalAngsuranBerhasil">Success</small>';
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