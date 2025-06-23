<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Tangkap id_mitra
    if(empty($_POST['id_barang_bacth'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          ID Supplier Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_barang_bacth=validateAndSanitizeInput($_POST['id_barang_bacth']);
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
        $kode_barang= $DataBarang['kode_barang'];
        $satuan_barang= $DataBarang['satuan_barang'];
        echo '
            <div class="row mb-3">
                <div class="col-4"><small>Kode Barang</small></div>
                <div class="col-8">
                    <small><code class="text text-grayish">'.$kode_barang.'</code></small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4"><small>Nama Barang</small></div>
                <div class="col-8">
                    <small><code class="text text-grayish">'.$nama_barang.'</code></small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4"><small>No. Batch</small></div>
                <div class="col-8">
                    <small><code class="text text-grayish">'.$no_batch.'</code></small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4"><small>Expire Date</small></div>
                <div class="col-8">
                    <small><code class="text text-grayish">'.$expired_date.'</code></small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4"><small>Reminder Date</small></div>
                <div class="col-8">
                    <small><code class="text text-grayish">'.$reminder_date.'</code></small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4"><small>Jumlah (QTY)</small></div>
                <div class="col-8">
                    <small><code class="text text-grayish">'.$qty_batch.' '.$satuan_barang.'</code></small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4"><small>Status</small></div>
                <div class="col-8">
                    <small><code class="text text-grayish">'.$StatusExpired.'</code></small>
                </div>
            </div>
        ';
    }
?>