<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Validasi Sesi Akses
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                Sesi Akses Sudah Berakhir, Silahkan Login Ulang!
            </div>
        ';
    }else{
        //Validasi id_simpanan_jenis tidak boleh kosong
        if(empty($_POST['id_simpanan_jenis'])){
            echo '
                <div class="alert alert-danger">
                    Jenis Simpanan Tidak Boleh Kosong!
                </div>
            ';
        }else{
            if(empty($_POST['nominal_simpanan_sukarela'])){
                echo '
                    <div class="alert alert-danger">
                       Nominal Simpanan Tidak Boleh Kosong!
                    </div>
                ';
            }else{
                if(empty($_POST['metode_pembayaran'])){
                    echo '
                        <div class="alert alert-danger">
                            Metode Pembayaran Tidak Boleh Kosong!
                        </div>
                    ';
                }else{
                    $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
                    $nominal_simpanan_sukarela=$_POST['nominal_simpanan_sukarela'];
                    $metode_pembayaran=$_POST['metode_pembayaran'];
                    $tanggal_simpanan=date('Y-m-d');
                    $tanggal_bayar=date('Y-m-d H:i:s');
                    $status="Pending";

                    //Nama Anggota
                    $nama_anggota=GetDetailData($Conn,'anggota','id_anggota',$SessionIdAkses,'nama');
                    $nip=GetDetailData($Conn,'anggota','id_anggota',$SessionIdAkses,'nip');

                    //Buka simpanan jenis
                    $kategori=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'kategori');
                          
                    //Inisiasi Variabel Lainnya
                    $uuid_simpanan=GenerateKodeBarang(9);

                    //Simpan Data Ke Database
                    $EntrySimpanan="INSERT INTO simpanan (
                        uuid_simpanan,
                        id_anggota,
                        id_simpanan_jenis,
                        nip,
                        nama,
                        tanggal_simpanan,
                        tanggal_bayar,
                        kategori,
                        jumlah, 
                        metode_pembayaran, 
                        status
                    ) VALUES (
                        '$uuid_simpanan',
                        '$SessionIdAkses',
                        '$id_simpanan_jenis',
                        '$nip',
                        '$nama_anggota',
                        '$tanggal_simpanan',
                        '$tanggal_bayar',
                        '$kategori',
                        '$nominal_simpanan_sukarela',
                        '$metode_pembayaran',
                        '$status'
                    )";
                    $InputSimpananWajib=mysqli_query($Conn, $EntrySimpanan);
                    if($InputSimpananWajib){
                        echo '
                            <input type="hidden" id="get_uuide_simpanan_sukarela" value="'.$uuid_simpanan.'">
                            <div class="alert alert-success">
                                <span id="NotifikasiTambahSimpananSukarelaBerhasil">Success</span>
                            </div>
                        ';
                    }else{
                        echo '
                            <div class="alert alert-danger">
                                Terjadi Kesalahan Pada Saat Menyimpan Data Simpanan Anggota
                            </div>
                        ';
                    }
                }
            }
        }
    }
?>