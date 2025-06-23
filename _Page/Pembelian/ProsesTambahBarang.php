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
            if(empty($_POST['kategori_transaksi'])){
                echo '
                    <div class="alert alert-danger">
                        <small>Kategori Transaksi Tidak Boleh Kosong!</small>
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
                    $kategori_transaksi = $_POST['kategori_transaksi'];
                    $nama_barang = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'nama_barang');
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
                    
                    //Cek apakah data barang sudah ada pada bulk
                    $QryBulk = mysqli_query($Conn,"SELECT * FROM transaksi_bulk WHERE id_barang='$id_barang' AND id_akses='$SessionIdAkses' AND kategori='$kategori_transaksi'")or die(mysqli_error($Conn));
                    $DataBulk= mysqli_fetch_array($QryBulk);
                    if(!empty($DataBulk['id_transaksi_bulk'])){
                        $id_transaksi_bulk= $DataBulk['id_transaksi_bulk'];
                        $harga_bulk= $DataBulk['harga'];
                        $satuan_bulk= $DataBulk['satuan'];
                        $qty_bulk= $DataBulk['qty'];
                        //Bulatkan harga
                        $harga_bulk = (float) $harga_bulk; // Konversi ke float
                        $harga_bulk = ($harga_bulk == floor($harga_bulk)) ? (int)$harga_bulk : $harga_bulk;
                        
                        //Persiapan Data Update
                        $qty=$qty_bulk+$qty_real;
                        $subtotal=$qty*$harga_bulk;
                        
                        // Menghitung nilai PPN (jika subtotal bukan nol)
                        $rp_ppn = $subtotal > 0 ? ($ppn / 100) * $subtotal : 0;

                        // Menghitung nilai diskon (jika subtotal bukan nol)
                        $rp_diskon = $subtotal > 0 ? ($diskon / 100) * $subtotal : 0;

                        // Menghitung total
                        $total = ($subtotal + $rp_ppn) - $rp_diskon;
                    }else{
                        $id_transaksi_bulk=0;
                    }
                    
                    //Apabila Item barang sudah ada dan sama maka Update
                    if(!empty($id_transaksi_bulk)){
                        $UpdateBulk = mysqli_query($Conn,"UPDATE transaksi_bulk SET 
                            qty='$qty',
                            ppn='$rp_ppn',
                            diskon='$rp_diskon',
                            subtotal='$total'
                        WHERE id_transaksi_bulk='$id_transaksi_bulk'") or die(mysqli_error($Conn)); 
                        if($UpdateBulk){
                            echo '
                                <div class="alert alert-success">
                                    <small id="NotifikasiTambahBarangBerhasil">Success</small>
                                </div>
                            ';
                        }else{
                            echo '
                                <div class="alert alert-danger">
                                    <small>Terjadi kesalahan pada saat melakukan update</small>
                                </div>
                            ';
                        }
                    }else{
                        // Jika Tidak Ada Maka Simpan Data Simpan Data Ke Database Bulk
                        $query = "INSERT INTO transaksi_bulk (
                            id_akses,
                            kategori,
                            id_barang,
                            nama_barang,
                            satuan,
                            qty,
                            harga,
                            ppn,
                            diskon,
                            subtotal
                        ) VALUES (
                            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                        )";
                        // Persiapkan statement
                        $stmt = mysqli_prepare($Conn, $query);
                        if (!$stmt) {
                            die("Error dalam persiapan statement: " . mysqli_error($Conn));
                        }
                        // Bind parameter ke statement
                        mysqli_stmt_bind_param($stmt, "isisssssss", 
                            $SessionIdAkses, 
                            $kategori_transaksi, 
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
                            echo '
                                <div class="alert alert-success">
                                    <small id="NotifikasiTambahBarangBerhasil">Success</small>
                                </div>
                            ';
                        } else {
                            echo '
                                <div class="alert alert-danger">
                                    <small>Terjadi kesalahan pada saat menyimpan data rincian transaksi</small>
                                    '.$SessionIdAkses.'<br> 
                                    '.$kategori_transaksi.'<br>  
                                    '.$id_barang.'<br> , 
                                    '.$nama_barang.'<br>  
                                    Satuan: '.$satuan_barang.'<br>  
                                    Qty: '.$qty_real.'<br>  
                                    Harga : '.$harga_numeric.'<br> 
                                    PPN : '.$rp_ppn.'<br> 
                                    Diskon :'.$rp_diskon.'<br> 
                                    Total :'.$total.'
                                </div>
                            ';
                        }
                    }
                }
            }
        }
    }
?>
