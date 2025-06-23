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
            'id_barang_satuan' => "ID Multi Satuan Tidak Boleh Kosong!",
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
        $id_barang_satuan = validateAndSanitizeInput($_POST['id_barang_satuan']);
        $satuan_multi = validateAndSanitizeInput($_POST['satuan_multi']);
        $konversi = validateAndSanitizeInput($_POST['konversi']);
        // Validasi jumlah karakter
        if (strlen($satuan_multi) > 20) {
            $response = [
                "status" => "Error",
                "message" => "Satuan Multi Tidak Boleh Lebih Dari 20 Karakter"
            ];
        } else{

            //Update Ke Database
            $stmt = mysqli_prepare($Conn, "UPDATE barang_satuan SET satuan_multi=?, konversi_multi=? WHERE id_barang_satuan=?");
            mysqli_stmt_bind_param($stmt, "ssi", $satuan_multi, $konversi, $id_barang_satuan);
            $update_result = mysqli_stmt_execute($stmt);
            if ($update_result) {
                $kategori_log="Barang";
                $deskripsi_log="Edit Satuan Multi";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response = [
                        "status" => "Success",
                        "message" => "Edit Satuan Multi Berhasil!"
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
                    "message" => "Terjadi kesalahan pada saat Update ke database"
                ];
            }
        }
    }

    // Output response
    echo json_encode($response);
?>