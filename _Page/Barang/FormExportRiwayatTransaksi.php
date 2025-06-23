<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Validasi Sesi Akses
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                <small>Sessi Akses Sudah Berakhir, Silahkan Login Ulang!</small>
            </div>
        ';
    }else{
        if(empty($_POST['id_barang'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID Barang Tidak Boleh Kosong</small>
                </div>
            ';
        }else{
            $id_barang=validateAndSanitizeInput($_POST['id_barang']);
            //Buka Data Barang
            $nama_barang=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'nama_barang');
            $kode_barang=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'kode_barang');
            echo '
                <input type="hidden" name="id_barang" value="'.$id_barang.'">
                <div class="row mb-3">
                    <div class="col-4">
                        <small>Kode Barang</small>
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-7">
                        <small class="text text-muted">'.$kode_barang.'</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <small>Nama Barang</small>
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-7">
                        <small class="text text-muted">'.$nama_barang.'</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="periode_awal_transaksi"><small>Periode Awal</small></label>
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-7">
                        <input type="date" name="periode_awal_transaksi" id="periode_awal_transaksi" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="periode_akhir_transaksi"><small>Periode Akhir</small></label>
                    </div>
                    <div class="col-1">:</div>
                    <div class="col-7">
                        <input type="date" name="periode_akhir_transaksi" id="periode_akhir_transaksi" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <small>
                                Sistem akan melakukan export data riwayat transaksi dalam format file <b>Excel</b> sesuai parameter di atas. 
                                Pastikan periode data sudah terisi dengan benar
                            </small>
                        </div>
                    </div>
                </div>
            ';
        }
    }
?>