<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    //Zona waktu
    date_default_timezone_set('Asia/Jakarta');

    //Time Now Tmp
    $now=date('Y-m-d');

    //Validasi id_pinjaman_angsuran tidak boleh kosong
    if(empty($_POST['id_pinjaman_angsuran'])){
        echo '
            <div class="alert alert-danger">
                ID Angsuran Pinjaman Tidak Boleh Kosong!
            </div>
        ';
    }else{
        //Buat Variabel
        $id_pinjaman_angsuran=$_POST['id_pinjaman_angsuran'];

        //Update Data Angsuran
        $UpdateStatusAngsuran = mysqli_query($Conn,"UPDATE pinjaman_angsuran SET 
            kode_pembayaran='',
            metode_pembayaran='',
            tanggal_bayar='$now',
            status='None'
        WHERE id_pinjaman_angsuran='$id_pinjaman_angsuran'") or die(mysqli_error($Conn)); 
        if($UpdateStatusAngsuran){
            echo '
                <div class="alert alert-success">
                    <small id="NotifikasiPembatalanPembayaranBerhasil">Success</small>
                </div>
            ';
        }else{
            echo '
                <div class="alert alert-danger">
                    Terjadi kesalahan pada saat melakukan update angsuran!
                </div>
            ';
        }
    }
?>