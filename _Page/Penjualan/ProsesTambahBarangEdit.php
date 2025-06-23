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
        if(empty($_POST['id_barang'])){
            echo '
                <div class="alert alert-danger">
                    <small>ID barang Tidak Boleh Kosong!</small>
                </div>
            ';
        } else {
            if(empty($_POST['id_transaksi_jual_beli'])){
                echo '
                    <div class="alert alert-danger">
                        <small>ID Transaksi Tidak Boleh Kosong!</small>
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
                    $id_barang = $_POST['id_barang'];
                    $id_transaksi_jual_beli = $_POST['id_transaksi_jual_beli'];
                    $qty = $_POST['qty'];
                    
                    //Buka Kategori Transaksi
                    $kategori_transaksi=GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'kategori');

                    //Buka Data Barang
                    $nama_barang = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'nama_barang');
                    $konversi = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'konversi');
                    $satuan_barang = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'satuan_barang');
                    $stok_barang = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'stok_barang');

                    //Apabila Bukan Multi Satuan
                    if(empty($_POST['id_barang_satuan'])){
                        $id_barang_satuan = "";
                        $konversi_multi = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'konversi');
                    } else {
                        //Apabila Multi Satuan
                        $id_barang_satuan = $_POST['id_barang_satuan'];
                        $satuan_barang = GetDetailData($Conn, 'barang_satuan', 'id_barang_satuan', $id_barang_satuan, 'satuan_multi');
                        $konversi_multi = GetDetailData($Conn, 'barang_satuan', 'id_barang_satuan', $id_barang_satuan, 'konversi_multi');
                    }

                    // Pastikan nilai QTY, Harga, PPN, dan Diskon adalah numerik dan memiliki default 0 jika kosong
                    $harga = isset($_POST['harga']) ? $_POST['harga'] : "0";
                    $ppn = isset($_POST['ppn']) && is_numeric($_POST['ppn']) ? (float)$_POST['ppn'] : 0;
                    $diskon = isset($_POST['diskon']) && is_numeric($_POST['diskon']) ? (float)$_POST['diskon'] : 0;
                    $harga = (int) str_replace(".", "", $harga);
                    
                    //Apabila Multi Satuan hitung harga secara berbeda
                    if(!empty($_POST['id_barang_satuan'])){
                        $harga = $harga * ($konversi_multi / $konversi);
                        $qty_real=$qty*($konversi_multi / $konversi);
                    }else{
                        $harga = $harga;
                        $qty_real=$qty;
                    }
                    //Hitung Stok Barang Baru
                    $stok_barang_baru=$stok_barang-$qty_real;

                    // Ubah harga menjadi numerik (hapus titik pemisah ribuan)
                    $harga_numeric = (int) str_replace(".", "", $harga);
                    
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
                    
                    //Cek apakah data barang sudah ada pada Transaksi
                    $QryTransaksi = mysqli_query($Conn,"SELECT * FROM transaksi_jual_beli_rincian WHERE id_barang='$id_barang' AND id_transaksi_jual_beli='$id_transaksi_jual_beli'")or die(mysqli_error($Conn));
                    $DataTransaksi= mysqli_fetch_array($QryTransaksi);
                    if(!empty($DataTransaksi['id_transaksi_jual_beli_rincian'])){
                        $id_transaksi_jual_beli_rincian= $DataTransaksi['id_transaksi_jual_beli_rincian'];
                        $harga_bulk= $DataTransaksi['harga'];
                        $satuan_bulk= $DataTransaksi['satuan'];
                        $qty_bulk= $DataTransaksi['qty'];
                        //Bulatkan harga
                        $harga_bulk = (float) $harga_bulk; // Konversi ke float
                        $harga_bulk = ($harga_bulk == floor($harga_bulk)) ? (int)$harga_bulk : $harga_bulk;
                        
                        //Persiapan Data Update
                        $qty_rincian_baru=$qty_bulk+$qty_real;
                        $subtotal=$qty_rincian_baru*$harga_bulk;
                        
                        // Menghitung nilai PPN (jika subtotal bukan nol)
                        $rp_ppn = $subtotal > 0 ? ($ppn / 100) * $subtotal : 0;

                        // Menghitung nilai diskon (jika subtotal bukan nol)
                        $rp_diskon = $subtotal > 0 ? ($diskon / 100) * $subtotal : 0;

                        // Menghitung total
                        $total = ($subtotal + $rp_ppn) - $rp_diskon;
                    }else{
                        $id_transaksi_jual_beli_rincian=0;
                    }
                    
                    //Apabila Item barang yang sama sudah ada maka lakukan Update
                    if(!empty($id_transaksi_jual_beli_rincian)){
                        $UpdateRincian = mysqli_query($Conn,"UPDATE transaksi_jual_beli_rincian SET 
                            qty='$qty_rincian_baru',
                            ppn='$rp_ppn',
                            diskon='$rp_diskon',
                            subtotal='$total'
                        WHERE id_transaksi_jual_beli_rincian='$id_transaksi_jual_beli_rincian'") or die(mysqli_error($Conn)); 
                        if($UpdateRincian){
                            
                            //Lakukan Update Pada tabel barang
                            $UpdateBarang = mysqli_query($Conn,"UPDATE barang SET 
                                stok_barang='$stok_barang_baru'
                            WHERE id_barang='$id_barang'") or die(mysqli_error($Conn)); 
                            if($UpdateBarang){
                                $ValidasiProssesUpdateRincian="Valid";
                            }else{
                                $ValidasiProssesUpdateRincian="Terjadi Kesaslahan Pada Saat Update Data Barang";
                            }
                        }else{
                            $ValidasiProssesUpdateRincian="Terjadi Kesaslahan Pada Saat Update Data Rincian";
                        }
                    }else{
                        // Jika Item barang belum ada Maka Simpan Data Insert
                        $query = "INSERT INTO transaksi_jual_beli_rincian (
                            id_transaksi_jual_beli, 
                            id_barang,
                            nama_barang,
                            satuan,
                            qty,
                            harga,
                            ppn,
                            diskon,
                            subtotal
                        ) VALUES (
                            ?, ?, ?, ?, ?, ?, ?, ?, ?
                        )";
                        // Persiapkan statement
                        $stmt = mysqli_prepare($Conn, $query);
                        if (!$stmt) {
                            $ValidasiProssesUpdateRincian='Error dalam persiapan statement: '.mysqli_error($Conn).'';
                        }else{
                            // Bind parameter ke statement
                            mysqli_stmt_bind_param($stmt, "sisssssss", 
                                $id_transaksi_jual_beli, 
                                $id_barang, 
                                $nama_barang, 
                                $satuan_barang, 
                                $qty_real, 
                                $harga_numeric, 
                                $rp_ppn,
                                $rp_diskon,
                                $total
                            );

                            // Eksekusi statement
                            $Input = mysqli_stmt_execute($stmt);

                            // Cek apakah query berhasil dijalankan
                            if ($Input) {
                                //Lakukan Update Pada tabel barang
                                $UpdateBarang = mysqli_query($Conn,"UPDATE barang SET 
                                    stok_barang='$stok_barang_baru'
                                WHERE id_barang='$id_barang'") or die(mysqli_error($Conn)); 
                                if($UpdateBarang){
                                    $ValidasiProssesUpdateRincian="Valid";
                                }else{
                                    $ValidasiProssesUpdateRincian="Terjadi Kesaslahan Pada Saat Update Data Barang";
                                }
                            } else {
                                $ValidasiProssesUpdateRincian="Terjadi kesalahan pada saat menambahkan data barang ke rincian";
                            }
                        }
                    }

                    //Validasi Update/Insert Barang Ke Rincian
                    if($ValidasiProssesUpdateRincian!=="Valid"){
                        echo '
                            <div class="alert alert-danger">
                                <small>'.$ValidasiProssesUpdateRincian.'</small>
                            </div>
                        ';
                    }else{
                        //Melakukan Update Stok Barang
                        if($kategori_transaksi=="Retur Penjualan"){
                            $stok_baru=$stok_barang-$qty_real;
                        }else{
                            $stok_baru=$stok_barang+$qty_real;
                        }

                        // Query untuk menghitung subtotal
                        $query = "
                            SELECT 
                                SUM(qty * harga) AS subtotal 
                            FROM 
                                transaksi_jual_beli_rincian 
                            WHERE 
                                id_transaksi_jual_beli = '$id_transaksi_jual_beli'
                        ";

                        // Eksekusi query
                        $result = mysqli_query($Conn, $query);

                        if (!$result) {
                            echo '
                                <div class="alert alert-danger">
                                    <small>Terjadi kesalahan pada saat menghitung subtotal</small>
                                </div>
                            ';
                        }else{

                            // Ambil hasil query
                            $row = mysqli_fetch_assoc($result);
                            $subtotal = $row['subtotal'];

                            // Jika subtotal NULL (tidak ada data), set ke 0
                            if ($subtotal === NULL) {
                                $subtotal = 0;
                            }

                            //Hitung Jumlah PPN
                            $SumPpn = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(ppn) AS jumlah_ppn FROM transaksi_jual_beli_rincian WHERE id_transaksi_jual_beli = '$id_transaksi_jual_beli'"));
                            $jumlah_ppn = $SumPpn['jumlah_ppn'];
                            
                            //Hitung Jumlah Diskon
                            $SumDiskon = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(diskon) AS jumlah_diskon FROM transaksi_jual_beli_rincian WHERE id_transaksi_jual_beli = '$id_transaksi_jual_beli'"));
                            $jumlah_diskon = $SumDiskon['jumlah_diskon'];

                            //Hitung Jumlah Total
                            $sub_subtotal = mysqli_fetch_array(mysqli_query($Conn, "SELECT SUM(subtotal) AS jumlah_subtotal FROM transaksi_jual_beli_rincian WHERE id_transaksi_jual_beli = '$id_transaksi_jual_beli'"));
                            $jumlah_subtotal = $sub_subtotal['jumlah_subtotal'];

                            //Buka Data Transaksi Sebelumnya Untuk Mengetahui Cash
                            $cash=GetDetailData($Conn, 'transaksi_jual_beli', 'id_transaksi_jual_beli', $id_transaksi_jual_beli, 'cash');

                            //Apabila Jumlah Cash Kurang maka Kredit
                            if($cash<$jumlah_subtotal){
                                $status="Kredit";
                            }else{
                                $status="Lunas";
                            }
                            //Update Transaksi
                            $UpdateTransaksi = mysqli_query($Conn,"UPDATE transaksi_jual_beli SET 
                                subtotal='$subtotal',
                                diskon='$jumlah_diskon',
                                ppn='$jumlah_ppn',
                                total='$jumlah_subtotal',
                                status='$status'
                            WHERE id_transaksi_jual_beli='$id_transaksi_jual_beli'") or die(mysqli_error($Conn)); 
                            if($UpdateTransaksi){
                                echo '
                                    <div id="NotifikasiTambahBarangEditBerhasil" class="alert alert-success">Success</div>
                                ';
                            }else{
                                echo '
                                    <div class="alert alert-danger">Terjadi Kesalahan pada saat update data transaksi</div>
                                ';
                            }
                        }
                    }
                }
            }
        }
    }
?>
