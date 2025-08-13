<?php
    //koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    //Mencari Data Penarikan Dana Yang Pending
    $JumlahPengajuanPenarikan = mysqli_num_rows(mysqli_query($Conn, "SELECT id_simpanan_penarikan FROM simpanan_penarikan WHERE status='Pending'"));
    if(empty($JumlahPengajuanPenarikan)){
        echo '
            <div class="alert alert-success">
                <small>
                    <i class="bi bi-check-circle"></i> Tidak ada pengajuan penarikan dana untuk saat ini. Semua pengajuan penarikan dana sudah diproses.
                </small>
            </div>
        ';
    }else{
        echo '
            <div class="alert alert-danger">
                <small>Anda memiliki <b>'.$JumlahPengajuanPenarikan.' pengajuan</b> penarikan dana simpanan. Silahkan lakukan verifikasi pengajuan dan selesaikan transaksi.</small>
            </div>
        ';
    }
?>