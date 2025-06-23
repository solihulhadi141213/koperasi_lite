<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');

    // Inisialisasi respons default
    $response = [
        "status" => "Error",
        "message" => "Belum ada proses yang dilakukan pada sistem."
    ];

    //Validasi Sesi Akses
    if(empty($SessionIdAkses)){
        $response = [
            "status" => "Error",
            "message" => "Sesi Akses Sudah Berakhir, Silahkan Login Ulang"
        ];
    }else{

        //Validasi Kelengkapan Data
        if(empty($_POST['id_transaksi_jual_beli_rincian'])){
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

                //Buat Variabel Agar Lebih Mudah
                $id_transaksi_jual_beli_rincian = $_POST['id_transaksi_jual_beli_rincian'];
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
                
                //Buka QTY lama
                $qty_lama=GetDetailData($Conn, 'transaksi_jual_beli_rincian', 'id_transaksi_jual_beli_rincian', $id_transaksi_jual_beli_rincian, 'qty');
                
                //Hitung Selisih
                $selisih=$qty-$qty_lama;

                //Update Rincian Transaksi
                $UpdateRincian = mysqli_query($Conn,"UPDATE transaksi_jual_beli_rincian SET 
                    harga='$harga',
                    qty='$qty',
                    ppn='$ppn',
                    diskon='$diskon',
                    subtotal='$subtotal'
                WHERE id_transaksi_jual_beli_rincian='$id_transaksi_jual_beli_rincian'") or die(mysqli_error($Conn)); 
                if($UpdateRincian){
                    //Apabila Berhasil Buka ID transaksi
                    $id_transaksi_jual_beli=GetDetailData($Conn, 'transaksi_jual_beli_rincian', 'id_transaksi_jual_beli_rincian', $id_transaksi_jual_beli_rincian, 'id_transaksi_jual_beli');

                    //Menghitung ulang jumlah subtotal, ppn, diskon, dan total
                    $query_subtotal = "SELECT SUM(qty * harga) AS subtotal FROM  transaksi_jual_beli_rincian WHERE id_transaksi_jual_beli = '$id_transaksi_jual_beli'";
                    $result_subtotal = mysqli_query($Conn, $query_subtotal);
                    if (!$result_subtotal) {
                        $subtotal = 0;
                    }else{
                        $row_subtotal = mysqli_fetch_assoc($result_subtotal);
                        $subtotal = $row_subtotal['subtotal'];
                        if ($subtotal === NULL) {
                            $subtotal = 0;
                        }
                    }
                    //Hitung Jumlah PPN
                    $SumPpn = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(ppn) AS jumlah_ppn FROM transaksi_jual_beli_rincian WHERE id_transaksi_jual_beli = '$id_transaksi_jual_beli'"));
                    $jumlah_ppn = $SumPpn['jumlah_ppn'];

                    //Hitung Jumlah Diskon
                    $SumDiskon = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(diskon) AS jumlah_diskon FROM transaksi_jual_beli_rincian WHERE id_transaksi_jual_beli = '$id_transaksi_jual_beli'"));
                    $jumlah_diskon = $SumDiskon['jumlah_diskon'];

                    //Hitung Jumlah Total
                    $SumTotal = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(subtotal) AS total FROM transaksi_jual_beli_rincian WHERE id_transaksi_jual_beli = '$id_transaksi_jual_beli'"));
                    $total = $SumTotal['total'];

                    //Hitung cash
                    $cash=GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'cash');
                    
                    //Menentukan Status Transaksi
                    if($cash<$total){
                        $status="Kredit";
                    }else{
                        $status="Lunas";
                    }

                    //Update Transaksi
                    $UpdateTransaksi = mysqli_query($Conn,"UPDATE transaksi_jual_beli SET 
                        subtotal='$subtotal',
                        diskon='$jumlah_diskon',
                        ppn='$jumlah_ppn',
                        total='$total',
                        status='$status'
                    WHERE id_transaksi_jual_beli='$id_transaksi_jual_beli'") or die(mysqli_error($Conn)); 
                    if($UpdateTransaksi){

                        //Buka Satuan Dari Rincian
                        $id_barang=GetDetailData($Conn, 'transaksi_jual_beli_rincian', 'id_transaksi_jual_beli_rincian', $id_transaksi_jual_beli_rincian, 'id_barang');
                        $satuan=GetDetailData($Conn, 'transaksi_jual_beli_rincian', 'id_transaksi_jual_beli_rincian', $id_transaksi_jual_beli_rincian, 'satuan');

                        //Apakah Satuan Tersebut Merupakan Multi Satuan
                        $QryBarangsatuan = mysqli_query($Conn,"SELECT * FROM barang_satuan WHERE id_barang='$id_barang' AND satuan_multi='$satuan'")or die(mysqli_error($Conn));
                        $DataBarangSatuan = mysqli_fetch_array($QryBarangsatuan);
                        if(empty($DataBarangSatuan['id_barang_satuan'])){
                            $konversi_multi=0;
                        }else{
                            $konversi_multi= $DataBarangSatuan['konversi_multi'];
                        }
                        
                        //Buka Konversi Barang
                        $konversi=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'konversi');

                        //Ubah selisih berdasarkan faktor konversi
                        if(!empty($DataBarangSatuan['id_barang_satuan'])){
                            $selisih=$selisih*($konversi_multi/$konversi);
                        }
                        
                        //Buka Kategori Transaksi
                        $kategori_transaksi=GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'kategori');

                        //Buka Stok Barang
                        $stok_lama=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'stok_barang');
                        if($kategori_transaksi=="Retur Pembelian"){
                            $stok_baru=$stok_lama-$selisih;
                        }else{
                            $stok_baru=$stok_lama+$selisih;
                        }

                        //Update Barang
                        $update_barang = mysqli_query($Conn,"UPDATE barang SET 
                            stok_barang='$stok_baru'
                        WHERE id_barang='$id_barang'") or die(mysqli_error($Conn)); 
                        if($update_barang){
                            //LOGGING
                            $kategori_log="Transaksi Pembelian";
                            $deskripsi_log="Edit Rincian Pembelian";
                            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                            if($InputLog=="Success"){
                                $response = [
                                    "status" => "Success",
                                    "message" => "Update Rincian Transaksi Pembelian Berhasil!"
                                ];
                            }else{
                                $response = [
                                    "status" => "Error",
                                    "message" => "Terjadi kesalahan pada saat menyimpan log aktivitas"
                                ];
                            }
                        }else{
                            $response = [
                                "status" => "Error",
                                "message" => "Terjadi kesalahan pada saat update data barang"
                            ];
                        }
                    }else{
                        $response = [
                            "status" => "Error",
                            "message" => "Terjadi kesalahan pada saat update data transaksi"
                        ];
                    }
                    
                }else{
                    $response = [
                        "status" => "Error",
                        "message" => "Terjadi kesalahan pada saat melakukan update"
                    ];
                }
            }
        }
    }

    // Output response
    echo json_encode($response);
?>
