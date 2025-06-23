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
        if(empty($_POST['id_transaksi_jual_beli'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID Transaksi Tidak Boleh Kosong!</small>
                </div>
            ';
        }else{
            if(empty($_POST['mode'])){
                echo '
                    <div class="alert alert-danger">
                        <small>Mode Form Tidak Boleh Kosong!</small>
                    </div>
                ';
            }else{
                $id_transaksi_jual_beli=$_POST['id_transaksi_jual_beli'];
                if(empty($_POST['id_supplier'])){
                    $id_supplier="";
                    $nama_supplier_baru="-";
                    $validasi_supplier_baru="Valid";
                }else{
                    $id_supplier=$_POST['id_supplier'];
                    //Buka Nama Supplier Baru
                    $nama_supplier_baru=GetDetailData($Conn, 'supplier', 'id_supplier', $id_supplier, 'nama_supplier');
                    if(empty($nama_supplier_baru)){
                        $validasi_supplier_baru="Supplier Yang Anda Pilih Tidak Ditemukan!";
                    }else{
                        $validasi_supplier_baru="Valid";
                    }
                    
                }
                $mode=$_POST['mode'];
                if($validasi_supplier_baru!=="Valid"){
                    echo '
                        <div class="alert alert-danger">
                            <small>'.$validasi_supplier_baru.'</small>
                        </div>
                    ';
                }else{
                    //Buka data Transaksi
                    $QryTransaksi = mysqli_query($Conn,"SELECT * FROM transaksi_jual_beli WHERE id_transaksi_jual_beli='$id_transaksi_jual_beli'")or die(mysqli_error($Conn));
                    $DataTransaksi= mysqli_fetch_array($QryTransaksi);
                    if(empty($DataTransaksi['id_transaksi_jual_beli'])){
                        echo '
                            <div class="alert alert-danger">
                                <small>Data Transaksi Tidak Ditemukan!</small>
                            </div>
                        ';
                    }else{
                        if(empty($DataTransaksi['id_supplier'])){
                            $id_supplier_lama=0;
                            $nama_supplier_lama="-";
                        }else{
                            $id_supplier_lama= $DataTransaksi['id_supplier'];
                            $nama_supplier_lama=GetDetailData($Conn, 'supplier', 'id_supplier', $id_supplier_lama, 'nama_supplier');
                        }
                        
                        $tanggal= $DataTransaksi['tanggal'];
                        //Buka Nama Supplier Lama
                        

?>
                        <input type="hidden" name="id_transaksi_jual_beli" value="<?php echo "$id_transaksi_jual_beli"; ?>">
                        <input type="hidden" name="id_supplier_lama" value="<?php echo "$id_supplier_lama"; ?>">
                        <input type="hidden" name="id_supplier_baru" value="<?php echo "$id_supplier"; ?>">
                        <input type="hidden" name="mode" value="<?php echo "$mode"; ?>">
                        <div class="row mb-3">
                            <div class="col-4">
                                <small>Supplier Sebelumnya</small>
                            </div>
                            <div class="col-8">
                                <small class="text text-grayish"><?php echo "$nama_supplier_lama"; ?></small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <small>Supplier Baru</small>
                            </div>
                            <div class="col-8">
                                <small class="text text-grayish"><?php echo "$nama_supplier_baru"; ?></small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <small>Apakah Anda Yakin Akan Mengubah Informasi Supplier Pada Transaksi Ini?</small>
                            </div>
                        </div>
<?php
                    }
                }
            }
        }
    }
?>