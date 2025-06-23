<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Tangkap id_barang_satuan
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang.</small>
            </div>
        ';
    }else{
        if(empty($_POST['id_transaksi_bulk'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID Rincian Transaksi Tidak Boleh Kosong!</small>
                </div>
            ';
        }else{
            $id_transaksi_bulk=$_POST['id_transaksi_bulk'];
            //Buka data Rincian
            $QryRincian = mysqli_query($Conn,"SELECT * FROM transaksi_bulk WHERE id_transaksi_bulk='$id_transaksi_bulk'")or die(mysqli_error($Conn));
            $DataRincian= mysqli_fetch_array($QryRincian);
            if(empty($DataRincian['id_transaksi_bulk'])){
                echo '
                    <div class="alert alert-danger">
                        <small>Data Barang Tidak Ditemukan!</small>
                    </div>
                ';
            }else{
                $nama_barang= $DataRincian['nama_barang'];
                $kategori= $DataRincian['kategori'];
                $satuan= $DataRincian['satuan'];
                $qty= $DataRincian['qty'];
                $harga= $DataRincian['harga'];
                $ppn= $DataRincian['ppn'];
                $diskon= $DataRincian['diskon'];
                $subtotal= $DataRincian['subtotal'];
                //Pembulatan
                $qty=pembulatan_nilai($qty);
                $harga=pembulatan_nilai($harga);
                $ppn=pembulatan_nilai($ppn);
                $diskon=pembulatan_nilai($diskon);
                $subtotal=pembulatan_nilai($subtotal);
                $subtotal_rp = "Rp " . number_format($subtotal,0,',','.');
?>
                <input type="hidden" name="id_transaksi_bulk" value="<?php echo "$id_transaksi_bulk"; ?>">
                <div class="row mb-3">
                    <div class="col-4">
                        <small>Nama Barang</small>
                    </div>
                    <div class="col-8">
                        <small class="text text-grayish"><?php echo "$nama_barang"; ?></small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="qty_edit">
                            <small>QTY/Satuan</small>
                        </label>
                    </div>
                    <div class="col-8">
                        <div class="input-group">
                            <span class="input-group-text">.00</span>
                            <input type="text" name="qty" id="qty_edit" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="<?php echo "$qty"; ?>">
                            <span class="input-group-text"><?php echo "$satuan"; ?></span>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="harga_edit">
                            <small>Harga</small>
                        </label>
                    </div>
                    <div class="col-8">
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="harga" id="harga_edit" class="form-control form-money" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php echo "$harga"; ?>">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="ppn_edit">
                            <small>PPN</small>
                        </label>
                    </div>
                    <div class="col-8">
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="ppn" id="ppn_edit" class="form-control form-money" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php echo "$ppn"; ?>">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="diskon_edit"><small>Diskon</small></label>
                    </div>
                    <div class="col-8">
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="diskon" id="diskon_edit" class="form-control form-money" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php echo "$diskon"; ?>">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <small>Jumlah</small>
                    </div>
                    <div class="col-8" id="jumlah_rincian_edit">
                        <h4 class="text text-grayish"><?php echo "$subtotal_rp"; ?></h4>
                    </div>
                </div>
                <script>
                    // Event listener untuk input perubahan
                    $('#qty_edit, #harga_edit, #ppn_edit, #diskon_edit').on('input', function(){
                        hitungTotal();
                    });

                    // Panggil fungsi pertama kali saat halaman dimuat
                    hitungTotal();
                </script>

<?php
            }
        }
    }
?>