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
            'id_barang_satuan' => "ID Multi Satuan Tidak Boleh Kosong!"
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

        //Hapus Data
        $HapusBarangSatuan= mysqli_query($Conn, "DELETE FROM barang_satuan WHERE id_barang_satuan='$id_barang_satuan'") or die(mysqli_error($Conn));
        if($HapusBarangSatuan) {
            $kategori_log="Barang";
            $deskripsi_log="Hapus Satuan Multi";
            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
            if($InputLog=="Success"){
                $response = [
                    "status" => "Success",
                    "message" => "Hapus Satuan Multi Berhasil!"
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
                "message" => "Terjadi kesalahan pada saat hapus data dari database"
            ];
        }
    }

    // Output response
    echo json_encode($response);
?>
