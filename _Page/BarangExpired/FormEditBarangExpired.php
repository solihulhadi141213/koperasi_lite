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
        $QryBarang = mysqli_query($Conn,"SELECT satuan_barang FROM barang WHERE id_barang='$id_barang'")or die(mysqli_error($Conn));
        $DataBarang = mysqli_fetch_array($QryBarang);
        $satuan_barang= $DataBarang['satuan_barang'];
?>
    <input type="hidden" name="id_barang_bacth" id="id_barang_bacth" value="<?php echo $id_barang_bacth;?>">
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="no_batch_edit">No/Kode Batch</label>
            <input type="text" name="no_batch" id="no_batch_edit" class="form-control" value="<?php echo $no_batch; ?>">
            <small>
                <code class="text text-grayish">
                    Kode Batch Produk/Barang Pada Kemasan
                </code>
            </small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="expired_date_edit">Expire Date</label>
            <input type="date" name="expired_date" id="expired_date_edit" class="form-control" value="<?php echo $expired_date; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="reminder_date_edit">Reminder Date</label>
            <input type="date" name="reminder_date" id="reminder_date_edit" class="form-control" value="<?php echo $reminder_date; ?>">
            <small>
                <code class="text text-grayish">
                    Tanggal/Waktu kapan sistem menampilkan pemberitahuan.
                </code>
            </small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="qty_batch_edit">Jumlah (QTY)</label>
            <div class="input-group">
                <input type="number" name="qty_batch" id="qty_batch_edit" class="form-control" value="<?php echo $qty_batch; ?>">
                <span class="input-group-text">
                    <?php echo $satuan_barang; ?>
                </span>
            </div>
            
            <small>
                <code class="text text-grayish">
                    Jumlah barang dengan nomor batch yang sama
                </code>
            </small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="status_edit">Status</label>
            <select name="status" id="status_edit" class="form-control">
                <option <?php if($StatusExpired==""){echo "selected";} ?> value="">Pilih</option>
                <option <?php if($StatusExpired=="Terdaftar"){echo "selected";} ?> value="Terdaftar">Terdaftar</option>
                <option <?php if($StatusExpired=="Terjual"){echo "selected";} ?> value="Terjual">Terjual</option>
            </select>
            <small>
                <ul>
                    <li>Terdaftar : <code class="text text-grayish">Barang tersedia dan belum terjual</code></li>
                    <li>Terjual : <code class="text text-grayish">Barang tidak tersedia atau sudah terjual</code></li>
                </ul>
            </small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <span class="text-dark">Pastikan bahwa informasi data yang anda masukan sudah benar</span>
        </div>
    </div>
<?php } ?>