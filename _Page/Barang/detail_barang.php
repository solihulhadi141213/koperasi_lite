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
            'id_barang' => "ID Barang Tidak Boleh Kosong!"
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
        $id_barang = validateAndSanitizeInput($_POST['id_barang']);
        //Buka Data
        $Qry = $Conn->prepare("SELECT * FROM barang WHERE id_barang = ?");
        $Qry->bind_param("s", $id_barang);
        if (!$Qry->execute()) {
            $error=$Conn->error;
            $response = [
                "status" => "Error",
                "message" => $error
            ];
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
            //Hitung Jumlah Item
            $jumlah_multi_harga = mysqli_num_rows(mysqli_query($Conn, "SELECT id_barang_harga FROM barang_harga WHERE id_barang='$id_barang'"));
            $dataset = [
                "id_barang" => $id_barang,
                "kode_barang" => $kode_barang,
                "nama_barang" => $nama_barang,
                "kategori_barang" => $kategori_barang,
                "satuan_barang" => $satuan_barang,
                "konversi" => $konversi,
                "harga_beli" => $harga_beli,
                "harga_beli_format" => $harga_beli_format,
                "stok_barang" => $stok_barang,
                "stok_minimum" => $stok_minimum,
            ];

            //Buat List Multi harga
            $multi_harga = [];

            // Query dengan LEFT JOIN untuk memastikan semua kategori harga tetap muncul
            $sql = "SELECT bkh.kategori_harga, COALESCE(bh.harga, 0) AS harga 
                    FROM barang_kategori_harga bkh
                    LEFT JOIN barang_harga bh 
                    ON bkh.id_barang_kategori_harga = bh.id_barang_kategori_harga
                    AND bh.id_barang = ?";  // Filter id_barang dipindah ke dalam ON agar kategori tetap muncul

            $stmt = $Conn->prepare($sql);
            $stmt->bind_param("i", $id_barang); // Bind parameter dengan tipe integer
            $stmt->execute();
            $result = $stmt->get_result();

            // Looping hasil query
            while ($row = $result->fetch_assoc()) {
                // Format harga agar lebih rapi
                $harga_multi = $row['harga'];
                $selisih = $harga_multi-$harga_beli;
                $persen_laba = ($selisih/$harga_beli)*100;
                $persen_laba = round($persen_laba);
                $harga_multi_format = number_format($row['harga'], 0, ',', '.');

                // Masukkan ke dalam array multi_harga
                $multi_harga[] = [
                    "kategori_harga" => $row['kategori_harga'],
                    "harga" => $harga_multi,
                    "persen_laba" => $persen_laba,
                    "harga_format" => $harga_multi_format,
                ];
            }
            $stmt->close();

            //Buat Arry Response
            $response = [
                "status" => "Success",
                "message" => "Data Ditemukan",
                "dataset" => $dataset,
                "multi_harga" => $multi_harga,
            ];
        }
    }

    // Output response
    echo json_encode($response);
?>
