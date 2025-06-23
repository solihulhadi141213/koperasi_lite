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
            $query = "INSERT INTO barang_kategori_harga (
                kategori_harga, 
                keterangan
            ) VALUES (?, ?)";
            $stmt = $Conn->prepare($query);
            if ($stmt) {
                $stmt->bind_param(
                    "ss",
                    $kategori_harga,
                    $keterangan
                );
                if ($stmt->execute()) {
                    $kategori_log="Barang";
                    $deskripsi_log="Tambah Kategori Harga";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        $response = [
                            "status" => "Success",
                            "message" => "Tambah Kategori Harga Baru Berhasil!"
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
                        "message" => "Terjadi kesalahan pada saat input ke database"
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
