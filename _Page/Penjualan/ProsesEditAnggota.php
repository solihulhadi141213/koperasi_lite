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
            'id_transaksi_jual_beli' => "ID Transaksi Penjualan Tidak Boleh Kosong!",
            'mode' => "Mode Transaksi Penjualan Tidak Boleh Kosong!",
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
        $id_transaksi_jual_beli = validateAndSanitizeInput($_POST['id_transaksi_jual_beli']);
        $mode = validateAndSanitizeInput($_POST['mode']);
        
        // Kondisi jika id_anggota_baru kosong
        if (empty($_POST['id_anggota_baru'])) {
            $id_anggota = "NULL"; // Nilai NULL sebagai string
        } else {
            $id_anggota = "'" . mysqli_real_escape_string($Conn, $_POST['id_anggota_baru']) . "'"; // Escape input untuk keamanan
        }

        // Proses Update Transaksi
        $query = "UPDATE transaksi_jual_beli SET id_anggota = $id_anggota WHERE id_transaksi_jual_beli = '$id_transaksi_jual_beli'";
        $UpdateTransaksi = mysqli_query($Conn, $query) or die(mysqli_error($Conn)); 

        if ($UpdateTransaksi) {
            // Apabila Berhasil Simpan Log
            $kategori_log = "Transaksi Penjualan";
            $deskripsi_log = "Update Transaksi Penjualan";
            $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);
            if ($InputLog == "Success") {
                $response = [
                    "status" => "Success",
                    "message" => "Update Transaksi Berhasil!",
                    "mode" => $mode,
                    "id_transaksi_jual_beli" => $id_transaksi_jual_beli,
                ];
            } else {
                $response = [
                    "status" => "Error",
                    "message" => "Terjadi kesalahan pada saat menyimpan log aktivitas"
                ];
            }
        } else {
            $response = [
                "status" => "Error",
                "message" => "Terjadi kesalahan pada saat update data"
            ];
        }
    }

    // Output response
    echo json_encode($response);
?>