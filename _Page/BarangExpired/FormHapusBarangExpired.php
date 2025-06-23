<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Tangkap Data
    if(empty($_POST['id_barang_bacth'])){
        echo '  <div class="row">';
        echo '      <div class="col col-md-12 text-center">';
        echo '          <div class="alert alert-danger">ID batch Tidak Boleh Kosong!</div>';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_barang_bacth=$_POST['id_barang_bacth'];
        //Buka data supplier
        $QryBatch= mysqli_query($Conn,"SELECT * FROM barang_bacth WHERE id_barang_bacth='$id_barang_bacth'")or die(mysqli_error($Conn));
        $DataBatch= mysqli_fetch_array($QryBatch);
        $id_barang_bacth= $DataBatch['id_barang_bacth'];
        $id_barang= $DataBatch['id_barang'];
        $no_batch= $DataBatch['no_batch'];
        $expired_date= $DataBatch['expired_date'];
        $qty_batch= $DataBatch['qty_batch'];
        $qty_batch = ($qty_batch == floor($qty_batch)) ? number_format($qty_batch, 0) : $qty_batch;
        $reminder_date= $DataBatch['reminder_date'];
        $StatusExpired= $DataBatch['status'];
        //Buka data barang
        $QryBarang = mysqli_query($Conn,"SELECT * FROM barang WHERE id_barang='$id_barang'")or die(mysqli_error($Conn));
        $DataBarang = mysqli_fetch_array($QryBarang);
        $nama_barang= $DataBarang['nama_barang'];

        //Tampilkan Data
        echo '
            <input type="hidden" name="id_barang_bacth" value="'.$id_barang_bacth.'">
            <div class="row mb-3">
                <div class="col-4"><small>Nama Barang</small></div>
                <div class="col-8"><small class="text text-grayish">'.$nama_barang.'</small></div>
            </div>
            <div class="row mb-3">
                <div class="col-4"><small>No.Batch</small></div>
                <div class="col-8"><small class="text text-grayish">'.$no_batch.'</small></div>
            </div>
            <div class="row mb-3">
                <div class="col-4"><small>Expire Date</small></div>
                <div class="col-8"><small class="text text-grayish">'.$expired_date.'</small></div>
            </div>
            <div class="row">
                <div class="col-12">Apakah Anda Yakin Akan Menghapus Data Tersebut?</div>
            </div>
        ';
    }
?>