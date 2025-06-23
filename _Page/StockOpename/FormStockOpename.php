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
                <small>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</small>
            </div>
        ';
    }else{
        
        //Tangkap id_barang
        if(empty($_POST['id_barang'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID Barang Tidak Boleh Kosong!</small>
                </div>
            ';
        }else{
            //Tangkap Sesi
            if(empty($_POST['id_stok_opename'])){
                echo '
                    <div class="alert alert-danger">
                        <small>ID Sesi Stock Opename Tidak Boleh Kosong!</small>
                    </div>
                ';
            }else{
                $id_barang=$_POST['id_barang'];
                $id_stok_opename=$_POST['id_stok_opename'];

                //id_stok_opename_barang
                if(empty($_POST['id_stok_opename_barang'])){
                    $id_stok_opename_barang="";
                    //Apabila id_stok_opename_barang kosong maka stok awal diambil darii data barang
                    $stok_awal=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'stok_barang');
                    $stok_akhir=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'stok_barang');
                    $harga=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'harga_beli');
                }else{
                    $id_stok_opename_barang=$_POST['id_stok_opename_barang'];
                    //Buka Stok Opename Barang
                    $stok_awal=GetDetailData($Conn, 'stok_opename_barang', 'id_stok_opename_barang', $id_stok_opename_barang, 'stok_awal');
                    $stok_akhir=GetDetailData($Conn, 'stok_opename_barang', 'id_stok_opename_barang', $id_stok_opename_barang, 'stok_akhir');
                    $harga=GetDetailData($Conn, 'stok_opename_barang', 'id_stok_opename_barang', $id_stok_opename_barang, 'harga_beli');
                }

                //Pembulatan stok_awal
                $stok_awal = (float) $stok_awal; // Konversi ke float
                $stok_awal = ($stok_awal == floor($stok_awal)) ? (int)$stok_awal : $stok_awal;
                //Pembulatan stok_akhir
                $stok_akhir = (float) $stok_akhir; // Konversi ke float
                $stok_akhir = ($stok_akhir == floor($stok_akhir)) ? (int)$stok_akhir : $stok_akhir;
                //Pembulatan Harga
                $harga = (float) $harga; // Konversi ke float
                $harga = ($harga == floor($harga)) ? (int)$harga : $harga;
?>
                <input type="hidden" name="id_barang" value="<?php echo "$id_barang"; ?>">
                <input type="hidden" name="id_stok_opename" value="<?php echo "$id_stok_opename"; ?>">
                <input type="hidden" name="id_stok_opename_barang" value="<?php echo "$id_stok_opename_barang"; ?>">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="stok_awal">Stock Awal</label>
                        <input type="text" name="stok_awal" id="stok_awal" class="form-control" maxlength="15" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="<?php echo "$stok_awal"; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="stok_akhir">Stock Akhir</label>
                        <input type="text" name="stok_akhir" id="stok_akhir" class="form-control" maxlength="15" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="<?php echo "$stok_akhir"; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="harga">Harga Beli (Rp)</label>
                        <input type="text" name="harga" id="harga" class="form-control form-money" inputmode="numeric" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="<?php echo "$harga"; ?>">
                    </div>
                </div>
                <script>
                    initializeMoneyInputs();
                </script>
<?php }}} ?>