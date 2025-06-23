<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
    }else{
        if(empty($_POST['periode'])){
            echo '
                <div class="alert alert-danger">
                    <small>Periode Data Tidak Boleh Kosong!</small>
                </div>
            ';
        }else{
            //Buat Dalam Bentuk Variabel Yang Sudah Dibersihkan
            $periode=validateAndSanitizeInput($_POST['periode']);
            //Format Periode Data
            $periode_format=date('d F Y', strtotime($periode));

            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota"));
            echo '
                <input type="hidden" name="periode" value="'.$periode.'">
                <div class="row mb-2">
                    <div class="col-4"><small>Periode</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-7"><small class="text text-dark">'.$periode_format.'</small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><small>Jumlah Data</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-7"><small class="text text-dark">'.$jml_data.' Record</small></div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <small>Sistem Akan Melakukan Download ke Format Excel. Semakin besar data maka waktu yang dibutuhkan semakin lama.</small>
                        </div>
                    </div>
                </div>
            ';
        }
    }
?>