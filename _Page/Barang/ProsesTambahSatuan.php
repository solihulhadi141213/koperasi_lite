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
            'id_barang' => "ID Barang Tidak Boleh Kosong!",
            'satuan_multi' => "Nama Satuan Tidak Boleh Kosong!",
            'konversi' => "Nilai konversi / isi satuan multi tidak boleh kosong"
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
        $satuan_multi = validateAndSanitizeInput($_POST['satuan_multi']);
        $konversi = validateAndSanitizeInput($_POST['konversi']);
        // Validasi jumlah karakter
        if (strlen($satuan_multi) > 20) {
            $response = [
                "status" => "Error",
                "message" => "Satuan Multi Tidak Boleh Lebih Dari 20 Karakter"
            ];
        } else{

            //Insert Ke Database
            $query = "INSERT INTO barang_satuan (
                id_barang, 
                satuan_multi, 
                konversi_multi
            ) VALUES (?, ?, ?)";
            $stmt = $Conn->prepare($query);
            if ($stmt) {
                $stmt->bind_param(
                    "isi",
                    $id_barang,
                    $satuan_multi,
                    $konversi
                );
                if ($stmt->execute()) {
                    $kategori_log="Barang";
                    $deskripsi_log="Tambah Satuan Multi";
                    $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                    if($InputLog=="Success"){
                        $response = [
                            "status" => "Success",
                            "message" => "Tambah Satuan Multi Berhasil!"
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
