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
            'id_transaksi_bulk' => "ID Rincian Tidak Boleh Kosong!"
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
        $id_transaksi_bulk = validateAndSanitizeInput($_POST['id_transaksi_bulk']);
        //Buka Data
        $Qry = $Conn->prepare("SELECT * FROM transaksi_bulk WHERE id_transaksi_bulk = ?");
        $Qry->bind_param("s", $id_transaksi_bulk);
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
            $id_akses=$Data['id_akses'];
            $kategori=$Data['kategori'];
            $id_barang=$Data['id_barang'];
            $nama_barang=$Data['nama_barang'];
            $satuan=$Data['satuan'];
            $qty=$Data['qty'];
            $harga=$Data['harga'];
            $ppn=$Data['ppn'];
            $diskon=$Data['diskon'];
            $subtotal=$Data['subtotal'];
            //Lakukan pembulatan
            $qty=pembulatan_nilai($qty);
            $harga=pembulatan_nilai($harga);
            $ppn=pembulatan_nilai($ppn);
            $diskon=pembulatan_nilai($diskon);
            $subtotal=pembulatan_nilai($subtotal);
            //Format Rupiah
            $harga_rp = "Rp " . number_format($harga,0,',','.');
            $subtotal_rp = "Rp " . number_format($subtotal,0,',','.');
            $ppn_rp = "Rp " . number_format($ppn,0,',','.');
            $diskon_rp = "Rp " . number_format($diskon,0,',','.');
            $dataset = [
                "id_akses" => $id_akses,
                "kategori" => $kategori,
                "id_barang" => $id_barang,
                "nama_barang" => $nama_barang,
                "satuan" => $satuan,
                "qty" => $qty,
                "harga" => $harga,
                "ppn" => $ppn,
                "diskon" => $diskon,
                "subtotal" => $subtotal,
                "harga_rp" => $harga_rp,
                "ppn_rp" => $ppn_rp,
                "diskon_rp" => $diskon_rp,
                "subtotal_rp" => $subtotal_rp,
            ];
            //Buat Arry Response
            $response = [
                "status" => "Success",
                "message" => "Data Ditemukan",
                "dataset" => $dataset
            ];
        }
    }

    // Output response
    echo json_encode($response);
?>
