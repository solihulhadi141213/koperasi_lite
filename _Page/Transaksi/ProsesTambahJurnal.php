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
        if(empty($_POST['uuid'])){
            echo '<small class="text-danger">UUID Tidak Boleh Kosong</small>';
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
                        //Buat Variabel
                        $uuid=$_POST['uuid'];
                        $kode_perkiraan=$_POST['kode_perkiraan'];
                        $d_k=$_POST['d_k'];
                        $nilai=$_POST['nilai'];
                        //Bersihkan Variabel
                        $uuid=validateAndSanitizeInput($uuid);
                        $kode_perkiraan=validateAndSanitizeInput($kode_perkiraan);
                        $d_k=validateAndSanitizeInput($d_k);
                        $nilai=validateAndSanitizeInput($nilai);
                        //Buka Transaksi
                        $id_transaksi=GetDetailData($Conn,'transaksi','uuid_transaksi',$uuid,'id_transaksi');
                        $tanggal=GetDetailData($Conn,'transaksi','uuid_transaksi',$uuid,'tanggal');
                        //Buka Akun Perkiraan
                        $nama_perkiraan=GetDetailData($Conn,'akun_perkiraan','kode',$kode_perkiraan,'nama');
                        $strtotime=strtotime($tanggal);
                        $TanggalFormat=date('Y-m-d', $strtotime);
                        //Simpan data
                        $EntryData="INSERT INTO jurnal (
                            kategori,
                            uuid,
                            id_transaksi,
                            tanggal,
                            kode_perkiraan,
                            nama_perkiraan,
                            d_k,
                            nilai
                        ) VALUES (
                            'Transaksi',
                            '$uuid',
                            '$id_transaksi',
                            '$TanggalFormat',
                            '$kode_perkiraan',
                            '$nama_perkiraan',
                            '$d_k',
                            '$nilai'
                        )";
                        $InputData=mysqli_query($Conn, $EntryData);
                        if($InputData){
                            $KategoriLog="Transaksi";
                            $KeteranganLog="Tambah Jurnal Transaksi";
                            include "../../_Config/InputLog.php";
                            echo '<small class="text-success" id="NotifikasiTambahJurnalBerhasil">Success</small>';
                        }else{
                            echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data!</span>';
                        }
                    }
                }
            }
        }
    }
?>