<?php
    //Connection
    include "../../_Config/Connection.php";
    include "../../_Config/globalFunction.php";
    include "../../_Config/Session.php";
    $now=date('Y-m-d H:i:s');
    if(empty($_POST['id_pinjaman'])){
        echo '
            <div class="alert alert-danger">
                <small>Tidak Ada Data Pengajuan Pinjaman Yang Dipilih</small>
            </div>
        ';
    }else{
        $id_pinjaman=$_POST['id_pinjaman'];
        $status=GetDetailData($Conn,'pinjaman','id_pinjaman',$id_pinjaman,'status');

        if($status=="Berjalan"){
            echo '
                <div class="alert alert-danger">
                    <small>Data Pinjaman Tidak Bisa Dibatalkan Karena Sudah Berjalan</small>
                </div>
            ';
        }else{
            if($status=="Lunas"){
                echo '
                    <div class="alert alert-danger">
                        <small>Data Pinjaman Tidak Bisa Dibatalkan Karena Sudah Lunas</small>
                    </div>
                ';
            }else{
                $BatalkanPengajuan = mysqli_query($Conn, "DELETE FROM pinjaman WHERE id_pinjaman='$id_pinjaman'") or die(mysqli_error($Conn));
                if($BatalkanPengajuan){
                    echo '
                        <div class="alert alert-success">
                            <small id="NotifikasiPembatalanPengajuanBerhasil">Success</small>
                        </div>
                    ';
                }else{
                    echo '
                        <div class="alert alert-danger">
                            <small>Terjadi kesalahan pada saat pembatalan pengajuan pinjaman</small>
                        </div>
                    ';
                }
            }
        }
    }
?>