<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Tangkap id_barang_satuan
    if(empty($_POST['id_barang'])){
        echo '
            <div class="alert alert-danger">
                <small>ID barang Tidak Boleh Kosong!</small>
            </div>
        ';
    }else{
        if(empty($_POST['id_transaksi_jual_beli'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID Transaksi Tidak Boleh Kosong!</small>
                </div>
            ';
        }else{
            $id_barang=$_POST['id_barang'];
            $id_transaksi_jual_beli=$_POST['id_transaksi_jual_beli'];
            //Buka data Barang
            $QryBarang = mysqli_query($Conn,"SELECT * FROM barang WHERE id_barang='$id_barang'")or die(mysqli_error($Conn));
            $DataBarang= mysqli_fetch_array($QryBarang);
            if(empty($DataBarang['id_barang'])){
                echo '
                    <div class="alert alert-danger">
                        <small>Data Barang Tidak Ditemukan!</small>
                    </div>
                ';
            }else{
                $id_barang= $DataBarang['id_barang'];
                $nama_barang= $DataBarang['nama_barang'];
                $satuan_barang= $DataBarang['satuan_barang'];
                $konversi= $DataBarang['konversi'];
                $harga_beli= $DataBarang['harga_beli'];
                $harga_beli_rp = "Rp " . number_format($harga_beli,0,',','.');

                //Pembulatan konversi
                $konversi = (float) $konversi; // Konversi ke float
                $konversi = ($konversi == floor($konversi)) ? (int)$konversi : $konversi;
?>
                <input type="hidden" name="id_barang" value="<?php echo $id_barang;?>">
                <input type="hidden" name="id_transaksi_jual_beli" value="<?php echo $id_transaksi_jual_beli;?>">
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="nama_barang_edit">Nama Barang</label>
                    </div>
                    <div class="col-8">
                        <input type="text" name="nama_barang" id="nama_barang_edit" class="form-control" value="<?php echo "$nama_barang"; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="satuan_barang_edit">Satuan</label>
                    </div>
                    <div class="col-8">
                        <select name="id_barang_satuan" id="satuan_barang_edit" class="form-control">
                            <option value=""><?php echo "$satuan_barang ($konversi)"; ?></option>
                            <?php
                                //Buka Multi Satuan
                                $QrySatuanMulti = mysqli_query($Conn, "SELECT * FROM barang_satuan WHERE id_barang='$id_barang' ORDER BY satuan_multi ASC");
                                while ($DataSatuanMulti = mysqli_fetch_array($QrySatuanMulti)) {
                                    $id_barang_satuan= $DataSatuanMulti['id_barang_satuan'];
                                    $satuan_multi= $DataSatuanMulti['satuan_multi'];
                                    $konversi_multi= $DataSatuanMulti['konversi_multi'];
                                    echo '<option value="'.$id_barang_satuan.'">'.$satuan_multi.' ('.$konversi_multi.')</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="qty_edit">QTY</label>
                    </div>
                    <div class="col-8">
                        <div class="input-group">
                            <span class="input-group-text">.00</span>
                            <input type="text" name="qty" id="qty_edit" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="1">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="kategori_harga_edit">Kategori Harga</label>
                    </div>
                    <div class="col-8">
                        <select name="kategori_harga" id="kategori_harga_edit" class="form-control">
                            <?php
                                //Buka barang_kategori_harga
                                $QryKategoriHarga = mysqli_query($Conn, "SELECT id_barang_kategori_harga, kategori_harga FROM barang_kategori_harga ORDER BY kategori_harga ASC");
                                while ($DataKategoriHarga = mysqli_fetch_array($QryKategoriHarga)) {
                                    $id_barang_kategori_harga= $DataKategoriHarga['id_barang_kategori_harga'];
                                    $kategori_harga= $DataKategoriHarga['kategori_harga'];
                                    //Buka barang_harga
                                    $QryBarangHarga = mysqli_query($Conn,"SELECT * FROM barang_harga WHERE id_barang='$id_barang' AND id_barang_kategori_harga='$id_barang_kategori_harga'")or die(mysqli_error($Conn));
                                    $DataBarangHarga= mysqli_fetch_array($QryBarangHarga);
                                    if(empty($DataBarangHarga['harga'])){
                                        $harga=0;
                                    }else{
                                        $harga= $DataBarangHarga['harga'];
                                    }
                                    $harga_rp = "Rp " . number_format($harga,0,',','.');
                                    echo '<option value="'.$harga.'">'.$kategori_harga.' ('.$harga_rp.' / '.$satuan_barang.')</option>';
                                }
                                echo '<option value="'.$harga_beli.'">Harga Beli ('.$harga_beli_rp.' / '.$satuan_barang.')</option>';
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="harga_edit">Harga/<?php echo $satuan_barang; ?></label>
                    </div>
                    <div class="col-8">
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="harga" id="harga_edit" class="form-control form-money"  oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="0">
                        </div>
                        
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="ppn_edit">PPN (%)</label>
                    </div>
                    <div class="col-8">
                        <div class="input-group">
                            <span class="input-group-text">.00</span>
                            <input type="text" name="ppn" id="ppn_edit" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="0">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="diskon_edit">Diskon (%)</label>
                    </div>
                    <div class="col-8">
                        <div class="input-group">
                            <span class="input-group-text">.00</span>
                            <input type="text" name="diskon" id="diskon_edit" class="form-control" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="0">
                        </div>
                    </div>
                </div>
                
                <script>
                    $(document).ready(function() {
                        //Tangkap kategori harga
                        var kategori_harga = Math.round(parseFloat($('#kategori_harga_edit').val())); 
                        
                        //Tempelkan harga
                        $('#harga_edit').val(kategori_harga);
                        
                        //Format nilai
                        initializeMoneyInputs();

                        //Ketika kategori harga diubah
                        $('#kategori_harga_edit').change(function() {
                            var selected_harga = Math.round(parseFloat($(this).val()));
                            $('#harga_edit').val(selected_harga);
                            initializeMoneyInputs();

                            //Refresh Simulasi
                            HitungSimulasiRincianEdit();
                        });

                        //Menampilkan Simulasi pertama kali
                        HitungSimulasiRincianEdit();

                        //Ketika Satuan Diubah
                        $('#satuan_barang_edit').change(function() {
                            HitungSimulasiRincianEdit();
                        });

                        //Ketika qty Diubah
                        $('#qty_edit').keyup(function() {
                            HitungSimulasiRincianEdit();
                        });

                        //Ketika kategori_harga Diubah
                        $('#kategori_harga_edit').change(function() {
                            HitungSimulasiRincianEdit();
                        });

                        //Ketika harga Diubah
                        $('#harga_edit').keyup(function() {
                            HitungSimulasiRincianEdit();
                        });

                        //Ketika ppn Diubah
                        $('#ppn_edit').keyup(function() {
                            HitungSimulasiRincianEdit();
                        });

                        //Ketika diskon Diubah
                        $('#diskon_edit').keyup(function() {
                            HitungSimulasiRincianEdit();
                        });
                    });
                </script>
<?php 
            } 
        } 
    } 
?>