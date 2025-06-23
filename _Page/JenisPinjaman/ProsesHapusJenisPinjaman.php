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
            'id_pinjaman_jenis' => "ID Pinjaman Tidak Boleh Kosong!"
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
        $id_pinjaman_jenis = validateAndSanitizeInput($_POST['id_pinjaman_jenis']);

        //Hapus Data
        $HapusJenisPinjaman= mysqli_query($Conn, "DELETE FROM pinjaman_jenis WHERE id_pinjaman_jenis='$id_pinjaman_jenis'") or die(mysqli_error($Conn));
        if($HapusJenisPinjaman) {
            $kategori_log="Jenis Pinjaman";
            $deskripsi_log="Hapus Jenis Pinjaman";
            $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
            if($InputLog=="Success"){
                $response = [
                    "status" => "Success",
                    "message" => "Hapus Jenis Pinjaman Berhasil!"
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
