<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    //Validasi id_simpanan_jenis tidak boleh kosong
    if(empty($_POST['id_simpanan_jenis'])){
        echo '
            <div class="alert alert-danger">
                Jenis Simpanan Tidak Boleh Kosong!
            </div>
        ';
    }else{
        if(empty($_POST['id_anggota'])){
            echo '
                <div class="alert alert-danger">
                    ID Anggota Tidak Boleh Kosong!
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
                if(empty($_POST['periode'])){
                    echo '
                        <div class="alert alert-danger">
                            Periode Pembayaran Tidak Boleh Kosong!
                        </div>
                    ';
                }else{
                    $id_simpanan_jenis=$_POST['id_simpanan_jenis'];
                    $id_anggota=$_POST['id_anggota'];
                    $metode_pembayaran=$_POST['metode_pembayaran'];
                    $periode=$_POST['periode'];

                    $periode=date('Y-m-d',strtotime($periode));
                    
                    //Validasi Pembayaran Tidak Duplikat
                    $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan FROM simpanan WHERE id_simpanan_jenis='$id_simpanan_jenis' AND id_anggota='$id_anggota' AND tanggal_simpanan='$periode'"));
                    if(!empty($ValidasiDuplikat)){
                        echo '
                            <div class="alert alert-danger">
                                Data Pembayaran Sudah Ada. Silahkan Selesaikan Pembayaran Tersebut!
                            </div>
                        ';
                    }else{
                        //Buka Jenis Simpanan
                        $nama_simpanan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nama_simpanan');
                        $keterangan=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'keterangan');
                        $kategori=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'kategori');
                        $nominal=GetDetailData($Conn,'simpanan_jenis','id_simpanan_jenis',$id_simpanan_jenis,'nominal');
                        $nominal_Format = "Rp " . number_format($nominal,0,',','.');

                        //Nama Anggota
                        $nama_anggota=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nama');
                        $tanggal_masuk=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'tanggal_masuk');
                        $nip=GetDetailData($Conn,'anggota','id_anggota',$id_anggota,'nip');
                        
                        //Inisiasi Variabel Lainnya
                        $uuid_simpanan=GenerateKodeBarang(9);
                        $tanggal_simpanan=$tanggal_masuk;
                        $tanggal_bayar=date('Y-m-d H:i:s');
                        $status="Pending";

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
                            '$id_anggota',
                            '$id_simpanan_jenis',
                            '$nip',
                            '$nama_anggota',
                            '$periode',
                            '$tanggal_bayar',
                            '$kategori',
                            '$nominal',
                            '$metode_pembayaran',
                            '$status'
                        )";
                        $InputSimpananWajib=mysqli_query($Conn, $EntrySimpanan);
                        if($InputSimpananWajib){
                            echo '
                                <input type="hidden" id="get_uuide_simpanan_wajib" value="'.$uuid_simpanan.'">
                                <div class="alert alert-success">
                                    <span id="NotifikasiBayarSimpananWajibBerhasil">Success</span>
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
    }
?>