<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');

    //Validasi Sesi Akses
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir Silahkan Login Ulang!!</small>
            </div>
        ';
    }else{
        if(empty($_POST['id_transaksi_bulk'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID Rincian Transaksi Tidak Boleh Kosong!</small>
                </div>
            ';
        } else {
            if(empty($_POST['qty'])){
                echo '
                    <div class="alert alert-danger">
                        <small>Jumlah Barang Tidak Boleh Kosong!</small>
                    </div>
                ';
            } else {
                $id_transaksi_bulk = $_POST['id_transaksi_bulk'];
                $qty = isset($_POST['qty']) ? $_POST['qty'] : "0";
                $harga = isset($_POST['harga']) ? $_POST['harga'] : "0";
                if(empty($_POST['ppn'])){
                    $ppn=0;
                }else{
                    $ppn=$_POST['ppn'];
                }
                if(empty($_POST['diskon'])){
                    $diskon=0;
                }else{
                    $diskon=$_POST['diskon'];
                }
                $ppn = (int) str_replace(".", "", $ppn);
                $diskon = (int) str_replace(".", "", $diskon);
                $harga = (int) str_replace(".", "", $harga);
                $jumlah=$qty*$harga;
                $subtotal=$jumlah+$ppn-$diskon;

                $UpdateBulk = mysqli_query($Conn,"UPDATE transaksi_bulk SET 
                    harga='$harga',
                    qty='$qty',
                    ppn='$ppn',
                    diskon='$diskon',
                    subtotal='$subtotal'
                WHERE id_transaksi_bulk='$id_transaksi_bulk'") or die(mysqli_error($Conn)); 
                if($UpdateBulk){
                    echo '
                        <div class="alert alert-success">
                            <small id="NotifikasiEditBulkBerhasil">Success</small>
                        </div>
                    ';
                }else{
                    echo '
                        <div class="alert alert-danger">
                            <small>Terjadi kesalahan pada saat melakukan update</small>
                        </div>
                    ';
                }
            }
        }
    }
?>
