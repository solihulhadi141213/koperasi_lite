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
                if(empty($_POST['id_anggota'])){
                    $id_anggota="";
                    $nama_anggota_baru="-";
                    $validasi_anggota_baru="Valid";
                }else{
                    $id_anggota=$_POST['id_anggota'];
                    //Buka Nama Anggota Baru
                    $nama_anggota_baru=GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota, 'nama');
                    if(empty($nama_anggota_baru)){
                        $validasi_anggota_baru="Anggota Yang Anda Pilih Tidak Ditemukan!";
                    }else{
                        $validasi_anggota_baru="Valid";
                    }
                    
                }
                $mode=$_POST['mode'];
                if($validasi_anggota_baru!=="Valid"){
                    echo '
                        <div class="alert alert-danger">
                            <small>'.$validasi_anggota_baru.'</small>
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
                        if(empty($DataTransaksi['id_anggota'])){
                            $id_anggota_lama=0;
                            $nama_anggota_lama="-";
                        }else{
                            $id_anggota_lama= $DataTransaksi['id_anggota'];
                            $nama_anggota_lama=GetDetailData($Conn, 'anggota', 'id_anggota', $id_anggota_lama, 'nama');
                        }
                        
                        $tanggal= $DataTransaksi['tanggal'];
                        //Buka Nama Anggota Lama
                        

?>
                        <input type="hidden" name="id_transaksi_jual_beli" value="<?php echo "$id_transaksi_jual_beli"; ?>">
                        <input type="hidden" name="id_anggota_lama" value="<?php echo "$id_anggota_lama"; ?>">
                        <input type="hidden" name="id_anggota_baru" value="<?php echo "$id_anggota"; ?>">
                        <input type="hidden" name="mode" value="<?php echo "$mode"; ?>">
                        <div class="row mb-3">
                            <div class="col-4">
                                <small>Anggota Sebelumnya</small>
                            </div>
                            <div class="col-8">
                                <small class="text text-grayish"><?php echo "$nama_anggota_lama"; ?></small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <small>Anggota Baru</small>
                            </div>
                            <div class="col-8">
                                <small class="text text-grayish"><?php echo "$nama_anggota_baru"; ?></small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <small>Apakah Anda Yakin Akan Mengubah Informasi Anggota Pada Transaksi Ini?</small>
                            </div>
                        </div>
<?php
                    }
                }
            }
        }
    }
?>