<?php
    //koneksi dan session
    session_start();
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    //Validasi id_simpanan_jenis tidak boleh kosong
    if(empty($_POST['uuid_simpanan'])){
        echo '
            <div class="alert alert-danger">
                UUID Simpanan Tidak Boleh Kosong!
            </div>
        ';
    }else{
        $uuid_simpanan=$_POST['uuid_simpanan'];

        //Validasi Keberadaan Data
        $ValidasiData = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan FROM simpanan WHERE uuid_simpanan='$uuid_simpanan'"));
        if(empty($ValidasiData)){
            echo '
                <div class="alert alert-danger">
                    Data Pembayaran Tersebut Tidak Ditemukan
                </div>
            ';
        }else{
            //Status Simpanan
            $status=GetDetailData($Conn,'simpanan','uuid_simpanan',$uuid_simpanan,'status');

            //Apabila Lunas Tidak Bisa
            if($status=="Lunas"){
                echo '
                    <div class="alert alert-danger">
                        Pembayaran sudah lunas! Anda tidak bisa membatalkan pembayaran ini. Silahkan lakukan reload halaman.
                    </div>
                ';
            }else{
                //Hapus Data
                $HapusSimpanan = mysqli_query($Conn, "DELETE FROM simpanan WHERE uuid_simpanan='$uuid_simpanan'") or die(mysqli_error($Conn));
                if($HapusSimpanan) {
                    $_SESSION["NotifikasiSwal"] = "Pembatalan Pembayaran Berhasil";
                    echo '<small class="text-success" id="NotifikasiPembatalanBerhasil">Success</small>';
                }else{
                    //Jika Gagal
                     echo '
                        <div class="alert alert-danger">
                            Terjadi kesalahan pada saat menghapus data!
                        </div>
                    ';
                }
            }
        }
    }
?>