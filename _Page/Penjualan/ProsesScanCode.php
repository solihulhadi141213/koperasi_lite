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
        if(empty($_POST['keyword_code'])){
            echo '
                <div class="alert alert-danger">
                    <small>Kode barang Tidak Boleh Kosong!</small>
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
                if(empty($_POST['qty_scan_code'])){
                    echo '
                        <div class="alert alert-danger">
                            <small>Jumlah Barang Tidak Boleh Kosong!</small>
                        </div>
                    ';
                } else {
                    $keyword_code = $_POST['keyword_code'];
                    $kategori_transaksi = $_POST['kategori_transaksi'];
                    $qty = $_POST['qty_scan_code'];
                    $id_barang = GetDetailData($Conn, 'barang', 'kode_barang', $keyword_code, 'id_barang');
                    //apabila data tidak ditrmukan
                    if(empty($id_barang)){
                        echo '
                            <div class="alert alert-danger">
                                <small>Data Tidak Ditemukan!</small>
                            </div>
                        ';
                    }else{
                        $nama_barang = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'nama_barang');
                        $kode_barang = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'kode_barang');
                        $konversi = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'konversi');
                        $satuan_barang = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'satuan_barang');

                        $harga=0;
                        //Apabila id_barang_kategori_harga kosong maka ambil harga dari tabel barang
                        if(empty($_POST['id_barang_kategori_harga'])){
                            $harga = GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'harga_beli');
                        } else {
                            $id_barang_kategori_harga = $_POST['id_barang_kategori_harga'];
                            //Apabila Ada maka buka dari barang_harga
                            $QryHarga = mysqli_query($Conn,"SELECT * FROM barang_harga WHERE id_barang='$id_barang' AND id_barang_kategori_harga='$id_barang_kategori_harga'")or die(mysqli_error($Conn));
                            $DataHarga= mysqli_fetch_array($QryHarga);
                            if(empty($DataHarga['harga'])){
                                $harga=0;
                            }else{
                                $harga=$DataHarga['harga'];
                            }
                        }
                        // Menghitung subtotal
                        $subtotal = $qty * $harga;

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
                            $qty=$qty_bulk+$qty;
                            $subtotal=$qty*$harga;
                        }else{
                            $id_transaksi_bulk=0;
                        }
                    
                        //Apabila Item barang sudah ada dan sama maka Update
                        if(!empty($id_transaksi_bulk)){
                            $UpdateBulk = mysqli_query($Conn,"UPDATE transaksi_bulk SET 
                                qty='$qty',
                                ppn='0',
                                diskon='0',
                                subtotal='$subtotal'
                            WHERE id_transaksi_bulk='$id_transaksi_bulk'") or die(mysqli_error($Conn)); 
                            if($UpdateBulk){
                                $harga_rp = "Rp " . number_format($harga,0,',','.');
                                echo '
                                    <div class="row mb-2">
                                        <div class="col-4"><small>Proses</small></div>
                                        <div class="col-8 text-end"><small class="text text-success" id="NotifikasiScanCodeBerhasil">Success</small></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><small>Kode Barang</small></div>
                                        <div class="col-8 text-end"><small class="text text-grayish">'.$kode_barang.'</small></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><small>Nama Barang</small></div>
                                        <div class="col-8 text-end"><small class="text text-grayish">'.$nama_barang.'</small></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><small>Harga</small></div>
                                        <div class="col-8 text-end"><small class="text text-grayish">'.$harga_rp.'</small></div>
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
                            $rp_ppn=0;
                            $rp_diskon=0;
                            // Bind parameter ke statement
                            mysqli_stmt_bind_param($stmt, "isisssssss", 
                                $SessionIdAkses, 
                                $kategori_transaksi, 
                                $id_barang, 
                                $nama_barang, 
                                $satuan_barang, 
                                $qty, 
                                $harga, 
                                $rp_ppn,
                                $rp_diskon,
                                $subtotal
                            );
                            
                            // Eksekusi statement
                            $Input = mysqli_stmt_execute($stmt);

                            // Cek apakah query berhasil dijalankan
                            if ($Input) {
                                $harga_rp = "Rp " . number_format($harga,0,',','.');
                                echo '
                                    <div class="row mb-2">
                                        <div class="col-4"><small>Proses</small></div>
                                        <div class="col-8 text-end"><small class="text text-success" id="NotifikasiScanCodeBerhasil">Success</small></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><small>Kode Barang</small></div>
                                        <div class="col-8 text-end"><small class="text text-grayish">'.$kode_barang.'</small></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><small>Nama Barang</small></div>
                                        <div class="col-8 text-end"><small class="text text-grayish">'.$nama_barang.'</small></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4"><small>Harga</small></div>
                                        <div class="col-8 text-end"><small class="text text-grayish">'.$harga_rp.'</small></div>
                                    </div>
                                ';
                            } else {
                                echo '
                                    <div class="alert alert-danger">
                                        <small>Terjadi kesalahan pada saat menyimpan data rincian transaksi</small>
                                    </div>
                                ';
                            }
                        }
                    }
                }
            }
        }
    }
?>
