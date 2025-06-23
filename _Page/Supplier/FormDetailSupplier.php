<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Tangkap id_mitra
    if(empty($_POST['id_supplier'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          ID Supplier Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_supplier=$_POST['id_supplier'];
        //Buka data supplier
        $QrySupplier = mysqli_query($Conn,"SELECT * FROM supplier WHERE id_supplier='$id_supplier'")or die(mysqli_error($Conn));
        $DataSupplier = mysqli_fetch_array($QrySupplier);
        $id_supplier= $DataSupplier['id_supplier'];
        $nama_supplier= $DataSupplier['nama_supplier'];
        if(empty($DataSupplier['alamat_supplier'])){
            $alamat_supplier='-';
        }else{
            $alamat_supplier= $DataSupplier['alamat_supplier'];
        }
        if(empty($DataSupplier['email_supplier'])){
            $email_supplier='-';
        }else{
            $email_supplier= $DataSupplier['email_supplier'];
        }
        if(empty($DataSupplier['kontak_supplier'])){
            $kontak_supplier='-';
        }else{
            $kontak_supplier= $DataSupplier['kontak_supplier'];
        }
        //Hitung volume transaksi
        $Sum = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(total) AS total FROM transaksi_jual_beli WHERE id_supplier='$id_supplier'"));
        $jumlah_transaksi = $Sum['total'];
        $VolumeTransaksi = "Rp " . number_format($jumlah_transaksi,0,',','.');
        echo '
            <input type="hidden" name="id" value="'.$id_supplier.'">
            <input type="hidden" name="Sub" value="DetailSupplier">
            <input type="hidden" name="Page" value="Supplier">
            <div class="row mb-2">
                <div class="col-4"><small>Nama Supplier</small></div>
                <div class="col-8"><small><code class="text-grayish">'.$nama_supplier.'</code></small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Email</small></div>
                <div class="col-8"><small><code class="text-grayish">'.$email_supplier.'</code></small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Kontak</small></div>
                <div class="col-8"><small><code class="text-grayish">'.$kontak_supplier.'</code></small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Alamat</small></div>
                <div class="col-8"><small><code class="text-grayish">'.$alamat_supplier.'</code></small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Volume Transaksi</small></div>
                <div class="col-8"><small><code class="text-grayish">'.$VolumeTransaksi.'</code></small></div>
            </div>
        ';
    }
?>