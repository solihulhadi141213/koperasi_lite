<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');

    // Time Now Tmp
    $now = date('Y-m-d H:i:s');
    
    //Validasi Kelengkapan Data
    if(empty($_POST['id_barang'])){
        echo '<div class="alert alert-danger">ID Barang Tidak Boleh Kosong!</div>';
        exit;
    }
    if(empty($_POST['id_stok_opename'])){
        echo '<div class="alert alert-danger">ID Sesi Stock Opename Tidak Boleh Kosong!</div>';
        exit;
    }
    $id_barang = validateAndSanitizeInput($_POST['id_barang']);
    $id_stok_opename = validateAndSanitizeInput($_POST['id_stok_opename']);
    if(empty($_POST['id_stok_opename_barang'])){
        $id_stok_opename_barang="";
    }else{
        $id_stok_opename_barang=validateAndSanitizeInput($_POST['id_stok_opename_barang']);
    }
    if(empty($_POST['stok_awal'])){
        $stok_awal=0;
    }else{
        $stok_awal=validateAndSanitizeInput($_POST['stok_awal']);
    }
    if(empty($_POST['stok_akhir'])){
        $stok_akhir=0;
    }else{
        $stok_akhir=validateAndSanitizeInput($_POST['stok_akhir']);
    }
    if(empty($_POST['harga'])){
        $harga=0;
    }else{
        $harga=validateAndSanitizeInput($_POST['harga']);
    }
    $harga= str_replace(".", "", $harga);
    
    //Validasi Nominal
    if(!preg_match("/^[0-9]*$/", $stok_awal)){
        echo '<div class="alert alert-danger">Stock Awal Hanya Boleh Angka!</div>';
    }else{
        if(!preg_match("/^[0-9]*$/", $stok_akhir)){
            echo '<div class="alert alert-danger">Stock Akhir Hanya Boleh Angka!</div>';
        }else{
            if(!preg_match("/^[0-9]*$/", $harga)){
                echo '<div class="alert alert-danger">Harga Hanya Boleh Angka!</div>';
            }else{
                //Hitung selisih
                $stok_gap=$stok_akhir-$stok_awal;

                //Hitung Jumlah
                $jumlah=$stok_gap*$harga;
                
                //Apabila Data Baru maka insert
                if(empty($id_stok_opename_barang)){
                    // Query untuk menyimpan data menggunakan prepared statement
                    $query = "INSERT INTO stok_opename_barang (
                        id_stok_opename,
                        id_barang,
                        stok_awal,
                        stok_akhir,
                        stok_gap,
                        harga_beli,
                        jumlah
                    ) VALUES (
                        ?, ?, ?, ?, ?, ?, ?
                    )";
                    // Persiapkan statement
                    $stmt = mysqli_prepare($Conn, $query);
                    if (!$stmt) {
                        die("Error dalam persiapan statement: " . mysqli_error($Conn));
                    }
                    // Bind parameter ke statement
                    mysqli_stmt_bind_param($stmt, "sssssss", $id_stok_opename, $id_barang, $stok_awal, $stok_akhir, $stok_gap, $harga, $jumlah);
                    
                    // Eksekusi statement
                    $Input = mysqli_stmt_execute($stmt);

                    // Cek apakah query berhasil dijalankan
                    if ($Input) {
                        $validasi_proses = "Berhasil";
                        echo "Data berhasil disimpan!";
                    } else {
                        $validasi_proses = "Terjadi Kesalahan Ketika Input Data Stock Opename Barang";
                        echo "Error: " . mysqli_error($Conn);
                    }

                    // Tutup statement
                    mysqli_stmt_close($stmt);
                }else{
                    //Apabila Data lama maka Update
                    $Update = mysqli_query($Conn,"UPDATE stok_opename_barang SET 
                        stok_awal='$stok_awal',
                        stok_akhir='$stok_akhir',
                        stok_gap='$stok_gap',
                        harga_beli='$harga',
                        jumlah='$jumlah'
                    WHERE id_stok_opename_barang='$id_stok_opename_barang'") or die(mysqli_error($Conn)); 
                    if($Update){
                        $validasi_proses="Berhasil";
                    }else{
                        $validasi_proses="Terjadi Kesalahan Ketika Update Data Stock Opename Barang";
                    }
                }
                if($validasi_proses!=="Berhasil"){
                    echo '<div class="alert alert-danger">'.$validasi_proses.'</div>';
                }else{
                    //Update data barang
                    $UpdateBarang = mysqli_query($Conn,"UPDATE barang SET 
                        harga_beli='$harga',
                        stok_barang='$stok_akhir'
                    WHERE id_barang='$id_barang'") or die(mysqli_error($Conn)); 
                    if($UpdateBarang){
                        $kategori_log="Barang";
                        $deskripsi_log="Atur Stock Opename Barang";
                        $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                        if($InputLog=="Success"){
                            echo '<small class="text-success" id="NotifikasiStockOpenameBerhasil">Success</small>';
                        }else{
                            echo '<div class="alert alert-danger">Terjadi kesalahan pada saat menyimpan log aktivitas</div>';
                        }
                    }else{
                        echo '<div class="alert alert-danger">Terjadi Kesalahan pada saat update barang</div>';
                    }
                }
            }
        }
    }
?>