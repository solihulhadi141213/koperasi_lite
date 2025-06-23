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
            'id_barang_kategori_harga' => "ID Kategori Harga Tidak Boleh Kosong!",
            'kategori_harga' => "Nama Kategori Harga Tidak Boleh Kosong!",
            'keterangan' => "Setidaknya anda harus menjelaskan sedikit tentang harga tersebut!"
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
        $id_barang_kategori_harga = validateAndSanitizeInput($_POST['id_barang_kategori_harga']);
        $kategori_harga = validateAndSanitizeInput($_POST['kategori_harga']);
        $keterangan = validateAndSanitizeInput($_POST['keterangan']);
        // Validasi jumlah karakter
        if (strlen($kategori_harga) > 30) {
            $response = [
                "status" => "Error",
                "message" => "Kategori Harga Tidak Boleh Lebih Dari 30 Karakter"
            ];
        } elseif (strlen($keterangan) > 250) {
            $response = [
                "status" => "Error",
                "message" => "Keterangan Tidak Boleh Lebih Dari 250 Karakter"
            ];
        } else {

            //Update Ke Database
            $stmt = mysqli_prepare($Conn, "UPDATE barang_kategori_harga SET kategori_harga=?, keterangan=? WHERE id_barang_kategori_harga=?");
            mysqli_stmt_bind_param($stmt, "ssi", $kategori_harga, $keterangan, $id_barang_kategori_harga);
            $update_result = mysqli_stmt_execute($stmt);
            if ($update_result) {
                $kategori_log="Barang";
                $deskripsi_log="Edit Kategori Harga";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response = [
                        "status" => "Success",
                        "message" => "Edit Kategori Harga Berhasil!"
                    ];
                }else{
                    $response = [
                        "status" => "Error",
                        "message" => "Terjadi kesalahan pada saat menyimpan log aktivitas"
                    ];
                }
            } else {
                $response = [
                    "status" => "Error",
                    "message" => "Terjadi kesalahan pada saat mempersiapkan statement database"
                ];
            }
        }
    }

    // Output response
    echo json_encode($response);
?>
