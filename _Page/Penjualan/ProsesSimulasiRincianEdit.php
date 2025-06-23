<?php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    
    if(empty($_POST['id_barang'])){
        echo '
            <div class="alert alert-danger">
                <small>ID barang Tidak Boleh Kosong!</small>
            </div>
        ';
    } else {
        $id_barang = $_POST['id_barang'];
        $konversi = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'konversi');
        $satuan_barang = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'satuan_barang');

        if(empty($_POST['id_barang_satuan'])){
            $id_barang_satuan = "";
            $konversi_multi = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'konversi');
        } else {
            $id_barang_satuan = $_POST['id_barang_satuan'];
            $satuan_barang = GetDetailData($Conn, 'barang_satuan', 'id_barang_satuan', $id_barang_satuan, 'satuan_multi');
            $konversi_multi = GetDetailData($Conn, 'barang_satuan', 'id_barang_satuan', $id_barang_satuan, 'konversi_multi');
        }

        // Pastikan nilai QTY, Harga, PPN, dan Diskon adalah numerik dan memiliki default 0 jika kosong
        $qty = isset($_POST['qty']) && is_numeric($_POST['qty']) ? (float)$_POST['qty'] : 0;
        $harga = isset($_POST['harga']) ? $_POST['harga'] : "0";
        $ppn = isset($_POST['ppn']) && is_numeric($_POST['ppn']) ? (float)$_POST['ppn'] : 0;
        $diskon = isset($_POST['diskon']) && is_numeric($_POST['diskon']) ? (float)$_POST['diskon'] : 0;
        $harga = (int) str_replace(".", "", $harga);
        
        if(!empty($_POST['id_barang_satuan'])){
            $harga = $harga * ($konversi_multi / $konversi);
        }
        // Ubah harga menjadi numerik (hapus titik pemisah ribuan)
        $harga_numeric = (int) str_replace(".", "", $harga);
        
        // Menghindari pembagian dengan nol (konversi tidak boleh nol)
        $qty_real = $qty;

        // Menghitung subtotal
        $subtotal = $qty_real * $harga_numeric;

        // Pastikan subtotal tidak negatif
        if ($subtotal < 0) {
            $subtotal = 0;
        }

        // Menghitung nilai PPN (jika subtotal bukan nol)
        $rp_ppn = $subtotal > 0 ? ($ppn / 100) * $subtotal : 0;

        // Menghitung nilai diskon (jika subtotal bukan nol)
        $rp_diskon = $subtotal > 0 ? ($diskon / 100) * $subtotal : 0;

        // Menghitung total
        $total = ($subtotal + $rp_ppn) - $rp_diskon;

        //tampilkan data
        $harga_rp = "Rp " . number_format($harga_numeric,0,',','.');
        $ppn_rp = "Rp " . number_format($rp_ppn,0,',','.');
        $diskon_rp = "Rp " . number_format($rp_diskon,0,',','.');
        $total_rp = "Rp " . number_format($total,0,',','.');
        echo '
            <div class="row mb-2">
                <div class="col-4">
                    <small class="text text-dark">Jumlah Barang</small>
                </div>
                <div class="col-8">
                    <small class="text text-grayish">'.$qty_real.' '.$satuan_barang.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small class="text text-dark">Harga Barang</small>
                </div>
                <div class="col-8">
                    <small class="text text-grayish">'.$harga_rp.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small class="text text-dark">PPN</small>
                </div>
                <div class="col-8">
                    <small class="text text-grayish">'.$ppn_rp.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small class="text text-dark">Diskon</small>
                </div>
                <div class="col-8">
                    <small class="text text-grayish">'.$diskon_rp.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small class="text text-dark">Jumlah</small>
                </div>
                <div class="col-8">
                    <h3 class="text text-grayish">'.$total_rp.'</h3>
                </div>
            </div>
        ';
    }
?>
