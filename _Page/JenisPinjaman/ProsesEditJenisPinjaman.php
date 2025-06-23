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
            'id_pinjaman_jenis' => "ID Jenis Pinjaman Tidak Boleh Kosong!",
            'nama_pinjaman' => "Nama Pinjaman Tidak Boleh Kosong!",
            'periode_angsuran' => "Periode Angsuran Tidak Boleh Kosong!"
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

        // Validasi dan Sanitasi Data
        $id_pinjaman_jenis = trim($_POST['id_pinjaman_jenis']);
        $nama_pinjaman = trim($_POST['nama_pinjaman']);
        $periode_angsuran = trim($_POST['periode_angsuran']);
        $persen_jasa = isset($_POST['persen_jasa']) ? trim($_POST['persen_jasa']) : 0;

        // Validasi id_pinjaman_jenis harus angka
        if (!ctype_digit($id_pinjaman_jenis)) {
            $response = [
                "status" => "Error",
                "message" => "ID Jenis Pinjaman harus berupa angka!"
            ];
            echo json_encode($response);
            exit;
        }
        $id_pinjaman_jenis = intval($id_pinjaman_jenis);

        // Validasi Panjang nama_pinjaman
        if (strlen($nama_pinjaman) > 250) {
            $response = [
                "status" => "Error",
                "message" => "Nama Pinjaman tidak boleh lebih dari 250 karakter!"
            ];
            echo json_encode($response);
            exit;
        }

        // Validasi periode_angsuran harus angka positif
        if (!ctype_digit($periode_angsuran) || intval($periode_angsuran) <= 0) {
            $response = [
                "status" => "Error",
                "message" => "Periode Angsuran harus berupa angka positif!"
            ];
            echo json_encode($response);
            exit;
        }

        // Validasi persen_jasa antara 0 hingga 100
        if (!is_numeric($persen_jasa) || $persen_jasa < 0 || $persen_jasa > 100) {
            $response = [
                "status" => "Error",
                "message" => "Persen Jasa harus berupa angka antara 0 hingga 100!"
            ];
            echo json_encode($response);
            exit;
        }

        // Konversi tipe data
        $periode_angsuran = intval($periode_angsuran);
        $persen_jasa = floatval($persen_jasa);

        // Persiapan Prepared Statement
        $stmt = mysqli_prepare($Conn, "UPDATE pinjaman_jenis SET nama_pinjaman=?, periode_angsuran=?, persen_jasa=? WHERE id_pinjaman_jenis=?");
        if (!$stmt) {
            $response = [
                "status" => "Error",
                "message" => "Gagal mempersiapkan query: " . mysqli_error($Conn)
            ];
            echo json_encode($response);
            exit;
        }

        // Bind Parameter
        mysqli_stmt_bind_param($stmt, "sidi", $nama_pinjaman, $periode_angsuran, $persen_jasa, $id_pinjaman_jenis);
        $update_result = mysqli_stmt_execute($stmt);

        if ($update_result) {
            $kategori_log = "Jenis Pinjaman";
            $deskripsi_log = "Edit Jenis Pinjaman";
            $InputLog = addLog($Conn, $SessionIdAkses, $now, $kategori_log, $deskripsi_log);

            if ($InputLog == "Success") {
                $response = [
                    "status" => "Success",
                    "message" => "Edit Jenis Pinjaman Berhasil!"
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
                "message" => "Terjadi kesalahan pada saat Update data ke database"
            ];
        }

        // Tutup statement
        $stmt->close();
    }

    // Tutup koneksi
    $Conn->close();

    // Output response
    echo json_encode($response);
?>
