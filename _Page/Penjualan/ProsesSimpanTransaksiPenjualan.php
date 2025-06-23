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

    // Validasi sesi login
    if (empty($SessionIdAkses)) {
        $response = [
            "status" => "Error",
            "message" => "Sesi Akses Sudah Berakhir, Silahkan Login Ulang"
        ];
    } else {
        // Validasi Data Tidak Boleh Kosong
        $requiredFields = [
            'kategori_transaksi'    => "Kategori Transaksi Tidak Boleh Kosong!",
            'tanggal'               => "Tanggal Transaksi Tidak Boleh Kosong!",
            'jam'                   => "Jam Transaksi Tidak Boleh Kosong!",
            'status'                => "Status Transaksi Tidak Boleh Kosong!",
        ];

        foreach ($requiredFields as $field => $errorMessage) {
            if (empty($_POST[$field])) {
                $response = [
                    "status" => "Error",
                    "message" => $errorMessage
                ];
                echo json_encode($response);
                exit;
            }
        }
        // Buat Variabel
        $kategori_transaksi = validateAndSanitizeInput($_POST['kategori_transaksi']);
        $tanggal = validateAndSanitizeInput($_POST['tanggal']);
        $jam = validateAndSanitizeInput($_POST['jam']);
        $tanggal="$tanggal $jam";
        $status = validateAndSanitizeInput($_POST['status']);

        //Variabel Lain Yang Tidak Wajib
        if(empty($_POST['put_id_anggota_for_add_penjualan'])){
            $id_anggota=null;
            $validasi_anggota="Valid";
        }else{
            $id_anggota=$_POST['put_id_anggota_for_add_penjualan'];
            if($id_anggota=="1"){
                $validasi_anggota="ID Anggota 1 Terus";
            }else{
                $validasi_id_anggota=mysqli_num_rows(mysqli_query($Conn, "SELECT id_anggota FROM anggota WHERE id_anggota='$id_anggota'"));
                if(empty($validasi_id_anggota)){
                    $validasi_anggota="ID Anggota Tidak Ditemukan!";
                }else{
                    $validasi_anggota="Valid";
                }
            }
        }
        if(empty($_POST['total'])){
            $total=0;
        }else{
            $total=validateAndSanitizeInput($_POST['total']);
        }
        if(empty($_POST['cash'])){
            $cash=0;
        }else{
            $cash=validateAndSanitizeInput($_POST['cash']);
        }
        if(empty($_POST['kembalian'])){
            $kembalian=0;
        }else{
            $kembalian=validateAndSanitizeInput($_POST['kembalian']);
        }
        //Hapus Titik Pada Nilai Angka Rupiah
        $total = str_replace('.', '', $total);
        $cash = str_replace('.', '', $cash);
        $kembalian = str_replace('.', '', $kembalian);

        //Validasi Anggota
        if($validasi_anggota!=="Valid"){
            $response = [
                "status" => "Error",
                "message" => "$validasi_anggota"
            ];
        }else{

            //Menghitung Data Dari Bulk
            $jumlah_bulk=mysqli_num_rows(mysqli_query($Conn, "SELECT id_transaksi_bulk FROM transaksi_bulk WHERE id_akses='$SessionIdAkses' AND kategori='$kategori_transaksi'"));
            
            if(empty($jumlah_bulk)){
                $response = [
                    "status" => "Error",
                    "message" => "Belum ada data rincian untuk transaksi ini!"
                ];
            }else{

                // Query untuk menghitung total transaksi, total PPN, dan total diskon
                $query_sum = "
                SELECT 
                    SUM(qty * harga) AS total_transaksi, 
                    SUM(ppn) AS total_ppn, 
                    SUM(diskon) AS total_diskon 
                FROM transaksi_bulk 
                WHERE kategori = ? AND id_akses = ?";

                $stmt_sum = $Conn->prepare($query_sum);
                $stmt_sum->bind_param("si", $kategori_transaksi, $SessionIdAkses);
                $stmt_sum->execute();
                $result_sum = $stmt_sum->get_result();
                $row_sum = $result_sum->fetch_assoc();

                $total_transaksi = $row_sum['total_transaksi'] ?? 0;
                $total_ppn = $row_sum['total_ppn'] ?? 0;
                $total_diskon = $row_sum['total_diskon'] ?? 0;

                //Buat ID Transaksi
                $id_transaksi_jual_beli=generateRandomString(36);

                //Karena ini transaksi penjualan maka
                $id_supplier=null;

                //Insert Ke Database transaksi_jual_beli
                $query = "INSERT INTO transaksi_jual_beli (
                    id_transaksi_jual_beli, 
                    id_anggota, 
                    id_supplier, 
                    kategori, 
                    tanggal, 
                    subtotal, 
                    diskon, 
                    ppn, 
                    total, 
                    cash, 
                    kembalian, 
                    status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $Conn->prepare($query);
                if ($stmt) {
                    $stmt->bind_param(
                        "ssssssssssss",
                        $id_transaksi_jual_beli,
                        $id_anggota,
                        $id_supplier,
                        $kategori_transaksi,
                        $tanggal,
                        $total_transaksi,
                        $total_diskon,
                        $total_ppn,
                        $total,
                        $cash,
                        $kembalian,
                        $status
                    );
                    if ($stmt->execute()) {

                        //Jika Berhasil Input transaksi bulk ke transaksi rincian
                        $jumlah_error=0;
                        $error_item = [];
                        $item_no=1;
                        $query = mysqli_query($Conn, "SELECT*FROM transaksi_bulk WHERE id_akses='$SessionIdAkses' AND kategori='$kategori_transaksi' ORDER BY id_transaksi_bulk DESC");
                        while ($data = mysqli_fetch_array($query)) {
                            $id_transaksi_bulk= $data['id_transaksi_bulk'];
                            $id_akses= $data['id_akses'];
                            $kategori= $data['kategori'];
                            $id_barang= $data['id_barang'];
                            $nama_barang= $data['nama_barang'];
                            $satuan= $data['satuan'];
                            $qty= $data['qty'];
                            $harga= $data['harga'];
                            $ppn= $data['ppn'];
                            $diskon= $data['diskon'];
                            $subtotal= $data['subtotal'];

                            //Buka Harga Beli Barang
                            $harga_beli=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'harga_beli');
                            if(empty($harga_beli)){
                                $harga_beli=0;
                            }
                            //Simpan Data ke tabel transaksi_jual_beli_rincian
                            $query2 = "INSERT INTO transaksi_jual_beli_rincian (
                                id_transaksi_jual_beli,
                                id_barang,
                                nama_barang,
                                satuan,
                                qty,
                                hpp,
                                harga,
                                ppn,
                                diskon,
                                subtotal
                            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                            // Persiapkan statement ke 2
                            $stmt2 = mysqli_prepare($Conn, $query2);
                            if (!$stmt2) {
                                $jumlah_error=$jumlah_error+1;
                                $error_item[]="Error Statment in item $item_no";
                            }else{
                                // Bind parameter ke statement
                                mysqli_stmt_bind_param($stmt2, "sissssssss", 
                                    $id_transaksi_jual_beli, 
                                    $id_barang, 
                                    $nama_barang, 
                                    $satuan, 
                                    $qty, 
                                    $harga_beli, 
                                    $harga, 
                                    $ppn,
                                    $diskon,
                                    $subtotal
                                );
                            
                                // Eksekusi statement
                                $Input2 = mysqli_stmt_execute($stmt2);

                                // Cek apakah query berhasil dijalankan
                                if ($Input2) {
                                    
                                    //Jika Berhasil Hapus Bulk
                                    $HapusBulk = mysqli_query($Conn, "DELETE FROM transaksi_bulk WHERE id_transaksi_bulk='$id_transaksi_bulk'") or die(mysqli_error($Conn));
                                    if ($HapusBulk) {
                                        //Jika Hapus Berhasil Lakukan Update Data Stok Barang

                                        //Buka Stok lama
                                        $stok_barang_lama=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'stok_barang');

                                        //Buka nilai konversi
                                        $konversi=GetDetailData($Conn, 'barang', 'id_barang', $id_barang, 'konversi');

                                        //Jika Satuan Yang Digunakan Adalah Multi
                                        $konversi_multi=GetDetailData($Conn, 'barang_satuan', 'satuan_multi', $satuan, 'konversi_multi');
                                        if(!empty($konversi_multi)){
                                            $qty=$qty*($konversi_multi/$konversi);

                                            //Update Stok Untuk kategori Penjualan
                                            if($kategori_transaksi=="Penjualan"){
                                                $stok_barang=$stok_barang_lama-$qty;
                                            }else{
                                                $stok_barang=$stok_barang_lama+$qty;
                                            }
                                            
                                        }else{
                                            //Jika satuan yang digunakan adalah utama
                                            if($kategori_transaksi=="Penjualan"){
                                                $stok_barang=$stok_barang_lama-$qty;
                                            }else{
                                                $stok_barang=$stok_barang_lama+$qty;
                                            }
                                        }

                                        //Proses Update
                                        $update_barang = mysqli_query($Conn,"UPDATE barang SET 
                                            stok_barang='$stok_barang'
                                        WHERE id_barang='$id_barang'") or die(mysqli_error($Conn)); 
                                        if($update_barang){
                                            $jumlah_error=$jumlah_error+0;
                                        }else{
                                            $jumlah_error=$jumlah_error+1;
                                            $error_item[]="Error Update in item $item_no";
                                        }
                                    }else{
                                        $jumlah_error=$jumlah_error+1;
                                        $error_item[]="Error Delete in item $item_no";
                                    }
                                }else{
                                    $jumlah_error=$jumlah_error+1;
                                    $error_item[]="Error Input in item $item_no";
                                }
                            }
                            $item_no++;
                        }
                        $error_item_list=implode(',', $error_item);
                        //Jika Ada Error
                        if(!empty($jumlah_error)){
                            $response = [
                                "status" => "Error",
                                "message" => "Ada Beberapa Item Barang Yang Gagal Ditangani.Data :  $error_item_list"
                            ];
                        }else{

                            //Format tanggal
                            $tanggal_jurnal=date('Y-m-d',strtotime($tanggal));

                            //Hitung HPP Penjualan
                            $query_hpp = "SELECT SUM(hpp * qty) AS total_hpp 
                                    FROM transaksi_jual_beli_rincian 
                                    WHERE id_transaksi_jual_beli = ?";

                            // Siapkan statement
                            $stmt_hpp = $Conn->prepare($query_hpp);
                            $stmt_hpp->bind_param("s", $id_transaksi_jual_beli); // "s" untuk tipe string

                            // stmt_hpp statement
                            $stmt_hpp->execute();

                            // Ambil hasil
                            $result_hpp = $stmt_hpp->get_result();
                            $row_hpp = $result_hpp->fetch_assoc();
                            $total_hpp = $row_hpp['total_hpp'] ?? 0;
                            
                            //Simpan Auto Jurnal Berdasarkan Kategori Transaksi
                            if($kategori_transaksi=="Penjualan"){
                                $auto_jurnal=AutoJurnalPenjualan($Conn, $kategori_transaksi, $tanggal_jurnal, $id_transaksi_jual_beli, $total, $cash, $total_hpp, $status);
                            }else{
                                $auto_jurnal=AutoJurnalReturPenjualan($Conn, $kategori_transaksi, $tanggal_jurnal, $id_transaksi_jual_beli, $total, $cash, $total_hpp, $status);
                            }
                            
                            if($auto_jurnal!=="Success"){
                                $response = [
                                    "status" => "Error",
                                    "message" => $auto_jurnal
                                ];
                            }else{
                                $kategori_log="Transaksi Penjualan";
                                $deskripsi_log="Tambah Transaksi Penjualan";
                                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                                if($InputLog=="Success"){
                                    $response = [
                                        "status" => "Success",
                                        "message" => "Tambah Transaksi Penjualan Berhasil!",
                                        "id_transaksi_jual_beli" => $id_transaksi_jual_beli,
                                    ];
                                }else{
                                    $response = [
                                        "status" => "Error",
                                        "message" => "Terjadi kesalahan pada saat menyimpan log aktivitas"
                                    ];
                                }
                            }
                        }
                    } else {
                        $response = [
                            "status" => "Error",
                            "message" => "Terjadi kesalahan pada saat input ke database <br>$stmt->error"
                        ];
                    }
                    $stmt_sum->close();
                } else {
                    $response = [
                        "status" => "Error",
                        "message" => "Terjadi kesalahan pada saat mempersiapkan statement database"
                    ];
                }
            }
        }
    }

    // Output response
    echo json_encode($response);
?>
