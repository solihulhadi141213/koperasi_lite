<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');

    // Validasi sesi login
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir, Silahkan Login Ulang!</small>
            </div>
        ';
    } else {
        if (empty($_POST['id_barang'])) {
            echo '
                <div class="alert alert-danger">
                    <small>ID Barang Tidak Boleh Kosong!</small>
                </div>
            ';
        } else {
            if (empty($_POST['type_code'])) {
                echo '
                    <div class="alert alert-danger">
                        <small>Type Code Tidak Boleh Kosong!</small>
                    </div>
                ';
            } else {
                // Buat Variabel
                $id_barang = validateAndSanitizeInput($_POST['id_barang']);
                $type_code = validateAndSanitizeInput($_POST['type_code']);
                //Buka Data
                $Qry = $Conn->prepare("SELECT * FROM barang WHERE id_barang = ?");
                $Qry->bind_param("s", $id_barang);
                if (!$Qry->execute()) {
                    $error=$Conn->error;
                    echo '
                        <div class="alert alert-danger">
                            <small>Terjadi Kesalahan Pada Saat Membuka Data Barang!<br>Keterangan : '.$error.'</small>
                        </div>
                    ';
                }else{
                    $Result = $Qry->get_result();
                    $Data = $Result->fetch_assoc();
                    $Qry->close();
                    //Buat Variabel
                    $kode_barang=$Data['kode_barang'];
                    $nama_barang=$Data['nama_barang'];
                    $kategori_barang=$Data['kategori_barang'];
                    $satuan_barang=$Data['satuan_barang'];
                    $konversi=$Data['konversi'];
                    $harga_beli=$Data['harga_beli'];
                    $stok_barang=$Data['stok_barang'];
                    $stok_minimum=$Data['stok_minimum'];
                    //Lakukan pembulatan
                    $harga_beli = (float) $harga_beli; // Konversi ke float
                    $harga_beli = ($harga_beli == floor($harga_beli)) ? (int)$harga_beli : $harga_beli;
                    //Format Harga RP
                    $harga_beli_format = "Rp " . number_format($harga_beli,0,',','.');

                    //Buka Kategori Harga
                    if (empty($_POST['id_barang_kategori_harga'])) {
                        $harga_barang="";
                    } else {
                        //Buat Variabel
                        $id_barang_kategori_harga=$_POST['id_barang_kategori_harga'];

                        //Buka Kategori Harga
                        $QryHarga = $Conn->prepare("SELECT * FROM barang_harga WHERE id_barang_kategori_harga = ? AND id_barang = ?");
                        $QryHarga->bind_param("ii", $id_barang_kategori_harga, $id_barang);
                        if (!$QryHarga->execute()) {
                            $harga_barang=$Conn->error;
                        }else{
                            $ResultHarga = $QryHarga->get_result();
                            $DataHarga = $ResultHarga->fetch_assoc();
                            $QryHarga->close();
                            //Buat Variabel
                            $harga_barang=$DataHarga['harga'];
                            $harga_barang = "Rp " . number_format($harga_barang,0,',','.');
                        }
                        
                    }
                    if (empty($_POST['tampilkan_nama_barang_for_code'])) {
                        $nama_barang="";
                    }else{
                        if($_POST['tampilkan_nama_barang_for_code']=="Tidak"){
                            $nama_barang="";
                        }
                    }
                    //Buat Element untuk preview

                    if($type_code=="code128"||$type_code=="code39"||$type_code=="code25"){
                        echo '
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <small class="name_of_product">'.$nama_barang.'</small><br>
                                    <img src="assets/vendor/barcode.php?text='.$kode_barang.'&size=65&codetype='.$type_code.'" alt="'.$kode_barang.'" /><br>
                                    <small class="price_of_product">'.$harga_barang.'</small>
                                </div>
                            </div>
                        ';
                    }else{
                        include "../../assets/vendor/phpqrcode/qrlib.php";
                        // Mulai output buffering
                        $level = QR_ECLEVEL_H; // Tingkat koreksi error (H = High)
                        $size = 4;             // Ukuran skala
                        $margin = 0;           // Margin (default 4)

                        // Mulai output buffering
                        ob_start();
                        QRcode::png($kode_barang, null, $level, $size, $margin);
                        $imageString = base64_encode(ob_get_contents());
                        ob_end_clean();
                        echo '
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <small class="name_of_product">'.$nama_barang.'</small><br>
                                    <img src="data:image/png;base64,'.$imageString.'" alt="QR Code" width="180px"><br>
                                    <small class="price_of_product">'.$harga_barang.'</small>
                                </div>
                            </div>
                        ';
                    }
                    
                }
            }
        }
    }
?>
