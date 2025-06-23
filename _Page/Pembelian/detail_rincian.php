<?php
    // Koneksi & Konfigurasi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Time Zone
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // Default Response
    $response = [
        "status" => "Error",
        "message" => "Belum ada proses yang dilakukan pada sistem."
    ];

    // Validasi Sesi Login
    if (empty($SessionIdAkses)) {
        $response = [
            "status" => "Error",
            "message" => "Sesi Akses Sudah Berakhir, Silahkan Login Ulang"
        ];
    } elseif (!isset($_POST['id_transaksi_jual_beli_rincian']) || empty($_POST['id_transaksi_jual_beli_rincian'])) {
        // Validasi ID Transaksi
        $response = [
            "status" => "Error",
            "message" => "ID Rincian Transaksi Tidak Boleh Kosong!"
        ];
    } else {
        // Ambil Data Transaksi
        $id_transaksi_jual_beli_rincian = validateAndSanitizeInput($_POST['id_transaksi_jual_beli_rincian']);
        
        $Qry = $Conn->prepare("SELECT * FROM transaksi_jual_beli_rincian WHERE id_transaksi_jual_beli_rincian = ?");
        $Qry->bind_param("i", $id_transaksi_jual_beli_rincian);
        
        if (!$Qry->execute()) {
            $response = [
                "status" => "Error",
                "message" => $Conn->error
            ];
        } else {
            $Result = $Qry->get_result();
            $Data = $Result->fetch_assoc();
            $Qry->close();

            if (!$Data) {
                $response = [
                    "status" => "Error",
                    "message" => "Data transaksi tidak ditemukan"
                ];
            } else {
                // Ambil Data Transaksi
                $id_transaksi_jual_beli_rincian = $Data['id_transaksi_jual_beli_rincian'];
                $id_barang = $Data['id_barang'];
                $nama_barang = $Data['nama_barang'];
                $satuan = $Data['satuan'];
                $qty = $Data['qty'];
                $harga = $Data['harga'];
                $ppn = $Data['ppn'];
                $diskon = $Data['diskon'];
                $subtotal = $Data['subtotal'];
                //Pembulatan
                $qty = pembulatan_nilai($Data['qty']);
                $harga = pembulatan_nilai($Data['harga']);
                $ppn = pembulatan_nilai($Data['ppn']);
                $diskon = pembulatan_nilai($Data['diskon']);
                $subtotal = pembulatan_nilai($Data['subtotal']);

                // Format Rupiah
                $harga_rp = "Rp " . number_format($harga, 0, ',', '.');
                $subtotal_rp = "Rp " . number_format($subtotal, 0, ',', '.');
                $ppn_rp = "Rp " . number_format($ppn, 0, ',', '.');
                $diskon_rp = "Rp " . number_format($diskon, 0, ',', '.');

                // Data Response
                $dataset = [
                    "id_transaksi_jual_beli_rincian" => $id_transaksi_jual_beli_rincian,
                    "id_barang" => $id_barang,
                    "nama_barang" => $nama_barang,
                    "satuan" => $satuan,
                    "qty" => $qty,
                    "harga" => $harga,
                    "ppn" => $ppn,
                    "diskon" => $diskon,
                    "subtotal" => $subtotal,
                    "subtotal_rp" => $subtotal_rp,
                    "ppn_rp" => $ppn_rp,
                    "diskon_rp" => $diskon_rp,
                    "harga_rp" => $harga_rp,
                ];

                // Response JSON
                $response = [
                    "status" => "Success",
                    "message" => "Data Ditemukan",
                    "dataset" => $dataset
                ];
            }
        }
    }

    // Output JSON Response
    header('Content-Type: application/json');
    echo json_encode($response);
?>
